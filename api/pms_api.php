<?php
/**
 * Payroll Management System — API v3
 * Upload to: Hostinger public_html/pms_api.php
 */

// ═══════════════════════════════════════════════════════════
//  CONFIG — fill in SMTP_PASS before uploading
// ═══════════════════════════════════════════════════════════
define('DB_HOST',     getenv('DB_HOST')     ?: 'localhost');
define('DB_NAME',     getenv('DB_NAME')     ?: 'u843401270_Payroll');
define('DB_USER',     getenv('DB_USER')     ?: 'u843401270_payroll_user');
define('DB_PASS',     getenv('DB_PASS')     ?: 'YOUR_DATABASE_PASSWORD');
define('API_TOKEN',   getenv('API_TOKEN')   ?: 'YOUR_SECURE_API_TOKEN');
define('FROM_EMAIL',  getenv('FROM_EMAIL')  ?: 'hr@naelmedia.ae');
define('FROM_NAME',   getenv('FROM_NAME')   ?: 'Nael Media HR');
define('SMTP_HOST',   getenv('SMTP_HOST')   ?: 'smtp.office365.com');
define('SMTP_PORT',   getenv('SMTP_PORT')   ?: 587);
define('SMTP_USER',   getenv('SMTP_USER')   ?: 'hr@naelmedia.ae');
define('SMTP_PASS',   getenv('SMTP_PASS')   ?: 'YOUR_SMTP_PASSWORD');
define('OTP_EXPIRY',  600);    // 10 minutes
define('SESS_EXPIRY', 43200);  // 12 hours
// ═══════════════════════════════════════════════════════════

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-PMS-Token');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit; }

// ── DB connect ───────────────────────────────────────────────────
try {
    $pdo = new PDO(
        'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT=>10]
    );
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error'=>'DB error: '.$e->getMessage()]);
    exit;
}

