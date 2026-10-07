<?php
session_start();
require_once 'config.php';

$errors = $_SESSION['register_errors'] ?? [];
unset($_SESSION['register_errors']);
$success = $_SESSION['register_success'] ?? false;
unset($_SESSION['register_success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; min-height: 100vh; display: flex; align-items: center; }
        .register-card { max-width: 400px; margin: 0 auto; padding: 2rem 1.5rem; background: white; border-radius: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-card">
            <h2 class="text-center mb-4">📝 Register</h2>

            <?php if ($success): ?>
                <div class="alert alert-success">Registration successful! <a href="index.php">Login now</a></div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $err): ?>
                        <p class="mb-0"><?php echo htmlspecialchars($err); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="register_handler.php" method="POST">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                    <label>Username (min 3 chars)</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                    <label>Password (min 6 chars)</label>
                </div>
                <button type="submit" class="btn btn-success w-100 py-2">Create Account</button>
            </form>
            <p class="text-center mt-3"><a href="index.php">Back to Login</a></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>