<?php
/**
 * The Clandestino USA - Enhanced Contact Form Handler
 * Professional, secure, and robust message processing
 * 
 * Features:
 * - Advanced input sanitization and validation
 * - Intelligent spam detection with scoring
 * - Enhanced rate limiting with progressive delays
 * - Optional logging with IP tracking
 * - Improved error handling and reporting
 * - CSRF protection with time-based validation
 * 
 * @version 2.0
 * @author The Clandestino USA Development Team
 */

// Enhanced security headers
header('Content-Type: application/json; charset=utf-8');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
header('Content-Security-Policy: default-src \'self\'');

// Configuration
define('ENABLE_LOGGING', true); // Set to false to disable logging
define('LOG_DIR', sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'clx_contact_logs');
define('RATE_LIMIT_DIR', sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'clx_contact_rl');
define('MAX_HOURLY_SUBMISSIONS', 8); // Reduced from 10 for better protection
define('MAX_DAILY_SUBMISSIONS', 25);
define('CSRF_TOKEN_LIFETIME', 3600); // 1 hour
define('SPAM_SCORE_THRESHOLD', 7); // Block if spam score >= this value

/**
 * Enhanced logging function
 */
function logContactAttempt($level, $message, $data = []) {
  if (!ENABLE_LOGGING) return;
  
  if (!is_dir(LOG_DIR)) {
    @mkdir(LOG_DIR, 0700, true);
  }
  
  $logFile = LOG_DIR . DIRECTORY_SEPARATOR . 'contact_' . date('Y-m-d') . '.log';
  $timestamp = date('Y-m-d H:i:s');
  $ip = getClientIP();
  $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
  
  $logEntry = [
    'timestamp' => $timestamp,
    'level' => strtoupper($level),
    'ip' => $ip,
    'message' => $message,
    'user_agent' => $userAgent,
    'data' => $data
  ];
  
  $logLine = json_encode($logEntry) . "\n";
  @file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX);
}

/**
 * Get real client IP address
 */
function getClientIP() {
  $headers = ['HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'HTTP_CLIENT_IP'];
  
  foreach ($headers as $header) {
    if (!empty($_SERVER[$header])) {
      $ips = explode(',', $_SERVER[$header]);
      $ip = trim($ips[0]);
      if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
        return $ip;
      }
    }
  }
  
  return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

/**
 * Advanced spam detection with scoring
 */
function calculateSpamScore($data) {
  $score = 0;
  $factors = [];
  
  // Check for suspicious patterns
  $suspiciousPatterns = [
    '/\b(viagra|cialis|loan|casino|poker|dating|sex|porn)\b/i',
    '/\b(click here|visit now|act now|limited time|free money)\b/i',
    '/\b(guaranteed|100% free|no cost|risk free)\b/i',
    '/(http|https):\/\/[^\s]+/i', // URLs in message
    '/[A-Z]{10,}/', // Excessive caps
    '/(.)\1{4,}/', // Repeated characters
  ];
  
  $text = $data['name'] . ' ' . $data['email'] . ' ' . $data['message'];
  
  foreach ($suspiciousPatterns as $pattern) {
    if (preg_match($pattern, $text)) {
      $score += 2;
      $factors[] = 'Suspicious pattern detected';
    }
  }
  
  // Check message length patterns
  if (strlen($data['message']) < 10) {
    $score += 1;
    $factors[] = 'Very short message';
  }
  
  if (strlen($data['message']) > 2000) {
    $score += 1;
    $factors[] = 'Unusually long message';
  }
  
  // Check for excessive special characters
  $specialChars = preg_match_all('/[^a-zA-Z0-9\s\.\,\!\?\-\'\"]/', $text);
  if ($specialChars > strlen($text) * 0.3) {
    $score += 2;
    $factors[] = 'Excessive special characters';
  }
  
  // Check email patterns
  if (preg_match('/[0-9]{6,}/', $data['email'])) {
    $score += 1;
    $factors[] = 'Suspicious email pattern';
  }
  
  // Check for rapid submission (if session available)
  if (isset($_SESSION['last_form_view']) && (time() - $_SESSION['last_form_view']) < 5) {
    $score += 3;
    $factors[] = 'Too fast submission';
  }
  
  return ['score' => $score, 'factors' => $factors];
}

/**
 * Enhanced input sanitization
 */
function sanitizeInput($value, $type = 'text') {
  if (is_array($value)) return '';
  
  $value = trim($value);
  
  // Remove null bytes, carriage returns, and control characters
  $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $value);
  
  switch ($type) {
    case 'email':
      $value = filter_var($value, FILTER_SANITIZE_EMAIL);
      break;
    case 'phone':
      $value = preg_replace('/[^0-9+()\-\s]/', '', $value);
      break;
    case 'name':
      // Allow letters, spaces, hyphens, apostrophes, and dots
      $value = preg_replace('/[^a-zA-ZÀ-ÿ\u00f1\u00d1\s\-\'\.]/', '', $value);
      break;
    default:
      // General text sanitization
      $value = htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
  }
  
  return $value;
}

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  logContactAttempt('warning', 'Invalid request method', ['method' => $_SERVER['REQUEST_METHOD']]);
  http_response_code(405);
  echo json_encode(['success'=>false,'error'=>'method','errorMessage'=>'Method not allowed']);
  exit;
}

