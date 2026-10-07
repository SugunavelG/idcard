<?php
session_start();
if (empty($_SESSION['USER_ID']) && empty($_SESSION['USER_NAME'])) {
    header("Location: ../index.php");
    exit();
}
include '../common/config.php';

// Get filter parameters (GET or POST)
$category      = $_GET['category'] ?? '';
$admissionHead = $_GET['admissionHead'] ?? '';
$deptID        = $_GET['dept'] ?? '';
$industry        = $_GET['industry'] ?? '';
$applicant_type       = $_GET['applicant_type'] ?? '';
$date = $_GET['date'] ?? '';

if (!empty($date)) {
    $date = date('Y-m-d', strtotime($date));
}
$cond1 = "";

if (!empty($applicant_type) && !empty($category)) {
    
     if ($category == 'REPORTED') {

        $cond1 = "AND s_reportedStatus='REPORTED'";

        if (!empty($admissionHead)) {
            $cond1 .= " AND s_admissionOwner='" . insert_val($conn, $admissionHead) . "'";
        }

        if (!empty($deptID)) {
            $cond1 .= " AND s_department='" . insert_val($conn, $deptID) . "'";
        }
        if (!empty($industry)) {
            $cond1 .= " AND s_industryPartner='" . insert_val($conn, $industry) . "'";
        }
        if (!empty($date)) {
            $cond1 .= " AND DATE(s_reportedcDate)='" . insert_val($conn, $date) . "'";
        }
        
        if (!empty($applicant_type)) {
            $cond1 .= " AND s_course_type='" . insert_val($conn, $applicant_type) . "'";
        }

    } 
    else if ($category == 'ID CARD ISSUED') {

        $cond1 = "AND s_reportedStatus='REPORTED'
                  AND s_idcardStatus='ISSUED'";

        if (!empty($admissionHead)) {
            $cond1 .= " AND s_admissionOwner='" . insert_val($conn, $admissionHead) . "'";
        }

        if (!empty($deptID)) {
            $cond1 .= " AND s_department='" . insert_val($conn, $deptID) . "'";
        }
        if (!empty($industry)) {
            $cond1 .= " AND s_industryPartner='" . insert_val($conn, $industry) . "'";
        }
        if (!empty($date)) {
            $cond1 .= " AND DATE(s_idcardDate)='" . insert_val($conn, $date) . "'";
        }
         if (!empty($applicant_type)) {
            $cond1 .= " AND s_course_type='" . insert_val($conn, $applicant_type) . "'";
        }

    } elseif ($category == 'BAG ISSUED') {

        $cond1 = "AND s_reportedStatus='REPORTED'
                  AND s_bagStatus='ISSUED'";

        if (!empty($admissionHead)) {
            $cond1 .= " AND s_admissionOwner='" . insert_val($conn, $admissionHead) . "'";
        }

        if (!empty($deptID)) {
            $cond1 .= " AND s_department='" . insert_val($conn, $deptID) . "'";
        }
        if (!empty($industry)) {
            $cond1 .= " AND s_industryPartner='" . insert_val($conn, $industry) . "'";
        }
        if (!empty($date)) {
            $cond1 .= " AND DATE(s_bagDate)='" . insert_val($conn, $date) . "'";
        }
         if (!empty($applicant_type)) {
            $cond1 .= " AND s_course_type='" . insert_val($conn, $applicant_type) . "'";
        }

    } elseif ($category == 'T-SHIRT ISSUED') {

        $cond1 = "AND s_reportedStatus='REPORTED'
                  AND s_tshirtStatus='ISSUED'";

        if (!empty($admissionHead)) {
            $cond1 .= " AND s_admissionOwner='" . insert_val($conn, $admissionHead) . "'";
        }

        if (!empty($deptID)) {
            $cond1 .= " AND s_department='" . insert_val($conn, $deptID) . "'";
        }
        if (!empty($industry)) {
            $cond1 .= " AND s_industryPartner='" . insert_val($conn, $industry) . "'";
        }
        if (!empty($date)) {
            $cond1 .= " AND DATE(s_tshirtDate)='" . insert_val($conn, $date) . "'";
        }
         if (!empty($applicant_type)) {
            $cond1 .= " AND s_course_type='" . insert_val($conn, $applicant_type) . "'";
        }

    } elseif ($category == 'ADMIT CARD ISSUED') {

        $cond1 = "AND s_reportedStatus='REPORTED'
                AND s_admittedStatus='ISSUED'";

        if (!empty($admissionHead)) {
            $cond1 .= " AND s_admissionOwner='" . insert_val($conn, $admissionHead) . "'";
        }

        if (!empty($deptID)) {
            $cond1 .= " AND s_department='" . insert_val($conn, $deptID) . "'";
        }
        if (!empty($industry)) {
            $cond1 .= " AND s_industryPartner='" . insert_val($conn, $industry) . "'";
        }
        if (!empty($date)) {
            $cond1 .= " AND DATE(s_admittedDate)='" . insert_val($conn, $date) . "'";
        }
         if (!empty($applicant_type)) {
            $cond1 .= " AND s_course_type='" . insert_val($conn, $applicant_type) . "'";
        }

    } elseif ($category == 'HOSTEL REPORTED') {

        $cond1 = "AND s_reportedStatus='REPORTED'
                  AND s_hosStatus='REPORTED'";

        if (!empty($admissionHead)) {
            $cond1 .= " AND s_admissionOwner='" . insert_val($conn, $admissionHead) . "'";
        }

        if (!empty($deptID)) {
            $cond1 .= " AND s_department='" . insert_val($conn, $deptID) . "'";
        }
        if (!empty($industry)) {
            $cond1 .= " AND s_industryPartner='" . insert_val($conn, $industry) . "'";
        }
        if (!empty($date)) {
            $cond1 .= " AND DATE(s_hos_cDate)='" . insert_val($conn, $date) . "'";
        }
         if (!empty($applicant_type)) {
            $cond1 .= " AND s_course_type='" . insert_val($conn, $applicant_type) . "'";
        }

    } else {

        $cond1 = "AND s_reportedStatus='REPORTED'";
    }
}
$sql = "SELECT * 
        FROM student_details
        LEFT JOIN department ON dept_id=s_department
        LEFT JOIN blood_group ON bg_id=s_blood_group
        LEFT JOIN hostel ON h_id=s_h_id
        LEFT JOIN room_category ON rc_id=s_rc_id
        LEFT JOIN state ON st_id=s_state
        WHERE s_status = '1' $cond1
        ORDER BY s_id DESC";

