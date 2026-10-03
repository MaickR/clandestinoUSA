<?php
/**
 * The Clandestino USA - Contact Form Handler (hardened anti-spam)
 * Optimized for GoDaddy/cPanel hosting
 *
 * Recipients:
 *  - To (primary / preferred public contact): ntcusa@nicolastena.com
 *  - Cc (public secondary):                    info@theclandestinousa.com
 *  - Bcc (internal, NEVER published on site):  msrl.dev420@gmail.com
 *
 * Anti-spam layers (server side, authoritative):
 *  1. Multiple honeypot fields (bots fill them, humans never see them)
 *  2. Time-trap (form_loaded_at): rejects instant/bot-speed submissions via scoring
 *  3. Header-injection guard (rejects \r \n in name/email/subject/phone)
 *  4. Disposable / temporary email domain blocklist (scoring)
 *  5. Content scoring: links, spam keywords, repeated chars, ALL CAPS
 *  6. Origin / Referer same-site check (scoring)
 *  7. Rate limiting: session (10/hour) + per-IP file throttle (4 / 15 min, min 20s gap)
 *  8. Bots receive a FAKE success response so they move on instead of retrying
 *
 * @version 4.0 - multi-recipient + hardened
 */

// Set execution limits for shared hosting
@set_time_limit(30);
@ini_set('max_execution_time', 30);

// Security headers
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: same-origin');

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

/**
 * Fake success for bots: looks like a real delivery so automated
 * spammers do not retry or adapt. NEVER reveals that we detected them.
 */
function fakeSuccess() {
  respond(200, [
    'success' => true,
    'message' => 'Thank you for contacting The Clandestino USA! We\'ll get back to you soon.'
  ]);
}

// ---------------------------------------------------------------------------
// Configuration
// ---------------------------------------------------------------------------
define('MAIL_TO_PRIMARY', 'ntcusa@nicolastena.com');   // preferred public contact
define('MAIL_TO_COPY', 'info@theclandestinousa.com');  // public secondary
define('MAIL_TO_BCC', 'msrl.dev420@gmail.com');        // internal only, never public
define('MAIL_FROM', 'noreply@theclandestinousa.com');
define('MAIL_FROM_NAME', 'The Clandestino USA');

// Spam score threshold: >= this value = treated as bot (fake success)
define('SPAM_THRESHOLD', 4);

// Disposable / temporary email domains (bots love these)
$DISPOSABLE_DOMAINS = [
  'mailinator.com', 'mailinator.net', 'tempmail.com', 'temp-mail.org',
  'guerrillamail.com', 'guerrillamail.net', '10minutemail.com', '10minutemail.net',
  'yopmail.com', 'yopmail.net', 'trashmail.com', 'trashmail.net', 'dispostable.com',
  'throwawaymail.com', 'fakeinbox.com', 'getnada.com', 'mohmal.com', 'tempail.com',
  'emailondeck.com', 'sharklasers.com', 'grr.la', 'mintemail.com', 'mytrashmail.com',
  'spamgourmet.com', 'maildrop.cc', 'harakirimail.com', 'cryptogmail.com',
];

// Classic form-spam keywords (pharma / casino / seo / money schemes / adult)
$SPAM_KEYWORDS = [
  'viagra', 'cialis', 'levitra', 'phentermine', 'tramadol', 'oxycodone',
  'casino', 'poker', 'blackjack', 'lottery', 'jackpot', 'betting', 'sportsbook',
  'forex', 'binary option', 'crypto doubler', 'bitcoin doubler', 'investment opportunity',
  'backlink', 'link building', 'domain authority', 'page rank', 'pagerank',
  'seo service', 'seo expert', 'rank #1', 'rank no.1', 'first page of google',
  'website traffic', 'buy traffic', 'cheap traffic', 'social followers', 'buy followers',
  'instagram followers', 'youtube views', 'make money fast', 'work from home',
  'weight loss', 'lose weight fast', 'payday loan', 'quick loan', 'debt relief',
  'porn', 'xxx', 'escort', 'sexdoll', 'hack', 'hacker for hire', 'spy app',
  'replica watch', 'replica bag', 'canada pharmacy', 'online pharmacy',
];

// ---------------------------------------------------------------------------
// Only POST allowed
// ---------------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  respond(405, ['success' => false, 'errorMessage' => 'Method not allowed']);
}

// Basic size check
if (empty($_POST)) {
  respond(400, ['success' => false, 'errorMessage' => 'No data received']);
}

