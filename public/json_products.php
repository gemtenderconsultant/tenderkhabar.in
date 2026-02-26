<?php
include('config_mysqli.php');

$sqlu = "UPDATE `keyword` SET name=unhex(replace(hex(name),'C2A0','20'))";
$sqlu = "UPDATE `keyword` SET name=cast(unhex(replace(replace(replace(hex(name),'C2A9',''),'C2AE',''),'E284A2','')) AS char) as name";

$sql = "SELECT subcategory.*,category.name as categoryname,industry.name as industryname FROM `subcategory` LEFT JOIN category ON subcategory.categoryid=category.id LEFT JOIN industry ON category.industry_id=industry.id";
$result = mysqli_query($dbh1, $sql);


//store the entire response
$response = array();

//the array that will hold the titles and links
$posts = array();


while($row = mysqli_fetch_assoc($result)) { //mysql_fetch_array($sql)

$id=$row['id']; 
$name=$row['name']; 
$categoryid=$row['categoryid']; 
$categoryname=$row['categoryname']; 
$productid=$row['productid']; 
$productname = $row['industryname']; 

$name = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $name);
$categoryname = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $categoryname);
$productname = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $productname);
//each item from the rows go in their respective vars and into the posts array
$posts[] = array('subcategoryid'=> $id, 'subcategoryname'=> $name, 'categoryid'=> $categoryid, 'categoryname'=> $categoryname, 'productid'=> $productid, 'productname'=> $productname); 

} 

//the posts array goes into the response
//$response['posts'] = $posts;

//echo json_encode($posts);die();
//print_r($response);die();
//creates the file
$fp = fopen('products.json', 'w');
fwrite($fp, json_encode($posts));
fclose($fp);

// $fp = fopen('../../backend/web/products.json', 'w');
// fwrite($fp, json_encode($posts));
// fclose($fp);
?>