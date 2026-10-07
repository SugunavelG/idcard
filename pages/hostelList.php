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
   $id=decryptId($_GET['id']);
   
   $type=$_GET['type'];
   if($type=='View' ){
       $disabled='disabled';
       $readonly='disabled';
   }else{
       $disabled='';
   }
   if($type=='Edit' ){
       $readonly='readonly';
   }else{
       $readonly='';
   }
   $sql="SELECT * FROM hostel WHERE h_id='".$id."'";
   //echo $sql;
   //exit;
   $result=mysqli_query($conn,$sql);
   $numrows=mysqli_num_rows($result);
   $fetchArr=mysqli_fetch_array($result);
   if($numrows>0){
       $hosID=$fetchArr['h_id'];
       $hosName=$fetchArr['h_name'];
       $hosStatus=trim($fetchArr['h_status']);
   }else{
       $hosID='';
       $hosName='';
       $hosStatus='';
   }
   ?>
   <style>
       label.error,
span.error {
    color: #dc3545;
    font-size: 14px;
    margin-top: 5px;
    display: block;
}
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
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- [ Main Content ] start -->
    <section class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ breadcrumb ] start -->
                            <!--<div class="page-header">-->
                            <!--    <div class="page-block">-->
                            <!--        <div class="row align-items-center">-->
                            <!--            <div class="col-md-12">-->
                            <!--                <div class="page-header-title">-->
                            <!--                    <h5 class="m-b-10">Department <?php echo $type; ?></h5>-->
                            <!--                </div>-->
                                             
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <!-- [ breadcrumb ] end -->
                            <!-- [ Main Content ] start -->
                            <div class="row">
                               
                                <div class="col-xl-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Hostel List <?php echo $utStatus; ?></h5>
                                        </div>
                                        <div class="card-body table-border-style">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="departmentTable" >
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Hostel Name</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                       <?php
                                                            $sql1 = "SELECT * FROM hostel WHERE h_status='1' ORDER BY h_id DESC";
                                                            $result1 = mysqli_query($conn, $sql1);
                                                            if(mysqli_num_rows($result1) > 0){
                                                                $i = 1;
                                                                while($value = mysqli_fetch_assoc($result1)){
                                                                    $hosid=$value['h_id'];
                                                                    $hos_Name=$value['h_name'];
                                                                    $status=$value['h_status'];
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $i++; ?></td>
                                                                <td><?php echo htmlspecialchars($hos_Name); ?></td>
                                                                <td>
                                                                    <?php if($status == '1'){ ?>
                                                                        <span class="badge bg-success text-white">Active</span>
                                                                    <?php } else { ?>
                                                                        <span class="badge bg-danger text-white">Inactive</span>
                                                                    <?php } ?>
                                                                </td>
                                                                <td>
                                                                    <?php if(isset($prev['38'])=='Y'){ ?>
                                                                    <!-- Edit -->
                                                                    <button class="btn btn-primary btn-sm">
                                                                        <a href="hostelList.php?id=<?php echo encryptId($hosid); ?>&type=Edit" 
                                                                           title="Edit" class="text-white">
                                                                            <i class="fas fa-edit text-white"></i> Edit
                                                                        </a>
                                                                    </button>
                                                                    <?php } ?>
                                                                    <?php if(isset($prev['39'])=='Y'){ ?>
                                                                    <button class="btn btn-danger btn-sm">
                                                                        <a href="javascript:void(0);" class="delete-btn text-white" data-id="<?php echo $hosid; ?>" data-deptname="<?php echo $hos_Name; ?>" data-status="<?php echo $status; ?>"
                                                                           title="Delete Student">
                                                                            <i class="fas fa-trash-alt text-white"></i> Delete
                                                                        </a>
                                                                    </button>
                                                                    <?php } ?>
                                                                    <?php if(isset($prev['40'])=='Y'){ ?>
                                                                    <button class="btn btn-warning btn-sm">
                                                                        <a href="hostelList.php?id=<?php echo encryptId($hosid); ?>&type=View" 
                                                                           title="View" class="text-white">
                                                                            <i class="fas fa-eye text-white"></i> View
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
                                <!-- [ stiped-table ] end -->
                                <?php if(isset($prev['37'])=='Y'){ ?>
                                <div class="col-xl-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><?php echo $type; ?> Hostel</h5>
                                        </div>
                                        <div class="card-body">
                                            <form id="departmentForm">
                                                <input type="hidden" name="hosAutoID" id="hosAutoID" value="<?php echo $hosID; ?>" />
                                                <div class="mb-3">
                                                    <label class="form-label">Hostel<sup class="text-danger">*</sup></label>
                                                    <input type="text" class="form-control" id="hos" name="hos" value="<?php echo $hosName; ?>" <?php echo $disabled; ?>>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Status<sup class="text-danger">*</sup></label>
                                                    <select class="form-control" id="status" name="status" <?php echo $disabled; ?>>
                                                        <option value="">Select Status</option>
                                                        <option value="1" <?php if(empty($hosStatus) || $hosStatus == '1') echo 'selected'; ?>>
                                                            Active
                                                        </option>
                                                        <option value="2" <?php if($hosStatus == '2') echo 'selected'; ?>>
                                                            Inactive
                                                        </option>
                                                    </select>
                                                </div>
                                                <?php if(empty($hosID) && $type=='Add'){ ?>
                                                <button type="submit" class="btn btn-success float-right">
                                                    Save Hostel
                                                </button>
                                                <?php }else if(!empty($hosID) && $type=='Edit'){ ?>
                                                <button type="submit" class="btn btn-success float-right">
                                                    Update Hostel
                                                </button>
                                                <?php } ?>
                                            </form>
                                            <div id="responseMsg"></div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
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
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-trash-alt me-2"></i> Confirm Delete
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
    
                <div class="modal-body text-center">
                    <i class="fas fa-exclamation-triangle text-warning fa-4x mb-3"></i>
    
                    <h5>Are you sure?</h5>
                    <p class="text-muted mb-3">
                        You are about to permanently delete this hostel.
                    </p>
    
                    <div class="card bg-light border-0">
                        <div class="card-body text-start">
                            <p class="mb-2">
                                <strong>Hostel:</strong>
                                <span id="modalDepartment"></span>
                            </p>
                            <p class="mb-2">
                                <strong>Status :</strong>
                                <span id="modalStatus"></span>
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
                       class="btn btn-danger">
                        <i class="fas fa-trash-alt me-1"></i>
                        Delete Record
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
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script>
    $(document).ready(function () {
        $('#departmentTable').DataTable({
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
        
        $("#departmentForm").validate({
            rules: {
                hos: {
                    required: true,
                },
                status: {
                    required: true
                }
            },
            messages: {
                hos: {
                    required: "Please enter hostel",
                },
                status: {
                    required: "Please select status"
                }
            },
            errorElement: "span",
            errorPlacement: function (error, element) {
                error.addClass("text-danger");
                error.insertAfter(element);
            },
            submitHandler: function (form) {
                $.ajax({
                    url: "save.php?request=saveHostel&type=<?php echo $type;?>",
                    type: "POST",
                    dataType: "json",
                    data: $(form).serialize(),
    
                    beforeSend: function () {
                        $("#responseMsg").html(
                            '<div class="alert alert-info">Saving...</div>'
                        );
                    },
                    success: function (response) {
                        if (response.status === "success") {
                            $("#responseMsg").html(
                                '<div class="alert alert-success">' +
                                response.message +
                                '</div>'
                            );
                            setTimeout(function() {
                                $("#responseMsg").html('');
                            }, 3000);
                            $("#departmentForm")[0].reset();
                            window.location.href = './hostelList.php?type=Add';
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        } else {
                            $("#responseMsg").html(
                                '<div class="alert alert-danger">' +
                                response.message +
                                '</div>'
                            );
                            setTimeout(function() {
                                $("#responseMsg").html('');
                            }, 3000);
                        }
                    },
                    error: function () {
                        $("#responseMsg").html(
                            '<div class="alert alert-danger">Something went wrong.</div>'
                        );
                        setTimeout(function() {
                            $("#responseMsg").html('');
                        }, 3000);
                    }
                });
                return false;
            }
        });
        
        $(document).on('click', '.delete-btn', function () {
    
            let id = $(this).data('id');
            let deptname = $(this).data('deptname');
            let status = $(this).data('status');

            if (status == 1 || status == '1') {
                $('#modalStatus').text('Active');
            } else {
                $('#modalStatus').text('Inactive');
            }
            $('#modalDepartment').text(deptname);

            // Store ID in delete button
            $('#confirmDeleteBtn').data('id', id);
            $('#confirmDeleteBtn').data('deptname', deptname);
    
            $('#deleteModal').modal('show');
        });
        
        $(document).on('click', '#confirmDeleteBtn', function () {
    
            let id = $(this).data('id');
            let deptname = $(this).data('deptname');
    
            $.ajax({
                url: 'save.php?request=deleteHostel',
                type: 'POST',
                data: {
                    id: id,
                    deptname: deptname
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
                            window.location.href = './hostelList.php?type=Add';
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
