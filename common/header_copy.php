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
	<meta name="description" content="Flash Able Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
	<meta name="keywords"
		content="admin templates, bootstrap admin templates, bootstrap 4, dashboard, dashboard templets, sass admin templets, html admin templates, responsive, bootstrap admin templates free download,premium bootstrap admin templates, Flash Able, Flash Able bootstrap admin template">
	<meta name="author" content="Codedthemes" />

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
					<!--<li class="nav-item pcoded-menu-caption">-->
					<!--	<label>Navigation</label>-->
					<!--</li>-->
					<?php if(isset($prev['1'])=='Y'){ ?>
					<li class="nav-item">
						<a href="index.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
					</li>
					<?php } ?>
					<?php if(isset($prev['6'])=='Y'){ ?>
					<li class="nav-item pcoded-hasmenu">
						<a href="#!" class="nav-link">
						    <span class="pcoded-micon">
						        <i class="feather icon-box"></i>
						    </span>
						    <span class="pcoded-mtext">Masters</span>
						</a>
						<ul class="pcoded-submenu">
						    <?php if(isset($prev['7'])=='Y'){ ?>
							<li class="">
							    <a href="./userTypeList.php?type=Add" class="">User Type</a>
							</li>
							<?php } ?>
							<?php if(isset($prev['13'])=='Y'){ ?>
							<li class="">
							    <a href="./usersList.php?type=Add" class="">Users</a>
							</li>
							<?php } ?>
						</ul>
					</li>
					<?php } ?>
					<?php if(isset($prev['18'])=='Y'){ ?>
					<li class="nav-item">
						<a href="./studentEntryList.php" class="nav-link">
						    <span class="pcoded-micon">
						        <i class="feather icon-file-text"></i>
						    </span>
						    <span class="pcoded-mtext">Student Entry</span></a>
					</li>
					<?php } ?>
					<?php if(isset($prev['23'])=='Y'){ ?>
					<li class="nav-item">
						<a href="idcardEligibleList.php" class="nav-link">
						    <span class="pcoded-micon">
						        <i class="fa-regular fa-id-card"></i>
						    </span>
						    <span class="pcoded-mtext">ID Card Issue</span></a>
					</li>
					<?php } ?>
					<?php if(isset($prev['26'])=='Y'){ ?>
					<li class="nav-item">
						<a href="tshirtEligibleList.php" class="nav-link">
						    <span class="pcoded-micon">
						        <i class="fa-solid fa-shirt"></i>
						    </span>
						    <span class="pcoded-mtext">T-Shirt Issue</span></a>
					</li>
					<?php } ?>
					<?php if(isset($prev['29'])=='Y'){ ?>
					<li class="nav-item">
						<a href="bagEligibleList.php" class="nav-link">
						    <span class="pcoded-micon">
						        <i class="fas fa-school"></i>
						    </span>
						    <span class="pcoded-mtext">Bag Issue</span></a>
					</li>
					<?php } ?>
					<?php if(isset($prev['33'])=='Y'){ ?>
					<li class="nav-item pcoded-hasmenu">
						<a href="#!" class="nav-link">
						    <span class="pcoded-micon">
						        <i class="fa-solid fa-file-pdf"></i>
						    </span>
						    <span class="pcoded-mtext">Reports</span>
						</a>
						<ul class="pcoded-submenu">
						    <?php if(isset($prev['34'])=='Y'){ ?>
							<li class="">
							    <a href="./idCardIssuedReportList.php" class="">ID Card Issued</a>
							</li>
							<?php } ?>
							<?php if(isset($prev['36'])=='Y'){ ?>
							<li class="">
							    <a href="./bagIssuedReportList.php" class="">Bag Issued</a>
							</li>
							<?php } ?>
							<?php if(isset($prev['38'])=='Y'){ ?>
							<li class="">
							    <a href="./tshirtIssuedReportList.php" class="">T-shirt Issued</a>
							</li>
							<?php } ?>
							<?php if(isset($prev['40'])=='Y'){ ?>
							<li class="">
							    <a href="./studentOverAllReportList.php" class="">Students Over all Report</a>
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
			<a href="index.php" class="b-brand">
				<img src="../assets/logo/vmcc-avit-white-logo.png" alt="" class="logo images">
				<img src="../assets/logo/vmcc-avit-white-logo.png" alt="" class="logo-thumb images">
			</a>
		</div>
		<a class="mobile-menu" id="mobile-header" href="#!">
			<i class="feather icon-more-horizontal"></i>
		</a>
		<div class="collapse navbar-collapse">
			<a href="#!" class="mob-toggler"></a>
			<!--<ul class="navbar-nav mr-auto">-->
			<!--	<li class="nav-item">-->
			<!--		<div class="main-search open">-->
			<!--			<div class="input-group">-->
			<!--				<input type="text" id="m-search" class="form-control" placeholder="Search . . .">-->
			<!--				<a href="#!" class="input-group-append search-close">-->
			<!--					<i class="feather icon-x input-group-text"></i>-->
			<!--				</a>-->
			<!--				<span class="input-group-append search-btn btn btn-primary">-->
			<!--					<i class="feather icon-search input-group-text"></i>-->
			<!--				</span>-->
			<!--			</div>-->
			<!--		</div>-->
			<!--	</li>-->
			<!--</ul>-->
			<ul class="navbar-nav ml-auto">
				 
				<li>
					<div class="dropdown drp-user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon feather icon-settings"></i>
						</a>
						<div class="dropdown-menu dropdown-menu-right profile-notification">
							<div class="pro-head">
								<!--<img src="../assets/images/user/avatar-1.jpg" class="img-radius" alt="User-Profile-Image">-->
								<span><?php echo $_SESSION['USER_NAME']; ?></span>
								<a href="logout.php" class="dud-logout" title="Logout">
									<i class="feather icon-log-out"></i>
								</a>
							</div>
							<ul class="pro-body">
								<!--<li><a href="#!" class="dropdown-item"><i class="feather icon-settings"></i> Settings</a></li>-->
								<!--<li><a href="#!" class="dropdown-item"><i class="feather icon-user"></i> Profile</a></li>-->
								<!--<li><a href="message.html" class="dropdown-item"><i class="feather icon-mail"></i> My Messages</a></li>-->
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
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
</body>

</html>