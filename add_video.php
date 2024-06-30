<?php
session_start();
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $title = mysqli_real_escape_string($conn, trim($_POST['title']));
    $description = mysqli_real_escape_string($conn, trim($_POST['description']));
    $video_path = mysqli_real_escape_string($conn, trim($_POST['video_path']));

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO videos (title, description, video_path) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $description, $video_path);

    if ($stmt->execute()) {
        header("Location: admin_panel.php");
        exit();
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch all videos from the database
$sql = "SELECT * FROM videos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Video</title>
    <link rel="stylesheet" href="css/add_video.css">
</head>
<body>
<?php include "navigation_bar.php"; ?>
<div class="add-video" style="border: 1px solid #ddd; border-radius: 10px; padding: 10px; margin-top: 20px;">
    <h2 style="color: #007bff;">Upload Video</h2>
    <?php if (isset($error)): ?>
        <div style="color: red;"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="add_video.php" style="margin-bottom: 20px;">
        <label for="title">Title</label><br>
        <input type="text" id="title" name="title" required><br>
        <label for="description">Description</label><br>
        <textarea id="description" name="description" required></textarea><br>
        <label for="video_path">Video Path</label><br>
        <input type="text" id="video_path" name="video_path" required><br>
        <button type="submit" style="padding: 10px 20px; background-color: #28a745; border-radius: 5px; border: none; color: #fff; margin-top: 10px;">Add Video</button>
    </form>
    <table style="width: 100%; text-align: left;">
        <tr style="background-color: #f8f9fa; border-bottom: 1px solid #ddd;">
            <th style="padding: 10px;">Title</th>
            <th style="padding: 10px;">Description</th>
            <th style="padding: 10px;">Video Path</th>
        </tr>
        <?php while ($video = $result->fetch_assoc()): ?>
        <tr style="background-color: #fff; border-bottom: 1px solid #ddd;">
            <td style="padding: 10px;"><?php echo htmlspecialchars($video['title']); ?></td>
            <td style="padding: 10px;"><?php echo htmlspecialchars($video['description']); ?></td>
            <td style="padding: 10px;"><?php echo htmlspecialchars($video['video_path']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>

<?php
$conn->close();
?>
