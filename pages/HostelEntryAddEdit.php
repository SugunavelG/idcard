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
        $hosId=$fetchArr['s_h_id'];
        $roomCatId=$fetchArr['s_rc_id'];
        $roomNo=$fetchArr['s_hos_roomno'];
        $hosPaymentStatus=$fetchArr['s_hosPaymentStatus'];
        $hosCheckInStatus=$fetchArr['s_hos_checkIn_status'];
        $hostelStatus=$fetchArr['s_hosStatus'];
        $remarks=$fetchArr['s_hos_desc'];
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
        $hosId='';
        $roomCatId='';
        $roomNo='';
        $hostelStatus='';
        $hosPaymentStatus='';
        $hosCheckInStatus='';
        $remarks='';
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
                                                        <input type="text" class="form-control" id="appno" name="appno" <?php if (empty($studentID)) { ?> onblur="checkApplicationNumberExits(this.value);" <?php } ?>  value="<?php echo $appno; ?>" <?php echo $readonly; ?> <?php echo $disabled; ?>>
                                                    </div>
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">First Name<sup class="error">*</sup></label>
                                                        <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $firstname; ?>" <?php echo $disabled; ?> readonly>
                                                    </div>
                                                  
                                                     <div class="mb-2 col-lg-4">
                                                        <label class="form-label">Last Name<sup class="error">*</sup></label>
                                                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $lastname; ?>" <?php echo $disabled; ?> readonly>
                                                    </div>
                                                    <!--<div class="mb-2 col-lg-2">-->
                                                    <!--    <label class="form-label">DOB<sup class="error">*</sup></label>-->
                                                    <!--    <input type="date" class="form-control" id="dob" name="dob" onkeydown="return false" value="<?php echo $dob; ?>" <?php echo $disabled; ?> readonly>-->
                                                    <!--</div>-->
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">Gender<sup class="error">*</sup></label>
                                                        <select class="form-control" id="gender" name="gender" <?php echo $disabled; ?> disabled>
                                                            <option value="">Select Gender</option>
                                                            <option value="Male" <?php if(isset($gender) && $gender=='Male') echo 'selected'; ?>>Male</option>
                                                            <option value="Female" <?php if(isset($gender) && $gender=='Female') echo 'selected'; ?>>Female</option>
                                                            <option value="Other" <?php if(isset($gender) && $gender=='Other') echo 'selected'; ?>>Other</option>
                                                        </select>
                                                    </div>
                                                     
                                                    <div class="mb-2 col-lg-8">
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
                                                 
                                                    <div class="mb-2 col-lg-3">
                                                        <label class="form-label">
                                                            Hostel <sup class="text-danger">*</sup>
                                                        </label>
                                                        <select class="form-select form-control" id="hostel" name="hostel" <?php echo $disabled; ?> required>
                                                            <option value="">Select Hostel</option>
                                                            <?php
                                                            $deptQry = mysqli_query($conn, "SELECT h_id, h_name FROM hostel WHERE h_status='1' ORDER BY h_name ASC");
                                                            while($row = mysqli_fetch_assoc($deptQry))
                                                            {
                                                            ?>
                                                                <option value="<?php echo $row['h_id']; ?>"
                                                                    <?php if(isset($hosId) && $hosId == $row['h_id']) echo 'selected'; ?>>
                                                                    <?php echo htmlspecialchars($row['h_name']); ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2 col-lg-3">
                                                        <label class="form-label">
                                                             Room Category <sup class="text-danger">*</sup>
                                                        </label>
                                                        <select name="room_category" id="room_category" class="form-control" <?php echo $disabled; ?> required>
                                                            <option value="" selected>Select Room Category</option>
                                                        
                                                            <?php
                                                            $sql = mysqli_query($conn,
                                                                "SELECT rc_id, rc_name
                                                                 FROM room_category
                                                                 WHERE rc_status='1'");
                                                            while($row = mysqli_fetch_assoc($sql)){
                                                            ?>
                                                                <option value="<?php echo $row['rc_id']; ?>" <?php if(isset($roomCatId) && $roomCatId == $row['rc_id']) echo 'selected'; ?>>
                                                                    <?php echo $row['rc_name']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                     <div class="mb-2 col-lg-3">
                                                        <label class="form-label">Room No<sup class="error">*</sup></label>
                                                        <input type="text" class="form-control" id="roomNo" name="roomNo" value="<?php echo $roomNo; ?>" <?php echo $disabled; ?>>
                                                    </div>
                                                    
                                                    <div class="mb-2 col-lg-3">
                                                        <label class="form-label">
                                                            Hostel Payment Status<sup class="text-danger">*</sup> 
                                                        </label>
                                                        <select class="form-select form-control" id="paymentStatus" name="paymentStatus" <?php echo $disabled; ?> required onchange="getRemarks(this.value);">
                                                            <option value="">Select Payment Status</option>
                                                        
                                                            <!--<option value="Not Paid"-->
                                                            <!--    <?php if(isset($hosPaymentStatus) && $hosPaymentStatus == "Not Paid") echo 'selected'; ?>>-->
                                                            <!--    Not Paid-->
                                                            <!--</option>-->
                                                        
                                                            <option value="Partially Paid"
                                                                <?php if(isset($hosPaymentStatus) && $hosPaymentStatus == "Partially Paid") echo 'selected'; ?>>
                                                                Partially Paid
                                                            </option>
                                                        
                                                            <option value="Fully Paid"
                                                                <?php if(isset($hosPaymentStatus) && $hosPaymentStatus == "Fully Paid") echo 'selected'; ?>>
                                                                Fully Paid
                                                            </option>
                                                            <option value="1st Semester Fee"
                                                                <?php if(isset($hosPaymentStatus) && $hosPaymentStatus == "1st Semester Fee") echo 'selected'; ?>>
                                                               1st Semester Fee
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2 col-lg-4">
                                                        <label class="form-label">Hostel Status<sup class="error">*</sup></label>
                                                        <select class="form-control" id="hostel_status" name="hostel_status" <?php echo $disabled; ?>>
                                                            <option value="">Select Gender</option>
                                                            <option value="REPORTED" <?php if(isset($hostelStatus) && $hostelStatus=='REPORTED') echo 'selected'; ?>>REPORTED</option>
                                                            <option value="NOT REPORTED" <?php if(isset($hostelStatus) && $hostelStatus=='NOT REPORTED') echo 'selected'; ?>>NOT REPORTED</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2 col-lg-8">
                                                        <label class="form-label">
                                                            Remarks
                                                        </label>
                                                        <textarea class="form-control" name="desc" id="desc" rows="2"><?php echo $remarks; ?></textarea>
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
                    gender: {
                        required: true,
                    },
                    dept: {
                        required: true,
                    },
                    
                    hostel: {
                        required: true
                    },
                    room_category: {
                        required: true,
                    },
                    roomNo: {
                        required: true,
                    },
                    hostel_status:{
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
                    },
                    gender: {
                        required: "Please select gender",
                    },
                    dept: {
                        required: "Please select department",
                    },
                   
                    hostel: {
                        required: "Please select hostel name"
                    },
                    room_category: {
                        required: "Please select room category",
                    },
                    roomNo: {
                        required: "Please enter room no",
                    },
                    hostel_status:{
                        required: "Please select hostel status",
                    }
                },
                errorElement: "span",
                errorPlacement: function (error, element) {
                    error.addClass("text-danger");
                    error.insertAfter(element);
                },
                submitHandler: function (form) {
                   var paymentStatus = $("#paymentStatus").val();
                    var desc = $("#desc").val();
                    
                    // Validation
                    if (paymentStatus == 'Partially Paid' && (!desc || desc.trim() == '')) {
                        alert("Please enter the remarks.");
                        $("#desc").focus();
                        return false;
                    }
                    
                    // If validation passes, execute AJAX
                    var formData = new FormData(form);
                    
                    $.ajax({
                        url: "save.php?request=saveHostelStudent&type=<?php echo $type;?>",
                        type: "POST",
                        dataType: "json",
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function () {
                            $("#responseMsg").html(
                                '<div class="alert alert-info">Saving...</div>'
                            );
                        },
                        success: function (response) {
                            if (response.status === "success") {
                                $("#responseMsg").html(
                                    '<div class="alert alert-success">' + response.message + '</div>'
                                );
                    
                                $("#userForm")[0].reset();
                    
                                setTimeout(function () {
                                    $("#responseMsg").fadeOut(function () {
                                        $(this).html('').show();
                                        window.location.href = './studentHostelEntryList.php';
                                    });
                                }, 3000);
                    
                            } else {
                                $("#responseMsg").html(
                                    '<div class="alert alert-danger">' + response.message + '</div>'
                                );
                    
                                setTimeout(function () {
                                    $("#responseMsg").fadeOut(function () {
                                        $(this).html('').hide();
                                    });
                                }, 3000);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr.responseText);
                    
                            $("#responseMsg").html(
                                '<div class="alert alert-danger">Something went wrong: ' + error + '</div>'
                            );
                    
                            setTimeout(function () {
                                $("#responseMsg").fadeOut(function () {
                                    $(this).html('').hide();
                                });
                            }, 3000);
                        }
                    });
                    
                    return false;
                }
            });
        });
        
        function getRemarks(value){
            if(value!='Fully Paid'){
               var desc= $("#desc").val();
               if(desc==''){
                   $("#desc").focus();
               }
            }
        }
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
