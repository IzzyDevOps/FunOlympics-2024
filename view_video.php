<?php
// Include database connection
include "connection.php";

// Fetch all videos from the database
$sql = "SELECT * FROM videos";
$result = mysqli_query($conn, $sql);

// Check if there are any videos
if (mysqli_num_rows($result) > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Videos</title>
    </head>
    <body>
        <h2>View Videos</h2>
        <ul>
            <?php
            // Loop through each row of the result set
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <li>
                    <h3><?php echo $row['title']; ?></h3>
                    <p>Description: <?php echo $row['description']; ?></p>
                    <p>Category: <?php echo $row['category']; ?></p>
                    <video controls>
                        <source src="videos/<?php echo $row['video_url']; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </li>
                <?php
            }
            ?>
        </ul>
    </body>
    </html>
    <?php
} else {
    // If no videos are found, display a message
    echo "No videos found.";
}
?>
