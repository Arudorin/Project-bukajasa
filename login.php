<?php
session_start();

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bukajasa";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password, $role);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Set session variables
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            // Redirect based on role
            if ($role == 'Mahasiswa') {
                header("Location: student/student-home.php");
            } elseif ($role == 'Perusahaan') {
                header("Location: company/comp-home.php");
            } elseif ($role == 'Admin') {
                header("Location: Admin/admin-home.php");   
            } else {
                echo "Invalid role";
            }
            exit();
        } else {
            echo "Invalid password";
        }
    } else {
        echo "No user found with that username";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Log in</title>
    <link rel="stylesheet" type="text/css" href="CSS/Stylelogin.css">
</head>
<body>
    <div class="container">
        <div class="header"></div>
        <div class="konten">
            <form action="login.php" method="post">
                <input id="text-box" type="text" name="username" placeholder="username" required>
                <input id="text-box" type="password" name="password" placeholder="password" required>
                <input id="submit" type="submit" name="submit" value="Log In">
            </form>
        </div>
        <div class="footer">
            <p>BukaJasa</p>
        </div>
    </div>
</body>
</html>
