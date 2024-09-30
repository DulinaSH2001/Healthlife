<?php

include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $checkupId = $_POST['id'];
    $action = $_POST['action'];


    $sql = "UPDATE health SET action = '$action' WHERE id = $checkupId";


    if ($connect->query($sql) === TRUE) {

        header("Location: admin_checkup_list.php?success=1");
        exit();
    } else {
        echo "Error updating action: " . $connect->error;
    }


    $connect->close();
} else {

    header("Location: admin_checkup_list.php");
    exit();
}
?>