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

include '../common/header.php'; 
?>
<style>
    label.error, span.error {
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
        display: block;
    }
    .dt-buttons .btn {
        margin-right: 5px;
    }
    .action-icons a {
        margin: 0 3px;
        font-size: 18px;
        color: #6c757d;
        transition: 0.2s;
    }
    .action-icons a:hover {
        color: #0d6efd;
    }
    .action-icons a.delete-btn:hover {
        color: #dc3545;
    }
</style>

<!-- DataTables CSS & Buttons CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<!-- Font Awesome for icons -->
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
                                <form action="#" method="POST" id="searchReportId">
                                     <div class="col-lg-12">   
                                        <div class="row">
                                           <div class="col-lg-2">
                                                <label class="form-label">
                                                    Applicant Type <sup class="text-danger">*</sup>
                                                </label>
                                                <select class="form-control" id="applicant_type" name="applicant_type">
                                                    <option value="">--Select Filtter--</option>
                                                    <option value='REGULAR'>REGULAR</option>
                                                    <option value='WORKING PROFESSIONAL'>WORKING PROFESSIONAL</option>
                                                   
                                                </select>
                                            </div> 
                                             <div class="col-lg-2">
                                                <label class="form-label">
                                                    Category <sup class="text-danger">*</sup>
                                                </label>
                                                <select class="form-control" id="category" name="category">
                                                    <option value="">--Select Filtter--</option>
                                                    <option value='REPORTED'>REPORTED</option>
                                                    <option value='ADMIT CARD ISSUED'>ADMIT CARD ISSUED</option>
                                                    <option value='ID CARD ISSUED'>ID CARD ISSUED</option>
                                                    <option value='BAG ISSUED'>BAG ISSUED</option>
                                                    <option value='T-SHIRT ISSUED'>T-SHIRT ISSUED</option>
                                                    <option value='HOSTEL REPORTED'>HOSTEL REPORTED</option>
                                                    <option value='DEPARTMENT SUMMARY'>DEPARTMENT SUMMARY</option>
                                                    <option value='INDUSTRY PARTNERS SUMMARY'>INDUSTRY PARTNERS SUMMARY</option>
                                                </select>
                                            </div> 
                                            <div class="col-lg-3">
                                                <label class="form-label">
                                                    Admission Head <sup class="text-danger">*</sup>
                                                </label>
                                                <select class="form-control" id="admissionHead" name="admissionHead">
                                                    <option value="">--Select Head--</option>
                                                    <option value='Dr.P.Karthikeyan'>Dr.P.Karthikeyan</option>
                                                    <option value='Mrs.S.Noorjahan'>Mrs.S.Noorjahan</option>
                                                    <option value='Mr.CS.Vijay Kumar'>Mr.CS.Vijay Kumar</option>
                                                </select>
                                            </div> 
                                            <div class="mb-2 col-lg-3">
                                                <label class="form-label">
                                                    Department <sup class="text-danger">*</sup>
                                                </label>
                                                <select class="form-select form-control" id="dept" name="dept" <?php echo $disabled; ?> required>
                                                    <option value="">Select Department</option>
                                                    <?php
                                                    $deptQry = mysqli_query($conn, "SELECT dept_id, dept_name FROM department WHERE dept_status='1' ORDER BY dept_name ASC");
                                                    while($row = mysqli_fetch_assoc($deptQry))
                                                    {
                                                    ?>
                                                        <option value="<?php echo $row['dept_id']; ?>"
                                                            <?php if(isset($dept) && $dept == $row['dept_id']) echo 'selected'; ?>>
                                                            <?php echo htmlspecialchars($row['dept_name']); ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="form-label">
                                                    Industry Partners <sup class="text-danger">*</sup>
                                                </label>
                                                <select class="form-control" id="industry" name="industry">
                                                    <option value="">--Select Industry Partners--</option>
                                                    <option value='AMTZ'>AMTZ</option>
                                                    <option value='BVERSITY'>BVERSITY</option>
                                                    <option value='HCL TECH'>HCL TECH</option>
                                                    <option value='INTEL NEC'>INTEL NEC</option>
                                                    <option value='MEDINI'>MEDINI</option>
                                                    <option value='POWERED BY HCL'>POWERED BY HCL</option>
                                                </select>
                                            </div> 
                                            <div class="col-lg-3">
                                                <label class="form-label">
                                                    Date <sup class="text-danger">*</sup>
                                                </label>
                                                <input type="date" class="form-control" id="date" name="date" />
                                            </div> 
                                            <div class="col-lg-2">
                                                <!--<label class="form-label">-->
                                                <!--            Search <sup class="text-danger">*</sup>-->
                                                <!--        </label>--><br>
                                                <button type="button" id="searchBtn" class="btn btn-primary" onclick="search_val();" disabled>
                                                    <i class="fa-solid fa-magnifying-glass"></i> Search
                                                </button>
                                            </div>
                                             <?php if(isset($prev['88'])=='Y'){ ?>
                                            <div class="col-lg-2">
                                                <label class="form-label">
                                                            Download <sup class="text-danger">*</sup>
                                                        </label>
                                                <button type="button" id="excelBtn" class="btn btn-success" onclick="excel_fun();" disabled>
                                                    <i class="fa-solid fa-file-excel"></i> Excel Download
                                                </button>
                                            </div>
                                            <?php } ?>
                                        </div>  
                                    </div>                 
                                </form>  
                            </div>
                        </div>
                        <!-- [ breadcrumb ] end -->
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Students Over All Report List</h5>
                                    </div>
                                    <div class="card-body table-border-style">
                                        <div class="table-responsive" id="tableContainer">
                                            <table id="studentTable" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Application No</th>
                                                        <th>Full Name</th>
                                                        <th>Gender</th>
                                                        <th>Department</th>
                                                          <th>Applicant Type</th>
                                                        <th>Industry Partners</th>
                                                        <th>Admission Head</th>
                                                        
                                                        <th>Action</th> <!-- NEW -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql = "SELECT * 
                                                            FROM student_details 
                                                            LEFT JOIN department ON dept_id=s_department
                                                            WHERE s_status='1' AND s_reportedStatus='REPORTED'
                                                            ORDER BY s_id DESC";
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
                                                        
                                                        <td class="action-icons">
                                                            <!-- View -->
                                                             <?php if(isset($prev['87'])=='Y'){ ?>
                                                             <a href="studentProfile.php?id=<?php echo encryptId($id); ?>&appno=<?php echo encryptId($appno); ?>&type=View&redirect=studentOverAllReportList"
                                                                   title="View" class="text-white">
                                                                <button class="btn btn-warning btn-sm">
                                                                    <i class="fas fa-user text-white"></i> Profile
                                                                </button>
                                                            </a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- [ Main Content ] end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- [ Main Content ] end -->

<!-- DataTables JS & Buttons -->
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

<script>
$(document).ready(function () {

    function toggleButtons() {

        var applicant_type = $('#applicant_type').val();
        var category = $('#category').val();

        if (applicant_type !== '' && category !== '') {
            $('#searchBtn, #excelBtn').prop('disabled', false);
        } else {
            $('#searchBtn, #excelBtn').prop('disabled', true);
        }
    }

    // When Applicant Type changes
    $('#applicant_type').on('change', function () {
        toggleButtons();
    });

    // When Category changes
    $('#category').on('change', function () {
        toggleButtons();
    });

    // Page load
    toggleButtons();

});
$(document).ready(function () {
    // Initially disable
//   $(document).ready(function () {

//     // Initially disable
//     $('#admissionHead').prop('disabled', true);
//     $('#dept').prop('disabled', true);
//     $('#industry').prop('disabled', true);
//     $('#searchBtn').prop('disabled', true);
//     $('#excelBtn').prop('disabled', true);

//     $('#category').on('change', function () {

//         if ($(this).val() !== "") {

//             $('#admissionHead').prop('disabled', false);
//             $('#dept').prop('disabled', false);
//             $('#industry').prop('disabled', false);
//             $('#searchBtn').prop('disabled', false);
//             $('#excelBtn').prop('disabled', false);

//         } else {

//             $('#admissionHead').val('').prop('disabled', true);
//             $('#dept').val('').prop('disabled', true);
//             $('#industry').val('').prop('disabled', true);

//             $('#searchBtn').prop('disabled', true);
//             $('#excelBtn').prop('disabled', true);
//         }

//     });

// });
    
    // Initialize DataTable with action column
    $('#studentTable').DataTable({
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
    
    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');
        let appno = $(this).data('appno');
        let fullname = $(this).data('fullname');
        $('#modalAppNo').text(appno);
        $('#modalFullName').text(fullname);
        // Store ID in delete button
        $('#confirmDeleteBtn').data('id', id);
        $('#confirmDeleteBtn').data('appno', appno);
        $('#deleteModal').modal('show');
    });

});

function search_val() {
    $.ajax({
        url: './studentOverAllReportAjaxList.php',
        data: $("#searchReportId").serialize(),
        type: 'post',
        success: function(data) {
            // data is the full table HTML (including <table>)
            console.log(data);

            // Destroy existing DataTable if any
            if ($.fn.DataTable.isDataTable('#studentTable')) {
                $('#studentTable').DataTable().destroy();
            }

            // Replace the entire container content with the new table
            $('#tableContainer').html(data);

            // Re-initialize DataTable on the new table
            $('#studentTable').DataTable();
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
        }
    });
}

function excel_fun(){   
     window.open('./studentOverAllReportXLDownload.php?'+$("#searchReportId").serialize());
}
</script>