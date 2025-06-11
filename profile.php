<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get current user info
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$message = '';

// Update profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';

    if (!empty($name) && !empty($email)) {
        $update = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $update->execute([$name, $email, $_SESSION['user_id']]);
        $message = "✅ Profile updated successfully.";
        $_SESSION['user_name'] = $name;
    } else {
        $message = "⚠️ Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="container mt-5">
    <h2 class="mb-4">Edit Profile</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-info"> <?= $message ?> </div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </form>
</body>
</html>
