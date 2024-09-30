<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diet History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .history-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            width: 100%;
            max-width: 600px;
        }

        .history-card h2 {
            margin-top: 0;
            font-size: 20px;
            color: #333;
        }

        .card-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .card-details div {
            width: 48%;
        }

        .detail-label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        .masked-card {
            letter-spacing: 0.1em;
        }

        .price,
        .expiry {
            color: #4CAF50;
        }

        .no-history {
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            color: #555;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <h1>Diet History</h1>

    <?php
    include 'connect.php';

    // Assuming you have a session started and the user is logged in
    $user_id = $_SESSION['uid'];

    // Query to fetch diet history along with payment details
    $sql = "
    SELECT d.id, d.diet_type, d.start_date, d.end_date, d.action, p.card_name, p.card_number, p.price, p.expiry_date
    FROM diet d, payment p
    WHERE d.id = p.diet_id
    AND d.user_id = '$user_id'";

    $result = $connect->query($sql);
    ?>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="history-card">
                <h2>Diet Plan #<?php echo $row['id']; ?></h2>
                <div class="card-details">
                    <div>
                        <span class="detail-label">Diet Type:</span>
                        <?php echo htmlspecialchars($row['diet_type']); ?>
                    </div>
                    <div>
                        <span class="detail-label">Start Date:</span>
                        <?php echo htmlspecialchars($row['start_date']); ?>
                    </div>
                </div>
                <div class="card-details">
                    <div>
                        <span class="detail-label">End Date:</span>
                        <?php echo htmlspecialchars($row['end_date']); ?>
                    </div>
                    <div class="action">
                        <span class="detail-label">Action:</span>
                        <textarea class="action-textarea" name="action_description"
                            placeholder="Wait....."><?php echo htmlspecialchars($row['action']); ?></textarea>
                    </div>
                </div>
                <hr>
                <h2>Payment Details</h2>
                <div class="card-details">
                    <div>
                        <span class="detail-label">Name on Card:</span>
                        <?php echo htmlspecialchars($row['card_name']); ?>
                    </div>
                    <div class="masked-card">
                        <span class="detail-label">Card Number:</span>
                        <?php echo htmlspecialchars($row['card_number']); ?>
                    </div>
                </div>
                <div class="card-details">
                    <div class="price">
                        <span class="detail-label">Price (Rs):</span>
                        <?php echo htmlspecialchars($row['price']); ?>
                    </div>
                    <div class="expiry">
                        <span class="detail-label">Expiry Date:</span>
                        <?php echo htmlspecialchars($row['expiry_date']); ?>
                    </div>
                </div>

            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="no-history">
            <p>No diet history found.</p>
        </div>
    <?php endif; ?>

</body>

</html>