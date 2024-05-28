<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="CSS/student-home.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
</head>
<body>

    <div class="container">

        <div class="header">
        </div>

        <div class="log-out"><a href="home1.html">Log out</a></div>

        <div class="posting">
            <?php
            include 'db_connection.php';

            $sql = "SELECT jobs.id, jobs.title, jobs.description, jobs.requirements, jobs.salary, jobs.deadline, users.username AS company 
                    FROM jobs 
                    JOIN users ON jobs.company_id = users.id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='post-1'>";
                    echo "<div class='foto'><p>Disini Foto</p></div>";
                    echo "<div class='teks'>";
                    echo "<a href='apply-job.php?job_id=" . $row['id'] . "'>" . $row['title'] . "</a><br>";
                    echo "<span>Company: " . $row['company'] . "<br></span>";
                    echo "<span>Requirements: " . $row['requirements'] . "</span>";
                    echo "<ul>";
                    echo "<li>" . $row['description'] . "</li>";
                    echo "</ul>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "No jobs available.";
            }

            $conn->close();
            ?>
        </div>

        <div class="profile">
            <div class="foto-profil">
                <p>Disini Foto profil</p>
            </div>
            <div class="keterangan">
                <a href="profile-mahasiswa.html">Nama Profil</a>
            </div>
        </div>

    </div>

</body>
</html>
