<?php
include('config_mysqli.php');

$sqlu = "UPDATE `agency` SET agencyname=unhex(replace(hex(name),'C2A0','20'))";

//$sql = "SELECT agencyid,REPLACE(agencyname, '\’', '') as agencynamet,sector,LEFT (agencyname, 1) as sortname FROM agency WHERE verifiedby=0 ORDER BY LENGTH(agencyname) ASC LIMIT 7563,1";
$sql = 'SELECT agencyid,agencyname,sector,LEFT (agencyname, 1) as sortname FROM agency WHERE verifiedby=0 ORDER BY agencyname ASC'; //LENGTH(agencyname)
$result = mysqli_query($dbh1, $sql);


//store the entire response
$response = array();

//the array that will hold the titles and links
$posts = array();

while($row = mysqli_fetch_assoc($result)) { //mysql_fetch_array($sql)

$id = $row['agencyid']; 
$name = $row['agencyname']; 
$sortname = $row['sortname']; 
$sector = $row['sector']; 
//$name = str_replace("\’","",$name);
$name = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $name);
//each item from the rows go in their respective vars and into the posts array
$posts[] = array('id'=> $id, 'sortname'=> $sortname, 'sector'=> $sector, 'text'=> $name); 

} 
//print_r($posts);
//the posts array goes into the response
//$response['posts'] = $posts;

//echo json_encode($posts);die();
//print_r($response);die();
//creates the file
$fp = fopen('agency.json', 'w');
fwrite($fp, json_encode($posts));
fclose($fp);

// $fp = fopen('../../backend/web/agency.json', 'w');
// fwrite($fp, json_encode($posts));
// fclose($fp);
?>