<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage All Reviews</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        .admin-actions {
            display: flex;
            gap: 10px;
        }

        .approve,
        .reject,
        .delete,
        .pending {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .reject {
            background-color: #f44336;
        }

        .pending {
            background-color: #FF9800;
        }

        .delete {
            background-color: #555;
        }

        .approve:hover,
        .reject:hover,
        .delete:hover,
        .pending:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <h1>Admin - Manage All Reviews</h1>

    <?php
    include 'connect.php';

    // Handle Approve, Reject, or Delete actions
    if (isset($_POST['action']) && isset($_POST['review_id'])) {
        $action = $_POST['action'];
        $review_id = intval($_POST['review_id']);

        if ($action === 'approve') {
            $status = 'approved';
            $sql = "UPDATE reviews SET status = '$status', approved_at = NOW() WHERE id = '$review_id'";
        } elseif ($action === 'reject') {
            $status = 'rejected';
            $sql = "UPDATE reviews SET status = '$status', approved_at = NOW() WHERE id = '$review_id'";
        } elseif ($action === 'pending') {
            $status = 'pending';
            $sql = "UPDATE reviews SET status = '$status', approved_at = NULL WHERE id = '$review_id'";
        } elseif ($action === 'delete') {
            $sql = "DELETE FROM reviews WHERE id = '$review_id'";
        }

        $connect->query($sql);

        if ($connect->affected_rows > 0) {
            echo "Review has been successfully processed.";
        } else {
            echo "There was an error processing the review.";
        }
    }

    // Fetch all reviews
    $sql = "SELECT r.id, r.review, r.rating, u.firstname, u.lastname, r.status, r.created_at 
            FROM reviews r
            INNER JOIN users u ON r.user_id = u.id";
    $result = $connect->query($sql);
    ?>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['firstname']) . ' ' . htmlspecialchars($row['lastname']); ?></td>
                        <td><?php echo $row['rating']; ?> Stars</td>
                        <td><?php echo htmlspecialchars($row['review']); ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td><?php echo ucfirst($row['status']); ?></td>
                        <td>
                            <div class="admin-actions">
                                <form method="POST" action="admin_reviews_list.php" style="display:inline-block;">
                                    <input type="hidden" name="review_id" value="<?php echo $row['id']; ?>">
                                    <?php if ($row['status'] !== 'approved'): ?>
                                        <button class="approve" name="action" value="approve">Approve</button>
                                    <?php endif; ?>
                                    <?php if ($row['status'] !== 'rejected'): ?>
                                        <button class="reject" name="action" value="reject">Reject</button>
                                    <?php endif; ?>
                                    <?php if ($row['status'] !== 'pending'): ?>
                                        <button class="pending" name="action" value="pending">Mark Pending</button>
                                    <?php endif; ?>
                                </form>
                                <form method="POST" action="admin_reviews_list.php" style="display:inline-block;">
                                    <input type="hidden" name="review_id" value="<?php echo $row['id']; ?>">
                                    <button class="delete" name="action" value="delete">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No reviews available at the moment.</p>
    <?php endif; ?>

</body>

</html>

<?php
$connect->close();
?>