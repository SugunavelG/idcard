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
    .dataTables_filter input {
        width: 600px !important;
        min-width: 300px;
        border-radius: 5px;
        padding: 6px 12px;
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
                                        <h5>Student Hostel Entry List</h5>
                                    </div>
                                    <div class="card-body table-border-style">
                                        <div class="table-responsive">
                                            <table id="studentTable" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Action</th>
                                                        <th>App No</th>
                                                        <th>Full Name</th>
                                                        <th>Department</th>
                                                        <th>Admission Head</th>
                                                        <th>Hostel Reported Status</th>
                                                        <th>Hostel Reported Date</th>
                                                        <th>Checked In Status</th>
                                                         <th>Checked In Dated</th>
                                                        <th>Payment Status</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql = "SELECT * FROM student_details
                                                            LEFT JOIN department ON dept_id=s_department 
                                                            WHERE s_status='1' AND s_reportedStatus='REPORTED' ORDER BY s_id DESC";
                                                        $result = mysqli_query($conn, $sql);
                                                        if(mysqli_num_rows($result) > 0){
                                                            $i = 1;
                                                            while($value = mysqli_fetch_assoc($result)){
                                                                $id = $value['s_id'];
                                                                $appno = $value['s_application_number'];
                                                                $fullname = $value['s_first_name'].' '.$value['s_last_name'];
                                                                $admitStatus = $value['s_admittedStatus'];
                                                                $admissionOwner=$value['s_admissionOwner'];
                                                                $reportedStatus = $value['s_reportedStatus'];
                                                                $hosPaymentStatus=$value['s_hosPaymentStatus'];
                                                                $hosCheckInStatus=$value['s_hos_checkIn_status'];
                                                                $hosReportStatus=$value['s_hosStatus'];
                                                                $hosReportedDate = (!empty($value['s_hos_cDate']) && $value['s_hos_cDate'] != '0000-00-00 00:00:00')
                                                                    ? date('d-m-Y h:i A', strtotime($value['s_hos_cDate']))
                                                                    : '';
                                                                
                                                                $hosCheckedDate = (!empty($value['s_hos_checkIn_cDate']) && $value['s_hos_checkIn_cDate'] != '0000-00-00 00:00:00')
                                                                    ? date('d-m-Y h:i A', strtotime($value['s_hos_checkIn_cDate']))
                                                                    : '';
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td>
                                                            <!-- Edit -->
                                                            <?php if(isset($prev['62'])=='Y'){ ?>
                                                            <?php if($hosReportStatus!='REPORTED'){ ?>
                                                            <a href="HostelEntryAddEdit.php?id=<?php echo encryptId($id); ?>&appno=<?php echo encryptId($appno); ?>&type=Edit"
                                                                   title="Edit" class="text-white">
                                                                <button class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-edit text-white"></i>Edit
                                                                </button>
                                                            </a>
                                                            <?php } ?>
                                                            <?php } ?>
                                                            <!--Delete-->
                                                            <?php if(isset($prev['63'])=='Y'){ ?>
                                                             <?php if($hosReportStatus=='REPORTED' && $hosCheckInStatus!='Check-In'){ ?>
                                                            <a href="javascript:void(0);" class="delete-btn text-white" data-id="<?php echo $id; ?>" data-appno="<?php echo $appno; ?>" data-fullname="<?php echo $fullname; ?>"
                                                                   title="Approve Check In Student">
                                                                <button class="btn bg-c-teal btn-sm text-white">
                                                                    <i class="fa-solid fa-bed text-white"></i> Check-In
                                                                </button>
                                                            </a>
                                                            <?php } ?>
                                                            <?php } ?>
                                                            <!-- View -->
                                                             <?php if(isset($prev['64'])=='Y'){ ?>
                                                             <a href="studentProfile.php?id=<?php echo encryptId($id); ?>&appno=<?php echo encryptId($appno); ?>&type=View&redirect=studentHostelEntryList"
                                                                   title="View" class="text-white">
                                                                <button class="btn btn-warning btn-sm">
                                                                    <i class="fas fa-user text-white"></i> Profile
                                                                </button>
                                                            </a>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($value['s_application_number']); ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_first_name']); ?> <?php echo htmlspecialchars($value['s_last_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($value['dept_code']); ?></td>
                                                        <td><?php echo htmlspecialchars($admissionOwner); ?></td>
                                                        <td>
                                                            <?php if($hosReportStatus=='REPORTED'){ ?>
                                                                <button class="btn btn-success btn-sm">
                                                                REPORTED
                                                                </button>
                                                            <?php }else{ ?>
                                                            <button class="btn btn-danger btn-sm">
                                                               NOT REPORTED
                                                                </button>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?php echo $hosReportedDate; ?></td>
                                                        <td>
                                                            <?php if($hosCheckInStatus=='Check-In'){ ?>
                                                                <button class="btn btn-success btn-sm">
                                                                Checked-In
                                                                </button>
                                                            <?php }else{ ?>
                                                            <button class="btn btn-danger btn-sm">
                                                                Not Check-In
                                                                </button>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                             <?php echo $hosCheckedDate; ?>
                                                        </td>
                                                        <td>
                                                            <?php if($hosPaymentStatus=='Partially Paid'){ ?>
                                                                <button class="btn btn-danger btn-sm">
                                                                <?php echo $hosPaymentStatus; ?>
                                                                </button>
                                                            <?php }else{ ?>
                                                            <button class="btn btn-success btn-sm">
                                                                <?php echo $hosPaymentStatus; ?>
                                                                </button>
                                                            <?php } ?>
                                                            
                                                        </td>
                                                        
                                                        
                                                    </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                                    <?php
                                                    $sql1 = "SELECT * FROM student_details
                                                             WHERE s_status='1' AND s_hos_checkIn_status='Check-In'";
                                                    $result1 = mysqli_query($conn, $sql1);
                                                    $checkInCount = mysqli_num_rows($result1);
                                                    
                                                    $sql2 = "SELECT * FROM student_details
                                                             WHERE s_status='1' AND s_h_id!=''";
                                                    $result2 = mysqli_query($conn, $sql2);
                                                    $totHosCount = mysqli_num_rows($result2);
                                                    $notReportedCount = $totHosCount - $checkInCount;
                                                    ?>
                                                    <tfoot>
                                                        <tr class="text-center">
                                                            <th colspan="3">
                                                                Total Hostel Count:
                                                                <button class="btn btn-primary btn-sm text-white">
                                                                    <?php echo $totHosCount; ?>
                                                                </button>
                                                            </th>
                                                        
                                                            <th colspan="4">
                                                                Check-In Students Count:
                                                                <button class="btn btn-success btn-sm text-white">
                                                                    <?php echo $checkInCount; ?>
                                                                </button>
                                                            </th>
                                                        
                                                            <th colspan="3">
                                                                Not Check-In Count:
                                                                <button class="btn btn-danger text-white btn-sm">
                                                                    <?php echo $notReportedCount; ?>
                                                                </button>
                                                            </th>
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
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-user-check me-2"></i> Confirm Student Hostel Check In
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <i class="fas fa-exclamation-triangle text-warning fa-4x mb-3"></i>

                <h5>Are you sure?</h5>
                <p class="text-muted mb-3">
                    You are about to permanently Confirm Student Hostel Check In this student record.
                </p>

                <div class="card bg-light border-0">
                    <!--<div class="card-body text-start">-->
                    <!--    <p class="mb-2">-->
                    <!--        <strong>Application No :</strong>-->
                    <!--        <span id="modalAppNo"></span>-->
                    <!--    </p>-->

                    <!--    <p class="mb-0">-->
                    <!--        <strong>Student Name :</strong>-->
                    <!--        <span id="modalFullName"></span>-->
                    <!--    </p>-->
                    <!--</div>-->
                    <!--<div class="mb-2 col-lg-12">-->
                    <!--    <label class="form-label">-->
                    <!--        Hostel Check In<sup class="text-danger">*</sup>-->
                    <!--    </label>-->
                    <!--    <select class="form-select form-control" id="checkIn" name="checkIn" <?php echo $disabled; ?> required>-->
                    <!--        <option value="">Select Hostel Check In</option>-->
                    <!--        <option value="Check-In"-->
                    <!--            <?php if(isset($hosId) && $hosCheckInStatus == $row['s_hos_checkIn_status']) echo 'selected'; ?>>-->
                    <!--            Check-In-->
                    <!--        </option>-->
                    <!--        <option value="Not Check-In"-->
                    <!--            <?php if(isset($hosId) && $hosCheckInStatus == $row['s_hos_checkIn_status']) echo 'selected'; ?>>-->
                    <!--            Not Check-In-->
                    <!--        </option>-->
                    <!--    </select>-->
                    <!--</div>-->
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Application No</th>
                            <td><span id="modalAppNo"></span></td>
                        </tr>
                    
                        <tr>
                            <th>Student Name</th>
                            <td><span id="modalFullName"></span></td>
                        </tr>
                    
                        <tr>
                            <th>Hostel Check In <sup class="text-danger">*</sup></th>
                            <td>
                                <select class="form-select form-control"
                                        id="checkIn"
                                        name="checkIn"
                                        <?php echo $disabled; ?>
                                        required>
                                    <option value="">Select Hostel Check In</option>
                    
                                    <option value="Check-In"
                                        <?php if(isset($hosId) && $hosCheckInStatus == 'Check-In') echo 'selected'; ?>>
                                        Check-In
                                    </option>
                    
                                    <option value="Not Check-In"
                                        <?php if(isset($hosId) && $hosCheckInStatus == 'Not Check-In') echo 'selected'; ?>>
                                        Not Check-In
                                    </option>
                                </select>
                            </td>
                        </tr>
                    
                        <tr>
                            <th>Remarks</th>
                            <td>
                                <textarea class="form-control"
                                          id="description"
                                          name="description"
                                          rows="3"><?php echo $description ?? ''; ?></textarea>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="modal-footer justify-content-center">
                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    Cancel
                </button>

                <a href="#" id="confirmDeleteBtn" class="btn btn-success">
                    <i class="fas fa-edit-alt me-1"></i>
                    Check In Student
                </a>
            </div>

        </div>
        <div id="responseMsg"></div>
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
    $('#admitModal .btn-secondary').click(function () {
        $('#admitModal').modal('hide');
    });
    // Initialize DataTable with action column
    // $('#studentTable').DataTable({
    //     paging: true,
    //     searching: true,
    //     ordering: true,
    //     info: true,
    //     pageLength: 10,
    //     lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    //     dom: 'Bfrtip',
    //     buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
    //     language: {
    //         emptyTable: "No Records Found"
    //     },
    //     columnDefs: [
    //         { orderable: false, targets: [0, 3] }
    //     ]
    // });

     $('#studentTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        pageLength: 10,
        lengthMenu: [[10, 40, 70, -1], [10, 40, 70, "All"]],
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
        var checkIn=$("#checkIn").val();
        var description=$("#description").val();
        if(!checkIn){
            $("#checkIn").focus();
        }else{
            $.ajax({
                url: 'save.php?request=checkInStudentHostelEntry',
                type: 'POST',
                data: {
                    id: id,
                    appno: appno,
                    checkIn:checkIn,
                    description:description
                },
                    dataType: 'json',
                beforeSend: function () {
                    $("#responseMsg1").html(
                        '<div class="alert alert-info">Saving...</div>'
                    );
                },
                success: function(response) {
                    console.log(response,"response");
                   if (response.status == "success") {
                        $("#responseMsg1").html(
                            '<div class="alert alert-success">' + response.message + '</div>'
                        );
                        // Optionally reset form
                        $('#deleteModal').modal('hide');
                        // Redirect or reload after a delay
                        setTimeout(function () {
                            window.location.href = './studentHostelEntryList.php';
                        }, 1000);
                    } else {
                        $("#responseMsg1").html(
                            '<div class="alert alert-danger">' + response.message + '</div>'
                        );
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                    $("#responseMsg1").html(
                        '<div class="alert alert-danger">Something went wrong: ' + error + '</div>'
                    );
                }
            });
        }
    });
    
    $('.btn-close, .btn-secondary').on('click', function () {
        $('#deleteModal').modal('hide');
    });
});
</script>