// ── Helpers ──────────────────────────────────────────────────────
function respond($code, $data){
    http_response_code($code);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function dbGet($pdo, $key){
    $s = $pdo->prepare("SELECT store_val FROM pms_store WHERE store_key=?");
    $s->execute([$key]);
    $r = $s->fetch(PDO::FETCH_ASSOC);
    return $r ? json_decode($r['store_val'], true) : null;
}

function dbSet($pdo, $key, $value){
    $s = $pdo->prepare("INSERT INTO pms_store (store_key,store_val) VALUES(?,?)
        ON DUPLICATE KEY UPDATE store_val=VALUES(store_val),updated_at=CURRENT_TIMESTAMP");
    $s->execute([$key, json_encode($value, JSON_UNESCAPED_UNICODE)]);
}

function isAdmin(){
    $t = $_SERVER['HTTP_X_PMS_TOKEN'] ?? ($_GET['token'] ?? '');
    return $t === API_TOKEN;
}

function getSession($pdo){
    $t = $_SERVER['HTTP_X_PMS_TOKEN'] ?? ($_GET['token'] ?? '');
    if (!$t) return null;
    $sess = dbGet($pdo, 'emp_sess_'.hash('sha256', $t));
    if (!$sess || $sess['expiry'] < time()) return null;
    return $sess;
}

function findEmpByEmail($pdo, $email){
    $emps  = dbGet($pdo, 'pms_employees') ?? [];
    $email = strtolower(trim($email));
    foreach ($emps as $e) {
        if (strtolower(trim($e['Email'] ?? '')) === $email) return $e;
    }
    return null;
}

// ── SMTP mailer (Microsoft 365 / Office 365) ─────────────────────
function smtpSend($to, $subject, $body){
    $host = SMTP_HOST;
    $port = SMTP_PORT;
    $user = SMTP_USER;
    $pass = SMTP_PASS;
    $from = FROM_EMAIL;
    $name = FROM_NAME;
    $log  = [];

    // Connect plain on port 587
    $socket = fsockopen($host, $port, $errno, $errstr, 15);
    if (!$socket) return ['ok'=>false, 'step'=>'connect', 'error'=>"$errno: $errstr"];
    stream_set_timeout($socket, 15);

    $read = function() use ($socket, &$log) {
        $line = fgets($socket, 512);
        $log[] = "< ".trim($line);
        return $line;
    };
    $send = function($cmd) use ($socket, &$log) {
        $logCmd = (strpos($cmd, base64_encode(SMTP_PASS)) !== false) ? "AUTH_PASS [hidden]" : $cmd;
        $log[] = "> ".$logCmd;
        fputs($socket, $cmd."\r\n");
    };

    $log[] = "Connecting to $host:$port";
    $read(); // greeting 220

    $send("EHLO naeladvertising.ae");
    while ($line = fgets($socket, 512)) { $log[]="< ".trim($line); if (substr($line,3,1)===' ') break; }

    // STARTTLS
    $send("STARTTLS");
    $r = $read();
    if (substr(trim($r),0,3) !== '220') {
        fclose($socket);
        return ['ok'=>false,'step'=>'starttls','error'=>trim($r),'log'=>$log];
    }
    stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
    $log[] = "TLS enabled";

    $send("EHLO naeladvertising.ae");
    while ($line = fgets($socket, 512)) { $log[]="< ".trim($line); if (substr($line,3,1)===' ') break; }

    // Auth
    $send("AUTH LOGIN");
    $read();
    $send(base64_encode($user));
    $read();
    $send(base64_encode($pass));
    $resp = $read();
    if (substr(trim($resp),0,3) !== '235') {
        fclose($socket);
        return ['ok'=>false,'step'=>'auth','error'=>trim($resp),'log'=>$log];
    }

    // Envelope
    $send("MAIL FROM:<{$from}>");
    $r1 = $read();
    $send("RCPT TO:<{$to}>");
    $r2 = $read();
    $send("DATA");
    $read();

    // Message
    $msg  = "From: {$name} <{$from}>\r\n";
    $msg .= "To: {$to}\r\n";
    $msg .= "Subject: {$subject}\r\n";
    $msg .= "MIME-Version: 1.0\r\n";
    $msg .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $msg .= "\r\n";
    $msg .= $body."\r\n.\r\n";
    fputs($socket, $msg);
    $r3 = $read();

    $send("QUIT");
    fclose($socket);

    return ['ok'=>true,'step'=>'sent','mail_from_resp'=>trim($r1),'rcpt_resp'=>trim($r2),'data_resp'=>trim($r3),'log'=>$log];
}

function sendOtp($to, $otp, $name){
    $subject = 'Nael Advertising — Your Login Code';
    $message = "Hello {$name},\r\n\r\nYour one-time login code is:\r\n\r\n    {$otp}\r\n\r\nThis code expires in 10 minutes.\r\nDo not share it with anyone.\r\n\r\n— Nael Advertising HR";
    return smtpSend($to, $subject, $message);
}

// ── Route ────────────────────────────────────────────────────────
$action = $_GET['action'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];
$key    = preg_replace('/[^a-z0-9_]/', '', strtolower($_GET['key'] ?? ''));
$body   = ($method === 'POST') ? file_get_contents('php://input') : '';

// ════════════════════════════════════════════════════════════════
//  SETUP — create table (run once)
// ════════════════════════════════════════════════════════════════
if ($action === 'setup') {
    if (!isAdmin()) respond(403, ['error'=>'Unauthorized']);
    $pdo->exec("CREATE TABLE IF NOT EXISTS pms_store (
        store_key  VARCHAR(200) PRIMARY KEY,
        store_val  LONGTEXT NOT NULL,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    respond(200, ['ok'=>true, 'message'=>'Table ready.']);
}

// ════════════════════════════════════════════════════════════════
//  ADMIN: read / write key-value store
// ════════════════════════════════════════════════════════════════
if ($action === '' || $action === 'store') {
    if (!isAdmin()) respond(403, ['error'=>'Unauthorized']);
    if ($method === 'GET' && $key) {
        $s = $pdo->prepare("SELECT store_val FROM pms_store WHERE store_key=?");
        $s->execute([$key]);
        $r = $s->fetch(PDO::FETCH_ASSOC);
        echo $r ? $r['store_val'] : 'null';
        exit;
    }
    if ($method === 'GET' && !$key) {
        $rows = $pdo->query("SELECT store_key,updated_at FROM pms_store ORDER BY updated_at DESC")->fetchAll(PDO::FETCH_ASSOC);
        respond(200, ['ok'=>true, 'keys'=>$rows]);
    }
    if ($method === 'POST' && $key) {
        json_decode($body);
        if (json_last_error() !== JSON_ERROR_NONE) respond(400, ['error'=>'Invalid JSON']);
        $s = $pdo->prepare("INSERT INTO pms_store (store_key,store_val) VALUES(?,?)
            ON DUPLICATE KEY UPDATE store_val=VALUES(store_val),updated_at=CURRENT_TIMESTAMP");
        $s->execute([$key, $body]);
        respond(200, ['ok'=>true, 'key'=>$key, 'bytes'=>strlen($body)]);
    }
    respond(400, ['error'=>'Bad request']);
}

// ════════════════════════════════════════════════════════════════
//  EMPLOYEE: request OTP
// ════════════════════════════════════════════════════════════════
if ($action === 'request_otp' && $method === 'POST') {
    $data  = json_decode($body, true);
    $email = strtolower(trim($data['email'] ?? ''));
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL))
        respond(400, ['error'=>'Invalid email']);

    $emp = findEmpByEmail($pdo, $email);
    if (!$emp) respond(404, ['error'=>'Email not found. Contact HR.']);

    $otp    = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    $otpKey = 'otp_'.hash('sha256', $email);

    dbSet($pdo, $otpKey, [
        'otp'    => password_hash($otp, PASSWORD_DEFAULT),
        'email'  => $email,
        'empId'  => $emp['ID'],
        'expiry' => time() + OTP_EXPIRY,
        'used'   => false
    ]);

    dbSet($pdo, 'otp_plain_'.hash('sha256', $email), [
        'otp'    => $otp,
        'expiry' => time() + OTP_EXPIRY
    ]);

    $sent = sendOtp($email, $otp, $emp['Name']);
    respond(200, ['ok'=>true, 'sent'=>$sent, 'name'=>$emp['Name']]);
}

// ════════════════════════════════════════════════════════════════
//  ADMIN: debug — retrieve current OTP for an email
// ════════════════════════════════════════════════════════════════
if ($action === 'test_smtp' && $method === 'GET') {
    if (!isAdmin()) respond(403, ['error'=>'Unauthorized']);
    $to = trim($_GET['to'] ?? FROM_EMAIL);
    $result = smtpSend($to, 'SMTP Test — Nael HR Portal', 'This is a test email from pms_api.php. If you see this, SMTP is working correctly.');
    respond(200, ['ok'=>$result['ok'], 'smtp_user'=>SMTP_USER, 'from'=>FROM_EMAIL, 'to'=>$to, 'result'=>$result]);
}

if ($action === 'debug_otp' && $method === 'GET') {
    if (!isAdmin()) respond(403, ['error'=>'Unauthorized']);
    $email = strtolower(trim($_GET['email'] ?? ''));
    if (!$email) respond(400, ['error'=>'email param required']);
    $plain = dbGet($pdo, 'otp_plain_'.hash('sha256', $email));
    if (!$plain || $plain['expiry'] < time()) respond(404, ['error'=>'No active OTP']);
    respond(200, ['ok'=>true, 'otp'=>$plain['otp'], 'expires_in'=>$plain['expiry']-time()]);
}

// ════════════════════════════════════════════════════════════════
//  EMPLOYEE: verify OTP → session token
// ════════════════════════════════════════════════════════════════
if ($action === 'verify_otp' && $method === 'POST') {
    $data  = json_decode($body, true);
    $email = strtolower(trim($data['email'] ?? ''));
    $otp   = trim($data['otp'] ?? '');
    if (!$email || !$otp) respond(400, ['error'=>'Email and OTP required']);

    $otpKey = 'otp_'.hash('sha256', $email);
    $stored = dbGet($pdo, $otpKey);
    if (!$stored)                    respond(401, ['error'=>'No OTP found. Request again.']);
    if ($stored['used'])             respond(401, ['error'=>'OTP already used. Request a new one.']);
    if ($stored['expiry'] < time())  respond(401, ['error'=>'OTP expired. Request a new one.']);
    if (!password_verify($otp, $stored['otp'])) respond(401, ['error'=>'Wrong OTP. Try again.']);

    $stored['used'] = true;
    dbSet($pdo, $otpKey, $stored);

    $token   = bin2hex(random_bytes(32));
    $sessKey = 'emp_sess_'.hash('sha256', $token);
    $emp     = findEmpByEmail($pdo, $email);

    dbSet($pdo, $sessKey, [
        'empId'    => $emp['ID'],
        'empEmail' => $email,
        'empName'  => $emp['Name'],
        'expiry'   => time() + SESS_EXPIRY
    ]);

    $pwdRecord = dbGet($pdo, 'emp_pwd_'.hash('sha256', strtolower($emp['ID'])));
    $needsPassword = empty($pwdRecord['hash']);

    respond(200, ['ok'=>true, 'token'=>$token, 'empId'=>$emp['ID'], 'empName'=>$emp['Name'], 'needsPassword'=>$needsPassword]);
}

// ════════════════════════════════════════════════════════════════
//  EMPLOYEE: login with password
// ════════════════════════════════════════════════════════════════
if ($action === 'login_password' && $method === 'POST') {
    $data  = json_decode($body, true);
    $email = strtolower(trim($data['email']    ?? ''));
    $pwd   = trim($data['password'] ?? '');
    if (!$email || !$pwd) respond(400, ['ok'=>false, 'error'=>'Email and password required']);

    $emp = findEmpByEmail($pdo, $email);
    if (!$emp) respond(401, ['ok'=>false, 'error'=>'Incorrect email or password']);

    $pwdRecord = dbGet($pdo, 'emp_pwd_'.hash('sha256', strtolower($emp['ID'])));
    if (empty($pwdRecord['hash']))
        respond(401, ['ok'=>false, 'error'=>'No password set yet. Please use Email Code to sign in and set a password.']);

    if (!password_verify($pwd, $pwdRecord['hash']))
        respond(401, ['ok'=>false, 'error'=>'Incorrect email or password']);

    $token   = bin2hex(random_bytes(32));
    $sessKey = 'emp_sess_'.hash('sha256', $token);
    dbSet($pdo, $sessKey, [
        'empId'    => $emp['ID'],
        'empEmail' => $email,
        'empName'  => $emp['Name'],
        'expiry'   => time() + SESS_EXPIRY
    ]);
    respond(200, ['ok'=>true, 'token'=>$token, 'empId'=>$emp['ID'], 'empName'=>$emp['Name']]);
}

// ════════════════════════════════════════════════════════════════
//  EMPLOYEE: set password
// ════════════════════════════════════════════════════════════════
if ($action === 'set_password' && $method === 'POST') {
    $sess = getSession($pdo);
    if (!$sess) respond(401, ['ok'=>false, 'error'=>'Session expired. Please login again.']);

    $data = json_decode($body, true);
    $pwd  = $data['password'] ?? '';
    if (strlen($pwd) < 6) respond(400, ['ok'=>false, 'error'=>'Password must be at least 6 characters']);

    $pwdKey = 'emp_pwd_'.hash('sha256', strtolower($sess['empId']));
    dbSet($pdo, $pwdKey, ['hash' => password_hash($pwd, PASSWORD_BCRYPT), 'empId' => $sess['empId']]);
    respond(200, ['ok'=>true]);
}

// ════════════════════════════════════════════════════════════════
//  EMPLOYEE: reset password via OTP
// ════════════════════════════════════════════════════════════════
if ($action === 'reset_password' && $method === 'POST') {
    $data  = json_decode($body, true);
    $email = strtolower(trim($data['email']    ?? ''));
    $otp   = trim($data['otp']      ?? '');
    $pwd   = $data['password'] ?? '';

    if (!$email || !$otp || !$pwd) respond(400, ['ok'=>false, 'error'=>'All fields required']);
    if (strlen($pwd) < 6) respond(400, ['ok'=>false, 'error'=>'Password must be at least 6 characters']);

    $otpKey = 'otp_'.hash('sha256', $email);
    $stored = dbGet($pdo, $otpKey);
    if (!$stored)                   respond(401, ['ok'=>false, 'error'=>'No OTP found. Request again.']);
    if ($stored['used'])            respond(401, ['ok'=>false, 'error'=>'OTP already used. Request a new one.']);
    if ($stored['expiry'] < time()) respond(401, ['ok'=>false, 'error'=>'OTP expired. Request a new one.']);
    if (!password_verify($otp, $stored['otp'])) respond(401, ['ok'=>false, 'error'=>'Wrong OTP. Try again.']);

    $stored['used'] = true;
    dbSet($pdo, $otpKey, $stored);

    $emp = findEmpByEmail($pdo, $email);
    if (!$emp) respond(404, ['ok'=>false, 'error'=>'Email not found']);

    $pwdKey = 'emp_pwd_'.hash('sha256', strtolower($emp['ID']));
    dbSet($pdo, $pwdKey, ['hash' => password_hash($pwd, PASSWORD_BCRYPT), 'empId' => $emp['ID']]);

    $token   = bin2hex(random_bytes(32));
    $sessKey = 'emp_sess_'.hash('sha256', $token);
    dbSet($pdo, $sessKey, [
        'empId'    => $emp['ID'],
        'empEmail' => $email,
        'empName'  => $emp['Name'],
        'expiry'   => time() + SESS_EXPIRY
    ]);
    respond(200, ['ok'=>true, 'token'=>$token, 'empId'=>$emp['ID'], 'empName'=>$emp['Name']]);
}

// ════════════════════════════════════════════════════════════════
//  EMPLOYEE: get own data
// ════════════════════════════════════════════════════════════════
if ($action === 'my_data' && $method === 'GET') {
    $sess = getSession($pdo);
    if (!$sess) respond(401, ['error'=>'Session expired. Please login again.']);

    $empId      = $sess['empId'];
    $employees  = dbGet($pdo, 'pms_employees')  ?? [];
    $attendance = dbGet($pdo, 'pms_attendance') ?? [];
    $advances   = dbGet($pdo, 'pms_advances')   ?? [];
    $deals      = dbGet($pdo, 'pms_deals')      ?? [];
    $splits     = dbGet($pdo, 'pms_splits')     ?? [];
    $reimbs     = dbGet($pdo, 'pms_reimbs')     ?? [];
    $deductions = dbGet($pdo, 'pms_deductions') ?? [];
    $exceptions = dbGet($pdo, 'pms_exceptions') ?? [];

    $emp = null;
    foreach ($employees as $e) { if ($e['ID'] == $empId) { $emp = $e; break; } }
    if (!$emp) respond(404, ['error'=>'Employee not found']);

    $myAdv    = array_values(array_filter($advances,   fn($a) => $a['EmployeeID'] == $empId));
    $myReimbs = array_values(array_filter($reimbs,     fn($r) => $r['EmployeeID'] == $empId));
    $myDeds   = array_values(array_filter($deductions, fn($d) => $d['EmployeeID'] == $empId));
    $myExcs   = array_values(array_filter($exceptions, fn($x) => $x['EmployeeID'] == $empId));

    $splitsByDeal = [];
    foreach ($splits as $s) { $splitsByDeal[$s['DealID']][] = $s; }

    $myDeals = array_values(array_filter($deals, function($d) use ($empId, $splitsByDeal) {
        if ($d['PrimaryEmpID'] == $empId) return true;
        foreach ($splitsByDeal[$d['DealID']] ?? [] as $s) {
            if ($s['EmployeeID'] == $empId) return true;
        }
        return false;
    }));

    respond(200, [
        'ok'             => true,
        'employee'       => [
            'ID'         => $emp['ID'],
            'Name'       => $emp['Name'],
            'Department' => $emp['Department'] ?? '',
            'Role'       => $emp['Role']       ?? '',
            'Salary'     => $emp['Salary']     ?? 0,
            'Shift'      => $emp['Shift']      ?? 'default',
        ],
        'attendance'     => $attendance[$empId] ?? [],
        'advances'       => $myAdv,
        'reimbursements' => $myReimbs,
        'deductions'     => $myDeds,
        'exceptions'     => $myExcs,
        'deals'          => $myDeals,
        'splits'         => $splits,
    ]);
}

// ════════════════════════════════════════════════════════════════
//  EMPLOYEE: remark & disputes
// ════════════════════════════════════════════════════════════════
if ($action === 'update_remark_emp' && $method === 'POST') {
    $sess = getSession($pdo);
    if (!$sess) respond(401, ['error'=>'Session expired.']);

    $data     = json_decode($body, true);
    $id       = trim($data['id']       ?? '');
    $date     = trim($data['date']     ?? '');
    $text     = trim($data['remark']   ?? '');
    $fileData = $data['fileData']      ?? '';

    if (!$id || !$date || !$text) respond(400, ['ok'=>false,'error'=>'Missing required fields']);
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) respond(400, ['ok'=>false,'error'=>'Invalid date']);
    if (strlen($text) > 1000) respond(400, ['ok'=>false,'error'=>'Too long (max 1000 chars)']);

    $remarks = dbGet($pdo, 'pms_remarks') ?? [];
    $idx = null;
    foreach ($remarks as $i => $r) {
        if ($r['id'] === $id && $r['empId'] == $sess['empId']) { $idx = $i; break; }
    }
    if ($idx === null) respond(404, ['ok'=>false,'error'=>'Remark not found']);
    if (!in_array($remarks[$idx]['status'], ['pending','opened']))
        respond(400, ['ok'=>false,'error'=>'This remark is already being processed and cannot be edited']);

    $fileUrl = $remarks[$idx]['fileUrl'] ?? '';
    if ($fileData) {
        if (!preg_match('#^data:([\w/+.\-]+);base64,(.+)$#s', $fileData, $m))
            respond(400, ['ok'=>false,'error'=>'Invalid file format']);
        $mime = strtolower($m[1]);
        $raw  = base64_decode($m[2], true);
        if ($raw === false) respond(400, ['ok'=>false,'error'=>'Could not read the file']);
        if (strlen($raw) > 5 * 1024 * 1024) respond(400, ['ok'=>false,'error'=>'File too large (max 5 MB)']);
        $extMap = [
            'image/jpeg'=>'jpg','image/jpg'=>'jpg','image/png'=>'png',
            'image/webp'=>'webp','image/heic'=>'heic','image/gif'=>'gif',
            'application/pdf'=>'pdf',
            'application/msword'=>'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'=>'docx',
        ];
        if (!isset($extMap[$mime]))
            respond(400, ['ok'=>false,'error'=>'File must be an image, PDF, or Word document']);
        $dir = __DIR__ . '/pms_remarks_files';
        if (!is_dir($dir)) @mkdir($dir, 0755, true);
        $fname = 'rmk_' . date('Ymd') . '_' . bin2hex(random_bytes(6)) . '.' . $extMap[$mime];
        if (file_put_contents($dir . '/' . $fname, $raw) === false)
            respond(500, ['ok'=>false,'error'=>'Could not save file on server']);
        $scheme  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host    = $_SERVER['HTTP_HOST'] ?? 'naeladvertising.ae';
        $fileUrl = $scheme . '://' . $host . '/pms_remarks_files/' . $fname;
    }

    $remarks[$idx]['date']    = $date;
    $remarks[$idx]['remark']  = $text;
    $remarks[$idx]['fileUrl'] = $fileUrl;
    if ($remarks[$idx]['status'] === 'opened') $remarks[$idx]['status'] = 'pending';

    dbSet($pdo, 'pms_remarks', $remarks);
    respond(200, ['ok'=>true, 'message'=>'Remark updated.']);
}

if ($action === 'submit_remark' && $method === 'POST') {
    $sess = getSession($pdo);
    if (!$sess) respond(401, ['error'=>'Session expired.']);

    $data     = json_decode($body, true);
    $date     = trim($data['date']     ?? '');
    $text     = trim($data['remark']   ?? '');
    $fileData = $data['fileData']      ?? '';

    if (!$date || !$text) respond(400, ['error'=>'Date and remark required']);
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) respond(400, ['error'=>'Invalid date']);
    if (strlen($text) > 1000) respond(400, ['error'=>'Too long (max 1000 chars)']);

    $fileUrl = '';
    if ($fileData) {
        if (!preg_match('#^data:([\w/+.\-]+);base64,(.+)$#s', $fileData, $m))
            respond(400, ['ok'=>false, 'error'=>'Invalid file format']);
        $mime = strtolower($m[1]);
        $raw  = base64_decode($m[2], true);
        if ($raw === false) respond(400, ['ok'=>false, 'error'=>'Could not read the file']);
        if (strlen($raw) > 5 * 1024 * 1024) respond(400, ['ok'=>false, 'error'=>'File too large (max 5 MB)']);
        $extMap = [
            'image/jpeg'=>'jpg','image/jpg'=>'jpg','image/png'=>'png',
            'image/webp'=>'webp','image/heic'=>'heic','image/gif'=>'gif',
            'application/pdf'=>'pdf',
            'application/msword'=>'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'=>'docx',
        ];
        if (!isset($extMap[$mime]))
            respond(400, ['ok'=>false, 'error'=>'File must be an image, PDF, or Word document']);
        $dir = __DIR__ . '/pms_remarks_files';
        if (!is_dir($dir)) @mkdir($dir, 0755, true);
        $fname = 'rmk_' . date('Ymd') . '_' . bin2hex(random_bytes(6)) . '.' . $extMap[$mime];
        if (file_put_contents($dir . '/' . $fname, $raw) === false)
            respond(500, ['ok'=>false, 'error'=>'Could not save the file on the server']);
        $scheme  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host    = $_SERVER['HTTP_HOST'] ?? 'naeladvertising.ae';
        $fileUrl = $scheme . '://' . $host . '/pms_remarks_files/' . $fname;
    }

    $remarks   = dbGet($pdo, 'pms_remarks') ?? [];
    $remarks[] = [
        'id'          => uniqid('rmk_'),
        'empId'       => $sess['empId'],
        'empName'     => $sess['empName'],
        'empEmail'    => $sess['empEmail'],
        'date'        => $date,
        'remark'      => $text,
        'fileUrl'     => $fileUrl,
        'status'      => 'pending',
        'submittedAt' => date('Y-m-d H:i:s'),
        'reviewedAt'  => null,
        'adminNote'   => null,
    ];
    dbSet($pdo, 'pms_remarks', $remarks);
    respond(200, ['ok'=>true, 'message'=>'Submitted. HR will review soon.']);
}

