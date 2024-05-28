<!-- post_job_process.php -->
<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $company_id = $_SESSION['user_id']; // Pastikan perusahaan sudah login
    $title = $_POST['title'];
    $deadline = $_POST['deadline'];
    $salary = $_POST['salary'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];

    $sql = "INSERT INTO jobs (company_id, title, deadline, salary, description, requirements) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ississ", $company_id, $title, $deadline, $salary, $description, $requirements);

    if ($stmt->execute()) {
        echo "Job posted successfully.";
        header("Location: comp-home.html"); // Redirect ke halaman home perusahaan setelah berhasil
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
