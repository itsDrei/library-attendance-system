<?php

require 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" href="images/aoe.png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="accRegistration.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Bootstrap CSS and JS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/XpZ4y3RSKB8kSk" crossorigin="anonymous"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <script src="passwordValidation.js" defer></script>
</head>
<style>
  .container{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }


</style>
<body>

<?php include('cdn_bootstrap.php') ?>

 
<body>
  
    <div class="container">
      
    <form method="post">
      <center>
      <h1 class="title">Register Account</h1>
      </center>
<br>
    <div style="display:flex; justify-content:right; align-items:center;">
   
    </div>

    <div class="row">
        <center>
            <div class="col-lg-4">
                <input type="text" class="form-control" name="firstname" id="userName" placeholder="Enter first name e.g Juan">
            </div>
            <br>
            <div class="col-lg-4">
                <input type="text" class="form-control" name="lastname" id="userLastName" placeholder="Enter last name e.g Dela Cruz">
            </div>
            <br>
            <div class="col-lg-4">
                <input type="text" class="form-control" name="empNum" id="email1" placeholder="Enter employee number" required>
            </div>
        </center>
    </div>
    <br>

    <div class="row">
        <center>
            <div class="col-lg-4">
                <input type="password" class="form-control pass" name="password" id="password" placeholder="Password" required>
            </div>
            <br>
            <div class="col-lg-4">
                <input type="password" class="form-control" name="confirmPass" id="confirmPass" placeholder="Confirm Password" required>
            </div>
            <br>
            
        </center>
    </div>
    <br>
    <br>
    <center>
        <button type="submit" class="btn btn-success " target="_blank">Sign Up</button>
        <br>
    </center>
</form>
        
         <br>
    <br>
    </div>
   
    <?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $empNum = $_POST['empNum'];
  $password = $_POST['password'];
  $confirmPass = $_POST['confirmPass'];
  $role = "System Administrator";

  // Check if passwords match
  if ($password != $confirmPass) {
    echo '<script>
      Swal.fire({
        title: "Error",
        text: "Password does not match the confirm password",
        icon: "error",
        confirmButtonText: "OK"
      }).then(function () {
        window.history.back();
      });
    </script>';
    exit;
  }

  // Hash the password using password_hash() function
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Prepare SQL statement to check if empNum already exists in registration_sysad table
  $empNum_query = "SELECT COUNT(*) as count FROM registration_table WHERE empNum = '$empNum'";

  // Execute query to check empNum count
  $empNum_result = mysqli_query($conn, $empNum_query);

  // Fetch empNum count from query result
  $empNum_count = mysqli_fetch_assoc($empNum_result)['count'];

  // Check if empNum count is greater than 0
  if ($empNum_count > 0) {
    echo "<script>
      Swal.fire({
        title: 'Error',
        text: 'Employee Number already exists in the database.',
        icon: 'error',
        confirmButtonText: 'OK'
      }).then(function () {
        window.history.back();
      });
    </script>";
    exit;
  }

  // Prepare SQL statement to insert data into registration_sysad table
  $sql = "INSERT INTO registration_table (firstname, lastname, empNum, password, role) 
          VALUES ('$firstname', '$lastname', '$empNum', '$hashed_password', '$role')";

  // Execute query to insert data
  $query_run = mysqli_query($conn, $sql);

  // Check if query executed successfully
  if ($query_run) {
    // $user_name = $_SESSION['firstname'] . ' ' . $_SESSION['lastname'];
    // $activity = "System Admin Created an Admin Account for <b>$firstname $lastname</b>";
    // date_default_timezone_set('Asia/Manila');
    // $date = new DateTime();
    // $timestamp = $date->format('Y-m-d H:i:s');
    // $formatted_datetime = date('F j, Y h:i A', strtotime($timestamp));
    // $sql = "INSERT INTO audit_trail (user_name, activity, date) VALUES ('$user_name', '$activity', '$formatted_datetime')";
    // mysqli_query($conn, $sql);
    echo "<script>
      Swal.fire({
        title: 'Success!',
        text: 'Account successfully created!',
        icon: 'success',
        confirmButtonText: 'OK'
      }).then(function () {
        window.location = 'index.php';
      });
    </script>";
    exit;
  } else {
    echo "<script>
      Swal.fire({
        title: 'Error',
        text: 'An error occurred while creating the account. Please try again later.',
        icon: 'error',
        confirmButtonText: 'OK'
      });
    </script>";
    exit;
  }
}
?>



</body>

</html>
