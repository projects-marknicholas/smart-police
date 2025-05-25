<?php
session_start();
if (!isset($_SESSION['username'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

// Set user image based on the username
$userImage = ($_SESSION['username'] === 'admin') ? 'admin.png' : 'police.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>Smart Police System</title>
    <style>
        /* Reset margins and paddings */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #003662;
            padding: 10px 20px;
            color: white;
            flex-wrap: wrap; /* Allows content to wrap on smaller screens */
        }

        /* Header title centered on all screens */
        .header-title {
            font-size: 1.5rem;
            font-weight: bold;
            flex: 1; /* Makes the title grow to take up available space */
            text-align: center;
        }

        /* User info section styling */
        .user-info {
            display: flex;
            align-items: center;
            font-size: 1rem;
            white-space: nowrap; /* Prevents text wrapping within user info */
        }

        .user-icon {
            width: 30px;
            height: 30px;
            margin-right: 10px;
            border-radius: 50%;
        }

        .logout-icon {
            width: 30px;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .logout-icon:hover {
            transform: scale(1.1);
        }

        /* Responsive styling for smaller screens */
        @media (max-width: 768px) {
            .header {
                flex-direction: column; /* Stacks items vertically */
                text-align: center; /* Center-aligns content */
            }

            .header-title {
                font-size: 1.3rem;
                margin-bottom: 10px;
            }

            .user-info {
                font-size: 0.9rem;
            }
        }

        /* Extra small devices (phones, 600px and below) */
        @media (max-width: 600px) {
            .header-title {
                font-size: 1.1rem;
            }

            .user-icon,
            .logout-icon {
                width: 25px; /* Scale icons down slightly on smaller screens */
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <!-- Left side placeholder to keep title centered (optional) -->
        <div style="width: 50px;"></div>
        
        <!-- Centered title -->
        <div class="header-title">Smart Police System</div>
        
        <!-- Right side with user icon and logout -->
        <div class="user-info">
            <img src="assets/images/<?php echo $userImage; ?>" alt="<?php echo ucfirst($_SESSION['username']); ?>'s profile picture" class="user-icon">
            <a href="logout.php" aria-label="Logout">
                <img src="assets/images/logout.png" alt="Logout icon" title="Logout" class="logout-icon">
            </a>
        </div>
    </header>
</body>
</html>
