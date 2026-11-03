<?php
/**
 * The Clandestino USA - Reservation / Events Form Handler (hardened anti-spam)
 * Optimized for GoDaddy/cPanel hosting
 *
 * Receives background POSTs from #clandestino-reservation-form (index.html).
 * The visible flow reports a pending request via JSON; this
 * endpoint submits the request to the configured mail transport (not proof of delivery).
 *
 * Recipients:
 *  - To (primary / preferred public contact): ntcusa@nicolastena.com
 *  - Cc (public secondary):                    info@theclandestinousa.com
 *  - Bcc (internal, NEVER published on site):  msrl.dev420@gmail.com
 *
 * Anti-spam layers: honeypots, time-trap + scoring, header-injection guard,
 * content scoring (links / spam keywords), same-site check, session + IP
 * throttling, and FAKE success responses for bots.
 *
 * @version 1.0
 */

@set_time_limit(30);
@ini_set('max_execution_time', 30);

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: same-origin');

require_once __DIR__ . '/includes/formularios.php';
iniciarSesionFormulario();

function respond($code, $data) {
  http_response_code($code);
  echo json_encode($data, JSON_UNESCAPED_UNICODE);
  exit;
}

/** Fake success for bots so they move on instead of retrying. */
function fakeSuccess() {
  respond(200, [
    'success' => true,
    'message' => 'Reservation request received! We will confirm shortly via WhatsApp.'
  ]);
}

// ---------------------------------------------------------------------------
// Configuration
// ---------------------------------------------------------------------------
define('MAIL_TO_PRIMARY', 'ntcusa@nicolastena.com');
define('MAIL_TO_COPY', 'info@theclandestinousa.com');
define('MAIL_TO_BCC', 'msrl.dev420@gmail.com');
define('MAIL_FROM', 'noreply@theclandestinousa.com');
define('MAIL_FROM_NAME', 'The Clandestino USA — Reservations');

define('SPAM_THRESHOLD', 4);

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
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Allow: POST');
  respond(405, ['success' => false, 'errorMessage' => 'Method not allowed']);
}

if (empty($_POST)) {
  respond(400, ['success' => false, 'errorMessage' => 'No data received']);
}

verificarSolicitudFormulario();

$now = time();
$spamScore = 0;
// Conservar la señal antispam débil cuando el navegador omite ambas cabeceras.
if (!isset($_SERVER['HTTP_ORIGIN']) && !isset($_SERVER['HTTP_REFERER'])) {
    $spamScore += 1;
}

// Honeypots — any filled trap = certain bot
foreach (['website', 'url', 'company'] as $trap) {
  if (!empty($_POST[$trap])) {
    fakeSuccess();
  }
}

// Time-trap
$loadedAt = intval($_POST['form_loaded_at'] ?? 0);
if ($loadedAt <= 0) {
  $spamScore += 2;
} else {
  $elapsed = $now - $loadedAt;
  if ($elapsed < 0 || $elapsed > 3 * 3600) {
    respond(400, ['success' => false, 'errorMessage' => 'Form expired. Please refresh the page and try again.']);
  }
  if ($elapsed < 3) {
    $spamScore += 2;
  }
}

// Same-site check
// El origen ya se verificó junto al token de sesión.

// ---------------------------------------------------------------------------
function hasInjection($value) {
  return is_string($value) && preg_match('/[\r\n]/', $value);
}

foreach (['name', 'email', 'phone', 'guests', 'time', 'date', 'eventType', 'customTitle', 'budget'] as $field) {
  if (isset($_POST[$field]) && hasInjection($_POST[$field])) {
    respond(422, ['success' => false, 'errorMessage' => 'Invalid characters in submission.']);
  }
}

