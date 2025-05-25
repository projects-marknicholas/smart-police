<?php
session_start();
include 'includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $reset_code = bin2hex(random_bytes(16)); // Generate a secure random code

        // Save the reset code to the database (you might need a reset column for this)
        $stmt = $conn->prepare("UPDATE admins SET reset_code = ? WHERE email = ?");
        $stmt->bind_param("ss", $reset_code, $email);
        $stmt->execute();

        // Send the reset email
        $reset_link = "http://yourwebsite.com/reset_password.php?code=$reset_code";
        $subject = "Password Reset Request";
        $message = "Click the following link to reset your password: $reset_link";
        $headers = "From: no-reply@yourwebsite.com";

        if (mail($email, $subject, $message, $headers)) {
            $success_message = "Password reset link has been sent to your email.";
        } else {
            $error_message = "Failed to send reset email. Please try again.";
        }
    } else {
        $error_message = "Email address not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Smart Police System</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #003662;
        }
        .auth-container {
            background-color: #f9f9f9;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            width: 320px;
            text-align: center;
        }
        h2 {
            color: #003662;
            margin-bottom: 25px;
        }
        .error-message {
            color: red;
            margin-bottom: 15px;
        }
        .success-message {
            color: green;
            margin-bottom: 15px;
        }
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        .reset-button {
            width: 100%;
            padding: 12px;
            background-color: #003662;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        .reset-button:hover {
            background-color: #00548e;
        }
        .login-link {
            margin-top: 20px;
            font-size: 14px;
        }
        .login-link a {
            color: #003662;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <h2>Forgot Password</h2>
        <?php 
        if (isset($error_message)) echo "<p class='error-message'>$error_message</p>"; 
        if (isset($success_message)) echo "<p class='success-message'>$success_message</p>"; 
        ?>
        <form action="forget.php" method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit" class="reset-button">Send Reset Link</button>
        </form>
        <div class="login-link">
            Remembered your password? <a href="login.php">Login Here!</a>
        </div>
    </div>
</body>
</html>
