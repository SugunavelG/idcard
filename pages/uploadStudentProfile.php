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
        $studentVerified=$fetchArr['s_stu_verified'];
        $studentStatus=$fetchArr['s_reportedStatus'];
        $applicant_type=$fetchArr['s_course_type'];
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
        $studentVerified='';
        $studentStatus='';
        $applicant_type='';
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
                                                        <input type="text" class="form-control" id="appno" name="appno"  <?php if (empty($studentID)) { ?> onblur="checkApplicationNumberExits(this.value);" <?php } ?>  value="<?php echo $appno; ?>" <?php echo $readonly; ?> <?php echo $disabled; ?>>
                                                    </div>
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">First Name<sup class="error">*</sup></label>
                                                        <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $firstname; ?>" <?php echo $disabled; ?> readonly>
                                                    </div>
                                                     <div class="mb-2 col-lg-4">
                                                        <label class="form-label">Last Name<sup class="error">*</sup></label>
                                                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $lastname; ?>" <?php echo $disabled; ?> readonly>
                                                    </div>
                                                     <div class="mb-2 col-lg-4">
                                                        <label class="form-label">
                                                            Department <sup class="text-danger">*</sup>
                                                        </label>
                                                        <select class="form-select form-control" id="dept" name="dept" <?php echo $disabled; ?> required disabled>
                                                            <option value="">Select Department</option>
                                                            <?php
                                                            $deptQry = mysqli_query($conn, "SELECT dept_id, dept_name FROM department WHERE dept_status='1' ORDER BY dept_name ASC");
                                                            while($row = mysqli_fetch_assoc($deptQry))
                                                            {
                                                            ?>
                                                                <option value="<?php echo $row['dept_id']; ?>"
                                                                    <?php if(isset($dept) && $dept == $row['dept_id']) echo 'selected'; ?>>
                                                                    <?php echo htmlspecialchars($row['dept_name']); ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">Student Status<sup class="error">*</sup></label>
                                                       <input type="text" class="form-control" id="applicant_type" name="applicant_type" value="<?php echo $applicant_type; ?>" readonly/>
                                                    </div>
                                                    <!--<div class="mb-2 col-lg-4">-->
                                                    <!--    <label class="form-label">ID Card Verification<sup class="error">*</sup></label>-->
                                                    <!--    <select class="form-control" id="studentIdVerification" name="studentIdVerification"  <?php echo $disabled; ?>>-->
                                                    <!--        <option value="">Select Status</option>-->
                                                    <!--        <option value="VERIFIED" selected <?php if(isset($studentVerified) && $studentVerified=='VERIFIED') echo 'selected'; ?>>VERIFIED</option>-->
                                                    <!--        <option value="NOT VERIFIED" <?php if(isset($studentVerified) && $studentVerified=='NOT VERIFIED') echo 'selected'; ?>>NOT VERIFIED</option>-->
                                                    <!--    </select>-->
                                                    <!--</div>-->
                                                    <div class="mb-2 col-lg-3">
                                                        <label class="form-label">Student Photo Upload <?php echo $photo; ?></label>
                                                        <input type="file" class="form-control" id="student_photo" name="student_photo"
                                                            accept="image/png,image/jpeg,image/jpg"
                                                            onchange="previewImage(this,'photoPreview')"
                                                            <?php echo $disabled; ?>>
                                                    
                                                        <input type="hidden" name="prevPhoto" id="prevPhoto" value="<?php echo $photo; ?>"/>
                                                    
                                                        <?php if(isset($id) && isset($appno) && $type=='Edit'){ ?>
                                                            <img src="../uploads/2026/<?php echo $appno; ?>/<?php echo $photo; ?>" id="photoPreview" style="width:100px;height:120px;border:1px solid #ccc;margin-top:10px;">
                                                        <?php } else { ?>
                                                            <img id="photoPreview" style="display:none;width:100px;height:120px;border:1px solid #ccc;margin-top:10px;">
                                                        <?php } ?>
                                                    
                                                        <br>
                                                        <small class="error">Allowed: JPG, PNG, JPEG (Max 2MB)</small>
                                                    </div>
                                                    
                                                    <div class="mb-2  col-lg-3">
                                                        <label class="form-label">Student Signature Upload</label>
                                                    
                                                        <input type="file" class="form-control" id="student_signature" name="student_signature"
                                                            accept="image/png,image/jpeg,image/jpg"
                                                            onchange="previewImage(this,'signaturePreview')"
                                                            <?php echo $disabled; ?>>
                                                    
                                                        <input type="hidden" name="prevSignature" id="prevSignature" value="<?php echo $signature; ?>"/>
                                                    
                                                        <?php if(isset($id) && isset($appno) && $type=='Edit'){ ?>
                                                            <img src="../uploads/2026/<?php echo $appno; ?>/<?php echo $signature; ?>" id="signaturePreview" style="width:150px;height:60px;border:1px solid #ccc;margin-top:10px;">
                                                        <?php } else { ?>
                                                            <img id="signaturePreview" style="display:none;width:150px;height:60px;border:1px solid #ccc;margin-top:10px;">
                                                        <?php } ?>
                                                    
                                                        <br>
                                                        <small class="error">Allowed: JPG, PNG, JPEG (Max 2MB)</small>
                                                    </div>
                                                    <div class="mb-2  col-lg-3">
                                                        <label class="form-label">Parent's Signature Upload</label>
                                                    
                                                        <input type="file" class="form-control" id="father_signature" name="father_signature"
                                                            accept="image/png,image/jpeg,image/jpg"
                                                            onchange="previewImage(this,'parentSignaturePreview')"
                                                            <?php echo $disabled; ?>>
                                                    
                                                        <input type="hidden" name="prevParentSignature" id="prevParentSignature" value="<?php echo $parent_signature; ?>"/>
                                                    
                                                        <?php if(isset($id) && isset($appno) && $type=='Edit'){ ?>
                                                            <img src="../uploads/2026/<?php echo $appno; ?>/<?php echo $parent_signature; ?>" id="parentSignaturePreview" style="width:150px;height:60px;border:1px solid #ccc;margin-top:10px;">
                                                        <?php } else { ?>
                                                            <img id="parentSignaturePreview" style="display:none;width:150px;height:60px;border:1px solid #ccc;margin-top:10px;">
                                                        <?php } ?>
                                                    
                                                        <br>
                                                        <small class="error">Allowed: JPG, PNG, JPEG (Max 2MB)</small>
                                                    </div>
                                                    <div class="mb-2  col-lg-3">
                                                        <label class="form-label">Family Upload</label>
                                                    
                                                        <input type="file" class="form-control" id="family_photo" name="family_photo"
                                                            accept="image/png,image/jpeg,image/jpg"
                                                            onchange="previewImage(this,'familyProfilePreview')"
                                                            <?php echo $disabled; ?>>
                                                    
                                                        <input type="hidden" name="prevFamilyPhoto" id="prevFamilyPhoto" value="<?php echo $familyPhoto; ?>"/>
                                                    
                                                        <?php if(isset($id) && isset($appno) && $type=='Edit'){ ?>
                                                            <img src="../uploads/2026/<?php echo $appno; ?>/<?php echo $familyPhoto; ?>" id="familyProfilePreview" style="width:150px;height:60px;border:1px solid #ccc;margin-top:10px;">
                                                        <?php } else { ?>
                                                            <img id="familyProfilePreview" style="display:none;width:150px;height:60px;border:1px solid #ccc;margin-top:10px;">
                                                        <?php } ?>
                                                    
                                                        <br>
                                                        <small class="error">Allowed: JPG, PNG, JPEG (Max 2MB)</small>
                                                    </div>
                                                </div>
                                                <?php 
                                                if(isset($id) && isset($appno) && $type=='Edit'){
                                                ?>
                                                    <button type="submit" class="btn btn-success float-right">
                                                        Update Student
                                                    </button>
                                                <?php 
                                                }else if(isset($id) && isset($appno) && $type=='View'){
                                                ?>
                                                    <button type="button" class="btn btn-success">
                                                        <a href="uploadStudentProfileList.php" >Back Student List</a>
                                                    </button>
                                                <?php
                                                }else{
                                                ?>
                                                    <button type="submit" class="btn btn-success float-right">
                                                        Save Student
                                                    </button>
                                                <?php } ?>
                                            </form>
                                            <div id="responseMsg"></div>
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
                    lastname: {
                        required: true,
                    }
                },
                messages: {
                    appno: {
                        required: "Please enter application number",
                    },
                    firstname: {
                        required: "Please enter full name",
                    },
                    lasstname: {
                        required: "Please enter last name",
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
                        url: "save.php?request=uploadStudentFiles&type=<?php echo $type;?>",
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
                            if (response.status === "success") {
                                // $("#responseMsg").html(
                                //     '<div class="alert alert-success">' + response.message + '</div>'
                                // );
                                alert(response.message);
                                // Optionally reset form
                                $("#userForm")[0].reset();
                                // Redirect or reload after a delay
                                setTimeout(function () {
                                    window.location.href = './uploadStudentProfileList.php';
                                }, 1000);
                                $("#responseMsg").hide();
                            } else {
                                // $("#responseMsg").html(
                                //     '<div class="alert alert-danger">' + response.message + '</div>'
                                // );
                                alert(response.message);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr.responseText);
                            alert(response.message);
                            // $("#responseMsg").html(
                            //     '<div class="alert alert-danger">Something went wrong: ' + error + '</div>'
                            // );
                        }
                    });
                    return false;
                }
            });
        });
        
        function previewImage(input, previewId) {
            var file = input.files[0];
            if (file) {
                // Validate image type
                var allowedTypes = ['image/jpeg', 'image/png'];
        
                if (!allowedTypes.includes(file.type)) {
                    alert("Please select JPG, JPEG or PNG image.");
                    input.value = "";
                    return;
                }
        
                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert("Image size should not exceed 2MB.");
                    input.value = "";
                    return;
                }
        
                var reader = new FileReader();
        
                reader.onload = function(e) {
                    var preview = document.getElementById(previewId);
                    preview.src = e.target.result;
                    preview.style.display = "block";
                };
        
                reader.readAsDataURL(file);
            }
        }
        
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
