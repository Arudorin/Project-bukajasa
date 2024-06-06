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

// Check if user is logged in and is a student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Mahasiswa') {
    header("Location: ../login.php");
    exit();
}

// Fetch jobs available for students
$sql = "SELECT jobs.id, jobs.title, jobs.deadline, jobs.salary, jobs.description, jobs.requirements, users.username 
        FROM jobs 
        JOIN users ON jobs.company_id = users.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="../CSS/student-home.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
</head>
<body>

    <div class="container">

        <div class="header">
        </div>

        <div class="log-out"><a href="../logout.php">Log out</a></div>
        
        <div class="posting">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="post-1">
                    <div class="foto">
                        <p>Disini Foto</p>
                    </div>
                    <div class="teks">
                        <a href="apply-job.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['title']) ?><br></a>
                        <span>Deadline: <?= htmlspecialchars($row['deadline']) ?></span>
                        <span>Gaji: Rp. <?= number_format($row['salary'], 2) ?> / Jam</span>
                        <span>Deskripsi: <?= htmlspecialchars($row['description']) ?></span>
                        <span>Persyaratan: <?= htmlspecialchars($row['requirements']) ?></span>
                        <span>Perusahaan: <?= htmlspecialchars($row['username']) ?></span>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="profile">
            <div class="foto-profil">
                <p>Disini Foto profil</p>
            </div>
            <div class="keterangan">
                <a href="profile-mahasiswa.php"><?= $_SESSION['username'] ?></a>
            </div>
        </div>

    </div>

</body>
</html>

<?php
$conn->close();
?>
