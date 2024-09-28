<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../signin.php");
    exit();
}
?>

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

<header>
    <div class="header">
        <span>Welcome, <?php echo isset($_SESSION['firstname']) ? $_SESSION['firstname'] : 'Guest'; ?>!</span>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </div>
</header>