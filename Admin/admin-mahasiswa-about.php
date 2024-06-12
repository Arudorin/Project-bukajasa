<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../login.php");
    exit();
}

$mahasiswa_id = $_GET['id'];

// Fetch mahasiswa details
$sql = "SELECT * FROM users WHERE id = ? AND role = 'Mahasiswa'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $mahasiswa_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "mahasiswa not found.";
    exit();
}

$mahasiswa = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Mahasiswa</title>
    <link rel="stylesheet" type="text/css" href="../CSS/Admin/admin-perusahaan.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
</head>
<body>

    <div class="container">

        <div class="header">
            <h1 style="color: white;">Detail Mahasiswa</h1>
        </div>

        <div class="log-out"><a href="../logout.php">Log out</a></div>

        <div class="detail">
            <h2 style="text-align: center; color: white;"><?php echo htmlspecialchars($mahasiswa['name']); ?></h2>
            <p style="text-align: center; color: white;">Username: <?php echo htmlspecialchars($mahasiswa['username']); ?></p>
            <p style="text-align: center; color: white;">Email: <?php echo htmlspecialchars($mahasiswa['email']); ?></p>
            <p style="text-align: center;">
                <img src="../uploads/<?php echo htmlspecialchars($mahasiswa['profile_picture']); ?>" alt="Profile Picture" style="max-width: 200px; border-radius: 50%;">
            </p>
        </div>
        <div class="back-link" style="text-align: center; margin-top: 20px;">
            <a href="admin-Mahasiswa.php" style="color: white; text-decoration: none; font-size: 16px;">Back to Home</a>
        </div>
        <hr>

    </div>

</body>
</html>
