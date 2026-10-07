<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Countdown to Tomorrow 9:00 AM</title>

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
    height:100vh;
    background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
}

.card{
    width:420px;
    padding:35px;
    border-radius:20px;
    background:rgba(255,255,255,.08);
    backdrop-filter:blur(15px);
    text-align:center;
    color:#fff;
    box-shadow:0 15px 35px rgba(0,0,0,.4);
}

.card h1{
    font-size:28px;
    margin-bottom:10px;
}

.card p{
    color:#ddd;
    margin-bottom:25px;
}

.timer{
    display:flex;
    justify-content:space-between;
    gap:10px;
}

.box{
    flex:1;
    background:#ffffff15;
    border-radius:12px;
    padding:20px 10px;
}

.box span{
    display:block;
    font-size:40px;
    font-weight:bold;
    color:#00e5ff;
}

.box small{
    font-size:14px;
    color:#fff;
    letter-spacing:1px;
}
</style>

</head>
<body>

<div class="card">
    <h1>⏰ Tomorrow 9:30 AM</h1>    <p>Countdown Timer</p>

    <div class="timer">
        <div class="box">
            <span id="days">00</span>
            <small>Days</small>
        </div>

        <div class="box">
            <span id="hours">00</span>
            <small>Hours</small>
        </div>

        <div class="box">
            <span id="minutes">00</span>
            <small>Minutes</small>
        </div>

        <div class="box">
            <span id="seconds">00</span>
            <small>Seconds</small>
        </div>
    </div>
</div>

<script>
function updateCountdown(){

    const now = new Date();

    const target = new Date();
    target.setDate(now.getDate() + 1);
    target.setHours(9,30,0,0); // Tomorrow 9:30 AM

    const diff = target - now;

    if(diff <= 0){
        document.querySelector(".card h1").innerHTML = "🎉 Time Reached!";
        return;
    }

    const days = Math.floor(diff / (1000*60*60*24));
    const hours = Math.floor((diff % (1000*60*60*24)) / (1000*60*60));
    const minutes = Math.floor((diff % (1000*60*60)) / (1000*60));
    const seconds = Math.floor((diff % (1000*60)) / 1000);

    document.getElementById("days").innerHTML = String(days).padStart(2,'0');
    document.getElementById("hours").innerHTML = String(hours).padStart(2,'0');
    document.getElementById("minutes").innerHTML = String(minutes).padStart(2,'0');
    document.getElementById("seconds").innerHTML = String(seconds).padStart(2,'0');
}

updateCountdown();
setInterval(updateCountdown,1000);
</script>

</body>
</html>