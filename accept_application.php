<?php
session_start();

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bukajasa";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in and is a company
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Perusahaan') {
    header("Location: login.php");
    exit();
}

// Get application ID from URL
$application_id = $_GET['id'];

// Update application status to 'accepted'
$sql = "UPDATE applications SET status = 'accepted' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $application_id);
$stmt->execute();

$stmt->close();
$conn->close();

// Redirect back to company home
header("Location: comp-home.php");
exit();
?>
