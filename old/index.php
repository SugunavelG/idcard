<?php
session_start();
// Display server‑side errors if any
$errors = $_SESSION['login_errors'] ?? [];
unset($_SESSION['login_errors']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap 5 CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom responsive tweaks -->
    <style>
        body {
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            max-width: 400px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .error-text {
            font-size: 0.875rem;
            color: #dc3545;
        }
        .form-floating > label {
            font-size: 0.9rem;
        }
        @media (max-width: 576px) {
            .login-card { padding: 1.5rem 1rem; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="login-card">
        <h2 class="text-center mb-4">🔐 Login</h2>

        <!-- Display server‑side errors -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger" role="alert">
                <?php foreach ($errors as $err): ?>
                    <p class="mb-0"><?php echo htmlspecialchars($err); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form id="loginForm" action="login.php" method="POST" novalidate>
            <!-- Username -->
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo isset($_SESSION['old_username']) ? htmlspecialchars($_SESSION['old_username']) : ''; ?>">
                <label for="username">Username</label>
                <div class="error-text" id="usernameError"></div>
            </div>

            <!-- Password -->
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                <label for="password">Password</label>
                <div class="error-text" id="passwordError"></div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
        </form>

        <p class="text-center mt-3 mb-0">
            Don't have an account? <a href="register.php">Register</a>
        </p>
    </div>
</div>

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom validation script -->
<script src="assets/js/validate.js"></script>
<script>
    $(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        // Clear previous errors
        $('.error-text').text('');
        $('.alert-danger').remove();

        let isValid = true;
        const username = $('#username').val().trim();
        const password = $('#password').val().trim();

        // Username validation
        if (username === '') {
            $('#usernameError').text('Username is required.');
            isValid = false;
        } else if (username.length < 3) {
            $('#usernameError').text('Username must be at least 3 characters.');
            isValid = false;
        }

        // Password validation
        if (password === '') {
            $('#passwordError').text('Password is required.');
            isValid = false;
        } else if (password.length < 6) {
            $('#passwordError').text('Password must be at least 6 characters.');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault(); // stop submission
        }
    });
});
</script>
</body>
</html>