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
        $userType=$fetchArr['ut_name'];
        $prev=json_decode($fetchArr['ut_prev'],true);
    }
    include '../common/header.php'; 
    $headName=$_SESSION['USER_HEAD_NAME'];
    $currentDate=date("Y-m-d"); 
    $currentFormatDate=date('j M y'); 
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
#searchResult{
    position:absolute;
    width:100%;
    z-index:9999;
    display:none;
    max-height:250px;
    overflow-y:auto;
    top: 65px;
}

.student-item.active{
    background:#0d6efd;
    color:#fff;
}
</style>
	<!-- [ Main Content ] start -->
	<div class="pcoded-main-container">
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
											<div class="page-header-title">
												<h5><i class="feather icon-home"></i> Dashboard</h5>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- [ breadcrumb ] end -->
							<!-- [ Main Content ] start -->
							<div class="row">
							    
                                <?php if(isset($prev['2'])=='Y'){ ?>
								<!-- product profit start -->
								<div class="col-xl-3 col-md-6">
									<div class="card prod-p-card bg-c-red">
										<div class="card-body">
											<div class="row align-items-center m-b-25">
												<div class="col">
													<h6 class="m-b-5 text-white">Total Regular Students</h6>
													<?php 
													$cond1 = "s_status='1' AND s_course_type='REGULAR'";
                                                        
                                                    if ($userType == 'Super Admin' || $headName == 'Others') {

                                                        // Show all records
                                                    }else if ($userType == 'Admin' || $headName == 'Others') {

                                                        // Show all records
                                                    } elseif (!empty($headName)) {
                                                    
                                                        $cond1 .= " AND s_admissionOwner='$headName'";
                                                    
                                                    } else {
                                                    
                                                        $cond1 .= " AND s_admissionOwner='$userName'";
                                                    }
													$sql1 = "SELECT * 
                                                        FROM student_details 
                                                        WHERE $cond1
                                                        ORDER BY s_idcardDate DESC";
                                                    $result1 = mysqli_query($conn, $sql1);
                                                    $studentCount=mysqli_num_rows($result1);
													?>
													<h3 class="m-b-0 text-white"><?php echo $studentCount; ?></h3>
												</div>
												<div class="col-auto">
													<i class="fa-solid fa-users text-c-blue f-18"></i>
												</div>
											</div>
											<!--<p class="m-b-0 text-white"><span class="label label-danger m-r-10">+11%</span>From Previous Month</p>-->
										</div>
									</div>
								</div>
								<?php } ?>
								<?php if(isset($prev['3'])=='Y'){ ?>
								<!-- product profit start -->
								<div class="col-xl-3 col-md-6">
									<div class="card prod-p-card bg-c-purple">
										<div class="card-body">
											<div class="row align-items-center m-b-25">
												<div class="col">
													<h6 class="m-b-5 text-white">Reported Regular Students</h6>
													
													<?php 
													    $cond8 = "s_status='1' AND s_course_type='REGULAR'
                                                              AND s_reportedStatus='REPORTED'
                                                              AND DATE(s_reportedcDate) = '$currentDate'";
                                                        if ($userType == 'Super Admin' || $headName == 'Others') {
                                                            // Show all records
                                                        } elseif ($userType == 'Admin' || $headName == 'Others') {
                                                            // Show all records
                                                        } elseif (!empty($headName)) {
                                                            $cond8 .= " AND s_admissionOwner='$headName'";
                                                        } else {
                                                            $cond8 .= " AND s_admissionOwner='$userName'";
                                                        }
                                                        
                                                        $sql8 = "SELECT COUNT(*) AS total
                                                                 FROM student_details
                                                                 WHERE $cond8";
                                                                 //echo $sql8;exit;
                                                        $result8 = mysqli_query($conn, $sql8);
                                                        $row8 = mysqli_fetch_assoc($result8);
                                                        $studentTodayCount8 = $row8['total'];
                                                    ?>
                                                    <h6 class="m-b-0 text-white"><?php echo $currentFormatDate; ?>, Count - <?php echo $studentTodayCount8; ?></h6>
                                                    <?php 
													$cond2 = "s_status='1' AND s_reportedStatus='REPORTED' AND s_course_type='REGULAR'";
                                                        
                                                    if ($userType == 'Super Admin' || $headName == 'Others') {

                                                        // Show all records
                                                    }else if ($userType == 'Admin' || $headName == 'Others') {

                                                        // Show all records
                                                    } elseif (!empty($headName)) {
                                                    
                                                        $cond2 .= " AND s_admissionOwner='$headName'";
                                                    
                                                    } else {
                                                    
                                                        $cond2 .= " AND s_admissionOwner='$userName'";
                                                    }
													$sql2 = "SELECT * 
                                                        FROM student_details 
                                                        WHERE $cond2 ";
                                                    $result2 = mysqli_query($conn, $sql2);
                                                    $studentCount2=mysqli_num_rows($result2);
													?>
													<h6 class="m-b-0 text-white">Total Count- <?php echo $studentCount2; ?></h6>
												</div>
												<div class="col-auto">
													<i class="fa-solid fa-users text-c-blue f-18"></i>
												</div>
											</div>
											<!--<p class="m-b-0 text-white"><span class="label label-danger m-r-10">+11%</span>From Previous Month</p>-->
										</div>
									</div>
								</div>
								<?php } ?>
								  <?php if(isset($prev['4'])=='Y'){ ?>
								<!-- product profit start -->
								<div class="col-xl-3 col-md-6">
									<div class="card prod-p-card bg-c-infocyan">
										<div class="card-body">
											<div class="row align-items-center m-b-25">
												<div class="col">
													<h6 class="m-b-5 text-white">Regular Admit Card Issued</h6>
													<?php 
													$cond11 = "s_status='1' AND s_reportedStatus='REPORTED' AND s_admittedStatus='ISSUED' AND DATE(s_admittedDate) = '$currentDate'  AND s_course_type='REGULAR'";
                                                        
                                                    if ($userType == 'Super Admin' || $headName == 'Others') {
                                                        // Show all records
                                                    }else if ($userType == 'Admin' || $headName == 'Others') {
                                                        // Show all records
                                                    } elseif (!empty($headName)) {
                                                        $cond11 .= " AND s_admissionOwner='$headName'";
                                                    } else {
                                                        $cond11 .= " AND s_admissionOwner='$userName'";
                                                    }
													$sql11 = "SELECT * 
                                                        FROM student_details 
                                                        WHERE $cond11
                                                        ORDER BY s_admittedDate DESC";
                                                    $result11 = mysqli_query($conn, $sql11);
                                                    $studentCount11=mysqli_num_rows($result11);
													?>
													<h6 class="m-b-0 text-white"><?php echo $currentFormatDate; ?>, Count - <?php echo $studentCount11; ?></h6>
													
													<?php 
													$cond3 = "s_status='1' AND s_reportedStatus='REPORTED' AND s_admittedStatus='ISSUED' AND s_course_type='REGULAR'";
                                                        
                                                    if ($userType == 'Super Admin' || $headName == 'Others') {
                                                        // Show all records
                                                    }else if ($userType == 'Admin' || $headName == 'Others') {
                                                        // Show all records
                                                    } elseif (!empty($headName)) {
                                                    
                                                        $cond3 .= " AND s_admissionOwner='$headName'";
                                                    
                                                    } else {
                                                    
                                                        $cond3 .= " AND s_admissionOwner='$userName'";
                                                    }
													$sql3 = "SELECT * 
                                                        FROM student_details 
                                                        WHERE $cond3
                                                        ORDER BY s_idcardDate DESC";
                                                    $result3 = mysqli_query($conn, $sql3);
                                                    $studentCount3=mysqli_num_rows($result3);
													?>
													<h6 class="m-b-0 text-white">Total Count - <?php echo $studentCount3; ?></h6>
												</div>
												<div class="col-auto">
													<i class="fa-solid fa-users text-c-blue f-18"></i>
												</div>
											</div>
											<!--<p class="m-b-0 text-white"><span class="label label-danger m-r-10">+11%</span>From Previous Month</p>-->
										</div>
									</div>
								</div>
								<?php } ?>
								<?php if(isset($prev['5'])=='Y'){ ?>
								<div class="col-xl-3 col-md-6">
									<div class="card prod-p-card bg-c-blue">
										<div class="card-body">
											<div class="row align-items-center m-b-25">
												<div class="col">
												    <h6 class="m-b-5 text-white">Regular ID Card Verified</h6>
												    <?php 
													    $cond10 = "s_status='1' AND s_course_type='REGULAR'
                                                              AND s_stu_verified='VERIFIED' AND s_reportedStatus='REPORTED'
                                                              AND DATE(s_stu_verifiedDate) = '$currentDate'";
                                                        if ($userType == 'Super Admin' || $headName == 'Others') {
                                                            // Show all records
                                                        } elseif ($userType == 'Admin' || $headName == 'Others') {
                                                            // Show all records
                                                        } elseif (!empty($headName)) {
                                                            $cond10 .= " AND s_admissionOwner='$headName'";
                                                        } else {
                                                            $cond10 .= " AND s_admissionOwner='$userName'";
                                                        }
                                                        
                                                        $sql10 = "SELECT COUNT(*) AS total
                                                                 FROM student_details
                                                                 WHERE $cond10";
                                                                 //echo $sql8;exit;
                                                        $result10 = mysqli_query($conn, $sql10);
                                                        $row10 = mysqli_fetch_assoc($result10);
                                                        $studentTodayVerifiedCount10 = $row10['total'];
                                                    ?>
                                                    <h6 class="m-b-0 text-white"><?php echo $currentFormatDate; ?>, Count - <?php echo $studentTodayVerifiedCount10; ?></h6>
													
													<?php 
													$sql9 = "SELECT * 
                                                            FROM student_details 
                                                            WHERE s_status='1' AND s_stu_verified='VERIFIED' AND s_reportedStatus='REPORTED' AND s_course_type='REGULAR'
                                                            ORDER BY s_idcardDate DESC";
                                                    $result9 = mysqli_query($conn, $sql9);
                                                    $idCardVerifiedCount=mysqli_num_rows($result9);
													?>
													<h6 class="m-b-0 text-white">Total Count - <?php echo $idCardVerifiedCount; ?></h6>
												</div>
												<div class="col-auto">
												    <i class="fa-solid fa-id-card text-c-blue f-18"></i>
												</div>
											</div>
											<!--<p class="m-b-0 text-white"><span class="label label-primary m-r-10">+12%</span>From Previous Month</p>-->
										</div>
									</div>
								</div>
								<div class="col-xl-3 col-md-6">
									<div class="card prod-p-card bg-c-blue">
										<div class="card-body">
											<div class="row align-items-center m-b-25">
												<div class="col">
													<h6 class="m-b-5 text-white">Regular ID Card Issued</h6>
													<?php 
													$sql41 = "SELECT * 
                                                            FROM student_details 
                                                            WHERE s_status='1' AND s_stu_verified='VERIFIED' AND s_course_type='REGULAR' AND s_reportedStatus='REPORTED' AND s_idcardStatus='ISSUED' AND DATE(s_idcardDate) = '$currentDate'
                                                            ORDER BY s_idcardDate DESC";
                                                    $result41 = mysqli_query($conn, $sql41);
                                                    $idCardIssuedTodayCount=mysqli_num_rows($result41);
													?>
													<h6 class="m-b-0 text-white"><?php echo $currentFormatDate; ?>, Count - <?php echo $idCardIssuedTodayCount; ?></h6>
													<?php 
													$sql4 = "SELECT * 
                                                            FROM student_details 
                                                            WHERE s_status='1' AND s_idcardStatus='ISSUED' AND s_course_type='REGULAR' AND s_stu_verified='VERIFIED' AND s_reportedStatus='REPORTED'
                                                            ORDER BY s_idcardDate DESC";
                                                    $result4 = mysqli_query($conn, $sql4);
                                                    $idCardIssuedTotalCount=mysqli_num_rows($result4);
													?>
													<h6 class="m-b-0 text-white">Total Count - <?php echo $idCardIssuedTotalCount; ?></h6>
												</div>
												<div class="col-auto">
												    <i class="fa-solid fa-id-card text-c-blue f-18"></i>
												</div>
											</div>
											<!--<p class="m-b-0 text-white"><span class="label label-primary m-r-10">+12%</span>From Previous Month</p>-->
										</div>
									</div>
								</div>
								<?php } ?>
								<?php if(isset($prev['7'])=='Y'){ ?>
								<div class="col-xl-3 col-md-6">
									<div class="card prod-p-card bg-c-yellow">
										<div class="card-body">
											<div class="row align-items-center m-b-25">
												<div class="col">
													<h6 class="m-b-5 text-white">Regular T-Shirt Issued</h6>
													<?php 
													$sql5 = "SELECT * 
                                                            FROM student_details 
                                                            WHERE s_status='1' AND s_tshirtStatus='ISSUED' AND s_course_type='REGULAR' AND s_stu_verified='VERIFIED' AND s_reportedStatus='REPORTED'
                                                            ORDER BY s_idcardDate DESC";
                                                    $result5 = mysqli_query($conn, $sql5);
                                                    $tshirtIssuedCount=mysqli_num_rows($result5);
													?>
													<h3 class="m-b-0 text-white"><?php echo $tshirtIssuedCount; ?></h3>
												</div>
												<div class="col-auto">
													<i class="fa-solid fa-shirt text-c-blue f-18"></i>
												</div>
											</div>
											<!--<p class="m-b-0 text-white"><span class="label label-warning m-r-10">+52%</span>From Previous Month</p>-->
										</div>
									</div>
								</div>
								<?php }?>
								<?php if(isset($prev['6'])=='Y'){ ?>
								<div class="col-xl-3 col-md-6">
									<div class="card prod-p-card bg-c-green">
										<div class="card-body">
											<div class="row align-items-center m-b-25">
												<div class="col">
													<h6 class="m-b-5 text-white">Regular Bag Issued</h6>
													<?php 
													$sql6 = "SELECT * 
                                                            FROM student_details 
                                                            WHERE s_status='1' AND s_bagStatus='ISSUED' AND s_course_type='REGULAR' AND s_stu_verified='VERIFIED' AND s_reportedStatus='REPORTED'
                                                            ORDER BY s_idcardDate DESC";
                                                    $result6 = mysqli_query($conn, $sql6);
                                                    $bagIssuedCount=mysqli_num_rows($result6);
													?>
													<h3 class="m-b-0 text-white"><?php echo $bagIssuedCount; ?></h3>
												</div>
												<div class="col-auto">
													<i class="fa-solid fa-suitcase-rolling text-c-blue f-18"></i> 
												</div>
											</div>
											<!--<p class="m-b-0 text-white"><span class="label label-success m-r-10">+52%</span>From Previous Month</p>-->
										</div>
									</div>
								</div>
								<?php } ?>
									<?php if(isset($prev['94'])=='Y'){ ?>
								<div class="col-xl-3 col-md-6">
									<div class="card prod-p-card bg-c-teal">
										<div class="card-body">
											<div class="row align-items-center m-b-25">
												<div class="col">
													<h6 class="m-b-5 text-white">Regular Hostel Students Count</h6>
													<?php 
													$cond7 = "s_status='1' AND s_reportedStatus='REPORTED' AND s_course_type='REGULAR' AND s_hosStatus='REPORTED'";
                                                        
                                                    if ($userType == 'Super Admin' || $headName == 'Others') {

                                                        // Show all records
                                                    }else if ($userType == 'Admin' || $headName == 'Others') {

                                                        // Show all records
                                                    } elseif (!empty($headName)) {
                                                    
                                                        $cond7 .= " AND s_admissionOwner='$headName'";
                                                    
                                                    } else {
                                                    
                                                        $cond7 .= " AND s_admissionOwner='$userName'";
                                                    }
													$sql7 = "SELECT * 
                                                            FROM student_details 
                                                            WHERE $cond7";
                                                    $result7 = mysqli_query($conn, $sql7);
                                                    $hostelCount=mysqli_num_rows($result7);
													?>
													<h3 class="m-b-0 text-white"><?php echo $hostelCount; ?></h3>
												</div>
												<div class="col-auto">
													<i class="fa-solid fa-hotel text-c-blue f-18"></i> 
												</div>
											</div>
											<!--<p class="m-b-0 text-white"><span class="label label-success m-r-10">+52%</span>From Previous Month</p>-->
										</div>
									</div>
								</div>
								<?php } ?>
									<?php if(isset($prev['95'])=='Y'){ ?>
								<div class="col-xl-3 col-md-6">
									<div class="card prod-p-card bg-c-pink">
										<div class="card-body">
											<div class="row align-items-center m-b-25">
												<div class="col">
													<h6 class="m-b-5 text-white">Regular Hostel Checked-In</h6>
													<?php 
													$cond8 = "s_status='1' AND s_reportedStatus='REPORTED' AND s_course_type='REGULAR' AND s_hosStatus='REPORTED' AND s_hos_checkIn_status='Check-In'";
                                                        
                                                    if ($userType == 'Super Admin' || $headName == 'Others') {

                                                        // Show all records
                                                    }else if ($userType == 'Admin' || $headName == 'Others') {

                                                        // Show all records
                                                    } elseif (!empty($headName)) {
                                                    
                                                        $cond8 .= " AND s_admissionOwner='$headName'";
                                                    
                                                    } else {
                                                    
                                                        $cond8 .= " AND s_admissionOwner='$userName'";
                                                    }
													$sql8 = "SELECT * 
                                                            FROM student_details 
                                                            WHERE $cond8";
                                                    $result8 = mysqli_query($conn, $sql8);
                                                    $hostelCheckInCount=mysqli_num_rows($result8);
													?>
													<h3 class="m-b-0 text-white"><?php echo $hostelCheckInCount; ?></h3>
												</div>
												<div class="col-auto">
													<i class="fa-solid fa-hotel text-c-blue f-18"></i> 
												</div>
											</div>
											<!--<p class="m-b-0 text-white"><span class="label label-success m-r-10">+52%</span>From Previous Month</p>-->
										</div>
									</div>
								</div>
								<?php } ?>
								<?php if(isset($prev['2'])=='Y'){ ?>
								<!-- product profit start -->
								<div class="col-xl-3 col-md-6">
									<div class="card prod-p-card bg-c-red">
										<div class="card-body">
											<div class="row align-items-center m-b-25">
												<div class="col">
													<h6 class="m-b-5 text-white">Total WP Students</h6>
													<?php 
													$cond1 = "s_status='1' AND s_course_type='WORKING PROFESSIONAL'";
                                                        
                                                    if ($userType == 'Super Admin' || $headName == 'Others') {

                                                        // Show all records
                                                    }else if ($userType == 'Admin' || $headName == 'Others') {

                                                        // Show all records
                                                    } elseif (!empty($headName)) {
                                                    
                                                        $cond1 .= " AND s_admissionOwner='$headName'";
                                                    
                                                    } else {
                                                    
                                                        $cond1 .= " AND s_admissionOwner='$userName'";
                                                    }
													$sql1 = "SELECT * 
                                                        FROM student_details 
                                                        WHERE $cond1
                                                        ORDER BY s_idcardDate DESC";
                                                    $result1 = mysqli_query($conn, $sql1);
                                                    $studentCount=mysqli_num_rows($result1);
													?>
													<h3 class="m-b-0 text-white"><?php echo $studentCount; ?></h3>
												</div>
												<div class="col-auto">
													<i class="fa-solid fa-users text-c-blue f-18"></i>
												</div>
											</div>
											<!--<p class="m-b-0 text-white"><span class="label label-danger m-r-10">+11%</span>From Previous Month</p>-->
										</div>
									</div>
								</div>
								<?php } ?>
								<?php if(isset($prev['3'])=='Y'){ ?>
								<!-- product profit start -->
								<div class="col-xl-3 col-md-6">
									<div class="card prod-p-card bg-c-purple">
										<div class="card-body">
											<div class="row align-items-center m-b-25">
												<div class="col">
													<h6 class="m-b-5 text-white">Reported WP Students</h6>
													
													<?php 
													    $cond8 = "s_status='1' AND s_course_type='WORKING PROFESSIONAL'
                                                              AND s_reportedStatus='REPORTED'
                                                              AND DATE(s_reportedcDate) = '$currentDate'";
                                                        if ($userType == 'Super Admin' || $headName == 'Others') {
                                                            // Show all records
                                                        } elseif ($userType == 'Admin' || $headName == 'Others') {
                                                            // Show all records
                                                        } elseif (!empty($headName)) {
                                                            $cond8 .= " AND s_admissionOwner='$headName'";
                                                        } else {
                                                            $cond8 .= " AND s_admissionOwner='$userName'";
                                                        }
                                                        
                                                        $sql8 = "SELECT COUNT(*) AS total
                                                                 FROM student_details
                                                                 WHERE $cond8";
                                                                 //echo $sql8;exit;
                                                        $result8 = mysqli_query($conn, $sql8);
                                                        $row8 = mysqli_fetch_assoc($result8);
                                                        $studentTodayCount8 = $row8['total'];
                                                    ?>
                                                    <h6 class="m-b-0 text-white"><?php echo $currentFormatDate; ?>, Count - <?php echo $studentTodayCount8; ?></h6>
                                                    <?php 
													$cond2 = "s_status='1' AND s_reportedStatus='REPORTED' AND s_course_type='WORKING PROFESSIONAL'";
                                                        
                                                    if ($userType == 'Super Admin' || $headName == 'Others') {

                                                        // Show all records
                                                    }else if ($userType == 'Admin' || $headName == 'Others') {

                                                        // Show all records
                                                    } elseif (!empty($headName)) {
                                                    
                                                        $cond2 .= " AND s_admissionOwner='$headName'";
                                                    
                                                    } else {
                                                    
                                                        $cond2 .= " AND s_admissionOwner='$userName'";
                                                    }
													$sql2 = "SELECT * 
                                                        FROM student_details 
                                                        WHERE $cond2 ";
                                                    $result2 = mysqli_query($conn, $sql2);
                                                    $studentCount2=mysqli_num_rows($result2);
													?>
													<h6 class="m-b-0 text-white">Total Count- <?php echo $studentCount2; ?></h6>
												</div>
												<div class="col-auto">
													<i class="fa-solid fa-users text-c-blue f-18"></i>
												</div>
											</div>
											<!--<p class="m-b-0 text-white"><span class="label label-danger m-r-10">+11%</span>From Previous Month</p>-->
										</div>
									</div>
								</div>
								<?php } ?>
								<?php if(isset($prev['5'])=='Y'){ ?>
								<div class="col-xl-3 col-md-6">
									<div class="card prod-p-card bg-c-blue">
										<div class="card-body">
											<div class="row align-items-center m-b-25">
												<div class="col">
												    <h6 class="m-b-5 text-white">WP ID Card Verified</h6>
												    <?php 
													    $cond10 = "s_status='1' AND s_course_type='WORKING PROFESSIONAL'
                                                              AND s_stu_verified='VERIFIED' AND s_reportedStatus='REPORTED'
                                                              AND DATE(s_stu_verifiedDate) = '$currentDate'";
                                                        if ($userType == 'Super Admin' || $headName == 'Others') {
                                                            // Show all records
                                                        } elseif ($userType == 'Admin' || $headName == 'Others') {
                                                            // Show all records
                                                        } elseif (!empty($headName)) {
                                                            $cond10 .= " AND s_admissionOwner='$headName'";
                                                        } else {
                                                            $cond10 .= " AND s_admissionOwner='$userName'";
                                                        }
                                                        
                                                        $sql10 = "SELECT COUNT(*) AS total
                                                                 FROM student_details
                                                                 WHERE $cond10";
                                                                 //echo $sql8;exit;
                                                        $result10 = mysqli_query($conn, $sql10);
                                                        $row10 = mysqli_fetch_assoc($result10);
                                                        $studentTodayVerifiedCount10 = $row10['total'];
                                                    ?>
                                                    <h6 class="m-b-0 text-white"><?php echo $currentFormatDate; ?>, Count - <?php echo $studentTodayVerifiedCount10; ?></h6>
													
													<?php 
													$sql9 = "SELECT * 
                                                            FROM student_details 
                                                            WHERE s_status='1' AND s_stu_verified='VERIFIED' AND s_reportedStatus='REPORTED' AND s_course_type='WORKING PROFESSIONAL'
                                                            ORDER BY s_idcardDate DESC";
                                                    $result9 = mysqli_query($conn, $sql9);
                                                    $idCardVerifiedCount=mysqli_num_rows($result9);
													?>
													<h6 class="m-b-0 text-white">Total Count - <?php echo $idCardVerifiedCount; ?></h6>
												</div>
												<div class="col-auto">
												    <i class="fa-solid fa-id-card text-c-blue f-18"></i>
												</div>
											</div>
											<!--<p class="m-b-0 text-white"><span class="label label-primary m-r-10">+12%</span>From Previous Month</p>-->
										</div>
									</div>
								</div>
								<div class="col-xl-3 col-md-6">
									<div class="card prod-p-card bg-c-blue">
										<div class="card-body">
											<div class="row align-items-center m-b-25">
												<div class="col">
													<h6 class="m-b-5 text-white">WP ID Card Issued</h6>
													<?php 
													$sql41 = "SELECT * 
                                                            FROM student_details 
                                                            WHERE s_status='1' AND s_stu_verified='VERIFIED' AND s_course_type='WORKING PROFESSIONAL' AND s_reportedStatus='REPORTED' AND s_idcardStatus='ISSUED' AND DATE(s_idcardDate) = '$currentDate'
                                                            ORDER BY s_idcardDate DESC";
                                                    $result41 = mysqli_query($conn, $sql41);
                                                    $idCardIssuedTodayCount=mysqli_num_rows($result41);
													?>
													<h6 class="m-b-0 text-white"><?php echo $currentFormatDate; ?>, Count - <?php echo $idCardIssuedTodayCount; ?></h6>
													<?php 
													$sql4 = "SELECT * 
                                                            FROM student_details 
                                                            WHERE s_status='1' AND s_idcardStatus='ISSUED' AND s_course_type='WORKING PROFESSIONAL' AND s_stu_verified='VERIFIED' AND s_reportedStatus='REPORTED'
                                                            ORDER BY s_idcardDate DESC";
                                                    $result4 = mysqli_query($conn, $sql4);
                                                    $idCardIssuedTotalCount=mysqli_num_rows($result4);
													?>
													<h6 class="m-b-0 text-white">Total Count - <?php echo $idCardIssuedTotalCount; ?></h6>
												</div>
												<div class="col-auto">
												    <i class="fa-solid fa-id-card text-c-blue f-18"></i>
												</div>
											</div>
											<!--<p class="m-b-0 text-white"><span class="label label-primary m-r-10">+12%</span>From Previous Month</p>-->
										</div>
									</div>
								</div>
								<?php } ?>
							</div>
							
							<?php if(isset($prev['8'])=='Y'){ ?>
				            <div class="row">
                                <div class="col-md-6">
                            
                                    <label class="form-label fw-semibold">
                                        Search Student Profile
                                    </label>
                            
                                    <div class="input-group position-relative">
                            
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-search"></i>
                                        </span>
                            
                                        <input type="text"
                                               id="applicationNumber"
                                               class="form-control"
                                               placeholder="Enter Application Number or Student Name"
                                               autocomplete="off">
                            
                                        <button type="button"
                                                id="btnSearch"
                                                class="btn btn-primary">
                                            <i class="fas fa-search me-1"></i>
                                            Search
                                        </button>
                            
                                        <div id="searchResult"
                                             class="list-group position-absolute w-100">
                                        </div>
                            
                                    </div>
                            
                                    <small class="text-muted">
                                        Example:
                                        AVITUGXXXX
                                    </small>
                            
                                </div>
                            </div>
                            <?php } ?>
							<!-- [ Main Content ] end -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- [ Main Content ] end -->

	
