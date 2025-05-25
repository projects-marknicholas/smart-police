<?php
include 'includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));
    $email = htmlspecialchars(trim($_POST['email']));
    $role = htmlspecialchars(trim($_POST['role']));

    // Allowed roles
    $allowed_roles = ['admin', 'user', 'Police officer'];
    if (!in_array($role, $allowed_roles)) {
        $error_message = "Invalid role selected.";
    } else {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT * FROM user_list WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "Username already exists!";
        } else {
            // Check if email already exists
            $stmt = $conn->prepare("SELECT * FROM user_list WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error_message = "Email already exists!";
            } else {
                // Generate a random verification code
                $verification_code = rand(100000, 999999);

                // Send verification email
                $apiKey = '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'; 
                $brevoUrl = "https://api.brevo.com/v3/smtp/email";

                // Email data
                $emailData = [
                    "sender" => [
                        "name" => "Smart Police System",
                        "email" => "skilllink69@gmail.com"
                    ],
                    "to" => [
                        [
                            "email" => $email,
                            "name" => $username
                        ]
                    ],
                    "subject" => "Verify Your Email",
                    "htmlContent" => "
                        <p>Hello $username,</p>
                        <p>Your verification code is: <strong>$verification_code</strong></p>
                        <p>Please use this code to verify your email and activate your account.</p>
                    "
                ];

                // cURL setup
                $ch = curl_init($brevoUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    "Content-Type: application/json",
                    "api-key: $apiKey"
                ]);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($emailData));

                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                if ($httpCode == 201) {
                    // Hash the password before storing it
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Insert new user into the database
                    $stmt = $conn->prepare("INSERT INTO user_list (username, password, email, role, status, verification_code, created_at) VALUES (?, ?, ?, ?, 'inactive', ?, NOW())");
                    $stmt->bind_param("sssss", $username, $hashed_password, $email, $role, $verification_code);

                    if ($stmt->execute()) {
                        // Redirect to verification page
                        header("Location: verify_email.php");
                        exit;
                    } else {
                        $error_message = "Registration failed. Please try again.";
                    }
                } else {
                    $error_message = "Failed to send verification email. Please try again.";
                }
            }
        }
        $stmt->close();
    }
    $conn->close();
}
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Smart Police System</title>
    <style>
        /* CSS styling for the registration form */
        body {
            font-family: Arial, sans-serif;
            background-color: #003662;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
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

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #003662;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
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

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <form method="POST" action="register.php">
            <h2>Register Form</h2>
            <?php 
                if (isset($success_message)) echo "<p class='success-message'>$success_message</p>"; 
                if (isset($error_message)) echo "<p class='error-message'>$error_message</p>"; 
            ?>
            <input type="text" name="username" placeholder="Create a username" required>
            <input type="password" name="password" placeholder="Create a password" required>
            <input type="email" name="email" placeholder="Enter your email" required>
            <select name="role" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
                <option value="Police officer">Police Officer</option>
            </select>
            <button type="submit">Register</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="login.php">Login Here</a>
        </div>
    </div>
</body>
</html>
