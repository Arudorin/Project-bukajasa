<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $email = $_POST['email'];
    $name = $_POST['name'];

    // Check if username is already in use
    $check_username = "SELECT * FROM users WHERE username = '$username'";
    $result_username = $conn->query($check_username);
    if ($result_username->num_rows > 0) {
        $error_message = "Username already exists.";
    }

    // Check if email is already in use
    $check_email = "SELECT * FROM users WHERE email = '$email'";
    $result_email = $conn->query($check_email);
    if ($result_email->num_rows > 0) {
        $error_message = "Email already exists.";
    }

    // If no error, proceed with insertion
    if (!isset($error_message)) {
        $sql = "INSERT INTO users (username, password, role, email, name) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $username, $password, $role, $email, $name);

        if ($stmt->execute()) {
            header("Location: home.html");
            exit();
        } else {
            $error_message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="CSS/sign-up.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var errorMessage = "<?php echo isset($error_message) ? $error_message : ''; ?>";
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
</head>
<body>
    <!-- Your HTML content -->
    <div class="container">
        <div class="header"></div>
        <div class="isi">
            <div class="judul"><h1>Sign Up</h1></div>
        </div>
        <div class="form">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <table>
                    <tr>
                        <td width="150px"><label for="username">Username<span>*</span></label></td>
                        <td><input id="form-teks" type="text" name="username" placeholder="Username" required></td>
                    </tr>
                    <tr>
                        <td><label for="email">Email<span>*</span></label></td>
                        <td><input id="form-teks" type="email" name="email" placeholder="Email" autocomplete="off" required></td>
                    </tr>
                    <tr>
                        <td><label for="name">Nama Lengkap<span>*</span></label></td>
                        <td><input id="form-teks" type="text" name="name" placeholder="Nama Lengkap" required></td>
                    </tr>
                    <tr>
                        <td><label for="password">Password<span>*</span></label></td>
                        <td><input id="form-teks" type="password" name="password" placeholder="Password" required></td>
                    </tr>
                    <tr>
                        <td><label for="re-password">Re-Password<span>*</span></label></td>
                        <td><input id="form-teks" type="password" name="re-password" placeholder="Re-Password" required></td>
                    </tr>
                    <tr>
                        <td><label for="role">Role<span>*</span></label></td>
                        <td>
                            <select id="form-teks" name="role" required>
                                <option value="Mahasiswa">Mahasiswa</option>
                                <option value="Perusahaan">Perusahaan</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <input id="submit" type="submit" name="submit" value="Submit" class="submit">
            </form>
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
