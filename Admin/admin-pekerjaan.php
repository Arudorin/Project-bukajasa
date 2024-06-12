<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../login.php");
    exit();
}

// Fetch jobs from the database
$sql = "SELECT id, title FROM jobs";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pekerjaan</title>
    <link rel="stylesheet" type="text/css" href="../CSS/Admin/admin-pekerjaan.css">
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
                        echo "<td width='700px'><a href='admin-pekerjaan-about.php?id={$row['id']}'>{$row['title']}</a><hr></td>";
                        echo "<td><a href='delete-pekerjaan.php?id={$row['id']}' class='hapus'>Hapus</a><hr class='hr'></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No jobs found.</td></tr>";
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

<?php
$conn->close();
?>
