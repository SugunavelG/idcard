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
   $appno=decryptId($_GET['appno']);
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
   $sql="SELECT * FROM student_details WHERE s_id='".$id."' AND s_application_number='".$appno."'";
   $result=mysqli_query($conn,$sql);
   $numrows=mysqli_num_rows($result);
   $fetchArr=mysqli_fetch_array($result);
   if($numrows>0){
        $studentID=$fetchArr['s_id'];
        $appno=$fetchArr['s_application_number'];
        $firstname=$fetchArr['s_first_name'];
        $lastname=$fetchArr['s_last_name'];
        $dob=$fetchArr['s_dob'];
        $gender=$fetchArr['s_gender'];
        $batch=$fetchArr['s_batch'];
        $bld_grp=$fetchArr['s_blood_group'];
        $dept=$fetchArr['s_department'];
        $mobile=$fetchArr['s_mobile_no'];
        $emailID=$fetchArr['s_emailId'];
        $fathername=$fetchArr['s_fathername'];
        $mothername=$fetchArr['s_mothername'];
        $fatherEmail=$fetchArr['s_father_email'];
        $address1=$fetchArr['s_address1'];
        $address2=$fetchArr['s_address2'];
        $area=$fetchArr['s_area'];
        $city=$fetchArr['s_city'];
        $district=$fetchArr['s_district'];
        $state=$fetchArr['s_state'];
        $pincode=$fetchArr['s_pincode'];
        $alterMobile=$fetchArr['s_alternate_mobile'];
        $stuType=$fetchArr['s_stu_type'];
        $modeOfTransport=$fetchArr['s_modeOfTransport'];
        $status=$fetchArr['s_status'];
        $photo=$fetchArr['s_photo'];
        $signature=$fetchArr['s_signature'];
        $parent_signature=$fetchArr['s_parent_signature'];
        $familyPhoto=$fetchArr['s_family_photo'];
        $admitCardStatus=$fetchArr['s_admittedStatus'];
        $admittedDesc=$fetchArr['s_admittedDesc'];
        $admittedEmail=$fetchArr['s_admitCardEmail'];
   }else{
        $studentID='';
        $appno='';
        $firstname='';
        $lastname='';
        $dob='';
        $gender='';
        $batch='';
        $bld_grp='';
        $dept='';
        $emailID='';
        $fathername='';
        $mothername='';
        $fatherEmail='';
        $address1='';
        $address2='';
        $area='';
        $city='';
        $district='';
        $state='';
        $pincode='';
        $alterMobile='';
        $stuType='';
        $modeOfTransport='';
        $status=''; 
        $photo='';       
        $signature='';
        $parent_signature='';
        $familyPhoto='';
        $admitCardNo='';
        $admittedDesc='';
        $admittedEmail='';
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
.error{
    color:red;
}
   </style>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- [ Main Content ] start -->
    <section class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ breadcrumb ] start -->
                            <div class="page-header">
                                <div class="page-block">
                                    <div class="row align-items-center">
                                        <div class="col-md-12">
                                            <!--<div class="page-header-title">-->
                                            <!--    <h5 class="m-b-10">Student <?php echo ($type?$type:'Add'); ?></h5>-->
                                            <!--</div>-->
                                            <!--<ul class="breadcrumb">-->
                                            <!--    <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>-->
                                            <!--    <li class="breadcrumb-item"><a href="#!">Bootstrap Table</a></li>-->
                                            <!--    <li class="breadcrumb-item"><a href="#!">Basic Tables</a></li>-->
                                            <!--</ul>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <!-- [ stiped-table ] end -->
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Student Details</h5>
                                        </div>
                                        <div class="card-body">
                                            <form id="userForm" enctype="multipart/form-data">
                                                <input type="hidden" name="studentID" id="studentID" value="<?php echo $studentID; ?>" />
                                                <input type="hidden" name="type" id="type" value="<?php echo ($type?$type:'Add'); ?>" />
                                                <div class="row">
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">Application No<sup class="error">*</sup></label>
                                                        <input type="text" class="form-control" id="appno" name="appno" value="<?php echo $appno; ?>" <?php echo $readonly; ?> <?php echo $disabled; ?>>
                                                    </div>
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">Full Name<sup class="error">*</sup></label>
                                                        <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $firstname; ?> <?php echo $lastname; ?>" readonly <?php echo $disabled; ?>>
                                                    </div>
                                                     
                                                    <!--<div class="mb-2 col-lg-4">-->
                                                    <!--    <label class="form-label">Admit Card Number<sup class="error">*</sup></label>-->
                                                    <!--    <input type="text" class="form-control" id="admitcardno" name="admitcardno" value="<?php echo $admitCardNo; ?>" <?php echo $disabled; ?>>-->
                                                    <!--</div>-->
                                                    <!--<div class="mb-2 col-lg-4">-->
                                                    <!--    <label class="form-label">Admit Card Verification<sup class="error">*</sup></label>-->
                                                    <!--    <select class="form-control" id="admitcardstatus" name="admitcardstatus"  <?php echo $disabled; ?>>-->
                                                    <!--        <option value="">Select Status</option>-->
                                                    <!--        <option value="ISSUED" selected <?php if(isset($admitCardStatus) && $admitCardStatus=='ISSUED') echo 'selected'; ?>>ISSUED</option>-->
                                                            <!--<option value="NOT ISSUED" <?php if(isset($admitCardStatus) && $admitCardStatus=='NOT ISSUED') echo 'selected'; ?>>NOT ISSUED</option>-->
                                                    <!--    </select>-->
                                                    <!--</div>-->
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">Admit Card Verification<sup class="error">*</sup></label>
                                                        <input type="text" class="form-control" id="admitcardstatus" name="admitcardstatus" value="ISSUED" <?php echo $disabled; ?> readonly>
                                                    </div>
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">Admit Card Email ID<sup class="error">*</sup></label>
                                                        <input type="email" class="form-control" id="admitcardEmail" name="admitcardEmail" value="<?php echo $admittedEmail; ?>" <?php echo $disabled; ?>>
                                                    </div>
                                                     <div class="mb-2 col-lg-8">
                                                        <label class="form-label">
                                                            Remarks
                                                        </label>
                                                        <textarea class="form-control" name="desc" id="desc" rows="2"><?php echo $admittedDesc; ?></textarea>
                                                    </div>
                                                </div>
                                                <?php 
                                                if(isset($id) && isset($appno) && $type=='Edit'){
                                                ?>
                                                    <button type="submit" class="btn btn-success float-right">
                                                        Process Admit Card
                                                    </button>
                                                <?php 
                                                }else if(isset($id) && isset($appno) && $type=='View'){
                                                ?>
                                                    <button type="button" class="btn btn-success">
                                                        <a href="studentAdmitCardList.php" >Back </a>
                                                    </button>
                                                <?php
                                                }else{
                                                ?>
                                                    <button type="submit" class="btn btn-success float-right">
                                                        Save Student
                                                    </button>
                                                <?php } ?>
                                            </form>
                                            
                                        </div>
                                    </div>
                                   <div id="responseMsg"></div>
                                </div>
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- [ Main Content ] end -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#userForm").validate({
                rules: {
                    appno: {
                        required: true,
                    },
                    firstname: {
                        required: true,
                    },
                    admitcardstatus: {
                        required: true,
                    },
                    admitcardEmail:{
                        required:true,
                    }
                },
                messages: {
                    appno: {
                        required: "Please enter application number",
                    },
                    firstname: {
                        required: "Please enter full name",
                    },
                    admitcardstatus: {
                        required: "Please check admit card status",
                    },
                    admitcardEmail:{
                        required:"Please enter admit card email id",
                    }
                },
                errorElement: "span",
                errorPlacement: function (error, element) {
                    error.addClass("text-danger");
                    error.insertAfter(element);
                },
                submitHandler: function (form) {
                    var formData = new FormData(form); // Creates FormData, automatically includes files
                    $.ajax({
                        url: "save.php?request=saveStudentAdmitCard&type=<?php echo $type;?>",
                        type: "POST",
                        dataType: "json",
                        data: formData,
                        contentType: false,      // required for file upload
                        processData: false,      // required for file upload
                        beforeSend: function () {
                            $("#responseMsg").html(
                                '<div class="alert alert-info">Saving...</div>'
                            );
                        },
                        success: function (response) {
                            if (response.status == "success") {
                                $("#responseMsg").html(
                                    '<div class="alert alert-success">' + response.message + '</div>'
                                );
                                alert(response.message);
                                $("#userForm")[0].reset();
                                
                                setTimeout(function () {
                                    $("#responseMsg").fadeOut(function () {
                                        $(this).html('').show(); 
                                        window.location.href = './studentAdmitCardList.php';
                                    });
                                }, 2000);
                            } else {
                                alert(response.message);
                                $("#responseMsg").html(
                                    '<div class="alert alert-danger">' + response.message + '</div>'
                                );
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr.responseText);
                            alert(response.message);
                            $("#responseMsg").html(
                                '<div class="alert alert-danger">Something went wrong: ' + error + '</div>'
                            );
                        }
                    });
                    return false;
                }
            });
        });
        
        
        function checkApplicationNumberExits(appno){
            if(!appno){
                alert('Dear Canditate, Please Enter Valid Application Number. Thank you.');
            }else{
                $.ajax({
                    url : 'save.php?request=checkApplicationNumberAlreadyExits',
                    type : 'post',
                    data : {appno:appno},
                    success : function(data){
                        if(data.trim()=='already_exits'){
                            alert('Dear Canditate, This application Number Already Exits. Please try to edit application?. Thank you.');
                            $("#appno").val('');
                        }else if(data.trim()=='empty'){
                            alert('Dear Candidate, Enter valid application number. Thank you.');
                            $("#appno").val('');
                        }
                        else if(data.trim()=='false'){
                            alert('Dear Canditate, application number is invalid. Thank you.');
                            $("#appno").val('');
                        }
                    }
                });
            }
        }
    </script>
