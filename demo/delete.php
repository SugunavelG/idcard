<?php

include '../common/config.php';

$id = $_GET['id'];

// Delete from MySQL
$sql = "DELETE FROM students WHERE id='$id'";

if(mysqli_query($conn,$sql))
{
    // Google Apps Script URL
    $url = "https://script.google.com/macros/s/AKfycbyE_qPzpKndyukmL33j8YxST7glBZLBnbihdBNtekRuJ0DiT_A-dheMoFhSqDRdSTpK/exec";

    $data = array(
        "action" => "delete",
        "id"     => $id
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

    header("Location:list.php");
    exit;
}
else
{
    echo "Database Error : ".mysqli_error($conn);
}

?>