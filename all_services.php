<?php include 'includes/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Services - Smart Police System</title>
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

        /* Services Header */
        .services-header {
            background-color: #FF6F61;
            color: white;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .services-header h1 {
            font-size: 2.8em;
            margin-bottom: 10px;
        }

        .services-header p {
            font-size: 1.3em;
            margin: 0;
        }

        /* Button Styles for Services */
        .services-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .service-item {
            background-color: #007BFF;
            color: white;
            padding: 20px;
            width: 250px;
            text-align: center;
            border-radius: 8px;
            transition: background-color 0.3s, transform 0.2s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .service-item:hover {
            background-color: #0056b3;
            transform: translateY(-5px);
        }

        .service-item a {
            color: white;
            text-decoration: none;
            font-size: 1.2em;
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

        /* Sidebar and mobile responsiveness */
        @media (max-width: 768px) {
            .content {
                margin-left: 0;
            }

            .footer {
                width: 100%;
            }

            .services-header h1 {
                font-size: 2.5em;
            }

            .services-list {
                flex-direction: column;
                gap: 10px;
            }

            .service-item {
                width: 100%;
            }

            .sidebar-toggle {
                display: block;
                background-color: #333;
                color: white;
                padding: 10px;
                text-align: center;
                cursor: pointer;
            }

            .sidebar-toggle.active {
                background-color: #444;
            }
        }

        /* Mobile-first Design */
        @media (max-width: 480px) {
            .services-header {
                padding: 20px;
            }

            .service-item {
                padding: 15px;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar toggle for mobile -->
    <div class="sidebar-toggle" onclick="toggleSidebar()">☰ Menu</div>

    <!-- Main Content Section -->
    <div class="content">
        <div class="services-header">
            <h1>All Available Services</h1>
            <p>Explore the different services offered by the Smart Police System.</p>
        </div>

        <!-- Accessible Pages for User -->
        <div class="services-list">
            <div class="service-item">
                <a href="add_incident_report.php">Add Incident Report</a>
            </div>
            <div class="service-item">
                <a href="add_police_report.php">Add Police Report</a>
            </div>
            <div class="service-item">
                <a href="incident_reports.php">View Incident Reports</a>
            </div>
            <div class="service-item">
                <a href="police_reports.php">View Police Reports</a>
            </div>
            <div class="service-item">
                <a href="prediction.php">Crime Prediction</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Smart Police System - All Services © 2024</p>
    </div>

    <script>
        // Toggle sidebar visibility on small screens
        function toggleSidebar() {
            var content = document.querySelector('.content');
            content.style.marginLeft = content.style.marginLeft === '0px' ? '250px' : '0px';
        }
    </script>

</body>
</html>
