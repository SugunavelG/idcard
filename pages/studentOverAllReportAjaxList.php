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

$category      = $_POST['category'] ?? '';
$admissionHead = $_POST['admissionHead'] ?? '';
$deptID        = $_POST['dept'] ?? '';
$industry        = $_POST['industry'] ?? '';
$applicant_type= $_POST['applicant_type'] ?? '';
$date = $_POST['date'] ?? '';

if (!empty($date)) {
    $date = date('Y-m-d', strtotime($date));
}
$cond1 = "";
//print_r($date);
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
 
?>
<table id="studentTable" class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Application No</th>
            <th>Full Name</th>
            <th>Gender</th>
            <th>Department</th>
            <th>Applicant Type</th>
            <th>Industry Partner</th>
            <th>Admission Head</th>
            <?php if($category=='REPORTED'){ ?>
            <th>Reported Status</th>
            <th>Reported Date</th>
            <?php } ?>
            <?php if($category=='ADMIT CARD ISSUED'){ ?>
            <th>Admit Card Status</th>
            <th>Admit Card Date</th>
            <?php } ?>
             <?php if($category=='ID CARD ISSUED'){ ?>
            <th>ID Card Status</th>
            <th>ID Card Date</th>
            <?php } ?>
             <?php if($category=='T-SHIRT ISSUED'){ ?>
            <th>T-Shirt Card Status</th>
            <th>T-Shirt Date</th>
            <?php } ?>
             <?php if($category=='BAG ISSUED'){ ?>
            <th>Bag Card Status</th>
            <th>Bag Date</th>
            <?php } ?>
            <?php if($category=='HOSTEL REPORTED'){ ?>
            <th>Hostel Status</th>
            <th>Hostel Reported Date</th>
            <?php } ?>
            <th >Action</th> <!-- NEW -->
        </tr>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT * 
                FROM student_details 
                 LEFT JOIN department ON dept_id=s_department
                WHERE s_status='1' $cond1
                ORDER BY s_id DESC";
                //echo $sql;
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0){
                $i = 1;
                while($value = mysqli_fetch_assoc($result)){
                    $id = $value['s_id'];
                    $appno = $value['s_application_number'];
                    $fullname = $value['s_first_name'].' '.$value['s_last_name'];
                    $idCardIssuedDate = $value['s_idcardDate'];
                    $bagIssuedDate = $value['s_bagDate'];
                    $tshirtIssuedDate = $value['s_tshirtDate'];
                    $reportedcDate=(!empty($value['s_reportedcDate']) &&
                          $value['s_reportedcDate'] != '0000-00-00' &&
                          $value['s_reportedcDate'] != '0000-00-00 00:00:00')
                        ? date('d-m-Y h:i A', strtotime($value['s_reportedcDate']))
                        : '';
                    $admittedDate=(!empty($value['s_admittedDate']) &&
                          $value['s_admittedDate'] != '0000-00-00' &&
                          $value['s_admittedDate'] != '0000-00-00 00:00:00')
                        ? date('d-m-Y h:i A', strtotime($value['s_admittedDate']))
                        : '';
                    $idcardDate=(!empty($value['s_idcardDate']) &&
                          $value['s_idcardDate'] != '0000-00-00' &&
                          $value['s_idcardDate'] != '0000-00-00 00:00:00')
                        ? date('d-m-Y h:i A', strtotime($value['s_idcardDate']))
                        : '';
                    $tshirtDate=(!empty($value['s_tshirtDate']) &&
                          $value['s_tshirtDate'] != '0000-00-00' &&
                          $value['s_tshirtDate'] != '0000-00-00 00:00:00')
                        ? date('d-m-Y h:i A', strtotime($value['s_tshirtDate']))
                        : '';
                    $bagDate=(!empty($value['s_bagDate']) &&
                          $value['s_bagDate'] != '0000-00-00' &&
                          $value['s_bagDate'] != '0000-00-00 00:00:00')
                        ? date('d-m-Y h:i A', strtotime($value['s_bagDate']))
                        : '';
                    $hosReportedDate=(!empty($value['s_hos_cDate']) &&
                          $value['s_hos_cDate'] != '0000-00-00' &&
                          $value['s_hos_cDate'] != '0000-00-00 00:00:00')
                        ? date('d-m-Y h:i A', strtotime($value['s_hos_cDate']))
                        : '';
        ?>
        <tr>
            <td><?php echo $i++; ?></td>
            
            <td><?php echo htmlspecialchars($value['s_application_number']); ?></td>
            <td><?php echo htmlspecialchars($fullname); ?></td>
             <td>
               <?php echo $value['s_gender']; ?>
            </td>
            <td>
               <?php echo $value['dept_code']; ?>
            </td>
            <td>
               <?php echo $value['s_course_type']; ?>
            </td>
            <td>
               <?php echo $value['s_industryPartner']; ?>
            </td>
            <td>
                <?php echo $value['s_admissionOwner']; ?>
            </td>
            <?php if($category=='REPORTED'){ ?>
             <td>
                <?php echo $value['s_reportedStatus']; ?>
            </td>
             <td>
                <?php echo $reportedcDate; ?>
            </td>
            <?php } ?>
            <?php if($category=='ADMIT CARD ISSUED'){ ?>
             <td>
                <?php echo $value['s_admittedStatus']; ?>
            </td>
             <td>
                <?php echo $admittedDate; ?>
            </td>
            <?php } ?>
             <?php if($category=='ID CARD ISSUED'){ ?>
             <td>
                <?php echo $value['s_idcardStatus']; ?>
            </td>
            <td>
                <?php echo $idcardDate; ?>
            </td>
             <?php } ?>
             <?php if($category=='T-SHIRT ISSUED'){ ?>
            <td>
                <?php echo $value['s_tshirtStatus']; ?>
            </td>
            <td>
                <?php echo $tshirtDate; ?>
            </td>
             <?php } ?>
             <?php if($category=='BAG ISSUED'){ ?>
            <td>
                <?php echo $value['s_bagStatus']; ?>
            </td>
            <td>
                <?php echo $bagDate; ?>
            </td>
             <?php } ?>
            <?php if($category=='HOSTEL REPORTED'){ ?>
            <td>
                <?php echo $value['s_hosStatus']; ?>
            </td>
            <td>
                <?php echo $hosReportedDate; ?>
            </td>
            <?php } ?>
             <td class="action-icons">
                <?php if(isset($prev['87'])=='Y'){ ?>
                <button class="btn btn-warning btn-sm">
                    <a href="studentProfile.php?id=<?php echo encryptId($id); ?>&appno=<?php echo encryptId($appno); ?>&type=View&redirect=studentOverAllReportList" title="View" class="text-white">
                        <i class="fas fa-eye text-warning"></i>
                    </a>
                </button>
                <?php } ?>
            </td>
        </tr>
        <?php
            }
        }
        ?>
    </tbody>
    <tfooter>
        <?php
        $countSql = "SELECT COUNT(*) AS total
             FROM student_details
             WHERE s_status='1' $cond1";

        $countResult = mysqli_query($conn, $countSql);
        $countRow = mysqli_fetch_assoc($countResult);
        
        $totalCount = $countRow['total'];
        ?>
        <tr>
            <th colspan="43" class="text-center">
                Total Students : <?php echo $totalCount; ?>
            </th>
        </tr>
    </tfooter>
</table>
                                             
<script>
$(document).ready(function () {
    // Initialize DataTable with action column
    $('#example1').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        language: {
            emptyTable: "No Records Found"
        },
        columnDefs: [
            { orderable: false, targets: [0, 1] }
        ]
    });
});
</script>