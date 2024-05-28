<!-- apply_job_process.php -->
<?php
session_start();
include 'db_connection.php';

if (isset($_SESSION['user_id']) && isset($_POST['job_id'])) {
    $student_id = $_SESSION['user_id'];
    $job_id = $_POST['job_id'];
    $application_text = $_POST['application_text'];

    $sql = "INSERT INTO applications (job_id, student_id, application_text) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $job_id, $student_id, $application_text);

    if ($stmt->execute()) {
        echo "Application submitted successfully.";
        header("Location: student_home.php"); // Redirect ke halaman home mahasiswa setelah berhasil
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "You must be logged in to apply for a job.";
}
?>
