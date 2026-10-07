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
    $userType=$fetchArr['ut_name'];
    $prev=json_decode($fetchArr['ut_prev'],true);
}
include '../common/header.php'; 
$headName=$_SESSION['USER_HEAD_NAME'];
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
                        <!-- [ breadcrumb ] end -->
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Students List</h5>
                                    </div>
                                    <div class="card-body table-border-style">
                                        <div class="table-responsive">
                                            <table id="studentTable" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>App No</th>
                                                        <th>Full Name</th>
                                                        <th>Department</th>
                                                        <th>Applicant Type</th>
                                                        <th>Admission Head</th>
                                                        <th>Student Mobile</th>
                                                        <th>Parent Mobile</th>
                                                        <th>Student Mobile Verification</th>
                                                        <th>Parents Mobile Verification</th>
                                                        <th>Registration Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $cond = "s_status='1' ";
                                                        
                                                        if ($userType == 'Super Admin' || $headName == 'Others') {

                                                            // Show all records
                                                        }else if ($userType == 'Admin' || $headName == 'Others') {

                                                            // Show all records
                                                        } elseif (!empty($headName)) {
                                                        
                                                            $cond .= " AND s_admissionOwner='$headName'";
                                                        
                                                        } else {
                                                        
                                                            $cond .= " AND s_admissionOwner='$userName'";
                                                        }
                                                        $sql = "SELECT *
                                                                FROM student_details
                                                                LEFT JOIN department ON dept_id = s_department
                                                                WHERE $cond AND s_reportedStatus='REPORTED'
                                                                ORDER BY s_id DESC";
                                                                //echo $sql;
                                                        // $sql = "SELECT * FROM student_details
                                                        //     LEFT JOIN department ON dept_id=s_department
                                                        //     WHERE s_status='1' AND s_reportedStatus='REPORTED' ORDER BY s_id DESC";
                                                        $result = mysqli_query($conn, $sql);
                                                        if(mysqli_num_rows($result) > 0){
                                                            $i = 1;
                                                            while($value = mysqli_fetch_assoc($result)){
                                                                $id = $value['s_id'];
                                                                $appno = $value['s_application_number'];
                                                                $fullname = $value['s_first_name'].' '.$value['s_last_name'];
                                                                $admissionOwner=$value['s_admissionOwner'];
                                                                $reportedStatus=$value['s_reportedStatus'];
                                                                 $sMobileStatus = $value['s_smobile_Status'];
                                                                $pMobileStatus = $value['s_pmobile_Status'];
                                                                $mobileDesc = $value['s_mobile_Desc'];
                                                                $sMobile = $value['s_mobile_no'];
                                                                $pMobile = $value['s_alternate_mobile'];
                                                                
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_application_number']); ?></td>
                                                        <td><?php echo htmlspecialchars($fullname); ?></td>
                                                        <td><?php echo htmlspecialchars($value['dept_code']); ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_course_type']); ?></td>
                                                        <td><?php echo htmlspecialchars($admissionOwner); ?></td>
                                                        <td><?php echo $sMobile; ?></td>
                                                        <td><?php echo $pMobile; ?></td>
                                                        <td>
                                                            <?php if($sMobileStatus=='Verified'){ ?>
                                                            <button class="btn btn-success btn-sm">
                                                                VERIFIED
                                                            </button>
                                                            <?php }else{ ?>
                                                            <button class="btn btn-danger btn-sm">
                                                                <?php echo $sMobileStatus; ?>
                                                            </button>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if($pMobileStatus=='Verified'){ ?>
                                                            <button class="btn btn-success btn-sm">
                                                                VERIFIED
                                                            </button>
                                                            <?php }else{ ?>
                                                            <button class="btn btn-danger btn-sm">
                                                                <?php echo $pMobileStatus; ?>
                                                            </button>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if($reportedStatus=='REPORTED'){ ?>
                                                            <button class="btn btn-success btn-sm">
                                                                REPORTED
                                                            </button>
                                                            <?php }else{ ?>
                                                            <button class="btn btn-danger btn-sm">
                                                                NOT REPORTED
                                                            </button>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <!-- Edit -->
                                                            <!--<?php if(isset($prev['92'])=='Y'){ ?>-->
                                                            <!--<?php if($admitStatus=='NOT ISSUED'){ ?>-->
                                                            <!--<button class="btn btn-primary btn-sm">-->
                                                            <!--    <a href="studentAdmitCardAdd.php?id=<?php echo encryptId($id); ?>&appno=<?php echo encryptId($appno); ?>&type=Edit"-->
                                                            <!--       title="Edit" class="text-white">-->
                                                            <!--        <i class="fas fa-edit text-white"></i> Process-->
                                                            <!--    </a>-->
                                                            <!--</button>-->
                                                            <!--<?php } } ?>-->
                                                            <?php if(isset($prev['92'])=='Y'){ ?>
                                                            <?php if($sMobileStatus!='Verified' || $pMobileStatus!='Verified'){ ?>
                                                            <a href="javascript:void(0);" class="call-btn text-white" data-sMobile="<?php echo $sMobile; ?>" data-pMobile="<?php echo $pMobile; ?>" data-sMobileStatus="<?php echo $sMobileStatus; ?>" data-pMobileStatus="<?php echo $pMobileStatus; ?>" data-mobileDesc="<?php echo $mobileDesc; ?>" data-id="<?php echo $id; ?>" data-appno="<?php echo $appno; ?>" data-fullname="<?php echo $fullname; ?>"
                                                                   title="Call Student">">
                                                                <button class="btn btn-purple btn-sm">
                                                                    <i class="fas fa-phone text-white"></i>Call
                                                                </button>
                                                            </a>
                                                            <?php } } ?>
                                                            <?php if(isset($prev['93'])=='Y'){ ?>
                                                             <a href="studentProfile.php?id=<?php echo encryptId($id); ?>&appno=<?php echo encryptId($appno); ?>&type=View&redirect=studentCounsellorList"
                                                                   title="View" class="text-white">
                                                                <button class="btn btn-warning btn-sm">
                                                                    <i class="fas fa-user text-white"></i>Profile
                                                                </button>
                                                            </a>
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
                                                             WHERE $cond";
                                                    $result1 = mysqli_query($conn, $sql1);
                                                    $totalCount = mysqli_num_rows($result1);
                                                
                                                    $sql2 = "SELECT * FROM student_details
                                                             WHERE $cond AND  s_reportedStatus='REPORTED'";
                                                    $result2 = mysqli_query($conn, $sql2);
                                                    $reportedCount = mysqli_num_rows($result2);
                                                    
                                                    $sql3 = "SELECT * FROM student_details
                                                             WHERE $cond AND  s_reportedStatus='REPORTED' AND s_smobile_Status='Verified'";
                                                    $result3 = mysqli_query($conn, $sql3);
                                                    $sVerifiedCount = mysqli_num_rows($result3);
                                                    
                                                    $sql4 = "SELECT * FROM student_details
                                                             WHERE $cond AND  s_reportedStatus='REPORTED' AND s_pmobile_Status='Verified'";
                                                    $result4 = mysqli_query($conn, $sql4);
                                                    $pVerifiedCount = mysqli_num_rows($result4);
                                                    
                                                    $notReportedCount = $totalCount - $reportedCount;
                                                    ?>
                                                    <tfoot>
                                                        <tr class="text-center">
                                                            <th colspan="3">
                                                                Total Students Count:
                                                                <button class="btn btn-primary btn-sm text-white">
                                                                    <?php echo $totalCount; ?>
                                                                </button>
                                                            </th>
                                                        
                                                            <th colspan="2">
                                                                Reported Count:
                                                                <button class="btn btn-success btn-sm text-white">
                                                                    <?php echo $reportedCount; ?>
                                                                </button>
                                                            </th>
                                                            
                                                            <th colspan="2">
                                                                Student Mobile Verified Count:
                                                                <button class="btn btn-success btn-sm text-white">
                                                                    <?php echo $sVerifiedCount; ?>
                                                                </button>
                                                            </th>
                                                            
                                                            <th colspan="2">
                                                                Parent Mobile Verified Count:
                                                                <button class="btn btn-success btn-sm text-white">
                                                                    <?php echo $pVerifiedCount; ?>
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
<div class="modal fade" id="callModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                     <i class="fas fa-user-check"me-2></i> Confirm Student & Parents Mobile Number
                </h5>
                <button type="button"
                        class="close"
                        data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body text-center">
                <i class="fas fa-exclamation-triangle text-warning fa-4x mb-3"></i>

                <h5>Are you sure?</h5>
                <p class="text-muted mb-3">
                    You are about to verified this student mobile numbers.
                </p>

                <div class="card bg-light border-0">
                   <div class="card-body">

                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="30%">Application No</th>
                                    <td>
                                        <span id="modalCallAppNo"></span>
                                    </td>
                                </tr>
                    
                                <tr>
                                    <th>Student Name</th>
                                    <td>
                                        <span id="modalCallFullName"></span>
                                    </td>
                                </tr>
                                
                                <!--<tr>-->
                                <!--    <th>Student Mobile No</th>-->
                                <!--    <td>-->
                                <!--        <span id="modalCallSMobile"></span>-->
                                <!--    </td>-->
                                <!--</tr>-->
                                
                                <!--<tr>-->
                                <!--    <th>Student Parent Mobile</th>-->
                                <!--    <td>-->
                                <!--        <span id="modalCallPMobile"></span>-->
                                <!--    </td>-->
                                <!--</tr>-->
                    
                                <tr>
                                    <th>Student Number Call Status</th>
                                    <td>
                                        <select class="form-select form-control" id="scallStatus" name="scallStatus" required>
                                            <option value="">Select Status</option>
                                            <option value="Answered">Answered</option>
                                            <option value="Not Answered">Not Answered</option>
                                            <option value="Switched Off">Switched Off</option>
                                            <option value="Busy">Busy</option>
                                            <option value="Verified">Verified</option>
                                        </select>
                                    </td>
                                </tr>
                    
                                <tr>
                                    <th>Parents Number Call Status</th>
                                    <td>
                                        <select class="form-select form-control" id="pcallStatus" name="pcallStatus" required>
                                            <option value="">Select Status</option>
                                            <option value="Answered">Answered</option>
                                            <option value="Not Answered">Not Answered</option>
                                            <option value="Switched Off">Switched Off</option>
                                            <option value="Busy">Busy</option>
                                            <option value="Verified">Verified</option>
                                        </select>
                                    </td>
                                </tr>
                    
                                <tr>
                                    <th>Remarks</th>
                                    <td>
                                        <textarea class="form-control"
                                                  id="remarks" name="remarks"
                                                  rows="4"
                                                  placeholder="Enter remarks"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-center">
                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    Cancel
                </button>

                <a href="#" id="confirmCallBtn"
                   class="btn btn-success">
                    <i class="fa fa-check me-1"></i>
                    Update Record
                </a>
            </div>
        </div>
        <div id="responseMsg3"></div>
    </div>
</div>
<!-- DataTables JS & Buttons -->
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

<script>
$('#admitModal .btn-secondary').click(function () {
        $('#admitModal').modal('hide');
    });
$(document).ready(function () {
    // Initialize DataTable with action column
   $('#studentTable').DataTable({
    paging: true,
    searching: true,
    ordering: true,
    info: true,
    pageLength: 10,
    lengthMenu: [[10, 40, 70, -1], [10, 40, 70, "All"]],
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copy',
            title: 'Student_Report'
        },
        {
            extend: 'csv',
            title: 'Student_Report'
        },
        {
            extend: 'excel',
            title: 'Student_Report'
        },
        {
            extend: 'pdf',
            title: 'Student_Report',
            orientation: 'landscape',
            pageSize: 'A4'
        },
        {
            extend: 'print',
            title: 'Student Report'
        }
    ],
    language: {
        emptyTable: "No Records Found",
        search: "",
        searchPlaceholder: "Search Application No, Name, Department..."
    },
    columnDefs: [
        { orderable: false, targets: [0, 5] }
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
            url: 'save.php?request=deleteStudentEntry',
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
                        window.location.href = './studentAdmitCardList.php';
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
    
    $(document).on('click', '.call-btn', function () {

        let id = $(this).data('id');
        let appno = $(this).data('appno');
        let fullname = $(this).data('fullname');
        let sMobileStatus = $(this).data('smobilestatus');
        let pMobileStatus = $(this).data('pmobilestatus');
        let mobileDesc = $(this).data('mobiledesc');
        let sMobile = $(this).data('sMobile');
        let pMobile = $(this).data('pMobile');
         
        $("#scallStatus").val(sMobileStatus).trigger('change');
        $("#pcallStatus").val(pMobileStatus).trigger('change');
        $("#remarks").val(mobileDesc);
        $('#modalCallAppNo').text(appno);
        $('#modalCallFullName').text(fullname);
        $('#modalCallSMobile').text(sMobile);
        $('#modalCallPMobile').text(pMobile);
        // Store ID in delete button
        $('#confirmCallBtn').data('id', id);
        $('#confirmCallBtn').data('appno', appno);

        $('#callModal').modal('show');
    });
    
    $(document).on('click', '#confirmCallBtn', function () {

        let id = $(this).data('id');
        let appno = $(this).data('appno');
        let scallStatus = $("#scallStatus").val();
        let pcallStatus = $("#pcallStatus").val();
        let remarks = $("#remarks").val();
        if(id=='' || appno==''){
            alert("Studnet Detail is missing");
        }else if(scallStatus==''){
            $("#scallStatus").focus();
        }else if(pcallStatus==''){
            $("#pcallStatus").focus();
        }else if(remarks==''){
            $("#remarks").focus();
        }else{
            $.ajax({
                url: 'save.php?request=callStudentMobileVerification',
                type: 'POST',
                data: {
                    id: id,
                    appno: appno,
                    scallStatus:scallStatus,
                    pcallStatus:pcallStatus,
                    remarks:remarks
                },
                    dataType: 'json',
                beforeSend: function () {
                    $("#responseMsg3").html(
                        '<div class="alert alert-info">Saving...</div>'
                    );
                },
                success: function(response) {
                    console.log(response,"response");
                   if (response.status == "success") {
                        $("#responseMsg3").html(
                            '<div class="alert alert-success">' + response.message + '</div>'
                        );
                        // Optionally reset form
                        $('#deleteModal').modal('hide');
                        // Redirect or reload after a delay
                        setTimeout(function () {
                            window.location.href = './studentCounsellorList.php';
                        }, 1000);
                    } else {
                        $("#responseMsg3").html(
                            '<div class="alert alert-danger">' + response.message + '</div>'
                        );
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                    $("#responseMsg3").html(
                        '<div class="alert alert-danger">Something went wrong: ' + error + '</div>'
                    );
                }
            });
        }
    });
    $('.btn-close, .btn-secondary').on('click', function () {
        $('#callModal').modal('hide');
    });
});
</script>