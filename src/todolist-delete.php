<?php
require '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "error: Method not allowed";
    exit;
}

$todoId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

// Validasi input
if (!$todoId) {
    echo "error: Invalid todo ID";
    exit;
}

// Prepare query delete
$query = "DELETE FROM todolists WHERE id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $query);

$user_id = 1;
mysqli_stmt_bind_param($stmt, "ii", $todoId, $user_id);

// Execute query
if (mysqli_stmt_execute($stmt)) {
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "success";
    } else {
        echo "error: Todo not found";
    }
} else {
    echo "error: Database error";
}

// Close statement
mysqli_stmt_close($stmt);
?>