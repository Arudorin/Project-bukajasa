<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Perusahaan') {
    echo "<script>alert('You must be logged in as a company to view this page.'); window.location.href = 'comp-home.php';</script>";
    exit();
}

$application_id = isset($_GET['id']) ? $_GET['id'] : '';
if (empty($application_id)) {
    echo "<script>alert('No application ID provided.'); window.location.href = 'comp-home.php';</script>";
    exit();
}

// Retrieve job_id for redirect
$sql_job_id = "SELECT job_id FROM applications WHERE id = ?";
$stmt_job_id = $conn->prepare($sql_job_id);
$stmt_job_id->bind_param("i", $application_id);
$stmt_job_id->execute();
$stmt_job_id->bind_result($job_id);
$stmt_job_id->fetch();
$stmt_job_id->close();

if (empty($job_id)) {
    echo "<script>alert('Invalid job ID.'); window.location.href = 'comp-home.php';</script>";
    exit();
}

$sql = "UPDATE applications SET status = 'accepted' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $application_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "<script>alert('Application accepted successfully.'); window.location.href = 'about-job.php?id=" . $job_id . "';</script>";
} else {
    echo "<script>alert('Failed to accept application.'); window.location.href = 'about-job.php?id=" . $job_id . "';</script>";
}

$stmt->close();
$conn->close();

exit();
?>
