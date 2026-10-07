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
                            <!--                    <h5 class="m-b-10">Student List</h5>-->
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
                                            <h5>Student List </h5>
                                        </div>
                                        <div class="card-body table-border-style">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="usersTable">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Student Name</th>
                                                            <th>Application No</th>
                                                            <th>Dept</th>
                                                            <th>Industry Partner</th>
                                                            <th>Applicant Type</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                       <?php
                                                            $sql = "SELECT * FROM student_details
                                                            LEFT JOIN department ON dept_id=s_department
                                                            WHERE s_status='1' ORDER BY s_id DESC";
                                                           // echo $sql;
                                                            $result = mysqli_query($conn, $sql);
                                                            if(mysqli_num_rows($result) > 0){
                                                                $i = 1;
                                                                while($value = mysqli_fetch_assoc($result)){
                                                                    $uid=$value['u_id'];
                                                                    $uname=$value['s_first_name'];
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $i++; ?></td>
                                                                <td><?php echo htmlspecialchars($value['s_first_name']); ?> <?php echo htmlspecialchars($value['s_last_name']); ?></td>
                                                                <td><?php echo htmlspecialchars($value['s_application_number']); ?></td>
                                                                 <td><?php echo htmlspecialchars($value['dept_code']); ?></td>
                                                                <td>
                                                                    <?php echo $value['s_industryPartner'] ?>
                                                                        
                                                                </td>
                                                                <td>
                                                                    <?php echo $value['s_course_type'] ?>
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
                                            <h5><?php echo $type; ?> Student</h5>
                                        </div>
                                        <div class="card-body">
                                            <form id="userForm">
                                                <div class="mb-3">
                                                    <label class="form-label">Application Number</label>
                                                    <input type="text" class="form-control" id="appno" name="appno" <?php echo $disabled; ?>>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">First Name</label>
                                                    <input type="text" class="form-control" id="first_name" name="first_name"  <?php echo $disabled; ?>>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Last Name</label>
                                                    <input type="text" class="form-control" id="last_name" name="last_name" <?php echo $disabled; ?>>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Gender</label>
                                                    <select class="form-control" id="gender" name="gender" >
                                                        <option value="" selected>Select Gender</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Applicant Type</label>
                                                    <select class="form-control" id="applicant_type" name="applicant_type" onchange="getApplicantType(this.value);">
                                                        <option value="" selected>Select Applicant Type</option>
                                                        <option value="REGULAR">REGULAR</option>
                                                        <option value="WORKING PROFESSIONAL">WORKING PROFESSIONAL</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Department</label>
                                                    <select class="form-control" id="dept" name="dept" <?php echo $disabled; ?>>
                                                        <option value="">Select Department</option>
                                                        <?php
                                                            $sql = "SELECT * FROM department WHERE dept_status='1' ORDER BY dept_name ASC";
                                                            $result = mysqli_query($conn, $sql);
                                                            if(mysqli_num_rows($result) > 0){
                                                                $i = 1;
                                                                foreach($result as $value){
                                                        ?>
                                                        <option value="<?php echo $value['dept_id']; ?>" ><?php echo $value['dept_name']; ?></option>
                                                        <?php } } ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3 industryDiv">
                                                    <label class="form-label">Industry Partner</label>
                                                    <select class="form-control" id="industry" name="industry" >
                                                        <option value="" selected>Select Industry Partner</option>
                                                        <option value="AMTZ">AMTZ</option>
                                                        <option value="BVERSITY" >BVERSITY</option>
                                                        <option value="HCL TECH" >HCL TECH</option>
                                                        <option value="INTEL NEC">INTEL NEC</option>
                                                        <option value="MEDINI">MEDINI</option>
                                                        <option value="POWERED BY HCL">POWERED BY HCL</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Admission Head</label>
                                                    <select class="form-control" id="admission_head" name="admission_head" <?php echo $disabled; ?>>
                                                        <option value="" selected>Select Admission Head</option>
                                                        <option value="Dr.P.Karthikeyan" >Dr.P.Karthikeyan</option>
                                                        <option value="Mrs.S.Noorjahan" >Mrs.S.Noorjahan</option>
                                                        <option value="Mr.CS.Vijay Kumar" >Mr.CS.Vijay Kumar</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="mb-3 admitCardDiv">
                                                    <label class="form-label">Admit Card Email</label>
                                                    <input type="text" class="form-control" id="admit_email" name="admit_email" <?php echo $disabled; ?>>
                                                </div>
                                                <button type="submit" class="btn btn-success float-right">
                                                    Save Student
                                                </button>
                                                 
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
function getApplicantType(type){
    
    if (type == 'REGULAR') {
       // $("#industry").prop("required", true);
        //$("#admit_email").prop("required", true);
        $(".industryDiv").show();
        $(".admitCardDiv").show();
    } else {
        $("#industry").prop("required", false);
        $("#admit_email").prop("required", false);
        $("#industry").val('');
         $("#admit_email").val('');
        $(".industryDiv").hide();
        $(".admitCardDiv").hide();
    }
}
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
                appno: {
                    required: true,
                },
                first_name: {
                    required: true,
                },
                last_name:{
                    required:true,
                },
                gender: {
                    required: true,
                },
                applicant_type: {
                    required: true,
                },
                dept: {
                    required: true,
                },
                admission_head: {
                    required: true
                }
            },
            messages: {
                appno: {
                    required: "Please enter application number",
                },
                 first_name: {
                    required: "Please enter first name",
                },
                last_name:{
                    required: "Please enter last name",
                },
                gender: {
                    required: "Please select gender",
                },
                applicant_type: {
                    required: "Please select applicant type",
                },
                dept: {
                    required: "Please select department",
                },
                admission_head: {
                    required: "Please select admission head"
                }
            },
            errorElement: "span",
            errorPlacement: function (error, element) {
                error.addClass("text-danger");
                error.insertAfter(element);
            },
            submitHandler: function (form) {
                $.ajax({
                    url: "save.php?request=saveManualStudentEntry&type=<?php echo $type;?>",
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
                             window.location.href = './studentEntry.php?type=Add';
                            setTimeout(function() {
                                $("#responseMsg").html('');
                            }, 3000);
                             //window.location.href = './studentEntry.php';
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
        
    
</script>
