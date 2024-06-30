<?php
session_start(); // Start the session

include "connection.php";

// Fetch user details from the database
$user_id = 5; // Assuming user ID 1 is logged in
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$contact_number = isset($_SESSION['contact_number']) ? $_SESSION['contact_number'] : '';
$country = isset($_SESSION['country']) ? $_SESSION['country'] : '';
$interested_sport = isset($_SESSION['interested_sport']) ? $_SESSION['interested_sport'] : '';
$user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : '';

// Fetch videos from the database
$sql = "SELECT * FROM videos";
$result = $conn->query($sql);
$videos = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $videos[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>funolympics</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="users_dash/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="users_dash/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="users_dash/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="users_dash/css/style.css" rel="stylesheet">
    <link href="users_dash/css/style2.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h4 class="m-0"><img class="img-fluid me-2" style="height: 50px; border-radius: 10px" src="img/Olympics logo.jpg" alt="Image">FunOlympics</h4>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img id="profile-pic" class="rounded-circle" src="users_dash/img/user.jpg" alt="" style="width: 40px; height: 40px; cursor: pointer;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><?php echo $user['name']; ?></h6>
                        <!-- <span><?php echo $user['role']; ?></span> -->
                    </div>
                </div>
                <!-- Rest of the sidebar navigation -->
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Modal -->
        <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userModalLabel">User Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6>User Name: <?php echo htmlspecialchars($name); ?></h6>
                        <p>Email: <?php echo htmlspecialchars($email); ?></p>
                        <p>Contact Number: <?php echo htmlspecialchars($contact_number); ?></p>
                        <p>Country: <?php echo htmlspecialchars($country); ?></p>
                        <p>Interested Sport: <?php echo htmlspecialchars($interested_sport); ?></p>
                        <p>User Role: <?php echo htmlspecialchars($user_role); ?></p>
                        <!-- Add more user details here if needed -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Start -->
        <div class="content">
                    <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h4 class="m-0"><img class="img-fluid me-2" style="height: 50px; border-radius: 10px" src="img/Olympics logo.jpg" alt="Image">FunOlympics</h4>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <!-- <div class="position-relative">
                        <img class="rounded-circle" src="users_dash/img/user.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div> -->
                    <!-- <div class="ms-3">
                        <h6 class="mb-0">Billy Lamaine</h6>
                        <span>User</span>
                    </div> -->
                </div>
                <div class="navbar-nav w-100">
                    <a href="index.html" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <!-- <a href="broadcasts.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>broadcasts</a> -->
                    <a href="table.html" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Tables</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->
<!-- Navbar Start -->
<nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="container mt-3 mb-3">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search videos...">
                </div>

                <div class="navbar-nav align-items-center ms-auto">
                    <!-- Notification section -->
                    <div class="nav-item dropdown">
                        <!-- <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notifications</span>
                        </a> -->
                        <!-- <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Profile updated</h6>
                                <small>5 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">New user added</h6>
                                <small>10 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Password changed</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all notifications</a>
                        </div> -->
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="img/profile.jpg" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item" id="profile">My Profile</a>
                            <a href="login.php" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->
            <!-- Navbar End -->

            <div class="container">
                <h3>Broadcasts</h3>
                <div class="row align-items-center" id="videoList">
                    <?php foreach ($videos as $video): ?>
                        <div class="col">
                            <div class="card" style="margin: 1em auto;">
                                <video src="<?php echo $video['video_path']; ?>" class="card-img-top" muted loop controls></video>
                                <div class="card-body">
                                    <h5 class="card-title" style="text-align: center; color: rgba(0, 0, 0, 0.8); text-transform: uppercase;"><?php echo $video['title']; ?></h5>
                                    <p class="card-text"><?php echo $video['description']; ?></p>
                                    <div style="text-align: center; margin-top: 10px;">
                                        <i class="fas fa-thumbs-up" style="color: green; margin-right: 10px; cursor: pointer;"></i>
                                        <i class="fas fa-thumbs-down" style="color: red; cursor: pointer;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div> 
        <!-- Content End -->
    </div>
    <script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function () {
        var searchQuery = this.value.toLowerCase();
        var videos = document.querySelectorAll('#videoList .card');

        videos.forEach(function(video) {
            var title = video.querySelector('.card-title').innerText.toLowerCase();
            var description = video.querySelector('.card-text').innerText.toLowerCase();

            if (title.includes(searchQuery) || description.includes(searchQuery)) {
                video.style.display = 'block';
            } else {
                video.style.display = 'none';
            }
        });
    });
</script>

<script>
    document.getElementById('profile').addEventListener('click', function () {
        $('#userModal').modal('show');
    });
</script>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="users_dash/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="users_dash/lib/chart/chart.min.js"></script>
    <script src="users_dash/lib/easing/easing.min.js"></script>
    <script src="users_dash/lib/waypoints/waypoints.min.js"></script>
    <script src="users_dash/lib/tempusdominus/js/moment.min.js"></script>
    <script src="users_dash/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="users_dash/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
   
    <!-- Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.min.js"></script>

    <!-- Template Javascript -->
    <script src="users_dash/js/main.js"></script>
</body>

</html>
