<?php
require '../config/koneksi.php';

// Cek method request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "error: Method not allowed";
    exit;
}

// Ambil dan sanitasi input
$todoId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

// Validasi input
if (!$todoId) {
    echo "error: Invalid todo ID";
    exit;
}

// Prepare query update status
$query = "UPDATE todolists SET status = 'done' WHERE id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $query);

// Bind parameter (id todo, user_id hardcoded sementara)
$user_id = 1;
mysqli_stmt_bind_param($stmt, "ii", $todoId, $user_id);

// Execute query
if (mysqli_stmt_execute($stmt)) {
    // Cek apakah ada row yang terupdate
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "success";
    } else {
        echo "error: Todo not found or already done";
    }
} else {
    echo "error: Database error";
}

// Close statement
mysqli_stmt_close($stmt);
?>