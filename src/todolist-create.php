<?php
require __DIR__ . '/../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Method not allowed";
    exit;
}

$user_id = 1;
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$deadline = trim($_POST['deadline'] ?? '');
$priority = trim($_POST['priority'] ?? '');

if ($title === '' || $description === '' || $deadline === '' || $priority === '') {
    http_response_code(400);
    die("Error: Semua field harus diisi.");
}

$query = "INSERT INTO todolists (user_id, title, description, deadline, priority, status) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);
if (!$stmt) {
    die("Error prepare: " . mysqli_error($conn));
}

$status = 'pending';
mysqli_stmt_bind_param($stmt, "isssss", $user_id, $title, $description, $deadline, $priority, $status);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header("Location: ../index.php?success=created");
    exit;
} else {
    $error = mysqli_stmt_error($stmt) ?: mysqli_error($conn);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    die("Error: " . $error);
}
?>
