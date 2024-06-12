<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin home</title>
    <link rel="stylesheet" type="text/css" href="../CSS/Admin/admin-home.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
</head>
<body>

    <div class="container">

        <div class="header">
        </div>

        <div class="log-out"><a href="../logout.php">Log out</a></div>
            
        <div class="posting">
            <table width="500px" cellspacing="10px">
                <tr>
                    <td width="400"><font>Perusahaan</font><hr></td>
                    <td>
                        <a href="admin-perusahaan.php">Edit</a><hr class="hr">
                    </td>
                </tr>
                <tr>
                    <td><font>Mahasiswa</font><hr></td>
                    <td>
                        <a href="admin-mahasiswa.php">Edit</a><hr class="hr">
                    </td>
                </tr>
                <tr>
                    <td><font>Pekerjaan</font><hr></td>
                    <td>
                        <a href="admin-pekerjaan.php">Edit</a><hr class="hr">
                    </td>
                </tr>
            </table>
        </div>
        <hr>
    </div>
</body>
</html>
