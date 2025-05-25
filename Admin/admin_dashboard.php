<?php
// admin_dashboard.php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

include 'includes/header.php'; // Assuming you have a header file for consistent styling

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css"> <!-- Link your CSS file -->
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Admin Dashboard</h2>
    <table>
        <tr>
            <th>Priority</th>
            <th>Item</th>
            <th>Admin Story</th>
            <th>Estimated Time</th>
        </tr>
        <tr>
            <td>1</td>
            <td>Access the link/system</td>
            <td>As an Admin, I want to access the system</td>
            <td>2hrs</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Manage the System</td>
            <td>As an Admin, I want to manage the system</td>
            <td>4hrs</td>
        </tr>
        <tr>
            <td>3</td>
            <td>Configure data ingestion from sources</td>
            <td>As an Admin, I want to configure data ingestion from various sources</td>
            <td>8hrs</td>
        </tr>
        <tr>
            <td>4</td>
            <td>Manage and monitor system performance</td>
            <td>As an Admin, I want to manage and monitor system performance</td>
            <td>10hrs</td>
        </tr>
        <tr>
            <td>5</td>
            <td>Oversee data analysis and modeling</td>
            <td>As an Admin, I want to oversee data analysis and modeling</td>
            <td>6hrs</td>
        </tr>
    </table>

    <?php include 'includes/footer.php'; // Footer file for consistent styling ?>
</body>
</html>
