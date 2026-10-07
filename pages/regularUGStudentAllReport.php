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
                                        <h5>Regular UG Student Reported List</h5>
                                    </div>
                                    <div class="card-body table-border-style">
                                        <div class="table-responsive">
                                            <table id="studentTable" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Appliaction No</th>
                                                        <th>First Name</th>
                                                        <th>Last Name</th>
                                                        <th>DOB</th>
                                                        <th>Gender</th>
                                                        <th>Batch</th>
                                                        <th>Blood Group</th>
                                                        <th>Applicant Type</th>
                                                        <th>Department</th>
                                                        <th>Industry Partner</th>
                                                        <th>Student Mobile NO</th> 
                                                        <th>Student Email ID</th>
                                                        <th>Father Name</th>
                                                        <th>Mother Name</th>
                                                        <th>Parents Mobile NO</th>
                                                        <th>Parents Email ID</th>
                                                        <th>Address</th>
                                                        <th>Student Type</th>
                                                        <th>Admit Card Status</th>
                                                        <th>Admit Card Issued Date</th>
                                                        <th>Admit Card Email ID</th>
                                                        <th>ID Card Status</th>
                                                        <th>ID Card Issued Date</th>
                                                        <th>Student Mobile Verification Status</th>
                                                        <th>Parents Mobile Verification Status</th>
                                                        <th>Hostel Status</th>
                                                        <th>Hostel Hostel Name</th>
                                                        <th>Hostel Room Category</th>
                                                        <th>Hostel Room No</th>
                                                        <th>Hostel Payment Status</th>
                                                        <th>Hostel Reported Date</th>
                                                        <th>Hostel Checked-In Status</th>
                                                        <th>Hostel Checked-In Date</th>
                                                        <th>Student Photo</th>
                                                        <th>Student Signature</th>
                                                        <th>Family Photo</th>
                                                        <th>Parent Signature</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql = "SELECT * 
                                                            FROM student_details
                                                            LEFT JOIN department ON dept_id=s_department
                                                            LEFT JOIN state ON st_id=s_state
                                                            LEFT JOIN blood_group ON bg_id=s_blood_group
                                                            LEFT JOIN hostel ON h_id=s_h_id
                                                            LEFT JOIN room_category ON rc_id=s_rc_id
                                                            WHERE s_status='1' AND s_reportedStatus='REPORTED' AND s_course_type='REGULAR' AND dept_name!='M.E. COMPUTER SCIENCE AND ENGINEERING' AND dept_name!='M.E. - POWER SYSTEMS ENGINEERING' AND dept_name!='M.E. - MANUFACTURING ENGINEERING'
                                                            ORDER BY s_idcardDate DESC";
                                                        $result = mysqli_query($conn, $sql);
                                                        if(mysqli_num_rows($result) > 0){
                                                            $i = 1;
                                                            while($value = mysqli_fetch_assoc($result)){
                                                                $id = $value['s_id'];
                                                                $appno = $value['s_application_number'];
                                                                $fullname = $value['s_first_name'].' '.$value['s_last_name'];
                                                                $dob = date('d-m-Y', strtotime($value['s_dob']));
                                                                $admitCardIssuedDate = !empty($value['s_admittedDate']) 
                                                                    ? date('d-m-Y h:i A', strtotime($value['s_admittedDate'])) 
                                                                    : '-';
                                                                
                                                                $idCardIssuedDate = !empty($value['s_idcardDate']) 
                                                                    ? date('d-m-Y h:i A', strtotime($value['s_idcardDate'])) 
                                                                    : '-';
                                                                
                                                                $hostelReportedDate = !empty($value['s_hos_cDate']) 
                                                                    ? date('d-m-Y h:i A', strtotime($value['s_hos_cDate'])) 
                                                                    : '-';
                                                                
                                                                $hostelCheckededDate = !empty($value['s_hos_checkIn_cDate']) 
                                                                    ? date('d-m-Y h:i A', strtotime($value['s_hos_checkIn_cDate'])) 
                                                                    : '-';
                                                                $sphotourl = 'https://avcampusadmissions.com/idcard/uploads/2026/' . $appno . '/' . $value['s_photo'];
                                                                $ssigurl = 'https://avcampusadmissions.com/idcard/uploads/2026/' . $appno . '/' . $value['s_signature'];
                                                                $psigurl = 'https://avcampusadmissions.com/idcard/uploads/2026/' . $appno . '/' . $value['s_parent_signature'];
                                                                $familyurl = 'https://avcampusadmissions.com/idcard/uploads/2026/' . $appno . '/' . $value['s_family_photo'];
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_application_number']); ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_first_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_last_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($dob); ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_gender']); ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_batch']); ?></td>
                                                        <td><?php echo htmlspecialchars($value['bg_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_course_type']); ?></td>
                                                        <td><?php echo htmlspecialchars($value['dept_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_industryPartner']); ?></td>
                                                        <td>
                                                           <?php echo $value['s_mobile_no']; ?>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($value['s_emailId']); ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_fathername']); ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_mothername']); ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_alternate_mobile']); ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_father_email']); ?></td>
                                                        <td>
                                                            <?php echo htmlspecialchars($value['s_address1']); ?>
                                                            <?php if($value['s_address2']!=''){ ?>
                                                            <?php echo htmlspecialchars($value['s_address2']); ?>,<br>
                                                            <?php } ?>
                                                            <?php echo htmlspecialchars($value['s_area']); ?>
                                                            <?php echo htmlspecialchars($value['s_city']); ?>
                                                            <?php echo htmlspecialchars($value['s_district']); ?>,
                                                            <?php echo htmlspecialchars($value['st_name']); ?>-
                                                            <?php echo htmlspecialchars($value['s_pincode']); ?>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($value['s_stu_type']); ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_admittedStatus']); ?></td>
                                                        <td><?php echo htmlspecialchars($admitCardIssuedDate); ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_admitCardEmail']); ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_idcardStatus']); ?></td>
                                                        <td><?php echo htmlspecialchars($idCardIssuedDate); ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_smobile_Status']); ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_pmobile_Status']); ?></td>
                                                        <td>
                                                            <?php if($value['s_hosStatus']=='REPORTED'){ ?>
                                                                HOSTEL STUDENT
                                                            <?php }else{ ?>
                                                                NO HOSTEL STUDENT
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if($value['s_hosStatus']=='REPORTED'){ ?>
                                                                <?php echo htmlspecialchars($value['h_name']); ?>
                                                            <?php }else{ ?>
                                                               -
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if($value['s_hosStatus']=='REPORTED'){ ?>
                                                                <?php echo htmlspecialchars($value['rc_name']); ?>
                                                            <?php }else{ ?>
                                                                -
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if($value['s_hosStatus']=='REPORTED'){ ?>
                                                                <?php echo htmlspecialchars($value['s_hos_roomno']); ?>
                                                            <?php }else{ ?>
                                                                -
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if($value['s_hosStatus']=='REPORTED'){ ?>
                                                                <?php echo htmlspecialchars($value['s_hosPaymentStatus']); ?>
                                                            <?php }else{ ?>
                                                                -
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if($value['s_hosStatus']=='REPORTED'){ ?>
                                                                <?php echo htmlspecialchars($hostelReportedDate); ?>
                                                            <?php }else{ ?>
                                                                -
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if($value['s_hosStatus']=='REPORTED'){ ?>
                                                                <?php echo htmlspecialchars($value['s_hos_checkIn_status']); ?>
                                                            <?php }else{ ?>
                                                                -
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if($value['s_hosStatus']=='REPORTED'){ ?>
                                                                <?php echo htmlspecialchars($hostelCheckededDate); ?>
                                                            <?php }else{ ?>
                                                                -
                                                            <?php } ?>
                                                        </td>
                                                        <td class="action-icons">
                                                            <?php if (!empty($value['s_photo'])) { ?>
                                                                <a href="<?php echo htmlspecialchars($sphotourl); ?>" targe="_blank" >
                                                                    <?php echo htmlspecialchars($sphotourl); ?>
                                                                </a>
                                                                <!--<img src="<?php echo htmlspecialchars($sphotourl); ?>" style="height:300px;width:300px;"/>-->
                                                            <?php } ?>
                                                        </td>
                                                        <td class="action-icons">
                                                            <?php if (!empty($value['s_signature'])) { ?>
                                                                <a href="<?php echo htmlspecialchars($ssigurl); ?>" targe="_blank" >
                                                                    <?php echo htmlspecialchars($ssigurl); ?>
                                                                </a>
                                                            <?php } ?>
                                                        </td>
                                                         <td>
                                                            <?php if (!empty($value['s_family_photo'])) { ?>
                                                                <a href="<?php echo htmlspecialchars($familyurl); ?>" targe="_blank" >
                                                                    <?php echo htmlspecialchars($familyurl); ?>
                                                                </a>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if (!empty($value['s_parent_signature'])) { ?>
                                                                <a href="<?php echo htmlspecialchars($psigurl); ?>" targe="_blank" >
                                                                    <?php echo htmlspecialchars($psigurl); ?>
                                                                </a>
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
                    <i class="fas fa-success-alt me-2"></i> Confirm ID Card Issued
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <i class="fas fa-exclamation-triangle text-warning fa-4x mb-3"></i>

                <h5>Are you sure ID Card Issue?</h5>
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
                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    Cancel
                </button>

                <a href="#" id="confirmDeleteBtn"
                   class="btn btn-primary">
                    <i class="fas fa-trash-alt me-1"></i>
                    ID Card Issued
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
                title: 'Regular UG Student Reported List',
                exportOptions: {
                    columns: ':not(:last-child)'
                },
                text: '<i class="fa fa-copy"></i> Copy'
            },
            {
                extend: 'excelHtml5',
                title: 'Regular UG Student Reported List',
                text: '<i class="fa fa-file-excel"></i> Excel',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'csv',
                title: 'Regular UG Student Reported List',
                exportOptions: {
                    columns: ':not(:last-child)'
                },
                text: '<i class="fa fa-file-csv"></i> CSV'
            },
            {
                extend: 'pdf',
                title: 'Regular UG Student Reported List',
                exportOptions: {
                    columns: ':not(:last-child)'
                },
                text: '<i class="fa fa-file-pdf"></i> PDF'
            },
            {
                extend: 'print',
                title: 'Regular UG Student Reported List',
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
            url: 'save.php?request=approveStudentIDIssued',
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
                        window.location.href = './idcardEligibleList.php';
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