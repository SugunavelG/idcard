<?php 
session_start();
include '../common/config.php';
if(empty($_SESSION['USER_ID']) && empty($_SESSION['USER_NAME'])){
    header("Location: ../index.php");
    exit();
}else{
    $sql="SELECT * FROM user_type WHERE ut_id='".$_SESSION['USER_TYPE_ID']."'";
    $result=mysqli_query($conn,$sql);
    $numrows=mysqli_num_rows($result);
    $fetchArr=mysqli_fetch_array($result);
    $prev=json_decode($fetchArr['ut_prev'],true);
}

include '../common/header.php'; 
?>
<style>
    label.error, span.error {
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
        display: block;
    }
    .dt-buttons .btn {
        margin-right: 5px;
    }
    .action-icons a {
        margin: 0 3px;
        font-size: 18px;
        color: #6c757d;
        transition: 0.2s;
    }
    .action-icons a:hover {
        color: #0d6efd;
    }
    .action-icons a.delete-btn:hover {
        color: #dc3545;
    }
 #studentTable tbody td {
    text-align: right;
}
 #studentTable tfoot td {
    text-align: right;
}
#studentTable tbody td:nth-child(2) {
    text-align: left;
}
</style>

<!-- DataTables CSS & Buttons CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- [ Main Content ] start -->
<section class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Department Summary Report List</h5>
                                    </div>
                                    <div class="card-body table-border-style">
                                        <div class="table-responsive" id="tableContainer">
                                            <table id="studentTable" class="table table-striped table-border">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Department</th>
                                                        <th>Reported</th>
                                                        <th>Admit Card Issued</th>
                                                        <th>ID Card Issued</th>
                                                        <th>TShirt Issued</th>
                                                        <th>Bag Issued</th>
                                                        <th>Hostel Reported</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                     <?php

                                                    $sql = "SELECT
                                                                department.dept_code,
                                                    
                                                                SUM(s_reportedStatus = 'REPORTED') AS reported,
                                                    
                                                                SUM(
                                                                    s_reportedStatus = 'REPORTED'
                                                                    AND s_admittedStatus = 'ISSUED'
                                                                ) AS admit_card_issued,
                                                    
                                                                SUM(
                                                                    s_reportedStatus = 'REPORTED'
                                                                    AND s_idcardStatus = 'ISSUED'
                                                                ) AS id_card_issued,
                                                    
                                                                SUM(
                                                                    s_reportedStatus = 'REPORTED'
                                                                    AND s_tshirtStatus = 'ISSUED'
                                                                ) AS tshirt_issued,
                                                    
                                                                SUM(
                                                                    s_reportedStatus = 'REPORTED'
                                                                    AND s_bagStatus = 'ISSUED'
                                                                ) AS bag_issued,
                                                    
                                                                SUM(
                                                                    s_reportedStatus = 'REPORTED'
                                                                    AND s_hosStatus = 'REPORTED'
                                                                ) AS hostel_reported
                                                    
                                                            FROM student_details
                                                    
                                                            LEFT JOIN department
                                                                ON department.dept_id = student_details.s_department
                                                    
                                                            WHERE s_course_type = 'REGULAR'
                                                    
                                                            GROUP BY student_details.s_department, department.dept_code
                                                    
                                                            ORDER BY department.dept_code ASC";
                                                    
                                                    $result = mysqli_query($conn, $sql);
                                                    
                                                    $i = 1;
                                                    
                                                    // Total variables
                                                    $totalReported  = 0;
                                                    $totalAdmitCard = 0;
                                                    $totalIDCard    = 0;
                                                    $totalTshirt    = 0;
                                                    $totalBag       = 0;
                                                    $totalHostel    = 0;
                                                    
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                    
                                                        // Add totals INSIDE the loop
                                                        $totalReported  += $row['reported'];
                                                        $totalAdmitCard += $row['admit_card_issued'];
                                                        $totalIDCard    += $row['id_card_issued'];
                                                        $totalTshirt    += $row['tshirt_issued'];
                                                        $totalBag       += $row['bag_issued'];
                                                        $totalHostel    += $row['hostel_reported'];
                                                    ?>
                                                    
                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                    
                                                        <td>
                                                            <?php echo htmlspecialchars($row['dept_code']); ?>
                                                        </td>
                                                    
                                                        <td>
                                                            <?php echo $row['reported']; ?>
                                                        </td>
                                                    
                                                        <td>
                                                            <?php echo $row['admit_card_issued']; ?>
                                                        </td>
                                                    
                                                        <td>
                                                            <?php echo $row['id_card_issued']; ?>
                                                        </td>
                                                    
                                                        <td>
                                                            <?php echo $row['tshirt_issued']; ?>
                                                        </td>
                                                    
                                                        <td>
                                                            <?php echo $row['bag_issued']; ?>
                                                        </td>
                                                    
                                                        <td>
                                                            <?php echo $row['hostel_reported']; ?>
                                                        </td>
                                                    </tr>
                                                    
                                                    <?php
                                                    }
                                                    ?>
                                                    
                                                    

                                                </tbody>
                                                <tfoot>
                                                    <!-- TOTAL -->
                                                    <tr style="font-weight:bold; background:#f2f2f2;">
                                                        <td></td>
                                                        <td >TOTAL</td>
                                                    
                                                        <td><?php echo $totalReported; ?></td>
                                                    
                                                        <td><?php echo $totalAdmitCard; ?></td>
                                                    
                                                        <td><?php echo $totalIDCard; ?></td>
                                                    
                                                        <td><?php echo $totalTshirt; ?></td>
                                                    
                                                        <td><?php echo $totalBag; ?></td>
                                                    
                                                        <td><?php echo $totalHostel; ?></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- [ Main Content ] end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- [ Main Content ] end -->

<!-- DataTables JS & Buttons -->
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

<script>

$(document).ready(function () {
   
    
    $('#studentTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        pageLength: 20,
        lengthMenu: [[20, 25, 50, -1], [20, 25, 50, "All"]],
        dom: 'Bfrtip',
    
        buttons: [
            {
                extend: 'copy',
                title: 'Department Wise Summary Report',
                footer: true
            },
            {
                extend: 'csv',
                title: 'Department Wise Summary Report',
                filename: 'Student_Department_Wise_Summary_Report',
                footer: true
            },
            {
                extend: 'excel',
                title: 'Department Wise Summary Report',
                filename: 'Student_Department_Wise_Summary_Report',
                footer: true
            },
            {
                extend: 'pdf',
                title: 'Department Wise Summary Report',
                filename: 'Student_Department_Wise_Summary_Report',
                footer: true
            },
            {
                extend: 'print',
                title: 'Department Wise Summary Report',
                footer: true
            }
        ],
    
        language: {
            emptyTable: "No Records Found"
        },
    
        columnDefs: [
            { orderable: false, targets: [0, 1] }
        ]
    });

});

</script>