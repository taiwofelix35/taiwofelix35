<?php
declare(strict_types=1);
require_once __DIR__ . '/config/db.php';

$pdo = getDbConnection();

$salonStmt = $pdo->query('SELECT id, name, location FROM salons ORDER BY name ASC');
$serviceStmt = $pdo->query('SELECT id, salon_id, name, duration_minutes, price FROM services ORDER BY name ASC');

$salons = $salonStmt->fetchAll();
$services = $serviceStmt->fetchAll();

$selectedSalonId = isset($_GET['salon_id']) ? (int)$_GET['salon_id'] : 0;
$message = $_GET['message'] ?? '';
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment | BeautyConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">BeautyConnect</a>
        </div>
    </nav>

    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="mb-4">Book Your Appointment</h1>

                <?php if ($message !== ''): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($message); ?></div>
                <?php endif; ?>

                <?php if ($error !== ''): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form id="bookingForm" class="card shadow-sm border-0 p-4" method="POST" action="submit_booking.php">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" required maxlength="120">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required maxlength="120">
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required maxlength="20">
                        </div>
                        <div class="col-md-6">
                            <label for="salon_id" class="form-label">Salon</label>
                            <select class="form-select" id="salon_id" name="salon_id" required data-selected-salon="<?= $selectedSalonId; ?>">
                                <option value="">Select salon</option>
                                <?php foreach ($salons as $salon): ?>
                                    <option value="<?= (int)$salon['id']; ?>">
                                        <?= htmlspecialchars((string)$salon['name']); ?> - <?= htmlspecialchars((string)$salon['location']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="service_id" class="form-label">Service</label>
                            <select class="form-select" id="service_id" name="service_id" required>
                                <option value="">Select service</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="appointment_date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="appointment_date" name="appointment_date" required>
                        </div>
                        <div class="col-md-3">
                            <label for="appointment_time" class="form-label">Time</label>
                            <input type="time" class="form-control" id="appointment_time" name="appointment_time" required>
                        </div>
                        <div class="col-12">
                            <label for="notes" class="form-label">Additional Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" maxlength="500" placeholder="Optional"></textarea>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">Confirm Booking</button>
                        <a href="index.php" class="btn btn-outline-secondary">Back to Home</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        window.beautyConnectServices = <?= json_encode($services, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;
    </script>
    <script src="assets/js/main.js"></script>
</body>
</html>
