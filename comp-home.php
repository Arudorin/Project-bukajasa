<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Perusahaan') {
    echo "You must be logged in as a company to view this page.";
    exit();
}

$company_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home Company</title>
    <link rel="stylesheet" type="text/css" href="CSS/comp-home.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
</head>
<body>

    <div class="container">

        <div class="header">
        </div>

        <div class="log-out"><a href="logout.php">Log out</a></div>

        <h1>Applicants</h1>

        <div class="posting">
            <?php
            // Fetch job postings and their applicants
            $sql = "SELECT applications.id AS application_id, applications.application_date, 
                           jobs.title, users.username AS applicant_name, users.email AS applicant_email
                    FROM applications 
                    JOIN jobs ON applications.job_id = jobs.id 
                    JOIN users ON applications.user_id = users.id 
                    WHERE jobs.company_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $company_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='post-1'>";
                    echo "<div class='foto'><p>Disini Foto</p></div>";
                    echo "<div class='teks'>";
                    echo "<a href='about-job.html'>" . $row['title'] . "</a><br>";
                    echo "<span>Nama Pelamar: " . $row['applicant_name'] . "</span><br>";
                    echo "<span>Email Pelamar: " . $row['applicant_email'] . "</span><br>";
                    echo "<span>Tanggal Aplikasi: " . $row['application_date'] . "</span><br>";
                    echo "</div>";
                    echo "<div class='decline'><a href='decline-application.php?id=" . $row['application_id'] . "'>Decline</a></div>";
                    echo "<div class='accept'><a href='accept-application.php?id=" . $row['application_id'] . "'>Accept</a></div>";
                    echo "<hr>";
                    echo "</div>";
                }
            } else {
                echo "No applicants found.";
            }

            $stmt->close();
            $conn->close();
            ?>
        </div>

        <div class="profile">
            <div class="foto-profil">
                <p>Disini Foto profil</p>
            </div>
            <div class="keterangan">
                <a href="profile-comp.html">Nama Perusahaan</a>
                <span><br>Email</span>
            </div>
            <div class="post-job"> 
                <a href="post-job.php">Post a Job</a>
            </div>
        </div>

    </div>

</body>
</html>
