<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../login.php");
    exit();
}

// Fetch all companies
$sql = "SELECT id, name FROM users WHERE role = 'Mahasiswa'";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mahasiswa</title>
    <link rel="stylesheet" type="text/css" href="../CSS/Admin/admin-perusahaan.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
</head>
<body>

    <div class="container">

        <div class="header">
        </div>

        <div class="log-out"><a href="../logout.php">Log out</a></div>
            
        <div class="posting">
            <table width="1000px" cellspacing="10px">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td width='700px'><a href='admin-mahasiswa-about.php?id={$row['id']}'> {$row['name']}</a><hr></td>";
                        echo "<td><a href='delete-mahasiswa.php?id={$row['id']}' class='hapus'>Hapus</a><hr class='hr'></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No companies found.</td></tr>";
                }
                ?>
            </table>
        </div>
        <div class="back-link" style="text-align: center; margin-top: 20px;">
            <a href="admin-home.php" style="color: white; text-decoration: none; font-size: 16px;">Back to Home</a>
        </div>
        <hr>


    </div>

</body>
</html>
