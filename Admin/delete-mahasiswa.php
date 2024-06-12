<?php
session_start();

// Include database connection or configuration file
include '../db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../login.php");
    exit();
}

$user_id = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($user_id)) {
    echo "Invalid user ID.";
    exit();
}

// Fetch user details
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "User not found.";
    exit();
}

$user = $result->fetch_assoc();

// Perform deletion
$sql_delete = "DELETE FROM users WHERE id = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("i", $user_id);

if ($stmt_delete->execute()) {
    $message = "User '" . $user['name'] . "' (ID: " . $user_id . ") has been deleted.";
} else {
    $error_message = "Error deleting user: " . $conn->error;
}

$stmt->close();
$stmt_delete->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Mahasiswa</title>
    <script>
        // Function to display delete message
        function displayDeleteMessage() {
            var message = "<?php echo isset($message) ? htmlspecialchars($message) : ''; ?>";
            if (message) {
                alert(message);
            } else {
                var errorMessage = "<?php echo isset($error_message) ? htmlspecialchars($error_message) : 'Error deleting user.'; ?>";
                alert(errorMessage);
            }
            window.location.href = "admin-mahasiswa.php"; // Redirect to admin page
        }

        // Call the function when the page loads
        window.onload = displayDeleteMessage;
    </script>
</head>
<body>
</body>
</html>
