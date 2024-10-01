<?php
include 'connect.php';


$sql = "SELECT c.id, c.message, c.reply, u.firstname, u.lastname 
        FROM contact_us c 
        INNER JOIN users u ON c.user_id = u.id";
$result = $connect->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Contact Us</title>
    <style>
        textarea {
            width: 100%;
            height: 80px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        button {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <h1>Contact Us Messages</h1>
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <tr>
            <th>User</th>
            <th>Message</th>
            <th>Reply</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['firstname'] . ' ' . $row['lastname']); ?></td>
                <td><?php echo htmlspecialchars($row['message']); ?></td>
                <td>
                    <?php if ($row['reply']): ?>

                        <p><strong>Reply:</strong> <?php echo htmlspecialchars($row['reply']); ?></p>
                    <?php else: ?>

                        <form method="POST" action="reply_contact.php">
                            <textarea name="reply" placeholder="Write your reply here..." required></textarea>
                            <input type="hidden" name="contact_id" value="<?php echo $row['id']; ?>">
                            <button type="submit">Reply</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>

</html>

<?php
$connect->close();
?>