$result = mysqli_query($conn, $sql);
$totCount = mysqli_num_rows($result);

// Set headers to force Excel download
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="Student_Report_'.date('Y-m-d').'.xls"');
header('Cache-Control: max-age=0');

// Start HTML table output (Excel can read HTML tables)
echo '<html><head><meta charset="UTF-8"></head><body>';
?>

<style>
    .subHead { 
        font-weight:bold; 
        font-size:20px; 
        text-align:center; 
    }
    table { 
        border-collapse: collapse; 
        width:100%; 
    }
    th, td { 
        border:1px solid #000; 
        padding:5px; 
    }
</style>

<table>
    <tr>
        <td colspan="17" style="text-align:center;">
            <strong class="subHead"><?php echo htmlspecialchars($category ? $category . ' Issued' : 'Student'); ?> Report</strong>
        </td>
    </tr>
    <thead>
        <tr>
            <th>#</th>
            <th>Application No</th>
            <th>First Name</th>
            <th>Last Name</th>
             <th>Gender</th>
             
            <th>Department</th>
             <th>Industry Partner</th>
           
            <?php if($category=='REPORTED'){ ?>
            <th>Reported Status</th>
            <th>Reported Date</th>
            <?php } ?>
            
            <th>Student Type</th>
            <?php if($category=='HOSTEL REPORTED'){ ?>
            <th>Hostel Name</th>
            <th>Room Category</th>
            <th>Room No</th>
            <th>Hostel Payment Status</th>
            <th>Hostel Check-In </th>
            <th>Hostel Check-In Date </th>
            <?php } ?>
            <?php if($category=='ID CARD ISSUED'){ ?>
            <th>ID Card Verified Status</th>
            <th>ID Card Verified Date</th>
            <th>ID Card Issued Status</th>
            <th>ID Card Issued Date</th>
            <?php } ?>
            <?php if($category=='BAG ISSUED'){ ?>
            <th>Bag Status</th>
            <th>Bag Issued Date</th>
            <?php } ?>
            <?php if($category=='T-SHIRT ISSUED'){ ?>
            <th>T-shirt Status</th>
            <th>T-shirt Issued Date</th>
            <?php } ?>
             <?php if($category=='ADMIT CARD ISSUED'){ ?>
            <th>Admit Card Status</th>
            <th>Admit card Issued Date</th>
            <?php } ?>
            <th>Student Owner</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if ($totCount > 0) {
        $sno = 1;
        while ($row = mysqli_fetch_assoc($result)) {

$reportedDate = (!empty($row['s_reportedcDate']) &&
                 $row['s_reportedcDate'] != '0000-00-00' &&
                 $row['s_reportedcDate'] != '0000-00-00 00:00:00' &&
                 strtotime($row['s_reportedcDate']) !== false)
    ? date('d-m-Y', strtotime($row['s_reportedcDate']))
    : '-';

$idcardDate = (!empty($row['s_idcardDate']) &&
               $row['s_idcardDate'] != '0000-00-00' &&
               $row['s_idcardDate'] != '0000-00-00 00:00:00' &&
               strtotime($row['s_idcardDate']) !== false)
    ? date('d-m-Y', strtotime($row['s_idcardDate']))
    : '-';
    
$idcardVerrifiedDate = (!empty($row['s_stu_verifiedDate']) &&
               $row['s_stu_verifiedDate'] != '0000-00-00' &&
               $row['s_stu_verifiedDate'] != '0000-00-00 00:00:00' &&
               strtotime($row['s_stu_verifiedDate']) !== false)
    ? date('d-m-Y', strtotime($row['s_stu_verifiedDate']))
    : '-';

$bagDate = (!empty($row['s_bagDate']) &&
            $row['s_bagDate'] != '0000-00-00' &&
            $row['s_bagDate'] != '0000-00-00 00:00:00' &&
            strtotime($row['s_bagDate']) !== false)
    ? date('d-m-Y', strtotime($row['s_bagDate']))
    : '-';

$tshirtDate = (!empty($row['s_tshirtDate']) &&
               $row['s_tshirtDate'] != '0000-00-00' &&
               $row['s_tshirtDate'] != '0000-00-00 00:00:00' &&
               strtotime($row['s_tshirtDate']) !== false)
    ? date('d-m-Y', strtotime($row['s_tshirtDate']))
    : '-';

$verifiedDate = (!empty($row['s_cDate']) &&
                 $row['s_cDate'] != '0000-00-00' &&
                 $row['s_cDate'] != '0000-00-00 00:00:00' &&
                 strtotime($row['s_cDate']) !== false)
    ? date('d-m-Y', strtotime($row['s_cDate']))
    : '-';

$checkInDate = (!empty($row['s_hos_checkIn_cDate']) &&
                $row['s_hos_checkIn_cDate'] != '0000-00-00' &&
                $row['s_hos_checkIn_cDate'] != '0000-00-00 00:00:00' &&
                strtotime($row['s_hos_checkIn_cDate']) !== false)
    ? date('d-m-Y', strtotime($row['s_hos_checkIn_cDate']))
    : '-';

$admitCardDate = (!empty($row['s_admittedDate']) &&
                  $row['s_admittedDate'] != '0000-00-00' &&
                  $row['s_admittedDate'] != '0000-00-00 00:00:00' &&
                  strtotime($row['s_admittedDate']) !== false)
    ? date('d-m-Y', strtotime($row['s_admittedDate']))
    : '-';

            $fullname = $row['s_first_name'].' '.$row['s_last_name'];
            echo "<tr>";
            echo "<td>" . $sno++ . "</td>";
            echo "<td>" . htmlspecialchars($row['s_application_number']) . "</td>";
            echo "<td>" . htmlspecialchars($row['s_first_name']) . "</td>";
             echo "<td>" . htmlspecialchars($row['s_last_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['s_gender']) . "</td>";
            echo "<td>" . htmlspecialchars($row['dept_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['s_industryPartner']) . "</td>";
           
            if($category=='REPORTED'){ 
            echo "<td>" . htmlspecialchars($row['s_reportedStatus']) . "</td>";
            echo "<td>" . htmlspecialchars($reportedDate) . "</td>";
            }
            
            // echo "<td>" . htmlspecialchars($verifiedDate) . "</td>";
            echo "<td>" . htmlspecialchars($row['s_stu_type']) . "</td>";
            if($category=='HOSTEL REPORTED'){ 
            echo "<td>" . htmlspecialchars($row['h_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['rc_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['s_hos_roomno']) . "</td>";
            echo "<td>" . htmlspecialchars($row['s_hosPaymentStatus']) . "</td>";
            echo "<td>" . htmlspecialchars($row['s_hos_checkIn_status']) . "</td>";
            echo "<td>" . htmlspecialchars($checkInDate) . "</td>";
            }
            if($category=='ID CARD ISSUED'){
                echo "<td>" . htmlspecialchars($row['s_stu_verified']) . "</td>";
             echo "<td>" . htmlspecialchars($idcardVerrifiedDate) . "</td>";
             echo "<td>" . htmlspecialchars($row['s_idcardStatus']) . "</td>";
            echo "<td>" . htmlspecialchars($idcardDate) . "</td>";
            }
            if($category=='BAG ISSUED'){
            echo "<td>" . htmlspecialchars($row['s_bagStatus']) . "</td>";
            echo "<td>" . htmlspecialchars($bagDate) . "</td>";
            }
             if($category=='T-SHIRT ISSUED'){ 
            echo "<td>" . htmlspecialchars($row['s_tshirtStatus']) . "</td>";
            echo "<td>" . htmlspecialchars($tshirtDate) . "</td>";
             }
            if($category=='ADMIT CARD ISSUED'){
            echo "<td>" . htmlspecialchars($row['s_admittedStatus']) . "</td>";
            echo "<td>" . htmlspecialchars($admitCardDate) . "</td>";
            }
            echo "<td>" . htmlspecialchars($row['s_admissionOwner']) . "</td>";
            echo "</tr>";
            
        }
    } else {
        echo "<tr><td colspan='17' style='text-align:center;color:red;'>No Records Found</td></tr>";
    }
    ?>
    </tbody>
    <?php
    $countSql = "SELECT COUNT(*) AS total
             FROM student_details
             WHERE s_status='1' $cond1";

            $countResult = mysqli_query($conn, $countSql);
            $countRow = mysqli_fetch_assoc($countResult);
            $totalCount = $countRow['total'];
            
            echo "<tfoot>";
            echo "<tr>";
            echo "<th colspan='43' style='text-align:center;'>Total Students : " . $totalCount . "</th>";
            echo "</tr>";
            echo "</tfoot>";
echo "</table>";


echo '</body></html>';
exit;
?>