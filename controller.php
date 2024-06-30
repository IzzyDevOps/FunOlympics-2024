
<?php 

@include 'connection.php';

if(isset($_POST['signUp'])){
    $id=$_POST['id'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    $contact_number=$_POST['contact_number'];
    $country=$_POST['country'];
    $interest_sport=$_POST['interested_sport'];
    $password=$_POST['password'];
    $password=md5($password);

    // selecting user by email
     $checkEmail="SELECT * From users where email='$email'";
     $result=$conn->query($checkEmail);
     if($result->num_rows>0){
        echo "Email Address Already Exists !";
     }
     else{
        $insertQuery="INSERT INTO users (id, name, email, contact_number, country, interested_sport, password)
                       VALUES ('$id', '$name', '$email', '$phone', '$country', '$interest_sport', '$password')";
            if($conn->query($insertQuery)==TRUE){
                header("location: login.php");
            }
            else{
                echo "Error:".$conn->error;
            }
     }
   

}

if(isset($_POST['signIn'])){
   $email=$_POST['email'];
   $password=$_POST['password'];
   $password=md5($password) ;
   
   $sql="SELECT * FROM users WHERE email='$email' and password='$password'";
   $result=$conn->query($sql);
   if($result->num_rows>0){
    session_start();
    $row=$result->fetch_assoc();
    $_SESSION['email']=$row['email'];
    header("Location: user_dashboard.php");
    exit();
   }
   else{
    echo "Incorrect Email or Password";
   }

    // Check if the user's email is of the admin
    if ($user['email'] == 'admin@example.com') {
        // Redirect to the admin page
        header("Location: admin_.php");
        exit();
    } else {
        // Redirect to the user page or other appropriate page
        header("Location: user_dashboard.php");
        exit();
    }
}
?>