// ---------------------------------------------------------------------------
// Inputs
// ---------------------------------------------------------------------------
$name        = trim($_POST['name'] ?? '');
$email       = trim($_POST['email'] ?? '');
$phone       = trim($_POST['phone'] ?? '');
$guests      = trim($_POST['guests'] ?? '');
$time        = $_POST['time'] ?? '';
$date        = $_POST['date'] ?? '';
$eventType   = trim($_POST['eventType'] ?? '');
$customTitle = trim($_POST['customTitle'] ?? '');
$duration    = trim($_POST['duration'] ?? '');
$winePref    = trim($_POST['winePreference'] ?? '');
$budget      = trim($_POST['budget'] ?? '');
$notes       = trim($_POST['notes'] ?? '');
$accepted    = isset($_POST['accept']);

$dietRaw = $_POST['diet'] ?? [];
if (!is_array($dietRaw)) $dietRaw = [$dietRaw];
$allowedDiets = ['vegetarian', 'vegan', 'gluten-free', 'dairy-free'];
$diets = [];
foreach ($dietRaw as $d) {
  $d = strtolower(trim((string)$d));
  if (in_array($d, $allowedDiets, true) && !in_array($d, $diets, true)) {
    $diets[] = $d;
  }
}

// ---------------------------------------------------------------------------
// Validation
// ---------------------------------------------------------------------------
$errors = [];

if (mb_strlen($name) < 2 || mb_strlen($name) > 80
    || !preg_match('/^[\p{L}\p{M}\s\x{2019}\x{2018}\x{201c}\x{201d}\x{22}\x{27}&.\-]+$/u', $name)) {
  $errors[] = 'Name must be 2-80 characters';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 120) {
  $errors[] = 'Valid email required';
}

if (mb_strlen(preg_replace('/\D/', '', $phone)) < 6 || mb_strlen($phone) > 25 || !preg_match('/^[0-9+()\-\s]+$/D', $phone)) {
  $errors[] = 'Valid phone required';
}

$allowedGuests = ['1','2','3','4','5','6','7','8','9','10','15','20','25','30'];
if (!in_array($guests, $allowedGuests, true)) {
  $errors[] = 'Please select the number of guests';
}

$allowedTimes = ['16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30'];
if (!in_array($time, $allowedTimes, true)) {
  $errors[] = 'Please select a valid time';
}

$allowedTypes = ['standard','romantic','birthday','anniversary','family','holiday','tasting','corporate','custom'];
if (!in_array($eventType, $allowedTypes, true)) {
  $errors[] = 'Please select a valid event type';
}

$fechaReserva = fechaSolicitudReserva($date, $time);
if ($fechaReserva === null) {
  $errors[] = 'Please select a valid date';
}

if ($eventType === 'custom' && mb_strlen($customTitle) < 2) {
  $errors[] = 'Custom events need a short title';
}

if (mb_strlen($customTitle) > 120 || mb_strlen($budget) > 60 || mb_strlen($notes) > 1000) {
  $errors[] = 'One of the fields is too long';
}

if (!$accepted) {
  $errors[] = 'Please accept the terms & policies';
}

if (!empty($errors)) {
  respond(422, [
    'success' => false,
    'error' => 'validation',
    'errorMessage' => implode('. ', $errors)
  ]);
}

// ---------------------------------------------------------------------------
// Content scoring
// ---------------------------------------------------------------------------
$haystack = mb_strtolower($name . ' ' . $customTitle . ' ' . $budget . ' ' . $notes, 'UTF-8');

$linkCount = preg_match_all('#https?://|www\.#i', $notes . ' ' . $customTitle . ' ' . $budget, $m);
if ($linkCount >= 2) {
  $spamScore += 3;
} elseif ($linkCount === 1 && mb_strlen(trim($notes)) < 60) {
  $spamScore += 2;
}

foreach ($SPAM_KEYWORDS as $kw) {
  if (mb_strpos($haystack, $kw) !== false) {
    $spamScore += 3;
    break;
  }
}

if (preg_match('/(.)\\1{5,}/u', $notes)) {
  $spamScore += 1;
}

if ($spamScore >= SPAM_THRESHOLD) {
  fakeSuccess();
}

