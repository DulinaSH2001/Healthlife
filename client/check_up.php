<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Check-Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
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
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .payment-button {
            position: static;
            right: 20px;
            bottom: 20px;
        }

        .payment-form {
            display: none;
            margin-top: 20px;
        }

        .payment-form input {
            margin-bottom: 10px;
        }

        .card-details {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            max-width: 40%;
        }
    </style>
    <script>
        function showPaymentForm() {
            document.getElementById("payment-form").style.display = "block";
            document.getElementById("payment-button").style.display = "none";
        }
        function check_card_number_length() {
            var card_number = document.getElementById("card-number").value;
            if (card_number.length < 16) {
                alert("Card number must be 16 digits!");
                return false;
            }
        }

        function formatCardNumber() {
            var cardNumberInput = document.getElementById("card-number");
            cardNumberInput.addEventListener("input", function (e) {
                var value = cardNumberInput.value.replace(/\s+/g, '');
                var formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
                cardNumberInput.value = formattedValue;
            });
        }
        function showPrice() {
            var paymentButton = document.getElementById("payment-button");
            paymentButton.innerHTML = "Proceed to Payment (Rs 2000)";
        }

        document.addEventListener("DOMContentLoaded", showPrice);





        document.addEventListener("DOMContentLoaded", formatCardNumber);

    </script>
</head>

<body>
    <?php include 'components/header.php'; ?>


    <h1>Health Check-Up</h1>




    <form method="POST" action="check_up.php">
        <div class="card-details">
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select name="gender" id="gender" style="width: 120px;" required>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" name="age" id="age" min="1" max="120" style="width: 120px;" min="10" max="120"
                    required>
            </div>

            <div class="form-group">
                <label for="height">Height :</label>
                <input type="number" name="height" id="height" step="0.01" min="70.00" style="width: 120px;" required>
                <span>cm</span>
            </div>

            <div class="form-group">
                <label for="weight">Weight :</label>
                <input type="number" name="weight" id="weight" step="0.01" min="10.00" required style="width: 120px;">
                <span>Kg</span>
            </div>


            <div class="payment-button">
                <button type="button" id="payment-button" onclick="showPaymentForm()">Proceed to Payment</button>
            </div>
        </div>


        <div class="payment-form" id="payment-form" style="display: none;">
            <h2>Payment Details</h2>
            <div class="card-details">
                <div class="form-group">
                    <label for="card-name">Name on Card:</label>
                    <input type="text" id="card-name" name="card-name" style="width: 350px;" required>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="text" value="Rs.2000.00" readonly style="width: 300px;" disabled>
                    <input type="hidden" id="price" name="price" value="2000" style="width: 350px;">
                </div>

                <div class="form-group">
                    <label for="card-number">Card Number:</label>
                    <input type="text" id="card-number" name="card-number" maxlength="19" style="width: 350px;"
                        required>
                </div>

                <div class="form-group">
                    <label for="expiry-date">Expiry Date:</label>
                    <input type="text" id="expiry-date" name="expiry-date" placeholder="MM/YY" maxlength="5"
                        style="width: 200px;" required>
                </div>


                <div class="form-group">
                    <label for="cvv">CVV:</label>
                    <input type="text" id="cvv" name="cvv" maxlength="3" style="width: 200px;" required>
                </div>

                <button type="submit">Make Payment</button>
            </div>
        </div>
    </form>
</body>

<?php

include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];

    // Sanitize inputs for payment details
    $card_name = $_POST['card-name'];
    $price = $_POST['price'];
    $card_number = $_POST['card-number'];
    $expiry_date = $_POST['expiry-date'];
    $cvv = $_POST['cvv'];



    $card_number = str_replace(' ', '', $card_number);
    $masked_card_number = str_repeat('*', 12) . substr($card_number, -4);


    $user_id = $_SESSION['uid'];
    $sql_health = "INSERT INTO health (user_id, gender, age, height, weight) 
                   VALUES ('$user_id', '$gender', '$age', '$height', '$weight')";


    if ($connect->query($sql_health) === TRUE) {

        $health_id = $connect->insert_id;
        $sql_payment = "INSERT INTO payment (user_id, health_id, card_name,price, card_number, expiry_date, cvv) 
                VALUES ('$user_id', '$health_id', '$card_name','$price', '$masked_card_number', '$expiry_date', '$cvv')";

        if ($connect->query($sql_payment) === TRUE) {
            echo "<script>alert('Health details and payment successfully saved!');</script>";
        } else {
            echo "<script>alert('Error saving payment details!');</script>";
        }

    } else {
        echo "<script>alert('Error saving health details!');</script>";
    }
}
?>

</html>