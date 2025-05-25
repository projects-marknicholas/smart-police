<?php include 'includes/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Police System Dashboard</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #F4F4F9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .content {
            padding: 30px;
            background-color: #FFFFFF;
            min-height: 100vh;
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }

        /* Dashboard Header */
        .dashboard-header {
            background-color: #007BFF;
            color: white;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .dashboard-header h1 {
            font-size: 2.8em;
            margin-bottom: 10px;
        }

        .dashboard-header p {
            font-size: 1.3em;
            margin: 0;
        }

        .btn {
            display: inline-block;
            background-color: #28A745;
            color: white;
            padding: 12px 24px;
            font-size: 1.2em;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
            transition: background-color 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            background-color: #218838;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: -250px; /* Initially hidden */
            top: 0;
            width: 250px;
            height: 100%;
            background-color: black;
            padding-top: 20px;
            box-shadow: 2px 0px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-container img {
            width: 70%;
        max-width: 180px;
        }

        .sidebar a {
            color: white;
            padding: 15px 20px;
            text-decoration: none;
            font-size: 1.2em;
            display: flex;
            align-items: center;
            transition: background-color 0.3s;
        }

        .sidebar a i {
            margin-right: 15px;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        .sidebar.active {
            transform: translateX(250px);
        }

        /* Footer */
        .footer {
            background-color: #222;
            color: white;
            text-align: center;
            padding: 15px;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        /* Sidebar Toggle */
        .toggle-btn {
            font-size: 30px;
            color: white;
            background-color: transparent;
            border: none;
            cursor: pointer;
            position: fixed;
            top: 10px;
            left: 20px;
            z-index: 1100;
            transition: 0.3s;
        }

        .toggle-btn:hover {
            background-color: rgba(0, 0, 0, 0.3);
            border-radius: 50%;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .content {
                margin-left: 0;
            }

            .sidebar {
                width: 200px;
            }

            .sidebar a {
                font-size: 16px;
            }

            .toggle-btn {
                font-size: 28px;
            }
        }

        @media (max-width: 480px) {
            .dashboard-header {
                padding: 20px;
            }

            .btn {
                padding: 10px 18px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo-container">
            <img src="assets/images/logo.png" alt="Logo">
        </div>
        <a href="index.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="all_services.php"><i class="fas fa-th-list"></i> All Services</a>
        <a href="police-reports.php"><i class="fas fa-file-alt"></i> Police Reports</a>
        <a href="User/user_crime_statistics.php"><i class="fas fa-exclamation-circle"></i> Incident Reports</a>
        <a href="User/crime_statistics.php"><i class="fas fa-chart-bar"></i> Crime Statistics</a>
    </div>

    <!-- Sidebar Toggle Button -->
    <button class="toggle-btn" id="toggle-btn" onclick="toggleSidebar()">&#9776;</button>

    <!-- Main Content -->
    <div class="content">
        <div class="dashboard-header">
            <h1>Welcome to Smart Police Services</h1>
            <p>Your safety, our priority</p>
            <a href="all_services.php" class="btn">View All Services</a>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Smart Police System - User Dashboard © 2024</p>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
