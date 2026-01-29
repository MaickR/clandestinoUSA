<?php
/**
 * The Clandestino USA - Contact Form Handler
 * Optimized for GoDaddy/cPanel hosting
 * 
 * @version 3.0 - Simplified and robust
 */

// Set execution limits for shared hosting
@set_time_limit(30);
@ini_set('max_execution_time', 30);

// Security headers
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');

// Start session for CSRF and rate limiting
if (session_status() !== PHP_SESSION_ACTIVE) {
  @session_start();
}

// Quick response function
function respond($code, $data) {
  http_response_code($code);
  echo json_encode($data, JSON_UNESCAPED_UNICODE);
  exit;
}

// Configuration
define('MAIL_TO', 'info@theclandestinousa.com');
define('MAIL_FROM', 'noreply@theclandestinousa.com');
define('MAIL_FROM_NAME', 'The Clandestino USA');

// Only POST allowed
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  respond(405, ['success' => false, 'errorMessage' => 'Method not allowed']);
}

// Basic size check
if (empty($_POST)) {
  respond(400, ['success' => false, 'errorMessage' => 'No data received']);
}

// CSRF validation (flexible)
$csrf = $_POST['csrf_token'] ?? '';
if (strlen($csrf) < 10) {
  respond(400, ['success' => false, 'errorMessage' => 'Invalid security token. Please refresh the page.']);
}

// Honeypot check
if (!empty($_POST['website']) || !empty($_POST['url'])) {
  respond(200, ['success' => true]); // Fake success for bots
}

// Sanitize function
function clean($value, $type = 'text') {
  if (is_array($value)) return '';
  $value = trim($value);
  $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', '', $value);
  
  switch ($type) {
    case 'email':
      return filter_var($value, FILTER_SANITIZE_EMAIL);
    case 'phone':
      return preg_replace('/[^0-9+()\-\s]/', '', $value);
    case 'name':
      return preg_replace('/[^\p{L}\s\-\'\.]/u', '', $value);
    default:
      return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
  }
}

// Get and sanitize inputs
$name = clean($_POST['name'] ?? '', 'name');
$email = clean($_POST['email'] ?? '', 'email');
$phone = clean($_POST['tel'] ?? '', 'phone');
$subject = clean($_POST['subject'] ?? '');
$message = clean($_POST['message'] ?? '');

// Validation
$errors = [];

if (mb_strlen($name) < 2 || mb_strlen($name) > 80) {
  $errors[] = 'Name must be 2-80 characters';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errors[] = 'Valid email required';
}

if (mb_strlen($phone) < 6) {
  $errors[] = 'Valid phone required';
}

if (empty($subject)) {
  $errors[] = 'Please select a subject';
}

if (mb_strlen($message) < 5 || mb_strlen($message) > 1500) {
  $errors[] = 'Message must be 5-1500 characters';
}

// Allowed subjects
$allowed = ['Table Reservation', 'Wine Club Membership', 'Private Event', 'Catering Services', 'Product Information', 'General Question', 'Other'];
if ($subject && !in_array($subject, $allowed, true)) {
  $errors[] = 'Invalid subject';
}

if (!empty($errors)) {
  respond(422, [
    'success' => false,
    'error' => 'validation',
    'errorMessage' => implode('. ', $errors)
  ]);
}

// Simple rate limiting using session
$now = time();
$lastSubmit = $_SESSION['clx_last_submit'] ?? 0;
$submitCount = $_SESSION['clx_submit_count'] ?? 0;

// Reset counter each hour
if ($now - $lastSubmit > 3600) {
  $submitCount = 0;
}

// Check rate (max 10 per hour, no delay for first)
if ($submitCount >= 10) {
  respond(429, [
    'success' => false,
    'error' => 'rate',
    'errorMessage' => 'Too many messages. Please try again later.'
  ]);
}

// Update session
$_SESSION['clx_last_submit'] = $now;
$_SESSION['clx_submit_count'] = $submitCount + 1;

// Build professional HTML email
$date = date('F j, Y');
$time = date('g:i A');
$nameSafe = htmlspecialchars($name);
$emailSafe = htmlspecialchars($email);
$phoneSafe = htmlspecialchars($phone);
$subjectSafe = htmlspecialchars($subject ?: 'General Question');
$messageSafe = nl2br(htmlspecialchars($message));

