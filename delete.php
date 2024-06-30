<?php
include "connection.php";
include "crud_operations.php";

// Ensure the $id is defined before using it
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
} else {
    die('Error: User ID not provided.');
}

// Fetch user details from the database
$sql = "SELECT * FROM `users` WHERE id = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $username = $_POST['Username'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $interested_sport = $_POST['interested_sport'];
    $country = $_POST['country'];

    // Update user information in the database
    $update_sql = "UPDATE `users` SET name = ?, contact_number = ?, email = ?, interested_sport = ?, country = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssssi", $username, $contact_number, $email, $interested_sport, $country, $id);
    
    if ($update_stmt->execute()) {
        echo "Record updated successfully!";
        header("Location: admin_panel.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>PHP CRUD Application</title>
</head>

<body>
  <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #00ff5573;">
    Admin Panel
  </nav>

  <div class="container">
    <div class="text-center mb-4">
      <h3>Edit User Information</h3>
      <p class="text-muted">Click update after changing any information</p>
    </div>

    <div class="container d-flex justify-content-center">
      <form action="" method="post" style="width:50vw; min-width:300px;">
        <div class="row mb-3">
          <div class="col">
            <label class="form-label">Username:</label>
            <input type="text" class="form-control" name="Username" value="<?php echo htmlspecialchars($row['name']); ?>">
          </div>

          <div class="col">
            <label for="contact_number" class="form-label">Contact Number</label>
            <input type="tel" class="form-control" name="contact_number" id="contact_number" value="<?php echo htmlspecialchars($row['contact_number']); ?>" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Email:</label>
          <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($row['email']); ?>">
        </div>

        <div class="mb-3">
          <label for="interested_sport" class="form-label">Interested Sport:</label>
          <select name="interested_sport" id="interested_sport" class="form-select" required>
            <option value="" disabled>Select Sport</option>
            <option value="Football" <?php if ($row['interested_sport'] == 'Football') echo 'selected'; ?>>Football</option>
            <option value="Basketball" <?php if ($row['interested_sport'] == 'Basketball') echo 'selected'; ?>>Basketball</option>
            <option value="Tennis" <?php if ($row['interested_sport'] == 'Tennis') echo 'selected'; ?>>Tennis</option>
            <!-- Add more options as needed -->
          </select>
        </div>

        <div class="mb-3">
          <label for="country" class="form-label">Country:</label>
          <select name="country" id="country" class="form-select" required>
            <option value="" disabled>Select Country</option>
            <option value="USA" <?php if ($row['country'] == 'USA') echo 'selected'; ?>>USA</option>
            <option value="UK" <?php if ($row['country'] == 'UK') echo 'selected'; ?>>UK</option>
            <option value="BW" <?php if ($row['country'] == 'BW') echo 'selected'; ?>>Botswana</option>
            <option value="RSA" <?php if ($row['country'] == 'RSA') echo 'selected'; ?>>South Africa</option>
            <!-- Add more options as needed -->
          </select>
        </div>

        <div>
          <button type="submit" class="btn btn-success" name="submit">Update</button>
          <a href="add_new_user.php" class="btn btn-secondary">Cancel</a>
          <a href="delete_user.php" class="btn btn-danger">Delete</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>
