<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Health Check-Up</title>
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
            margin-top: 0;
            color: #333;
        }

        .detail-label {
            font-weight: bold;
        }

        .action-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            margin-right: 5px;
        }

        .save-button {
            background-color: #008CBA;
            /* Blue color for save button */
        }

        .action-button:hover,
        .save-button:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <h1>Select Health Check-Up</h1>

    <?php
    include 'connect.php';

    // Check if ID is passed in the URL
    if (isset($_GET['id'])) {
        $checkupId = intval($_GET['id']);

        // Fetch the specific health check-up details
        $sql = "SELECT h.id, u.firstname, h.gender, h.age, h.height, h.weight, h.action
                FROM health h
                INNER JOIN users u ON h.user_id = u.id
                WHERE h.id = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("i", $checkupId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>

            <div class="container">
                <h2>Health Check-Up Details</h2>
                <p><span class="detail-label">User Name:</span> <?php echo htmlspecialchars($row['firstname']); ?></p>
                <p><span class="detail-label">Gender:</span> <?php echo htmlspecialchars($row['gender']); ?></p>
                <p><span class="detail-label">Age:</span> <?php echo htmlspecialchars($row['age']); ?></p>
                <p><span class="detail-label">Height (cm):</span> <?php echo htmlspecialchars($row['height']); ?></p>
                <p><span class="detail-label">Weight (kg):</span> <?php echo htmlspecialchars($row['weight']); ?></p>

                <h3>Add Action</h3>
                <form action="save_action.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                    <textarea name="action" placeholder="Enter action"
                        required> <?php echo htmlspecialchars($row['action']); ?></textarea>
                    <button class="action-button save-button" type="submit">Save Action</button>
                </form>
            </div>

            <?php
        } else {
            echo "<p>No health check-up found.</p>";
        }

        $stmt->close();
    } else {
        echo "<p>No ID specified.</p>";
    }

    $connect->close();
    ?>
</body>

</html>