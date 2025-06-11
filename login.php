<?php
session_start();
require 'includes/db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';

    if (!empty($email) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: dashboard.php");
            exit;
        } else {
            $message = "❌ Incorrect email or password.";
        }
    } else {
        $message = "⚠️ Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Bootstrap & Custom CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="blob"></div>
    <div class="blob"></div>
    <div class="login-card">
        <h2 class="text-center mb-4">Login</h2>
        <?php if (!empty($message)): ?>
            <div class="alert alert-warning"><?= $message ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-success">Login</button>
                <a href="register.php" class="btn btn-outline-primary">Back to Register</a>
            </div>
        </form>
    </div>
</body>

</html>