<script>
     
$("#applicationNumber").keyup(function(e){

    if(e.which==38 || e.which==40 || e.which==13){
        return;
    }

    let keyword = $(this).val();

    if(keyword!='')
    {
        $.ajax({

            url:'save.php?request=searchStudent',
            type:'POST',

            data:{
                keyword:keyword
            },

            success:function(data){

                $("#searchResult")
                    .html(data)
                    .show();

                currentIndex = -1;
            }
        });
    }
    else
    {
        $("#searchResult").hide();
    }
});
let currentIndex = -1;

$("#applicationNumber").keydown(function(e){

    let items =
        $("#searchResult .student-item");

    if(items.length==0)
        return;

    // DOWN
    if(e.which==40)
    {
        e.preventDefault();

        currentIndex++;

        if(currentIndex >= items.length)
            currentIndex = 0;

        items.removeClass('active');

        $(items[currentIndex])
            .addClass('active');
    }

    // UP
    if(e.which==38)
    {
        e.preventDefault();

        currentIndex--;

        if(currentIndex < 0)
            currentIndex =
                items.length-1;

        items.removeClass('active');

        $(items[currentIndex])
            .addClass('active');
    }

    // ENTER
    if(e.which==13)
    {
        e.preventDefault();

        if(currentIndex>=0)
        {
            $(items[currentIndex]).click();
        }
    }

});

$(document).on('click',
    '.student-item',
    function(){
        let appno =$(this).data('appno');

        $("#applicationNumber")
            .val(appno);

        $("#searchResult")
            .hide();

        window.location =
            'studentProfile.php?appno='
            + appno;

    }
);
</script>

