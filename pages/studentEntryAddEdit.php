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
        $admissionOwner=$fetchArr['s_admissionOwner'];
        $studentVerified=$fetchArr['s_stu_verified'];
        $studentStatus=$fetchArr['s_reportedStatus'];
        $course_type=$fetchArr['s_course_type'];
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
        $admissionOwner='';
        $studentVerified='';
        $studentStatus='';
        $course_type='';
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
                                                        <input type="text" class="form-control" id="appno" name="appno" 
                                                        <?php if (empty($studentID)) { ?> onblur="checkApplicationNumberExits(this.value);" <?php } ?> 
                                                        value="<?php echo $appno; ?>" <?php echo $readonly; ?> <?php echo $disabled; ?>>
                                                    </div>
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">First Name<sup class="error">*</sup></label>
                                                        <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $firstname; ?>" <?php echo $disabled; ?>>
                                                    </div>
                                                    <!-- <div class="mb-2 col-lg-4">-->
                                                    <!--    <label class="form-label">Middle Name<sup class="error">*</sup></label>-->
                                                    <!--    <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $lastname; ?>" <?php echo $disabled; ?>>-->
                                                    <!--</div>-->
                                                     <div class="mb-2 col-lg-4">
                                                        <label class="form-label">Last Name<sup class="error">*</sup></label>
                                                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $lastname; ?>" <?php echo $disabled; ?>>
                                                    </div>
                                                    <div class="mb-2 col-lg-2">
                                                        <label class="form-label">DOB<sup class="error">*</sup></label>
                                                        <input type="date" class="form-control" id="dob" name="dob" onkeydown="return false" value="<?php echo $dob; ?>" <?php echo $disabled; ?>>
                                                    </div>
                                                    <div class="mb-2 col-lg-2">
                                                        <label class="form-label">Gender<sup class="error">*</sup></label>
                                                        <select class="form-control" id="gender" name="gender" <?php echo $disabled; ?>>
                                                            <option value="">Select Gender</option>
                                                            <option value="Male" <?php if(isset($gender) && $gender=='Male') echo 'selected'; ?>>Male</option>
                                                            <option value="Female" <?php if(isset($gender) && $gender=='Female') echo 'selected'; ?>>Female</option>
                                                            <option value="Other" <?php if(isset($gender) && $gender=='Other') echo 'selected'; ?>>Other</option>
                                                        </select>
                                                    </div>
                                                     <div class="mb-2 col-lg-2">
                                                        <label class="form-label">Batch<sup class="error">*</sup></label>
                                                        <select class="form-control" id="batch" name="batch" <?php echo $disabled; ?>>
                                                            <option value="">Select Batch</option>
                                                            <option value="2026-30" selected <?php if(isset($batch) && $batch=='2026-30') echo 'selected'; ?>>2026-30</option>
                                                            <option value="2026-29" selected <?php if(isset($batch) && $batch=='2026-29') echo 'selected'; ?>>2026-29</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2 col-lg-2">
                                                        <label class="form-label">Blood Group </label>
                                                        <select class="form-select form-control" id="blood" name="blood" <?php echo $disabled; ?> >
                                                            <option value="" selected>Select Blood Group</option>
                                                            <?php
                                                            $bloodQry = mysqli_query($conn, "SELECT bg_id, bg_name FROM blood_group WHERE bg_status='1' ORDER BY bg_name ASC");
                                                            while($blood = mysqli_fetch_assoc($bloodQry))
                                                            {
                                                            ?>
                                                                <option value="<?php echo $blood['bg_id']; ?>"
                                                                    <?php if(isset($bld_grp) && $bld_grp == $blood['bg_id']) echo 'selected'; ?>>
                                                                    <?php echo $blood['bg_name']; ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">
                                                            Department <sup class="text-danger">*</sup>
                                                        </label>
                                                        <select class="form-select form-control" id="dept" name="dept" <?php echo $disabled; ?> required>
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
                                                    <!--<div class="mb-2 col-lg-4">-->
                                                    <!--    <label class="form-label">-->
                                                    <!--        Applicant Type <sup class="text-danger">*</sup>-->
                                                    <!--    </label>-->
                                                    <!--    <select class="form-select form-control" id="course_type" name="course_type" <?php echo $disabled; ?> required>-->
                                                    <!--        <option value="">Select Applicant Category</option>-->
                                                    <!--        <option value="REGULAR" <?php if(isset($course_type) && $course_type == 'REGULAR') echo 'selected'; ?>>-->
                                                    <!--            REGULAR-->
                                                    <!--        </option>-->
                                                    <!--        <option value="WORKING PROFESSIONAL" <?php if(isset($course_type) && $course_type == 'WORKING PROFESSIONAL') echo 'selected'; ?>>-->
                                                    <!--            WORKING PROFESSIONAL-->
                                                    <!--        </option>-->
                                                    <!--    </select>-->
                                                    <!--</div>-->
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">Mobile No<sup class="error">*</sup></label>
                                                        <input type="text" class="form-control" id="mobile" name="mobile" minlength="10" maxlength="10" pattern="[0-9]{10}" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'')" value="<?php echo $mobile; ?>" <?php echo $disabled; ?>>
                                                    </div>
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">Email ID<sup class="error">*</sup></label>
                                                        <input type="email" class="form-control" id="emailId" name="emailId" value="<?php echo $emailID; ?>" <?php echo $disabled; ?>>
                                                    </div>
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">Father Name<sup class="error">*</sup></label>
                                                        <input type="text" class="form-control" id="fathername" name="fathername" value="<?php echo $fathername; ?>" <?php echo $disabled; ?>>
                                                    </div>
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">Mother Name<sup class="error">*</sup></label>
                                                        <input type="text" class="form-control" id="mothername" name="mothername" value="<?php echo $mothername; ?>" <?php echo $disabled; ?>>
                                                    </div>
                                                     
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">Parent's Mobile No<sup class="error">*</sup></label>
                                                        <input type="text" class="form-control" id="alternate_mobile" name="alternate_mobile" minlength="10" maxlength="10" pattern="[0-9]{10}" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'')" value="<?php echo $alterMobile; ?>" <?php echo $disabled; ?>>
                                                    </div>
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">Father Email ID<sup class="error">*</sup></label>
                                                        <input type="email" class="form-control" id="fatherEmailId" name="fatherEmailId" value="<?php echo $fatherEmail; ?>" <?php echo $disabled; ?>>
                                                    </div>
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">Address Line 1<sup class="error">*</sup></label>
                                                        <input type="text" class="form-control" id="addressLine1" name="addressLine1" value="<?php echo $address1; ?>" <?php echo $disabled; ?> />
                                                    </div>
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">Address Line 2</label>
                                                        <input type="text" class="form-control" id="addressLine2" name="addressLine2" value="<?php echo $address2; ?>" <?php echo $disabled; ?> />
                                                    </div>
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">Area / Locality<sup class="error">*</sup></label>
                                                        <input type="text" class="form-control" id="area" name="area" value="<?php echo $area; ?>" <?php echo $disabled; ?> />
                                                    </div>
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">City / Town<sup class="error">*</sup></label>
                                                        <input type="text" class="form-control" id="city" name="city" value="<?php echo $city; ?>" <?php echo $disabled; ?> />
                                                    </div>
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">District<sup class="error">*</sup></label>
                                                        <input type="text" class="form-control" id="district" name="district" value="<?php echo $district; ?>" <?php echo $disabled; ?> />
                                                    </div>
                                                    <div class="col-lg-4 mb-2">
                                                        <label for="state">State<span class="text-danger">*</span></label>
                                                        <select class="form-select form-control" id="state" name="state" required>
                                                            <option value="">-- Select State / Union Territory --</option>
                                                            <?php
                                                            $query = mysqli_query($conn, "SELECT st_id, st_name FROM state WHERE st_status = 1 ORDER BY st_name ASC");
                                                            while ($row = mysqli_fetch_assoc($query)) {
                                                                ?>
                                                                 <option value="<?php echo $row['st_id']; ?>"
                                                                    <?php if (isset($state) && $state == $row['st_id']) echo 'selected'; ?>>
                                                                    <?php echo htmlspecialchars($row['st_name']); ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">Postal Code (PIN Code)<sup class="error">*</sup></label>
                                                        <input type="text" class="form-control" id="pincode" name="pincode" <?php echo $disabled; ?> value="<?php echo $pincode; ?>" minlength="6" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'')"/>
                                                    </div>
                                                    
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">Student Type <sup class="error">*</sup></label>
                                                        <select class="form-control" id="stuType" name="stuType" <?php echo $disabled; ?>>
                                                            <option value="">Select Student Type </option>
                                                            <option value="Hosteller" <?php if(isset($stuType) && $stuType=='Hosteller') echo 'selected'; ?>>Hosteller</option>
                                                            <option value="Day Scholar - College Transport" <?php if(isset($stuType) && $stuType=='Day Scholar - College Transport') echo 'selected'; ?>>Day Scholar - College Transport</option>
                                                            <option value="Day Scholar - No College Transport" <?php if(isset($stuType) && $stuType=='Day Scholar - No College Transport') echo 'selected'; ?>>Day Scholar - No College Transport</option>
                                                            <option value="WORKING PROFESSIONAL" <?php if(isset($stuType) && $stuType=='WORKING PROFESSIONAL') echo 'selected'; ?>>WORKING PROFESSIONAL</option>
                                                        </select>
                                                    </div>
                                                    <!--<div class="mb-2 col-lg-4">-->
                                                    <!--    <label class="form-label">Student Status<sup class="error">*</sup></label>-->
                                                    <!--    <select class="form-control" id="courseType" name="courseType"  <?php echo $disabled; ?>>-->
                                                    <!--        <option value="">Select Status</option>-->
                                                    <!--        <option value="Regular" selected <?php if(isset($courseType) && $courseType=='Regular') echo 'selected'; ?>>Regular</option>-->
                                                    <!--        <option value="Working Professional" <?php if(isset($courseType) && $courseType=='Working Professional') echo 'selected'; ?>>Working Professional</option>-->
                                                    <!--    </select>-->
                                                    <!--</div>-->
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">ID Card Verification<sup class="error">*</sup></label>
                                                        <select class="form-control" id="studentIdVerification" name="studentIdVerification"  <?php echo $disabled; ?>>
                                                            <option value="">Select Status</option>
                                                            <option value="VERIFIED" selected <?php if(isset($studentVerified) && $studentVerified=='VERIFIED') echo 'selected'; ?>>VERIFIED</option>
                                                            <!--<option value="NOT VERIFIED" <?php if(isset($studentVerified) && $studentVerified=='NOT VERIFIED') echo 'selected'; ?>>NOT VERIFIED</option>-->
                                                        </select>
                                                    </div>
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">
                                                            Admission Owner <sup class="error">*</sup>
                                                        </label>
                                                    
                                                       <?php
                                                        $admissionOwner = trim($fetchArr['s_admissionOwner']);
                                                        ?>
                                                        
                                                        <!--<select class="form-control" id="admissionOwner" name="admissionOwner" <?php echo $disabled; ?> >-->
                                                        <!--    <option value="">Select Admission Owner</option>-->
                                                        
                                                        <!--    <option value="Dr.P.Karthikeyan" <?php echo ($admissionOwner == 'Dr.P.Karthikeyan') ? 'selected' : ''; ?>>-->
                                                        <!--        Dr.P.Karthikeyan-->
                                                        <!--    </option>-->
                                                        
                                                        <!--    <option value="Mrs.S.Noorjahan" <?php echo ($admissionOwner == 'Mrs.S.Noorjahan') ? 'selected' : ''; ?>>-->
                                                        <!--        Mrs.S.Noorjahan-->
                                                        <!--    </option>-->
                                                        
                                                        <!--    <option value="Mr.CS.Vijay Kumar" <?php echo ($admissionOwner == 'Mr.CS.Vijay Kumar') ? 'selected' : ''; ?>>-->
                                                        <!--        Mr.CS.Vijay Kumar-->
                                                        <!--    </option>-->
                                                        
                                                        <!--    <option value="Direct" <?php echo ($admissionOwner == 'Direct') ? 'selected' : ''; ?>>-->
                                                        <!--        Direct-->
                                                        <!--    </option>-->
                                                        <!--</select>-->
                                                        <input type="text" name="admissionOwner" id="admissionOwner" class="form-control" value="<?php echo $admissionOwner; ?>" readonly>
                                                    </div>
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">Student Photo Upload <?php echo $photo; ?></label>
                                                        <input type="file" class="form-control" id="student_photo" name="student_photo"
                                                            accept="image/png,image/jpeg,image/jpg"
                                                            onchange="previewImage(this,'photoPreview')"
                                                            <?php echo $disabled; ?>>
                                                    
                                                        <input type="hidden" name="prevPhoto" id="prevPhoto" value="<?php echo $photo; ?>"/>
                                                    
                                                        <?php if(isset($id) && isset($appno) && $type=='Edit'){ ?>
                                                        <?php if(!empty($photo)){ ?>
                                                            <img src="../uploads/2026/<?php echo $appno; ?>/<?php echo $photo; ?>" id="photoPreview" style="width:100px;height:120px;border:1px solid #ccc;margin-top:10px;">
                                                        <?php } ?>
                                                        <?php } else { ?>
                                                            <img id="photoPreview" style="display:none;width:100px;height:120px;border:1px solid #ccc;margin-top:10px;">
                                                        <?php } ?>
                                                        <br>
                                                        <small class="error">Allowed: JPG, PNG, JPEG (Max 2MB)</small>
                                                    </div>
                                                    
                                                    <div class="mb-2 col-lg-4">
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
                                                    <div class="mb-2  col-lg-4">
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
                                                      <div class="mb-2  col-lg-4">
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
                                                    
                                                    <!--<div class="mb-2 col-lg-2">-->
                                                    <!--    <label class="form-label">Status<sup class="error">*</sup></label>-->
                                                    <!--    <select class="form-control" id="status" name="status"  <?php echo $disabled; ?>>-->
                                                    <!--        <option value="">Select Status</option>-->
                                                    <!--        <option value="1" selected <?php if(isset($status) && $status=='1') echo 'selected'; ?>>Active</option>-->
                                                    <!--        <option value="2" <?php if(isset($status) && $status=='2') echo 'selected'; ?>>Inactive</option>-->
                                                    <!--    </select>-->
                                                    <!--</div>-->
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
                                                        <a href="studentEntryList.php" >Back Student List</a>
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
                    lastname: {
                        required: true,
                    },
                    dob: {
                        required: true,
                    },
                    gender: {
                        required: true,
                    },
                    batch: {
                        required: true,
                    },
                    dept: {
                        required: true,
                    },
                    mobile: {
                        required: true, 
                        digits: true, 
                        minlength: 10, 
                        maxlength: 10
                    },
                    emailId:{
                        required: true,
                    },
                    fathername: {
                        required: true,
                    },
                    mothername: {
                        required: true,
                    },
                    alternate_mobile: {
                        required: true, 
                        digits: true, 
                        minlength: 10, 
                        maxlength: 10
                    },
                    fatherEmailId:{
                        required: true,
                    },
                    addressLine1: {
                        required: true,
                        minlength:1,
                    },
                    
                    area: {
                        required: true,
                    },
                    city: {
                        required: true,
                    },
                    district: {
                        required: true,
                    },
                    state: {
                        required: true,
                    },
                    pincode: {
                        required: true,
                        digits: true, 
                        minlength: 6, 
                        maxlength: 6
                    },
                    stuType:{
                        required: true,
                    },
                    admissionOwner:{
                        required: true,
                    },
                    status: {
                        required: true
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
                    },
                    dob: {
                        required: "Please select dob",
                    },
                    gender: {
                        required: "Please select gender",
                    },
                    batch: {
                        required: "Please enter batch",
                    },
                   
                    dept: {
                        required: "Please select department",
                    },
                    
                    mobile: {
                        required: "Please enter mobile",
                    },
                    emailId:{
                        required: "Please enter father email ID",
                    },
                    fathername: {
                        required: "Please enter father name",
                    },
                    mothername: {
                        required: "Please enter mother name",
                    },
                    alternate_mobile: {
                        required: "Please enter alternate mobile no",
                    },
                    fatherEmailId:{
                        required: "Please enter fater Email ID",
                    },
                    addressLine1: {
                        required: "Please enter address line1",
                    },
                   
                    area: {
                        required: "Please enter area",
                    },
                    city: {
                        required: "Please enter city",
                    },
                    district: {
                        required: "Please enter district",
                    },
                    state: {
                        required: "Please select state",
                    },
                    pincode: {
                        required: "Please enter pincode",
                    },
                    stuType: {
                        required: "Please select student type",
                    },
                    admissionOwner:{
                        required: "Please select admission owner",
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
                    var formData = new FormData(form); // Creates FormData, automatically includes files
                    $.ajax({
                        url: "save.php?request=saveStudent&type=<?php echo $type;?>",
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
                               // $("#userForm")[0].reset();
                                
                                setTimeout(function () {
                                    $("#responseMsg").fadeOut(function () {
                                        $(this).html('').show(); 
                                        window.location.href = './studentEntryList.php';
                                    });
                                }, 2000);
                                 
                            } else {
                                // $("#responseMsg").html(
                                //     '<div class="alert alert-danger">' + response.message + '</div>'
                                // );
                                  alert(response.message);
                                setTimeout(function () {
                                    $("#responseMsg").fadeOut(function () {
                                        $(this).html('').hide(); 
                                    });
                                }, 2000);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr.responseText);
                            // $("#responseMsg").html(
                            //     '<div class="alert alert-danger">Something went wrong: ' + error + '</div>'
                            // );
                              alert(response.message);
                            setTimeout(function () {
                                $("#responseMsg").fadeOut(function () {
                                    $(this).html('').hide(); 
                                });
                            }, 2000);
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
