<?php
include('config_mysqli.php');

$sqlu = "UPDATE `keyword` SET name=unhex(replace(hex(name),'C2A0','20'))";
$sqlu = "UPDATE `keyword` SET name=cast(unhex(replace(replace(replace(hex(name),'C2A9',''),'C2AE',''),'E284A2','')) AS char) as name";

$sql = "SELECT city.*,state.name as state_name FROM city LEFT JOIN state ON city.state_id=state.id ORDER BY city.name ASC";
$result = mysqli_query($dbh1, $sql);


//store the entire response
$response = array();

//the array that will hold the titles and links
$posts = array();


while($row = mysqli_fetch_assoc($result)) { //mysql_fetch_array($sql)

$id=$row['id']; 
$name=$row['name']; 
$stateid=$row['state_id']; 
$state_name = $row['state_name']; 
$name = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $name);
$state_name = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $state_name);
//each item from the rows go in their respective vars and into the posts array
$posts[] = array('id'=> $id, 'stateid'=> $stateid, 'statename'=> $state_name, 'name'=> $name); 

} 

//the posts array goes into the response
//$response['posts'] = $posts;

//echo json_encode($posts);die();
//print_r($response);die();
//creates the file
$fp = fopen('city.json', 'w');
fwrite($fp, json_encode($posts));
fclose($fp);

// $fp = fopen('../../backend/web/city.json', 'w');
// fwrite($fp, json_encode($posts));
// fclose($fp);

?>