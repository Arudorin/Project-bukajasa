<?php
session_start();

// Include database connection or configuration file
include '../db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../login.php");
    exit();
}

$company_id = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($company_id)) {
    echo "Invalid company ID.";
    exit();
}

// Fetch company details
$sql = "SELECT * FROM users WHERE id = ? AND role = 'Perusahaan'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $company_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Company not found.";
    exit();
}

$company = $result->fetch_assoc();

// Perform deletion
$sql_delete = "DELETE FROM users WHERE id = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("i", $company_id);

if ($stmt_delete->execute()) {
    $message = "Company '" . $company['name'] . "' (ID: " . $company_id . ") has been deleted.";
} else {
    $error_message = "Error deleting company: " . $conn->error;
}

$stmt->close();
$stmt_delete->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Perusahaan</title>
    <script>
        // Function to display delete message
        function displayDeleteMessage() {
            var message = "<?php echo isset($message) ? htmlspecialchars($message) : ''; ?>";
            if (message) {
                alert(message);
            } else {
                var errorMessage = "<?php echo isset($error_message) ? htmlspecialchars($error_message) : 'Error deleting company.'; ?>";
                alert(errorMessage);
            }
            window.location.href = "admin-perusahaan.php"; // Redirect to admin page
        }

        // Call the function when the page loads
        window.onload = displayDeleteMessage;
    </script>
</head>
<body>
</body>
</html>
