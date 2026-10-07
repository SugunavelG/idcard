<?php 
session_start();
include './config.php';
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
?>
<!DOCTYPE html>
<html lang="en">

<head>

	<title>AVIT ID Card Management System</title>
	<!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 11]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="AVIT ID Card Management System" />
	<meta name="keywords"
		content="AVIT ID Card Management System">
	<meta name="author" content="AVIT ID Card Management System" />

	<!-- Favicon icon -->
	<link rel="icon" href="../assets/logo/favicon.png" type="image/x-icon">
	<!-- fontawesome icon -->
	<link rel="stylesheet" href="../assets/fonts/fontawesome/css/fontawesome-all.min.css">
	<!-- animation css -->
	<link rel="stylesheet" href="../assets/plugins/animation/css/animate.min.css">

	<!-- vendor css -->
	<link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="">
	<!-- [ Pre-loader ] start -->
	<div class="loader-bg">
		<div class="loader-track">
			<div class="loader-fill"></div>
		</div>
	</div>
	<!-- [ Pre-loader ] End -->

	<!-- [ navigation menu ] start -->
	<nav class="pcoded-navbar menupos-fixed menu-light brand-blue ">
		<div class="navbar-wrapper ">
			<div class="navbar-brand header-logo">
				<a href="index.html" class="b-brand">
					<img src="../assets/logo/vmcc-avit-white-logo.png" alt="" class="logo images" width="200">
					<img src="../assets/logo/vmcc-avit-white-logo.png" alt="" class="logo-thumb images" width="200">
				</a>
				<a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
			</div>
			<div class="navbar-content scroll-div">
				<ul class="nav pcoded-inner-navbar">
					 
					<?php if(isset($prev['1'])=='Y'){ ?>
					<li class="nav-item">
						<a href="index.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
					</li>
					<?php } ?>
						<?php if(isset($prev['9'])=='Y'){ ?>
					<li class="nav-item pcoded-hasmenu">
						<a href="#!" class="nav-link">
						    <span class="pcoded-micon">
						        <i class="feather icon-box"></i>
						    </span>
						    <span class="pcoded-mtext">Masters</span>
						</a>
						<ul class="pcoded-submenu">
						    <?php if(isset($prev['10'])=='Y'){ ?>
							<li class="">
							    <a href="./userTypeList.php?type=Add" class="">User Type</a>
							</li>
							<?php } ?>
							<?php if(isset($prev['16'])=='Y'){ ?>
							<li class="">
							    <a href="./usersList.php?type=Add" class="">Users</a>
							</li>
							<?php } ?>
						    <?php if(isset($prev['21'])=='Y'){ ?>
							<li class="">
							    <a href="./bloodGroupList.php?type=Add" class="">Blood Group</a>
							</li>
							<?php } ?>
							<?php if(isset($prev['26'])=='Y'){ ?>
							<li class="">
							    <a href="./departmentList.php?type=Add" class="">Department</a>
							</li>
							<?php } ?>
						    <?php if(isset($prev['31'])=='Y'){ ?>
							<li class="">
							    <a href="./stateList.php?type=Add" class="">State</a>
							</li>
							<?php } ?>
							 <?php if(isset($prev['36'])=='Y'){ ?>
							<li class="">
							    <a href="./hostelList.php?type=Add" class="">Hostel</a>
							</li>
							<?php } ?>
							<?php if(isset($prev['41'])=='Y'){ ?>
							<li class="">
							    <a href="./roomCategoryList.php?type=Add" class="">Room Category</a>
							</li>
							<?php } ?>
						</ul>
					</li>
					<?php } ?>
					<?php if(isset($prev['46'])=='Y'){ ?>
					<li class="nav-item">
						<a href="./studentReportList.php" class="nav-link">
    					    <span class="pcoded-micon">
    					        <i class="fa-solid fa-bell-concierge"></i>
    					    </span>
    					    <span class="pcoded-mtext">Student Registration</span>
    					</a>
					</li>
					<?php } ?>
					<?php if(isset($prev['49'])=='Y'){ ?>
					<li class="nav-item">
						<a href="./studentEntryList.php" class="nav-link">
    					    <span class="pcoded-micon">
    					        <i class="fa-solid fa-users"></i>
    					    </span>
    					    <span class="pcoded-mtext">Student ID Card Verification</span>
    					</a>
					</li>
					<?php } ?>
					<?php if(isset($prev['56'])=='Y'){ ?>
					<li class="nav-item">
						<a href="./uploadStudentProfileList.php" class="nav-link">
    					    <span class="pcoded-micon">
    					        <i class="fas fa-cloud-upload-alt"></i>
    					    </span>
    					    <span class="pcoded-mtext">Upload ID Card Profile</span>
    					</a>
					</li>
					<?php } ?>
					<?php if(isset($prev['61'])=='Y'){ ?>
					<li class="nav-item">
						<a href="./studentHostelEntryList.php" class="nav-link">
    					    <span class="pcoded-micon">
    					        <i class="fa-solid fa-hotel"></i>
    					    </span>
    					    <span class="pcoded-mtext">Hostel Registration</span>
    					</a>
					</li>
					<?php } ?>
					<?php if(isset($prev['98'])=='Y'){ ?>
					<li class="nav-item">
						<a href="./admissionOwnerWiseDetails.php" class="nav-link">
    					    <span class="pcoded-micon">
    					        <i class="fa-solid fa-hotel"></i>
    					    </span>
    					    <span class="pcoded-mtext">Admission Owners Wise</span>
    					</a>
					</li>
					<?php } ?>
					<?php if(isset($prev['91'])=='Y'){ ?>
					<li class="nav-item">
						<a href="./studentCounsellorList.php" class="nav-link">
    					    <span class="pcoded-micon">
    					        <i class="fas fa-address-card"></i>
    					    </span>
    					    <span class="pcoded-mtext">Student Counsellor</span>
    					</a>
					</li>
					<?php } ?>
					<?php if(isset($prev['65'])=='Y'){ ?>
					<li class="nav-item">
						<a href="./studentAdmitCardList.php" class="nav-link">
    					    <span class="pcoded-micon">
    					        <i class="fas fa-address-card"></i>
    					    </span>
    					    <span class="pcoded-mtext">Admit Card</span>
    					</a>
					</li>
					<?php } ?>
					<?php if(isset($prev['70'])=='Y'){ ?>
					<li class="nav-item">
						<a href="./studentProgrameList.php" class="nav-link">
    					    <span class="pcoded-micon">
    					        <i class="fas fa-book-open"></i>
    					    </span>
    					    <span class="pcoded-mtext">Programme Migration</span>
    					</a>
					</li>
					<?php } ?>
					<?php if(isset($prev['71'])=='Y'){ ?>
					<li class="nav-item">
						<a href="idcardEligibleList.php" class="nav-link">
						    <span class="pcoded-micon">
						        <i class="fas fa-id-card"></i>
						    </span>
						    <span class="pcoded-mtext">ID Card Issue</span></a>
					</li>
					<?php } ?>
					<?php if(isset($prev['74'])=='Y'){ ?>
					<li class="nav-item">
						<a href="welcomeKitList.php" class="nav-link">
						    <span class="pcoded-micon">
						       <i class="fas fa-briefcase"></i>
						    </span>
						    <span class="pcoded-mtext">Welcome Kit</span></a>
					</li>
					<li class="nav-item">
						<a href="tshirtEligibleList.php" class="nav-link">
						    <span class="pcoded-micon">
						        <i class="fa-solid fa-shirt"></i>
						    </span>
						    <span class="pcoded-mtext">T-Shirt Issue</span></a>
					</li>
					<?php } ?>
					<!--<?php if(isset($prev['26'])=='Y'){ ?>-->
					<!--<li class="nav-item">-->
					<!--	<a href="tshirtEligibleList.php" class="nav-link">-->
					<!--	    <span class="pcoded-micon">-->
					<!--	        <i class="fa-solid fa-shirt"></i>-->
					<!--	    </span>-->
					<!--	    <span class="pcoded-mtext">T-Shirt Issue</span></a>-->
					<!--</li>-->
					<!--<?php } ?>-->
					
					<!--<?php if(isset($prev['29'])=='Y'){ ?>-->
					<!--<li class="nav-item">-->
					<!--	<a href="bagEligibleList.php" class="nav-link">-->
					<!--	    <span class="pcoded-micon">-->
					<!--	       <i class="fas fa-briefcase"></i>-->
					<!--	    </span>-->
					<!--	    <span class="pcoded-mtext">Bag Issue</span></a>-->
					<!--</li>-->
					<!--<?php } ?>-->
					<?php if(isset($prev['77'])=='Y'){ ?>
					<li class="nav-item pcoded-hasmenu">
						<a href="#!" class="nav-link">
						    <span class="pcoded-micon">
						        <i class="fa-solid fa-file-pdf"></i>
						    </span>
						    <span class="pcoded-mtext">Issued Reports</span>
						</a>
						<ul class="pcoded-submenu">
						    <?php if(isset($prev['89'])=='Y'){ ?>
						    <li class="">
							    <a href="./regularStudentAllReport.php" class="">Regular Student Data Collection Report</a>
							</li>
							<li class="">
							    <a href="./regularUGStudentAllReport.php" class="">Regular UG Student Reported Collection Report</a>
							</li>
        					<li class="nav-item">
        						<a href="./studentAdmitCardReportList.php" class="nav-link">
            					    <span class="pcoded-mtext">Admit Card Issued Report</span>
            					</a>
        					</li>
        					<li class="nav-item">
        						<a href="./section_A.php" class="nav-link">
            					    <span class="pcoded-mtext">Section A</span>
            					</a>
        					</li>
        					<li class="nav-item">
        						<a href="./section_B.php" class="nav-link">
            					    <span class="pcoded-mtext">Section B</span>
            					</a>
        					</li>
        					<li class="nav-item">
        						<a href="./section_C.php" class="nav-link">
            					    <span class="pcoded-mtext">Section C</span>
            					</a>
        					</li>
        					<li class="nav-item">
        						<a href="./section_D.php" class="nav-link">
            					    <span class="pcoded-mtext">Section D</span>
            					</a>
        					</li>
        					<li class="nav-item">
        						<a href="./section_E.php" class="nav-link">
            					    <span class="pcoded-mtext">Section E</span>
            					</a>
        					</li>
        					<li class="nav-item">
        						<a href="./section_F.php" class="nav-link">
            					    <span class="pcoded-mtext">Section F</span>
            					</a>
        					</li>
        					<li class="nav-item">
        						<a href="./section_G.php" class="nav-link">
            					    <span class="pcoded-mtext">Section G</span>
            					</a>
        					</li>
        					<li class="nav-item">
        						<a href="./section_H.php" class="nav-link">
            					    <span class="pcoded-mtext">Section H</span>
            					</a>
        					</li>
        					<li class="nav-item">
        						<a href="./section_I.php" class="nav-link">
            					    <span class="pcoded-mtext">Section I</span>
            					</a>
        					</li>
        					<li class="nav-item">
        						<a href="./section_J.php" class="nav-link">
            					    <span class="pcoded-mtext">Section J</span>
            					</a>
        					</li>
            				<?php } ?>
						    <?php if(isset($prev['78'])=='Y'){ ?>
						    <li class="">
							    <a href="./studentRegistredReport.php" class="">Student Registered Report</a>
							</li>
							<li class="">
							    <a href="./idCardVerifiedReportList.php" class="">ID Card Verified Report</a>
							</li>
							<li class="">
							    <a href="./idCardIssuedReportList.php" class="">ID Card Issued Report</a>
							</li>
							<?php } ?>
							<?php if(isset($prev['82'])=='Y'){ ?>
							<li class="">
							    <a href="./tshirtIssuedReportList.php" class="">T-shirt Issued Report</a>
							</li>
							<li class="">
							    <a href="./tshirtPendingList.php" class="">T-shirt NOT Issued Report (ID CARD ISSUED)</a>
							</li>
							<li class="">
							    <a href="./tshirtPendingListIDCardVerified.php" class="">T-shirt NOT Issued Report (ID CARD VERIFIED)</a>
							</li>
							<?php } ?>
							<?php if(isset($prev['80'])=='Y'){ ?>
							<li class="">
							    <a href="./bagIssuedReportList.php" class="">Bag Issued Report</a>
							</li>
							<?php } ?>
							<?php if(isset($prev['84'])=='Y'){ ?>
							<li class="">
							    <a href="./hostelReportedList.php" class="">Hostel Reported Report</a>
							</li>
							<?php } ?>
							<?php if(isset($prev['96'])=='Y'){ ?>
							<li class="">
							    <a href="./hostelCheckedInReportList.php" class="">Hostel Checked In Report</a>
							</li>
							<?php } ?>
							<?php if(isset($prev['86'])=='Y'){ ?>
							<li class="">
							    <a href="./studentOverAllReportList.php" class="">Students Over all Report</a>
							</li>
							<li class="">
							    <a href="./departmentSummaryReport.php" class="">Regular Department Summary Report</a>
							</li>
							<li class="">
							    <a href="./industryPartnerSummaryReport.php" class="">Regular Industry Partner Summary Report</a>
							</li>
							<li class="">
							    <a href="./admissionHeadSummaryReport.php" class="">Regular Head Wise Summary Report</a>
							</li>
							<?php } ?>
							<?php if(isset($prev['78'])=='Y'){ ?>
							<li class="">
							    <a href="./studentWpAllReport.php" class="">WP Student Data Collection Report</a>
							</li>
							<li class="">
							    <a href="./wpStudents.php" class="">WP Student </a>
							</li>
						    <li class="">
							    <a href="./wpstudentRegistredReport.php" class="">WP Student Registered Report</a>
							</li>
							 <li class="">
							    <a href="./wpstudentRegistredButNotVerifiedReport.php" class="">WP Student Registered NOT Verified</a>
							</li>
							<li class="">
							    <a href="./wpidCardVerifiedReportList.php" class="">WP ID Card Verified Report</a>
							</li>
							<li class="">
							    <a href="./wpidCardIssuedReportList.php" class="">WP ID Card Issued Report</a>
							</li>
							<li class="">
							    <a href="./wpdepartmentSummaryReport.php" class="">WP Department Summary Report</a>
							</li>
							<li class="">
							    <a href="./wpadmissionHeadSummaryReport.php" class="">WP Head Wise Summary Report</a>
							</li>
							<li class="">
							    <a href="./studentEntry.php" class="">Student Entry</a>
							</li>
							<?php } ?>
						</ul>
					</li>
					<?php } ?>  
				 
				</ul>
			 
			</div>
		</div>
	</nav>
	<!-- [ navigation menu ] end -->

	<!-- [ Header ] start -->
	<header class="navbar pcoded-header navbar-expand-lg navbar-light headerpos-fixed">
		<div class="m-header">
			<a class="mobile-menu" id="mobile-collapse1" href="#!"><span></span></a>
			<a href="index.html" class="b-brand">
				<img src="../assets/logo/vmcc-avit-white-logo.png" alt="" class="logo images" width="200">
				<img src="../assets/logo/vmcc-avit-white-logo.png" alt="" class="logo-thumb images" width="200">
			</a>
		</div>
		<a class="mobile-menu" id="mobile-header" href="#!">
			<i class="feather icon-more-horizontal"></i>
		</a>
		<div class="collapse navbar-collapse">
			<a href="#!" class="mob-toggler"></a>
			<h3 class="p-1 text-center ml-2" style="color: #002147;">AVIT Admission Management System</h3>
			<ul class="navbar-nav ml-auto">
				<li>
					<div class="dropdown drp-user">
					    
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon feather icon-settings"></i> 
						</a>&nbsp;&nbsp;<?php echo $_SESSION['USER_NAME']; ?>
						<div class="dropdown-menu dropdown-menu-right profile-notification">
							<div class="pro-head">
								<img src="../assets/images/user/profile.jpg" class="img-radius" alt="User-Profile-Image">
								<span><?php echo $_SESSION['USER_NAME']; ?></span>
								<a href="logout.php" class="dud-logout" title="Logout">
									<i class="feather icon-log-out"></i>
								</a>
							</div>
							<ul class="pro-body">
								<li><a href="logout.php" class="dropdown-item"><i class="feather icon-lock"></i> Lock Screen</a></li>
							</ul>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</header>
	<!-- [ Header ] end -->

	<!-- Required Js -->
	<script src="../assets/js/vendor-all.min.js"></script>
	<script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="../assets/js/pcoded.min.js"></script>

</body>

</html>
