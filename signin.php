<?php
session_start();

include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to find the user in the users table
    $sql = "SELECT * FROM users WHERE username='$username' OR email='$username'";
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            // Set session variables for regular user
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['firstname'] = $row['firstname'];
            $_SESSION['uid'] = $row['id'];

            echo "<script>console.log('Login successful!');</script>";

            header("Location: client/home.php");
            exit();
        } else {
            echo "<script>alert('Invalid password!');</script>";
        }
    } else {

        $adminSql = "SELECT * FROM admin WHERE username='$username' OR email='$username'";
        $adminResult = $connect->query($adminSql);

        if ($adminResult->num_rows > 0) {
            $adminRow = $adminResult->fetch_assoc();

            if (password_verify($password, $adminRow['password'])) {

                $_SESSION['admin_username'] = $adminRow['username'];
                $_SESSION['admin_email'] = $adminRow['email'];
                $_SESSION['admin_id'] = $adminRow['id'];

                echo "<script>console.log('Admin login successful!');</script>";

                header("Location: admin/dashboard.php");
                exit();
            } else {
                echo "<script>alert('Invalid password for admin!');</script>";
            }
        } else {
            echo "<script>alert('No user found with this username or email!');</script>";
        }
    }
}

$connect->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            background-color: #f0f8ff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            width: 300px;
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
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
        input[type="password"] {
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
    <h3>Login</h3>
    <form method="POST" action="signin.php">
        <div class="form-group">
            <label for="username">Username or Email:</label>
            <input type="text" name="username" id="username" placeholder="Enter your username or email" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Enter your password" required>
        </div>

        <button type="submit">Login</button>
    </form>
</body>

</html>