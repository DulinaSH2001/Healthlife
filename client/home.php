<?php
include 'header.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f8ff;
        }

        .content {
            margin: 20px;
        }

        h1 {
            color: #333;
        }

        p {
            color: #666;
            font-size: 16px;
        }

        .welcome-box {
            background-color: #4CAF50;
            padding: 20px;
            border-radius: 10px;
            color: white;
            text-align: center;
        }

        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 4px;
            margin-top: 20px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <div class="content">
        <h1>Welcome to Your Dashboard</h1>
        <p>This is your home page where you can access various features of the website. Feel free to explore and check
            out the different sections.</p>

        <div class="welcome-box">
            <h2>Hello, <?php echo $_SESSION['firstname']; ?>!</h2>
            <p>Welcome back! You can navigate through the site using the menu above.</p>
            <a href="profile.php" class="button">Go to Profile</a>
        </div>

        <div>
            <h3>Site Features</h3>
            <ul>
                <li>Manage your profile</li>
                <li>Access exclusive content</li>
                <li>Stay updated with the latest news</li>
            </ul>
        </div>
    </div>

</body>

</html>