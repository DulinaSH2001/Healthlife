<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Review</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: auto;
        }

        h2 {
            color: #333;
        }

        textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .stars {
            display: flex;
            gap: 5px;
        }

        .stars input {
            display: none;
        }

        .stars label {
            font-size: 30px;
            cursor: pointer;
            color: #ccc;
        }

        .stars input:checked~label {
            color: #FFD700;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.8;
        }

        .message {
            color: green;
            margin-bottom: 20px;
        }

        .error {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <div class="container">
        <h2>Submit Your Review</h2>





        <form action="review_page.php" method="POST"> <!-- Self-submitting form -->
            <h3>Rating:</h3>
            <div class="stars">
                <input type="radio" name="rating" id="star5" value="5" required>
                <label for="star5">&#9733;</label>
                <input type="radio" name="rating" id="star4" value="4">
                <label for="star4">&#9733;</label>
                <input type="radio" name="rating" id="star3" value="3">
                <label for="star3">&#9733;</label>
                <input type="radio" name="rating" id="star2" value="2">
                <label for="star2">&#9733;</label>
                <input type="radio" name="rating" id="star1" value="1">
                <label for="star1">&#9733;</label>
            </div>

            <textarea name="review" placeholder="Write your review here..." required></textarea>
            <button type="submit">Submit Review</button>
        </form>
    </div>
</body>

</html>


<?php
include 'connect.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user_id = $_SESSION['uid'];

    // Retrieve the review and rating from the POST request
    $review = isset($_POST['review']) ? $connect->real_escape_string($_POST['review']) : '';
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
    $status = 'pending'; // Set the review status to pending

    if ($rating >= 1 && $rating <= 5) {

        $sql = "INSERT INTO reviews (user_id, review, rating, status) VALUES ('$user_id', '$review', '$rating', '$status')";
        if ($connect->query($sql) === TRUE) {
            $message = "Your review has been submitted and is awaiting approval.";
        } else {
            $message = "There was an error submitting your review: " . $connect->error;
        }
    } else {
        $message = "Please select a valid star rating.";
    }
}

$connect->close();
?>