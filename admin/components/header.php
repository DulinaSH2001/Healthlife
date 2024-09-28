<?php
session_start();


if (!isset($_SESSION['admin_username'])) {
    header("Location: ../../signin.php");
    exit();
}
?>
<header>
    <div class="header-container">
        <h1>Admin Dashboard</h1>
        <div class="admin-info">
            <span>Welcome, <?php echo $_SESSION['admin_username']; ?>!</span>
            <a href="../../logout.php">Logout</a>
        </div>
    </div>
</header>

<style>
    header {
        background-color: #4CAF50;
        color: white;
        padding: 15px 20px;
    }

    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    h1 {
        margin: 0;
    }

    .admin-info {
        font-size: 16px;
    }

    .admin-info a {
        color: white;
        text-decoration: none;
        margin-left: 20px;
    }

    .admin-info a:hover {
        text-decoration: underline;
    }
</style>