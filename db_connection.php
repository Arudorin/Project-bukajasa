<!-- db_connection.php -->
<?php
$servername = "localhost"; // Sesuaikan dengan server Anda
$username = "root"; // Sesuaikan dengan username database Anda
$password = ""; // Sesuaikan dengan password database Anda
$dbname = "bukajasa"; // Sesuaikan dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
