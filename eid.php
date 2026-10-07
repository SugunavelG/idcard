<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student ID Card</title>
    <style>
        *{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
    background:#eee;
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

.college{
    margin-left:15px;
}

.college h1{
    font-size:140px;
    color:#222343;
    line-height:1;
}

.college p{
    color:#444;
    font-size:28px;
}

.college h2{
    color:#293a84;
    font-size:34px;
    margin-top:5px;
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

.blood-group{
    position:absolute;
    top:440px;
    left:390px;
    width:78px;
    height:78px;
    background:#234a93;
    color:#fff;
    border-radius:0 18px 18px 0;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:42px;
    font-weight:bold;
}

/* Student Details */

.student-details {
    margin-top: 30px;
    width: 90%;
    text-align: left;
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

/* Principal */



.principal img{
    width:180px;
    height:auto;
    object-fit:contain;
}

.principal h4{
    margin-top:5px;
    font-size:20px;
    color:#234a93;
    letter-spacing:1px;
}
.right-design{
    position: absolute;
    right: 0;
    bottom: 0;
    width: 70px;
    height: 50%;
}
.principal{
    position:absolute;
    bottom:0px;
    right:30px;

    width:220px;          /* 50% size */
    text-align:center;
}

.principal img{
    width:120px;          /* Signature size */
    height:auto;
    display:block;
    margin:0 auto;
}

.principal h4{
    margin-top:8px;
    font-size:18px;
    color:#234a93;
    font-weight:bold;
    border-top:2px solid #234a93;
    padding-top:6px;
    width:140px;
    margin-left:auto;
    margin-right:auto;
}
    </style>
</head>
<body>
<div class="container">
<div class="id-card">

    <!-- Left Vertical Strip -->
    <div class="left-strip">
        <span>STUDENT IDENTITY CARD</span>
    </div>

    <!-- Main Content -->
    <div class="content">

        <!-- Header -->
        <div class="header">
            <!--<div class="logo">-->
            <!--    <img src="https://avcampusadmissions.com/idcard/assets/logo/AVITLogowhite.png" alt="AVIT Logo">-->
            <!--</div>-->

            <div class="college logo">
                 <img src="https://avcampusadmissions.com/idcard/assets/logo/AVITLogowhite.png" alt="AVIT Logo">
            </div>
        </div>

        <!-- Batch -->
        <div class="batch">
            Batch 2025 -26
        </div>

        <!-- Photo -->
        <div class="photo-box">
            <img src="photo4.jpg" alt="Student Photo">
        </div>

        <!-- Blood Group -->
        <div class="blood-group">
            D
        </div>
        
        <!-- Student Details -->
        <div class="student-details">
        
            <h2 class="student-name">JOHN DOE</h2>
        
            <p class="course">
                B.E. COMPUTER SCIENCE AND ENGINEERING
            </p>
        
            <!--<p class="regno">-->
            <!--    Reg No : 1234567890-->
            <!--</p>-->
        
        </div>
        
        <!-- Principal Signature -->
        <div class="principal">
        
            <img src="principal-sign.png" alt="Principal Signature">
        
            <h4>PRINCIPAL</h4>
        
        </div>
        <img src="rightbar.jpg" class="right-design">
    </div>

</div>
<style>
    *{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
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

/* Details */

.details{
    padding:50px 30px 20px;
}

.row{
    display:grid;
    grid-template-columns:150px 20px 1fr;
    margin-bottom:15px;
    color:#244992;
    font-size:28px;
    line-height:1.4;
}

.address{
    align-items:flex-start;
}

.label{
    font-weight:500;
    width: 161px;
}

.colon{
    text-align:center;
}

.value{
    color:#244992;
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
    font-weight:bold;
}

.footer p{

    font-size:18px;
    line-height:1.5;
    margin-bottom:30px;
    font-weight:600;
}

.validity{

    display:inline-block;
    background:#fff;
    color:#244992;

    padding:12px 18px;

    font-size:22px;
    font-weight:bold;

    border-radius:2px;
}
</style>
<div class="back-card">

    <div class="details">

        <div class="row">
            <span class="label">Date of Birth</span>
            <span class="colon">:</span>
            <span class="value">25.05.2009</span>
        </div>

        <div class="row">
            <span class="label">Blood Group</span>
            <span class="colon">:</span>
            <span class="value">A1 +Ve</span>
        </div>

        <div class="row address">
            <span class="label">Address</span>
            <span class="colon">:</span>
            <span class="value">
                #45, NSC Bose Road,<br>
                Triplicane,<br>
                Chennai - 600 000.
            </span>
        </div>

        <div class="row">
            <span class="label">Contact</span>
            <span class="colon">:</span>
            <span class="value">+91 00000 00000</span>
        </div>

        <div class="row">
            <span class="label">Emergency Contact</span>
            <span class="colon">:</span>
            <span class="value">+91 00000 00000</span>
        </div>

    </div>

    <div class="footer">

        <h2>Day Scholar</h2>

        <p>
            AARUPADAI VEEDU INSTITUTE OF TECHNOLOGY<br>
            Vinayaka Nagar, Rajiv Gandhi Salai<br>
            (Old Mahabalipuram Road) Paiyanoor,<br>
            Chennai-603104
        </p>

        <div class="validity">
            This Identity Card Is Valid till 31 Dec 2026
        </div>

    </div>

</div>
</div>
</body>
</html>