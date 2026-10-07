<?php
include '../common/config.php';

$sql = "SELECT * FROM students ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student List</title>

    <style>

    table{
        border-collapse:collapse;
        width:100%;
    }

    table,th,td{
        border:1px solid #000;
        padding:10px;
        text-align:left;
    }

    a{
        text-decoration:none;
        padding:5px 10px;
    }

    .edit{
        background:green;
        color:#fff;
    }

    .delete{
        background:red;
        color:#fff;
    }

    .add{
        background:blue;
        color:#fff;
        padding:10px;
    }

    </style>

</head>

<body>

<h2>Student List</h2>

<a href="index.php" class="add">Add New Student</a>

<br><br>

<table>

<tr>

<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Mobile</th>
<th>Action</th>

</tr>

<?php

if(mysqli_num_rows($result)>0)
{

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['name']; ?></td>

<td><?php echo $row['email']; ?></td>

<td><?php echo $row['mobile']; ?></td>

<td>

<a class="edit"
href="edit.php?id=<?php echo $row['id']; ?>">
Edit
</a>

<a class="delete"
href="delete.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Are you sure you want to delete this record?');">
Delete
</a>

</td>

</tr>

<?php

}

}
else
{

?>

<tr>

<td colspan="5" align="center">

No Records Found

</td>

</tr>

<?php

}

?>

</table>

</body>
</html>