$now = time();
$spamScore = 0;

// ---------------------------------------------------------------------------
// Honeypot check (multiple traps — humans never see these fields)
// Any filled trap = certain bot -> fake success, no further processing.
// ---------------------------------------------------------------------------
foreach (['website', 'url', 'company'] as $trap) {
  if (!empty($_POST[$trap])) {
    fakeSuccess();
  }
}

// ---------------------------------------------------------------------------
// Time-trap: form_loaded_at is set by JS when the page loads.
// Bots submit instantly (< 3s) or forge/omit the stamp.
// NOTE: a single weak signal never blocks alone (autofill users are fast);
// it only adds score combined with other signals.
// ---------------------------------------------------------------------------
$loadedAt = intval($_POST['form_loaded_at'] ?? 0);
if ($loadedAt <= 0) {
  $spamScore += 2; // no JS stamp: bot or forged request
} else {
  $elapsed = $now - $loadedAt;
  if ($elapsed < 0 || $elapsed > 3 * 3600) {
    respond(400, ['success' => false, 'errorMessage' => 'Form expired. Please refresh the page and try again.']);
  }
  if ($elapsed < 3) {
    $spamScore += 2; // inhuman speed
  }
}

// ---------------------------------------------------------------------------
// Same-site check: legitimate fetch() requests carry our Origin/Referer.
// ---------------------------------------------------------------------------
$host = strtolower($_SERVER['HTTP_HOST'] ?? '');
$originHost = strtolower(parse_url($_SERVER['HTTP_ORIGIN'] ?? '', PHP_URL_HOST) ?: '');
$refererHost = strtolower(parse_url($_SERVER['HTTP_REFERER'] ?? '', PHP_URL_HOST) ?: '');
if (($originHost !== '' && $originHost !== $host) || ($refererHost !== '' && $refererHost !== $host)) {
  $spamScore += 2; // cross-site forgery attempt
} elseif ($originHost === '' && $refererHost === '') {
  $spamScore += 1; // missing entirely: slightly suspicious (browsers always send it)
}

// ---------------------------------------------------------------------------
// Sanitizers
// ---------------------------------------------------------------------------
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

/** Header-injection guard: CR/LF characters are never legitimate here. */
function hasInjection($value) {
  return is_string($value) && preg_match('/[\r\n]/', $value);
}

foreach (['name', 'email', 'tel', 'subject'] as $field) {
  if (isset($_POST[$field]) && hasInjection($_POST[$field])) {
    respond(422, ['success' => false, 'errorMessage' => 'Invalid characters in submission.']);
  }
}

// Get and sanitize inputs
$name = clean($_POST['name'] ?? '', 'name');
$email = clean($_POST['email'] ?? '', 'email');
$phone = clean($_POST['tel'] ?? '', 'phone');
$subject = clean($_POST['subject'] ?? '');
$message = clean($_POST['message'] ?? '');

// ---------------------------------------------------------------------------
// Validation (honest errors for real users)
// ---------------------------------------------------------------------------
$errors = [];

