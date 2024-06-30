<?php
include "connection.php";

// Function to add a new user
function add_user($id, $name, $email, $country, $contact_number, $password, $interested_sport) {
    global $conn; // Access the global database connection variable

    // Hash the password
    $password_hashed = md5($password);

    // Prepare the SQL statement
    $insert_query = "INSERT INTO users (id, name, email, country, contact_number, password, interested_sport) 
                     VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("sssssss", $id, $name, $email, $country, $contact_number, $password_hashed, $interested_sport);

    // Execute the statement
    if ($stmt->execute()) {
        return true; // User added successfully
    } else {
        return false; // Failed to add user
    }
}

// Function to update user information
function update_user($id, $name, $email, $country, $contact_number, $password, $interested_sport) {
    global $conn; // Access the global database connection variable

    // Hash the password
    $password_hashed = md5($password);

    // Prepare the SQL statement
    $update_query = "UPDATE users SET name = ?, email = ?, country = ?, contact_number = ?, password = ?, interested_sport = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssssi", $name, $email, $country, $contact_number, $password_hashed, $interested_sport, $id);

    // Execute the statement
    if ($stmt->execute()) {
        return true; // User information updated successfully
    } else {
        return false; // Failed to update user information
    }
}

// Function to delete a user
function delete_user($id) {
    global $conn; // Access the global database connection variable

    // Prepare the SQL statement
    $delete_query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id);

    // Execute the statement
    if ($stmt->execute()) {
        return true; // User deleted successfully
    } else {
        return false; // Failed to delete user
    }
}

// Function to get video information by ID
function get_video_by_id($video_id) {
    global $conn; // Access the global database connection variable

    // Prepare the SQL statement
    $sql = "SELECT * FROM `videos` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $video_id);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Fetch the video information as an associative array
    $video = $result->fetch_assoc();

    // Close the statement
    $stmt->close();

    // Return the video information
    return $video;
}
?>
