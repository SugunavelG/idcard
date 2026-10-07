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
   $appno=$_GET['appno'];
   $redirect=$_GET['redirect'];
   
   $cond='';
    if(!empty($id)){
        $id = decryptId($_GET['id']);
        $cond .= " AND s_id='".$id."' ";
    }else{
        $appno = $_GET['appno'];
        $cond .= " AND s_application_number='".$appno."' ";
    }
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
   $sql="SELECT * FROM student_details
    LEFT JOIN department ON dept_id=s_department
    LEFT JOIN blood_group ON bg_id=s_blood_group
    LEFT JOIN hostel ON h_id=s_h_id
    LEFT JOIN room_category ON rc_id=s_rc_id
    LEFT JOIN state ON st_id=s_state
    WHERE s_status='1' $cond";
   //echo $sql;exit;
   $result=mysqli_query($conn,$sql);
   $numrows=mysqli_num_rows($result);
   $fetchArr=mysqli_fetch_array($result);
   //print_r($numrows);
   if($numrows>0){
       $studentID=$fetchArr['s_id'];
        $appno=$fetchArr['s_application_number'];
        $firstname=$fetchArr['s_first_name'];
        $lastname=$fetchArr['s_last_name'];
        $dob=$fetchArr['s_dob'];
        $gender=$fetchArr['s_gender'];
        $batch=$fetchArr['s_batch'];
        $bld_grp=$fetchArr['bg_name'];
        $dept=$fetchArr['dept_name'];
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
        $state=$fetchArr['st_name'];
        $pincode=$fetchArr['s_pincode'];
        $alterMobile=$fetchArr['s_alternate_mobile'];
        $stuType=$fetchArr['s_stu_type'];
        $modeOfTransport=$fetchArr['s_modeOfTransport'];
        $status=$fetchArr['s_status'];
        $photo=$fetchArr['s_photo'];
        $signature=$fetchArr['s_signature'];
        $parent_signature=$fetchArr['s_parent_signature'];
        $familyPhoto=$fetchArr['s_family_photo'];
        $admittedStatus=$fetchArr['s_admittedStatus'];
        $reportStatus=$fetchArr['s_reportedStatus'];
        $reportDate = !empty($fetchArr['s_reportedcDate'])
    ? date("d-m-Y h:i A", strtotime($fetchArr['s_reportedcDate']))
    : '';
        $idCardStatus=$fetchArr['s_idcardStatus'];
        $idCardIssuedDate = !empty($fetchArr['s_idcardDate'])
            ? date("d-m-Y h:i A", strtotime($fetchArr['s_idcardDate']))
            : '';
        $bagStatus=$fetchArr['s_bagStatus'];
        $bagIssuedDate = !empty($fetchArr['s_bagDate'])
            ? date("d-m-Y h:i A", strtotime($fetchArr['s_bagDate']))
            : '';
        $tshirtStatus=$fetchArr['s_tshirtStatus'];
        $tshirtIssuedDate = !empty($fetchArr['s_tshirtDate'])
            ? date("d-m-Y h:i A", strtotime($fetchArr['s_tshirtDate']))
            : '';
        $admittedDated = !empty($fetchArr['s_admittedDate'])
    ? date("d-m-Y h:i A", strtotime($fetchArr['s_admittedDate']))
    : '';
    $admittedRemarks=$fetchArr['s_admittedDesc'];
         $hostelReportedDate=!empty($fetchArr['s_hos_cDate'])
    ? date("d-m-Y h:i A", strtotime($fetchArr['s_hos_cDate']))
    : '';
    $hostelStatus=$fetchArr['s_hosStatus'];
    $hostelName=$fetchArr['h_name'];
    $roomCategory=$fetchArr['rc_name'];
    $roomNo=$fetchArr['s_hos_roomno'];
    $paymentStatus=$fetchArr['s_hosPaymentStatus'];
   
    $hostelRemarks=$fetchArr['s_hos_desc'];
    $hostelCheckInStatus=$fetchArr['s_hos_checkIn_status'];
    $hostelCheckInDate=!empty($fetchArr['s_hos_checkIn_cDate'])
    ? date("d-m-Y h:i A", strtotime($fetchArr['s_hos_checkIn_cDate']))
    : '';
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
        $admittedStatus='';
        $reportStatus='';
        $familyPhoto='';
        $reportDate='';
        $idCardIssuedDate='';
        $bagIssuedDate='';
        $tshirtIssuedDate='';
        $admittedDated='';
        $admittedRemarks='';
         $hostelReportedDate='';
         $hostelStatus='';
    $hostelName='';
    $roomCategory='';
    $roomNo='';
    $paymentStatus='';
   
    $hostelRemarks='';
    $hostelCheckInStatus='';
    $hostelCheckInDate='';
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
   <style>
 

    .profile-card {
      max-width: 1100px;
      width: 100%;
      background: white;
      border-radius: 32px;
      box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.12);
      padding: 2rem 2.5rem 2.5rem;
      transition: 0.2s;
    }

    /* ===== grid layout ===== */
    .profile-grid {
      display: grid;
      grid-template-columns: 1fr 1.6fr;
      gap: 2rem 2.8rem;
      margin-top: 0.25rem;
    }

    /* ---------- left column ---------- */
    .left-panel {
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }

    /* avatar + name */
    .avatar-section {
      display: flex;
      align-items: center;
      gap: 1.2rem;
    }

    /*.avatar-placeholder {*/
    /*  width: 80px;*/
    /*  height: 80px;*/
    /*  border-radius: 50%;*/
    /*  background: linear-gradient(145deg, #d9e2ef, #c0cee0);*/
    /*  display: flex;*/
    /*  align-items: center;*/
    /*  justify-content: center;*/
    /*  font-size: 2rem;*/
    /*  font-weight: 500;*/
    /*  color: #1f2a44;*/
    /*  flex-shrink: 0;*/
    /*  box-shadow: 0 6px 12px rgba(0,0,0,0.02);*/
    /*}*/
