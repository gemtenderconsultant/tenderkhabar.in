<?php
include('config_mysqli.php');

$sqlu = "UPDATE `keyword` SET name=unhex(replace(hex(name),'C2A0','20'))";
$sqlu = "UPDATE `keyword` SET name=cast(unhex(replace(replace(replace(hex(name),'C2A9',''),'C2AE',''),'E284A2','')) AS char) as name";

$sql = "SELECT id,name FROM keyword";
$result = mysqli_query($dbh1, $sql);


//store the entire response
$response = array();

//the array that will hold the titles and links
$posts = array();


while($row = mysqli_fetch_assoc($result)) { //mysql_fetch_array($sql)

$id=$row['id']; 
$name=$row['name']; 

//each item from the rows go in their respective vars and into the posts array
$posts[] = array('id'=> $id, 'name'=> $name); 

} 

//the posts array goes into the response
//$response['posts'] = $posts;

//echo json_encode($posts);die();
//print_r($response);die();
//creates the file
$fp = fopen('keywords.json', 'w');
fwrite($fp, json_encode($posts));
fclose($fp);

// $fp = fopen('../../backend/web/keywords.json', 'w');
// fwrite($fp, json_encode($posts));
// fclose($fp);

?>
