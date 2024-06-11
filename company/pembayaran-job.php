<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Perusahaan') {
    echo "You must be logged in as a company to view this page.";
    exit();
}

$application_id = isset($_GET['id']) ? $_GET['id'] : '';
if (empty($application_id)) {
    echo "Invalid application ID.";
    exit();
}

// Get application details
$sql_application = "SELECT a.id AS application_id, a.job_id, u.id AS user_id, u.name, u.email, j.title, j.salary
                    FROM applications a
                    JOIN users u ON a.user_id = u.id
                    JOIN jobs j ON a.job_id = j.id
                    WHERE a.id = ?";
$stmt_application = $conn->prepare($sql_application);
$stmt_application->bind_param("i", $application_id);
$stmt_application->execute();
$result_application = $stmt_application->get_result();

if ($result_application->num_rows == 0) {
    echo "Application not found.";
    exit();
}

$application = $result_application->fetch_assoc();

// Process payment logic here (e.g., update database, send email to user)

// Close statement
$stmt_application->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Accept Application</title>
    <link rel="stylesheet" type="text/css" href="../CSS/accept-application.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="Images/title.png">
        </div>
        <div class="log-out"><a href="../logout.php">Log out</a></div>
        <h1>Application Accepted</h1>
        <div class="application-details">
            <p>Job Title: <?php echo $application['title']; ?></p>
            <p>Applicant Name: <?php echo $application['name']; ?></p>
            <p>Applicant Email: <?php echo $application['email']; ?></p>
            <p>Salary: Rp. <?php echo number_format($application['salary'], 2); ?> / Hour</p>
        </div>
        <!-- Add payment information and options here -->
    </div>
</body>
</html>

<?php
$conn->close();
?>
