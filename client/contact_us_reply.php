<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Messages</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .message-container {
            max-width: 800px;
            margin: auto;
        }

        .message-box {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .message-box h3 {
            margin-bottom: 10px;
            color: #333;
        }

        .message-box p {
            margin: 5px 0;
            color: #555;
        }

        .message-box .reply {
            background-color: #e9f6e9;
            border-left: 5px solid #4CAF50;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }

        .message-box .no-reply {
            color: #999;
            font-style: italic;
        }

        .replied-date {
            font-size: 0.9em;
            color: #888;
        }
    </style>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="message-container">
        <h1>Your Contact Us Messages</h1>

        <?php
        include 'connect.php';

        $user_id = $_SESSION['uid'];

        // Fetch messages and replies
        $sql = "SELECT message, reply, replied_at FROM contact_us WHERE user_id = '$user_id'";
        $result = $connect->query($sql);
        ?>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="message-box">
                    <h3>Your Message</h3>
                    <p><?php echo htmlspecialchars($row['message']); ?></p>

                    <?php if ($row['reply']): ?>
                        <div class="reply">
                            <h3>Admin's Reply</h3>
                            <p><?php echo htmlspecialchars($row['reply']); ?></p>
                            <p class="replied-date">Replied on: <?php echo $row['replied_at']; ?></p>
                        </div>
                    <?php else: ?>
                        <p class="no-reply">No reply yet.</p>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>You haven't sent any messages yet.</p>
        <?php endif; ?>
    </div>

</body>

</html>

<?php
$connect->close();
?>