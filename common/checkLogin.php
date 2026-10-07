<?php
session_start();
require_once 'config.php';

$request=$_GET['request'];
if($request=='checkLoginCredentials'){
    
    $username=insert_val($conn,$_POST['username']);
    $password=insert_val($conn,$_POST['password']);
    if((isset($username) && !empty($username)) && (isset($password) && !empty($password))){
        $sql="SELECT * FROM users WHERE u_username='".$username."' AND u_password='".$password."'";
         
        $result=mysqli_query($conn,$sql);
        $numrows=mysqli_num_rows($result);
        $fetchArr=mysqli_fetch_array($result);
        
        if($numrows>0){
            //if (password_verify($password, $hashed_password)) {
    	        $_SESSION['USER_ID']=$fetchArr['id'];
    	        $_SESSION['USER_NAME']=$fetchArr['u_name'];
    	        $_SESSION['USERNAME']=$fetchArr['u_name'];
    	        $_SESSION['USER_TYPE_ID']=$fetchArr['u_ut_type'];
    	        $_SESSION['USER_HEAD_NAME']=$fetchArr['u_headName'];
    	        echo json_encode([
                    'status'  => 'success',
                    'message' => 'Login successful! Redirecting…',
                    'user'    => $user['username']
                ]);
                exit;
            // }else{
            //     echo 'invalid';
            // }
        }else{
            echo json_encode([
                'status'  => 'error',
                'message' => 'Invalid username or password.'
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'status'  => 'empty',
            'message' => 'Username or Password is empty.'
        ]);
        exit;
    }
    
}