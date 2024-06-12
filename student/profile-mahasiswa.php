<?php
session_start();
include '../db_connection.php';

// Pastikan pengguna telah masuk dan merupakan seorang mahasiswa
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Mahasiswa') {
    echo "You must be logged in as a student to view this page.";
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil informasi pengguna
$sql_user = "SELECT name, email, profile_picture FROM users WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows == 0) {
    echo "User not found.";
    exit();
}

$user = $result_user->fetch_assoc();

// Ambil aplikasi pekerjaan pengguna
$sql_applications = "SELECT j.title AS job_title, a.status 
                     FROM applications a 
                     JOIN jobs j ON a.job_id = j.id 
                     WHERE a.user_id = ?";
$stmt_applications = $conn->prepare($sql_applications);
$stmt_applications->bind_param("i", $user_id);
$stmt_applications->execute();
$result_applications = $stmt_applications->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile Mahasiswa</title>
    <link rel="stylesheet" type="text/css" href="../CSS/profile-mhs.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
</head>
<body>

    <div class="container">
        <div class="header">
        </div>

        <div class="profile-pic">
          <img src="../uploads/<?php echo $user['profile_picture']; ?>" alt="Profile Picture">
        </div>
        
        <div class="teks">
            <p>Nama: <?php echo htmlspecialchars($user['name']); ?></p>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        </div>

        <div id="edit">
            <a href="edit-mahasiswa.php">Edit</a>
        </div>
        <div id="logout">
            <a href="../logout.php">Logout</a>
        </div>

        <div class="bawah">
            <table width="800px" align="center" cellspacing="10px">
                <?php
                if ($result_applications->num_rows > 0) {
                    while ($application = $result_applications->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><font>" . htmlspecialchars($application['job_title']) . "</font><hr></td>";
                        echo "<td width='250px'><font>" . htmlspecialchars($application['status']) . "</font><hr></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No job applications found.</td></tr>";
                }
                ?>
            </table>
        </div>
        <div class="back-link" style="text-align: center; margin-top: 20px;">
            <a href="student-home.php" style="color: #26293b; text-decoration: none; font-size: 16px;">Back to Home</a>
        </div>
</body>
</html>

<?php
$stmt_user->close();
$stmt_applications->close();
$conn->close();
?>
