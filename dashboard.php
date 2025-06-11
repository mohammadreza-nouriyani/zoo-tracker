<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM animals ORDER BY id DESC");
$animals = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Animal Tracker</title>
    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom Style -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .animal-img {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body class="dark-mode">
    <div class="container mt-5 dashboard-container">
        <div class="dashboard-header">
            <h2><i class="fa-solid fa-paw"></i> Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h2>
            <div>
                <a href="logout.php" class="btn btn-danger me-2"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                <a href="add_animal.php" class="btn btn-success"><i class="fa-solid fa-plus"></i> Add Animal</a>
            </div>
        </div>

        <!-- Search Box -->
        <div class="input-group mb-4">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" id="searchInput" class="form-control" placeholder="Search animals by name or species...">

        </div>

        <!-- Gender Chart -->
        <div class="chart-container">
            <<canvas id="genderChart" height="80"></canvas>
        </div>

        <!-- Species Chart -->
        <div class="chart-container">
            <canvas id="speciesChart" height="80"></canvas>
        </div>

        <!-- Health Chart -->
        <div class="chart-container">
            <canvas id="healthChart" height="80"></canvas>
        </div>

        <?php
        $maleCount = 0;
        $femaleCount = 0;
        $speciesCounts = [];
        $healthCounts = ['Good' => 0, 'Needs Care' => 0];

        foreach ($animals as $a) {
            if ($a['gender'] === 'Male') $maleCount++;
            elseif ($a['gender'] === 'Female') $femaleCount++;

            $species = $a['species'];
            $speciesCounts[$species] = ($speciesCounts[$species] ?? 0) + 1;

            $status = strtolower($a['health_status']);
            if (strpos($status, '90') !== false || strpos($status, '80') !== false) {
                $healthCounts['Needs Care']++;
            } else {
                $healthCounts['Good']++;
            }
        }
        ?>

        <script>
            // Gender Chart
            new Chart(document.getElementById('genderChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Male', 'Female'],
                    datasets: [{
                        data: [<?= $maleCount ?>, <?= $femaleCount ?>],
                        backgroundColor: ['#0d6efd', '#f06595']
                    }]
                },
                options: {
                    plugins: { title: { display: true, text: 'Animal Gender Distribution' }, legend: { position: 'bottom' } }
                }
            });

            // Species Chart
            new Chart(document.getElementById('speciesChart'), {
                type: 'bar',
                data: {
                    labels: <?= json_encode(array_keys($speciesCounts)) ?>,
                    datasets: [{
                        label: 'Count by Species',
                        data: <?= json_encode(array_values($speciesCounts)) ?>,
                        backgroundColor: '#198754'
                    }]
                },
                options: {
                    plugins: { title: { display: true, text: 'Animal Species Distribution' } }
                }
            });

            // Health Chart
            new Chart(document.getElementById('healthChart'), {
                type: 'pie',
                data: {
                    labels: ['Good', 'Needs Care'],
                    datasets: [{
                        data: [<?= $healthCounts['Good'] ?>, <?= $healthCounts['Needs Care'] ?>],
                        backgroundColor: ['#20c997', '#ffc107']
                    }]
                },
                options: {
                    plugins: { title: { display: true, text: 'Health Status Overview' }, legend: { position: 'bottom' } }
                }
            });

            // Search filter
            document.getElementById('searchInput').addEventListener('keyup', function() {
                let value = this.value.toLowerCase();
                document.querySelectorAll('.animal-card').forEach(function(card) {
                    const name = card.getAttribute('data-name').toLowerCase();
                    const species = card.getAttribute('data-species').toLowerCase();
                    if (name.includes(value) || species.includes(value)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        </script>

        <?php if (count($animals) > 0): ?>
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <?php foreach ($animals as $animal): ?>
                    <div class="col animal-card animate__animated animate__fadeInUp" data-name="<?= htmlspecialchars($animal['name']) ?>" data-species="<?= htmlspecialchars($animal['species']) ?>">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><i class="fa-solid fa-dog"></i> <?= htmlspecialchars($animal['name']) ?></h5>
                                <p class="card-text mb-1"><strong>Species:</strong> <?= htmlspecialchars($animal['species']) ?></p>
                                <p class="card-text mb-1"><strong>Birth Date:</strong> <?= htmlspecialchars($animal['birth_date']) ?></p>
                                <p class="card-text mb-1"><strong>Gender:</strong> <?= htmlspecialchars($animal['gender']) ?></p>
                                <p class="card-text mb-1"><strong>Habitat:</strong> <?= htmlspecialchars($animal['habitat']) ?></p>
                                <p class="card-text mb-1"><strong>Health Status:</strong> <?= htmlspecialchars($animal['health_status']) ?></p>
                                <p class="card-text mb-1"><strong>Last Checkup:</strong> <?= htmlspecialchars($animal['last_checkup']) ?></p>
                                <p class="card-text"><strong>Diet:</strong> <?= htmlspecialchars($animal['diet']) ?></p>
                                <div class="d-flex justify-content-end">
                                    <a href="edit_animal.php?id=<?= $animal['id'] ?>" class="btn btn-warning btn-sm me-2"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                    <a href="delete_animal.php?id=<?= $animal['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this animal?');">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info mt-4">No animals found.</div>
        <?php endif; ?>
    </div>
</body>
</html>
