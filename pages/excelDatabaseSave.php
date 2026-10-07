<?php
include '../common/config.php';

if (isset($_POST['upload'])) {

    if ($_FILES['excel_file']['error'] != 0) {
        die("File upload failed.");
    }

    $extension = strtolower(pathinfo($_FILES['excel_file']['name'], PATHINFO_EXTENSION));

    if ($extension != 'csv') {
        die("Please upload CSV file only.");
    }

    $file = $_FILES['excel_file']['tmp_name'];

    if (($handle = fopen($file, "r")) !== FALSE) {

        $row = 0;
        $success = 0;
        $failed = 0;

        while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {

            // Skip Header
            if ($row == 0) {
                $row++;
                continue;
            }

            $appno   = mysqli_real_escape_string($conn, $data[0] ?? '');
            $firstname  = mysqli_real_escape_string($conn, $data[1] ?? '');
            $lastname = mysqli_real_escape_string($conn, $data[2] ?? '');
            $coursetype = mysqli_real_escape_string($conn, $data[3] ?? '');
            $department = mysqli_real_escape_string($conn, $data[4] ?? '');
            $industry = mysqli_real_escape_string($conn, $data[5] ?? '');
            $admitCardEmail = mysqli_real_escape_string($conn, $data[6] ?? '');
            $admissionOwner = mysqli_real_escape_string($conn, $data[7] ?? '');

            $created_at = $data[3] ?? '';

            if ($created_at != '') {
                $created_at = str_replace('.', ':', $created_at);
                $created_at = date('Y-m-d H:i:s', strtotime($created_at));
            } else {
                $created_at = NULL;
            }

            if ($name == '') {
                $row++;
                continue;
            }

            $sql = "INSERT INTO student_details_testupload(s_application_number='".$appno."',s_first_name='".$firstname."',s_last_name='".$lastname."',course_type='".$coursetype."',s_department='".$department."',s_industryPartner='".$industry."',s_reportedStatus='NOT REPORTED',s_idcardStatus='NOT ISSUED',s_smobile_Status='Not Verified',s_pmobile_Status='Not Verified',s_tshirtStatus='NOT ISSUED',s_bagStatus='NOT ISSUED',s_admittedStatus='NOT ISSUED's_admitCardEmail='".$admitCardEmail."',s_hosStatus='NOT REPORTED',s_admissionOwner='".$admissionOwner."',s_stu_verified='NOT VERIFIED'";

            if (mysqli_query($conn, $sql)) {
                $success++;
            } else {
                $failed++;
                echo "Row ".($row+1)." Error : ".mysqli_error($conn)."<br>";
            }

            $row++;
        }

        fclose($handle);

        echo "Upload Completed<br>";
        echo "Success : ".$success."<br>";
        echo "Failed : ".$failed;
    }
}
?>