<?php
include '../common/config.php';

if(!isset($_GET['id'])){
    die("ID not found");
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM students WHERE id='$id'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result)==0){
    die("Record not found");
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body>

<h2>Edit Student</h2>

<form action="update.php" method="post">

<input type="hidden" name="id" value="<?php echo $row['id']; ?>">

Name:<br>
<input type="text" name="name" value="<?php echo $row['name']; ?>" required>
<br><br>

Email:<br>
<input type="email" name="email" value="<?php echo $row['email']; ?>" required>
<br><br>

Mobile:<br>
<input type="text" name="mobile" value="<?php echo $row['mobile']; ?>" required>
<br><br>

<input type="submit" value="Update">

</form>

</body>
</html>