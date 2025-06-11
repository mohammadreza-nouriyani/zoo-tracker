<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $species = $_POST['species'] ?? '';
    $birth_date = $_POST['birth_date'] ?? null;
    $gender = $_POST['gender'] ?? '';
    $habitat = $_POST['habitat'] ?? '';
    $health_status = $_POST['health_status'] ?? '';
    $last_checkup = $_POST['last_checkup'] ?? null;
    $diet = $_POST['diet'] ?? '';

    if (!empty($name) && !empty($species) && !empty($gender)) {
        $stmt = $pdo->prepare("INSERT INTO animals (name, species, birth_date, gender, habitat, health_status, last_checkup, diet) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $species, $birth_date, $gender, $habitat, $health_status, $last_checkup, $diet]);

        header("Location: dashboard.php");
        exit;
    } else {
        $message = "⚠️ Name, Species, and Gender are required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Add Animal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Add New Animal</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-warning"><?= $message ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Species:</label>
            <input type="text" name="species" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Birth Date:</label>
            <input type="date" name="birth_date" class="form-control">
        </div>

        <div class="mb-3">
            <label>Gender:</label>
            <select name="gender" class="form-control" required>
                <option value="">Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Habitat:</label>
            <input type="text" name="habitat" class="form-control">
        </div>

        <div class="mb-3">
            <label>Health Status:</label>
            <textarea name="health_status" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Last Checkup Date:</label>
            <input type="date" name="last_checkup" class="form-control">
        </div>

        <div class="mb-3">
            <label>Diet:</label>
            <textarea name="diet" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Add Animal</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>
