<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Mahasiswa') {
    echo "You must be logged in as a student to view this page.";
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $profile_picture = '';

    if (!empty($_FILES['profile_picture']['name'])) {
        $profile_picture = basename($_FILES['profile_picture']['name']);
        $target_dir = "../uploads/";
        $target_file = $target_dir . $profile_picture;

        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
            // File uploaded successfully
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET name=?, email=?, username=?, password=?, profile_picture=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $name, $email, $username, $password, $profile_picture, $user_id);
    } else {
        $sql = "UPDATE users SET name=?, email=?, username=?, profile_picture=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $name, $email, $username, $profile_picture, $user_id);
    }

    if ($stmt->execute()) {
        echo "Profile updated successfully.";
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}

$sql = "SELECT name, email, username, profile_picture FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="../CSS/edit-mahasiswa.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
</head>
<body>

    <div class="container">
        <h1>Edit Profile</h1>
        <div class="profile-pic">
            <img src="../uploads/<?php echo $user['profile_picture']; ?>" alt="Profile Picture">
            <input type="file" name="profile_picture" form="edit-profile-form">
        </div>
        
        <form id="edit-profile-form" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password (leave blank if you do not want to change it)</label>
                <input type="password" id="password" name="password">
            </div>
            <button type="submit">Update Profile</button>
        </form>

        <div class="back-link">
            <a href="profile-mahasiswa.php">Back to Profile</a>
        </div>
    </div>

</body>
</html>

<?php
$conn->close();
?>
