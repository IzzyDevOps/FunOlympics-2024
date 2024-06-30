<?php
session_start();
include("connection.php");

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$id = $_GET["id"];

// Fetch user details
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Fetch available broadcasts
$broadcasts_query = "SELECT * FROM broadcasts";
$broadcasts_result = mysqli_query($conn, $broadcasts_query);
$broadcasts = mysqli_fetch_all($broadcasts_result, MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];
    $country = $_POST['country'];
    $interested_sport = $_POST['interested_sport'];
    $password = $_POST['password'];
    $password_hashed = md5($password);

    $update_query = "UPDATE users SET name = ?, country = ?, email = ?, contact_number = ?, interested_sport = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssssi", $name, $country, $email, $contact_number, $interested_sport, $password_hashed, $id);
    $stmt->execute();
    $stmt->close();

    header('Location: user_dashboard.php');
    exit();
}

// Handle broadcast selection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['select_broadcast'])) {
    $broadcast_id = $_POST['broadcast_id'];
    $user_id = $_SESSION['user_id'];
    $insert_query = "INSERT INTO user_broadcasts (user_id, broadcast_id) VALUES (?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ii", $user_id, $broadcast_id);
    $stmt->execute();
    $stmt->close();

    header('Location: user_dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?></h1>

    <h2>Select Broadcasts</h2>
    <form method="post">
        <select name="broadcast_id">
            <?php foreach ($broadcasts as $broadcast): ?>
                <option value="<?php echo htmlspecialchars($broadcast['id']); ?>">
                    <?php echo htmlspecialchars($broadcast['title']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="select_broadcast">Select</button>
    </form>

    <h2>Your Profile</h2>
    <form method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br>

        <label for="country">Country:</label>
        <input type="text" id="country" name="country" value="<?php echo htmlspecialchars($user['country']); ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>

        <label for="contact_number">Contact Number:</label>
        <input type="text" id="contact_number" name="contact_number" value="<?php echo htmlspecialchars($user['contact_number']); ?>" required><br>

        <label for="sports_interest">Sports Interest:</label>
        <input type="text" id="sports_interest" name="sports_interest" value="<?php echo htmlspecialchars($user['interested_sport']); ?>" required><br>

        <button type="submit" name="update_profile">Update Profile</button>
    </form>

    <a href="logout.php">Logout</a>
</body>
</html>