if ($action === 'my_remarks' && $method === 'GET') {
    $sess = getSession($pdo);
    if (!$sess) respond(401, ['error'=>'Session expired.']);
    $all  = dbGet($pdo, 'pms_remarks') ?? [];
    $mine = array_values(array_filter($all, fn($r) => $r['empId'] == $sess['empId']));
    respond(200, ['ok'=>true, 'remarks'=>$mine]);
}

if ($action === 'get_remarks' && $method === 'GET') {
    if (!isAdmin()) respond(403, ['error'=>'Unauthorized']);
    $all     = dbGet($pdo, 'pms_remarks') ?? [];
    $pending = count(array_filter($all, fn($r) => !in_array($r['status'], ['approved','refused'])));
    respond(200, ['ok'=>true, 'remarks'=>array_values($all), 'pending_count'=>$pending]);
}

if ($action === 'update_remark' && $method === 'POST') {
    if (!isAdmin()) respond(403, ['error'=>'Unauthorized']);
    $data   = json_decode($body, true);
    $id     = $data['id']        ?? '';
    $status = $data['status']    ?? '';
    $note   = $data['adminNote'] ?? '';
    if (!$id || !in_array($status, ['opened','processing','approved','refused']))
        respond(400, ['error'=>'Invalid params']);

    $all = dbGet($pdo, 'pms_remarks') ?? [];
    foreach ($all as &$r) {
        if ($r['id'] === $id) {
            $r['status']     = $status;
            $r['reviewedAt'] = date('Y-m-d H:i:s');
            $r['adminNote']  = $note;
            break;
        }
    }
    dbSet($pdo, 'pms_remarks', $all);
    respond(200, ['ok'=>true]);
}

