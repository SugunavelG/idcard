<?php
session_start();
require_once '../common/config.php';
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
$request=$_GET['request'];
$type=$_GET['type'];
 $headName=$_SESSION['USER_HEAD_NAME'];
if($request=='saveUserType' && $type=='Add'){
    $userType=insert_val($conn,$_POST['userType']);
    $status=insert_val($conn,$_POST['status']);
    if((isset($userType) && !empty($userType)) && (isset($status) && !empty($status))){
        $sql="SELECT * FROM user_type WHERE ut_name='".$userType."'";
        $result=mysqli_query($conn,$sql);
        $numrows=mysqli_num_rows($result);
        $fetchArr=mysqli_fetch_array($result);
        if($numrows==0){
	        $sql1="INSERT INTO user_type SET ut_name='".$userType."',ut_status='".$status."',ut_cDate='".$regon."',ut_cBy='".$_SESSION['USER_NAME']."'";
	        //echo $sql1;exit;
	        $result1=mysqli_query($conn,$sql1);
	        if($result1){
	            echo json_encode([
                    'status'  => 'success',
                    'message' => 'User type saved successfully',
                    'userType'    => $userType
                ]);
                exit;
	        }else{
	            echo json_encode([
                    'status'  => 'false',
                    'message' => 'User type not saved,please try again..',
                    'userType'    => $userType
                ]);
                exit;
	        }
        }else{
            echo json_encode([
                'status'  => 'exits',
                'message' => 'User type is already exits.',
                'userType'    => $userType
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'Usertype or Status is empty.'
        ]);
        exit;
    }
}else if($request=='reportStudent'){
   // print_r($_POST);exit;
    $autoID=insert_val($conn,$_POST['id']);
    $appno=insert_val($conn,$_POST['appno']);
    if((isset($autoID) && !empty($autoID)) && (isset($appno) && !empty($appno))){
        // $date = date('Y-m-d');
        // $sql = "SELECT COUNT(*) AS total
        //          FROM student_details
        //          WHERE s_slotDate='$date'";
        // $result = mysqli_query($conn,$sql);
        // $row = mysqli_fetch_assoc($result);
        // $count = $row['total'] + 1;
        // if($count <= 50){
        //     $slot = 'Slot 1';
        // }else{
        //     $slot = 'Slot 2';
        // }

        $date = date('Y-m-d');

        $sql = "SELECT COUNT(*) AS total
                FROM student_details
                WHERE s_slotDate='$date'";
        
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        $count = $row['total'] + 1;
        
        // 50 students per slot
        $slotNumber = ceil($count / 50);
        
        $slot = 'Slot ' . $slotNumber;
        
        $sql1 = "UPDATE student_details SET s_slot='$slot',s_slotDate='$date',s_reportedStatus='REPORTED',s_reportedcDate='".$regon."',s_reportedcBy='".$_SESSION['USER_NAME']."'
                 WHERE s_application_number='$appno' ";
        $result1 = mysqli_query($conn,$sql1);
        if($result1){
            echo json_encode([
                'status'  => 'success',
                'message' => 'Student Reported successfully',
                'slot'    => $slot
            ]);
            exit;
        }else{
            echo json_encode([
                'status'  => 'false',
                'message' => 'Student not Reported,please try again..',
                'slot'    => $slot
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'Student detail is missing.'
        ]);
        exit;
    }
}else if($request=='saveHostelStudent'){
    //print_r($_POST);exit;
    $appno=insert_val($conn,$_POST['appno']);
    $studentID=insert_val($conn,$_POST['studentID']);
    $hostel=insert_val($conn,$_POST['hostel']);
    $room_category=insert_val($conn,$_POST['room_category']);
    $roomNo=insert_val($conn,$_POST['roomNo']);
    $paymentStatus=insert_val($conn,$_POST['paymentStatus']);
    $hostel_status=insert_val($conn,$_POST['hostel_status']);
    $desc=insert_val($conn,$_POST['desc']);
    if((isset($studentID) && !empty($studentID)) && (isset($appno) && !empty($appno)) && (isset($hostel) && !empty($hostel)) && (isset($room_category) && !empty($room_category)) && (isset($roomNo) && !empty($roomNo))){
        $sql="SELECT * FROM student_details WHERE s_id='".$studentID."' AND s_application_number='".$appno."'";
        $result=mysqli_query($conn,$sql);
        $numrows=mysqli_num_rows($result);
        $fetchArr=mysqli_fetch_array($result);
        if($numrows>0){
	        $sql1="UPDATE student_details SET s_h_id='".$hostel."',s_rc_id='".$room_category."',s_hos_roomno='".$roomNo."',s_hosStatus='".$hostel_status."',s_hos_cBy='".$_SESSION['USER_NAME']."',s_hos_cDate='".$regon."',s_hosPaymentStatus='".$paymentStatus."',s_hos_desc='".$desc."' WHERE s_application_number='".$appno."' AND s_id='".$studentID."'";
	        //echo $sql1;exit;
	        $result1=mysqli_query($conn,$sql1);
	        if($result1){
	            echo json_encode([
                    'status'  => 'success',
                    'message' => 'Student hostel entry updated successfully',
                    'roomno'    => $roomNo
                ]);
                exit;
	        }else{
	            echo json_encode([
                    'status'  => 'false',
                    'message' => 'Student hostel entry not updated,please try again..',
                    'roomno'    => $roomNo
                ]);
                exit;
	        }
        }else{
            echo json_encode([
                'status'  => 'exits',
                'message' => 'Student hostel entry is already exits.',
                'roomno'    => $roomNo
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'Usertype or Status is empty.'
        ]);
        exit;
    }
}else if($request=='checkInStudentHostelEntry'){
    //print_r($_POST);exit;
    $appno=insert_val($conn,$_POST['appno']);
    $studentID=insert_val($conn,$_POST['id']);
    $checkIn=insert_val($conn,$_POST['checkIn']);
    $description=insert_val($conn,$_POST['description']);
    if((isset($studentID) && !empty($studentID)) && (isset($appno) && !empty($appno)) && (isset($checkIn) && !empty($checkIn))){
        $sql="SELECT * FROM student_details WHERE s_id='".$studentID."' AND s_application_number='".$appno."'";
        $result=mysqli_query($conn,$sql);
        $numrows=mysqli_num_rows($result);
        $fetchArr=mysqli_fetch_array($result);
        if($numrows>0){
	        $sql1="UPDATE student_details SET s_hos_checkIn_status='".$checkIn."',s_hos_checkIn_desc='".$description."',s_hos_checkIn_cBy='".$_SESSION['USER_NAME']."',s_hos_checkIn_cDate='".$regon."' WHERE s_application_number='".$appno."' AND s_id='".$studentID."'";
	        $result1=mysqli_query($conn,$sql1);
	        if($result1){
	            echo json_encode([
                    'status'  => 'success',
                    'message' => 'Student hostel checkin updated successfully',
                    'checkIn'    => $checkIn
                ]);
                exit;
	        }else{
	            echo json_encode([
                    'status'  => 'false',
                    'message' => 'Student hostel checkin not updated,please try again..',
                    'checkIn'    => $checkIn
                ]);
                exit;
	        }
        }else{
            echo json_encode([
                'status'  => 'exits',
                'message' => 'Student hostel checkin is already exits.',
                'checkIn'    => $checkIn
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'Student or Status is empty.'
        ]);
        exit;
    }
}else if($request=='saveUserType' && $type=='Edit'){
    
    $utAutoID=insert_val($conn,$_POST['utAutoID']);
    $userType=insert_val($conn,$_POST['userType']);
    $status=insert_val($conn,$_POST['status']);
    if((isset($userType) && !empty($userType)) && (isset($status) && !empty($status))){
        $sql="SELECT * FROM user_type WHERE ut_name='".$userType."'";
        $result=mysqli_query($conn,$sql);
        $numrows=mysqli_num_rows($result);
        $fetchArr=mysqli_fetch_array($result);
        
        if($numrows<=1){
	        $sql1="UPDATE user_type SET ut_name='".$userType."',ut_status='".$status."',ut_eDate='".$regon."',ut_eBy='".$_SESSION['USER_NAME']."' WHERE ut_id='".$utAutoID."'";
	        //echo $sql1;exit;
	        $result1=mysqli_query($conn,$sql1);
	        if($result1){
	            echo json_encode([
                    'status'  => 'success',
                    'message' => 'User type updated successfully',
                    'userType'    => $userType
                ]);
                exit;
	        }else{
	            echo json_encode([
                    'status'  => 'false',
                    'message' => 'User type not updated,please try again..',
                    'userType'    => $userType
                ]);
                exit;
	        }
        }else{
            echo json_encode([
                'status'  => 'exits',
                'message' => 'User type is already exits.',
                'userType'    => $userType
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'Usertype or Status is empty.'
        ]);
        exit;
    }
}else if($request=='deleteUserType'){
    $id=insert_val($conn,$_POST['id']);
    $utype=insert_val($conn,$_POST['utype']);
    if(!empty($id) && !empty($utype)){
        $sql="UPDATE user_type SET ut_status='Deleted' WHERE ut_id='".$id."'";
       // echo $sql;
        $result=mysqli_query($conn,$sql);
        if($result){
            echo json_encode([
                'status'  => 'success',
                'message' => 'User type deleted successfully',
                'appno'    => $utype
            ]);
            exit;
        }else{
            echo json_encode([
                'status'  => 'false',
                'message' => 'User type not deleted,please try again..',
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'User type detail is missing.'
        ]);
        exit;
    }
}else if($request=='saveBloodGroup' && $type=='Add'){
     //print_r($_POST);exit;
    $bldGroup=insert_val($conn,$_POST['bldGroup']);
    $status=insert_val($conn,$_POST['status']);
    if((isset($bldGroup) && !empty($bldGroup)) && (isset($status) && !empty($status))){
        $sql="SELECT * FROM blood_group WHERE bg_name='".$bldGroup."'";
        $result=mysqli_query($conn,$sql);
        $numrows=mysqli_num_rows($result);
        $fetchArr=mysqli_fetch_array($result);
        if($numrows==0){
	        $sql1="INSERT INTO blood_group SET bg_name='".$bldGroup."',bg_status='".$status."',bg_cDate='".$regon."',bg_cBy='".$_SESSION['USER_NAME']."'";
	       // echo $sql1;exit;
	        $result1=mysqli_query($conn,$sql1);
	        if($result1){
	            echo json_encode([
                    'status'  => 'success',
                    'message' => 'Blood group saved successfully',
                    'bloodGroup'    => $bldGroup
                ]);
                exit;
	        }else{
	            echo json_encode([
                    'status'  => 'false',
                    'message' => 'Blood group not saved,please try again..',
                    'bloodGroup'    => $bldGroup
                ]);
                exit;
	        }
        }else{
            echo json_encode([
                'status'  => 'exits',
                'message' => 'Blood group is already exits.',
                'bloodGroup'    => $bldGroup
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'Blood group or Status is empty.'
        ]);
        exit;
    }
}else if($request=='saveBloodGroup' && $type=='Edit'){
    $bgAutoID=insert_val($conn,$_POST['bgAutoID']);
    $bldGroup=insert_val($conn,$_POST['bldGroup']);
    $status=insert_val($conn,$_POST['status']);
    if((isset($bldGroup) && !empty($bldGroup)) && (isset($status) && !empty($status))){
        $sql="SELECT * FROM blood_group WHERE bg_name='".$bldGroup."'";
        $result=mysqli_query($conn,$sql);
        $numrows=mysqli_num_rows($result);
        $fetchArr=mysqli_fetch_array($result);
        if($numrows<=1){
	        $sql1="UPDATE blood_group SET bg_name='".$bldGroup."',bg_status='".$status."',bg_eDate='".$regon."',bg_eBy='".$_SESSION['USER_NAME']."' WHERE bg_id='".$bgAutoID."'";
	        //echo $sql1;exit;
	        $result1=mysqli_query($conn,$sql1);
	        if($result1){
	            echo json_encode([
                    'status'  => 'success',
                    'message' => 'Blood group updated successfully',
                    'bloodGroup'    => $bldGroup
                ]);
                exit;
	        }else{
	            echo json_encode([
                    'status'  => 'false',
                    'message' => 'Blood group not updated,please try again..',
                    'bloodGroup'    => $bldGroup
                ]);
                exit;
	        }
        }else{
            echo json_encode([
                'status'  => 'exits',
                'message' => 'Blood group is already exits.',
                'bloodGroup'    => $bldGroup
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'Blood group or Status is empty.'
        ]);
        exit;
    }
}else if($request=='deleteBloodGroup'){
    $id=insert_val($conn,$_POST['id']);
    $bgname=insert_val($conn,$_POST['bgname']);
    if(!empty($id) && !empty($bgname)){
        //echo "UPDATE blood_group SET bg_status='3' WHERE bg_id='".$id."'";
        $sql="UPDATE blood_group SET bg_status='3' WHERE bg_id='".$id."'";
        //echo $sql;exit;
        $result=mysqli_query($conn,$sql);
        if($result){
            echo json_encode([
                'status'  => 'success',
                'message' => 'Blood group deleted successfully',
                'bloodGroup'    => $bgname
            ]);
            exit;
        }else{
            echo json_encode([
                'status'  => 'false',
                'message' => 'Blood group not deleted,please try again..',
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'Blood group detail is missing.'
        ]);
        exit;
    }
}else if($request=='saveDepartment' && $type=='Add'){
    $dept=insert_val($conn,$_POST['dept']);
    $dept_short=insert_val($conn,$_POST['dept_short']);
    $status=insert_val($conn,$_POST['status']);
    if((isset($dept) && !empty($dept)) && (isset($dept_short) && !empty($dept_short)) && (isset($status) && !empty($status))){
        $sql="SELECT * FROM department WHERE dept_name='".$dept."'";
        $result=mysqli_query($conn,$sql);
        $numrows=mysqli_num_rows($result);
        $fetchArr=mysqli_fetch_array($result);
        if($numrows==0){
	        $sql1="INSERT INTO department SET dept_name='".$dept."',dept_code='".$dept_short."',dept_status='".$status."',dept_cDate='".$regon."',dept_cBy='".$_SESSION['USER_NAME']."'";
	       //echo $sql1;exit;
	        $result1=mysqli_query($conn,$sql1);
	        if($result1){
	            echo json_encode([
                    'status'  => 'success',
                    'message' => 'Department saved successfully',
                    'department'    => $dept
                ]);
                exit;
	        }else{
	            echo json_encode([
                    'status'  => 'false',
                    'message' => 'Department not saved,please try again..',
                    'department'    => $dept
                ]);
                exit;
	        }
        }else{
            echo json_encode([
                'status'  => 'exits',
                'message' => 'Department is already exits.',
                'department'    => $dept
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'Department or Status is empty.'
        ]);
        exit;
    }
}else if($request=='saveDepartment' && $type=='Edit'){
    $deptAutoID=insert_val($conn,$_POST['deptAutoID']);
    $dept=insert_val($conn,$_POST['dept']);
    $dept_short=insert_val($conn,$_POST['dept_short']);
    $status=insert_val($conn,$_POST['status']);
    if((isset($dept) && !empty($dept)) && (isset($dept_short) && !empty($dept_short)) && (isset($status) && !empty($status))){
        $sql="SELECT * FROM department WHERE dept_name='".$dept."'";
        $result=mysqli_query($conn,$sql);
        $numrows=mysqli_num_rows($result);
        $fetchArr=mysqli_fetch_array($result);
        if($numrows<=1){
	        $sql1="UPDATE department SET dept_name='".$dept."',dept_code='".$dept_short."',dept_status='".$status."',dept_eDate='".$regon."',dept_eBy='".$_SESSION['USER_NAME']."' WHERE dept_id='".$deptAutoID."'";
	        //echo $sql1;exit;
	        $result1=mysqli_query($conn,$sql1);
	        if($result1){
	            echo json_encode([
                    'status'  => 'success',
                    'message' => 'Department updated successfully',
                    'department'    => $dept
                ]);
                exit;
	        }else{
	            echo json_encode([
                    'status'  => 'false',
                    'message' => 'Department not updated,please try again..',
                    'department'    => $dept
                ]);
                exit;
	        }
        }else{
            echo json_encode([
                'status'  => 'exits',
                'message' => 'Department is already exits.',
                'department'    => $dept
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'Department or Status is empty.'
        ]);
        exit;
    }
}else if($request=='deleteDepartment'){
    $id=insert_val($conn,$_POST['id']);
    $deptname=insert_val($conn,$_POST['deptname']);
    if(!empty($id) && !empty($deptname)){
        $sql="UPDATE department SET dept_status='3' WHERE dept_id='".$id."'";
        //echo $sql;exit;
        $result=mysqli_query($conn,$sql);
        if($result){
            echo json_encode([
                'status'  => 'success',
                'message' => 'Department deleted successfully',
                'department'    => $deptname
            ]);
            exit;
        }else{
            echo json_encode([
                'status'  => 'false',
                'message' => 'Department not deleted,please try again..',
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'Department detail is missing.'
        ]);
        exit;
    }
}else if($request=='saveHostel' && $type=='Add'){
    $hos=insert_val($conn,$_POST['hos']);
    $status=insert_val($conn,$_POST['status']);
    if((isset($hos) && !empty($hos)) && (isset($status) && !empty($status))){
        $sql="SELECT * FROM hostel WHERE h_name='".$hos."'";
        $result=mysqli_query($conn,$sql);
        $numrows=mysqli_num_rows($result);
        $fetchArr=mysqli_fetch_array($result);
        if($numrows==0){
	        $sql1="INSERT INTO hostel SET h_name='".$hos."',h_status='".$status."',h_cDate='".$regon."',h_cBy='".$_SESSION['USER_NAME']."'";
	       //echo $sql1;exit;
	        $result1=mysqli_query($conn,$sql1);
	        if($result1){
	            echo json_encode([
                    'status'  => 'success',
                    'message' => 'Hostel saved successfully',
                    'hostel'    => $hos
                ]);
                exit;
	        }else{
	            echo json_encode([
                    'status'  => 'false',
                    'message' => 'Hostel not saved,please try again..',
                    'hostel'    => $hos
                ]);
                exit;
	        }
        }else{
            echo json_encode([
                'status'  => 'exits',
                'message' => 'Hostel is already exits.',
                'hostel'    => $hos
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'Hostel or Status is empty.'
        ]);
        exit;
    }
}else if($request=='saveHostel' && $type=='Edit'){
    $hosAutoID=insert_val($conn,$_POST['hosAutoID']);
    $hos=insert_val($conn,$_POST['hos']);
    $status=insert_val($conn,$_POST['status']);
    if((isset($hos) && !empty($hos)) && (isset($status) && !empty($status))){
        $sql="SELECT * FROM hostel WHERE h_name='".$hos."'";
        $result=mysqli_query($conn,$sql);
        $numrows=mysqli_num_rows($result);
        $fetchArr=mysqli_fetch_array($result);
        if($numrows<=1){
	        $sql1="UPDATE hostel SET h_name='".$hos."',h_status='".$status."',h_eDate='".$regon."',h_eBy='".$_SESSION['USER_NAME']."' WHERE h_id='".$hosAutoID."'";
	        //echo $sql1;exit;
	        $result1=mysqli_query($conn,$sql1);
	        if($result1){
	            echo json_encode([
                    'status'  => 'success',
                    'message' => 'Hostel updated successfully',
                    'hostel'    => $hos
                ]);
                exit;
	        }else{
	            echo json_encode([
                    'status'  => 'false',
                    'message' => 'Hostel not updated,please try again..',
                    'hostel'    => $hos
                ]);
                exit;
	        }
        }else{
            echo json_encode([
                'status'  => 'exits',
                'message' => 'Hostel is already exits.',
                'hostel'    => $hos
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'Hostel or Status is empty.'
        ]);
        exit;
    }
}else if($request=='deleteHostel'){
   // print_r($_POST);
    $id=insert_val($conn,$_POST['id']);
    $hosname=insert_val($conn,$_POST['deptname']);
    if(!empty($id) && !empty($hosname)){
        $sql="UPDATE hostel SET h_status='3' WHERE h_id='".$id."'";
      //  echo $sql;exit;
        $result=mysqli_query($conn,$sql);
        if($result){
            echo json_encode([
                'status'  => 'success',
                'message' => 'Hostel deleted successfully',
                'hostel'    => $hosname
            ]);
            exit;
        }else{
            echo json_encode([
                'status'  => 'false',
                'message' => 'Hostel not deleted,please try again..',
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'Hostel detail is missing.'
        ]);
        exit;
    }
}else if($request=='saveCategory' && $type=='Add'){
    $catName=insert_val($conn,$_POST['cat']);
    $status=insert_val($conn,$_POST['status']);
    if((isset($catName) && !empty($catName)) && (isset($status) && !empty($status))){
        $sql="SELECT * FROM room_category WHERE rc_name='".$catName."'";
        $result=mysqli_query($conn,$sql);
        $numrows=mysqli_num_rows($result);
        $fetchArr=mysqli_fetch_array($result);
        if($numrows==0){
	        $sql1="INSERT INTO room_category SET rc_name='".$catName."',rc_status='".$status."',rc_cDate='".$regon."',rc_cBy='".$_SESSION['USER_NAME']."'";
	       //echo $sql1;exit;
	        $result1=mysqli_query($conn,$sql1);
	        if($result1){
	            echo json_encode([
                    'status'  => 'success',
                    'message' => 'Room Category saved successfully',
                    'category'    => $catName
                ]);
                exit;
	        }else{
	            echo json_encode([
                    'status'  => 'false',
                    'message' => 'Room Category not saved,please try again..',
                    'category'    => $catName
                ]);
                exit;
	        }
        }else{
            echo json_encode([
                'status'  => 'exits',
                'message' => 'Room Category is already exits.',
                'category'    => $catName
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'Room Category or Status is empty.'
        ]);
        exit;
    }
}else if($request=='saveCategory' && $type=='Edit'){
    $catAutoID=insert_val($conn,$_POST['catAutoID']);
    $catName=insert_val($conn,$_POST['cat']);
    $status=insert_val($conn,$_POST['status']);
    if((isset($catName) && !empty($catName)) && (isset($status) && !empty($status))){
        $sql="SELECT * FROM room_category WHERE rc_name='".$catName."'";
        $result=mysqli_query($conn,$sql);
        $numrows=mysqli_num_rows($result);
        $fetchArr=mysqli_fetch_array($result);
        if($numrows<=1){
	        $sql1="UPDATE room_category SET rc_name='".$catName."',rc_status='".$status."',rc_eDate='".$regon."',rc_eBy='".$_SESSION['USER_NAME']."' WHERE rc_id='".$catAutoID."'";
	       // echo $sql1;exit;
	        $result1=mysqli_query($conn,$sql1);
	        if($result1){
	            echo json_encode([
                    'status'  => 'success',
                    'message' => 'Room Category updated successfully',
                    'category'    => $hos
                ]);
                exit;
	        }else{
	            echo json_encode([
                    'status'  => 'false',
                    'message' => 'Room Category not updated,please try again..',
                    'category'    => $hos
                ]);
                exit;
	        }
        }else{
            echo json_encode([
                'status'  => 'exits',
                'message' => 'Room Category is already exits.',
                'category'    => $hos
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'Hostel or Status is empty.'
        ]);
        exit;
    }
}else if($request=='deleteCategory'){
    //print_r($_POST);
    $id=insert_val($conn,$_POST['id']);
    $catName=insert_val($conn,$_POST['catname']);
    if(!empty($id) && !empty($catName)){
        $sql="UPDATE room_category SET rc_status='3' WHERE rc_id='".$id."'";
      // echo $sql;exit;
        $result=mysqli_query($conn,$sql);
        if($result){
            echo json_encode([
                'status'  => 'success',
                'message' => 'Room Category deleted successfully',
                'category'    => $catName
            ]);
            exit;
        }else{
            echo json_encode([
                'status'  => 'false',
                'message' => 'Room Category not deleted,please try again..',
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'Room Category detail is missing.'
        ]);
        exit;
    }
}else if($request=='saveState' && $type=='Add'){
    $state=insert_val($conn,$_POST['state']);
    $state_short=insert_val($conn,$_POST['state_short']);
    $status=insert_val($conn,$_POST['status']);
    if((isset($state) && !empty($state)) && (isset($state_short) && !empty($state_short)) && (isset($status) && !empty($status))){
        $sql="SELECT * FROM state WHERE st_name='".$state."'";
        $result=mysqli_query($conn,$sql);
        $numrows=mysqli_num_rows($result);
        $fetchArr=mysqli_fetch_array($result);
        if($numrows==0){
	        $sql1="INSERT INTO state SET st_name='".$state."',st_code='".$state_short."',st_status='".$status."',st_cDate='".$regon."',st_cBy='".$_SESSION['USER_NAME']."'";
	       //echo $sql1;exit;
	        $result1=mysqli_query($conn,$sql1);
	        if($result1){
	            echo json_encode([
                    'status'  => 'success',
                    'message' => 'State saved successfully',
                    'state'    => $state
                ]);
                exit;
	        }else{
	            echo json_encode([
                    'status'  => 'false',
                    'message' => 'State not saved,please try again..',
                    'state'    => $state
                ]);
                exit;
	        }
        }else{
            echo json_encode([
                'status'  => 'exits',
                'message' => 'State is already exits.',
                'state'    => $state
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'State or Status is empty.'
        ]);
        exit;
    }
}else if($request=='saveState' && $type=='Edit'){
    //print_r($_POST);exit;
    $stAutoID=insert_val($conn,$_POST['stAutoID']);
    $state=insert_val($conn,$_POST['state']);
    $state_short=insert_val($conn,$_POST['state_short']);
    $status=insert_val($conn,$_POST['status']);
    if((isset($state) && !empty($state)) && (isset($state_short) && !empty($state_short)) && (isset($status) && !empty($status))){
        $sql="SELECT * FROM state WHERE st_name='".$state."'";
        $result=mysqli_query($conn,$sql);
        $numrows=mysqli_num_rows($result);
        $fetchArr=mysqli_fetch_array($result);
        if($numrows<=1){
	        $sql1="UPDATE state SET st_name='".$state."',st_code='".$state_short."',st_status='".$status."',st_eDate='".$regon."',st_eBy='".$_SESSION['USER_NAME']."' WHERE st_id='".$stAutoID."'";
	        //echo $sql1;exit;
	        $result1=mysqli_query($conn,$sql1);
	        if($result1){
	            echo json_encode([
                    'status'  => 'success',
                    'message' => 'State updated successfully',
                    'state'    => $state
                ]);
                exit;
	        }else{
	            echo json_encode([
                    'status'  => 'false',
                    'message' => 'State not updated,please try again..',
                    'state'    => $state
                ]);
                exit;
	        }
        }else{
            echo json_encode([
                'status'  => 'exits',
                'message' => 'State is already exits.',
                'state'    => $state
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'State or Status is empty.'
        ]);
        exit;
    }
}else if($request=='deleteState'){
    $id=insert_val($conn,$_POST['id']);
    $stname=insert_val($conn,$_POST['stname']);
    if(!empty($id) && !empty($stname)){
        $sql="UPDATE state SET st_status='3' WHERE st_id='".$id."'";
        //echo $sql;exit;
        $result=mysqli_query($conn,$sql);
        if($result){
            echo json_encode([
                'status'  => 'success',
                'message' => 'State deleted successfully',
                'state'    => $stname
            ]);
            exit;
        }else{
            echo json_encode([
                'status'  => 'false',
                'state' => 'State not deleted,please try again..',
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'state' => 'State detail is missing.'
        ]);
        exit;
    }
}else if($request=='updateStudentDepartment'){
    //print_r($_POST);exit;
    $id=insert_val($conn,$_POST['id']);
    $appno=insert_val($conn,$_POST['appno']);
    $oldDept=insert_val($conn,$_POST['oldDept']);
    $deptname=insert_val($conn,$_POST['dept']);
    $desc=insert_val($conn,$_POST['desc']);
    if(!empty($id) && !empty($appno) && !empty($deptname)){
        $sql="UPDATE student_details SET s_department='".$deptname."',s_deptcDate='".$regon."',s_deptcBy='".$_SESSION['USER_NAME']."' WHERE s_id='".$id."' AND s_application_number ='".$appno."'";
        //echo $sql;exit;
        $result=mysqli_query($conn,$sql);
        if($result){
            $sql2="SELECT * FROM department WHERE dept_id='".$deptname."'";;
            $result2=mysqli_query($conn,$sql2);
            $fetchArr2=mysqli_fetch_array($result2);
            $newDeptName=$fetchArr2['dept_name'];
            $sql1="INSERT INTO department_history SET dh_appno='".$appno."',dh_oldDept='".$oldDept."',dh_newDept='".$newDeptName."',dh_desc='".$desc."',dh_cBy='".$_SESSION['USER_NAME']."',dh_cDate='".$regon."'";
            $result1=mysqli_query($conn,$sql1);
            if($result1){
                echo json_encode([
                    'status'  => 'success',
                    'message' => 'Department updated successfully',
                    'department'    => $deptname
                ]);
                exit;
            }else{
                echo json_encode([
                    'status'  => 'false',
                    'message' => 'Department not updated,please try again..',
                ]);
                exit;
            }
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'Department detail is missing.'
        ]);
        exit;
    }
}else if($request=='deleteUser'){
    $id=insert_val($conn,$_POST['id']);
    $utype=insert_val($conn,$_POST['utype']);
    //print_r($_POST);exit;
    if(!empty($id) && !empty($utype)){
        $sql="UPDATE users SET u_status='Deleted' WHERE u_id='".$id."'";
       // echo $sql;
        $result=mysqli_query($conn,$sql);
        if($result){
            echo json_encode([
                'status'  => 'success',
                'message' => 'User deleted successfully',
                'appno'    => $utype
            ]);
            exit;
        }else{
            echo json_encode([
                'status'  => 'false',
                'message' => 'User not deleted,please try again..',
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'User detail is missing.'
        ]);
        exit;
    }
}else if($request=='saveUser' && $type=='Add'){
    $userType=insert_val($conn,$_POST['usertype']);
    $team_head=insert_val($conn,$_POST['team_head']);
    $name=insert_val($conn,$_POST['name']);
    $username=insert_val($conn,$_POST['username']);
    $password=insert_val($conn,$_POST['password']);
    $status=insert_val($conn,$_POST['status']);
    if((isset($userType) && !empty($userType)) && (isset($name) && !empty($name)) && (isset($username) && !empty($username)) && (isset($password) && !empty($password)) && (isset($status) && !empty($status))){
        $sql="SELECT * FROM users WHERE u_username='".$name."' AND u_password='".$password."'";
        $result=mysqli_query($conn,$sql);
        $numrows=mysqli_num_rows($result);
        $fetchArr=mysqli_fetch_array($result);
        if($numrows==0){
	        $sql1="INSERT INTO users SET u_ut_type='".$userType."',u_headName='".$team_head."',u_name='".$name."',u_username='".$username."',u_password='".$password."',u_status='".$status."',u_cDate='".$regon."',u_cBy='".$_SESSION['USER_NAME']."'";
	        //echo $sql1;exit;
	        $result1=mysqli_query($conn,$sql1);
	        if($result1){
	            
	            echo json_encode([
                    'status'  => 'success',
                    'message' => 'User saved successfully',
                    'userType'    => $userType
                ]);
                exit;
	        }else{
	            echo json_encode([
                    'status'  => 'false',
                    'message' => 'User not saved,please try again..',
                    'userType'    => $userType
                ]);
                exit;
	        }
        }else{
            echo json_encode([
                'status'  => 'exits',
                'message' => 'User is already exits.',
                'userType'    => $userType
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'User detail is missing.'
        ]);
        exit;
    }
}else if($request=='saveUser' && $type=='Edit'){
   // print_r($_POST);exit;
    $uAutoID=insert_val($conn,$_POST['uAutoID']);
    $userType=insert_val($conn,$_POST['usertype']);
    $name=insert_val($conn,$_POST['name']);
    $username=insert_val($conn,$_POST['username']);
    $password=insert_val($conn,$_POST['password']);
    $status=insert_val($conn,$_POST['status']);
     $team_head=insert_val($conn,$_POST['team_head']);
    if((isset($userType) && !empty($userType)) && (isset($name) && !empty($name)) && (isset($username) && !empty($username)) && (isset($password) && !empty($password)) && (isset($status) && !empty($status))){
        $sql="SELECT * FROM users WHERE u_username='".$username."' AND u_password='".$password."'";
        $result=mysqli_query($conn,$sql);
        $numrows=mysqli_num_rows($result);
        $fetchArr=mysqli_fetch_array($result);
        if($numrows<=1){
	        $sql1="UPDATE users SET u_ut_type='".$userType."',u_headName='".$team_head."',u_name='".$name."',u_username='".$username."',u_password='".$password."',u_status='".$status."',u_eDate='".$regon."',u_eBy='".$_SESSION['USER_NAME']."' WHERE u_id='".$uAutoID."'";
	        $result1=mysqli_query($conn,$sql1);
	        //echo $sql1;exit;
	        if($result1){
	            echo json_encode([
                    'status'  => 'success',
                    'message' => 'User updated successfully',
                    'user'    => $name
                ]);
                exit;
	        }else{
	            echo json_encode([
                    'status'  => 'false',
                    'message' => 'User not updated,please try again..',
                    'user'    => $name
                ]);
                exit;
	        }
        }else{
            echo json_encode([
                'status'  => 'exits',
                'message' => 'User is already exits.',
                'userType'    => $name
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'User detail is missing.'
        ]);
        exit;
    }
}else if($request=='saveStudent' && $type=='Add'){
     // --- 1. Get form data ---
     // print_r($_POST);exit;
    $studentID=$_POST['studentID'];
    
    $appno            = insert_val($conn,$_POST['appno']);
    $firstname         = insert_val($conn,$_POST['firstname']);
    $lastname         = insert_val($conn,$_POST['lastname']);
    $dob              = insert_val($conn,$_POST['dob']);
    $gender           = insert_val($conn,$_POST['gender']);
    $batch            = insert_val($conn,$_POST['batch']);
    $blood            = insert_val($conn,$_POST['blood']);
    $dept             = insert_val($conn,$_POST['dept']);
    $course_type             = insert_val($conn,$_POST['course_type']);
    $mobile           = insert_val($conn,$_POST['mobile']);
    $emailId           = insert_val($conn,$_POST['emailId']);
    $fathername           = insert_val($conn,$_POST['fathername']);
    $mothername          = insert_val($conn,$_POST['mothername']);
    $fatherEmailId = insert_val($conn,$_POST['fatherEmailId']);
    $alternate_mobile = insert_val($conn,$_POST['alternate_mobile']);
    $addressLine1          = insert_val($conn,$_POST['addressLine1']);
    $addressLine2          = insert_val($conn,$_POST['addressLine2']);
    $area          = insert_val($conn,$_POST['area']);
    $city          = insert_val($conn,$_POST['city']);
    $district          = insert_val($conn,$_POST['district']);
    $state          = insert_val($conn,$_POST['state']);
    $pincode          = insert_val($conn,$_POST['pincode']);
    $status           = insert_val($conn,$_POST['status']);
    $stuType           = insert_val($conn,$_POST['stuType']);
    
    $admissionOwner          = insert_val($conn,$_POST['admissionOwner']);
    $studentStatus          = insert_val($conn,$_POST['studentStatus']);
    $studentIdVerification= insert_val($conn,$_POST['studentIdVerification']);
    if(
    (isset($appno) && !empty($appno)) && 
    (isset($firstname) && !empty($firstname)) && 
    (isset($lastname) && !empty($lastname)) && 
    (isset($dob) && !empty($dob)) && 
    (isset($gender) && !empty($gender)) && 
    (isset($batch) && !empty($batch)) && 
    (isset($dept) && !empty($dept)) && 
    (isset($mobile) && !empty($mobile)) && 
    (isset($emailId) && !empty($emailId)) && 
    (isset($fathername) && !empty($fathername)) && 
    (isset($mothername) && !empty($mothername)) && 
    (isset($fatherEmailId) && !empty($fatherEmailId)) && 
    (isset($alternate_mobile) && !empty($alternate_mobile)) && 
    (isset($addressLine1) && !empty($addressLine1)) && 
    (isset($area) && !empty($area)) && 
    (isset($city) && !empty($city)) && 
    (isset($district) && !empty($district)) && 
    (isset($state) && !empty($state)) && 
    (isset($pincode) && !empty($pincode)) && 
    (isset($stuType) && !empty($stuType))){
        
    $sql="SELECT * FROM student_details WHERE s_application_number='".$appno."'";
    $result=mysqli_query($conn,$sql);
    $numrows=mysqli_num_rows($result);
    $fetchArr=mysqli_fetch_array($result);
    if($numrows==0){
     
       
        // Physical Folder Path
        $uploadDir = dirname(__DIR__) . '/uploads/2026/' . $appno . '/';
        
        // Database Path
        $dbPath = 'uploads/2026/' . $appno . '/';
        
        if (!is_dir($uploadDir)) {
        
            if (!mkdir($uploadDir, 0777, true)) {
                die("Unable to create directory.");
            }
        }
        
        $fileNames = [
            'photo'           => 'student_photo',
            'signature'       => 'student_signature',
            'parentsignature' => 'father_signature',
            'family_photo' => 'family_photo'
        ];
        
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $maxFileSize = 2 * 1024 * 1024; // 2 MB
        
        $photoPath = '';
        $signaturePath = '';
        $parentSignaturePath = '';
        $familyPath = '';
        
        $errors = [];
        
        foreach ($fileNames as $filePrefix) {
        
            if (
                isset($_FILES[$filePrefix]) &&
                $_FILES[$filePrefix]['error'] === UPLOAD_ERR_OK
            ) {
        
                $fileName = $_FILES[$filePrefix]['name'];
                $tmpName  = $_FILES[$filePrefix]['tmp_name'];
        
                $extension = strtolower(
                    pathinfo($fileName, PATHINFO_EXTENSION)
                );
        
                $newFileName =$appno . '_' .$filePrefix . '.' .$extension;
        
                $targetFile =$uploadDir . $newFileName;
        
                $dbFilePath =$dbPath . $newFileName;
                if (file_exists($targetFile)) {
                    unlink($targetFile);
                }
                if (move_uploaded_file($tmpName,$targetFile)) {
        
                    if ($filePrefix == 'student_photo') {
                        $photoPath = $newFileName;
                    }
                    
                    if ($filePrefix == 'student_signature') {
                        $signaturePath = $newFileName;
                    }
                    
                    if ($filePrefix == 'father_signature') {
                        $parentSignaturePath = $newFileName;
                    }
                    if ($filePrefix == 'family_photo') {
                        $familyPath = $newFileName;
                    }
                }
            }
        }
        if($stuType=='WORKING PROFESSIONAL'){
            $course_type='WORKING PROFESSIONAL';
        }else{
            $course_type='REGULAR';
        }
        $sql1 = "INSERT INTO student_details SET 
            s_application_number = '$appno',
            s_first_name = '$firstname',
            s_last_name = '$lastname',
            s_dob = '$dob',
            s_gender = '$gender',
            s_batch = '$batch',
            s_blood_group = '$blood',
            s_department = '$dept',
            s_course_type='$course_type',
            s_mobile_no = '$mobile',
            s_emailId = '$emailId',
            s_fathername = '$fathername',
            s_mothername = '$mothername',
            s_alternate_mobile ='$alternate_mobile',
            s_father_email = '$fatherEmailId',
            s_address1 = '$addressLine1',
            s_address2 = '$addressLine2',
            s_area = '$area',
            s_city = '$city',
            s_district = '$district',
            s_state = '$state',
            s_pincode = '$pincode',
            s_stu_type = '$stuType',
            s_status = '1',
            s_admittedStatus='NOT ISSUED',
            s_bagStatus='NOT ISSUED',
            s_tshirtStatus='NOT ISSUED',
            s_idcardStatus='NOT ISSUED',
            s_photo = '$photoPath',
            s_signature = '$signaturePath',
            s_parent_signature='$parentSignaturePath',
            s_family_photo='$familyPath',
            s_stu_verified='".$studentIdVerification."',
             s_stu_verifiedDate='".$regon."',
             s_stu_verifiedBy='".$_SESSION['USER_NAME']."',
            s_admissionOwner='$admissionOwner',
            s_cDate='".$regon."',
            s_cBy='".$_SESSION['USER_NAME']."'";
            //echo $sql1;exit;
        $result1=mysqli_query($conn,$sql1);
        if($result1){
                // MySQL Auto ID
                if($studentIdVerification=='VERIFIED'){
                $id = mysqli_insert_id($conn);
               
                $sql1="SELECT * FROM student_details
                    LEFT JOIN department ON dept_id=s_department
                    LEFT JOIN blood_group ON bg_id=s_blood_group
                     LEFT JOIN state ON st_id=s_state
                    WHERE s_application_number='".$appno."'";
                $result1=mysqli_query($conn,$sql1);
                $numrows1=mysqli_num_rows($result1);
                $fetchArr1=mysqli_fetch_array($result1);
                $fullName=$firstname.' '.$lastname;
                $deptShortName=$fetchArr1['dept_code'];
                $batch=$fetchArr1['s_batch'];
                $dob = date('d-m-Y', strtotime($fetchArr1['s_dob']));
                $blood=$fetchArr1['bg_name'];
                if($fetchArr1['s_address2']=='' || empty($fetchArr1['s_address2'])){
                    $address1 = $fetchArr1['s_address1'];
                }else{
                    $address1 = $fetchArr1['s_address1'] . "," .
                            $fetchArr1['s_address2'];
                }
                
                
                $address2 = $fetchArr1['s_area'] . "," .
                            $fetchArr1['s_city'];
                
                $address3 = $fetchArr1['s_district'] . "," .
                strtoupper($fetchArr1['st_code']) . " - " . $fetchArr1['s_pincode'];
                                 // Google Apps Script URL
                $url = "https://script.google.com/macros/s/AKfycbzttMgXcFaR3sB3AvECPoqP542EmSqrTnNw5jYY4gKt9JUbBiOo_kuztnn_4pUiQxjN/exec";
            
                // Data to Google Sheet
               $data = array(
                    "action"             => "insert",
                    "full_name" => ucwords(strtolower($fullName)),
                    "application_number" => $appno,
                    "department"         => $deptShortName,
                    "batch"              => $batch,
                    "dob" => date("d.m.Y", strtotime($dob)),
                    "blood_group"        => $blood,
                    "address1" => ucwords(str_replace(array("\r\n", "\n", "\r"), "\n", strtolower($address1))),
                    "address2" => ucwords(str_replace(array("\r\n", "\n", "\r"), "\n", strtolower($address2))),
                    "address3" => $address3,
                    "address4"           => "",
                    "mobile"             => $mobile,
                    "alternate_mobile"   => $alternate_mobile,
                    "studentType"   => $stuType,
                    "applicantType"   => $course_type,
                    "id"                 => $id
                );
            
                $options = array(
                    "http" => array(
                        "header"  => "Content-Type: application/json",
                        "method"  => "POST",
                        "content" => json_encode($data)
                    )
                );
        
                $context = stream_context_create($options);
            
                $result2 = file_get_contents($url, false, $context);
                }
                echo json_encode([
                    'status'  => 'success',
                    'message' => 'Student saved successfully',
                    'appno'   => $appno
                ]);
                exit;
            }else{
                echo json_encode([
                    'status'  => 'false',
                    'message' => 'student not saved,please try again..',
                ]);
                exit;
            }
        }else{
            echo json_encode([
                'status'  => 'exits',
                'message' => 'Application number is already exits.',
                'appno'    => $appno
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'student detail is missing.'
        ]);
        exit;
    }
    
}else if($request=='saveStudent' && $type=='Edit'){
     // --- 1. Get form data ---
    $studentID=$_POST['studentID'];

    $appno            = insert_val($conn,$_POST['appno']);
    $firstname         = insert_val($conn,$_POST['firstname']);
    $lastname         = insert_val($conn,$_POST['lastname']);
    $dob              = insert_val($conn,$_POST['dob']);
    $gender           = insert_val($conn,$_POST['gender']);
    $batch            = insert_val($conn,$_POST['batch']);
    $blood            = insert_val($conn,$_POST['blood']);
    $dept             = insert_val($conn,$_POST['dept']);
    $course_type             = insert_val($conn,$_POST['course_type']);
    $mobile           = insert_val($conn,$_POST['mobile']);
    $emailId           = insert_val($conn,$_POST['emailId']);
    $fathername           = insert_val($conn,$_POST['fathername']);
    $mothername          = insert_val($conn,$_POST['mothername']);
    $fatherEmailId = insert_val($conn,$_POST['fatherEmailId']);
    $alternate_mobile = insert_val($conn,$_POST['alternate_mobile']);
    $addressLine1          = insert_val($conn,$_POST['addressLine1']);
    $addressLine2          = insert_val($conn,$_POST['addressLine2']);
    $area          = insert_val($conn,$_POST['area']);
    $city          = insert_val($conn,$_POST['city']);
    $district          = insert_val($conn,$_POST['district']);
    $state          = insert_val($conn,$_POST['state']);
    $pincode          = insert_val($conn,$_POST['pincode']);
    $status           = insert_val($conn,$_POST['status']);
    $stuType           = insert_val($conn,$_POST['stuType']);
    $studentStatus          = insert_val($conn,$_POST['studentStatus']);
    $admissionOwner          = insert_val($conn,$_POST['admissionOwner']);
    $studentIdVerification= insert_val($conn,$_POST['studentIdVerification']);
    if(
        (isset($appno) && !empty($appno)) && 
        (isset($firstname) && !empty($firstname)) && 
        (isset($lastname) && !empty($lastname)) && 
        (isset($dob) && !empty($dob)) && 
        (isset($gender) && !empty($gender)) && 
        (isset($batch) && !empty($batch)) && 
        (isset($dept) && !empty($dept)) && 
        (isset($mobile) && !empty($mobile)) && 
        (isset($emailId) && !empty($emailId)) && 
        (isset($fathername) && !empty($fathername)) && 
        (isset($mothername) && !empty($mothername)) && 
        (isset($fatherEmailId) && !empty($fatherEmailId)) && 
        (isset($alternate_mobile) && !empty($alternate_mobile)) && 
        (isset($addressLine1) && !empty($addressLine1)) && 
        (isset($area) && !empty($area)) && 
        (isset($city) && !empty($city)) && 
        (isset($district) && !empty($district)) && 
        (isset($state) && !empty($state)) && 
        (isset($pincode) && !empty($pincode)) && 
        (isset($stuType) && !empty($stuType))){
        $sql="SELECT * FROM student_details WHERE s_application_number='".$appno."'";
        $result=mysqli_query($conn,$sql);
        $numrows=mysqli_num_rows($result);
        $fetchArr=mysqli_fetch_array($result);
        if($numrows<=1){
           
            $uploadDir = dirname(__DIR__) . '/uploads/2026/' . $appno . '/';
        
            // Database Path
            $dbPath = 'uploads/2026/' . $appno . '/';
            
            if (!is_dir($uploadDir)) {
            
                if (!mkdir($uploadDir, 0777, true)) {
                    die("Unable to create directory.");
                }
            }
            
           $fileNames = [
            'photo'           => 'student_photo',
            'signature'       => 'student_signature',
            'parentsignature' => 'father_signature',
            'family_photo' => 'family_photo'
        ];
        
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $maxFileSize = 2 * 1024 * 1024; // 2 MB
        
            
            $photoPath            = $_POST['prevPhoto'];
            $signaturePath        = $_POST['prevSignature'];
            $parentSignaturePath  = $_POST['prevParentSignature'];
            $familyPath=$_POST['prevFamilyPhoto'];
            foreach ($fileNames as $inputName => $filePrefix) {
            
                 if (
                    isset($_FILES[$inputName]) &&
                    $_FILES[$inputName]['error'] == 0
                ) {
                
                    $fileName = $_FILES[$inputName]['name'];
                
                    $extension = strtolower(
                        pathinfo($fileName, PATHINFO_EXTENSION)
                    );
                
                    // jpeg ah jpg ah convert pannalam
                    if ($extension == 'jpeg') {
                        $extension = 'jpg';
                    }
                
                    $newFileName =
                        $appno . '_' .
                        $filePrefix . '.' .
                        $extension;
                
                    $targetFile =
                        $uploadDir . $newFileName;
                
                    // old file delete
                    if (file_exists($targetFile)) {
                        unlink($targetFile);
                    }
                
                    if (
                        move_uploaded_file(
                            $_FILES[$inputName]['tmp_name'],
                            $targetFile
                        )
                    ) {
                
                        if ($inputName == 'student_photo') {
                            $photoPath = $newFileName;
                        }
                
                        if ($inputName == 'student_signature') {
                            $signaturePath = $newFileName;
                        }
                
                        if ($inputName == 'father_signature') {
                            $parentSignaturePath = $newFileName;
                        }
                        
                        if ($inputName == 'family_photo') {
                            $familyPath = $newFileName;
                        }
                    }
                }
            }
            
        if($stuType=='WORKING PROFESSIONAL'){
            $course_type='WORKING PROFESSIONAL';
        }else{
            $course_type='REGULAR';
        }
        $sql1 = "UPDATE student_details SET 
            s_application_number = '$appno',
            s_first_name = '$firstname',
            s_last_name = '$lastname',
            s_dob = '$dob',
            s_gender = '$gender',
            s_batch = '$batch',
            s_blood_group = '$blood',
            s_department = '$dept',
            s_course_type='$course_type',
            s_mobile_no = '$mobile',
            s_emailId = '$emailId',
            s_fathername = '$fathername',
            s_mothername = '$mothername',
            s_alternate_mobile ='$alternate_mobile',
            s_father_email = '$fatherEmailId',
            s_address1 = '$addressLine1',
            s_address2 = '$addressLine2',
            s_area = '$area',
            s_city = '$city',
            s_district = '$district',
            s_state = '$state',
            s_pincode = '$pincode',
            s_stu_type = '$stuType',
            s_status = '1',
            s_reportedcBy='".$_SESSION['USER_NAME']."',
            s_bagStatus='NOT ISSUED',
            s_tshirtStatus='NOT ISSUED',
            s_idcardStatus='NOT ISSUED',
            s_photo = '$photoPath',
            s_signature = '$signaturePath',
            s_parent_signature='$parentSignaturePath',
            s_family_photo='$familyPath',
            s_stu_verified='".$studentIdVerification."',
            s_stu_verifiedDate='".$regon."',
             s_stu_verifiedBy='".$_SESSION['USER_NAME']."',
            s_admissionOwner='$admissionOwner',
            s_eDate='".$regon."',
            s_eBy='".$_SESSION['USER_NAME']."' WHERE s_id='".$studentID."' AND s_application_number='".$appno."'";
            // $sql1 = "UPDATE student_details SET s_application_number = '$appno',s_full_name = '$fullname',s_dob = '$dob',s_gender = '$gender',s_department = '$dept',s_batch = '$batch',s_blood_group = '$blood',s_mobile_no = '$mobile',s_alternate_mobile ='$alternate_mobile',s_address = '$address',s_stu_type = '$stuType',s_status = '$status',s_photo = '$photo_path',s_signature = '$signature_path',s_eDate='".$regon."',s_eBy='".$_SESSION['USER_NAME']."' ";
                  //  echo $sql1;exit;
            $result1=mysqli_query($conn,$sql1);
            if($result1){
                 if($studentIdVerification=='VERIFIED'){
                    $sql1="SELECT * FROM student_details
                        LEFT JOIN department ON dept_id=s_department
                        LEFT JOIN blood_group ON bg_id=s_blood_group
                        LEFT JOIN state ON st_id=s_state
                        WHERE s_application_number='".$appno."' AND s_id='".$studentID."'";
                    $result1=mysqli_query($conn,$sql1);
                    $numrows1=mysqli_num_rows($result1);
                    $fetchArr1=mysqli_fetch_array($result1);
                    $fullName=$firstname.' '.$lastname;
                    $deptShortName=$fetchArr1['dept_code'];
                    $batch=$fetchArr1['s_batch'];
                    $dob = date('d-m-Y', strtotime($fetchArr1['s_dob']));
                    $blood=$fetchArr1['bg_name'];
                    if($fetchArr1['s_address2']=='' || empty($fetchArr1['s_address2'])){
                        $address1 = $fetchArr1['s_address1'];
                    }else{
                        $address1 = $fetchArr1['s_address1'] . "," .
                                $fetchArr1['s_address2'];
                    }
                    
                    $address2 = $fetchArr1['s_area'] . "," .
                                $fetchArr1['s_city'];
                    
                    $address3 = $fetchArr1['s_district'] . "," .
                    strtoupper($fetchArr1['st_code']) . " - " . $fetchArr1['s_pincode'];
                                             // Google Apps Script URL
                    $url = "https://script.google.com/macros/s/AKfycbzttMgXcFaR3sB3AvECPoqP542EmSqrTnNw5jYY4gKt9JUbBiOo_kuztnn_4pUiQxjN/exec";
                
                    // Data to Google Sheet
                   $data = array(
                        "action"             => "update",
                        "full_name" => ucwords(strtolower($fullName)),
                        "application_number" => $appno,
                        "department"         => $deptShortName,
                        "batch"              => $batch,
                        "dob" => date("d.m.Y", strtotime($dob)),
                        "blood_group"        => $blood,
                        // "address1"            => str_replace(array("\\r\\n", "\\n", "\\r"), "\n", $address1),
                        // "address2"           => str_replace(array("\\r\\n", "\\n", "\\r"), "\n", $address2),
                        // "address3"           => str_replace(array("\\r\\n", "\\n", "\\r"), "\n", $address3),
                        "address1" => ucwords(str_replace(array("\r\n", "\n", "\r"), "\n", strtolower($address1))),
                        "address2" => ucwords(str_replace(array("\r\n", "\n", "\r"), "\n", strtolower($address2))),
                        "address3" => $address3,
                        "address4"           => "",
                        "mobile"             => $mobile,
                        "alternate_mobile"   => $alternate_mobile,
                        "studentType"   => $stuType,
                        "applicantType"   => $course_type,
                        "id"                 => $studentID
                    );
                
                    $options = array(
                        "http" => array(
                            "header"  => "Content-Type: application/json",
                            "method"  => "POST",
                            "content" => json_encode($data)
                        )
                    );
            
                    $context = stream_context_create($options);
                    $result = file_get_contents($url, false, $context);
                 }
                echo json_encode([
                    'status'  => 'success',
                    'message' => 'Student edited successfully',
                    'appno'    => $appno
                ]);
                exit;
            }else{
                echo json_encode([
                    'status'  => 'false',
                    'message' => 'student not edited,please try again..',
                ]);
                exit;
            }
        }else{
            echo json_encode([
                'status'  => 'exits',
                'message' => 'Application number is already exits.',
                'appno'    => $appno
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'student detail is missing.'
        ]);
        exit;
    }
    
}else if($request=='uploadStudentFiles' && $type=='Edit'){
     // --- 1. Get form data ---
    $studentID=$_POST['studentID'];

    $appno            = insert_val($conn,$_POST['appno']);
    $firstname         = insert_val($conn,$_POST['firstname']);
    $lastname         = insert_val($conn,$_POST['lastname']);
    // $studentStatus          = insert_val($conn,$_POST['studentStatus']);
    // $studentIdVerification= insert_val($conn,$_POST['studentIdVerification']);
    if(
        (isset($appno) && !empty($appno)) && 
        (isset($firstname) && !empty($firstname)) && 
        (isset($lastname) && !empty($lastname))
    ){
        $sql="SELECT * FROM student_details WHERE s_application_number='".$appno."'";
        $result=mysqli_query($conn,$sql);
        $numrows=mysqli_num_rows($result);
        $fetchArr=mysqli_fetch_array($result);
        if($numrows<=1){
            
            $uploadDir = dirname(__DIR__) . '/uploads/2026/' . $appno . '/';
        
            // Database Path
            $dbPath = 'uploads/2026/' . $appno . '/';
            
            if (!is_dir($uploadDir)) {
            
                if (!mkdir($uploadDir, 0777, true)) {
                    die("Unable to create directory.");
                }
            }
            
            $fileNames = [
                'photo'           => 'student_photo',
                'signature'       => 'student_signature',
                'parentsignature' => 'father_signature',
                'family_photo'  => 'family_photo'
            ];
            
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $maxFileSize = 5 * 1024 * 1024; // 2 MB
            
            $fileNames = [
                'student_photo'     => 'prevPhoto',
                'student_signature' => 'prevSignature',
                'father_signature'  => 'prevParentSignature',
                'family_photo'      => 'prevFamilyPhoto'
            ];
            
            $data = [];
            
            foreach ($fileNames as $inputName => $prevField) {
            
                // Default : Previous file
                $data[$inputName] = $_POST[$prevField] ?? '';
            
                // New file uploaded
                if (
                    isset($_FILES[$inputName]) &&
                    $_FILES[$inputName]['error'] == 0
                ) {
            
                    $extension = strtolower(
                        pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION)
                    );
            
                    $newFileName = $appno . '_' . $inputName . '.' . $extension;
            
                    $targetFile = $uploadDir . '/' . $newFileName;
            
                    if (
                        move_uploaded_file(
                            $_FILES[$inputName]['tmp_name'],
                            $targetFile
                        )
                    ) {
                        $data[$inputName] = $newFileName;
                    }
                }
            }
            $sql1 = "
            UPDATE student_details SET
                s_photo             = '".$data['student_photo']."',
                s_signature         = '".$data['student_signature']."',
                s_parent_signature  = '".$data['father_signature']."',
                s_family_photo      = '".$data['family_photo']."',
                s_uploadeDate       = '".$regon."',
                s_uploadeBy         = '".$_SESSION['USER_NAME']."'
            WHERE s_id='".$studentID."'
            AND s_application_number='".$appno."'
            ";
                  // echo $sql1;exit;
            $result1=mysqli_query($conn,$sql1);
            if($result1){
                echo json_encode([
                    'status'  => 'success',
                    'message' => 'Student profile updloaded successfully',
                    'appno'    => $appno
                ]);
                exit;
            }else{
                echo json_encode([
                    'status'  => 'false',
                    'message' => 'student profile not updloaded,please try again..',
                ]);
                exit;
            }
        }else{
            echo json_encode([
                'status'  => 'exits',
                'message' => 'Application number is already exits.',
                'appno'    => $appno
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'student detail is missing.'
        ]);
        exit;
    }
    
}else if($request=='saveStudentAdmitCard' && $type=='Edit'){
     // --- 1. Get form data ---
    $studentID=$_POST['studentID'];
//print_r($_POST);exit;
    $appno            = insert_val($conn,$_POST['appno']);
    $firstname         = insert_val($conn,$_POST['firstname']);
    $admitcardstatus         = insert_val($conn,$_POST['admitcardstatus']);
    $admitcardDesc         = insert_val($conn,$_POST['desc']);
    $admitcardEmail         = insert_val($conn,$_POST['admitcardEmail']);
    if((isset($appno) && !empty($appno)) && (isset($firstname) && !empty($firstname)) && (isset($admitcardstatus) && !empty($admitcardstatus))
    ){
        $sql="SELECT * FROM student_details WHERE s_application_number='".$appno."'";
        $result=mysqli_query($conn,$sql);
        $numrows=mysqli_num_rows($result);
        $fetchArr=mysqli_fetch_array($result);
       
        if($numrows<=1){
            $sql = "SELECT s_admittedToken FROM student_details 
                    ORDER BY s_admittedToken DESC LIMIT 1";

            $result = mysqli_query($conn, $sql);
             
            $nextNo = 1000;
            
            if ($row = mysqli_fetch_array($result)) {
            
                $lastToken = $row['s_admittedToken'];
            
                //$parts = explode('-', $lastToken);
            
                if (!empty($lastToken)) {
                    $nextNo = $lastToken + 1;
                }else{
                    $nextNo = 1000;
                }
                //echo $nextNo;exit;
            }
            $toketdatetime=date('dmYHis');
            $tokenNumber = $nextNo;

            $sql1 = "UPDATE student_details SET
                s_admittedStatus='ISSUED',
                s_admittedToken  = '".$tokenNumber."',
                s_admittedDesc='".$admitcardDesc."',
                s_admitCardEmail='".$admitcardEmail."',
                s_toketdatetime='".$toketdatetime."',
                s_admittedDate       = '".$regon."',
                s_admittedBy         = '".$_SESSION['USER_NAME']."'
            WHERE s_application_number='".$appno."'";
                   //echo $sql1;exit;
            $result1=mysqli_query($conn,$sql1);
            if($result1){
                echo json_encode([
                    'status'  => 'success',
                    'message' => 'Student admit card successfully',
                    'appno'    => $appno
                ]);
                exit;
            }else{
                echo json_encode([
                    'status'  => 'false',
                    'message' => 'student admit card failed,please try again..',
                ]);
                exit;
            }
        }else{
            echo json_encode([
                'status'  => 'exits',
                'message' => 'Application number is already exits.',
                'appno'    => $appno
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'student detail is missing.'
        ]);
        exit;
    }
    
}else if($request=='checkApplicationNumberAlreadyExits'){
    
    $appno=insert_val($conn,$_POST['appno']);
    if(!empty($appno)){
        $sql="SELECT * FROM student_details WHERE s_application_number='".$appno."'";
        $result=mysqli_query($conn,$sql);
        $numrows= mysqli_num_rows($result);
        if($numrows > 0){
            echo 'already_exits';
        }else{
            echo 'true';
        }
    }else{
        echo 'empty';
    }
}else if($request=='deleteStudentEntry'){
     //print_r($_POST);exit;
    $id=insert_val($conn,$_POST['id']);
    $appno=insert_val($conn,$_POST['appno']);
    if(!empty($id) && !empty($appno)){
        $sql="UPDATE student_details SET s_status='Deleted' WHERE s_id='".$id."' AND s_application_number='".$appno."'";
       // echo $sql;
        $result=mysqli_query($conn,$sql);
        if($result){
            echo json_encode([
                'status'  => 'success',
                'message' => 'Student deleted successfully',
                'appno'    => $appno
            ]);
            exit;
        }else{
            echo json_encode([
                'status'  => 'false',
                'message' => 'student not deleted,please try again..',
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'student detail is missing.'
        ]);
        exit;
    }
}else if($request=='admitStudent'){
     //print_r($_POST);exit;
    $id=insert_val($conn,$_POST['id']);
    $appno=insert_val($conn,$_POST['appno']);
    if(!empty($id) && !empty($appno)){
        $sql="UPDATE student_details SET s_admittedStatus='ISSUED',s_admittedBy='".$_SESSION['USER_NAME']."',s_admittedDate='".$regon."' WHERE s_id='".$id."' AND s_application_number='".$appno."'";
       // echo $sql;
        $result=mysqli_query($conn,$sql);
        if($result){
            echo json_encode([
                'status'  => 'success',
                'message' => 'Student admitted successfully',
                'appno'    => $appno
            ]);
            exit;
        }else{
            echo json_encode([
                'status'  => 'false',
                'message' => 'student not admitted,please try again..',
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'student detail is missing.'
        ]);
        exit;
    }
}else if($request=='callStudentMobileVerification'){
     //print_r($_POST);exit;
    $id=insert_val($conn,$_POST['id']);
    $appno=insert_val($conn,$_POST['appno']);
    $scallStatus=insert_val($conn,$_POST['scallStatus']);
    $pcallStatus=insert_val($conn,$_POST['pcallStatus']);
    $remarks=insert_val($conn,$_POST['remarks']);
    if(!empty($id) && !empty($appno) && !empty($scallStatus) && !empty($pcallStatus) && !empty($remarks)){
        $sql="UPDATE student_details SET s_smobile_Status='$scallStatus',s_pmobile_Status='$pcallStatus',s_mobile_Desc='$remarks',s_mobile_cBy='".$_SESSION['USER_NAME']."',s_mobile_cDate='".$regon."' WHERE s_id='".$id."' AND s_application_number='".$appno."'";
       // echo $sql;
        $result=mysqli_query($conn,$sql);
        if($result){
            $sql1="INSERT INTO call_history SET c_applno='".$appno."',c_sStatus='$scallStatus',c_pStatus='$pcallStatus',c_remarks='$remarks',c_cBy='".$_SESSION['USER_NAME']."',c_cDate='".$regon."'";
            $result1=mysqli_query($conn,$sql1);
            echo json_encode([
                'status'  => 'success',
                'message' => 'Student Mobile Verification updated',
                'appno'    => $appno
            ]);
            exit;
        }else{
            echo json_encode([
                'status'  => 'false',
                'message' => 'student not verified,please try again..',
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'student detail is missing.'
        ]);
        exit;
    }
}else if($request=='reportStudent'){
     //print_r($_POST);exit;
    $id=insert_val($conn,$_POST['id']);
    $appno=insert_val($conn,$_POST['appno']);
    if(!empty($id) && !empty($appno)){
        $sql="UPDATE student_details SET s_reportedStatus='REPORTED',s_reportedcBy='".$_SESSION['USER_NAME']."',s_reportedcDate='".$regon."' WHERE s_id='".$id."' AND s_application_number='".$appno."'";
       // echo $sql;
        $result=mysqli_query($conn,$sql);
        if($result){
            echo json_encode([
                'status'  => 'success',
                'message' => 'Student reported successfully',
                'appno'    => $appno
            ]);
            exit;
        }else{
            echo json_encode([
                'status'  => 'false',
                'message' => 'student not reported,please try again..',
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'student detail is missing.'
        ]);
        exit;
    }
}else if($request=='approveStudentBagIssued'){
    $id=insert_val($conn,$_POST['id']);
    $appno=insert_val($conn,$_POST['appno']);
    $issuedStatus=insert_val($conn,$_POST['issuedStatus']);
    $description=insert_val($conn,$_POST['description']);
    if(!empty($id) && !empty($appno) && !empty($issuedStatus)){
        $sql="UPDATE student_details SET s_bagStatus='".$issuedStatus."',s_bagDesc='".$description."',s_bagDate='".$regon."',s_bagIssuedcBy='".$_SESSION['USER_NAME']."' WHERE s_id='".$id."' AND s_application_number='".$appno."'";
       // echo $sql;
        $result=mysqli_query($conn,$sql);
        if($result){
            echo json_encode([
                'status'  => 'success',
                'message' => 'Student bag issued successfully',
                'appno'    => $appno
            ]);
            exit;
        }else{
            echo json_encode([
                'status'  => 'false',
                'message' => 'student bag not issued,please try again..',
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'student detail is missing.'
        ]);
        exit;
    }
}else if($request=='approveStudentIDIssued'){
    $id=insert_val($conn,$_POST['id']);
    $appno=insert_val($conn,$_POST['appno']);
    $issuedStatus=insert_val($conn,$_POST['issuedStatus']);
    $description=insert_val($conn,$_POST['description']);
    if(!empty($id) && !empty($appno) && !empty($issuedStatus)){
        $sql="UPDATE student_details SET s_idcardStatus='".$issuedStatus."',s_idcardDesc='".$description."',s_idcardDate='".$regon."',s_idcardIssuedcBy='".$_SESSION['USER_NAME']."' WHERE s_id='".$id."' AND s_application_number='".$appno."'";
       // echo $sql;
        $result=mysqli_query($conn,$sql);
        if($result){
            echo json_encode([
                'status'  => 'success',
                'message' => 'Student ID card issued successfully',
                'appno'    => $appno
            ]);
            exit;
        }else{
            echo json_encode([
                'status'  => 'false',
                'message' => 'student ID card not issued,please try again..',
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'student detail is missing.'
        ]);
        exit;
    }
}else if($request=='approveStudentTshirt'){
    $id=insert_val($conn,$_POST['id']);
    $appno=insert_val($conn,$_POST['appno']);
    $issuedStatus=insert_val($conn,$_POST['issuedStatus']);
    $description=insert_val($conn,$_POST['description']);
    $tshirtSize=insert_val($conn,$_POST['tshirtSize']);
    if(!empty($id) && !empty($appno) && !empty($issuedStatus)){
        $sql="UPDATE student_details SET s_tshirtStatus='".$issuedStatus."',s_tshirtSize='".$tshirtSize."',s_tshirtDesc='".$description."',s_tshirtDate='".$regon."',s_tshirtIssuedcBy='".$_SESSION['USER_NAME']."' WHERE s_id='".$id."' AND s_application_number='".$appno."'";
       // echo $sql;
        $result=mysqli_query($conn,$sql);
        if($result){
            echo json_encode([
                'status'  => 'success',
                'message' => 'Student T-Shirt issued successfully',
                'appno'    => $appno
            ]);
            exit;
        }else{
            echo json_encode([
                'status'  => 'false',
                'message' => 'student T-Shirt not issued,please try again..',
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'student detail is missing.'
        ]);
        exit;
    }
}else if($request=='saveUserTypePermission'){
   
    $usertTypeId = $_POST['userType_id'] ?? '';
    $access      = $_POST['access'] ?? [];
    
    $privilage = [];
    
    foreach($access as $value)
    {
        $privilage[$value] = 'Y';
    }
    
    if(!empty($usertTypeId))
    {
        $sql = "UPDATE user_type
                SET ut_prev='".json_encode($privilage)."'
                WHERE ut_id='$usertTypeId'";
        $result = mysqli_query($conn,$sql);
    
        if($result)
        {
            echo json_encode([
                'status'  => 'success',
                'message' => 'User Type Access Granted Successfully'
            ]);
            exit;
        }
        else
        {
            echo json_encode([
                'status'  => 'error',
                'message' => mysqli_error($conn)
            ]);
            exit;
        }
    }
    else
    {
        echo json_encode([
            'status'  => 'error',
            'message' => 'User Type ID is missing.'
        ]);
        exit;
    }
}else if($request=='approveStudentWelcomeKit'){
    //print_r($_POST);exit;
    $id=insert_val($conn,$_POST['id']);
    $appno=insert_val($conn,$_POST['appno']);
    $tshirtSize=insert_val($conn,$_POST['tshirtSize']);
    $tShirtIssuedStatus=insert_val($conn,$_POST['tShirtIssuedStatus']);
    $bagIssuedStatus=insert_val($conn,$_POST['bagIssuedStatus']);
    $description=insert_val($conn,$_POST['description']);
    if(!empty($id) && !empty($appno) && !empty($tShirtIssuedStatus)){
        $sql="UPDATE student_details SET s_tshirtStatus='".$tShirtIssuedStatus."',s_tshirtSize='".$tshirtSize."',s_tshirtDesc='".$description."',s_tshirtDate='".$regon."',s_tshirtIssuedcBy='".$_SESSION['USER_NAME']."',s_bagStatus='".$bagIssuedStatus."',s_bagDesc='".$description."',s_bagDate='".$regon."',s_bagIssuedcBy='".$_SESSION['USER_NAME']."' WHERE s_id='".$id."' AND s_application_number='".$appno."'";
       // echo $sql;
        $result=mysqli_query($conn,$sql);
        if($result){
            echo json_encode([
                'status'  => 'success',
                'message' => 'Student Welcome kit issued successfully',
                'appno'    => $appno
            ]);
            exit;
        }else{
            echo json_encode([
                'status'  => 'false',
                'message' => 'student Welcome kit not issued,please try again..',
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'student detail is missing.'
        ]);
        exit;
    }
    
}
else if($request=='searchStudent')
{
    $keyword = $_POST['keyword'];
    $cond1 = "s_status='1'";
                                                        
    if ($userType == 'Super Admin' || $headName == 'Others') {

        // Show all records
    }else if ($userType == 'Admin' || $headName == 'Others') {

        // Show all records
    } elseif (!empty($headName)) {
    
        $cond1 .= " AND s_admissionOwner='$headName'";
    
    } else {
    
        $cond1 .= " AND s_admissionOwner='$userName'";
    }
    $qry = mysqli_query(
        $conn,
        "SELECT
            s_application_number,
            s_first_name,
            s_last_name
        FROM student_details
        WHERE $cond1 AND 
            s_application_number LIKE '%$keyword%'
            OR s_first_name LIKE '%$keyword%'
            OR s_last_name LIKE '%$keyword%'
        LIMIT 10"
    );

    while($row = mysqli_fetch_assoc($qry))
    {
?>
        <a href="javascript:void(0)"
           class="list-group-item student-item"
           data-appno="<?php echo $row['s_application_number']; ?>">

            <?php echo $row['s_application_number']; ?>
            -
            <?php echo $row['s_first_name']; ?>
            <?php echo $row['s_last_name']; ?>

        </a>
<?php
    }
}else if($request=='saveManualStudentEntry'){
    //print_r($_POST);exit;
    $appno=insert_val($conn,$_POST['appno']);
    $firstname=insert_val($conn,$_POST['first_name']);
    $lastname=insert_val($conn,$_POST['last_name']);
    $gender=insert_val($conn,$_POST['gender']);
    $course_type=insert_val($conn,$_POST['applicant_type']);
    if($course_type=='REGULAR'){
        $industry=insert_val($conn,$_POST['industry']);
        $admit_email=insert_val($conn,$_POST['admit_email']);
    }else{
        $industry='';
        $admit_email='';
    }
    $dept=insert_val($conn,$_POST['dept']);
    $admission_head=insert_val($conn,$_POST['admission_head']);
    if(!empty($appno) && !empty($firstname) && !empty($lastname) && !empty($gender) && !empty($course_type) && !empty($dept) && !empty($admission_head) ){
        $sql1 = "INSERT INTO student_details SET 
            s_application_number = '$appno',
            s_first_name = '$firstname',
            s_last_name = '$lastname',
            s_gender = '$gender',
            s_department = '$dept',
            s_industryPartner = '$industry',
            s_course_type='$course_type',
            s_status = '1',
            s_reportedStatus='NOT REPORTED',
            s_bagStatus='NOT ISSUED',
            s_tshirtStatus='NOT ISSUED',
            s_idcardStatus='NOT ISSUED',
            s_smobile_Status='Not Verified',
            s_pmobile_Status='Not Verified',
            s_admittedStatus='NOT ISSUED',
            s_admitCardEmail='$admit_email',
            s_hosStatus='NOT REPORTED',
            s_stu_verified='NOT VERIFIED',
            s_admissionOwner='$admission_head'";
        $result=mysqli_query($conn,$sql1);
        if($result){
            echo json_encode([
                'status'  => 'success',
                'message' => 'Student Added successfully',
                'appno'    => $appno
            ]);
            exit;
        }else{
            echo json_encode([
                'status'  => 'false',
                'message' => 'student not added,please try again..',
            ]);
            exit;
        }
        
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'student detail is missing.'
        ]);
        exit;
    }
}
