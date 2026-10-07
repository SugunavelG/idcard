<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit;
}

// Collect and trim inputs
$full_name     = trim($_POST['full_name'] ?? '');
$dob           = trim($_POST['dob'] ?? '');
$address       = trim($_POST['address'] ?? '');
$mobile_no     = trim($_POST['mobile_no'] ?? '');
$alt_mobile    = trim($_POST['alternate_mobile_no'] ?? '');
$gender        = trim($_POST['gender'] ?? '');
$department    = trim($_POST['department'] ?? '');
$batch         = trim($_POST['batch'] ?? '');
$blood_group   = trim($_POST['blood_group'] ?? '');
$cby           = trim($_POST['cby'] ?? '');

$errors = [];

// Server-side validation (mirrors client-side)
if (empty($full_name) || strlen($full_name) < 3) $errors[] = 'Full Name is required (min 3 chars).';
if (empty($dob)) $errors[] = 'Date of Birth is required.';
elseif ($dob > date('Y-m-d')) $errors[] = 'DOB cannot be in the future.';
if (empty($address)) $errors[] = 'Address is required.';
if (empty($mobile_no) || !preg_match('/^[0-9]{10}$/', $mobile_no)) $errors[] = 'Valid 10-digit Mobile Number is required.';
if (!empty($alt_mobile) && !preg_match('/^[0-9]{10}$/', $alt_mobile)) $errors[] = 'Alternate Mobile must be 10 digits.';
if (empty($gender) || !in_array($gender, ['Male','Female','Other'])) $errors[] = 'Please select a valid Gender.';
if (empty($department)) $errors[] = 'Department is required.';
if (empty($batch)) $errors[] = 'Batch is required.';
if (empty($cby)) $errors[] = 'Created By (your name/ID) is required.';

if (!empty($errors)) {
    $_SESSION['id_card_errors'] = $errors;
    $_SESSION['id_card_old'] = $_POST;
    header('Location: dashboard.php#idCardFormSection');
    exit;
}

// --- Generate unique Application Number (format: IDC-YYYY-XXXX) ---
$year = date('Y');
$stmt = $pdo->prepare("SELECT MAX(application_number) as max_num FROM id_card_applications WHERE application_number LIKE ?");
$stmt->execute(["IDC-" . $year . "-%"]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$max_num = $row['max_num'];
$seq = $max_num ? intval(explode('-', $max_num)[2]) + 1 : 1;
$application_number = "IDC-" . $year . "-" . str_pad($seq, 4, '0', STR_PAD_LEFT);

// Insert into database
$sql = "INSERT INTO id_card_applications 
        (application_number, full_name, dob, address, mobile_no, alternate_mobile_no, gender, department, batch, blood_group, cby) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    $application_number, $full_name, $dob, $address, $mobile_no, $alt_mobile,
    $gender, $department, $batch, $blood_group, $cby
]);

$_SESSION['id_card_success'] = "Application submitted! Your Application Number is: $application_number";
header('Location: dashboard.php#idCardFormSection');
exit;
?>