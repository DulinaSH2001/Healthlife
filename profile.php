<?php

include 'connect.php';
include 'header.php';


if (!isset($_SESSION['username'])) {
    header("Location: signin.php");
    exit();
}


$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username='$username'";
$result = $connect->query($sql);
$user = $result->fetch_assoc();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];

    $updateSql = "UPDATE users SET firstname='$firstname', lastname='$lastname', address='$address', tel='$tel', email='$email' WHERE username='$username'";

    if ($connect->query($updateSql) === TRUE) {
        echo "<script>alert('Profile updated successfully!');</script>";
        header("Location: profile.php");
    } else {
        echo "Error: " . $connect->error;
    }
}

$connect->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f8ff;
        }

        .content {
            margin: 20px;
            max-width: 600px;
            margin: auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <div class="content">
        <h1>Profile Page</h1>
        <form method="POST" action="profile.php">
            <div class="form-group">
                <label for="firstname">First Name:</label>
                <input type="text" name="firstname" id="firstname" value="<?php echo $user['firstname']; ?>" required>
            </div>

            <div class="form-group">
                <label for="lastname">Last Name:</label>
                <input type="text" name="lastname" id="lastname" value="<?php echo $user['lastname']; ?>" required>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" value="<?php echo $user['address']; ?>" required>
            </div>

            <div class="form-group">
                <label for="tel">Mobile Number:</label>
                <input type="tel" name="tel" id="tel" value="<?php echo $user['tel']; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" value="<?php echo $user['email']; ?>" required>
            </div>

            <div class="form-group">
                <button type="submit">Update Profile</button>
            </div>
        </form>
    </div>

</body>

</html>