// ---------------------------------------------------------------------------
// Rate limiting (session 10/hour + per-IP file throttle 4/15min, 20s gap)
// ---------------------------------------------------------------------------
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$rlFile = sys_get_temp_dir() . '/clx_res_rl_' . md5('clandestino-usa|' . $ip) . '.json';
$rl = ['window' => $now, 'count' => 0, 'last' => 0];
if (is_readable($rlFile)) {
  $decoded = json_decode(@file_get_contents($rlFile), true);
  if (is_array($decoded)) {
    $rl = array_merge($rl, $decoded);
  }
}
if ($now - (int)$rl['window'] > 900) {
  $rl = ['window' => $now, 'count' => 0, 'last' => (int)$rl['last']];
}
if ((int)$rl['count'] >= 4) {
  respond(429, [
    'success' => false,
    'error' => 'rate',
    'errorMessage' => 'Too many requests from this connection. Please try again later or call us at +1 408-609-0027.'
  ]);
}
if ($now - (int)$rl['last'] < 20 && (int)$rl['last'] > 0) {
  respond(429, [
    'success' => false,
    'error' => 'rate',
    'errorMessage' => 'Please wait a few seconds before sending another request.'
  ]);
}
$rl['count']++;
$rl['last'] = $now;
@file_put_contents($rlFile, json_encode($rl), LOCK_EX);

$lastSubmit = $_SESSION['clx_res_last'] ?? 0;
$submitCount = $_SESSION['clx_res_count'] ?? 0;
if ($now - $lastSubmit > 3600) {
  $submitCount = 0;
}
if ($submitCount >= 10) {
  respond(429, [
    'success' => false,
    'error' => 'rate',
    'errorMessage' => 'Too many requests. Please try again later.'
  ]);
}
$_SESSION['clx_res_last'] = $now;
$_SESSION['clx_res_count'] = $submitCount + 1;

// ---------------------------------------------------------------------------
// Build email
// ---------------------------------------------------------------------------
$eventLabels = [
  'standard' => 'Standard Dining', 'romantic' => 'Romantic Dinner / Proposal',
  'birthday' => 'Birthday Celebration', 'anniversary' => 'Anniversary',
  'family' => 'Family Gathering', 'holiday' => 'Holiday / Seasonal Celebration',
  'tasting' => 'Wine Tasting Experience', 'corporate' => 'Corporate Meeting / Team Dinner',
  'custom' => 'Custom / Personalized Event',
];
$eventLabel = $eventLabels[$eventType] ?? $eventType;

$dateFmt = $fechaReserva->format('l, F j, Y');
$dateSafe = escaparCorreo($dateFmt);
$timeSafe = escaparCorreo($fechaReserva->format('g:i A'));
$guestsSafe = escaparCorreo($guests);
$customSafe = $customTitle !== '' ? escaparCorreo($customTitle) : '—';
$durationSafe = $duration !== '' ? escaparCorreo($duration) . ' h' : '—';
$wineSafe = $winePref !== '' ? escaparCorreo(ucfirst($winePref)) : '—';
$dietSafe = !empty($diets) ? escaparCorreo(implode(', ', $diets)) : 'None';
$budgetSafe = $budget !== '' ? escaparCorreo($budget) : '—';
$notesSafe = $notes !== '' ? nl2br(escaparCorreo($notes)) : '—';
$nameSafe = escaparCorreo($name);
$emailSafe = escaparCorreo($email);
$phoneSafe = escaparCorreo($phone);
$phoneDigits = escaparCorreo(preg_replace('/[^0-9]/', '', $phone));
$received = (new DateTimeImmutable('now', new DateTimeZone('America/Los_Angeles')))->format('F j, Y \a\t g:i A T');

$emailSubject = "Reservation Request — {$name} — {$date} {$time} ({$guests} guests)";

