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
   $userTypeId=decryptId($_GET['id']);
   
   if(isset($userTypeId)){
        $sql="SELECT * FROM user_type WHERE ut_id='".$userTypeId."'";
        $result=mysqli_query($conn,$sql);
        $utype_Obj=mysqli_fetch_object($result);
        $utId = $utype_Obj->ut_id;
        $utName = $utype_Obj->ut_name;
        $prev = json_decode($utype_Obj->ut_prev,true);
        $utStatus = $utype_Obj->ut_status;
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
            .module-box{
                border:1px solid #dee2e6;
                border-radius:10px;
                overflow:hidden;
                background:#fff;
            }
            
            .module-header{
                padding:10px 15px;
                font-weight:600;
                display:flex;
                align-items:center;
            }
            
            .module-header input{
                margin-top:0;
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
                                            <div class="page-header-title">
                                                <h5 class="m-b-10">User Type : <strong style="color:blue;font-size:24px;font-weight:bold;"><i><?php echo $utName ?></i></strong></h5>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form id="permissionForm">
                                <input type="hidden" name="userType_id" id="userType_id" value="<?php echo $userTypeId; ?>">
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <div class="module-box">
                                            <div class="module-header bg-primary text-white">
                                                <input type="checkbox" id="access1" name="access[]" value="1" <?php if($prev['1']=='Y'){ echo 'checked'; } ?> class="me-2">
                                                Dashboard
                                            </div>
                                            <div class="p-3">
                                                <label class="btn btn-outline-primary btn-sm me-2 mb-2">
                                                    <input type="checkbox"  id="access2" name="access[]" value="2" <?php if($prev['2']=='Y'){ echo 'checked'; } ?>>
                                                    Total Students
                                                </label>
                                                <label class="btn btn-outline-primary btn-sm me-2 mb-2">
                                                    <input type="checkbox"  id="access3" name="access[]" value="3" <?php if($prev['3']=='Y'){ echo 'checked'; } ?>>
                                                    Reported Students
                                                </label>
                                                <label class="btn btn-outline-primary btn-sm me-2 mb-2">
                                                    <input type="checkbox"  id="access4" name="access[]" value="4" <?php if($prev['4']=='Y'){ echo 'checked'; } ?>>
                                                    Admit Card Issued
                                                </label>
                                                <label class="btn btn-outline-success btn-sm me-2 mb-2">
                                                    <input type="checkbox" id="access5" name="access[]" value="5" <?php if($prev['5']=='Y'){ echo 'checked'; } ?>>
                                                    ID Card Issued
                                                </label>
                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                    <input type="checkbox" type="checkbox" id="access6" name="access[]" value="6" <?php if($prev['6']=='Y'){ echo 'checked'; } ?>>
                                                    Bag Issued
                                                </label>
                                                <label class="btn btn-outline-danger btn-sm me-2 mb-2">
                                                    <input type="checkbox" type="checkbox" id="access7" name="access[]" value="7" <?php if($prev['7']=='Y'){ echo 'checked'; } ?>>
                                                    T-shirt Issued
                                                </label>
                                                <label class="btn btn-outline-danger btn-sm me-2 mb-2">
                                                    <input type="checkbox" type="checkbox" id="access94" name="access[]" value="94" <?php if($prev['94']=='Y'){ echo 'checked'; } ?>>
                                                    Hostel Students Count
                                                </label>
                                                <label class="btn btn-outline-danger btn-sm me-2 mb-2">
                                                    <input type="checkbox" type="checkbox" id="access95" name="access[]" value="95" <?php if($prev['95']=='Y'){ echo 'checked'; } ?>>
                                                    Hostel Checked-In Count
                                                </label>
                                                <label class="btn btn-outline-danger btn-sm me-2 mb-2">
                                                    <input type="checkbox" type="checkbox" id="access8" name="access[]" value="8" <?php if($prev['8']=='Y'){ echo 'checked'; } ?>>
                                                    Search Student
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-lg-12">
                                        <div class="card shadow-sm border-0">
                                            <div class="card-header bg-primary text-white">
                                                <input type="checkbox" class="form-check-input me-2" name="access[]" id="access9" value="9"  <?php if($prev['9']=='Y'){ echo 'checked'; } ?>>
                                                <strong>Masters</strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-6 mb-3">
                                                        <div class="module-box">
                                                            <div class="module-header bg-primary text-white">
                                                                <input type="checkbox" name="access[]" id="access10" value="10" class="me-2"  <?php if($prev['10']=='Y'){ echo 'checked'; } ?>>
                                                                User Type
                                                            </div>
                                                            <div class="p-3">
                                                                <label class="btn btn-outline-success btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access11" value="11"  <?php if($prev['11']=='Y'){ echo 'checked'; } ?>>
                                                                    Add
                                                                </label>
                                                                <label class="btn btn-outline-primary btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access12" value="12" <?php if($prev['12']=='Y'){ echo 'checked'; } ?>>
                                                                    Edit
                                                                </label>
                                                                
                                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access13" value="13" <?php if($prev['13']=='Y'){ echo 'checked'; } ?>>
                                                                    View
                                                                </label>
                                                                <label class="btn btn-outline-danger btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access14" value="14" <?php if($prev['14']=='Y'){ echo 'checked'; } ?>>
                                                                    Delete
                                                                </label>
                                                                <label class="btn btn-outline-dark btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access15" value="15" <?php if($prev['15']=='Y'){ echo 'checked'; } ?>>
                                                                    User Access
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-3">
                                                        <div class="module-box">
                                                            <div class="module-header bg-success text-white">
                                                                <input type="checkbox" name="access[]" id="access16" value="16" class="me-2" <?php if($prev['16']=='Y'){ echo 'checked'; } ?>>
                                                                Users
                                                            </div>
                                                            <div class="p-3">
                                                                 <label class="btn btn-outline-success btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access17" value="17" <?php if($prev['17']=='Y'){ echo 'checked'; } ?>>
                                                                    Add
                                                                </label>
                                                                <label class="btn btn-outline-primary btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access18" value="18" <?php if($prev['18']=='Y'){ echo 'checked'; } ?>>
                                                                    Edit
                                                                </label>
                                                                <label class="btn btn-outline-danger btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access19" value="19" <?php if($prev['19']=='Y'){ echo 'checked'; } ?>>
                                                                    Delete
                                                                </label>
                                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access20" value="20" <?php if($prev['20']=='Y'){ echo 'checked'; } ?>>
                                                                    View
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 mb-3">
                                                        <div class="module-box">
                                                            <div class="module-header bg-success text-white">
                                                                <input type="checkbox" name="access[]" id="access21" value="21" class="me-2" <?php if($prev['21']=='Y'){ echo 'checked'; } ?>>
                                                                Blood Group
                                                            </div>
                                                            <div class="p-3">
                                                                 <label class="btn btn-outline-success btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access22" value="22" <?php if($prev['22']=='Y'){ echo 'checked'; } ?>>
                                                                    Add
                                                                </label>
                                                                <label class="btn btn-outline-primary btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access23" value="23" <?php if($prev['23']=='Y'){ echo 'checked'; } ?>>
                                                                    Edit
                                                                </label>
                                                                <label class="btn btn-outline-danger btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access24" value="24" <?php if($prev['24']=='Y'){ echo 'checked'; } ?>>
                                                                    Delete
                                                                </label>
                                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access25" value="25" <?php if($prev['25']=='Y'){ echo 'checked'; } ?>>
                                                                    View
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 mb-3">
                                                        <div class="module-box">
                                                            <div class="module-header bg-success text-white">
                                                                <input type="checkbox" name="access[]" id="access26" value="26" class="me-2" <?php if($prev['26']=='Y'){ echo 'checked'; } ?>>
                                                                Department
                                                            </div>
                                                            <div class="p-3">
                                                                 <label class="btn btn-outline-success btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access27" value="27" <?php if($prev['27']=='Y'){ echo 'checked'; } ?>>
                                                                    Add
                                                                </label>
                                                                <label class="btn btn-outline-primary btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access28" value="28" <?php if($prev['28']=='Y'){ echo 'checked'; } ?>>
                                                                    Edit
                                                                </label>
                                                                <label class="btn btn-outline-danger btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access29" value="29" <?php if($prev['29']=='Y'){ echo 'checked'; } ?>>
                                                                    Delete
                                                                </label>
                                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access30" value="30" <?php if($prev['30']=='Y'){ echo 'checked'; } ?>>
                                                                    View
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 mb-3">
                                                        <div class="module-box">
                                                            <div class="module-header bg-success text-white">
                                                                <input type="checkbox" name="access[]" id="access31" value="31" class="me-2" <?php if($prev['31']=='Y'){ echo 'checked'; } ?>>
                                                                State
                                                            </div>
                                                            <div class="p-3">
                                                                 <label class="btn btn-outline-success btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access32" value="32" <?php if($prev['32']=='Y'){ echo 'checked'; } ?>>
                                                                    Add
                                                                </label>
                                                                <label class="btn btn-outline-primary btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access33" value="33" <?php if($prev['33']=='Y'){ echo 'checked'; } ?>>
                                                                    Edit
                                                                </label>
                                                                <label class="btn btn-outline-danger btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access34" value="34" <?php if($prev['34']=='Y'){ echo 'checked'; } ?>>
                                                                    Delete
                                                                </label>
                                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access35" value="35" <?php if($prev['35']=='Y'){ echo 'checked'; } ?>>
                                                                    View
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 mb-3">
                                                        <div class="module-box">
                                                            <div class="module-header bg-success text-white">
                                                                <input type="checkbox" name="access[]" id="access36" value="36" class="me-2" <?php if($prev['36']=='Y'){ echo 'checked'; } ?>>
                                                                Hostel
                                                            </div>
                                                            <div class="p-3">
                                                                 <label class="btn btn-outline-success btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access37" value="37" <?php if($prev['37']=='Y'){ echo 'checked'; } ?>>
                                                                    Add
                                                                </label>
                                                                <label class="btn btn-outline-primary btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access38" value="38" <?php if($prev['38']=='Y'){ echo 'checked'; } ?>>
                                                                    Edit
                                                                </label>
                                                                <label class="btn btn-outline-danger btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access39" value="39" <?php if($prev['39']=='Y'){ echo 'checked'; } ?>>
                                                                    Delete
                                                                </label>
                                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access40" value="40" <?php if($prev['40']=='Y'){ echo 'checked'; } ?>>
                                                                    View
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 mb-3">
                                                        <div class="module-box">
                                                            <div class="module-header bg-success text-white">
                                                                <input type="checkbox" name="access[]" id="access41" value="41" class="me-2" <?php if($prev['41']=='Y'){ echo 'checked'; } ?>>
                                                                Room Category
                                                            </div>
                                                            <div class="p-3">
                                                                 <label class="btn btn-outline-success btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access42" value="42" <?php if($prev['42']=='Y'){ echo 'checked'; } ?>>
                                                                    Add
                                                                </label>
                                                                <label class="btn btn-outline-primary btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access43" value="43" <?php if($prev['43']=='Y'){ echo 'checked'; } ?>>
                                                                    Edit
                                                                </label>
                                                                <label class="btn btn-outline-danger btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access44" value="44" <?php if($prev['44']=='Y'){ echo 'checked'; } ?>>
                                                                    Delete
                                                                </label>
                                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access45" value="45" <?php if($prev['45']=='Y'){ echo 'checked'; } ?>>
                                                                    View
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4 mb-3">
                                        <div class="module-box">
                                            <div class="module-header bg-primary text-white">
                                                <input type="checkbox" id="access46" name="access[]" value="46" <?php if($prev['46']=='Y'){ echo 'checked'; } ?> class="me-2">
                                                Student Report List
                                            </div>
                                            <div class="p-3">
                                                <label class="btn btn-outline-success btn-sm me-2 mb-2">
                                                    <input type="checkbox" id="access47" name="access[]" value="47" <?php if($prev['47']=='Y'){ echo 'checked'; } ?>>
                                                    Edit
                                                </label>
                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                    <input type="checkbox" type="checkbox" id="access48" name="access[]" value="48" <?php if($prev['48']=='Y'){ echo 'checked'; } ?>>
                                                   View
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <div class="module-box">
                                            <div class="module-header bg-primary text-white">
                                                <input type="checkbox" id="access18" name="access[]" value="49" <?php if($prev['49']=='Y'){ echo 'checked'; } ?> class="me-2">
                                                Student Entry
                                            </div>
                                            <div class="p-3">
                                                <label class="btn btn-outline-primary btn-sm me-2 mb-2">
                                                    <input type="checkbox"  id="access50" name="access[]" value="50" <?php if($prev['50']=='Y'){ echo 'checked'; } ?>>
                                                    Add
                                                </label>
                                                <label class="btn btn-outline-success btn-sm me-2 mb-2">
                                                    <input type="checkbox" id="access51" name="access[]" value="51" <?php if($prev['51']=='Y'){ echo 'checked'; } ?>>
                                                    Edit
                                                </label>
                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                    <input type="checkbox" type="checkbox" id="access52" name="access[]" value="52" <?php if($prev['52']=='Y'){ echo 'checked'; } ?>>
                                                   Call
                                                </label>
                                                <label class="btn btn-outline-danger btn-sm me-2 mb-2">
                                                    <input type="checkbox" type="checkbox" id="access53" name="access[]" value="53" <?php if($prev['53']=='Y'){ echo 'checked'; } ?>>
                                                    Delete
                                                </label>
                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                    <input type="checkbox" type="checkbox" id="access54" name="access[]" value="54" <?php if($prev['54']=='Y'){ echo 'checked'; } ?>>
                                                   View
                                                </label>
                                                <label class="btn btn-outline-danger btn-sm me-2 mb-2">
                                                    <input type="checkbox" type="checkbox" id="access55" name="access[]" value="55" <?php if($prev['55']=='Y'){ echo 'checked'; } ?>>
                                                    E-ID Card
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4 mb-3">
                                        <div class="module-box">
                                            <div class="module-header bg-primary text-white">
                                                <input type="checkbox" id="access56" name="access[]" value="56" <?php if($prev['56']=='Y'){ echo 'checked'; } ?> class="me-2">
                                                Upload Profile List
                                            </div>
                                            <div class="p-3">
                                                <label class="btn btn-outline-success btn-sm me-2 mb-2">
                                                    <input type="checkbox" id="access57" name="access[]" value="57" <?php if($prev['57']=='Y'){ echo 'checked'; } ?>>
                                                    Edit
                                                </label>
                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                    <input type="checkbox" type="checkbox" id="access58" name="access[]" value="58" <?php if($prev['58']=='Y'){ echo 'checked'; } ?>>
                                                   Call
                                                </label>
                                                <label class="btn btn-outline-danger btn-sm me-2 mb-2">
                                                    <input type="checkbox" type="checkbox" id="access59" name="access[]" value="59" <?php if($prev['59']=='Y'){ echo 'checked'; } ?>>
                                                    Delete
                                                </label>
                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                    <input type="checkbox" type="checkbox" id="access60" name="access[]" value="60" <?php if($prev['60']=='Y'){ echo 'checked'; } ?>>
                                                   View
                                                </label>
                                                <label class="btn btn-outline-danger btn-sm me-2 mb-2">
                                                    <input type="checkbox" type="checkbox" id="access61" name="access[]" value="61" <?php if($prev['61']=='Y'){ echo 'checked'; } ?>>
                                                    E-ID Card
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <div class="module-box">
                                            <div class="module-header bg-primary text-white">
                                                <input type="checkbox" id="access61" name="access[]" value="61" <?php if($prev['61']=='Y'){ echo 'checked'; } ?> class="me-2">
                                                Hostel Entry
                                            </div>
                                            <div class="p-3">
                                                <label class="btn btn-outline-success btn-sm me-2 mb-2">
                                                    <input type="checkbox" id="access62" name="access[]" value="62" <?php if($prev['62']=='Y'){ echo 'checked'; } ?>>
                                                    Edit
                                                </label>
                                                <label class="btn btn-outline-danger btn-sm me-2 mb-2">
                                                    <input type="checkbox" type="checkbox" id="access63" name="access[]" value="63" <?php if($prev['63']=='Y'){ echo 'checked'; } ?>>
                                                    Check-In
                                                </label>
                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                    <input type="checkbox" type="checkbox" id="access64" name="access[]" value="64" <?php if($prev['64']=='Y'){ echo 'checked'; } ?>>
                                                   View
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <div class="module-box">
                                            <div class="module-header bg-primary text-white">
                                                <input type="checkbox" id="access98" name="access[]" value="98" <?php if($prev['98']=='Y'){ echo 'checked'; } ?> class="me-2">
                                                Admission Owner Wise
                                            </div>
                                            <div class="p-3">
                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                    <input type="checkbox" type="checkbox" id="access99" name="access[]" value="99" <?php if($prev['99']=='Y'){ echo 'checked'; } ?>>
                                                   View
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <div class="module-box">
                                            <div class="module-header bg-primary text-white">
                                                <input type="checkbox" id="access67" name="access[]" value="65" <?php if($prev['65']=='Y'){ echo 'checked'; } ?> class="me-2">
                                                Admit Card
                                            </div>
                                            <div class="p-3">
                                                <label class="btn btn-outline-success btn-sm me-2 mb-2">
                                                    <input type="checkbox" id="access67" name="access[]" value="66" <?php if($prev['66']=='Y'){ echo 'checked'; } ?>>
                                                    Edit
                                                </label>
                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                    <input type="checkbox" type="checkbox" id="access67" name="access[]" value="67" <?php if($prev['67']=='Y'){ echo 'checked'; } ?>>
                                                   View
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <div class="module-box">
                                            <div class="module-header bg-primary text-white">
                                                <input type="checkbox" id="access70" name="access[]" value="68" <?php if($prev['68']=='Y'){ echo 'checked'; } ?> class="me-2">
                                                Programme Migration
                                            </div>
                                            <div class="p-3">
                                                <label class="btn btn-outline-success btn-sm me-2 mb-2">
                                                    <input type="checkbox" id="access70" name="access[]" value="69" <?php if($prev['69']=='Y'){ echo 'checked'; } ?>>
                                                    Edit
                                                </label>
                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                    <input type="checkbox" type="checkbox" id="access70" name="access[]" value="70" <?php if($prev['70']=='Y'){ echo 'checked'; } ?>>
                                                   View
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <div class="module-box">
                                            <div class="module-header bg-primary text-white">
                                                <input type="checkbox" id="access23" name="access[]" value="71" <?php if($prev['71']=='Y'){ echo 'checked'; } ?> class="me-2">
                                                ID Card Issue
                                            </div>
                                            <div class="p-3">
                                                <label class="btn btn-outline-success btn-sm me-2 mb-2">
                                                    <input type="checkbox" id="access72" name="access[]" value="72" <?php if($prev['72']=='Y'){ echo 'checked'; } ?>>
                                                    Edit
                                                </label>
                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                    <input type="checkbox" type="checkbox" id="access73" name="access[]" value="73" <?php if($prev['73']=='Y'){ echo 'checked'; } ?>>
                                                   View
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <div class="module-box">
                                            <div class="module-header bg-primary text-white">
                                                <input type="checkbox" id="access75" name="access[]" value="74" <?php if($prev['74']=='Y'){ echo 'checked'; } ?> class="me-2">
                                                Welcome Kit
                                            </div>
                                            <div class="p-3">
                                                <label class="btn btn-outline-success btn-sm me-2 mb-2">
                                                    <input type="checkbox" id="access75" name="access[]" value="75" <?php if($prev['75']=='Y'){ echo 'checked'; } ?>>
                                                    Edit
                                                </label>
                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                    <input type="checkbox" type="checkbox" id="access76" name="access[]" value="76" <?php if($prev['76']=='Y'){ echo 'checked'; } ?>>
                                                   View
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <div class="module-box">
                                            <div class="module-header bg-primary text-white">
                                                <input type="checkbox" id="access91" name="access[]" value="91" <?php if($prev['91']=='Y'){ echo 'checked'; } ?> class="me-2">
                                                Studnet Counsellor
                                            </div>
                                            <div class="p-3">
                                                <label class="btn btn-outline-success btn-sm me-2 mb-2">
                                                    <input type="checkbox" id="access92" name="access[]" value="92" <?php if($prev['92']=='Y'){ echo 'checked'; } ?>>
                                                    Call
                                                </label>
                                                <label class="btn btn-outline-success btn-sm me-2 mb-2">
                                                    <input type="checkbox" id="access93" name="access[]" value="93" <?php if($prev['93']=='Y'){ echo 'checked'; } ?>>
                                                    View
                                                </label>
                                               
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="card shadow-sm border-0">
                                            <div class="card-header bg-primary text-white">
                                                <input type="checkbox" class="form-check-input me-2" name="access[]" id="access77" value="77" <?php if($prev['77']=='Y'){ echo 'checked'; } ?>>
                                                <strong>Reports</strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    
                                                    <div class="col-lg-3 mb-3">
                                                        <div class="module-box">
                                                            <div class="module-header bg-primary text-white">
                                                                <input type="checkbox" id="access78" name="access[]" value="78" class="me-2" <?php if($prev['78']=='Y'){ echo 'checked'; } ?>>
                                                                ID Card Issued
                                                            </div>
                                                            <div class="p-3">
                                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access79" value="79" <?php if($prev['79']=='Y'){ echo 'checked'; } ?>>
                                                                    View
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 mb-3">
                                                        <div class="module-box">
                                                            <div class="module-header bg-success text-white">
                                                                <input type="checkbox" id="access80" name="access[]" value="80" class="me-2" <?php if($prev['80']=='Y'){ echo 'checked'; } ?>>
                                                                Bag Issued
                                                            </div>
                                                            <div class="p-3">
                                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                                    <input type="checkbox" id="access81" name="access[]" value="81" <?php if($prev['81']=='Y'){ echo 'checked'; } ?>>
                                                                    View
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 mb-3">
                                                        <div class="module-box">
                                                            <div class="module-header bg-success text-white">
                                                                <input type="checkbox" id="access82" name="access[]" value="82" class="me-2" <?php if($prev['82']=='Y'){ echo 'checked'; } ?>>
                                                                T-Shirt Issued
                                                            </div>
                                                            <div class="p-3">
                                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                                    <input type="checkbox" id="access83" name="access[]" value="83" <?php if($prev['83']=='Y'){ echo 'checked'; } ?>>
                                                                    View
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 mb-3">
                                                        <div class="module-box">
                                                            <div class="module-header bg-success text-white">
                                                                <input type="checkbox" id="access84" name="access[]" value="84" class="me-2" <?php if($prev['84']=='Y'){ echo 'checked'; } ?>>
                                                                Hostel Entry Report
                                                            </div>
                                                            <div class="p-3">
                                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                                    <input type="checkbox" id="access85" name="access[]" value="85" <?php if($prev['85']=='Y'){ echo 'checked'; } ?>>
                                                                    View
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 mb-3">
                                                        <div class="module-box">
                                                            <div class="module-header bg-success text-white">
                                                                <input type="checkbox" id="access86" name="access[]" value="86" class="me-2" <?php if($prev['86']=='Y'){ echo 'checked'; } ?>>
                                                                Students All Report
                                                            </div>
                                                            <div class="p-3">
                                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access87" value="87" <?php if($prev['87']=='Y'){ echo 'checked'; } ?>>
                                                                    View
                                                                </label>
                                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access88" value="88" <?php if($prev['88']=='Y'){ echo 'checked'; } ?>>
                                                                    Export Excel
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 mb-3">
                                                        <div class="module-box">
                                                            <div class="module-header bg-primary text-white">
                                                                <input type="checkbox" id="access89" name="access[]" value="89" class="me-2" <?php if($prev['89']=='Y'){ echo 'checked'; } ?>>
                                                                Admit Card Issued
                                                            </div>
                                                            <div class="p-3">
                                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access90" value="90" <?php if($prev['90']=='Y'){ echo 'checked'; } ?>>
                                                                    View
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 mb-3">
                                                        <div class="module-box">
                                                            <div class="module-header bg-primary text-white">
                                                                <input type="checkbox" id="access96" name="access[]" value="96" class="me-2" <?php if($prev['96']=='Y'){ echo 'checked'; } ?>>
                                                                Hostel Checked Report
                                                            </div>
                                                            <div class="p-3">
                                                                <label class="btn btn-outline-warning btn-sm me-2 mb-2">
                                                                    <input type="checkbox" name="access[]" id="access97" value="97" <?php if($prev['97']=='Y'){ echo 'checked'; } ?>>
                                                                    View
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3 float-right">
                                    Save Permission
                                </button>
                            </form>
                            <div id="msg"></div>
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
    $("#permissionForm").submit(function(e){

    e.preventDefault();

    $.ajax({
        url: "save.php?request=saveUserTypePermission",
        type: "POST",
        data: $(this).serialize(),
        success: function(response){

            $("#msg").html(
                '<div class="alert alert-success">'+response+'</div>'
            );
             $("#permissionForm")[0].reset();
                window.location.href = './userTypeList.php';
                setTimeout(function () {
                    location.reload();
                }, 1000);
            console.log(response);
        },
        error: function(){
            alert("Something went wrong");
        }
    });

});
</script>