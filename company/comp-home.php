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
$sql = "SELECT id, title, category, requirements FROM jobs WHERE company_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $company_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home Company</title>
    <link rel="stylesheet" type="text/css" href="../CSS/comp-home.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
</head>
<body>

    <div class="container">

        <div class="header">
        </div>

        <div class="log-out"><a href="../logout.php">Log out</a></div>

        <div class="posting">
            <div class="post-1">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='post-1'>";
                    echo "<div class='teks'>";
                    echo "<a href='about-job.php?id={$row['id']}' style='display:inline-block;padding:0px 3px;background-color:#26293b;color:white;text-decoration:none;border-radius:4px;border:none;cursor:pointer;transition:background-color 0.3s ease;'>{$row['title']}</a><br>";
                    echo "<span>Kategori: " . $row['category'] . "</span><br>";
                    echo "<span>Persyaratan Pekerjaan: " . $row['requirements'] . "</span><br>";
                    echo "</div><hr></div>";
                }
            } else {
                echo "No jobs posted.";
            }

            $stmt->close();
            $conn->close();
            ?>
            </div>
        </div>


        <div class="profile">
            <div class="foto-profil">
                <img src="../uploads/<?php echo htmlspecialchars($company['profile_picture']); ?>" alt="Foto Profil">
            </div>
            <div class="keterangan">
                <a href="profile-comp.php"><?php echo htmlspecialchars($company['name']); ?></a>
            </div>
        </div>            <div class="post-job">
                <a href="post-job.php">Post a Job</a>
            </div>
        </div>

    </div>

</body>
</html>