// ── SATURDAY AVAILABILITY ─────────────────────────────────────────
if ($action === 'submit_saturday' && $method === 'POST') {
    $sess = getSession($pdo);
    if (!$sess) respond(401, ['ok'=>false, 'error'=>'Session expired. Please login again.']);

    $empId   = $sess['empId'];
    $empName = $sess['empName'];

    $tz  = new DateTimeZone('Asia/Dubai');
    $now = new DateTime('now', $tz);
    $dayOfWeek = (int)$now->format('N');

    if ($dayOfWeek !== 6) {
        respond(400, ['ok'=>false, 'error'=>'Availability can only be submitted on Saturdays.']);
    }

    $dateStr          = $now->format('Y-m-d');
    $submittedAt      = $now->format('Y-m-d H:i:s');
    $timeStr          = $now->format('H:i');

    if ($timeStr < '09:00') {
        respond(400, ['ok'=>false, 'error'=>'Too early. The availability window opens at 9:00 AM.']);
    }
    if ($timeStr >= '11:00') {
        respond(400, ['ok'=>false, 'error'=>'Deadline passed. Availability must be submitted between 9:00 AM and 11:00 AM.']);
    }

    $all = dbGet($pdo, 'pms_saturday') ?? [];

    foreach ($all as $rec) {
        if ($rec['empId'] == $empId && $rec['date'] === $dateStr) {
            respond(200, [
                'ok'              => true,
                'alreadySubmitted'=> true,
                'submittedAt'     => $rec['submittedAt'],
            ]);
        }
    }

    $newRec = [
        'id'              => uniqid('sat_', true),
        'empId'           => $empId,
        'empName'         => $empName,
        'date'            => $dateStr,
        'submittedAt'     => $submittedAt,
        'isBeforeDeadline'=> true,
    ];
    $all[] = $newRec;
    dbSet($pdo, 'pms_saturday', $all);

    respond(200, [
        'ok'          => true,
        'alreadySubmitted' => false,
        'submittedAt' => $submittedAt,
    ]);
}

