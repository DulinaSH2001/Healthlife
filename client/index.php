<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Website</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }

        header {
            background: #35424a;
            color: #ffffff;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #e8491d 3px solid;
        }

        header a {
            color: #ffffff;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 16px;
        }

        header ul {
            padding: 0;
            list-style: none;
        }

        header ul li {
            display: inline;
            padding: 0 20px 0 20px;
        }

        .reviews-section {
            margin: 20px 0;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .reviews-section h2 {
            color: #35424a;
        }

        .review-box {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 5px;
            background-color: #f4f4f4;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .review-box h3 {
            color: #333;
        }

        .review-box p {
            margin: 5px 0;
        }

        .stars {
            color: #FFD700;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="reviews-section">
            <h2>What Our Clients Say</h2>

            <?php
            include 'connect.php';

            // Fetch all approved reviews
            $sql = "SELECT r.review, r.rating, u.firstname, u.lastname, r.created_at 
                    FROM reviews r
                    INNER JOIN users u ON r.user_id = u.id
                    WHERE r.status = 'approved'
                    ORDER BY r.created_at DESC";
            $result = $connect->query($sql);

            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
                    ?>
                    <div class="review-box">
                        <h3><?php echo htmlspecialchars($row['firstname']) . ' ' . htmlspecialchars($row['lastname']); ?></h3>
                        <p class="stars"><?php echo str_repeat("&#9733;", $row['rating']); ?> (<?php echo $row['rating']; ?>
                            Stars)</p>
                        <p><?php echo htmlspecialchars($row['review']); ?></p>
                        <small>Reviewed on: <?php echo $row['created_at']; ?></small>
                    </div>
                    <?php
                endwhile;
            else:
                ?>
                <p>No reviews available at the moment. Be the first to submit one!</p>
                <?php
            endif;

            $connect->close();
            ?>
        </div>
    </div>

</body>

</html>