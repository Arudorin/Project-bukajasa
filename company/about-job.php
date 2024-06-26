<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Perusahaan') {
    echo "You must be logged in as a company to view this page.";
    exit();
}

$company_id = $_SESSION['user_id'];
$job_id = isset($_GET['id']) ? $_GET['id'] : '';
if (empty($job_id)) {
    echo "Invalid job ID.";
    exit();
}

// Fetch company details
$sql_company = "SELECT name, email, profile_picture FROM users WHERE id = ?";
$stmt_company = $conn->prepare($sql_company);
$stmt_company->bind_param("i", $company_id);
$stmt_company->execute();
$result_company = $stmt_company->get_result();

if ($result_company->num_rows == 0) {
    echo "Company not found.";
    exit();
}

$user = $result_company->fetch_assoc();

// Fetch job details
$sql = "SELECT j.id, j.title, j.description, j.requirements, j.salary, j.deadline, j.category, u.name AS company_name, u.email 
        FROM jobs j 
        JOIN users u ON j.company_id = u.id 
        WHERE j.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Job not found.";
    exit();
}

$job = $result->fetch_assoc();

// Fetch applicants
$sql_applicants = "SELECT a.id AS application_id, u.id AS user_id, u.name, a.status 
                   FROM applications a 
                   JOIN users u ON a.user_id = u.id 
                   WHERE a.job_id = ?";
$stmt_applicants = $conn->prepare($sql_applicants);
$stmt_applicants->bind_param("i", $job_id);
$stmt_applicants->execute();
$result_applicants = $stmt_applicants->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>About Job</title>
    <link rel="stylesheet" type="text/css" href="../CSS/about-job.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header"></div>
        <div class="log-out"><a href="../logout.php">Log out</a></div>
        <h1>Applicants</h1>
        <div class="posting">
            <div class="post-1">
                <div class="foto">
                    <p>Disini Foto</p>
                </div>
                <div class="teks">
                    <span>Nama pekerjaan: <?php echo htmlspecialchars($job['title']); ?></span><br>
                    <span>Gaji: Rp. <?php echo number_format($job['salary'], 2); ?> / Jam</span><br>
                    <span>Deadline: <?php echo htmlspecialchars($job['deadline']); ?></span><br>
                </div>
                <hr>
                <div class="delete"><a href="delete-pekerjaan.php?id=<?php echo $job['id']; ?>">Hapus pekerjaan</a></div>
                <table width="600px" align="center" cellspacing="30px">
                    <?php
                    if ($result_applicants->num_rows > 0) {
                        while ($applicant = $result_applicants->fetch_assoc()) {
                            echo "<tr id='applicant-{$applicant['application_id']}'>";
                            echo "<td><font>" . htmlspecialchars($applicant['name']) . "</font><hr></td>";
                            echo "<td width='200px' valign='top'>";

                            if ($applicant['status'] == 'Pending') {
                                echo "<div class='decline'><a href='decline_application.php?id=" . $applicant['application_id'] . "'>Decline</a></div>";
                                echo "<div class='accept'><a href='accept_application.php?id=" . $applicant['application_id'] . "'>Accept</a></div>";
                            } elseif ($applicant['status'] == 'Accepted') {
                                echo "<div class='accepted'><button disabled>Accepted</button></div>";
                            } elseif ($applicant['status'] == 'Declined') {
                                echo "<div class='declined'><button disabled>Declined</button></div>";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No applicants yet.</td></tr>";
                    }
                    $stmt_applicants->close();
                    ?>
                </table>
                <div class="back-link" style="text-align: center; margin-top: 20px;">
                  <a href="comp-home.php" style="color:white; text-decoration: none; font-size: 16px;">Back to Home</a>
                </div>
            </div>
        </div>
        <div class="profile">
            <div class="foto-profil">
                <img src="../uploads/<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Foto Profil">
            </div>
            <div class="keterangan">
                <a href="profile-comp.php"><?php echo htmlspecialchars($user['name']); ?></a>
            </div>
            <div class="post-job">
                <a href="post-job.php">Post a Job</a>
            </div>

        </div>
        
    </div>
</body>
</html>

<?php
$conn->close();
?>
