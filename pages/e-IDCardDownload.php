<?php
session_start();
include './config/config.php';

//print_r($_GET);exit;
$appno=$_GET['appno'];
//print_r($appno);
//$bdId=$_GET['arg'];
//$bdSubId=$_GET['bdSubId'];
$sql="SELECT *,DATE_FORMAT(txn_date,'%d-%m-%Y %h:%i %p') as regDate FROM avit_2025_application WHERE app_no='".$appno."'";
 
$result=mysqli_query($conn,$sql);
$totCount=mysqli_num_rows($result);
$fetchArr = mysqli_fetch_array($result);
  
$tenth='https://avcampusadmissions.com/avit/2025/smart-application/uploads/tenth/'.$fetchArr['tenth'];
$twelth='https://avcampusadmissions.com/avit/2025/smart-application/uploads/twelth/'.$fetchArr['twelth'];
$ug='https://avcampusadmissions.com/avit/2025/smart-application/uploads/ug/'.$fetchArr['ug'];
 
$photo='https://avcampusadmissions.com/avit/2025/smart-application/uploads/photo/'.$fetchArr['photo'];
$signature='https://avcampusadmissions.com/avit/2025/smart-application/uploads/signature/'.$fetchArr['signature'];
require_once './dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
$dompdf = new Dompdf();
$dompdf->set_option('isRemoteEnabled', TRUE);
    
$html = '';

// Begin HTML content
$html = '';

// Begin HTML content
$html .= '<!DOCTYPE html>';
$html .= '<html lang="en">';
$html .= '<head>';
$html .= '    <meta charset="UTF-8">';
$html .= '    <meta http-equiv="X-UA-Compatible" content="IE=edge">';
$html .= '    <meta name="viewport" content="width=device-width, initial-scale=1.0">';
$html .= '    <title>VMRF SMART 2025-26 Scholarship Examination</title>';
$html .= '    <link href="https://www.avit.ac.in/img/favicon.ico" rel="shortcut icon">';
$html = <<<HTML
<style>

label.error,
span.error{
    color:#dc3545;
    font-size:14px;
    margin-top:5px;
    display:block;
}

.dt-buttons .btn{
    margin-right:5px;
}

.action-icons a{
    margin:0 3px;
    font-size:18px;
    color:#6c757d;
    transition:.2s;
}

.action-icons a:hover{
    color:#0d6efd;
}

