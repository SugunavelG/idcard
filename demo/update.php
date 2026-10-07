<?php

include '../common/config.php';

$id     = mysqli_real_escape_string($conn, $_POST['id']);
$name   = mysqli_real_escape_string($conn, $_POST['name']);
$email  = mysqli_real_escape_string($conn, $_POST['email']);
$mobile = mysqli_real_escape_string($conn, $_POST['mobile']);

// Update MySQL
$sql = "UPDATE students
        SET
            name='$name',
            email='$email',
            mobile='$mobile'
        WHERE id='$id'";

if(mysqli_query($conn,$sql))
{
    // Google Apps Script URL
    $url = "https://script.google.com/macros/s/AKfycbyE_qPzpKndyukmL33j8YxST7glBZLBnbihdBNtekRuJ0DiT_A-dheMoFhSqDRdSTpK/exec";

    // Data to Google Sheet
    $data = array(
    "action" => "update",
    "id"     => $id,
    "name"   => $name,
    "email"  => $email,
    "mobile" => $mobile
);

    $options = array(
        "http" => array(
            "header"  => "Content-Type: application/json",
            "method"  => "POST",
            "content" => json_encode($data)
        )
    );

    $context = stream_context_create($options);

    $result = file_get_contents($url, false, $context);

    if($result == "Success")
    {
        echo "Database and Google Sheet Updated Successfully";
        header("Location:list.php");
exit;
    }
    else
    {
        echo "Database Updated, but Google Sheet Error: ".$result;
    }

}
else
{
    echo "Database Error : ".mysqli_error($conn);
}

?>