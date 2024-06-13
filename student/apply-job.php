<!DOCTYPE html>
<html>
<head>
    <title>Apply Job</title>
    <link rel="stylesheet" type="text/css" href="../CSS/apply-jobstyle.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const status = "<?php echo isset($_GET['status']) ? $_GET['status'] : ''; ?>";
            if (status === 'Accepted') {
                alert('Anda sudah diterima untuk pekerjaan ini.');
            } else if (status === 'Declined') {
                alert('Anda sudah ditolak untuk pekerjaan ini.');
            } else if (status === 'Pending') {
                alert('Aplikasi Anda sedang dalam proses peninjauan.');
            }
        });
    </script>
</head>
<body>

    <div class="container">

        <div class="header">
        </div>

        <div class="kiri">
            <?php
            session_start();
            include '../db_connection.php';

            if (isset($_GET['id'])) {
                $job_id = $_GET['id'];

                $sql = "SELECT jobs.title, jobs.description, jobs.requirements, jobs.salary, jobs.deadline, jobs.category, users.username AS company 
                        FROM jobs 
                        JOIN users ON jobs.company_id = users.id 
                        WHERE jobs.id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $job_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<span id='sub'>Nama Pekerjaan: " . $row['title'] . "</span><br>";
                    echo "<span id='sub'>Company: " . $row['company'] . "</span><br>";
                    echo "<span id='sub'>Deskripsi Pekerjaan: " . $row['description'] . "</span><br>";
                    echo "<span id='sub'>Persyaratan Pekerjaan: " . $row['requirements'] . "</span><br>";
                    echo "<span id='sub'>Gaji: Rp." . $row['salary'] . " / Jam</span><br>";
                    echo "<span id='sub'>Deadline: " . $row['deadline'] . "</span><br>";
                    echo "<span id='sub'>Kategori: " . $row['category'] . "</span><br><br>";

                    // Memeriksa status aplikasi pengguna
                    $sql_status = "SELECT status FROM applications WHERE job_id = ? AND user_id = ?";
                    $stmt_status = $conn->prepare($sql_status);
                    $stmt_status->bind_param("ii", $job_id, $_SESSION['user_id']);
                    $stmt_status->execute();
                    $result_status = $stmt_status->get_result();

                    if ($result_status->num_rows > 0) {
                        $application = $result_status->fetch_assoc();
                        $status = $application['status'];
                        echo "<script>window.location.href = 'apply-job.php?id=$job_id&status=$status';</script>";
                    }

                    $stmt_status->close();
                } else {
                    echo "Job not found.";
                }

                $stmt->close();
                $conn->close();
            } else {
                echo "No job selected.";
            }
            ?>
            <a href="apply-job-process.php?job_id=<?php echo $job_id; ?>">Apply</a>
        </div>
    </div>

</body>
</html>
