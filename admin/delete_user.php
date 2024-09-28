<?php
session_start();


if (!isset($_SESSION['admin_username'])) {
    header("Location: ../signin.php");
    exit();
}


include 'connect.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $user_id = intval($_POST['user_id']);

    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {

        header("Location: userManage.php");
        exit();
    } else {
        echo "Error deleting user: " . $stmt->error;
    }
}

$connect->close();
?>