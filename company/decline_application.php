<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Perusahaan') {
    echo "You must be logged in as a company to view this page.";
    exit();
}

$application_id = isset($_GET['id']) ? $_GET['id'] : '';
if (empty($application_id)) {
    echo "No application ID provided.";
    exit();
}

$sql = "UPDATE applications SET status = 'declined' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $application_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Application declined successfully.";
} else {
    echo "Failed to decline application.";
}

$stmt->close();
$conn->close();

header("Location: comp-home.php"); // Redirect back to job page
exit();
?>