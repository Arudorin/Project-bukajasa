<?php
session_start();

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Memeriksa apakah ID pekerjaan disertakan dalam URL
if (!isset($_GET['job_id']) || empty($_GET['job_id'])) {
    header("Location: ../home.php");
    exit();
}

// Mengambil data job_id dari URL
$job_id = $_GET['job_id'];

// Menyimpan user_id dari sesi
$user_id = $_SESSION['user_id'];

// Melakukan koneksi ke database
include '../db_connection.php';

// Menyiapkan query untuk memeriksa apakah pengguna sudah mengirimkan aplikasi untuk pekerjaan ini sebelumnya
$sql = "SELECT id FROM applications WHERE job_id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $job_id, $user_id);
$stmt->execute();
$stmt->store_result();

// Jika pengguna sudah mengirimkan aplikasi sebelumnya, maka tidak perlu mengirimkan lagi
if ($stmt->num_rows > 0) {
    header("Location: student-home.php");
    exit();
}

// Menyiapkan query untuk menyimpan aplikasi pekerjaan baru
$sql = "INSERT INTO applications (job_id, user_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $job_id, $user_id);

// Menjalankan query untuk menyimpan aplikasi pekerjaan baru
if ($stmt->execute()) {
    header("Location: student-home.php");
    exit();
} else {
    header("Location: application-error.php");
    exit();
}

// Menutup koneksi ke database
$stmt->close();
$conn->close();
?>
