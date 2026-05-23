<?php
declare(strict_types=1);
require_once __DIR__ . '/config/db.php';

$pdo = getDbConnection();

$stmt = $pdo->query(
    'SELECT s.id, s.name, s.location, s.phone, s.description, s.image_url,
            COUNT(se.id) AS total_services,
            MIN(se.price) AS starting_price
     FROM salons s
     LEFT JOIN services se ON se.salon_id = s.id
     GROUP BY s.id
     ORDER BY s.name ASC'
);

$salons = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeautyConnect | Salon Booking Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">BeautyConnect</a>
            <div>
                <a class="btn btn-outline-light btn-sm me-2" href="book.php">Book Now</a>
                <a class="btn btn-warning btn-sm" href="bookings.php">View Bookings</a>
            </div>
        </div>
    </nav>

    <header class="hero-section text-white py-5">
        <div class="container text-center py-4">
            <h1 class="display-5 fw-bold">Discover & Book Trusted Beauty Services</h1>
            <p class="lead">Find salons, compare services, and reserve appointments in minutes.</p>
            <a href="book.php" class="btn btn-lg btn-light fw-semibold">Book an Appointment</a>
        </div>
    </header>

    <main class="container py-5">
        <h2 class="mb-4">Featured Salons</h2>
        <div class="row g-4">
            <?php foreach ($salons as $salon): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="<?= htmlspecialchars((string)$salon['image_url']); ?>" class="card-img-top salon-img" alt="<?= htmlspecialchars((string)$salon['name']); ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars((string)$salon['name']); ?></h5>
                            <p class="text-muted mb-2"><?= htmlspecialchars((string)$salon['location']); ?></p>
                            <p class="card-text flex-grow-1"><?= htmlspecialchars((string)$salon['description']); ?></p>
                            <ul class="list-unstyled mb-3 small">
                                <li><strong>Phone:</strong> <?= htmlspecialchars((string)$salon['phone']); ?></li>
                                <li><strong>Services:</strong> <?= (int)$salon['total_services']; ?></li>
                                <li><strong>Starting from:</strong> $<?= number_format((float)($salon['starting_price'] ?? 0), 2); ?></li>
                            </ul>
                            <a href="book.php?salon_id=<?= (int)$salon['id']; ?>" class="btn btn-primary mt-auto">Book Here</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-3">
        <small>&copy; <?= date('Y'); ?> BeautyConnect. All rights reserved.</small>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