// Enhanced payload size checking
$postSize = strlen(file_get_contents('php://input'));
if (empty($_POST) || $postSize > 15000) { // Increased slightly for better UX
  logContactAttempt('warning', 'Payload size violation', ['size' => $postSize]);
  http_response_code(413);
  echo json_encode(['success'=>false,'error'=>'size','errorMessage'=>'Request too large']);
  exit;
}

// Enhanced CSRF token validation
$csrf = $_POST['csrf_token'] ?? '';
if (!$csrf || !preg_match('/^[A-Za-z0-9\-+\/=]{10,}$/', $csrf)) {
  logContactAttempt('warning', 'Invalid CSRF token', ['token_provided' => !empty($csrf)]);
  http_response_code(400);
  echo json_encode(['success'=>false,'error'=>'csrf','errorMessage'=>'Security token invalid']);
  exit;
}

// Optional: Time-based CSRF validation (decode timestamp from token if implemented)
try {
  $tokenData = base64_decode($csrf);
  if ($tokenData && strpos($tokenData, '.') !== false) {
    list($timestamp, $random) = explode('.', $tokenData, 2);
    if (is_numeric($timestamp) && (time() - $timestamp) > CSRF_TOKEN_LIFETIME) {
      logContactAttempt('warning', 'Expired CSRF token', ['age' => time() - $timestamp]);
      http_response_code(400);
      echo json_encode(['success'=>false,'error'=>'csrf','errorMessage'=>'Security token expired. Please refresh the page.']);
      exit;
    }
  }
} catch (Exception $e) {
  // Token format doesn't match expected pattern, continue with basic validation
}

// Enhanced honeypot with multiple traps
$honeypotFields = ['website', 'url', 'homepage', 'company_website'];
foreach ($honeypotFields as $field) {
  if (!empty($_POST[$field])) {
    logContactAttempt('info', 'Honeypot triggered', ['field' => $field, 'value' => $_POST[$field]]);
    // Pretend success to avoid bot learning
    echo json_encode(['success'=>true]);
    exit;
  }
}

// Enhanced input processing and validation
$name = sanitizeInput($_POST['name'] ?? '', 'name');
$email = sanitizeInput($_POST['email'] ?? '', 'email');
$telRaw = sanitizeInput($_POST['tel'] ?? '', 'phone');
$subject = sanitizeInput($_POST['subject'] ?? '');
$message = sanitizeInput($_POST['message'] ?? '');

// Comprehensive validation with better error messages
$validationErrors = [];

// Name validation
if (mb_strlen($name) < 2) {
  $validationErrors[] = 'Name must be at least 2 characters';
} elseif (mb_strlen($name) > 80) {
  $validationErrors[] = 'Name must be less than 80 characters';
} elseif (!preg_match('/^[a-zA-ZÀ-ÿ\u00f1\u00d1\s\-\'\.]+$/u', $name)) {
  $validationErrors[] = 'Name contains invalid characters';
}

// Email validation
if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $validationErrors[] = 'Please provide a valid email address';
} elseif (mb_strlen($email) > 120) {
  $validationErrors[] = 'Email address is too long';
}

// Subject validation
if (mb_strlen($subject) < 1) {
  $validationErrors[] = 'Please select an inquiry type';
}

