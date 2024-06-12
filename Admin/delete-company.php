<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../login.php");
    exit();
}

$company_id = $_GET['id'];

// Delete company
$sql = "DELETE FROM users WHERE id = ? AND role = 'Perusahaan'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $company_id);

if ($stmt->execute()) {
    header("Location: admin-perusahaan.php");
    exit();
} else {
    echo "Error deleting company: " . $conn->error;
}

$conn->close();
?>
