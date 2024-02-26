<?php session_start(); ?>
<?php session_destroy(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 100px;
        }
        h1 {
            color: #FF0000; /* Red color for emphasis */
        }
    </style>
    <script>
        // Clear session and redirect to index.php after 5 seconds
        setTimeout(function() {
            // Clear session (replace this with your actual session clearing code)
            // Example: sessionStorage.clear(); // For client-side session
            //          session_unset(); // For server-side session

            // Redirect to index.php
            window.location.href = '../index.html';
        }, 5000);
    </script>
</head>
<body>
    <h1>ออกจากระบบสำเร็จ</h1>
    <p>คุณออกจากระบบแล้ว คุณจะถูกนำไปที่หน้าแรกภายใน 5 วินาที.</p>
    <p>หากคุณไม่ถูกเปลี่ยนเส้นทาง, <a href="../index.html">คลิกที่นี่</a>.</p>
</body>
</html>
