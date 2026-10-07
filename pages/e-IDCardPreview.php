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
       $fullname=$fetchArr['s_full_name'];
       $dob=$fetchArr['s_dob'];
       $address=$fetchArr['s_address'];
       $mobile=$fetchArr['s_mobile_no'];
       $alterMobile=$fetchArr['s_alternate_mobile'];
       $gender=$fetchArr['s_gender'];
       $dept=$fetchArr['s_department'];
        $bld_grp=$fetchArr['s_blood_group'];
        $batch=$fetchArr['s_batch'];
        $stuType=$fetchArr['s_stu_type'];
        $modeOfTransport=$fetchArr['s_modeOfTransport'];
        $status=$fetchArr['s_status'];
        $photo=$fetchArr['s_photo'];
        $signature=$fetchArr['s_signature'];
   }else{
       $studentID='';
       $appno='';
       $fullname='';
       $dob='';
       $address='';
       $mobile='';
       $alterMobile='';
       $gender='';
       $dept='';
       $bld_grp='';
       $batch='';
       $stuType='';
       $modeOfTransport='';
       $status='';
       $photo='';
       $signature='';
   }
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

.id-card{
    width:770px;
    height:940px;
    background:#fff;
    display:flex;
    overflow:hidden;
    border:1px solid #ddd;
}

.left-strip{
    width:155px;
    background:#244992;
    display:flex;
    justify-content:center;
    align-items:center;
}

.left-strip span{
    writing-mode:vertical-rl;
    transform:rotate(180deg);
    color:#fff;
    font-size:70px;
    font-weight:bold;
    letter-spacing:2px;
}

.content{
    flex:1;
    position:relative;
    padding:35px 25px;
}

.header{
    display:flex;
    align-items:center;
}

.logo img{
    width:570px;
}

.college{
    margin-left:15px;
}

.college h1{
    font-size:140px;
    color:#222343;
    line-height:1;
}

.college p{
    color:#444;
    font-size:28px;
}

.college h2{
    color:#293a84;
    font-size:34px;
    margin-top:5px;
}

.batch{
    display:inline-block;
    margin-top:25px;
    background:#234a93;
    color:#fff;
    font-size:48px;
    font-weight:bold;
    padding:10px 18px;
}

.photo-box{
    margin-top:20px;
    width:365px;
    height:390px;
    border:5px solid #234a93;
    display:flex;
    justify-content:center;
    align-items:center;
}

.photo-box img{
    width:98%;
    height:98%;
    object-fit:cover;
}

.student-type{
    position:absolute;
    top:440px;
    left:390px;
    width:78px;
    height:78px;
    background:#234a93;
    color:#fff;
    border-radius:0 18px 18px 0;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:42px;
    font-weight:bold;
}
/* Hosteller - Red */
.student-type.hosteller{
    background:#e53935;
}

/* Day Scholar - Light Blue */
.student-type.dayscholar{
    background:#4FC3F7;
}

/* Transport - Dark Blue */
.student-type.transport{
    background:#234a93;
}
.hosteller-text{
    color:#e53935;
}
/* Day Scholar - Light Blue */
.dayscholar-text{
    color:#4FC3F7;
}

/* Transport - Dark Blue */
.transport-text{
    color:#002147;
}

.hosteller-bg{
    background-color:#e53935;
}
/* Day Scholar - Light Blue */
.dayscholar-bg{
    background-color:#4FC3F7;
}

/* Transport - Dark Blue */
.transport-bg{
    background-color:#234a93;
}

/* Student Details */

.student-details {
    margin-top: 30px;
    width: 90%;
    text-align: left;
}

.student-name{
    font-size:36px;
    color:#234a93;
    font-weight:bold;
    text-transform:uppercase;
    margin-bottom:10px;
}

.course{
    font-size:22px;
    color:#222;
    font-weight:600;
    line-height:1.5;
    margin-bottom:8px;
}

.regno{
    font-size:20px;
    color:#444;
    font-weight:bold;
}

/* Principal */



.principal img{
    width:180px;
    height:auto;
    object-fit:contain;
}

.principal h4{
    margin-top:5px;
    font-size:20px;
    color:#234a93;
    letter-spacing:1px;
}
.right-design{
    position: absolute;
    right: 0;
    bottom: 0;
    width: 70px;
    height: 50%;
}
.principal{
    position:absolute;
    bottom:0px;
    right:30px;

    width:220px;          /* 50% size */
    text-align:center;
}

.principal img{
    width:120px;          /* Signature size */
    height:auto;
    display:block;
    margin:0 auto;
}

