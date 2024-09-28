<?php

include 'connect.php';
include 'components/header.php';



if (!isset($_SESSION['username']) || !isset($_SESSION['uid'])) {
    header("Location: ../signin.php");
    exit();
}

$uid = $_SESSION['uid'];
$sql = "SELECT * FROM users WHERE id='$uid'";
$result = $connect->query($sql);

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Error fetching user data: " . $connect->error; // Add error message if fetch fails
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update profile
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];

    $updateSql = "UPDATE users SET firstname='$firstname', lastname='$lastname', address='$address', tel='$tel', email='$email' WHERE id='$uid'"; // Use id for the update

    if ($connect->query($updateSql) === TRUE) {
        echo "<script>alert('Profile updated successfully!');</script>";
        header("Location: profile.php");
        exit();
    } else {
        echo "Error: " . $connect->error;
    }
}

if (isset($_GET['change_password'])) {
    $current_password = $_GET['current_password'];
    $new_password = $_GET['new_password'];
    $confirm_password = $_GET['confirm_password'];

    if (password_verify($current_password, $user['password'])) {
        if ($new_password === $confirm_password) {
            $hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);
            $updatePasswordSql = "UPDATE users SET password='$hashed_new_password' WHERE id='$uid'"; // Use id for the update
            if ($connect->query($updatePasswordSql) === TRUE) {
                echo "<script>alert('Password updated successfully!');</script>";
                header("Location: profile.php");
                exit();
            } else {
                echo "Error: " . $connect->error;
            }
        } else {
            echo "<script>alert('New passwords do not match!');</script>";
        }
    } else {
        echo "<script>alert('Current password is incorrect!');</script>";
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

        .password-change {
            margin-top: 30px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 8px;
            display: none;
            /* Initially hidden */
        }

        .error {
            color: red;
            margin-top: 5px;
            display: none;
        }
    </style>
    <script>
        function validatePasswords() {
            const newPassword = document.getElementById("new_password").value;
            const confirmPassword = document.getElementById("confirm_password").value;
            const errorMsg = document.getElementById("error-message");
            const submitButton = document.getElementById("submit-password-change");

            if (newPassword !== confirmPassword) {
                errorMsg.textContent = "New passwords do not match!";
                errorMsg.style.display = "block";
                submitButton.disabled = true;
            } else {
                errorMsg.style.display = "none";
                submitButton.disabled = false;
            }
        }

        function togglePasswordChange() {
            const checkbox = document.getElementById("change-password-checkbox");
            const passwordChangeSection = document.querySelector(".password-change");
            passwordChangeSection.style.display = checkbox.checked ? "block" : "none";
        }
    </script>
</head>

<body>
    <div class="content">
        <h1>Profile Page</h1>
        <form method="POST" action="profile.php">
            <div class="form-group">
                <label for="firstname">First Name:</label>
                <input type="text" name="firstname" id="firstname" value="<?php echo $user['firstname'] ?? ''; ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="lastname">Last Name:</label>
                <input type="text" name="lastname" id="lastname" value="<?php echo $user['lastname'] ?? ''; ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" value="<?php echo $user['address'] ?? ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="tel">Mobile Number:</label>
                <input type="tel" name="tel" id="tel" value="<?php echo $user['tel'] ?? ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" value="<?php echo $user['email'] ?? ''; ?>" required>
            </div>
            <div class="form-group">
                <button type="submit">Update Profile</button>
            </div>
        </form>

        <div class="form-group">
            <input type="checkbox" id="change-password-checkbox" onclick="togglePasswordChange()">
            <label for="change-password-checkbox">Change Password</label>
        </div>

        <div class="password-change">
            <h2>Change Password</h2>
            <form method="GET" action="profile.php">
                <div class="form-group">
                    <label for="current_password">Current Password:</label>
                    <input type="password" name="current_password" id="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" name="new_password" id="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password:</label>
                    <input type="password" name="confirm_password" id="confirm_password" onkeyup="validatePasswords()"
                        required>
                </div>
                <div class="error" id="error-message"></div>
                <div class="form-group">
                    <button type="submit" name="change_password" id="submit-password-change">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>