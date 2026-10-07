<?php 
   session_start();
   include '../common/config.php';
   //print_r($_SESSION);
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
   //print_r($id);exit;
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
   $sql="SELECT * FROM users
        LEFT JOIN user_type ON ut_id=u_ut_type
        WHERE u_id='".$id."'";
   $result=mysqli_query($conn,$sql);
   $numrows=mysqli_num_rows($result);
   $fetchArr=mysqli_fetch_array($result);
   if($numrows>0){
       $uID=$fetchArr['u_id'];
       $utID=$fetchArr['u_ut_type'];
        $headName=$fetchArr['u_headName'];
       $uName=$fetchArr['u_name'];
       $userName=$fetchArr['u_username'];
       $uPassword=$fetchArr['u_password'];
       $status=$fetchArr['u_status'];
   }else{
       $uID='';
       $uName='';
       $userName='';
       $uPassword='';
       $status='';
       $headName='';
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
   </style>
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
                            <!--                    <h5 class="m-b-10">Users List</h5>-->
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
                                            <h5>Users List </h5>
                                        </div>
                                        <div class="card-body table-border-style">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="usersTable">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>User Type</th>
                                                            <th>User</th>
                                                            <th>Username</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                       <?php
                                                            $sql = "SELECT * FROM users
                                                            LEFT JOIN user_type ON ut_id=u_ut_type
                                                            WHERE u_status='Active' ORDER BY u_id DESC";
                                                            $result = mysqli_query($conn, $sql);
                                                            if(mysqli_num_rows($result) > 0){
                                                                $i = 1;
                                                                while($value = mysqli_fetch_assoc($result)){
                                                                    $uid=$value['u_id'];
                                                                    $uname=$value['u_name'];
                                                                    $status=$value['u_status'];
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $i++; ?></td>
                                                                <td><?php echo htmlspecialchars($value['ut_name']); ?></td>
                                                                <td><?php echo htmlspecialchars($value['u_name']); ?></td>
                                                                 <td><?php echo htmlspecialchars($value['u_username']); ?></td>
                                                                <td>
                                                                    <?php if($value['u_status'] == 'Active'){ ?>
                                                                        <span class="badge bg-success">Active</span>
                                                                    <?php } else { ?>
                                                                        <span class="badge bg-danger">Inactive</span>
                                                                    <?php } ?>
                                                                </td>
                                                                <td>
                                                                    <?php if(isset($prev['18'])=='Y'){ ?>
                                                                    <!-- Edit -->
                                                                    <a href="usersList.php?id=<?php echo encryptId($uid); ?>&type=Edit" 
                                                                       title="Edit">
                                                                        <i class="fas fa-edit text-primary"></i>
                                                                    </a>
                                                                    <?php } ?>
                                                                    <?php if(isset($prev['19'])=='Y'){ ?>
                                                                    <a href="javascript:void(0);" class="delete-btn" data-id="<?php echo $uid; ?>" data-utype="<?php echo $uname; ?>" data-status="<?php echo $status; ?>"
                                                                       title="Delete Student">
                                                                        <i class="fas fa-trash-alt text-danger"></i>
                                                                    </a>
                                                                    <?php } ?>
                                                                    <?php if(isset($prev['20'])=='Y'){ ?>
                                                                    <a href="usersList.php?id=<?php echo encryptId($uid); ?>&type=View" 
                                                                       title="View">
                                                                        <i class="fas fa-eye text-warning"></i>
                                                                    </a>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                                }
                                                            } else {
                                                            ?>
                                                            <tr>
                                                                <td colspan="3" class="text-center">No Records Found</td>
                                                            </tr>
                                                            <?php
                                                            }
                                                            ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- [ stiped-table ] end -->
                                <?php if(isset($prev['17'])=='Y'){ ?>
                                <div class="col-xl-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><?php echo $type; ?> User</h5>
                                        </div>
                                        <div class="card-body">
                                            <form id="userForm">
                                                <input type="hidden" name="uAutoID" id="uAutoID" value="<?php echo $uID; ?>" />
                                                <div class="mb-3">
                                                    <label class="form-label">User Type</label>
                                                    <select class="form-control" id="usertype" name="usertype" <?php echo $disabled; ?>>
                                                        <option value="">Select Status</option>
                                                        <?php
                                                            $sql = "SELECT * FROM user_type WHERE ut_status='Active' ORDER BY ut_id DESC";
                                                            $result = mysqli_query($conn, $sql);
                                                            if(mysqli_num_rows($result) > 0){
                                                                $i = 1;
                                                                foreach($result as $value){
                                                        ?>
                                                        <option value="<?php echo $value['ut_id']; ?>" <?php if(isset($utID) && $utID==$value['ut_id']) echo 'selected'; ?>><?php echo $value['ut_name']; ?></option>
                                                        <?php } } ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Team Head</label>
                                                    <select class="form-control" id="team_head" name="team_head" <?php echo $disabled; ?>>
                                                        <option value="" selected>Select Status</option>
                                                        <option value="Dr.P.Karthikeyan" <?php if(isset($headName) && $headName=='Dr.P.Karthikeyan') echo 'selected'; ?>>Dr.P.Karthikeyan</option>
                                                        <option value="Mrs.S.Noorjahan" <?php if(isset($headName) && $headName=='Mrs.S.Noorjahan') echo 'selected'; ?>>Mrs.S.Noorjahan</option>
                                                        <option value="Mr.CS.Vijay Kumar" <?php if(isset($headName) && $headName=='Mr.CS.Vijay Kumar') echo 'selected'; ?>>Mr.CS.Vijay Kumar</option>
                                                        <option value="Mr.Siva" <?php if(isset($headName) && $headName=='Mr.Siva') echo 'selected'; ?>>Mr.Siva</option>
                                                        <option value="Others" <?php if(isset($headName) && $headName=='Others') echo 'selected'; ?>>Others</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $uName; ?>" <?php echo $disabled; ?>>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Username</label>
                                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $userName; ?>" <?php echo $disabled; ?>>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Password</label>
                                                    <input type="text" class="form-control" id="password" name="password" value="<?php echo $uPassword; ?>" <?php echo $disabled; ?>>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select class="form-control" id="status" name="status" <?php echo $disabled; ?>>
                                                        <option value="">Select Status</option>
                                                        <option value="Active" selected <?php if(isset($status) && $status=='Active') echo 'selected'; ?>>Active</option>
                                                        <option value="Inactive" <?php if(isset($status) && $status=='Inactive') echo 'selected'; ?>>Inactive</option>
                                                    </select>
                                                </div>
                                                <?php if(empty($uID) && $type=='Add'){ ?>
                                                <button type="submit" class="btn btn-success float-right">
                                                    Save User
                                                </button>
                                                <?php }else if(!empty($uID) && $type=='Edit'){ ?>
                                                <button type="submit" class="btn btn-success float-right">
                                                    Update User
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
                    You are about to permanently delete this user type.
                </p>

                <div class="card bg-light border-0">
                    <div class="card-body text-start">
                        <p class="mb-2">
                            <strong>User type :</strong>
                            <span id="modalUserType"></span>
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
        $('#usersTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            pageLength: 15,
            lengthMenu: [[15, 40, 70, -1], [15, 40, 70, "All"]],
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            language: {
                emptyTable: "No Records Found"
            },
            columnDefs: [
                { orderable: false, targets: [0, 3] }
            ]
        });
        
        $("#userForm").validate({
            rules: {
                usertype: {
                    required: true,
                },
                team_head:{
                    required:true,
                },
                name: {
                    required: true,
                },
                username: {
                    required: true,
                },
                password: {
                    required: true,
                },
                status: {
                    required: true
                }
            },
            messages: {
                usertype: {
                    required: "Please select User Type",
                },
                team_head:{
                    required: "Please select team head",
                },
                name: {
                    required: "Please enter User",
                },
                username: {
                    required: "Please enter username",
                },
                password: {
                    required: "Please enter password",
                },
                status: {
                    required: "Please select Status"
                }
            },
            errorElement: "span",
            errorPlacement: function (error, element) {
                error.addClass("text-danger");
                error.insertAfter(element);
            },
            submitHandler: function (form) {
                $.ajax({
                    url: "save.php?request=saveUser&type=<?php echo $type;?>",
                    type: "POST",
                    dataType: "json",
                    data: $(form).serialize(),
    
                    beforeSend: function () {
                        $("#responseMsg").html(
                            '<div class="alert alert-info">Saving...</div>'
                        );
                    },
                    success: function (response) {
                        if (response.status == "success") {
                            $("#responseMsg").html(
                                '<div class="alert alert-success">' +
                                response.message +
                                '</div>'
                            );
                            
                            $("#userForm")[0].reset();
                             window.location.href = './usersList.php?type=Add';
                            setTimeout(function() {
                                $("#responseMsg").html('');
                            }, 3000);
                             //window.location.href = './usersList.php';
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
    });
        
    $(document).on('click', '.delete-btn', function () {

        let id = $(this).data('id');
        let utype = $(this).data('utype');
        let status = $(this).data('status');
    
        $('#modalUserType').text(utype);
        $('#modalStatus').text(status);
    
        // Store ID in delete button
        $('#confirmDeleteBtn').data('id', id);
        $('#confirmDeleteBtn').data('utype', utype);

        $('#deleteModal').modal('show');
    });
    
    $(document).on('click', '#confirmDeleteBtn', function () {

        let id = $(this).data('id');
        let utype = $(this).data('utype');

        $.ajax({
            url: 'save.php?request=deleteUser',
            type: 'POST',
            data: {
                id: id,
                utype: utype
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
                        window.location.href = './usersList.php';
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
</script>
