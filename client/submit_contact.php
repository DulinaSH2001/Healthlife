<?php
include 'connect.php';
session_start();
$user_id = $_SESSION['uid'];
$message = $_POST['message'];

// Store message in the database
$sql = "INSERT INTO contact_us (user_id, message, status) VALUES ('$user_id', '$message', 'pending')";
if ($connect->query($sql) === TRUE) {
    echo "Your message has been sent.";
} else {
    echo "There was an error: " . $connect->error;
}

$connect->close();
?>