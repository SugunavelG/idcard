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
                                        <h5>Bag Entry List</h5>
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
                                                        <th>Bag Issued Date</th>
                                                        <th>Bag Status</th>
                                                        <th>ID Status</th>
                                                         <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql = "SELECT * 
                                                            FROM student_details
                                                            LEFT JOIN department ON dept_id=s_department
                                                            WHERE s_status='1' AND s_reportedStatus='REPORTED' AND s_idcardStatus='ISSUED'
                                                            ORDER BY FIELD(s_bagStatus,'NOT ISSUED','ISSUED') DESC";
                                                        $result = mysqli_query($conn, $sql);
                                                        if(mysqli_num_rows($result) > 0){
                                                            $i = 1;
                                                            while($value = mysqli_fetch_assoc($result)){
                                                                $id = $value['s_id'];
                                                                $appno = $value['s_application_number'];
                                                                $fullname = $value['s_first_name'].' '.$value['s_last_name'];
                                                                $bagIssuedDate = date('d-m-Y h:i A', strtotime($value['s_bagDate']));
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                       
                                                        <td><?php echo htmlspecialchars($value['s_application_number']); ?></td>
                                                        <td><?php echo htmlspecialchars($fullname); ?></td>
                                                        <td><?php echo htmlspecialchars($value['dept_code']); ?></td>
                                                         <td class="action-icons">
                                                            <?php if($value['s_bagStatus'] == 'ISSUED'){ ?>
                                                                <?php echo $bagIssuedDate;?>
                                                            <?php }else{ ?>
                                                                -
                                                            <?php } ?>
                                                        </td>
                                                        <td class="action-icons">
                                                            <?php if($value['s_bagStatus'] == 'NOT ISSUED'){ ?>
                                                                <button class="btn btn-danger btn-sm">BAG NOT ISSUED</button>
                                                            <?php } else { ?>
                                                                <button class="btn btn-success btn-sm">BAG ISSUED</button>
                                                            <?php } ?>
                                                        </td>
                                                        <td class="action-icons">
                                                            <?php if($value['s_idcardStatus'] == 'NOT ISSUED'){ ?>
                                                                <button class="btn btn-danger btn-sm">ID CARD NOT ISSUED</button>
                                                            <?php } else { ?>
                                                                <button class="btn btn-success btn-sm">ID CARD ISSUED</button>
                                                            <?php } ?>
                                                        </td>
                                                        
                                                         <td class="action-icons">
                                                             <!-- View -->
                                                            <?php if(isset($prev['31'])=='Y'){ ?>
                                                                 <!-- View -->
                                                                <a href="studentProfile.php?id=<?php echo encryptId($id); ?>&appno=<?php echo encryptId($appno); ?>&type=View&redirect=bagEligibleList"
                                                                   title="View" class="text-white">
                                                                    <button class="btn btn-warning btn-sm">
                                                                        <i class="fas fa-user text-white"></i>Profile
                                                                    </button>
                                                                </a>
                                                            <?php } ?>
                                                             <!--Edit-->
                                                             <?php if(isset($prev['30'])=='Y'){ ?>
                                                              <?php if($value['s_bagStatus'] == 'NOT ISSUED'){ ?>
                                                                <button class="btn btn-primary btn-sm text-white">
                                                                   <a href="javascript:void(0);"
                                                                   class="delete-btn text-white"
                                                                   data-id="<?php echo $id; ?>"
                                                                   data-appno="<?php echo $appno; ?>"
                                                                   data-fullname="<?php echo $fullname; ?>"
                                                                   title="Approved / Pending">
                                                                    <i class="fas fa-edit text-white"></i> Edit
                                                                </a>
                                                            </button>
                                                            <?php }  ?>
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
                                                         WHERE s_status='1'";
                                                $result1 = mysqli_query($conn, $sql1);
                                                $totalCount = mysqli_num_rows($result1);
                                                
                                                
                                                $sql2 = "SELECT * FROM student_details
                                                         WHERE s_status='1'
                                                         AND s_reportedStatus='REPORTED' AND s_bagStatus='ISSUED'";
                                                $result2 = mysqli_query($conn, $sql2);
                                                $bagIssuedCount = mysqli_num_rows($result2);
                                            
                                                $bagNotIssuedCount = $totalCount - $bagIssuedCount;
                                                
                                                $sql3 = "SELECT * FROM student_details
                                                         WHERE s_status='1' AND s_reportedStatus='REPORTED'";
                                                $result3 = mysqli_query($conn, $sql3);
                                                $reportedCount = mysqli_num_rows($result3);
                                                
                                                $sql4 = "SELECT * FROM student_details
                                                         WHERE s_status='1' AND s_reportedStatus='REPORTED' AND s_idcardStatus='ISSUED'";
                                                $result4 = mysqli_query($conn, $sql4);
                                                $idcardIssuedCount = mysqli_num_rows($result4);
                                                ?>
                                                <tfoot>
                                                   <tr class="text-center">
                                                        <th colspan="2">
                                                            Total Students:
                                                            <button class="btn btn-primary text-white btn-sm">
                                                                <?php echo $totalCount; ?>
                                                            </button>
                                                        </th>
                                                    
                                                        <th colspan="2">
                                                            Reported Students:
                                                            <button class="btn btn-success text-white btn-sm">
                                                                <?php echo $reportedCount; ?>
                                                            </button>
                                                        </th>
                                                        <th colspan="1">
                                                            ID Card Issued:
                                                            <button class="btn btn-info text-white btn-sm">
                                                                <?php echo $idcardIssuedCount; ?>
                                                            </button>
                                                        </th>
                                                        <th colspan="1">
                                                            Bag Issued Count:
                                                            <button class="btn btn-warning text-white btn-sm">
                                                                <?php echo $bagIssuedCount; ?>
                                                            </button>
                                                        </th>
                                                    
                                                        <th colspan="2">
                                                            Bag Not Issued Count:
                                                            <button class="btn btn-danger text-white btn-sm">
                                                                <?php echo $bagNotIssuedCount; ?>
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
                    <i class="fas fa-success-alt me-2"></i> Confirm Bag Issued
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <i class="fas fa-exclamation-triangle text-warning fa-4x mb-3"></i>

                <h5>Are you sure Bag Issue?</h5>
                <!--<p class="text-muted mb-3">-->
                <!--    You are about to permanently delete this student record.-->
                <!--</p>-->

                <div class="card bg-light border-0">
                    <div class="card-body text-start">
                        <table class="table table-bordered align-middle">
                            <tbody>
                                <tr>
                                    <th width="30%">Application No</th>
                                    <td>
                                        <span id="modalAppNo"></span>
                                    </td>
                                </tr>
                        
                                <tr>
                                    <th>Student Name</th>
                                    <td>
                                        <span id="modalFullName"></span>
                                    </td>
                                </tr>
                        
                                <tr>
                                    <th>
                                        Bag Status <sup class="text-danger">*</sup>
                                    </th>
                                    <td>
                                        <select class="form-select form-control"
                                                id="issuedStatus"
                                                name="issuedStatus"
                                                <?php echo $disabled; ?>
                                                required>
                                            <option value="">Select Status</option>
                        
                                            <option value="ISSUED">
                                                ISSUED
                                            </option>
                        
                                            <option value="NOT ISSUED">
                                                NOT ISSUED
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                        
                                <tr>
                                    <th>Description</th>
                                    <td>
                                        <textarea class="form-control"
                                                  id="description"
                                                  name="description"
                                                  rows="3"
                                                  placeholder="Enter Remarks"><?php echo $description ?? ''; ?></textarea>
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

                <a href="#" id="confirmDeleteBtn"
                   class="btn btn-success">
                    <i class="fas fa-edit-alt me-1"></i>
                    Update Status
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
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        language: {
            emptyTable: "No Records Found"
        },
        columnDefs: [
            { orderable: false, targets: [0, 1] }
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
        let issuedStatus=$("#issuedStatus").val();
        let description=$("#description").val();
        if(issuedStatus==''){
            $("#issuedStatus").focus();
        }else{
            $.ajax({
                url: 'save.php?request=approveStudentBagIssued',
                type: 'POST',
                data: {
                    id: id,
                    appno: appno,
                    issuedStatus:issuedStatus,
                    description:description
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
                            window.location.href = './bagEligibleList.php';
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
        $('#deleteModal').modal('hide');
    });
});
</script>