<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../login.php");
    exit();
}

$job_id = $_GET['id'];

// Delete job from the database
$sql = "DELETE FROM jobs WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $job_id);

if ($stmt->execute()) {
    header("Location: admin-pekerjaan.php");
    exit();
} else {
    echo "Error deleting job: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
