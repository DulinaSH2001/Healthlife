<?php

include 'connect.php';


$sql = "
    SELECT p.id, p.card_name, p.card_number, p.price, p.expiry_date, 
           (SELECT u.firstname FROM users u WHERE u.id = p.user_id) as firstname, 
           p.user_id
    FROM payment p";

$result = $connect->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Payment List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .action-button {
            background-color: #4CAF50;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 4px;
        }

        .delete-button {
            background-color: #f44336;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: #d32f2f;
        }

        .alert-success {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <h1>Payment List</h1>

    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>User Name</th>
                <th>Card Name</th>
                <th>Card Number</th>
                <th>Price (Rs)</th>
                <th>Expiry Date</th>

            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['firstname']); ?></td>
                        <td><?php echo htmlspecialchars($row['card_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['card_number']); ?></td>
                        <td><?php echo htmlspecialchars($row['price']); ?></td>
                        <td><?php echo htmlspecialchars($row['expiry_date']); ?></td>

                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No payment records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>

<?php
// Close the database connection
$connect->close();
?>