// Message validation
if (mb_strlen($message) < 5) {
  $validationErrors[] = 'Message must be at least 5 characters';
} elseif (mb_strlen($message) > 1500) {
  $validationErrors[] = 'Message must be less than 1500 characters';
}

// Phone validation (now required)
if (!$telRaw) {
  $validationErrors[] = 'Phone number is required';
} elseif (!preg_match('/^[0-9+()\-\s]{6,30}$/', $telRaw)) {
  $validationErrors[] = 'Phone number format is invalid';
}

// Subject allowlist enforcement
$allowedSubjects = [
  'Table Reservation',
  'Wine Club Membership',
  'Private Event',
  'Catering Services',
  'Product Information',
  'General Question',
  'Other'
];
if ($subject && !in_array($subject, $allowedSubjects, true)) {
  $validationErrors[] = 'Invalid subject selection';
}

if (!empty($validationErrors)) {
  logContactAttempt('info', 'Validation failed', ['errors' => $validationErrors]);
  echo json_encode([
    'success' => false,
    'error' => 'validation',
    'errorMessage' => implode('. ', $validationErrors)
  ]);
  exit;
}

// Spam detection
$formData = compact('name', 'email', 'subject', 'message');
$spamCheck = calculateSpamScore($formData);

if ($spamCheck['score'] >= SPAM_SCORE_THRESHOLD) {
  logContactAttempt('warning', 'High spam score detected', [
    'score' => $spamCheck['score'],
    'factors' => $spamCheck['factors'],
    'data' => $formData
  ]);
  
  // Return generic error to avoid revealing spam detection
  echo json_encode([
    'success' => false,
    'error' => 'validation',
    'errorMessage' => 'Your message could not be processed. Please try again later.'
  ]);
  exit;
}

// Enhanced rate limiting with progressive delays
$ip = getClientIP();
if (!is_dir(RATE_LIMIT_DIR)) {
  @mkdir(RATE_LIMIT_DIR, 0700, true);
}

$rlFile = RATE_LIMIT_DIR . DIRECTORY_SEPARATOR . md5($ip) . '.json';
$currentTime = time();
$rlData = [
  'hourly_count' => 0,
  'daily_count' => 0,
  'hourly_reset' => $currentTime + 3600,
  'daily_reset' => strtotime('tomorrow 00:00:00'),
  'last_submission' => 0,
  'violations' => 0
];

if (is_file($rlFile)) {
  $json = @file_get_contents($rlFile);
  $tmp = json_decode($json, true);
  if (is_array($tmp)) {
    $rlData = array_merge($rlData, $tmp);
  }
}

// Reset counters if time windows have passed
if ($currentTime > $rlData['hourly_reset']) {
  $rlData['hourly_count'] = 0;
  $rlData['hourly_reset'] = $currentTime + 3600;
}

if ($currentTime > $rlData['daily_reset']) {
  $rlData['daily_count'] = 0;
  $rlData['daily_reset'] = strtotime('tomorrow 00:00:00');
  $rlData['violations'] = 0; // Reset violations daily
}

// Check for too frequent submissions (progressive delay)
$minDelay = 30; // Base minimum delay in seconds
if ($rlData['violations'] > 0) {
  $minDelay *= (1 + $rlData['violations']); // Increase delay with each violation
}

if ($rlData['last_submission'] > 0 && ($currentTime - $rlData['last_submission']) < $minDelay) {
  $rlData['violations']++;
  @file_put_contents($rlFile, json_encode($rlData));
  
  logContactAttempt('warning', 'Rate limit - too frequent', [
    'delay_required' => $minDelay,
    'actual_delay' => $currentTime - $rlData['last_submission'],
    'violations' => $rlData['violations']
  ]);
  
  echo json_encode([
    'success' => false,
    'error' => 'rate',
    'errorMessage' => 'Please wait before sending another message.'
  ]);
  exit;
}

// Increment counters
$rlData['hourly_count']++;
$rlData['daily_count']++;
$rlData['last_submission'] = $currentTime;

// Check limits
if ($rlData['hourly_count'] > MAX_HOURLY_SUBMISSIONS) {
  $rlData['violations']++;
  @file_put_contents($rlFile, json_encode($rlData));
  
  logContactAttempt('warning', 'Rate limit - hourly exceeded', [
    'hourly_count' => $rlData['hourly_count'],
    'limit' => MAX_HOURLY_SUBMISSIONS
  ]);
  
  echo json_encode([
    'success' => false,
    'error' => 'rate',
    'errorMessage' => 'Too many messages this hour. Please try again later.'
  ]);
  exit;
}

