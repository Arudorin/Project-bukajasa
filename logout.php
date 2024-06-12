<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <script>
        // Function to display logout message
        function displayLogoutMessage() {
            alert("Anda telah keluar.");
            window.location.replace("home.html"); // Redirect after showing message
        }

        // Call the function when the page loads
        window.onload = displayLogoutMessage;
    </script>
</head>
<body>
</body>
</html>
