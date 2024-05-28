<!DOCTYPE html>
<html>
<head>
    <title>Post Job</title>
    <link rel="stylesheet" type="text/css" href="CSS/post-jobstyle.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="Images/title.png">
        </div>

        <div class="isi">
            <div class="judul"><h1>Post a Job</h1></div>
        </div>

        <div class="form">
            <form action="post_job_process.php" method="POST">
                <table>
                    <tr>
                        <td width="180px"><font>Nama Pekerjaan<span>*</span></font></td>
                        <td><input id="form-teks" type="text" name="title" placeholder="Nama Pekerjaan" required></td>
                    </tr>
                    <tr>
                        <td><font>Deadline<span>*</span></font></td>
                        <td>
                            <input id="deadline" type="date" name="deadline" required>
                        </td>
                    </tr>
                    <tr>
                        <td><font>Gaji<span>*</span></font></td>
                        <td>
                            <font>Rp.</font>
                            <input id="gaji" type="number" name="salary" min="1000" max="10000000" placeholder="Gaji" required> / Jam
                        </td>
                    </tr>
                    <tr>
                        <td><font>Deskripsi Pekerjaan<span>*</span></font></td>
                        <td><textarea name="description" placeholder="Deskripsi Pekerjaan" required></textarea></td>
                    </tr>
                    <tr>
                        <td><font>Persyaratan<span>*</span></font></td>
                        <td><textarea name="requirements" placeholder="Persyaratan" required></textarea></td>
                    </tr>
                </table>
                <input id="submit" type="submit" name="submit" value="submit" class="submit">
            </form>
        </div>
    </div>
</body>
</html>
