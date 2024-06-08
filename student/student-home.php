<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Mahasiswa') {
    echo "You must be logged in as a student to view this page.";
    exit();
}

// Get selected category
$selected_category = isset($_POST['category']) ? $_POST['category'] : '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="../CSS/student-home.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
</head>
<body>

    <div class="container">

        <div class="header">
        </div>

        <div class="log-out"><a href="../logout.php">Log out</a></div>

        <div class="filter">
            <form method="POST" action="">
                <label for="category">Filter by Category:</label>
                <select id="category" name="category" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <option value="Akuntansi/Keuangan" <?php if ($selected_category == 'Akuntansi/Keuangan') echo 'selected'; ?>>Akuntansi/Keuangan</option>
                    <option value="Administrasi/Personalia" <?php if ($selected_category == 'Administrasi/Personalia') echo 'selected'; ?>>Administrasi/Personalia</option>
                    <option value="Seni/Media/Komunikasi" <?php if ($selected_category == 'Seni/Media/Komunikasi') echo 'selected'; ?>>Seni/Media/Komunikasi</option>
                    <option value="Komputer/IT" <?php if ($selected_category == 'Komputer/IT') echo 'selected'; ?>>Komputer/IT</option>
                    <option value="Pendidikan" <?php if ($selected_category == 'Pendidikan') echo 'selected'; ?>>Pendidikan</option>
                    <option value="Hotel" <?php if ($selected_category == 'Hotel') echo 'selected'; ?>>Hotel</option>
                    <option value="Restaurant" <?php if ($selected_category == 'Restaurant') echo 'selected'; ?>>Restaurant</option>
                    <option value="Marketing" <?php if ($selected_category == 'Marketing') echo 'selected'; ?>>Marketing</option>
                    <option value="Lainnya" <?php if ($selected_category == 'Lainnya') echo 'selected'; ?>>Lainnya</option>
                </select>
            </form>
        </div>

        <div class="posting">
            <?php
            if ($selected_category) {
                $sql = "SELECT id, title, description, requirements, salary, deadline, category FROM jobs WHERE category = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $selected_category);
            } else {
                $sql = "SELECT id, title, description, requirements, salary, deadline, category FROM jobs";
                $stmt = $conn->prepare($sql);
            }
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='post-1'>";
                    echo "<div class='foto'><p>Disini Foto</p></div>";
                    echo "<div class='teks' style='padding-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px;'>";
                    echo "<a href='apply-job.php?id=" . $row['id'] . "'>" . $row['title'] . "</a><br>";
                    echo "<span>Kategori: " . $row['category'] . "</span><br>";
                    echo "<span>Persyaratan Pekerjaan: " . $row['requirements'] . "</span><br>";
                    echo "<span>Gaji: Rp." . $row['salary'] . " / Jam</span><br>";
                    echo "<span>Deadline: " . $row['deadline'] . "</span><br>";
                    echo "</div></div>";
                }
            } else {
                echo "No jobs available.";
            }

            $stmt->close();
            $conn->close();
            ?>
        </div>

        <div class="profile">
            <div class="foto-profil"><p>Disini Foto profil</p></div>
            <div class="keterangan">
                <a href="profile-mahasiswa.html">Nama Profil</a>
            </div>
        </div>

    </div>

</body>
</html>
