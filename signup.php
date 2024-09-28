<?php
include 'connect.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];


    if ($password != $cpassword) {
        echo "Passwords do not match!";
        exit();
    }


    $hashed_password = password_hash($password, PASSWORD_BCRYPT);


    $checkUser = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = $connect->query($checkUser);

    if ($result->num_rows > 0) {
        echo "<script>alert('Username or email already exists!');</script>";
    } else {

        $sql = "INSERT INTO users (firstname, lastname, address, tel, email, username, password) 
            VALUES ('$firstname', '$lastname', '$address', '$tel', '$email', '$username', '$hashed_password')";

        if ($connect->query($sql) === TRUE) {
            echo "<script>alert('Registration successful!');</script>";
            header("Location: signin.php");
            exit();

        } else {
            echo "Error: " . $connect->error;
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
    <title>Signup Form</title>
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
        input[type="email"],
        input[type="tel"],
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

        input[type="reset"] {
            background-color: #f44336;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 10px;
        }

        input[type="reset"]:hover {
            background-color: #e41e1e;
        }
    </style>
    <script>

        function validatePassword() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('cpassword').value;

            if (password !== confirmPassword) {
                alert('Passwords do not match.');
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <h3>Signup Form</h3>
    <form method="POST" action="signup.php" onsubmit="return validatePassword()">
        <div class="form-group">
            <label for="fname">First name:</label>
            <input type="text" name="firstname" id="fname" placeholder="First name" required>
        </div>

        <div class="form-group">
            <label for="lname">Last name:</label>
            <input type="text" name="lastname" id="lname" placeholder="Last name" required>
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" name="address" id="address" placeholder="Address" required>
        </div>

        <div class="form-group">
            <label for="tel">Mobile number:</label>
            <input type="tel" name="tel" id="tel" placeholder="Mobile number" required>
        </div>

        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" placeholder="E-mail" required>
        </div>

        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" placeholder="Username" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Password" required>
        </div>

        <div class="form-group">
            <label for="cpassword">Confirm Password:</label>
            <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password" required>
        </div>

        <div class="form-group">
            <input type="reset" value="Reset">
            <button type="submit" class="btn btn-primary">SignUp</button>
        </div>
    </form>
</body>

</html>