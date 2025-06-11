<?php
require 'includes/db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"] ?? '';
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';

    if (!empty($name) && !empty($email) && !empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$name, $email, $hashedPassword]);
            $message = "✅ User registered successfully!";
        } catch (PDOException $e) {
            $message = "❌ Error: " . $e->getMessage();
        }
    } else {
        $message = "⚠️ All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Register</title>
        <!-- Bootstrap & Custom CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <div class="blob"></div>
        <div class="blob"></div>
        <div class="login-card">
            <h2 class="text-center mb-4">Register</h2>
            <?php if (!empty($message)): ?>
                <div class="alert alert-info"><?= $message ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="mb-3">
                    <label>Name:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Password:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary">Register</button>
                    <a href="login.php" class="btn btn-outline-secondary">Back to Login</a>
                </div>
            </form>
        </div>

    </body>
</html>




</html>