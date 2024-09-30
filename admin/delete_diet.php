<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $diet_id = $_POST['id'];

    // Delete diet record from the diet table
    $sql = "DELETE FROM diet WHERE id = $diet_id";

    if ($connect->query($sql) === TRUE) {
        echo "<script>alert('Diet plan deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting diet plan: " . $connect->error . "');</script>";
    }

    // Redirect back to the diet list page
    echo "<script>window.location.href = 'diet_list.php';</script>";
} else {
    echo "Invalid request.";
}
?>