.avatar-placeholder {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;   /* Important */
    flex-shrink: 0;
    box-shadow: 0 6px 12px rgba(0,0,0,0.02);
}

.avatar-placeholder img {
    width: 82px;
    height: 89px;
    object-fit: cover;
    display: block;
    position:unset !important;
}
    .name-title h2 {
      font-size: 1.6rem;
      font-weight: 600;
      color: #0b1a33;
      letter-spacing: -0.3px;
    }

    .name-title .badge {
      background: #eef3fa;
      padding: 0.25rem 1rem;
      border-radius: 40px;
      font-size: 0.7rem;
      font-weight: 600;
      color: #1f3a6b;
      display: inline-block;
      margin-top: 4px;
      letter-spacing: 0.3px;
    }

    /* info blocks */
    .info-block {
      background: #f9fbfe;
      border-radius: 20px;
      padding: 1.2rem 1.5rem;
    }

    .info-block .label {
      font-size: 0.7rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #6b7e9c;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }

    .info-row {
      display: flex;
      align-items: baseline;
      gap: 0.75rem;
      padding: 0.35rem 0;
      font-size: 0.95rem;
    }

    .info-row i {
      width: 1.2rem;
      color: #3f5a82;
      font-size: 0.9rem;
    }

    .info-row .value {
      color: #14273e;
      font-weight: 450;
      word-break: break-word;
    }

    .info-row .sub {
      color: #5d738f;
      font-size: 0.85rem;
    }

    .language-tag {
      background: #e3eaf5;
      padding: 0.2rem 1rem;
      border-radius: 30px;
      font-size: 0.8rem;
      font-weight: 500;
      color: #1f3a6b;
      display: inline-block;
    }

    .bio-text {
      color: #1e344e;
      line-height: 1.5;
      font-size: 0.95rem;
      margin-top: 0.2rem;
    }

    /* ---------- right panel (edit) ---------- */
    .right-panel {
      display: flex;
      flex-direction: column;
      gap: 1.8rem;
    }

    .section-title {
      font-size: 1.1rem;
      font-weight: 600;
      color: #0b1a33;
      letter-spacing: -0.2px;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      border-bottom: 1px solid #e7ecf5;
      padding-bottom: 0.7rem;
    }

    .section-title i {
      color: #2c4a7c;
      font-size: 1rem;
    }

    .edit-form {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .form-row {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem 1.8rem;
    }

    .form-group {
      flex: 1 0 calc(50% - 1rem);
      min-width: 160px;
    }

    .form-group.full-width {
      flex: 1 0 100%;
    }

    .form-group label {
      display: block;
      font-size: 0.7rem;
      font-weight: 600;
      color: #40587a;
      text-transform: uppercase;
      letter-spacing: 0.3px;
      margin-bottom: 0.25rem;
    }

    .form-group label .required-star {
      color: #b22234;
      margin-left: 2px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 0.7rem 1rem;
      background: #f6f9ff;
      border: 1px solid #dde5f0;
      border-radius: 16px;
      font-size: 0.9rem;
      color: #0f1f33;
      transition: 0.15s;
      outline: none;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      border-color: #6f8fc9;
      background: white;
      box-shadow: 0 0 0 3px rgba(60, 100, 177, 0.08);
    }

    .form-group input::placeholder,
    .form-group textarea::placeholder {
      color: #8c9eb8;
      font-weight: 300;
    }

    .form-group textarea {
      resize: vertical;
      min-height: 70px;
    }

    .form-group .hint {
      font-size: 0.7rem;
      color: #7b8ea8;
      margin-top: 4px;
    }

    /* change password block */
    .password-block {
      background: #fafcff;
      border-radius: 20px;
      padding: 1rem 0 0.2rem 0;
      margin-top: 0.2rem;
    }

    .password-block .form-group {
      margin-bottom: 0.8rem;
    }

    /* notification + buttons */
    .action-row {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      margin-top: 0.8rem;
      border-top: 1px solid #e7ecf5;
      padding-top: 1.4rem;
    }

    .notification-toggle {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      color: #1f3a6b;
      font-weight: 500;
      font-size: 0.9rem;
    }

    .notification-toggle i {
      font-size: 1.3rem;
      color: #2f4c7c;
    }

    .btn-group {
      display: flex;
      gap: 1rem;
    }

    .btn {
      padding: 0.6rem 1.8rem;
      border-radius: 40px;
      font-weight: 600;
      font-size: 0.85rem;
      border: none;
      background: transparent;
      cursor: default;
      transition: 0.1s;
      letter-spacing: 0.2px;
    }

    .btn-outline {
      background: #f0f4fe;
      color: #1f3a6b;
      border: 1px solid #d4e0f0;
    }

    .btn-primary {
      background: #1b3a6b;
      color: white;
      box-shadow: 0 4px 8px rgba(25, 60, 130, 0.12);
    }

    .btn-primary i {
      margin-right: 6px;
    }

    /* small extras */
    .profile-image-edit {
      display: flex;
      align-items: center;
      gap: 0.8rem;
      padding: 0.4rem 0;
    }

    .profile-image-edit span {
      font-weight: 500;
      color: #1f3a6b;
    }

    .profile-image-edit i {
      color: #4b6b97;
    }

    .edit-pic-link {
      color: #2a4d84;
      font-size: 0.8rem;
      font-weight: 500;
      text-decoration: none;
      border-bottom: 1px dashed #b2c6e0;
    }

    /* responsive */
    @media (max-width: 780px) {
      .profile-grid {
        grid-template-columns: 1fr;
        gap: 1.8rem;
      }
      .profile-card {
        padding: 1.5rem;
      }
      .form-group {
        flex: 1 0 100%;
      }
      .action-row {
        flex-direction: column;
        align-items: start;
        gap: 1rem;
      }
      .btn-group {
        width: 100%;
        justify-content: flex-end;
      }
    }

    @media (max-width: 480px) {
      .avatar-section {
        flex-direction: column;
        align-items: flex-start;
      }
      .btn-group {
        flex-wrap: wrap;
      }
      .btn {
        flex: 1;
        text-align: center;
      }
    }
    
    .signature-wrapper {
    width: 200px;
    height: 60px;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;  /* Important: Hide overflow */
}

/* Force image to fit */
.signature-img {
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
    object-fit: contain;  /* Show full image without cropping */
    display: block;
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
                             
                            <div class="row">
                               
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Profile View <?php echo $utStatus; ?></h5>
                                        </div>
                                        <div class="card-body table-border-style">
                                            <div class="profile-card">
                                                <div class="profile-grid">
                                                  <!-- LEFT COLUMN : Personal Info, Department, Languages, Bio -->
                                                  <div class="left-panel">
                                                    <!-- avatar + name (Will Jonto style) -->
                                                   <div class="avatar-section">
                                                        <div class="avatar-placeholder">
                                                            <?php 
                                                            $imagePath = "../uploads/2026/" . $appno . "/" . $photo;
                                                            if (!empty($photo) && file_exists($imagePath)) { 
                                                            ?>
                                                                <img src="<?php echo $imagePath; ?>" alt="<?php echo $firstname; ?> <?php echo $lastname; ?>" />
                                                            <?php } else { ?>
                                                                <div class="avatar-fallback">
                                                                    <?php echo strtoupper(substr($firstname, 0, 1)); ?>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="name-title">
                                                            <h2><?php echo htmlspecialchars($firstname); ?> <?php echo htmlspecialchars($lastname); ?></h2>
                                                            <span class="badge"><i class="fas fa-hashtag" style="margin-right: 6px;"></i> <?php echo htmlspecialchars($appno); ?></span>
                                                        </div>
                                                    </div>

                                                    <!-- Personal Info -->
                                                    <div class="info-block">
                                                      <!--<div class="label"><i class="fas fa-address-card" style="margin-right: 6px;"></i> Personal Info</div>-->
                                                      <div class="info-row"><i class="far fa-envelope"></i> <span class="value"><?php echo $emailID; ?></span></div>
                                                      <div class="info-row"><i class="fas fa-phone-alt"></i> <span class="value">(+91) <?php echo $mobile; ?></span></div>
                                                      <!--<div class="info-row"><i class="fas fa-phone-alt"></i> <span class="value">(+91) <?php echo $alterMobile; ?></span></div>-->
                                                      <div class="info-row"> Programme: <br><?php echo $dept; ?></div>
                                                    </div>
                                            
                                                    <!-- Department -->
                                                    <div class="info-block">
                                                      <div class="info-row"> Address: <br><?php echo $address1; ?>, <?php echo $address2; ?> ,<br>
                                                      <?php echo $area; ?> ,<?php echo $city; ?> ,<br><?php echo $district; ?> ,<?php echo $state; ?> ,<br><?php echo $pincode; ?></div>
                                                      <!--<div class="info-row">Gender: <?php echo $gender; ?> </div>-->
                                                    </div>
                                                    
                                                 <div class="info-block">
                                                    <!-- Student Signature -->
                                                    <div class="info-row">
                                                        <div class="signature-label">
                                                            Student Signature:
                                                        </div>
                                                        <div class="signature-wrapper">
                                                            <?php 
                                                            $signaturePath = "../uploads/2026/" . $appno . "/" . $signature; // Fixed variable name
                                                            if (!empty($signature) && file_exists($signaturePath)) { 
                                                            ?>
                                                                <img src="<?php echo htmlspecialchars($signaturePath); ?>" 
                                                                     alt="Student Signature - <?php echo htmlspecialchars($firstname . ' ' . $lastname); ?>" 
                                                                     class="signature-img" />
                                                            <?php } else { ?>
                                                                <div class="signature-fallback">
                                                                    <span><?php echo strtoupper(substr(htmlspecialchars($firstname), 0, 1)); ?></span>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                
                                                    <!-- Parent Signature -->
                                                    <div class="info-row">
                                                        <div class="signature-label">
                                                             Father Signature:
                                                        </div>
                                                        <div class="signature-wrapper">
                                                            <?php 
                                                            $parentSignaturePath = "../uploads/2026/" . $appno . "/" . $parent_signature;
                                                            if (!empty($parent_signature) && file_exists($parentSignaturePath)) { 
                                                            ?>
                                                                <img src="<?php echo htmlspecialchars($parentSignaturePath); ?>" 
                                                                     alt="Parent Signature - <?php echo htmlspecialchars($firstname . ' ' . $lastname); ?>" 
                                                                     class="signature-img" />
                                                            <?php } else { ?>
                                                                <div class="signature-fallback">
                                                                    <span><?php echo strtoupper(substr(htmlspecialchars($firstname), 0, 1)); ?></span>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="info-row">
                                                        <div class="signature-label">
                                                             Family Photo:
                                                        </div>
                                                        <div class="signature-wrapper">
                                                            <?php 
                                                            $familyPhotoPath = "../uploads/2026/" . $appno . "/" . $familyPhoto;
                                                            if (!empty($familyPhoto) && file_exists($familyPhotoPath)) { 
                                                            ?>
                                                                <img src="<?php echo htmlspecialchars($familyPhotoPath); ?>" 
                                                                     alt="Family Photo - <?php echo htmlspecialchars($firstname . ' ' . $lastname); ?>" 
                                                                     class="signature-img" />
                                                            <?php } else { ?>
                                                                <div class="signature-fallback">
                                                                    <span><?php echo strtoupper(substr(htmlspecialchars($firstname), 0, 1)); ?></span>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                    
                                                  </div>

                                                  <!-- RIGHT COLUMN : Edit Profile + Change Password + Notification -->
                                                  <div class="right-panel">
                                            
                                                    <!-- Edit Profile (with profile image line) -->
                                                    <div>
                                                      <div class="section-title"><i class="fas fa-user-edit"></i> Student's Details</div>
                                                      <div class="edit-form" style="margin-top: 0.5rem;">
                                                        <!-- Profile Image (replica) -->
                                                        <!--<div class="profile-image-edit">-->
                                                        <!--  <i class="fas fa-camera" style="font-size: 1.2rem; color: #1f3a6b;"></i>-->
                                                        <!--  <span>Profile Image</span>-->
                                                        <!--  <a href="#" class="edit-pic-link" style="margin-left: auto;"><i class="fas fa-upload"></i> change photo</a>-->
                                                        <!--</div>-->
                                            
                                                        <!-- two columns form -->
                                                        <div class="form-row">
                                                            <div class="form-group">
                                                                <label>Date of Birth <span class="required-star">*</span></label> 
                                                                <input type="email" value="<?php echo $dob;?>" readonly/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Gender <span class="required-star">*</span></label> 
                                                                <input type="text" value="<?php echo $gender;?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Blood Group</label> 
                                                                <input type="text" value="<?php echo $bld_grp;?>" >
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Batch <span class="required-star">*</span></label> 
                                                                <input type="text" value="<?php echo $batch;?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Student Type <span class="required-star">*</span></label> 
                                                                <input type="text" value="<?php echo $stuType;?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Student Reported Status <span class="required-star">*</span></label> 
                                                                <input type="text" value="<?php echo $reportStatus;?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Student Reported Date <span class="required-star">*</span></label> 
                                                                <input type="text" value="<?php echo $reportDate;?>" >
                                                            </div>
                                                        </div>
                                                       
                                                      </div>
                                                    </div>
                                            
                                                    <!-- Change Password -->
                                                    <div>
                                                      <div class="section-title"><i class="fas fa-lock"></i> Parents Details</div>
                                                       <div class="edit-form" style="margin-top: 0.5rem;">
                                                        <!-- two columns form -->
                                                        <div class="form-row">
                                                            <div class="form-group">
                                                                <label>Father Name <span class="required-star">*</span></label> 
                                                                <input type="text" value="<?php echo $fathername;?>" readonly/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Mother Name <span class="required-star">*</span></label> 
                                                                <input type="text" value="<?php echo $mothername;?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Parents Mobile</label> 
                                                                <input type="text" value="<?php echo $alterMobile;?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Parents Email <span class="required-star">*</span></label> 
                                                                <input type="text" value="<?php echo $fatherEmail;?>" readonly>
                                                            </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div>
                                                        <?php if($hostelStatus=='REPORTED'){ ?>
                                                      <div class="section-title"><i class="fas fa-lock"></i> Hostel Details</div>
                                                       <div class="edit-form" style="margin-top: 0.5rem;">
                                                        <!-- two columns form -->
                                                        <div class="form-row">
                                                            <div class="form-group">
                                                                <label>Hostel Reported Status <span class="required-star">*</span></label> 
                                                                <input type="text" value="<?php echo $hostelStatus;?>" readonly/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Hostel Reported Date <span class="required-star">*</span></label> 
                                                                <input type="text" value="<?php echo $hostelReportedDate;?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Hostel Check-In Status</label> 
                                                                <input type="text" value="<?php echo $hostelCheckInStatus;?>" >
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Hostel Check-In Date <span class="required-star">*</span></label> 
                                                                <input type="text" value="<?php echo $hostelCheckInDate;?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Hostel Name <span class="required-star">*</span></label> 
                                                                <input type="text" value="<?php echo $hostelName;?>" readonly/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Room Category <span class="required-star">*</span></label> 
                                                                <input type="text" value="<?php echo $roomCategory;?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Room No</label> 
                                                                <input type="text" value="<?php echo $roomNo;?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Payment Status <span class="required-star">*</span></label> 
                                                                <input type="text" value="<?php echo $paymentStatus;?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Remarks <span class="required-star">*</span></label> 
                                                                <input type="text" value="<?php echo $hostelRemarks;?>" readonly>
                                                            </div>
                                                        </div>
                                                      </div>
                                                      <?php } ?>
                                                      <div class="section-title"><i class="fas fa-lock"></i> Admit Card Details</div>
                                                       <div class="edit-form" style="margin-top: 0.5rem;">
                                                        <!-- two columns form -->
                                                        <div class="form-row">
                                                            <div class="form-group">
                                                                <label>Admit Card Status <span class="required-star">*</span></label> 
                                                                <input type="text" value="<?php echo $admittedStatus;?>" readonly/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Admit Card Issued Date <span class="required-star">*</span></label> 
                                                                <input type="text" value="<?php echo $admittedDated;?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Remarks <span class="required-star">*</span></label> 
                                                                <input type="text" value="<?php echo $admittedRemarks;?>" readonly/>
                                                            </div>
                                                           
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div>
                                                      <!--<div class="section-title"><i class="fas fa-lock"></i> ID Card & Welcome Kit Details</div>-->
                                                      <!-- <div class="edit-form" style="margin-top: 0.5rem;">-->
                                                      <!--  <div class="form-row">-->
                                                            
                                                      <!--      <div class="form-group">-->
                                                      <!--          <label>Id Card Status <span class="required-star">*</span></label> -->
                                                      <!--          <input type="text" value="<?php echo $idCardStatus;?>"/>-->
                                                      <!--      </div>-->
                                                      <!--      <div class="form-group">-->
                                                      <!--          <label>Id Card Issued Date <span class="required-star">*</span></label> -->
                                                      <!--          <input type="text" value="<?php echo $idCardIssuedDate;?>" >-->
                                                      <!--      </div>-->
                                                      <!--      <div class="form-group">-->
                                                      <!--          <label>Bag Status</label> -->
                                                      <!--          <input type="text" value="<?php echo $bagStatus;?>" >-->
                                                      <!--      </div>-->
                                                      <!--      <div class="form-group">-->
                                                      <!--          <label>Bag Issued Date <span class="required-star">*</span></label> -->
                                                      <!--          <input type="text" value="<?php echo $bagIssuedDate;?>" >-->
                                                      <!--      </div>-->
                                                      <!--      <div class="form-group">-->
                                                      <!--          <label>Tshirt Status</label> -->
                                                      <!--          <input type="text" value="<?php echo $tshirtStatus;?>" >-->
                                                      <!--      </div>-->
                                                      <!--      <div class="form-group">-->
                                                      <!--          <label>Tshirt Issued Date <span class="required-star">*</span></label> -->
                                                      <!--          <input type="text" value="<?php echo $tshirtIssuedDate;?>" >-->
                                                      <!--      </div>-->
                                                            
                                                      <!--  </div>-->
                                                      <!--</div>-->
                                                    </div>
                                                    <!-- Notification Settings + Cancel/Save -->
                                                    <div class="action-row">
                                                      <div class="btn-group">
                                                          <?php
                                                            $allowedPages = [
                                                                'studentEntryList',
                                                                'uploadStudentProfileList',
                                                                'studentAdmitCardList',
                                                                'studentProgrameList',
                                                                'idcardEligibleList',
                                                                'tshirtEligibleList',
                                                                'bagEligibleList',
                                                                'studentAdmitCardReportList',
                                                                'idCardIssuedReportList',
                                                                'tshirtIssuedReportList',
                                                                'bagIssuedReportList',
                                                                'studentOverAllReportList',
                                                                'hostelReportedList',
                                                                'studentCounsellorList',
                                                                'hostelCheckedInReportList',
                                                                'admissionOwnerWiseDetails',
                                                                'studentReportList',
                                                                'studentHostelEntryList',
                                                                'studentRegistredReport',
                                                                'idCardVerifiedReportList'
                                                            ];
                                                            
                                                            $backUrl = in_array($redirect, $allowedPages)
                                                                ? $redirect . '.php'
                                                                : 'index.php';
                                                        ?>
                                                            <a href="<?php echo $backUrl; ?>" class="btn btn-primary float-right">
                                                                <i class="fas fa-arrow-left"></i> Back
                                                            </a>
                                                            
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>

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
                        You are about to permanently delete this state.
                    </p>
    
                    <div class="card bg-light border-0">
                        <div class="card-body text-start">
                            <p class="mb-2">
                                <strong>State:</strong>
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
                state: {
                    required: true,
                },
                state_short:{
                    required:true,
                },
                status: {
                    required: true
                }
            },
            messages: {
                state: {
                    required: "Please enter state",
                },
                state_short:{
                    required:"Please enter state short code",
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
                    url: "save.php?request=saveState&type=<?php echo $type;?>",
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
                            window.location.href = './stateList.php?type=Add';
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
            let stname = $(this).data('deptname');
    
            $.ajax({
                url: 'save.php?request=deleteState',
                type: 'POST',
                data: {
                    id: id,
                    stname: stname
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
                            window.location.href = './stateList.php?type=Add';
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
