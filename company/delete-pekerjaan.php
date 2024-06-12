<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Perusahaan') {
    header("Location: ../login.php");
    exit();
}

$job_id = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($job_id)) {
    echo "Invalid job ID.";
    exit();
}

// Delete related applications first
$sql_delete_applications = "DELETE FROM applications WHERE job_id = ?";
$stmt_delete_applications = $conn->prepare($sql_delete_applications);
$stmt_delete_applications->bind_param("i", $job_id);
$stmt_delete_applications->execute();
$stmt_delete_applications->close();

// Then delete the job itself
$sql_delete_job = "DELETE FROM jobs WHERE id = ?";
$stmt_delete_job = $conn->prepare($sql_delete_job);
$stmt_delete_job->bind_param("i", $job_id);

if ($stmt_delete_job->execute()) {
    $message = "Job has been deleted successfully.";
} else {
    $error_message = "Error deleting job: " . $conn->error;
}

$stmt_delete_job->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Pekerjaan</title>
    <script>
        function displayDeleteMessage() {
            var message = "<?php echo isset($message) ? htmlspecialchars($message) : ''; ?>";
            if (message) {
                alert(message);
            } else {
                var errorMessage = "<?php echo isset($error_message) ? htmlspecialchars($error_message) : 'Error deleting job.'; ?>";
                alert(errorMessage);
            }
            window.location.href = "comp-home.php"; // Redirect to admin page
        }
        window.onload = displayDeleteMessage;
    </script>
</head>
<body>
</body>
</html>
