<?php
include 'connect.php';
$contact_id = $_POST['contact_id'];
$reply = $_POST['reply'];

// Update the contact message with admin's reply
$sql = "UPDATE contact_us SET reply = '$reply', status = 'replied', replied_at = NOW() WHERE id = '$contact_id'";
if ($connect->query($sql) === TRUE) {
    echo "Reply sent.";
} else {
    echo "There was an error: " . $connect->error;
}

$connect->close();
?>