if ($action === 'get_saturday' && $method === 'GET') {
    if (!isAdmin()) respond(401, ['ok'=>false, 'error'=>'Unauthorized']);

    $date = $_GET['date'] ?? date('Y-m-d');
    $all  = dbGet($pdo, 'pms_saturday') ?? [];

    $filtered = array_values(array_filter($all, fn($r) => $r['date'] === $date));
    $dates = array_unique(array_column($all, 'date'));
    rsort($dates);

    respond(200, ['ok'=>true, 'records'=>$filtered, 'availableDates'=>array_values($dates)]);
}

if ($action === 'my_saturday' && $method === 'GET') {
    $sess = getSession($pdo);
    if (!$sess) respond(401, ['ok'=>false, 'error'=>'Session expired']);

    $empId = $sess['empId'];
    $all   = dbGet($pdo, 'pms_saturday') ?? [];
    $mine  = array_values(array_filter($all, fn($r) => $r['empId'] == $empId));
    usort($mine, fn($a,$b) => strcmp($b['date'], $a['date']));

    respond(200, ['ok'=>true, 'records'=>$mine]);
}

// ── REIMBURSEMENTS ────────────────────────────────────────────────
if ($action === 'submit_reimbursement' && $method === 'POST') {
    $sess = getSession($pdo);
    if (!$sess) respond(401, ['ok'=>false, 'error'=>'Session expired. Please login again.']);

    $data        = json_decode($body, true);
    $date        = trim($data['date']        ?? '');
    $category    = trim($data['category']    ?? '');
    $amount      = $data['amount']           ?? '';
    $description = trim($data['description'] ?? '');
    $receiptData = $data['receiptData']      ?? '';

    $allowedCats = ['fuel','parking','supplies','meals','transport','maintenance','other'];
    if (!$date || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date))
        respond(400, ['ok'=>false, 'error'=>'A valid date (YYYY-MM-DD) is required']);
    if (!in_array($category, $allowedCats, true))
        respond(400, ['ok'=>false, 'error'=>'Invalid category']);
    $amount = (float)$amount;
    if ($amount <= 0)
        respond(400, ['ok'=>false, 'error'=>'Amount must be greater than 0']);
    if (strlen($description) > 500)
        respond(400, ['ok'=>false, 'error'=>'Description too long (max 500 characters)']);

    $receiptUrl = '';
    if ($receiptData) {
        if (!preg_match('#^data:([\w/+.\-]+);base64,(.+)$#s', $receiptData, $m))
            respond(400, ['ok'=>false, 'error'=>'Invalid receipt format']);
        $mime = strtolower($m[1]);
        $raw  = base64_decode($m[2], true);
        if ($raw === false)
            respond(400, ['ok'=>false, 'error'=>'Could not read the receipt']);
        if (strlen($raw) > 5 * 1024 * 1024)
            respond(400, ['ok'=>false, 'error'=>'Receipt too large (max 5 MB)']);
        $extMap = [
            'image/jpeg'=>'jpg', 'image/jpg'=>'jpg', 'image/png'=>'png',
            'image/webp'=>'webp', 'image/heic'=>'heic', 'image/gif'=>'gif',
            'application/pdf'=>'pdf'
        ];
        if (!isset($extMap[$mime]))
            respond(400, ['ok'=>false, 'error'=>'Receipt must be an image or a PDF']);
        $dir = __DIR__ . '/pms_receipts';
        if (!is_dir($dir)) @mkdir($dir, 0755, true);
        $safeName     = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $sess['empName']);
        $safeCategory = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $category);
        $fname = $safeName . '_' . $date . '_' . $safeCategory . '.' . $extMap[$mime];
        if (file_put_contents($dir . '/' . $fname, $raw) === false)
            respond(500, ['ok'=>false, 'error'=>'Could not save the receipt on the server']);
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host   = $_SERVER['HTTP_HOST'] ?? 'naeladvertising.ae';
        $receiptUrl = $scheme . '://' . $host . '/pms_receipts/' . $fname;
    }

    $reimbs = dbGet($pdo, 'pms_reimbs') ?? [];
    $maxId = 0;
    foreach ($reimbs as $r) { $n = (int)($r['ReimbID'] ?? 0); if ($n > $maxId) $maxId = $n; }
    $newRec = [
        'ReimbID'      => (string)($maxId + 1),
        'EmployeeID'   => $sess['empId'],
        'EmployeeName' => $sess['empName'],
        'Date'         => $date,
        'Category'     => $category,
        'Amount'       => number_format($amount, 2, '.', ''),
        'Description'  => $description,
        'Receipt'      => $receiptUrl,
        'Status'       => 'pending',
        'Notes'        => 'Submitted by employee',
    ];
    $reimbs[] = $newRec;
    dbSet($pdo, 'pms_reimbs', $reimbs);

    respond(200, ['ok'=>true, 'reimbursement'=>$newRec]);
}