if (mb_strlen($name) < 2 || mb_strlen($name) > 80) {
  $errors[] = 'Name must be 2-80 characters';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 120) {
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

// ---------------------------------------------------------------------------
// Content scoring (spam / promo bots)
// ---------------------------------------------------------------------------

// Disposable email domains
$emailDomain = strtolower(substr(strrchr($email, '@'), 1) ?: '');
if ($emailDomain !== '' && in_array($emailDomain, $DISPOSABLE_DOMAINS, true)) {
  $spamScore += 2;
}

// Links in the message: real guests rarely paste links; spammers always do
$linkCount = preg_match_all('#https?://|www\.#i', $message, $m);
if ($linkCount >= 2) {
  $spamScore += 3;
} elseif ($linkCount === 1 && mb_strlen($message) < 60) {
  $spamScore += 2; // short message whose only purpose is a link
}

// Spam keywords (name + subject + message)
$haystack = mb_strtolower($name . ' ' . $subject . ' ' . $message, 'UTF-8');
foreach ($SPAM_KEYWORDS as $kw) {
  if (mb_strpos($haystack, $kw) !== false) {
    $spamScore += 3;
    break;
  }
}

// Obvious bot gibberish: 6+ repeated characters, or ALL CAPS shouting
if (preg_match('/(.)\\1{5,}/u', $message)) {
  $spamScore += 1;
}
if (mb_strlen($message) > 20 && mb_strtoupper($message, 'UTF-8') === $message && preg_match('/[A-Z]{10,}/', $message)) {
  $spamScore += 1;
}

// Verdict: suspected bot -> fake success (they think it was delivered)
if ($spamScore >= SPAM_THRESHOLD) {
  fakeSuccess();
}

// ---------------------------------------------------------------------------
// Rate limiting
// ---------------------------------------------------------------------------

// Layer 1: per-IP file throttle (survives session resets; bots rotate sessions, not IPs)
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$rlFile = sys_get_temp_dir() . '/clx_rl_' . md5('clandestino-usa|' . $ip) . '.json';
$rl = ['window' => $now, 'count' => 0, 'last' => 0];
if (is_readable($rlFile)) {
  $decoded = json_decode(@file_get_contents($rlFile), true);
  if (is_array($decoded)) {
    $rl = array_merge($rl, $decoded);
  }
}
if ($now - (int)$rl['window'] > 900) { // 15-minute window
  $rl = ['window' => $now, 'count' => 0, 'last' => (int)$rl['last']];
}
if ((int)$rl['count'] >= 4) {
  respond(429, [
    'success' => false,
    'error' => 'rate',
    'errorMessage' => 'Too many messages from this connection. Please try again later or call us at +1 408-609-0027.'
  ]);
}
if ($now - (int)$rl['last'] < 20 && (int)$rl['last'] > 0) {
  respond(429, [
    'success' => false,
    'error' => 'rate',
    'errorMessage' => 'Please wait a few seconds before sending another message.'
  ]);
}
$rl['count']++;
$rl['last'] = $now;
@file_put_contents($rlFile, json_encode($rl), LOCK_EX);

// Layer 2: session throttle (max 10 per hour)
$lastSubmit = $_SESSION['clx_last_submit'] ?? 0;
$submitCount = $_SESSION['clx_submit_count'] ?? 0;
if ($now - $lastSubmit > 3600) {
  $submitCount = 0;
}
if ($submitCount >= 10) {
  respond(429, [
    'success' => false,
    'error' => 'rate',
    'errorMessage' => 'Too many messages. Please try again later.'
  ]);
}
$_SESSION['clx_last_submit'] = $now;
$_SESSION['clx_submit_count'] = $submitCount + 1;

// ---------------------------------------------------------------------------
// Build professional HTML email
// ---------------------------------------------------------------------------
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

// ---------------------------------------------------------------------------
// One message per inbox. Cc/Bcc is dropped by some hosts, so each
// address gets its own delivery. Success only when all three accept it.
// ---------------------------------------------------------------------------
function deliver_all($subject, $html, $plain, $replyTo) {
  $subject = str_replace(["\r", "\n"], ' ', $subject);
  $replyTo = str_replace(["\r", "\n"], '', $replyTo);
  $recipients = [MAIL_TO_PRIMARY, MAIL_TO_COPY, MAIL_TO_BCC];

  foreach ($recipients as $addr) {
    $headers = implode("\r\n", [
      'From: ' . MAIL_FROM_NAME . ' <' . MAIL_FROM . '>',
      'Reply-To: ' . $replyTo,
      'MIME-Version: 1.0',
      'Content-Type: text/html; charset=UTF-8',
      'X-Mailer: ClandestinoUSA/4.1'
    ]);
    $sent = @mail($addr, $subject, $html, $headers, '-f' . MAIL_FROM);
    if (!$sent) {
      $plainHeaders = 'From: ' . MAIL_FROM . "\r\nReply-To: " . $replyTo . "\r\nContent-Type: text/plain; charset=UTF-8";
      $sent = @mail($addr, $subject, $plain, $plainHeaders);
    }
    if (!$sent) {
      return false;
    }
  }
  return true;
}

$emailSubject = ($subject ?: 'Contact') . ' - ' . $name;
$replyTo = $name . ' <' . $email . '>';
$plainBody = "NEW CONTACT MESSAGE\n==================\n\nFrom: {$name}\nEmail: {$email}\nPhone: {$phone}\nSubject: {$subject}\n\nMessage:\n{$message}\n\nReceived: {$date} at {$time}";

if (deliver_all($emailSubject, $emailBody, $plainBody, $replyTo)) {
  respond(200, [
    'success' => true,
    'message' => 'Thank you for contacting The Clandestino USA. We will get back to you soon.'
  ]);
}

respond(502, [
  'success' => false,
  'error' => 'send',
  'errorMessage' => 'We could not send your message. Please call +1 408-609-0027 or email ntcusa@nicolastena.com.'
]);
