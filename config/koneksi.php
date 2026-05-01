<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "todolist_db";

// Buat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>