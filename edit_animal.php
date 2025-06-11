<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    die("Invalid ID.");
}

$stmt = $pdo->prepare("SELECT * FROM animals WHERE id = ?");
$stmt->execute([$id]);
$animal = $stmt->fetch();

if (!$animal) {
    die("❌ Animal not found with ID = $id.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'] ?? '';
    $species = $_POST['species'] ?? '';
    $birth_date = $_POST['birth_date'] ?? null;
    $gender = $_POST['gender'] ?? '';
    $habitat = $_POST['habitat'] ?? '';
    $health_status = $_POST['health_status'] ?? '';
    $last_checkup = $_POST['last_checkup'] ?? null;
    $diet = $_POST['diet'] ?? '';

    $stmt = $pdo->prepare("UPDATE animals SET name=?, species=?, birth_date=?, gender=?, habitat=?, health_status=?, last_checkup=?, diet=? WHERE id=?");
    $stmt->execute([$name, $species, $birth_date, $gender, $habitat, $health_status, $last_checkup, $diet, $id]);

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Edit Animal</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Edit Animal (ID: <?= htmlspecialchars($id) ?>)</h2>

    <form method="post">
        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($animal['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Species:</label>
            <input type="text" name="species" class="form-control" value="<?= htmlspecialchars($animal['species']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Birth Date:</label>
            <input type="date" name="birth_date" class="form-control" value="<?= $animal['birth_date'] ?>">
        </div>

        <div class="mb-3">
            <label>Gender:</label>
            <select name="gender" class="form-control" required>
                <option value="Male" <?= $animal['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $animal['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Habitat:</label>
            <input type="text" name="habitat" class="form-control" value="<?= htmlspecialchars($animal['habitat']) ?>">
        </div>

        <div class="mb-3">
            <label>Health Status:</label>
            <textarea name="health_status" class="form-control"><?= htmlspecialchars($animal['health_status']) ?></textarea>
        </div>

        <div class="mb-3">
            <label>Last Checkup Date:</label>
            <input type="date" name="last_checkup" class="form-control" value="<?= $animal['last_checkup'] ?>">
        </div>

        <div class="mb-3">
            <label>Diet:</label>
            <textarea name="diet" class="form-control"><?= htmlspecialchars($animal['diet']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>
