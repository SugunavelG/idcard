<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$errors = [];

if (strlen($username) < 3) $errors[] = 'Username must be at least 3 characters.';
if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';

if (empty($errors)) {
    // Check if username already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        $errors[] = 'Username already taken.';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
        $stmt->execute([$username, $hash]);
        $_SESSION['register_success'] = true;
        header('Location: register.php');
        exit;
    }
}

$_SESSION['register_errors'] = $errors;
header('Location: register.php');
exit;
?>