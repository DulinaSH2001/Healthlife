<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id'];
    $action = $_POST['action'];




    $sql = "UPDATE diet SET action = '$action' WHERE id = $id";

    if ($connect->query($sql) === TRUE) {
        echo "<script>alert('Diet action updated successfully!'); window.location.href = 'diet_list.php';</script>";
    } else {
        echo "<script>alert('Error updating diet action: " . $connect->error . "');</script>";
    }
}

$connect->close();
?>