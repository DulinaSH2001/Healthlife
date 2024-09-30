<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Diet Plan List</title>
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
    <h1>Admin Diet Plan List</h1>

    <?php
    include 'connect.php';

    // Fetch all diet plans with relevant user details
    $sql = "
    SELECT d.id, d.gender, d.age, d.height, d.weight, d.bmi, d.diet_plan, d.diet_preference, u.firstname, u.lastname
    FROM diet d
    JOIN users u ON d.user_id = u.id";

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
                <th>BMI</th>
                <th>Diet Plan</th>
                <th>Dietary Preference</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['firstname'] . " " . $row['lastname']); ?></td>
                        <td><?php echo htmlspecialchars($row['gender']); ?></td>
                        <td><?php echo htmlspecialchars($row['age']); ?></td>
                        <td><?php echo htmlspecialchars($row['height']); ?></td>
                        <td><?php echo htmlspecialchars($row['weight']); ?></td>
                        <td><?php echo htmlspecialchars($row['bmi']); ?></td>
                        <td><?php echo htmlspecialchars($row['diet_plan']); ?></td>
                        <td><?php echo htmlspecialchars($row['diet_preference']); ?></td>
                        <td>
                            <a href="select_diet.php?id=<?php echo htmlspecialchars($row['id']); ?>"
                                class="action-button">View</a>
                            <form action="delete_diet.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                <button class="delete-button" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No diet plans found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>