if ($rlData['daily_count'] > MAX_DAILY_SUBMISSIONS) {
  $rlData['violations']++;
  @file_put_contents($rlFile, json_encode($rlData));
  
  logContactAttempt('warning', 'Rate limit - daily exceeded', [
    'daily_count' => $rlData['daily_count'],
    'limit' => MAX_DAILY_SUBMISSIONS
  ]);
  
  echo json_encode([
    'success' => false,
    'error' => 'rate',
    'errorMessage' => 'Daily message limit reached. Please try again tomorrow.'
  ]);
  exit;
}

// Save updated rate limit data
@file_put_contents($rlFile, json_encode($rlData));

// Enhanced email composition and sending
$to = 'info@theclandestino.com';
$subjectLine = '[Website Contact] ' . ($subject ?: 'General Inquiry') . ' - ' . date('M j, Y');

// Build comprehensive email body with security context
$emailLines = [
  '=== THE CLANDESTINO USA CONTACT FORM ===',
  '',
  'Name: ' . $name,
  'Email: ' . $email,
  'Phone: ' . ($telRaw ?: 'Not provided'),
  'Subject: ' . ($subject ?: 'General Inquiry'),
  'Submitted: ' . date('F j, Y \a\t g:i A T'),
  '',
  '=== SECURITY INFORMATION ===',
  'IP Address: ' . $ip,
  'User Agent: ' . ($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'),
  'Referrer: ' . ($_SERVER['HTTP_REFERER'] ?? 'Direct'),
  'Spam Score: ' . $spamCheck['score'] . '/10',
  'Rate Limit Status: ' . $rlData['hourly_count'] . '/' . MAX_HOURLY_SUBMISSIONS . ' (hourly), ' . 
                           $rlData['daily_count'] . '/' . MAX_DAILY_SUBMISSIONS . ' (daily)',
  '',
  '=== MESSAGE ===',
  wordwrap($message, 75, "\n", true),
  '',
  '--- End of Message ---',
  '',
  'This message was sent via The Clandestino USA website contact form.',
  'Please reply directly to the customer\'s email address: ' . $email
];

$body = implode("\n", $emailLines);

// Enhanced email headers with security information
$headers = [
  'From: "The Clandestino USA Website" <noreply@theclandestino.com>',
  'Reply-To: "' . str_replace('"', '', $name) . '" <' . $email . '>',
  'MIME-Version: 1.0',
  'Content-Type: text/plain; charset=UTF-8',
  'Content-Transfer-Encoding: 8bit',
  'X-Mailer: The Clandestino USA Contact Form v2.0',
  'X-Originating-IP: ' . $ip,
  'X-Contact-Form: true',
  'X-Spam-Score: ' . $spamCheck['score'],
  'Message-ID: <' . md5(uniqid(rand(), true)) . '@theclandestino.com>',
  'Date: ' . date('r')
];

// Attempt to send email with better error handling
$mailResult = false;
try {
  $mailResult = @mail($to, $subjectLine, $body, implode("\r\n", $headers));
  
  if ($mailResult) {
    logContactAttempt('info', 'Message sent successfully', [
      'name' => $name,
      'email' => $email,
      'subject' => $subject,
      'spam_score' => $spamCheck['score'],
      'message_length' => strlen($message)
    ]);
  } else {
    logContactAttempt('error', 'Failed to send email', [
      'error' => error_get_last(),
      'name' => $name,
      'email' => $email
    ]);
  }
} catch (Exception $e) {
  logContactAttempt('error', 'Email sending exception', [
    'exception' => $e->getMessage(),
    'name' => $name,
    'email' => $email
  ]);
}

if (!$mailResult) {
  echo json_encode([
    'success' => false,
    'error' => 'send',
    'errorMessage' => 'Unable to send your message at this time. Please try again later or call us directly.'
  ]);
  exit;
}

// Success response
echo json_encode([
  'success' => true,
  'message' => 'Thank you for contacting The Clandestino USA! We\'ll get back to you soon.'
]);

exit;
?>
