<?php

ini_set('post_max_size','2000M');
ini_set('upload_max_filesize','2000M');
ini_set('max_execution_time',6000000000000);
ini_set('max_input_time',6000000000000);
ini_set('memory_limit', '512M');


$dbh1 = mysqli_connect("localhost", "tenderkhabar_admin", "Dummy@007", "tenderkhabar_prod");

// Check connection
if (!$dbh1) {
    die("Connection failed: " . mysqli_connect_error());
}
$dbh2 = mysqli_connect("localhost", "tenderkhabar_admin", "Dummy@007", "tenderkhabar_prod");
// Check connection
if (!$dbh2) {
    die("Connection failed: " . mysqli_connect_error());
}
function custom_real_escape_string($field) {
    $data = mysqli_real_escape_string($GLOBALS["dbh1"],$field);
    //echo $data;die();
    return $data;
}
?>