// ── DOWNLOAD RECEIPTS ZIP ─────────────────────────────────────────
if ($action === 'download_receipts' && $method === 'GET') {
    $token = urldecode($_SERVER['HTTP_X_PMS_TOKEN'] ?? ($_GET['_tok'] ?? ''));
    if ($token !== API_TOKEN) respond(401, ['ok'=>false,'error'=>'Unauthorized']);

    $empId = trim($_GET['empId'] ?? '');
    $month = trim($_GET['month'] ?? '');
    $year  = intval($_GET['year']  ?? date('Y'));

    if (!$empId || !$month) respond(400, ['ok'=>false,'error'=>'empId and month required']);

    $monthNums = ['January'=>1,'February'=>2,'March'=>3,'April'=>4,'May'=>5,'June'=>6,
                  'July'=>7,'August'=>8,'September'=>9,'October'=>10,'November'=>11,'December'=>12];
    $mn = $monthNums[$month] ?? 0;
    if (!$mn) respond(400, ['ok'=>false,'error'=>'Invalid month']);

    $reimbs = dbGet($pdo, 'pms_reimbs') ?? [];
    $toZip  = [];
    foreach ($reimbs as $r) {
        if (strval($r['EmployeeID'] ?? '') !== strval($empId)) continue;
        if (empty($r['Receipt'])) continue;
        try {
            $d = new DateTime($r['Date'] ?? '');
            if ((int)$d->format('n') !== $mn || (int)$d->format('Y') !== $year) continue;
        } catch (Exception $e) { continue; }
        $path = __DIR__ . '/pms_receipts/' . basename(parse_url($r['Receipt'], PHP_URL_PATH));
        if (!file_exists($path)) continue;
        $toZip[] = ['path'=>$path, 'record'=>$r];
    }

    if (empty($toZip)) respond(404, ['ok'=>false,'error'=>'No receipt files found on server for this employee and month.']);

    $empName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $toZip[0]['record']['EmployeeName'] ?? 'Employee');
    $dlName  = 'Receipts_' . $empName . '_' . $month . '_' . $year . '.zip';

    function zipEntry(string $filename, string $data): array {
        $crc      = crc32($data);
        $size     = strlen($data);
        $dosTime  = 0x4A21;
        $dosDate  = 0x0000;
        $local    = pack('VvvvVVVvv', 0x04034b50, 20, 0, 8, $dosTime | ($dosDate<<16), $crc, $size, $size, strlen($filename), 0)
                  . $filename . $data;
        $central  = pack('VvvvvVVVvvvvvVV', 0x02014b50, 20, 20, 0, 8, $dosTime | ($dosDate<<16), $crc, $size, $size, strlen($filename), 0, 0, 0, 0, 0x20, 0)
                  . $filename;
        return ['local'=>$local, 'central'=>$central, 'size'=>$size, 'crc'=>$crc, 'name'=>$filename];
    }

    $localData   = '';
    $centralData = '';
    $offsets     = [];
    $count       = 0;

    foreach ($toZip as $item) {
        $r       = $item['record'];
        $content = file_get_contents($item['path']);
        if ($content === false) continue;
        $ext     = pathinfo($item['path'], PATHINFO_EXTENSION);
        $safe    = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $r['EmployeeName'] ?? 'Employee');
        $fname   = $safe . '_' . ($r['Date'] ?? 'unknown') . '_' . ($r['Category'] ?? 'receipt') . '.' . $ext;
        $entry   = zipEntry($fname, $content);
        $offsets[]   = strlen($localData);
        $localData  .= $entry['local'];
        $centralData.= $entry['central'];
        $count++;
    }

    if ($count === 0) respond(404, ['ok'=>false,'error'=>'Could not read any receipt files from server']);

    $cdOffset = strlen($localData);
    $cdSize   = strlen($centralData);
    $eocd     = pack('VvvvvVVv', 0x06054b50, 0, 0, $count, $count, $cdSize, $cdOffset, 0);
    $zip      = $localData . $centralData . $eocd;

    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . $dlName . '"');
    header('Content-Length: ' . strlen($zip));
    header('Cache-Control: no-cache, no-store');
    header('Pragma: no-cache');
    echo $zip;
    exit;
}

respond(400, ['error'=>'Unknown action: '.$action]);
