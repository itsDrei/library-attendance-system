<?php
require '../admin/db.php';
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

<?php include('../admin/cdn_bootstrap.php') ?>

 
<body>
  
    <div class="container">
      
    <form action="registration.php" method="post">
      <center>
      <h1 class="title">Student Registration</h1>
      </center>
<br>
    <div style="display:flex; justify-content:right; align-items:center;">
   
    </div>

    <div class="row">
        <center>
        <div class="col-lg-4">
                <input type="text" class="form-control" name="stud_num" id="studnum" placeholder="Student Number">
            </div>
            <br>
            <div class="col-lg-4">
                <input type="text" class="form-control" name="firstname" id="userName" placeholder="Firstname">
            </div>
            <br>
            <div class="col-lg-4">
                <input type="text" class="form-control" name="lastname" id="userLastName" placeholder="Lastname">
            </div>
            <br>
            <div class="col-lg-4">
                <input type="text" class="form-control" name="course" placeholder="Course" required>
            </div>
            <br>
            <div class="col-lg-4">
                <input type="text" class="form-control" name="contact" placeholder="Contact Number" required>
            </div>
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $stud_num = $_POST['stud_num'];
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $course = $_POST['course'];
  $contact = $_POST['contact'];


//   // Hash the password using password_hash() function
//   $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Prepare SQL statement to check if empNum already exists in registration_sysad table
  $stud_num_query = "SELECT COUNT(*) as count FROM student_table WHERE stud_num = '$stud_num'";

  // Execute query to check stud_num count
  $stud_num_result = mysqli_query($conn, $stud_num_query);

  // Fetch stud_num count from query result
  $stud_num_count = mysqli_fetch_assoc($stud_num_result)['count'];

  // Check if stud_num count is greater than 0
  if ($stud_num_count > 0) {
    echo "<script>
      Swal.fire({
        title: 'Error',
        text: 'Student record already exists in the database.',
        icon: 'error',
        confirmButtonText: 'OK'
      }).then(function () {
        window.history.back();
      });
    </script>";
    exit;
  }

  // Prepare SQL statement to insert data into registration_sysad table
  $sql = "INSERT INTO student_table (stud_num,firstname, lastname, course, contact) 
          VALUES ('$stud_num','$firstname', '$lastname', '$course', '$contact')";

  // Execute query to insert data
  $query_run = mysqli_query($conn, $sql);

  // Check if query executed successfully
  if ($query_run) {

    echo "<script>
      Swal.fire({
        title: 'Success!',
        text: 'Registration Successful!',
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
    }).then(function () {
        window.history.back();
      });
    </script>";
    exit;
  }
}
?>



</body>

</html>
