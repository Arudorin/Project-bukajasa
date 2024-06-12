<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Perusahaan') {
    echo "You must be logged in as a company to view this page.";
    exit();
}

$company_id = $_SESSION['user_id'];

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

$company = $result_company->fetch_assoc();

// Fetch jobs posted by the company
$sql_jobs = "SELECT j.id, j.title, j.category, j.requirements, COUNT(a.id) as applicant_count
             FROM jobs j
             LEFT JOIN applications a ON j.id = a.job_id
             WHERE j.company_id = ?
             GROUP BY j.id";
$stmt_jobs = $conn->prepare($sql_jobs);
$stmt_jobs->bind_param("i", $company_id);
$stmt_jobs->execute();
$result_jobs = $stmt_jobs->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile Perusahaan</title>
    <link rel="stylesheet" type="text/css" href="../CSS/profile-comp.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
</head>
<body>

    <div class="container">
        <div class="header">
        </div>

        <div class="teks">
            <p><?php echo $company['name']; ?></p>
            <p><?php echo $company['email']; ?></p>
        </div>

        <div id="edit">
            <a href="edit-comp.php">Edit</a>
        </div>
        <div id="logout">
            <a href="../logout.php">Logout</a>
        </div>

        <div class="bawah">
            <table width="900px" align="center" cellspacing="10px">
                <?php
                if ($result_jobs->num_rows > 0) {
                    while ($row = $result_jobs->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><a href='about-job.php?id={$row['id']}'><font>{$row['title']}</font></a><hr></td>";
                        echo "<td width='150px'><font>{$row['applicant_count']} Applicant(s)</font><hr></td>";
                        echo "<td width='150px'><a href='delete-job.php?id={$row['id']}'><button>Delete</button></a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No jobs posted.</td></tr>";
                }

                $stmt_jobs->close();
                $conn->close();
                ?>
            </table>
        </div>
    </div>

</body>
</html>