.action-icons a.delete-btn:hover{
    color:#dc3545;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

.id-card{
    width:770px;
    height:940px;
    background:#fff;
    display:flex;
    overflow:hidden;
    border:1px solid #ddd;
}

.left-strip{
    width:155px;
    background:#244992;
    display:flex;
    justify-content:center;
    align-items:center;
}

.left-strip span{
    writing-mode:vertical-rl;
    transform:rotate(180deg);
    color:#fff;
    font-size:70px;
    font-weight:bold;
    letter-spacing:2px;
}

.content{
    flex:1;
    position:relative;
    padding:35px 25px;
}

.header{
    display:flex;
    align-items:center;
}

.logo img{
    width:570px;
}

.batch{
    display:inline-block;
    margin-top:25px;
    background:#234a93;
    color:#fff;
    font-size:48px;
    font-weight:bold;
    padding:10px 18px;
}

.photo-box{
    margin-top:20px;
    width:365px;
    height:390px;
    border:5px solid #234a93;
    display:flex;
    justify-content:center;
    align-items:center;
}

.photo-box img{
    width:98%;
    height:98%;
    object-fit:cover;
}

.student-type{
    position:absolute;
    top:440px;
    left:390px;
    width:78px;
    height:78px;
    color:#fff;
    border-radius:0 18px 18px 0;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:42px;
    font-weight:bold;
}

.student-type.hosteller{
    background:#e53935;
}

.student-type.dayscholar{
    background:#4FC3F7;
}

.student-type.transport{
    background:#234a93;
}

.hosteller-text{
    color:#e53935;
}

.dayscholar-text{
    color:#4FC3F7;
}

.transport-text{
    color:#002147;
}

.hosteller-bg{
    background:#e53935;
}

.dayscholar-bg{
    background:#4FC3F7;
}

.transport-bg{
    background:#234a93;
}

.student-details{
    margin-top:30px;
    width:90%;
}

.student-name{
    font-size:36px;
    color:#234a93;
    font-weight:bold;
    text-transform:uppercase;
    margin-bottom:10px;
}

.course{
    font-size:22px;
    color:#222;
    font-weight:600;
    line-height:1.5;
    margin-bottom:8px;
}

.regno{
    font-size:20px;
    color:#444;
    font-weight:bold;
}

.principal{
    position:absolute;
    bottom:0;
    right:30px;
    width:220px;
    text-align:center;
}

.principal img{
    width:120px;
}

.principal h4{
    margin-top:8px;
    font-size:18px;
    color:#234a93;
    border-top:2px solid #234a93;
    padding-top:6px;
    width:140px;
    margin:auto;
}

.right-design{
    position:absolute;
    right:0;
    bottom:0;
    width:70px;
    height:50%;
}

.back-card{
    width:770px;
    height:940px;
    background:#fff;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    border:1px solid #ccc;
}

.details{
    padding:50px 30px 20px;
}

.row{
    display:table;
    width:100%;
    margin-bottom:15px;
    color:#244992;
    font-size:28px;
}

.label{
    display:table-cell;
    width:185px;
    font-weight:500;
}

.colon{
    display:table-cell;
    width:20px;
}

.value{
    display:table-cell;
}

.footer{
    background:#244992;
    color:#fff;
    text-align:center;
    padding:40px 20px;
}

.footer h2{
    font-size:48px;
    margin-bottom:25px;
}

.footer p{
    font-size:18px;
    line-height:1.5;
    margin-bottom:30px;
}

.validity{
    color:#fff;
    font-size:22px;
    font-weight:bold;
}

</style>
HTML;
$html .= '</head>';
$html .= '<body>';
 $html .= '
<div class="id-card">

    <div class="left-strip">
        <span>STUDENT IDENTITY CARD</span>
    </div>

    <div class="content">

        <div class="header">
            <div class="college logo">
                <img src="https://avcampusadmissions.com/idcard/assets/logo/AVITLogowhite.png" alt="AVIT Logo">
            </div>
        </div>

        <div class="batch">
            Batch '.$batch.'
        </div>

        <div class="photo-box">
            <img src="../uploads/students/'.$photo.'" alt="Student Photo">
        </div>

        <div class="student-type '.$studentTypeClass.'">
            <label>'.$label.'</label>
        </div>

        <div class="student-details">

            <h2 class="student-name">'.$fullname.'</h2>

            <p class="course">
                '.$dept.'
            </p>

        </div>

        <div class="principal">

            <img src="principal-sign.png" alt="Principal Signature">

            <h4>PRINCIPAL</h4>

        </div>

        <img src="../assets/images/rightbar.jpg" class="right-design">

    </div>

</div>

<br>

<div class="back-card">

    <div class="details">

        <div class="row">
            <span class="label">Date of Birth</span>
            <span class="colon">:</span>
            <span class="value">'.$dob.'</span>
        </div>

        <div class="row">
            <span class="label">Blood Group</span>
            <span class="colon">:</span>
            <span class="value">'.$bld_grp.'</span>
        </div>

        <div class="row address">
            <span class="label">Address</span>
            <span class="colon">:</span>
            <span class="value">'.$address.'</span>
        </div>

        <div class="row">
            <span class="label">Contact</span>
            <span class="colon">:</span>
            <span class="value">+91 '.$mobile.'</span>
        </div>

        <div class="row">
            <span class="label">Emergency Contact</span>
            <span class="colon">:</span>
            <span class="value">+91 '.$alterMobile.'</span>
        </div>

    </div>

    <div class="footer">

        <h2 class="'.$studentTypeTextClass.'">'.$stuType.'</h2>

        <p>
            AARUPADAI VEEDU INSTITUTE OF TECHNOLOGY<br>
            Vinayaka Nagar, Rajiv Gandhi Salai<br>
            (Old Mahabalipuram Road) Paiyanoor,<br>
            Chennai-603104
        </p>

        <div class="validity '.$studentTypeBgClass.'">
            This Identity Card Is Valid till 31 Dec 2026
        </div>

    </div>

</div>
';
$html .= '</body>';
$html .= '</html>';

$html .= '<!DOCTYPE html>';
$html .= '<html lang="en">';
$html .= '<head>';
$html .= '    <meta charset="UTF-8">';
$html .= '    <meta http-equiv="X-UA-Compatible" content="IE=edge">';
$html .= '    <meta name="viewport" content="width=device-width, initial-scale=1.0">';
$html .= '    <title>VMRF SMART 2025-26 Scholarship Examination</title>';

$html .= '</head>';
$html .= '<body>';
$html .= '    <div class="container">';
$html .= '        <div class="header">';
$html .= '            <img src="https://avcampusadmissions.com/avit/2025/smart-application/assets/images/avit-logo.png" alt="AVIT" style="float:left !important;width:200px !important;" class="custom-img">';
$html .= '            <img src="https://avcampusadmissions.com/aems/assets/images/vmrf.png" alt="VMRF" style="float:right !important;width:200px !important;" class="custom-img-right">';
$html .= '          <div class="invoice-details" >';
$html .= '            <h2><u>VMRF SMART 2025-26 Scholarship Examination</u></h2>';
$html .= '            <p><strong>Application Number:</strong> '.$fetchArr['app_no'].'</p>';
$html .= '            <p><strong>Application Date & Time:</strong> '.$fetchArr['regDate'] . '</p>';
$html .= '          </div>';
$html .= '        </div>';

$html .= '        <div class="section">';
$html .= '            <h2>Programme Details</h2>';
$html .= '            <div><span class="label" style="width: 350px; display: inline-block;">Slot</span>:  '.$fetchArr['slot'].'</div>';
$html .= '            <div><span class="label" style="width: 350px; display: inline-block;">Branch of Study</span>:  '.$fetchArr['bos'].'</div>';
$html .= '            <div><span class="label" style="width: 350px; display: inline-block;">Subjects Studied in class 12<sup>th</sup></span>:  '.$fetchArr['school_group'].'</div>';
$html .= '            <div><span class="label" style="width: 350px; display: inline-block;">Board of Examination</span>:  '.$fetchArr['boe'].'</div>';
$html .= '            <div><span class="label" style="width: 350px; display: inline-block;">Medium of Instruction</span>:  '.$fetchArr['moi'].'</div>';
$html .= '        </div>';

$html .= '        <div class="section">';
$html .= '            <h2>Document Details</h2>';
$html .= '            <div><span class="label" style="width: 350px; display: inline-block;">10<sup>th</sup> Marksheet</span> : <a href="'.$tenth.'" target="_blank"><img src="'.$tenth.'" alt="10th Marksheet" style="max-width: 5%; height: auto;" /></a></div>';
$html .= '            <div><span class="label" style="width: 350px; display: inline-block;">12<sup>th</sup> Marksheet</span>:  <a href="'.$twelth.'" target="_blank"><img src="'.$twelth.'" alt="12th Marksheet" style="max-width: 5%; height: auto;" /></a></div>';
 
$html .= '            <div><span class="label" style="width: 350px; display: inline-block;">Photo</span>:  <a href="'.$photo.'" target="_blank"><img src="'.$photo.'" alt="photo Marksheet" style="max-width: 5%; height: auto;" /></a></div>';
$html .= '            <div><span class="label" style="width: 350px; display: inline-block;">Signature</span>:  <a href="'.$signature.'" target="_blank"><img src="'.$signature.'" alt="signature Marksheet" style="max-width: 5%; height: auto;" /></a></div>';
$html .= '        </div>';

$html .= '        <div class="section">';
$html .= '            <h2>Payment Details</h2>';
$html .= '            <div><span class="label" style="width: 350px; display: inline-block;">Payment Amount</span>:  '.$fetchArr['txn_amount'].'</div>';
$html .= '            <div><span class="label" style="width: 350px; display: inline-block;">Payment Status</span>:  '.$fetchArr['txn_status'].'</div>';
$html .= '            <div><span class="label" style="width: 350px; display: inline-block;">Transaction Id</span>:  '.$fetchArr['txn_id'].'</div>';
$html .= '            <div><span class="label" style="width: 350px; display: inline-block;">Transaction Date&Time</span>:  '.$fetchArr['txn_date'].'</div>';
$html .= '        </div>';

$html .= '      <div class="footer">';
$html .= '         <p>&copy; 2025 AVIT | VMRF SMART 2025-26 Scholarship Examination</p>';
$html .= '     </div>';
$html .= '    </div>';
$html .= '</body>';
$html .= '</html>';

      //exit;   
$dompdf->loadHtml($html);

$customPaper = array(0,0,1000,1000);
$dompdf->set_paper($customPaper);
//$dompdf->setPaper('A4', 'L');
/* Render the HTML as PDF */
$dompdf->render();
/* Output the generated PDF to Browser */
$dompdf->stream("VMRF SMART 2025-26 Scholarship Examination -".$fetchArr['app_no'].".pdf");
?>
<script>
setTimeout(function() {
    window.location.href = "view.php?appno=<?php echo $fetchArr['app_no']; ?>";
}, 5000); // 5 seconds
</script>
<!--sleep(10);-->
<!--header("Location: view.php?appno=".$fetchArr['app_no']); -->
<!--exit; -->
     ?>
 