<?php
session_start(); // Start the session to check if user is logged in

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: signin.php"); // Redirect to login page if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            background-color: #4CAF50;
            padding: 10px;
            text-align: right;
        }

        .header a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
        }

        .header a:hover {
            background-color: #45a049;
            color: white;
        }
    </style>
</head>

<body>
    <div class="header">
        <span>Welcome, <?php echo $_SESSION['firstname']; ?>!</span>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </div>
</body>

</html>