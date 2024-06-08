<!DOCTYPE html>
<html>
<head>
    <title>Post Job</title>
    <link rel="stylesheet" type="text/css" href="../CSS/post-jobstyle.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
</head>
<body>
    <div class="container">

        <div class="header">
            <img src="../Images/title.png">
        </div>

        <div class="isi">
            <div class="judul"><h1>Post a Job</h1></div>
        </div>

        <div class="form">
            <form action="post-job-process.php" method="post">
                <table>
                    <tr>
                        <td width="180px"><font>Nama Pekerjaan<span>*</span></font></td>
                        <td><input id="form-teks" type="text" name="title" placeholder="Nama" required></td>
                    </tr>
                    <tr>
                        <td width="180px"><font>Kategori<span>*</span></font></td>
                        <td>
                            <select name="category" required>
                                <option value="Akuntansi/Keuangan">Akuntansi/Keuangan</option>
                                <option value="Administrasi/Personalia">Administrasi/Personalia</option>
                                <option value="Seni/Media/Komunikasi">Seni/Media/Komunikasi</option>
                                <option value="Komputer/IT">Komputer/IT</option>
                                <option value="Pendidikan">Pendidikan</option>
                                <option value="Hotel">Hotel</option>
                                <option value="Restaurant">Restaurant</option>
                                <option value="Marketing">Marketing</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><font>Deadline<span>*</span></font></td>
                        <td><input type="date" name="deadline" required></td>
                    </tr>
                    <tr>
                        <td><font>Gaji<span>*</span></font></td>
                        <td>
                            <font>Rp.</font>
                            <input id="gaji" type="number" name="salary" min="1000" max="10000000" placeholder="gaji" required> / Jam
                        </td>
                    </tr>
                    <tr>
                        <td valign="top"><font>Deskripsi</font></td>
                        <td><textarea id="text-area" name="description" placeholder="Deskripsi" required></textarea></td>
                    </tr>
                    <tr>
                        <td valign="top"><font>Persyaratan Pekerjaan</font></td>
                        <td><textarea id="text-area" name="requirements" placeholder="Persyaratan Pekerjaan" required></textarea></td>
                    </tr>
                </table>
                <input id="submit" type="submit" name="submit" value="submit" class="submit">
            </form>
        </div>
    </div>
</body>
</html>
