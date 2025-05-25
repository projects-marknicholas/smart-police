<?php
session_start();
include 'includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Prepare the SQL statement
  $stmt = $conn->prepare("SELECT * FROM user_list WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();

    // Check if user is active
    if ($user['status'] !== 'active') {
      $error_message = "Your account is not active. Please verify your email.";
    } else {
      // Verify password
      if (password_verify($password, $user['password'])) {
        // Store user info in session
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; // Assuming 'role' column exists in the table

        // Redirect based on role
        if ($user['role'] === 'admin') {
          header("Location: dashboard.php");
        } elseif ($user['role'] === 'user') {
          header("Location: user_dashboard.php");
        } else {
          header("Location: dashboard.php");
        }
        exit();
      } else {
        $error_message = "Invalid password!";
      }
    }
  } else {
    $error_message = "User not found!";
  }

  $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Smart Police System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    /* Your styles remain unchanged */
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
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 16px;
    }
    .password-container {
      position: relative;
      width: 100%;
    }
    .toggle-password {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #003662;
      cursor: pointer;
    }
    .login-button {
      width: 100%;
      padding: 12px;
      background-color: #003662;
      color: white;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
    }
    .login-button:hover {
      background-color: #00548e;
    }
    .auth-links {
      margin-top: 10px;
      font-size: 14px;
      text-align: center;
    }
    .auth-links a {
      color: #003662;
      text-decoration: none;
      font-weight: bold;
    }
    .auth-links a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="auth-container">
    <h2>Login</h2>
    <?php if (isset($error_message)) echo "<p class='error-message'>$error_message</p>"; ?>
    <form action="login.php" method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <div class="password-container">
        <input type="password" name="password" placeholder="Password" required>
        <button type="button" class="toggle-password" onclick="togglePassword()">Show</button>
      </div>
      <button type="submit" class="login-button">Login</button>
    </form>
    
    <div class="auth-links">
      <a href="forget.php">Forgot Password?</a>
    </div>
    <div class="auth-links">
      Don't have an account? <a href="register.php">Register Here!</a>
    </div>
  </div>

  <script>
    function togglePassword() {
      const passwordField = document.querySelector('input[name="password"]');
      const toggleButton = document.querySelector('.toggle-password');
      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleButton.textContent = 'Hide';
      } else {
        passwordField.type = 'password';
        toggleButton.textContent = 'Show';
      }
    }
  </script>
</body>
</html>
