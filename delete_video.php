<?php
include "connection.php";

// Function to delete a video
function delete_video($video_id) {
    global $conn; // Access the global database connection variable

    // Prepare the SQL statement
    $delete_query = "DELETE FROM videos WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $video_id);

    // Execute the statement
    if ($stmt->execute()) {
        return true; // Video deleted successfully
    } else {
        return false; // Failed to delete video
    }
}

// Check if the video ID is provided in the URL
if (isset($_GET["id"])) {
    $video_id = $_GET["id"];
    // Retrieve video information if the video ID is provided
    $video = get_video_by_id($video_id); // Assuming get_video_by_id function is defined
    if (!$video) {
        // Handle case where video is not found
        die("Video not found.");
    }
} else {
    // Handle case where video ID is not provided in the URL
    die("Video ID not provided.");
}

// Check if the form is submitted for deletion
if (isset($_POST["submit"])) {
    // Confirm if the video ID matches the one in the form submission
    if ($_POST["id"] == $video_id) {
        // Call the delete_video function to delete the video
        if (delete_video($video_id)) {
            // Redirect to the admin panel with a success message
            header("Location: admin_panel.php?msg=Video deleted successfully");
            exit(); // Terminate script execution after redirection
        } else {
            // Display an error message if deletion fails
            $error_message = "Failed to delete video. Please try again.";
        }
    } else {
        // Display an error message if the video ID does not match
        $error_message = "Video ID mismatch. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Video</title>
</head>
<body>
    <h1>Delete Video</h1>
    <?php if (isset($error_message)) : ?>
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>
    <h2>Video Information:</h2>
    <p>Title: <?php echo $video["title"]; ?></p>
    <p>Description: <?php echo $video["description"]; ?></p>
    <p>Description: <?php echo $video["video_path"]; ?></p>
    <!-- Add more details if needed -->
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $video_id; ?>">
        <input type="submit" name="submit" value="Delete">
    </form>
</body>
</html>
