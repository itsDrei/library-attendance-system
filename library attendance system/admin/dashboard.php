
<?php
session_start();
require 'db.php';

	if (!isset($_SESSION['authenticated'])) {
		// If the user is not authenticated, show an empty page and exit
		echo "<script>alert('Please login first.')</script>";
	
		exit();
	}
	
	// Check if the user has the correct role
	if ($_SESSION['role'] !== 'System Administrator') {
		// If the user does not have the correct role, show an empty page and exit
		echo "<script>alert('Access denied. You do not have permission to access this page.')</script>";
	
		exit();
	}

	// Get the current user's name from the session variable
$user_name = $_SESSION['firstname'] . ' ' . $_SESSION['lastname'];
//ANDREI B LEGASPI (22) IS HERE!!!!! 6/1/2023 - GANDAHAN MO PA TO GAWIN MONG MALUPET
//POTPOT, GERO, CISCISCISFRANS, TIN

// Log the user out
if (isset($_GET['logout'])) {
  // Destroy the session
  session_unset();
  session_destroy();

  // Log the user's logout activity
  $activity = "System Admin Logged Out";
  date_default_timezone_set('Asia/Manila');
  $date = new DateTime();
  $timestamp = $date->format('Y-m-d H:i:s');
  $formatted_datetime = date('F j, Y h:i A', strtotime($timestamp));
$sql = "INSERT INTO audit_trail (user_name, activity, date) VALUES ('$user_name', '$activity', '$formatted_datetime')";
mysqli_query($conn, $sql);

  // Redirect to login page
  header("Location: index.php");
  exit;
}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="images/aoe.png">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">

<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="../css/dashboard.css">
	<title>System admin</title>
</head>
<style>
    .dropdown-menu {
        max-height: 200px;
        overflow-y: auto;
    }
	.dropdown-menu li a:hover {
        background-color: red;
        color: black;
    }
</style>
<body>
<!-- SIDEBAR -->
<section id="sidebar">
	<a href="#" class="brand">
		<img  style="width:170px; margin:auto; padding-top:5%;" src="../image/header-logo.png" alt="">
	</a>
	<ul class="side-menu top">
		<li class="active">
			<a href="dashboard.php">
				<i class='bx bxs-dashboard' ></i>
				<span class="text">Dashboard</span>
			</a>
		</li>
		<li>
		<a href="#" id="attendance-record-link">
  <i class='bx bxs-group'></i>
  <span class="text">Attendance Record</span>
</a>
		</li>
	</ul>
	<ul class="side-menu">
		<li class="logout">
			<a class="logout" href="?logout=true"><i class='bx bxs-log-out'></i>Logout</a>
		</li>
	</ul>
</section>
	<!-- CONTENT -->
	<section id="content">
		<main>
      <div id="ajax-content"></div>
 <br>
 <br>		
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="script.js"></script>
  <script>
  $(document).ready(function() {
    // Make an AJAX request to dashboard_table.php
    $.ajax({
      url: 'dashboard_table.php',
      success: function(data) {
        // On success, set the content of the div element to the loaded data
        $('#ajax-content').html(data);
      }
    });
  });
</script>
  <script>
  $(document).ready(function() {
    // Listen for click event on attendance record link
    $('#attendance-record-link').on('click', function(event) {
      event.preventDefault();
      
      // Send AJAX request to fetch attendance record table
      $.ajax({
        url: 'attendance_record.php',
        type: 'GET',
        success: function(response) {
          // Hide dashboard table and replace it with attendance record table
  
          $('#ajax-content').html(response);
        },
        error: function() {
          alert('Error loading attendance record.');
        }
      });
    });
  });
</script>
</body>
</html>