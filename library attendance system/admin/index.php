<?php
session_start();
require 'db.php';
?>
<!-- Login form HTML here -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="icon" href="images/aoe.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">

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
<?php include('cdn_bootstrap.php') ?>
    <div class="container">
        <form  action="index.php" method ="post">
          <center>
          <h2 class="title">Login as Administrator</h2>
          </center>

            <br>
            <br>
            <div class="row">
               <center>
              <div class="col-sm-2">
                <input type="text" name="empNum" class="form-control" placeholder="Employee Number" required>
              </div>
              <br>
              <div class="col-sm-2">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
              </div>
            </div>
            <br>
                </center>

                <div class="row register">
                
                  <center>
                  
                  <button type="submit" class="btn btn-success btn-block" target="_blank">Login</button>
                  <br>
                  <br>
                  <a style=
                  "font-size:13px;
                  color:#222222;
            
                  "
                   href="registration.php" target="blank_"><b>Register New Account</b></a>
                  </center>

                </div>
                
        </form>
    </div>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["empNum"]) && isset($_POST["password"])) {
  
  $empNum = $_POST["empNum"];
  $pass = $_POST["password"];

  $sql = "SELECT empNum, password, firstname, lastname, role FROM registration_table WHERE empNum='$empNum'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      if (password_verify($pass, $row['password'])) {
          // If the passwords match, store the user's authentication status and role in session variables
          $_SESSION['authenticated'] = true;
          $_SESSION['empNum'] = $empNum;
          $_SESSION['firstname'] = $row['firstname'];
          $_SESSION['lastname'] = $row['lastname'];
          $_SESSION['role'] = $row['role'];

                // Insert a new row into the audit_trail table
        $user_name = $row['firstname'] . ' ' . $row['lastname'];
        $activity = "System Admin Logged in";
        date_default_timezone_set('Asia/Manila');
        $date = new DateTime();
        $timestamp = $date->format('Y-m-d H:i:s');
        $formatted_datetime = date('F j, Y h:i A', strtotime($timestamp));
        $sql = "INSERT INTO audit_trail (user_name, activity, date) VALUES ('$user_name', '$activity', '$formatted_datetime')";
        mysqli_query($conn, $sql);

          // Redirect the user to the appropriate dashboard based on their role
          if ($row['role'] === 'System Administrator') {
            echo "<script>
            Swal.fire({
                title: 'Welcome, " . $row['firstname'] . " " . $row['lastname'] . "!',
                text: 'You have successfully logged in.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(function () {
                window.location = 'dashboard.php';
            });
            </script>";
              exit();
          }
      } else {
          echo "<script>
          Swal.fire({
              title: 'Error',
              text: 'Employee Number and password do not match',
              icon: 'error',
              confirmButtonText: 'OK'
            }).then(function () {
                window.history.back();
          });
          </script>";
      }
  } else {
      echo "<script>
      Swal.fire({
          title: 'Error',
          text: 'Employee Number and password do not match',
          icon: 'error',
          confirmButtonText: 'OK'
        }).then(function () {
            window.history.back();
      });
      </script>";
  }
}

mysqli_close($conn);

?>

</body>
</html>