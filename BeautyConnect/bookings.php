<?php
declare(strict_types=1);
require_once __DIR__ . '/config/db.php';

$pdo = getDbConnection();

$stmt = $pdo->query(
    'SELECT b.id, b.appointment_date, b.appointment_time, b.status, b.notes, b.created_at,
            c.full_name, c.email, c.phone,
            s.name AS salon_name,
            se.name AS service_name, se.price
     FROM bookings b
     INNER JOIN customers c ON c.id = b.customer_id
     INNER JOIN salons s ON s.id = b.salon_id
     INNER JOIN services se ON se.id = b.service_id
     ORDER BY b.appointment_date DESC, b.appointment_time DESC, b.created_at DESC'
);

$bookings = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings | BeautyConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">BeautyConnect</a>
            <a class="btn btn-outline-light btn-sm" href="book.php">New Booking</a>
        </div>
    </nav>

    <main class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3 mb-0">Booking Management</h1>
            <span class="badge text-bg-primary"><?= count($bookings); ?> bookings</span>
        </div>

        <div class="table-responsive bg-white shadow-sm rounded">
            <table class="table table-striped align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>Salon</th>
                        <th>Service</th>
                        <th>Appointment</th>
                        <th>Status</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!$bookings): ?>
                    <tr>
                        <td colspan="8" class="text-center py-4">No bookings yet.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?= (int)$booking['id']; ?></td>
                            <td><?= htmlspecialchars((string)$booking['full_name']); ?></td>
                            <td>
                                <div><?= htmlspecialchars((string)$booking['email']); ?></div>
                                <small class="text-muted"><?= htmlspecialchars((string)$booking['phone']); ?></small>
                            </td>
                            <td><?= htmlspecialchars((string)$booking['salon_name']); ?></td>
                            <td>
                                <div><?= htmlspecialchars((string)$booking['service_name']); ?></div>
                                <small class="text-muted">$<?= number_format((float)$booking['price'], 2); ?></small>
                            </td>
                            <td>
                                <div><?= htmlspecialchars((string)$booking['appointment_date']); ?></div>
                                <small class="text-muted"><?= htmlspecialchars(substr((string)$booking['appointment_time'], 0, 5)); ?></small>
                            </td>
                            <td><span class="badge text-bg-warning"><?= htmlspecialchars((string)$booking['status']); ?></span></td>
                            <td class="notes-cell"><?= htmlspecialchars((string)($booking['notes'] ?? '')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
