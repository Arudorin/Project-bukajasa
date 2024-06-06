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
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['nama_pekerjaan'];
    $deadline = $_POST['deadline'];
    $salary = $_POST['gaji'];
    $description = $_POST['deskripsi'];
    $requirements = $_POST['persyaratan'];
    $company_id = $_SESSION['user_id'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO jobs (company_id, title, deadline, salary, description, requirements) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $company_id, $title, $deadline, $salary, $description, $requirements);

    if ($stmt->execute()) {
        header("Location: comp-home.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
