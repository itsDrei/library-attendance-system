
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</head>
<style>
    .container{
        position: absolute;
        top:50%;
        left:50%;
        transform:translate(-50%, -50%);
    }

</style>
<body>

    <div class="container">
        <form action="index.php"method ="post">
            <center>
            <h1 class="title">Login Student Number</h1>
            </center>
     
            <br>
            <br>
            <div class="row">
               <center>
              <div class="col-sm-2">
                <input type="text" name="student_no" class="form-control" placeholder="Enter Student Number" required>
              </div>
            </div>
            <br>
                </center>
                <div class="row">
                  <center>
                  <button type="submit" class="btn btn-success btn-block" target="_blank">Login</button>
                  <br>
                  <br>
              <a style="font-size:13px; color:black;" href="registration.php">Register Account</a>
                  </center>
                </div>
               
           
       
        </form>
    </div>
 
    <?php
session_start();

// Check if the HTTP request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_no = $_POST['student_no'];

    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "admin";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve the student record from the database
    $sql = "SELECT * FROM student_table WHERE stud_num = '$student_no'";
    $result = mysqli_query($conn, $sql);

    

    if (mysqli_num_rows($result) > 0) {
        // Fetch the data from the result
        $row = mysqli_fetch_assoc($result);

// Insert a new record in the 'attendance_record' table
date_default_timezone_set('Asia/Manila');
$date = new DateTime();
$date_ph = $date->format('Y-m-d');
$time_ph = $date->format('h:i:s A');
$formatted_datetime = date('F j, Y h:i A', strtotime($date_ph . ' ' . $time_ph));
$sql = "INSERT INTO attendance_record (stud_num, firstname, lastname, course, contact, date, time_in) 
        VALUES ('$student_no', '{$row['firstname']}', '{$row['lastname']}', '{$row['course']}', '{$row['contact']}', '$date_ph', '$time_ph')";
mysqli_query($conn, $sql);




        // Assign the first name and last name to the $_SESSION variables
        $_SESSION['firstname'] = $row['firstname'];
        $_SESSION['lastname'] = $row['lastname'];
        echo "<script>
        Swal.fire({
            title: 'Welcome, " . $row['firstname'] . " " . $row['lastname'] . "!',
            text: 'You have successfully logged in.',
            icon: 'success',
            showConfirmButton: false
        });
        setTimeout(function(){
            window.location.href = 'index.php';
        }, 1000);
        </script>";

    } else {
        echo "<script>
        Swal.fire({
            title: 'Error',
            text: 'Student number not found in database',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        </script>";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

</body>
</html>


</body>
</html>