<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Show success message after ID card submission
$success_msg = $_SESSION['id_card_success'] ?? '';
unset($_SESSION['id_card_success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ID Card System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f4f7fc; }
        .content-area { max-width: 900px; margin: 30px auto; }
        .form-card { background: white; padding: 2rem 1.5rem; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        .error-text { font-size: 0.8rem; color: #dc3545; margin-top: 4px; }
        .required-star { color: #dc3545; }
        @media (max-width: 576px) {
            .form-card { padding: 1.25rem 0.75rem; }
        }
    </style>
</head>
<body>

<!-- Header Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="fas fa-id-card me-2"></i>ID Card System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard.php"><i class="fas fa-home me-1"></i>Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#idCardFormSection"><i class="fas fa-plus-circle me-1"></i>Add ID Card</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt me-1"></i>Logout (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container content-area">
    <!-- Success message from submission -->
    <?php if ($success_msg): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($success_msg); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- ID Card Form Section -->
    <div id="idCardFormSection" class="form-card">
        <h3 class="mb-4"><i class="fas fa-user-plus me-2"></i>Issue New ID Card</h3>
        <hr>
        <?php include 'id_card_form.php'; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/validate.js"></script>
</body>
</html>