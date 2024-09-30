<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Health Check-Up List</title>
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

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
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

        .delete-button {
            background-color: #f44336;
            /* Red color for delete button */
        }

        .action-button:hover {
            background-color: #45a049;
        }

        .delete-button:hover {
            background-color: #e53935;
            /* Darker red */
        }
    </style>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <h1>Admin Health Check-Up List</h1>

    <?php
    include 'connect.php';

    // Fetch all health check-ups with relevant user details
    $sql = "
    SELECT h.id, h.gender, h.age, h.height, h.weight, u.firstname, u.lastname
    FROM health h ,users u
    WHERE h.user_id = u.id";


    $result = $connect->query($sql);
    ?>

    <table>
        <thead>
            <tr>
                <th>User Name</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Height (cm)</th>
                <th>Weight (kg)</th>
                <th> Action
                </th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['firstname']); ?></td>
                        <td><?php echo htmlspecialchars($row['gender']); ?></td>
                        <td><?php echo htmlspecialchars($row['age']); ?></td>
                        <td><?php echo htmlspecialchars($row['height']); ?></td>
                        <td><?php echo htmlspecialchars($row['weight']); ?></td>
                        <td>
                            <a href="select_health.php?id=<?php echo htmlspecialchars($row['id']); ?>"
                                class="action-button">Action</a>
                            <form action="delete_checkup.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                <button class="delete-button" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No health check-up records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>