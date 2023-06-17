<?php
require 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <!-- date range -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.4.1/css/dataTables.dateTime.min.css">
    
    <title>Attendance Record</title>

</head>
<body>
    

<ul class="box-info">
    <li>
        <i class='bx bxs-calendar-check'></i>
        <span class="text">
            <p>Total Logs</p>
            <h3>
            <?php 
                $query = "SELECT COUNT(*) FROM attendance_record";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_array($result);
                echo $row[0];
            ?>
            </h3>                   
        </span>
    </li>
</ul>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div id="title-header" class="card-header">
                    <h4 id="title-header">Student Attendance Log</h4>
                </div>
                <div class="card-body">
                <table border="0" cellspacing="5" cellpadding="5">
        <tbody><tr>
            <td>Minimum date:</td>
            <td><input type="text" id="min" name="min"></td>
        
        </tr>
       
        <tr>
            <td>Maximum date:</td>
            <td><input type="text" id="max" name="max"></td>
        </tr>
    </tbody></table>
    <br>
                    <table class="table" id="mytable">
                        <thead>
                            <tr>
                                <th>Student No</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Course</th>
                                <th>Date</th>
                                <th>Contact</th>
                                <th>Time-in</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = "SELECT * FROM attendance_record";     
                                $query_run = mysqli_query($conn, $query);

                                if(mysqli_num_rows($query_run) > 0) {
                                    while($stud_info = mysqli_fetch_assoc($query_run)) {
                                        ?>
                                        <tr>
                                            <td><?= $stud_info['stud_num']; ?></td>
                                            <td><?= $stud_info['firstname']; ?></td>
                                            <td><?= $stud_info['lastname']; ?></td>
                                            <td><?= $stud_info['course']; ?></td>
                                            <td><?= $stud_info['date']; ?></td>
                                            <td><?= $stud_info['contact']; ?></td>
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

                    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.4.1/js/dataTables.dateTime.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>





                   

                    <script>
                        $(document).ready(function() {
                            var table = $('#mytable').DataTable({
                                order: [6, 'desc'],
                                dom: 'lBfrtip',
                                lengthMenu: [10, 20, 25, 50],
                                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                            });
                        });

                     
                    </script>
                    <script>
                           var minDate, maxDate;
 
 // Custom filtering function which will search data in column four between two values
 $.fn.dataTable.ext.search.push(
     function( settings, data, dataIndex ) {
         var min = minDate.val();
         var max = maxDate.val();
         var date = new Date( data[4] );
  
         if (
             ( min === null && max === null ) ||
             ( min === null && date <= max ) ||
             ( min <= date   && max === null ) ||
             ( min <= date   && date <= max )
         ) {
             return true;
         }
         return false;
     }
 );
  
 $(document).ready(function() {
     // Create date inputs
     minDate = new DateTime($('#min'), {
         format: 'MMMM Do YYYY'
     });
     maxDate = new DateTime($('#max'), {
         format: 'MMMM Do YYYY'
     });
  
     // DataTables initialisation
     var table = $('#mytable').DataTable();
  
     // Refilter the table
     $('#min, #max').on('change', function () {
         table.draw();
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
