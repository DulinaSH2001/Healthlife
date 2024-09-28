<div class="sidebar">
    <h2>Navigation</h2>
    <ul>
        <li><a href="admin_dashboard.php">Dashboard</a></li>
        <li><a href="user_management.php">User Management</a></li>
        <li><a href="admin_profile.php">Profile</a></li>
        <li><a href="settings.php">Settings</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>

<style>
    .sidebar {
        width: 250px;

        background-color: #f4f4f4;

        padding: 15px;

        position: fixed;

        height: 100%;

        overflow-y: auto;

    }

    .sidebar h2 {
        font-size: 18px;
        /* Font size for the title */
        margin-bottom: 10px;
        /* Space below the title */
        color: #333;
        /* Darker color for the title */
    }

    .sidebar ul {
        list-style-type: none;
        /* Remove bullet points from list */
        padding: 0;
        /* Remove default padding */
    }

    .sidebar li {
        margin-bottom: 10px;
        /* Space between links */
    }

    .sidebar a {
        text-decoration: none;
        /* Remove underline from links */
        color: #333;
        /* Dark color for the links */
        padding: 10px;
        /* Padding inside links */
        display: block;
        /* Make the whole area clickable */
        border-radius: 4px;
        /* Slightly rounded corners */
    }

    .sidebar a:hover {
        background-color: #4CAF50;
        /* Change background color on hover */
        color: white;
        /* Change text color on hover */
    }
</style>