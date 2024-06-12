<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../login.php");
    exit();
}

$job_id = $_GET['id'];

// Fetch job details
$sql = "SELECT * FROM jobs WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Job not found.";
    exit();
}

$job = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Pekerjaan</title>
    <link rel="stylesheet" type="text/css" href="../CSS/Admin/admin-pekerjaan.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
</head>
<body>

    <div class="container">

        <div class="header">
        </div>

        <div class="log-out"><a href="../logout.php">Log out</a></div>

<div class="detail" style="text-align: center; color: white;">
	<h2><?php echo htmlspecialchars($job['title']); ?></h2>
	<p>Kategori: <?php echo htmlspecialchars($job['category']); ?></p>
	<p>Persyaratan: <?php echo htmlspecialchars($job['requirements']); ?></p>
	<p>Deskripsi: <?php echo htmlspecialchars($job['description']); ?></p>
	<!-- Add more job details as needed -->
</div>
        <div class="back-link" style="text-align: center; margin-top: 20px;">
            <a href="admin-pekerjaan.php" style="color: white; text-decoration: none; font-size: 16px;">Back to Home</a>
        </div>
        <hr>

    </div>

</body>
</html>
