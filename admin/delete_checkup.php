<?php

include 'connect.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $checkupId = intval($_POST['id']);

    $sql = "DELETE FROM health WHERE id = $checkupId";


    if ($connect->query($sql) === TRUE) {

        header("Location: admin_checkup_list.php?delete_success=1");
        exit();
    } else {
        echo "Error deleting record: " . $connect->error;
    }

    $connect->close();
} else {

    header("Location: admin_checkup_list.php");
    exit();
}
?>