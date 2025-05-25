<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Police System Dashboard</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #2C3E50;
            color: white;
        }

        .content {
            padding: 20px;
            background-color: #4A1E1E;
            color: white;
            min-height: 100vh;
            margin-left: 250px; /* Space for the sidebar */
        }

        /* Dashboard Header */
        .dashboard-header {
            background-color: #333333;
            padding: 40px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .dashboard-header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .dashboard-header p {
            font-size: 1.2em;
            margin: 0;
        }

        /* Button Styles */
        .btn {
            display: inline-block;
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 10px;
            transition: background-color 0.3s;
        }

        
        /* Footer */
        .footer {
            background-color: #222;
            color: white;
            text-align: center;
            padding: 10px;
            position: relative;
            width: calc(100% - 250px);
            left: 250px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    

    <!-- Main Content Section -->
    <div class="content">
        <div class="dashboard-header">
            <h1>Smart Police Services</h1>
            <p>Office Time: 8:00 AM to 5:00 PM</p>
            <p>Smart Policing System is here to protect and serve you</p>
            <a href="all_services.php" class="btn all-services-btn">All Services</a>
        </div>
        <!-- Add other dashboard content here -->
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Smart Police System - User Dashboard © 2024</p>
    </div>

</body>
</html>
