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
    .table.table-sm td, .table.table-sm th {
    padding: 0.6rem 0rem !important;
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
                                        <h5>Student Programme Migration</h5>
                                        
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
                                                        <th>Status</th>
                                                        <th>Action</th>
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
                                                                $department = $value['dept_code'];
                                                                $admitStatus = $value['s_admittedStatus'];
                                                                $reportedStatus = $value['s_reportedStatus'];
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td><?php echo htmlspecialchars($value['s_application_number']); ?></td>
                                                        <td><?php echo htmlspecialchars($fullname); ?></td>
                                                        <td><?php echo htmlspecialchars($department); ?></td>
                                                        <td>
                                                            <?php if($admitStatus=='NOT ISSUED'){ ?>
                                                            <button class="btn btn-danger btn-sm">
                                                                <a href="javascript:void(0);" class="admit-btn text-white" data-id="<?php echo $id; ?>" data-appno="<?php echo $appno; ?>" data-fullname="<?php echo $fullname; ?>"
                                                               title="Admit Student">
                                                                ADMIT CARD NOT ISSUED
                                                                </a>
                                                            </button>
                                                            <?php }else{ ?>
                                                            <button class="btn btn-success btn-sm">
                                                                ADMIT CARD  ISSUED
                                                            </button>
                                                            <?php } ?>
                                                             <?php if($reportedStatus=='NOT REPORTED'){ ?>
                                                            <button class="btn btn-danger btn-sm">
                                                                NOT REPORTED
                                                            </button>
                                                            <?php }else{ ?>
                                                            <button class="btn btn-success btn-sm">
                                                                REPORTED
                                                            </button>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <!-- Edit -->
                                                            <?php if(isset($prev['69'])=='Y'){ ?>
                                                            <button class="btn btn-primary btn-sm">
                                                               <a href="javascript:void(0);" class="delete-btn text-white" data-id="<?php echo $id; ?>" data-appno="<?php echo $appno; ?>" data-fullname="<?php echo $fullname; ?>"  data-department="<?php echo $department; ?>"
                                                                   title="Delete Student">
                                                                    <i class="fas fa-edit text-white"></i>Edit
                                                                </a>
                                                            </button>
                                                            <?php } ?>
                                                             <?php if(isset($prev['70'])=='Y'){ ?>
                                                             <a href="studentProfile.php?id=<?php echo encryptId($id); ?>&appno=<?php echo encryptId($appno); ?>&type=View&redirect=studentProgrameList"
                                                                   title="View" class="text-white">
                                                                <button class="btn btn-warning btn-sm">
                                                                    <i class="fas fa-user text-white"></i> Profile
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
<!-- Change Programme Modal -->
<div class="modal fade" id="changeProgrammeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">

            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exchange-alt me-2"></i>
                    Confirm Programme Change
                </h5>
                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <div class="text-center mb-3">
                    <i class="fas fa-user-edit text-primary fa-4x mb-3"></i>
            
                    <h5>Are you sure?</h5>
            
                    <p class="text-muted">
                        You are about to change this student's programme.
                    </p>
                </div>
            <form id="changeProgrammeForm">
                <table class="table table-bordered table-striped table-sm align-middle mb-0">
                    <tbody>
                        <tr>
                            <th width="35%" class="bg-light">
                                Application No
                            </th>
                            <td>
                                <span id="modalAppNo"></span>
                            </td>
                        </tr>
            
                        <tr>
                            <th class="bg-light">
                                Student Name
                            </th>
                            <td>
                                <span id="modalFullName"></span>
                            </td>
                        </tr>
            
                        <tr>
                            <th class="bg-light">
                                Current Department
                            </th>
                            <td>
                                <span id="modalDepartment"></span>
                                <input type="hidden" id="oldDept" name="oldDept" />
                            </td>
                        </tr>
            
                        <tr>
                            <th class="bg-light">
                                Select New Department
                                <sup class="text-danger">*</sup>
                            </th>
            
                            <td>
                                <select class="form-select form-select-sm form-control"
                                        id="dept"
                                        name="dept"
                                        required>
                                    <option value="">
                                        Select Department
                                    </option>
            
                                    <?php
                                    $deptQry = mysqli_query(
                                        $conn,
                                        "SELECT dept_id, dept_name
                                         FROM department
                                         WHERE dept_status='1'
                                         ORDER BY dept_name ASC"
                                    );
            
                                    while($row = mysqli_fetch_assoc($deptQry))
                                    {
                                    ?>
                                        <option value="<?php echo $row['dept_id']; ?>">
                                            <?php echo htmlspecialchars($row['dept_name']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">
                                Description
                                <sup class="text-danger">*</sup>
                            </th>
            
                            <td>
                                <textarea class="form-control" name="desc" id="desc" rows="3"><?php echo $deptDesc; ?></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
                <div id="responseMsg"></div>
            
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer justify-content-center">

                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    Cancel
                </button>

                <button type="button"
                        id="confirmProgrammeBtn"
                        class="btn btn-primary">
                    <i class="fas fa-sync-alt me-1"></i>
                    Update Programme
                </button>

            </div>

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
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        language: {
            emptyTable: "No Records Found"
        },
        columnDefs: [
            { orderable: false, targets: [0, 3] }
        ]
    });

     
    
   $(document).on('click', '.delete-btn', function () {

        let id = $(this).data('id');
        let appno = $(this).data('appno');
        let fullname = $(this).data('fullname');
        let department = $(this).data('department');
    
        $('#modalAppNo').text(appno);
        $('#modalFullName').text(fullname);
        $('#modalDepartment').text(department);
        $("#oldDept").val(department);
        // Store ID in delete button
        $('#confirmProgrammeBtn').data('id', id);
        $('#confirmProgrammeBtn').data('appno', appno);

        $('#changeProgrammeModal').modal('show');
    });
    
    $(document).on('click', '#confirmProgrammeBtn', function () {
        let id = $(this).data('id');
        let appno = $(this).data('appno');
        let dept = $('#dept').val();
        let desc=$('#desc').val();
        let oldDept=$("#oldDept").val();
        if ($('#dept').val() == '') {
            $('#dept')[0].reportValidity();
            return false;
        }else  if ($('#dept').val() == '') {
            $('#desc')[0].reportValidity();
            return false;
        }else{
            $.ajax({
                url: 'save.php?request=updateStudentDepartment',
                type: 'POST',
                data: {
                    id: id,
                    appno: appno,
                    oldDept:oldDept,
                    dept:dept,
                    desc:desc
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
                        $('#changeProgrammeModal').modal('hide');
                        // Redirect or reload after a delay
                        setTimeout(function () {
                            window.location.href = './studentProgrameList.php';
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
        }
    });
    
    $('.btn-close, .btn-secondary').on('click', function () {
        $('#changeProgrammeModal').modal('hide');
    });
});
</script>