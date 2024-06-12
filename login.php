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

$error_message = "";

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
                $error_message = "Invalid role";
            }
            exit();
        } else {
            $error_message = "Invalid password";
        }
    } else {
        $error_message = "No user found with that username";
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var errorMessage = "<?php echo $error_message; ?>";
            if (errorMessage) {
                var modal = document.getElementById("error-modal");
                var modalMessage = document.getElementById("modal-message");
                modalMessage.innerText = errorMessage;
                modal.style.display = "block";
            }
        });

        function closeModal() {
            var modal = document.getElementById("error-modal");
            modal.style.display = "none";
        }
    </script>
    <style>
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 300px;
            text-align: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
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

    <!-- The Modal -->
    <div id="error-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p id="modal-message"></p>
        </div>
    </div>
</body>
</html>