$emailBody = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>New Reservation - {$nameSafe}</title></head>
<body style="margin:0;padding:0;background-color:#f5f5f5;font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f5f5f5;padding:30px 15px;">
    <tr><td align="center">
      <table width="100%" cellpadding="0" cellspacing="0" style="max-width:580px;background-color:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
        <tr>
          <td style="background-color:#1a1a1a;padding:25px 30px;border-bottom:3px solid #c9a227;">
            <h1 style="margin:0;color:#ffffff;font-size:22px;font-weight:600;">THE CLANDESTINO USA</h1>
            <p style="margin:6px 0 0;color:#c9a227;font-size:13px;letter-spacing:0.5px;">New Reservation / Event Request</p>
          </td>
        </tr>
        <tr>
          <td style="background-color:#c9a227;padding:14px 30px;">
            <p style="margin:0;color:#000000;font-size:15px;font-weight:600;">{$dateSafe} &bull; {$timeSafe} &bull; {$guestsSafe} guest(s)</p>
          </td>
        </tr>
        <tr><td style="padding:24px 30px 8px;">
          <table width="100%" cellpadding="6" cellspacing="0" style="font-size:14px;color:#333333;">
            <tr><td width="40%" style="color:#888888;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;">Name</td><td><strong>{$nameSafe}</strong></td></tr>
            <tr><td style="color:#888888;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;">Email</td><td><a href="mailto:{$emailSafe}" style="color:#8a6d1b;text-decoration:none;">{$emailSafe}</a></td></tr>
            <tr><td style="color:#888888;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;">Phone</td><td><a href="tel:+{$phoneDigits}" style="color:#8a6d1b;text-decoration:none;">{$phoneSafe}</a></td></tr>
            <tr><td style="color:#888888;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;">Event type</td><td>{$eventLabel}</td></tr>
            <tr><td style="color:#888888;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;">Custom title</td><td>{$customSafe}</td></tr>
            <tr><td style="color:#888888;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;">Duration</td><td>{$durationSafe}</td></tr>
            <tr><td style="color:#888888;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;">Wine preference</td><td>{$wineSafe}</td></tr>
            <tr><td style="color:#888888;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;">Dietary</td><td>{$dietSafe}</td></tr>
            <tr><td style="color:#888888;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;">Budget</td><td>{$budgetSafe}</td></tr>
          </table>
        </td></tr>
        <tr><td style="padding:8px 30px 20px;">
          <p style="margin:0 0 10px;color:#888888;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;">Notes / special requests</p>
          <div style="background-color:#fafafa;border:1px solid #eeeeee;border-radius:6px;padding:18px 20px;color:#333333;font-size:14px;line-height:1.65;">{$notesSafe}</div>
        </td></tr>
        <tr><td style="padding:0 30px 25px;">
          <a href="https://wa.me/{$phoneDigits}" style="display:block;background-color:#25D366;color:#ffffff;text-decoration:none;padding:12px 15px;border-radius:5px;font-weight:600;font-size:13px;text-align:center;">Confirm via WhatsApp</a>
        </td></tr>
        <tr><td style="background-color:#f9f9f9;padding:18px 30px;border-top:1px solid #eeeeee;">
          <p style="margin:0;color:#999999;font-size:11px;text-align:center;">Received on {$received} &bull; theclandestinousa.com</p>
        </td></tr>
      </table>
    </td></tr>
  </table>
</body>
</html>
HTML;

// ---------------------------------------------------------------------------

$emailSubject = 'Reservation - ' . $name . ' - ' . $date . ' ' . $time;
$replyTo = $email;
$plainBody = "NEW RESERVATION REQUEST\n========================\n\n";
$plainBody .= "Name: {$name}\nEmail: {$email}\nPhone: {$phone}\nDate: {$date}\nTime: {$time}\n";
$plainBody .= "Guests: {$guests}\nEvent: {$eventLabel}\nCustom title: {$customTitle}\n";
$plainBody .= "Duration: {$duration}\nWine: {$winePref}\nDietary: " . implode(', ', $diets) . "\n";
$plainBody .= "Budget: {$budget}\nNotes: {$notes}\n\nReceived: {$received}";

if (enviarNotificacionesFormulario('reservation', $emailSubject, $emailBody, $plainBody, $replyTo)) {
  respond(200, [
    'success' => true,
    'message' => 'Your reservation request was accepted for processing. We will confirm by email or phone.'
  ]);
}

respond(502, [
  'success' => false,
  'error' => 'send',
  'errorMessage' => 'We could not send your request. Please call +1 408-609-0027 or email ntcusa@nicolastena.com.'
]);
