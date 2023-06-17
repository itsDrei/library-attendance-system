<?php
require 'db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">

    <title>Attendance Record</title>
</head>
<body>
<div class="head-title">
				<div class="left">
					<h1>Welcome! Administrator</h1>
					
				</div>
		
			</div>
<ul class="box-info">
				<li>
					<i class='bx bxs-calendar-check' ></i>
					<span class="text">
          <p>Student Login Today</p>
          <h3><?php 
    $query = "SELECT COUNT(DISTINCT stud_num) FROM attendance_record WHERE DATE(date) = CURDATE();";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    echo $row[0];
?></h3>                   
					</span>
				</li>
			</ul>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div id="title-header" class="card-header">
                    <h4 id="title-header">Recently recorded student attendance
                            
                    </h4>
                </div>
                <div class="card-body">
                <table class="table" id = "mytable">
                    <thead>
                      <tr>
                        <th>Student No</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
						<th>Course</th>
                        <th>Contact</th>
                        <th>Date</th>
                        <th>Time-in</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
    $query = "SELECT * FROM attendance_record WHERE DATE(date) = CURDATE();";     
    $query_run = mysqli_query($conn, $query);

    if(mysqli_num_rows($query_run) > 0) {
        while($stud_info = mysqli_fetch_assoc($query_run)) {
            ?>
            <tr>
                <td><?= $stud_info['stud_num']; ?></td>
                <td><?= $stud_info['firstname']; ?></td>
                <td><?= $stud_info['lastname']; ?></td>
                <td><?= $stud_info['course']; ?></td>
                <td><?= $stud_info['contact']; ?></td>
                <td><?= $stud_info['date']; ?></td>
                <td><?= $stud_info['time_in']; ?></td>
            </tr>
            <?php
        }
    } else {
        echo "<h5>No Record Found</h5>";
    }
?>


                     
                    </tbody>
                  </table>
                  <script src="https://code.jquery.com/jquery-3.6.3.min.js" 
                          integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" 
                          crossorigin="anonymous"></script>


                  <script src ="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
                  <script>
                                   $(document).ready(function () {
    var table = $('#mytable').DataTable({
      order: [6, 'desc']
    });

   
  
    });



                  </script>
            
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>