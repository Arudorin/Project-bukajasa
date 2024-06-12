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

    $sql = "INSERT INTO users (username, password, role, email, name) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username, $password, $role, $email, $name);

    if ($stmt->execute()) {
        header("Location: home.html");
        exit();
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="CSS/sign-up.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header">
        </div>
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
            <?php
            if (isset($error)) {
                echo "<span>$error</span>";
            }
            ?>
        </div>
    </div>
</body>
</html>
