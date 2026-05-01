<?php
require __DIR__ . '/../config/koneksi.php';
header('Content-Type: text/plain; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "error: Method not allowed";
    exit;
}

$todoId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if ($todoId === false || $todoId <= 0) {
    http_response_code(400);
    echo "error: Invalid todo ID";
    exit;
}

$query = "DELETE FROM todolists WHERE id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $query);
if (!$stmt) {
    http_response_code(500);
    echo "error: Database prepare failed";
    exit;
}

$user_id = 1;
mysqli_stmt_bind_param($stmt, "ii", $todoId, $user_id);

if (mysqli_stmt_execute($stmt)) {
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "success";
    } else {
        http_response_code(404);
        echo "error: Todo not found";
    }
} else {
    http_response_code(500);
    echo "error: Database error";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
