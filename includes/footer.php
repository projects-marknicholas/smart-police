<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css"> <!-- Link to your CSS file -->
    <style>
        /* Styles to ensure footer stays at the bottom */
        body {
            display: flex;
            flex-direction: column; /* Stack children vertically */
            min-height: 100vh; /* Ensure the body takes at least full viewport height */
            margin: 0; /* Remove default margins */
        }
        .content {
            flex: 1; /* Allow content to grow and take available space */
        }
        footer {
            background-color: #003662; /* Dark indigo color */
            color: white;
            text-align: center;
            padding: 1px 0; /* Padding for footer */
            width: 100%; /* Full width */
            position: relative; /* Position footer relative to content */
        }
    </style>
</head>
<body>
    <div class="content">
        <!-- Your main content will be included here -->
    </div>

    <footer>
        <p>© 2024 Smart Police System</p>
    </footer>
</body>
</html>
