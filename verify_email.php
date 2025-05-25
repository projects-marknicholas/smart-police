<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>User Account Activation by Email Verification using PHP</title>
      <!-- CSS -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   </head>
   <body>
   <?php
   include 'includes/db_connection.php';

   $msg = ""; // Initialize message variable

   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       if (!empty($_POST['verification_code'])) {
           $verification_code = $_POST['verification_code'];

           // Check if the verification code exists and is inactive
           $stmt = $conn->prepare("SELECT * FROM user_list WHERE verification_code = ? AND status = 'inactive'");
           $stmt->bind_param("s", $verification_code);
           $stmt->execute();
           $result = $stmt->get_result();

           if ($result->num_rows > 0) {
               // Activate the user
               $stmt = $conn->prepare("UPDATE user_list SET status = 'active', verification_code = NULL WHERE verification_code = ?");
               $stmt->bind_param("s", $verification_code);
               if ($stmt->execute()) {
                   // Redirect to login with success message
                   header("Location: login.php?message=Your email has been verified successfully!");
                   exit;
               } else {
                   $msg = "Verification failed. Please try again later.";
               }
           } else {
               $msg = "Invalid or expired verification code.";
           }
           $stmt->close();
       } else {
           $msg = "Verification code is required.";
       }
   }

   $conn->close();
   ?>

      <div class="container mt-3">
          <div class="card">
            <div class="card-header text-center">
              User Account Activation by Email Verification using PHP
            </div>
            <div class="card-body">
             <?php if ($msg): ?>
               <div class="alert alert-danger"><?php echo $msg; ?></div>
             <?php endif; ?>
             <form method="POST" action="">
                 <div class="form-group">
                     <label for="verification_code">Enter Verification Code</label>
                     <input type="text" class="form-control" id="verification_code" name="verification_code" placeholder="Enter your verification code">
                 </div>
                 <button type="submit" class="btn btn-primary">Verify</button>
             </form>
            </div>
          </div>
      </div>
   </body>
</html>
