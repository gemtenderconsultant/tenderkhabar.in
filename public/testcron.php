<?php
$posts = array();
echo $datetime = date('Y-m-d H:i:s');
die();


$posts[] = array('id'=> "1", 'name'=> $ismail, 'time'=> $datetime); 
$fp = fopen('test2.txt', 'w');
fwrite($fp, json_encode($posts));
fclose($fp);

?>