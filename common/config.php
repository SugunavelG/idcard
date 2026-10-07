<?php

ini_set('display_errors',false);
ini_set('memory_limit', '1024M');
ini_set('error_reporting', E_ALL ^ E_NOTICE);
ini_set('session.bug_compat_42',1);
ini_set('session.bug_compat_warm',0);
ini_set('max_execution_time', 80000);
ini_set('upload_max_filesize', '500M');
ini_set('post_max_size', '500M');
ini_set('max_input_time', -1);
ini_set('max_execution_time', -1);
date_default_timezone_set("Asia/Kolkata");
define('SECRET_KEY', 'AVIT2026_SECRET_KEY');

$regon = date("Y-m-d H:i:s");
$conn=mysqli_connect("localhost", "avcampus_idcard", "W24]ZjSaRaRQ0B29", "avcampus_idcard") or die("Couldn't connet to SQL server");
 
function query($conn){
	$conn = $conn or die("Couldn't connet to SQL server");
	return $conn;
}

function qBegin(){
	query('BEGIN');
}
function qCommit(){
	query('COMMIT');
}
function qRollback(){
	query('ROLLBACK');
}
function insert_val($conn, $input) {
    // Remove leading/trailing whitespace
    $trimmed_input = trim($input);

    // Escape special characters for use in SQL
    $sanitized_input = mysqli_real_escape_string($conn, $trimmed_input);

    // Return sanitized value
    return $sanitized_input;
}
function encryptId($id)
{
    $encrypted = openssl_encrypt(
        $id,
        'AES-128-ECB',
        SECRET_KEY
    );

    return urlencode(base64_encode($encrypted));
}

function decryptId($encryptedId)
{
    $decoded = base64_decode(urldecode($encryptedId));

    return openssl_decrypt(
        $decoded,
        'AES-128-ECB',
        SECRET_KEY
    );
}

  function convertDateTime($dateValue)
{
    if (!empty($dateValue)) {
        $dateValue = str_replace('.', ':', $dateValue);

        $date = DateTime::createFromFormat('d-m-Y H:i', $dateValue);

        if ($date) {
            return $date->format('d-m-Y h:i A');
        }
    }
    return '';
}
?>