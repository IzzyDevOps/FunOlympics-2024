<?php
session_start();
@include 'connection.php';

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            $update_sql = "UPDATE users SET last_login = NOW() WHERE email = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param('s', $email);
            $update_stmt->execute();

            // Redirect based on user role (with debug statements)
            if ($user['user_role'] == 'admin') {
                echo "Redirecting to admin panel...";
                header("Location: admin_panel.php");
            } else {
                echo "Redirecting to user dashboard...";
                header("Location: users_dash.php");
            }
            exit();
        } else {
            header('Location: login.php?error=IncorrectEmailOrPassword');
            exit();
        }
    } else {
        header('Location: login.php?error=IncorrectEmailOrPassword');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/signup.css">
</head>
<body>
    <div class="container" id="signIn">
        <h1 class="form-title">Sign In</h1>
        <?php
        if (isset($_GET['error'])) {
            echo '<span class="error-msg">' . htmlspecialchars($_GET['error']) . '</span>';
        }
        ?>
        <form method="post" action="login.php">
            <div class="input-group">
                <input type="email" name="email" id="email" required>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <input type="password" name="password" id="password" required>
                <label for="password">Password</label>
            </div>
            <p class="recover">
                <a href="reset_password.php">Forgot Password?</a>
            </p>
            <input type="submit" class="btn" value="Sign In" name="login">
        </form>
        <p class="or">----------or--------</p>
        <div class="icons">
            <i class="fab fa-google"></i>
            <i class="fab fa-facebook"></i>
        </div>
        <div class="links">
            <p>Don't have an account yet?</p>
            <button id="signUpButton">Sign Up</button>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
