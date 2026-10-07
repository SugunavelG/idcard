<?php

include '../common/config.php';

$name   = mysqli_real_escape_string($conn, $_POST['name']);
$email  = mysqli_real_escape_string($conn, $_POST['email']);
$mobile = mysqli_real_escape_string($conn, $_POST['mobile']);

$sql = "INSERT INTO students(name,email,mobile)
        VALUES('$name','$email','$mobile')";

if(mysqli_query($conn,$sql))
{
    // MySQL Auto Increment ID
    $id = mysqli_insert_id($conn);

    $url = "https://script.google.com/macros/s/AKfycbyE_qPzpKndyukmL33j8YxST7glBZLBnbihdBNtekRuJ0DiT_A-dheMoFhSqDRdSTpK/exec";

    $data = array(
        "action" => "insert",
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

    echo $result;
    header("Location:list.php");
exit;
}
else
{
    echo mysqli_error($conn);
}

?>