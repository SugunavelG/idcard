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
                                        <h5>Hostel Checked Report List</h5>
                                    </div>
                                    <div class="card-body table-border-style">
                                        <div class="table-responsive">
                                            <table id="studentTable" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Appliaction No</th>
                                                        <th>Full Name</th>
                                                        <th>Department</th>
                                                        <th>Hostel Name</th>
                                                        <th>Room Category</th>
                                                        <th>Room No</th>
                                                        <th>Checked In Status</th>
                                                        <th>Checked In Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql = "SELECT * 
                                                            FROM student_details
                                                            LEFT JOIN department ON dept_id=s_department
                                                            LEFT JOIN hostel ON h_id=s_h_id
                                                            LEFT JOIN room_category ON rc_id=s_rc_id
                                                            WHERE s_status='1' AND s_reportedStatus='REPORTED' AND s_hosStatus='REPORTED' AND s_hos_checkIn_status='Check-In'
                                                            ORDER BY s_hos_cDate DESC";
                                                        $result = mysqli_query($conn, $sql);
                                                        if(mysqli_num_rows($result) > 0){
                                                            $i = 1;
                                                            while($value = mysqli_fetch_assoc($result)){
                                                                $id = $value['s_id'];
                                                                $appno = $value['s_application_number'];
                                                                $fullname = $value['s_first_name'].' '.$value['s_last_name'];
                                                                $tshirtIssuedDate = date('d-m-Y h:i A', strtotime($value['s_hos_cDate']));
                                                                $checkInStatus = $value['s_hos_checkIn_status'];
                                                                $checkInDate = date('d-m-Y h:i A', strtotime($value['s_hos_checkIn_cDate']));
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_application_number']); ?></td>
                                                        <td><?php echo htmlspecialchars($fullname); ?></td>
                                                        <td><?php echo htmlspecialchars($value['dept_code']); ?></td>
                                                        <td><?php echo htmlspecialchars($value['h_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($value['rc_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_hos_roomno']); ?></td>
                                                        <td>
                                                            <?php if($checkInStatus=='Check-In'){ ?>
                                                                <button class="btn btn-success btn-sm">
                                                                Checked-In
                                                                </button>
                                                            <?php }else{ ?>
                                                            <button class="btn btn-danger btn-sm">
                                                                Not Check-In
                                                                </button>
                                                            <?php } ?>
                                                        </td>
                                                        <td class="action-icons">
                                                            <?php echo $checkInDate; ?>
                                                        </td>
                                                        <td class="action-icons">
                                                            <!-- View -->
                                                            <?php if(isset($prev['97'])=='Y'){ ?>
                                                            <button class="btn btn-warning btn-sm">
                                                                 <a href="studentProfile.php?id=<?php echo encryptId($id); ?>&appno=<?php echo encryptId($appno); ?>&type=View&redirect=hostelCheckedInReportList"
                                                                   title="View" class="text-white">
                                                                    <i class="fas fa-user text-white"></i> Profile
                                                                </a>
                                                            </button>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
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
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-success-alt me-2"></i> Confirm T-shirt Issued
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <i class="fas fa-exclamation-triangle text-warning fa-4x mb-3"></i>
                <h5>Are you sure T-shirt Issue?</h5>
                <!--<p class="text-muted mb-3">-->
                <!--    You are about to permanently delete this student record.-->
                <!--</p>-->
                <div class="card bg-light border-0">
                    <div class="card-body text-start">
                        <p class="mb-2">
                            <strong>Application No :</strong>
                            <span id="modalAppNo"></span>
                        </p>
                        <p class="mb-0">
                            <strong>Student Name :</strong>
                            <span id="modalFullName"></span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
                <a href="#" id="confirmDeleteBtn"
                   class="btn btn-primary">
                    <i class="fas fa-trash-alt me-1"></i>
                    T-shirt Issued
                </a>
            </div>
            <div id="responseMsg"></div>
        </div>
    </div>
</div>
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
    // Initialize DataTable with action column
    $('#studentTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    
        dom: 'Blfrtip',
    
        buttons: [
            {
                extend: 'copy',
                title: 'Student Hostel Checked-In Report',
                exportOptions: {
                    columns: ':not(:last-child)'
                },
                text: '<i class="fa fa-copy"></i> Copy'
            },
            {
                extend: 'excel',
                title: 'Student Hostel Checked-In Report',
                exportOptions: {
                    columns: ':not(:last-child)'
                },
                text: '<i class="fa fa-file-excel"></i> Excel'
            },
            {
                extend: 'csv',
                title: 'Student Hostel Checked-In Report',
                exportOptions: {
                    columns: ':not(:last-child)'
                },
                text: '<i class="fa fa-file-csv"></i> CSV'
            },
            {
                extend: 'pdf',
                title: 'Student Hostel Checked-In Report',
                exportOptions: {
                    columns: ':not(:last-child)'
                },
                text: '<i class="fa fa-file-pdf"></i> PDF'
            },
            {
                extend: 'print',
                title: 'Student Hostel Checked-In Report',
                exportOptions: {
                    columns: ':not(:last-child)'
                },
                text: '<i class="fa fa-print"></i> Print'
            }
        ],
    
        language: {
            emptyTable: "No Records Found",
            search: "",
            searchPlaceholder: "Search Application No, Name, Department..."
        },
    
        columnDefs: [
            { orderable: false, targets: [0, 3] }
        ]
    });
    
    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');
        let appno = $(this).data('appno');
        let fullname = $(this).data('fullname');
        $('#modalAppNo').text(appno);
        $('#modalFullName').text(fullname);
        // Store ID in delete button
        $('#confirmDeleteBtn').data('id', id);
        $('#confirmDeleteBtn').data('appno', appno);
        $('#deleteModal').modal('show');
    });
    
    $(document).on('click', '#confirmDeleteBtn', function () {
        let id = $(this).data('id');
        let appno = $(this).data('appno');
        $.ajax({
            url: 'save.php?request=approveStudentTshirt',
            type: 'POST',
            data: {
                id: id,
                appno: appno
            },
            dataType: 'json',
            beforeSend: function () {
                $("#responseMsg").html(
                    '<div class="alert alert-info">Saving...</div>'
                );
            },
            success: function(response) {
                console.log(response,"response");
                if (response.status == "success") {
                    $("#responseMsg").html(
                        '<div class="alert alert-success">' + response.message + '</div>'
                    );
                    // Optionally reset form
                    $('#deleteModal').modal('hide');
                    // Redirect or reload after a delay
                    setTimeout(function () {
                        window.location.href = './tshirtEligibleList.php';
                    }, 1000);
                } else {
                    $("#responseMsg").html(
                        '<div class="alert alert-danger">' + response.message + '</div>'
                    );
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
                $("#responseMsg").html(
                    '<div class="alert alert-danger">Something went wrong: ' + error + '</div>'
                );
            }
        });
    });
    
    $('.btn-close, .btn-secondary').on('click', function () {
        $('#deleteModal').modal('hide');
    });
});
</script>