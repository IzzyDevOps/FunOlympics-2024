<?php
session_start();
include("connection.php");

if(isset($_POST['signIn'])){
    $email=$_POST['email'];
    $password=$_POST['password'];
    $password=md5($password) ;
    
  //Use prepared statement to prevent sql injection
  $select="SELECT * FROM users WHERE email=? AND password=?";
  $stmt= mysqli_prepare($conn, $select);
  mysqli_stmt_bind_param($stmt, 'ss', $email, $password);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if (mysqli_num_rows($result) > 0) {
    // User exists, log in 
    // Check if the user's email is of the admin
    if ($user['email'] == 'admin@example.com') {
      // Redirect to the admin page
      header("Location: admin_panel.php");
     
    } else {
        // Redirect to the user page or other appropriate page
        header("Location: users_dash.php");
    }

  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/signup.css">
</head>
<body>

<div class="container" id="signIn">
        <h1 class="form-title">Sign In</h1>
        <br>
        <form method="post" action="users_dash.php">
          <div class="input-group">
              <input type="email" name="email" id="email" placeholder="Email" required>
              <label for="email">Email</label>
          </div>
          <br>
          <div class="input-group">
              <input type="password" name="password" id="password" placeholder="Password" required>
              <label for="password">Password</label>
          </div>
          <br>
          <p class="recover">
            <a href="reset_password.php">Forgot Password</a>
          </p>
         <input type="submit" class="btn" value="Sign In" name="signIn">
        </form>
        <br>
        <p class="or">
          ----------or--------
        </p>
        <br>
        <div class="icons">
          <i class="fab fa-google"></i>
          <i class="fab fa-facebook"></i>
        </div>
        <div class="links">
          <p>Don't have account yet?</p>
          <button id="signUpButton">Sign Up</button>
        </div>
      </div>
      <script src="js/script.js"></script>
</body>
</html>