.principal h4{
    margin-top:8px;
    font-size:18px;
    color:#234a93;
    font-weight:bold;
    border-top:2px solid #234a93;
    padding-top:6px;
    width:140px;
    margin-left:auto;
    margin-right:auto;
}

 *{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

.back-card{
    width:770px;
    height:940px;
    background:#fff;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    border:1px solid #ccc;
}

/* Details */

.details{
    padding:50px 30px 20px;
}

.row{
    display:grid;
    grid-template-columns:175px 20px 1fr;
    margin-bottom:15px;
    color:#244992;
    font-size:28px;
    line-height:1.4;
}

.address{
    align-items:flex-start;
}

.label{
    font-weight:500;
    width: 185px;
}

.colon{
    text-align:center;
}

.value{
    color:#244992;
}

.footer{

    background:#244992;
    color:#fff;

    text-align:center;

    padding:40px 20px;
}

.footer h2{

    font-size:48px;
    margin-bottom:25px;
    font-weight:bold;
}

.footer p{

    font-size:18px;
    line-height:1.5;
    margin-bottom:30px;
    font-weight:600;
}

.validity{

    display:inline-block;
    /*background:#fff;*/
    color:#fff;

    padding:12px 18px;

    font-size:22px;
    font-weight:bold;

    border-radius:2px;
}
</style>

<!-- DataTables CSS & Buttons CSS -->
<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">-->
<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">-->
<!-- Font Awesome for icons -->
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
                                <div class=" align-items-center">
                                    <div class="col-md-12">
                                        <div class="page-header-title">
                                            <h5 class="m-b-10">Student E-ID Card Preview</h5>
                                        </div>
                                        <?php if(isset($prev['19'])=='Y'){ ?>
                                        <button class="btn btn-primary float-right">
                                            <a href="studentEntryAddEdit.php?type=Add" style="color:white;">Add</a>
                                        </button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- [ breadcrumb ] end -->
                        <!-- [ Main Content ] start -->
                        <div class="">
                            <div class="col-xl-12">
                                <div class="card">
                                     
                                    <div class="card-body table-border-style">
                                        <div class="id-card ">

                                        <!-- Left Vertical Strip -->
                                        <div class="left-strip">
                                            <span>STUDENT IDENTITY CARD</span>
                                        </div>
                                    
                                        <!-- Main Content -->
                                        <div class="content">
                                    
                                            <!-- Header -->
                                            <div class="header">
                                                <!--<div class="logo">-->
                                                <!--    <img src="https://avcampusadmissions.com/idcard/assets/logo/AVITLogowhite.png" alt="AVIT Logo">-->
                                                <!--</div>-->
                                    
                                                <div class="college logo">
                                                     <img src="https://avcampusadmissions.com/idcard/assets/logo/AVITLogowhite.png" alt="AVIT Logo">
                                                </div>
                                            </div>
                                    
                                            <!-- Batch -->
                                            <div class="batch">
                                                Batch <?php echo $batch; ?>
                                            </div>
                                    
                                            <!-- Photo -->
                                            <div class="photo-box">
                                                <img src="../uploads/students/<?php echo $photo; ?>" alt="Student Photo">
                                            </div>
                                        
                                            <!-- Student Type -->
                                            <?php
                                            $studentTypeClass = '';
                                            $studentTypeBgClass='';
                                            if($stuType == 'Hosteller'){
                                                $studentTypeClass = 'hosteller';
                                                $studentTypeTextClass = 'hosteller-text';
                                                $studentTypeBgClass = 'hosteller-bg';
                                                $label = 'H';
                                            }elseif($stuType == 'Day Scholar - College Transport'){
                                                $studentTypeClass = 'transport';
                                                $studentTypeTextClass = 'transport-text';
                                                $studentTypeBgClass = 'transport-bg';
                                                $label = 'T';
                                            }else if($stuType=='Day Scholar - No College Transport'){
                                                $studentTypeClass = 'dayscholar';
                                                $studentTypeTextClass = 'dayscholar-text';
                                                $studentTypeBgClass = 'dayscholar-bg';
                                                $label = 'D';
                                            }
                                            ?>
                                            <div class="student-type <?php echo $studentTypeClass; ?>">
                                                <label><?php echo $label; ?></label>
                                            </div>
                                            
                                            <!-- Student Details -->
                                            <div class="student-details">
                                            
                                                <h2 class="student-name"><?php echo $fullname; ?></h2>
                                            
                                                <p class="course">
                                                    <?php echo $dept; ?>
                                                </p>
                                            
                                                <!--<p class="regno">-->
                                                <!--    Reg No : 1234567890-->
                                                <!--</p>-->
                                            
                                            </div>
                                            
                                            <!-- Principal Signature -->
                                            <div class="principal">
                                            
                                                <img src="principal-sign.png" alt="Principal Signature">
                                            
                                                <h4>PRINCIPAL</h4>
                                            
                                            </div>
                                            <img src="../assets/images/rightbar.jpg" class="right-design">
                                        </div>
                                    
                                    </div>
                                <br>
                                <style>
                                   
                                </style>
                                <div class="back-card">
                                
                                    <div class="details">
                                
                                        <div class="row">
                                            <span class="label">Date of Birth</span>
                                            <span class="colon">:</span>
                                            <span class="value"><?php echo $dob; ?></span>
                                        </div>
                                
                                        <div class="row">
                                            <span class="label">Blood Group</span>
                                            <span class="colon">:</span>
                                            <span class="value"><?php echo $bld_grp; ?></span>
                                        </div>
                                
                                        <div class="row address">
                                            <span class="label">Address</span>
                                            <span class="colon">:</span>
                                            <span class="value">
                                                <?php echo $address; ?>
                                            </span>
                                        </div>
                                
                                        <div class="row">
                                            <span class="label">Contact</span>
                                            <span class="colon">:</span>
                                            <span class="value">+91 <?php echo $mobile; ?></span>
                                        </div>
                                
                                        <div class="row">
                                            <span class="label">Emergency Contact</span>
                                            <span class="colon">:</span>
                                            <span class="value">+91 <?php echo $alterMobile; ?></span>
                                        </div>
                                
                                    </div>
                                
                                    <div class="footer">
                                
                                        <h2 class="<?php echo $studentTypeTextClass; ?>"><?php echo $stuType; ?></h2>
                                
                                        <p>
                                            AARUPADAI VEEDU INSTITUTE OF TECHNOLOGY<br>
                                            Vinayaka Nagar, Rajiv Gandhi Salai<br>
                                            (Old Mahabalipuram Road) Paiyanoor,<br>
                                            Chennai-603104
                                        </p>
                                
                                        <div class="validity <?php echo $studentTypeBgClass; ?>">
                                            This Identity Card Is Valid till 31 Dec 2026
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