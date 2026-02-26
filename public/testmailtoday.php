<?php
include('config_mysqli.php');
$todaydate = date('Y-m-d');

$sql1 = 'SELECT user.id as u_id,user.email,user.alt_email,user.status,user.name,user.company_name,userproduct.* from users as user LEFT JOIN userproduct on user.id=userproduct.user_id  where user.is_tender=1 and userproduct.todate>="' . $todaydate . '" and user.status="Paid"  group by user.id order by user.id asc';
//echo $sql1;die();
$my_users = mysqli_query($dbh2,$sql1);
 $total = mysqli_num_rows($my_users);

 echo "total clients ".$total;
$querychecksend = "SELECT * FROM userinfo WHERE  tender_date='$todaydate'";
$resultchk = mysqli_query($dbh2,$querychecksend);
echo "<br>sent ";
if ($resultchk) {
    if (mysqli_num_rows($resultchk) > 0) {
    echo mysqli_num_rows($resultchk);
    } else {
    echo 'not found';
    }
}