<?php 
   session_start();
   include '../common/config.php';
   require '../vendor/autoload.php';

//use PhpOffice\PhpSpreadsheet\IOFactory;
//   if(empty($_SESSION['USER_ID']) && empty($_SESSION['USER_NAME'])){
//       header("Location: ../index.php");
//         exit();
//   }else{
//         $sql="SELECT * FROM user_type WHERE ut_id='".$_SESSION['USER_TYPE_ID']."'";
//         $result=mysqli_query($conn,$sql);
//         $numrows=mysqli_num_rows($result);
//         $fetchArr=mysqli_fetch_array($result);
//         $prev=json_decode($fetchArr['ut_prev'],true);
//     }
   
//   include '../common/header.php'; 
   ?>
   <!DOCTYPE html>
<html>
<head>
    <title>Excel Upload</title>
</head>
<body>

<form action="excelDatabaseSave.php" method="post" enctype="multipart/form-data">
    
    <input type="file" name="excel_file" accept=".csv" required>

    <button type="submit" name="upload">Upload</button>

</form>

</body>
</html>