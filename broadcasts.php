<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Video Display</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .video-card {
            margin-bottom: 20px;
        }
        .back-arrow {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 24px;
            color: #000;
            cursor: pointer;
        }
        .container {
            padding-top: 50px;
        }
    </style>
</head>
<body>
    <a href="#" class="back-arrow"><i class="fas fa-arrow-left"></i></a>
    <div class="container">
        <div class="row">
            <?php
            // Include database connection
            include('connection.php');

            // Fetch all videos from the database
            $sql = "SELECT * FROM videos";
            $result = $conn->query($sql);

            // Check if there are videos in the result
            if ($result && $result->num_rows > 0) {
                // Loop through each video fetched from the database
                while($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-md-4">
                        <div class="card video-card">
                            <video src="<?php echo $row['video_path']; ?>" class="card-img-top" muted loop controls></video>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['title']; ?></h5>
                                <p class="card-text"><?php echo $row['description']; ?></p>
                                <div class="thumbs">
                                    <i class="fas fa-thumbs-up" style="color: green;"></i>
                                    <i class="fas fa-thumbs-down" style="color: red;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                // Display a message if no videos are found
                echo '<div class="col">';
                echo '    <p>No videos found.</p>';
                echo '</div>';
            }

            // Close the database connection
            $conn->close();
            ?>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
