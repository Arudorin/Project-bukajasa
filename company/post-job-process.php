<?php
session_start();
include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['role'] == 'Perusahaan') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];
    $salary = $_POST['salary'];
    $deadline = $_POST['deadline'];
    $category = $_POST['category'];
    $company_id = $_SESSION['user_id'];

    $sql = "INSERT INTO jobs (title, description, requirements, salary, deadline, category, company_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $title, $description, $requirements, $salary, $deadline, $category, $company_id);

    if ($stmt->execute()) {
        header("Location: comp-home.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Unauthorized access.";
}
?>