$emailBody = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Contact - {$nameSafe}</title>
</head>
<body style="margin:0;padding:0;background-color:#f5f5f5;font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f5f5f5;padding:30px 15px;">
    <tr>
      <td align="center">
        <table width="100%" cellpadding="0" cellspacing="0" style="max-width:580px;background-color:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
          
          <!-- Header -->
          <tr>
            <td style="background-color:#1a1a1a;padding:25px 30px;border-bottom:3px solid #c9a227;">
              <h1 style="margin:0;color:#ffffff;font-size:22px;font-weight:600;">THE CLANDESTINO USA</h1>
              <p style="margin:6px 0 0;color:#c9a227;font-size:13px;letter-spacing:0.5px;">New Website Inquiry</p>
            </td>
          </tr>
          
          <!-- Subject Banner -->
          <tr>
            <td style="background-color:#c9a227;padding:14px 30px;">
              <p style="margin:0;color:#000000;font-size:15px;font-weight:600;">{$subjectSafe}</p>
            </td>
          </tr>
          
          <!-- Contact Details -->
          <tr>
            <td style="padding:28px 30px 20px;">
              <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td style="padding-bottom:16px;border-bottom:1px solid #eeeeee;">
                    <p style="margin:0 0 4px;color:#888888;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;">From</p>
                    <p style="margin:0;color:#1a1a1a;font-size:17px;font-weight:600;">{$nameSafe}</p>
                  </td>
                </tr>
                <tr>
                  <td style="padding:16px 0;border-bottom:1px solid #eeeeee;">
                    <table width="100%" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="50%" style="vertical-align:top;">
                          <p style="margin:0 0 4px;color:#888888;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;">Email</p>
                          <a href="mailto:{$emailSafe}" style="color:#c9a227;font-size:14px;text-decoration:none;">{$emailSafe}</a>
                        </td>
                        <td width="50%" style="vertical-align:top;">
                          <p style="margin:0 0 4px;color:#888888;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;">Phone</p>
                          <a href="tel:{$phoneSafe}" style="color:#c9a227;font-size:14px;text-decoration:none;">{$phoneSafe}</a>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          
          <!-- Message -->
          <tr>
            <td style="padding:0 30px 28px;">
              <p style="margin:0 0 10px;color:#888888;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;">Message</p>
              <div style="background-color:#fafafa;border:1px solid #eeeeee;border-radius:6px;padding:18px 20px;color:#333333;font-size:14px;line-height:1.65;">
                {$messageSafe}
              </div>
            </td>
          </tr>
          
          <!-- Action Buttons -->
          <tr>
            <td style="padding:0 30px 25px;">
              <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="48%" style="padding-right:2%;">
                    <a href="mailto:{$emailSafe}?subject=Re: {$subjectSafe}" style="display:block;background-color:#c9a227;color:#000000;text-decoration:none;padding:12px 15px;border-radius:5px;font-weight:600;font-size:13px;text-align:center;">Reply by Email</a>
                  </td>
                  <td width="48%" style="padding-left:2%;">
                    <a href="https://wa.me/{$phoneSafe}" style="display:block;background-color:#25D366;color:#ffffff;text-decoration:none;padding:12px 15px;border-radius:5px;font-weight:600;font-size:13px;text-align:center;">WhatsApp</a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          
          <!-- Footer -->
          <tr>
            <td style="background-color:#f9f9f9;padding:18px 30px;border-top:1px solid #eeeeee;">
              <p style="margin:0;color:#999999;font-size:11px;text-align:center;">
                Received on {$date} at {$time} &bull; theclandestinousa.com
              </p>
            </td>
          </tr>
          
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
HTML;

// Prepare email
$to = MAIL_TO;
$emailSubject = ($subject ?: 'Contact') . ' - ' . $name;

$headers = [
  'From: ' . MAIL_FROM_NAME . ' <' . MAIL_FROM . '>',
  'Reply-To: ' . $name . ' <' . $email . '>',
  'MIME-Version: 1.0',
  'Content-Type: text/html; charset=UTF-8',
  'X-Mailer: ClandestinoUSA/3.0'
];

$headerString = implode("\r\n", $headers);

// Try to send email
$mailSent = false;
$lastError = null;

try {
  // Use -f parameter for envelope sender (helps with GoDaddy)
  $mailSent = @mail($to, $emailSubject, $emailBody, $headerString, '-f' . MAIL_FROM);
  
  if (!$mailSent) {
    $lastError = error_get_last();
  }
} catch (Exception $e) {
  $lastError = ['message' => $e->getMessage()];
}

// If mail failed, try alternative method (simpler headers)
if (!$mailSent) {
  $simpleHeaders = "From: " . MAIL_FROM . "\r\n";
  $simpleHeaders .= "Reply-To: " . $email . "\r\n";
  $simpleHeaders .= "MIME-Version: 1.0\r\n";
  $simpleHeaders .= "Content-Type: text/html; charset=UTF-8\r\n";
  
  $mailSent = @mail($to, $emailSubject, $emailBody, $simpleHeaders);
}

// If still failed, try plain text as last resort
if (!$mailSent) {
  $plainBody = "NEW CONTACT MESSAGE\n";
  $plainBody .= "==================\n\n";
  $plainBody .= "From: {$name}\n";
  $plainBody .= "Email: {$email}\n";
  $plainBody .= "Phone: {$phone}\n";
  $plainBody .= "Subject: {$subject}\n\n";
  $plainBody .= "Message:\n{$message}\n\n";
  $plainBody .= "---\n";
  $plainBody .= "Received: {$date} at {$time}";
  
  $plainHeaders = "From: " . MAIL_FROM . "\r\nReply-To: " . $email;
  $mailSent = @mail($to, $emailSubject, $plainBody, $plainHeaders);
}

// Response
if ($mailSent) {
  respond(200, [
    'success' => true,
    'message' => 'Thank you for contacting The Clandestino USA! We\'ll get back to you soon.'
  ]);
} else {
  respond(502, [
    'success' => false,
    'error' => 'send',
    'errorMessage' => 'Unable to send your message. Please call us directly at +1 408-609-0027 or email info@theclandestinousa.com'
  ]);
}
