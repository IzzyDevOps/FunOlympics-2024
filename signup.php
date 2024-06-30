<?php
session_start();
@include 'connection.php';

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, isset($_POST['name']) ? $_POST['name'] : '');
    $email = mysqli_real_escape_string($conn, isset($_POST['email']) ? $_POST['email'] : '');
    $contact_number = mysqli_real_escape_string($conn, isset($_POST['contact_number']) ? $_POST['contact_number'] : '');
    $country = mysqli_real_escape_string($conn, isset($_POST['country']) ? $_POST['country'] : '');
    $interested_sport = mysqli_real_escape_string($conn, isset($_POST['interested_sport']) ? $_POST['interested_sport'] : '');
    $password = mysqli_real_escape_string($conn, isset($_POST['password']) ? $_POST['password'] : '');
    $user_role = mysqli_real_escape_string($conn, isset($_POST['user_role']) ? $_POST['user_role'] : '');

    $select = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($select);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error[] = 'User already exists!';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert = "INSERT INTO users (name, email, country, contact_number, password, interested_sport, user_role) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert);
        $stmt->bind_param('sssssss', $name, $email, $country, $contact_number, $hashed_password, $interested_sport, $user_role);

        if ($stmt->execute()) {
            header('Location: login.php'); // Redirect to login page
            exit();
        } else {
            $error[] = 'Failed to register the user!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/signup.css">
</head>
<body>
    <div class="container" id="signup">
        <h1 class="form-title">Register</h1>
        <?php
        if (isset($error)) {
            foreach ($error as $err) {
                echo '<span class="error-msg">' . $err . '</span>';
            }
        }
        ?>
        <form method="post" action="signup.php">
            <div class="input-group">
                <input type="text" name="name" id="name" required>
                <label for="name">Username</label>
            </div>
            <div class="input-group">
                <input type="email" name="email" id="email" required>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <input type="tel" name="contact_number" id="contact_number" required>
                <label for="contact_number">Contact Number</label>
            </div>
            <div class="input-group">
                <input type="password" name="password" id="password" required>
                <label for="password">Password</label>
            </div>
            <div class="input-group">
                <select name="interested_sport" id="interested_sport" required>
                    <option value="" disabled selected>Select Sport</option>
                    <option value="Football">Football</option>
                    <option value="Basketball">Basketball</option>
                    <option value="Tennis">Tennis</option>
                </select>
            </div>
            <div class="input-group">
                <select name="country" id="country" required>
                    <option value="" disabled selected>Select Country</option>
                    <option value="USA">USA</option>
                    <option value="UK">UK</option>
                    <option value="BW">Botswana</option>
                    <option value="RSA">South Africa</option>
                </select>
            </div>
            <div class="input-group">
                <select name="user_role" id="user_role" required>
                    <option value="" disabled selected>Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
            <input type="submit" class="btn" value="Sign Up" name="submit">
        </form>
        <p class="or">----------or--------</p>
        <div class="icons">
            <i class="fab fa-google"></i>
            <i class="fab fa-facebook"></i>
        </div>
        <div class="links">
            <p>Already Have Account?</p>
            <button id="signInButton">Sign In</button>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
