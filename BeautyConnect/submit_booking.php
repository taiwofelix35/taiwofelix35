<?php
declare(strict_types=1);
require_once __DIR__ . '/config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: book.php');
    exit;
}

$fullName = trim((string)($_POST['full_name'] ?? ''));
$email = trim((string)($_POST['email'] ?? ''));
$phone = trim((string)($_POST['phone'] ?? ''));
$salonId = (int)($_POST['salon_id'] ?? 0);
$serviceId = (int)($_POST['service_id'] ?? 0);
$appointmentDate = (string)($_POST['appointment_date'] ?? '');
$appointmentTime = (string)($_POST['appointment_time'] ?? '');
$notes = trim((string)($_POST['notes'] ?? ''));

$validationError = '';

if ($fullName === '' || $email === '' || $phone === '' || $salonId < 1 || $serviceId < 1 || $appointmentDate === '' || $appointmentTime === '') {
    $validationError = 'All required fields must be provided.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $validationError = 'Please provide a valid email address.';
} elseif (!preg_match('/^[0-9+\-\s()]{7,20}$/', $phone)) {
    $validationError = 'Please provide a valid phone number.';
} elseif (strtotime($appointmentDate) < strtotime(date('Y-m-d'))) {
    $validationError = 'Appointment date cannot be in the past.';
}

if ($validationError !== '') {
    header('Location: book.php?error=' . urlencode($validationError));
    exit;
}

$pdo = getDbConnection();

$serviceCheck = $pdo->prepare('SELECT id FROM services WHERE id = :service_id AND salon_id = :salon_id');
$serviceCheck->execute([
    ':service_id' => $serviceId,
    ':salon_id' => $salonId,
]);

if (!$serviceCheck->fetch()) {
    header('Location: book.php?error=' . urlencode('Selected service does not belong to the selected salon.'));
    exit;
}

try {
    $pdo->beginTransaction();

    $findCustomer = $pdo->prepare('SELECT id FROM customers WHERE email = :email LIMIT 1');
    $findCustomer->execute([':email' => $email]);
    $customer = $findCustomer->fetch();

    if ($customer) {
        $customerId = (int)$customer['id'];
        $updateCustomer = $pdo->prepare('UPDATE customers SET full_name = :full_name, phone = :phone WHERE id = :id');
        $updateCustomer->execute([
            ':full_name' => $fullName,
            ':phone' => $phone,
            ':id' => $customerId,
        ]);
    } else {
        $insertCustomer = $pdo->prepare('INSERT INTO customers (full_name, email, phone) VALUES (:full_name, :email, :phone)');
        $insertCustomer->execute([
            ':full_name' => $fullName,
            ':email' => $email,
            ':phone' => $phone,
        ]);
        $customerId = (int)$pdo->lastInsertId();
    }

    $insertBooking = $pdo->prepare(
        'INSERT INTO bookings (customer_id, salon_id, service_id, appointment_date, appointment_time, notes, status)
         VALUES (:customer_id, :salon_id, :service_id, :appointment_date, :appointment_time, :notes, :status)'
    );
    $insertBooking->execute([
        ':customer_id' => $customerId,
        ':salon_id' => $salonId,
        ':service_id' => $serviceId,
        ':appointment_date' => $appointmentDate,
        ':appointment_time' => $appointmentTime,
        ':notes' => $notes === '' ? null : $notes,
        ':status' => 'Pending',
    ]);

    $pdo->commit();

    header('Location: book.php?message=' . urlencode('Booking submitted successfully! We will contact you soon.'));
    exit;
} catch (Throwable $exception) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    header('Location: book.php?error=' . urlencode('Unable to submit booking at this time. Please try again.'));
    exit;
}
