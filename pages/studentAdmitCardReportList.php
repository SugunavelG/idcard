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
                                        <h5>Student Admitted List</h5>
                                    </div>
                                    <div class="card-body table-border-style">
                                        <div class="table-responsive">
                                            <table id="studentTable" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>App No</th>
                                                        <th>Full Name</th>
                                                        <th>Gender</th>
                                                        <th>Blood Group</th>
                                                        <th>Applicant Type</th>
                                                        <th>Department</th>
                                                        <th>Industry Partner</th>
                                                         <th>Admit Card Status</th>
                                                        <th>Admit Card Issued Date</th>
                                                        <th>ID Card Status</th>
                                                        <th>ID Card Issued Date</th>
                                                         <th>Admission Head</th>
                                                       
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $cond = "s_status='1' AND s_reportedStatus='REPORTED' AND s_admittedStatus='ISSUED' AND s_course_type='REGULAR'";
                                                         
                                                        if ($userType == 'Super Admin' || $headName == 'Others') {
                                                            // Show all records
                                                        }else if ($userType == 'Admin' || $headName == 'Others') {
                                                            // Show all records
                                                        } elseif (!empty($headName)) {
                                                            $cond .= " AND s_admissionOwner='$headName'";
                                                        } else {
                                                            $cond .= " AND s_admissionOwner='$userName'";
                                                        }
                                                        $sql = "SELECT * FROM student_details
                                                            LEFT JOIN department ON dept_id=s_department
                                                            LEFT JOIN blood_group ON bg_id=s_blood_group
                                                            WHERE $cond ORDER BY s_id DESC";
                                                            
                                                        $result = mysqli_query($conn, $sql);
                                                        if(mysqli_num_rows($result) > 0){
                                                            $i = 1;
                                                            while($value = mysqli_fetch_assoc($result)){
                                                                $id = $value['s_id'];
                                                                $appno = $value['s_application_number'];
                                                                $fullname = $value['s_first_name'].' '.$value['s_last_name'];
                                                                $admissionOwner=$value['s_admissionOwner'];
                                                                $admittedDate = !empty($value['s_admittedDate']) && $value['s_admittedDate'] != '0000-00-00 00:00:00'
                                                                    ? date('d-m-Y h:i:s A', strtotime($value['s_admittedDate']))
                                                                    : '';
                                                                
                                                                $admitStatus = $value['s_admittedStatus'];
                                                                
                                                                $idCardDate = !empty($value['s_idcardDate']) && $value['s_idcardDate'] != '0000-00-00 00:00:00'
                                                                    ? date('d-m-Y h:i:s A', strtotime($value['s_idcardDate']))
                                                                    : '';
                                                                
                                                                $idCardStatus = $value['s_idcardStatus'];
                                                                
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_application_number']); ?></td>
                                                        <td><?php echo htmlspecialchars($fullname); ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_gender']); ?></td>
                                                        <td><?php echo htmlspecialchars($value['bg_name']); ?></td>
                                                        
                                                        <td><?php echo htmlspecialchars($value['s_course_type']); ?></td>
                                                         <td><?php echo htmlspecialchars($value['dept_code']); ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_industryPartner']); ?></td>

                                                        <td>
                                                             <?php if($admitStatus=='ISSUED'){ ?>
                                                            <button class="btn btn-success btn-sm">
                                                                 ADMIT CARD ISSUED
                                                            </button>
                                                            <?php }else{ ?>
                                                             <button class="btn btn-danger btn-sm">
                                                             ADMIT CARD NOT ISSUED
                                                            </button>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($admittedDate); ?></td>
                                                        <td>
                                                             <?php if($idCardStatus=='ISSUED'){ ?>
                                                            <button class="btn btn-success btn-sm">
                                                                 ID CARD ISSUED
                                                            </button>
                                                            <?php }else{ ?>
                                                             <button class="btn btn-danger btn-sm">
                                                             ID CARD NOT ISSUED
                                                            </button>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($idCardDate); ?></td>
                                                        <td><?php echo htmlspecialchars($admissionOwner); ?></td>
                                                        <td>
                                                            <!-- View -->
                                                             <?php if(isset($prev['89'])=='Y'){ ?>
                                                            <button class="btn btn-warning btn-sm">
                                                                 <a href="studentProfile.php?id=<?php echo encryptId($id); ?>&appno=<?php echo encryptId($appno); ?>&type=View&redirect=studentAdmitCardReportList"
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
            title: 'Regular Student Admit Card Issued Report',
            exportOptions: {
                columns: ':not(:last-child)'
            },
            text: '<i class="fa fa-copy"></i> Copy'
        },
        {
            extend: 'excel',
            title: 'Regular Student Admit Card Issued Report',
            exportOptions: {
                columns: ':not(:last-child)'
            },
            text: '<i class="fa fa-file-excel"></i> Excel'
        },
        {
            extend: 'csv',
            title: 'Regular Student Admit Card Issued Report',
            exportOptions: {
                columns: ':not(:last-child)'
            },
            text: '<i class="fa fa-file-csv"></i> CSV'
        },
        {
            extend: 'pdf',
            title: 'Regular Student Admit Card Issued Report',
            exportOptions: {
                columns: ':not(:last-child)'
            },
            text: '<i class="fa fa-file-pdf"></i> PDF'
        },
        {
            extend: 'print',
            title: 'Regular Student Admit Card Issued Report',
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
                        window.location.href = './studentEntryList.php';
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