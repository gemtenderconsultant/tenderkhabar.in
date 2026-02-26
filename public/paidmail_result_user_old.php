<?php
//ini_set('memory_limit', '-1');
//list user and user product info

// include('config_mysqli.php');
// require_once "php_mailer/vendor/autoload.php";

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

// function email_phpmailer($emailid = array(), $subject, $body,$username,$password,$from,$fromname,$host){
//     $mail = new PHPMailer;
//     //Enable SMTP debugging.
//     $mail->SMTPDebug = 0;                           
//     //Set PHPMailer to use SMTP.
//     $mail->isSMTP();        
//     //Set SMTP host name                      
//     $mail->Host = $host;
//     //Set this to true if SMTP host requires authentication to send email
//     $mail->SMTPAuth = true;                      
//     //Provide username and password
//     $mail->Username = $username;             
//     $mail->Password = $password;            

//     //If SMTP requires TLS encryption then set it
//     //$mail->SMTPSecure = "tls";    //for gmail

//     //Set TCP port to connect to
//     $mail->Port = 587;                    
//     $mail->From = $from;
//     $mail->FromName = $fromname;
   
//     // $mail->addReplyTo('noreply@tenderkhabar.com', 'TenderKhabar');
//     $mail->addAddress($emailid[0], "");
//     foreach($emailid as $ek => $email)
//     {
//         if($ek != 0)
//         {
//           $mail->AddCC($email);
//         }
//     }
//     $mail->AddCC('tenderkhabar2@gmail.com'); // change
//     $mail->isHTML(true);
//     $mail->Subject = $subject;
//     $mail->Body = $body;
//     //$mail->AltBody = "This is the plain text version of the email content";
//     if(!$mail->send())
//     {
//     echo "Mailer Error: " . $mail->ErrorInfo;
//     }
//     else
//     {
//     echo "Message has been sent successfully";
//     }
// }
// //$monday = date( 'Y-m-d', strtotime( 'monday this week' ) );


// $logourl = "https://tenderkhabar.in/assets/img/logo.png";
// $phonenumber = "+91 9824 89 5546";
// $alt_title = "TenderKhabar";
// $mailto = "sales@gemtenderconsultant.in";
// $siteurl = "https://www.tenderkhabar.in";
// $siteurlname = "www.tenderkhabar.in";
// $full_details_path = "https://www.tenderkhabar.in/result/newemaildetails";
// $colorcode = "072f54";

// $monday = date( 'Y-m-d', strtotime( 'monday this week' ) );
// $dates = date('Y-m-d');

// //$monday = "2023-08-21";
// //$dates = "2023-08-28";


// //holiday list

// /*$sql_holiday = 'select hdate from holiday_master where hdate>="' . $dates . '" order by hdate asc';
// $my_holiday_days = mysqli_query($dbh2,$sql_holiday);
// $holiday = array();
// while ($h = mysqli_fetch_assoc($my_holiday_days)) {
//     $holiday[] = $h['hdate'];
// }

// if (!empty($holiday) && in_array($dates, $holiday)) {

//     echo "not allow";
//     die();
// }*/



// //listing valid paid  user
// //$sql1 = 'SELECT user.user_id as u_id,user.email,user.secondary_email,user.user_active_indicator,user.user_first_name,user.user_last_name,company.company_name,user_result_product.* from user LEFT JOIN user_result_product on user.id=user_result_product.user_id LEFT JOIN user_result_subscription on user.user_id=user_result_subscription.user_id LEFT JOIN company on user.user_id=company.user_id where user.status="Active" and user.flag="F" and user.user_active_indicator="Paid"  AND user.user_id IN(47497) and user.result_user=1 and user_result_subscription.status="Active" order by user.user_id '; // and user_result_subscription.todate>="' . $dates . '"

// $sql1 = "SELECT user.id as u_id,user.email,user.alt_email,user.status,user.name,user.company_name,user_result_product.* from users as user LEFT JOIN user_result_product on user.id=user_result_product.user_id where user.status='Paid' and user.is_result=1 and user_result_product.todate>='$dates' order by user.id";
// //$sql1 = 'SELECT user.user_id as u_id,user.email,user.secondary_email,user.user_active_indicator,user.user_first_name,user.user_last_name,company.company_name,user_result_product.*,user_result_subscription.* from user LEFT JOIN user_result_product on user.user_id=user_result_product.user_id LEFT JOIN user_result_subscription on user.user_id=user_result_subscription.user_id LEFT JOIN company on user.user_id=company.user_id where user.user_id=53294 AND user.status="Active" and user.is_deleted="0" and user.flag="F" and user.user_active_indicator="Paid" and user.result_user=1 and user_result_subscription.status="Active" and user_result_subscription.todate>="' . $dates . '" order by user.user_id ';

// //echo $sql1;die();
// $my_users = mysqli_query($dbh2,$sql1);
// $paid_user_tender = array();
// while ($m = mysqli_fetch_assoc($my_users)) {
//     $paid_user_tender[] = $m;
// }

// //echo $sql1;die();
// $user_state = array();
// $body = '';
// $tender_array = array();
// //print_r($paid_user_tender);die();

// /* user loop start  for paid user */
// foreach ($paid_user_tender as $u_key => $u_val) {


 

//     $my_new_result_list_tender = array();
//     $my_tender_for_user='';
    
  
//     /* ending tender list */
//     $uname = '';
//     $company_name = '';

//     $uname = $u_val['name'];

//     if (!empty($u_val['company_name'])) {
//         $company_name = $u_val['company_name'];
//     }

//     $subject = "Fresh Tender Result of Your Category ";

//     $email_recipients = array();
//     $user_id = '';
//     $user_id = base64_encode($u_val['user_id']);



//     $secondary_email = '';


//     $body = '';
//     $status = 0;
//     $tender_array = array();
//     $email_sent_status = 0;
//     //sending email to paid user according to their business info

//     $sql = '';
//     $u_tender_listing = array();

//     /* tender listing */

//     $sql = "select tender_result_info.id as ntid,tender_result_info.aoc as latest_date,tender_result_info.Organisation as organisation_name,tender_result_info.title as description,tender_result_info.awarded_value as tender_value,state.name as location from tender_result_info LEFT JOIN state on state.id=tender_result_info.state_id where (dt BETWEEN '".$monday."' AND '".$dates."')"; // dt='" . $dates . "'



//     if (isset($u_val['is_exact_keyword']) && $u_val['is_exact_keyword'] == 1) {


//         if (!empty($u_val['keyword'])) {



//             $userkeyword = explode(",", $u_val['keyword']);



//             for ($i = 0; $i < count($userkeyword); $i++) {
//                 if (count($userkeyword) == 1) {
//                     $sql .= " AND tender_result_info.title  LIKE '% " . $userkeyword[$i] . " %'";
//                 }
//                 if (count($userkeyword) > 1) {
//                     if ($i == 0) {
//                         $sql .= " AND (tender_result_info.title LIKE '% " . $userkeyword[$i] . " %' OR ";
//                     } else if ($i == (count($userkeyword) - 1)) {
//                         $sql .= " tender_result_info.title LIKE '% " . $userkeyword[$i] . " %')";
//                     } else {
//                         $sql .= " tender_result_info.title LIKE '% " . $userkeyword[$i] . " %' OR ";
//                     }
//                 }
//             }
//         }
//     } else {

//         if (!empty($u_val['keyword'])) {



//             $userkeyword = explode(",", $u_val['keyword']);



//             for ($i = 0; $i < count($userkeyword); $i++) {
//                 if (count($userkeyword) == 1) {
//                     $sql .= " AND tender_result_info.title  LIKE '%" . $userkeyword[$i] . "%'";
//                 }
//                 if (count($userkeyword) > 1) {
//                     if ($i == 0) {
//                         $sql .= " AND (tender_result_info.title LIKE '%" . $userkeyword[$i] . "%' OR ";
//                     } else if ($i == (count($userkeyword) - 1)) {
//                         $sql .= " tender_result_info.title LIKE '%" . $userkeyword[$i] . "%')";
//                     } else {
//                         $sql .= " tender_result_info.title LIKE '%" . $userkeyword[$i] . "%' OR ";
//                     }
//                 }
//             }
//         }
//     }




//     if (!empty($u_val['Min_Amount']) && $u_val['Min_Amount'] != '' && !empty($u_val['Max_Amount']) && $u_val['Max_Amount'] != '') {

//         $sql .= " and awarded_value >=" . $u_val['Min_Amount'] . "  and awarded_value <=" . $u_val['Max_Amount'];
//     } else if (!empty($u_val['Min_Amount']) && $u_val['Min_Amount'] != '') {

//         $sql .= " and awarded_value >=" . $u_val['Min_Amount'];
//     } else if (!empty($u_val['Max_Amount']) && $u_val['Max_Amount'] != '') {

//         $sql .= " and awarded_value <=" . $u_val['Max_Amount'];
//     }

//     if (!empty($u_val['refine_keyword']) && $u_val['refine_keyword'] != '') {

//         $sql .= " AND title LIKE '%" . $u_val['refine_keyword'] . "%' ";
//     }



//     if (!empty($u_val['excludingkeyword'])) {

//         $userexcludingkeyword = explode(",", $u_val['excludingkeyword']);

//         for ($j = 0; $j < count($userexcludingkeyword); $j++) {
//             if (count($userexcludingkeyword) == 1) {
//                 $sql .= " AND tender_result_info.title NOT LIKE '%" . $userexcludingkeyword[$j] . "%'";
//             }
//             if (count($userexcludingkeyword) > 1) {
//                 if ($j == 0) {
//                     $sql .= " AND (tender_result_info.title NOT LIKE '%" . $userexcludingkeyword[$j] . "%' AND ";
//                 } else if ($j == (count($userexcludingkeyword) - 1)) {

//                     $sql .= " tender_result_info.title NOT LIKE '%" . $userexcludingkeyword[$j] . "%')";
//                 } else {
//                     $sql .= " tender_result_info.title NOT LIKE '%" . $userexcludingkeyword[$j] . "%' AND ";
//                 }
//             }
//         }
//     }


//     if ($u_val['state'] != '') {
//         //$state_explode = explode(',', $u_val['state']);
//         //$state1 = "'" . implode("','", $state_explode) . "'";
        
//         $sql .= " AND `state_id` IN  ( " . $u_val['state'] . ") ";
//     }


    
//     if (!empty($my_new_result_list_tender)) {
        
//         $sql .=" or tender_result_info.tender_id in($my_tender_for_user)";
        
        
//     }

//     $sql .= " group by tender_result_info.id order by tender_result_info.id desc LIMIT 1000";
    
//     //echo $monday."<br>";
//     //echo $sql_tender;
//     //echo "<br><br>".$sql;
//     //die();
    
//     $my_fresh_result = mysqli_query($dbh1,$sql);
//     $u_tender_listing = array();

//     while ($k = mysqli_fetch_assoc($my_fresh_result)) {
//         $u_tender_listing[] = $k;
//     }


//     $tender_count = 0;

//     if (!empty($u_tender_listing)) {

//         $tender_count = 0;
//         $tender_count = count($u_tender_listing);
//         $subject .= "(" . $tender_count . ") - " . $dates . " || " . $company_name;
//     } else {

//         $tender_count = 0;

//         $subject .= "(" . $tender_count . ") - " . $dates . " || " . $company_name;
//     }
//     $body .= '<!DOCTYPE html>
// <html>
// <head>
//     <title></title>
// </head>
// <body>
//     <center>
//       <table class="container600" cellpadding="0" cellspacing="0" border="0" width="100%" style="width:calc(100%);margin: 0 auto;">
//         <tr>
//           <td width="100%" style="text-align: left;">

//             <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
//                 <tr>
//                     <td align="left">
//                         <h3 style="font-family:Arial;margin-bottom:5px;">Welcome ' . $uname . '</h3>
//                         <h4 style="font-family:Arial;margin-top:5px;">' . $company_name . '</h4>
//                     </td>
//                     <td align="right">
//                         <img src="'.$logourl.'" width="100" alt="'.$alt_title.'">
//                     </td>
//                 </tr>
//             </table>
            
//             <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
//                 <tr>
//                     <td width="100%">
//                         <hr width="100%" align="center" style="margin-top: 0px;margin-bottom: 0px;">
//                     </td>
//                 </tr>
//             </table>
            
//             <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
//                 <tr>
//                     <td align="left">
//                         <p style="font-family:Arial;color:#'.$colorcode.';">For assistance, Call on '.$phonenumber.'</p>
//                     </td>
//                     <td align="right">
//                         <p style="font-family:Arial;color:#f7931d;"><a style="color:#'.$colorcode.';" alt="'.$alt_title.'" title="'.$alt_title.'" href="mailto:'.$mailto.'" target="_blank">'.$mailto.'</a></p>
//                     </td>
//                 </tr>
//             </table>
            
//             <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
//                 <tr>
//                     <td width="100%">
//                         <hr width="100%" align="center" style="margin-top: 0px;margin-bottom: 0px;">
//                     </td>
//                 </tr>
//             </table>
            
//             <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
//                 <tr>
//                     <td width="100%">
//                         <p>We at <a href="'.$siteurl.'"><span style="color:windowtext">'.$siteurlname.'</span></a> provide information of Fresh Tenders Result with Full AOC Details</p>
//                     </td>
//                 </tr>
//             </table>
            
//             <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;margin-bottom:5px;">
//                 <tr>
//                     <td>
//                         <table class="ol col49 reorder" width="100%" align="left" style="width: calc(50%);" cellpadding="0" cellspacing="0" border="0">
//                             <tr>
//                                 <td width="50%" style="color:#'.$colorcode.';">Tender Result For Your Category</td>
//                             </tr>
//                         </table>
//                         <table class="ol col49 reorder" width="100%" align="right" style="width: calc(50%);" cellpadding="0" cellspacing="0" border="0">
//                             <tr>
//                                 <td width="50%" align="right" style="color:#'.$colorcode.';">Tender Bidding Window</td>
//                             </tr>
//                         </table>
//                     </td>
//                 </tr>
//             </table>
            
//             <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;margin-bottom:5px;">
//                 <tr>
//                     <td>
//                         <table class="ol col49 reorder" width="100%" align="left" style="width: calc(50%);" cellpadding="0" cellspacing="0" border="0">
//                             <tr>
//                                 <td width="50%" style="color:#'.$colorcode.';">No More Junk Tender Result</td>
//                             </tr>
//                         </table>
                        
//                         <table class="ol col49 reorder" width="100%" align="right" style="width: calc(50%);" cellpadding="0" cellspacing="0" border="0">
//                             <tr>
//                                 <td width="50%" align="right" style="color:#'.$colorcode.';">Sub Contracting /liasoning services</td>
//                             </tr>
//                         </table>
//                     </td>
//                 </tr>
//             </table>
//             <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;margin-bottom:5px;">
//                 <tr>
//                     <td>
//                         <table class="ol col49 reorder" width="100%" align="left" style="width: calc(50%);" cellpadding="0" cellspacing="0" border="0">
//                             <tr>
//                                 <td width="50%" style="color:#'.$colorcode.';">Quality Support</td>
//                             </tr>
//                         </table>
                        
//                         <table class="ol col49 reorder" width="100%" align="right" style="width: calc(50%);" cellpadding="0" cellspacing="0" border="0">
//                             <tr>
//                                 <td width="50%" align="right" style="color:#'.$colorcode.';">Quality Information</td>
//                             </tr>
//                         </table>
//                     </td>
//                 </tr>
//             </table>

//             <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;margin-top:10px;">
//               <tr>
//                 <td style="background-color:#F8F7F0;padding:15px 0px;">

//                   <table width="100%" cellpadding="0" cellspacing="0" border="0">
//                     <tr>
//                       <td width="100%" valign="top" style="min-width: 100%;">

//                         <table class="ol col49 reorder" width="100%" align="left" style="width: calc(100%);" cellpadding="0" cellspacing="0" border="0">
//                           <tr>
//                             <td width="100%" valign="top" style="background-color:#ffffff;color:#000000;">
//                               <table width="100%" cellpadding="5" cellspacing="0" border="" style="border-top:1px solid #afafaf;border-bottom:1px solid #afafaf;min-width:100%;">
//                                 <thead style="background-color:#'.$colorcode.';color:#fff;">
//                                 <tr>
//                                   <th align="center">Sr. No</th>
//                                   <th align="center">TRID</th>
//                                   <th align="center" width="35%">Description</th>
//                                   <th align="center">Authority Name</th>
//                                   <th align="center">Tender Value</th>
//                                   <th align="center">Location</th>
//                                   <th align="center">Aoc Date</th>
//                                   <th align="center">Action</th>
//                                 </tr>
//                                 </thead>
//                                 <tbody>';
//                                 if (!empty($u_tender_listing)) {

//                                     // echo "heloo";die();
//                                     $im = 0;

//                                     foreach ($u_tender_listing as $key => $val) {

                                        

//                                         $str = $val['description'];
//                                         $str = preg_replace('~[\r\n]+~', '', trim($str));
//                                         $str = preg_replace('/\s+/', ' ', $str);
//                                         $str = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $str);
                                        
//                                         $str = (strlen($str) > 300) ? substr($str, 0, 300).'...' : $str; // change 2022-06-08 
            
                                        
//                                         $im++;
//                                         //to send email or not for particular tender    
//                                         //setting email template view for user interface

//                                         $body .= '<tr>
//                                         <td>'.$im.'</td>
//                                         <td>'.$val['ntid'].'</td>
//                                         <td><a href="'.$full_details_path.'?tid='.base64_encode($val['ntid']).'&uid='.$user_id.'" target="_blank">'.ucwords(strtolower($str)).'</a></td>
//                                         <td>'.ucwords(strtolower($val['organisation_name'])).'</td>
//                                         <td>'.$val['tender_value'].' (approx.)</td>
//                                         <td>'.$val['location'].'</td>
//                                         <td>'.$val['latest_date'].'</td>
//                                         <td style="text-align: center;"><a href="'.$full_details_path.'?tid='.base64_encode($val['ntid']).'&uid='.$user_id.'" style="background-color:#'.$colorcode.';color:#fff;text-decoration:none;padding:5px 15px;width:auto;" target="_blank">View</a></td>
//                                     </tr>';
//                                         $email_sent_status = 1;
//                                         $tender_array[] = $val['ntid'];
//                                         }
//                                     } else {
//                                         $body .= '<tr>
//                                             <td colspan="8" align="center"><h3 style="font-family:Arial;">No Fresh Tender Result</h3></td>
//                                         </tr>';
//                                     }
//                                 $body .= '</tbody>
//                               </table>
//                             </td>
//                           </tr>
//                         </table>

//                         <table class="ol col2 ghost-column" width="100%" align="left" style="width: calc(2%);" cellpadding="0" cellspacing="0" border="0">
//                           <tr>
//                             <td width="100%" valign="top" style="line-height: 20px;">
//                               &nbsp;
//                             </td>
//                           </tr>
//                         </table>

//                       </td>
//                     </tr>
//                   </table>

//                 </td>
//               </tr>
//             </table>

//             <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
//                 <tr>
//                     <td width="100%">
//                         <p style="margin:5px 0px;">Note : If you are not getting Proper Tender Result then mail us at '.$mailto.'  with Desire Keyword / Categories.</p>
//                     </td>
//                 </tr>
//             </table>
            
           
            
           
            
//             <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
//                 <tr>
//                     <td width="100%">
//                         <p style="margin:5px 0px;">Thanks & Regards,</p>
//                     </td>
//                 </tr>
//             </table>
            
//             <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
//                 <tr>
//                     <td width="100%">
//                         <p style="margin:5px 0px;">Happy Tendering Result.</p>
//                     </td>
//                 </tr>
//             </table>
            
//             <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
//                 <tr>
//                     <td width="100%">
//                         <p style="margin:5px 0px;">For any support please contact : <br>
//                             Support : '.$phonenumber.'<br>
//                             Email :- '.$mailto.'</p>
//                     </td>
//                 </tr>
//             </table>
            
//             <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
//                 <tr>
//                     <td width="100%">
//                         <p style="margin:10px 0px;">If you do not want to receive this mailer, <a
//         href="'.$siteurl.'/site/unsubscribe?email='.$u_val['email'].'&type=result" style="color: #ed7e2c;" title="'.$fromname.'" target="_blank">Unsubscribe</a></p>
//                     </td>
//                 </tr>
//             </table>

//             </td>
//             </tr>
//         </table>
//     </center>
// </body>
// </html>';




//     $email_recipients[] = $u_val['email'];



//     //$mail->AddAddress($u_val['email'], $u_val['user_first_name']);
//     if (!empty($u_val['alt_email'])) {

//         $secondary_email = explode(',', $u_val['alt_email']);

//         foreach ($secondary_email as $km => $vm) {

//             //$mail->AddAddress($vm, $u_val['user_first_name']);
//             $email_recipients[] = $vm;
//         }
//     }
    
//     //echo $body;die();
        
//     $headers = "MIME-Version: 1.0" . "\r\n";
//     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

//     // More headers
//     $headers .= 'From: '.$from. "\r\n";
//     $headers .= 'Cc: '.$mailto. "\r\n";
//     $email_to = implode(',', $email_recipients);
//     //print_r($email_recipients);die();
//     //echo $email_to;die();
//     //$status = mail($email_to, $subject, $body, $headers);
    
//     $mailsent = email_phpmailer($email_recipients, $subject, $body,$emailUser,$emailPassword,$from,$fromname,$host);
    
//     $body = '';
//     $email_to = '';
//     $subject = '';
//     $email_recipients = array();
// }
//ini_set('memory_limit', '-1');
//list user and user product info

include('config_mysqli.php');
require_once "php_mailer/vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function email_phpmailer($emailid = array(), $subject, $body,$username,$password,$from,$fromname,$host){
    $mail = new PHPMailer;
    //Enable SMTP debugging.
    $mail->SMTPDebug = 0;                           
    //Set PHPMailer to use SMTP.
    $mail->isSMTP();        
    //Set SMTP host name                      
    $mail->Host = $host;
    //Set this to true if SMTP host requires authentication to send email
    $mail->SMTPAuth = true;                      
    //Provide username and password
    $mail->Username = $username;             
    $mail->Password = $password;            

    //If SMTP requires TLS encryption then set it
    //$mail->SMTPSecure = "tls";    //for gmail

    //Set TCP port to connect to
    $mail->Port = 587;                    
    $mail->From = $from;
    $mail->FromName = $fromname;
   
    $mail->addReplyTo('noreply@tenderkhabar.com', 'TenderKhabar');
    $mail->addAddress($emailid[0], "");
    foreach($emailid as $ek => $email)
    {
        if($ek != 0)
        {
          $mail->AddCC($email);
        }
    }
    $mail->AddCC('tenderkhabar2@gmail.com'); // change
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;
    //$mail->AltBody = "This is the plain text version of the email content";
    if(!$mail->send())
    {
    echo "Mailer Error: " . $mail->ErrorInfo;
    }
    else
    {
    echo "Message has been sent successfully";
    }
}
//$monday = date( 'Y-m-d', strtotime( 'monday this week' ) );


$emailUser = "noreply@tenderkhabar.com";
$emailPassword = "Care@9275";
$host = "mail.tenderkhabar.com";

$from = 'noreply@tenderkhabar.com';
$fromname = 'TenderKhabar'; 


$logourl = "https://tenderkhabar.in/assets/img/logo.png";
$phonenumber = "+91 9824 89 5546";
$alt_title = "TenderKhabar";
$mailto = "sales@gemtenderconsultant.in";
$siteurl = "https://www.tenderkhabar.in";
$siteurlname = "www.tenderkhabar.in";
$full_details_path = "https://www.tenderkhabar.in/result/newemaildetails";
$colorcode = "072f54";

$monday = date( 'Y-m-d', strtotime( 'monday this week' ) );
$dates = date('Y-m-d');

//$monday = "2023-08-21";
//$dates = "2023-08-28";


//holiday list

/*$sql_holiday = 'select hdate from holiday_master where hdate>="' . $dates . '" order by hdate asc';
$my_holiday_days = mysqli_query($dbh2,$sql_holiday);
$holiday = array();
while ($h = mysqli_fetch_assoc($my_holiday_days)) {
    $holiday[] = $h['hdate'];
}

if (!empty($holiday) && in_array($dates, $holiday)) {

    echo "not allow";
    die();
}*/



//listing valid paid  user
//$sql1 = 'SELECT user.user_id as u_id,user.email,user.secondary_email,user.user_active_indicator,user.user_first_name,user.user_last_name,company.company_name,user_result_product.* from user LEFT JOIN user_result_product on user.id=user_result_product.user_id LEFT JOIN user_result_subscription on user.user_id=user_result_subscription.user_id LEFT JOIN company on user.user_id=company.user_id where user.status="Active" and user.flag="F" and user.user_active_indicator="Paid"  AND user.user_id IN(47497) and user.result_user=1 and user_result_subscription.status="Active" order by user.user_id '; // and user_result_subscription.todate>="' . $dates . '"

$sql1 = "SELECT user.id as u_id,user.email,user.alt_email,user.status,user.name,user.company_name,user_result_product.* from users as user LEFT JOIN user_result_product on user.id=user_result_product.user_id where user.status='Paid' and user.is_result=1 and user_result_product.todate>='$dates' order by user.id";
//$sql1 = 'SELECT user.user_id as u_id,user.email,user.secondary_email,user.user_active_indicator,user.user_first_name,user.user_last_name,company.company_name,user_result_product.*,user_result_subscription.* from user LEFT JOIN user_result_product on user.user_id=user_result_product.user_id LEFT JOIN user_result_subscription on user.user_id=user_result_subscription.user_id LEFT JOIN company on user.user_id=company.user_id where user.user_id=53294 AND user.status="Active" and user.is_deleted="0" and user.flag="F" and user.user_active_indicator="Paid" and user.result_user=1 and user_result_subscription.status="Active" and user_result_subscription.todate>="' . $dates . '" order by user.user_id ';

//echo $sql1;die();
$my_users = mysqli_query($dbh2,$sql1);
$paid_user_tender = array();
while ($m = mysqli_fetch_assoc($my_users)) {
    $paid_user_tender[] = $m;
}

//echo $sql1;die();
$user_state = array();
$body = '';
$tender_array = array();
//print_r($paid_user_tender);die();

/* user loop start  for paid user */
foreach ($paid_user_tender as $u_key => $u_val) {


 

    $my_new_result_list_tender = array();
    $my_tender_for_user='';
    
  
    /* ending tender list */
    $uname = '';
    $company_name = '';

    $uname = $u_val['name'];

    if (!empty($u_val['company_name'])) {
        $company_name = $u_val['company_name'];
    }

    $subject = "Fresh Tender Result of Your Category ";

    $email_recipients = array();
    $user_id = '';
    $user_id = base64_encode($u_val['user_id']);



    $secondary_email = '';


    $body = '';
    $status = 0;
    $tender_array = array();
    $email_sent_status = 0;
    //sending email to paid user according to their business info

    $sql = '';
    $u_tender_listing = array();

    /* tender listing */

    $sql = "select tender_result_info.id as ntid,tender_result_info.aoc as latest_date,tender_result_info.Organisation as organisation_name,tender_result_info.title as description,tender_result_info.awarded_value as tender_value,state.name as location from tender_result_info LEFT JOIN state on state.id=tender_result_info.state_id where (dt BETWEEN '".$monday."' AND '".$dates."')"; // dt='" . $dates . "'



    if (isset($u_val['is_exact_keyword']) && $u_val['is_exact_keyword'] == 1) {


        if (!empty($u_val['keyword'])) {



            $userkeyword = explode(",", $u_val['keyword']);



            for ($i = 0; $i < count($userkeyword); $i++) {
                if (count($userkeyword) == 1) {
                    $sql .= " AND tender_result_info.title  LIKE '% " . $userkeyword[$i] . " %'";
                }
                if (count($userkeyword) > 1) {
                    if ($i == 0) {
                        $sql .= " AND (tender_result_info.title LIKE '% " . $userkeyword[$i] . " %' OR ";
                    } else if ($i == (count($userkeyword) - 1)) {
                        $sql .= " tender_result_info.title LIKE '% " . $userkeyword[$i] . " %')";
                    } else {
                        $sql .= " tender_result_info.title LIKE '% " . $userkeyword[$i] . " %' OR ";
                    }
                }
            }
        }
    } else {

        if (!empty($u_val['keyword'])) {



            $userkeyword = explode(",", $u_val['keyword']);



            for ($i = 0; $i < count($userkeyword); $i++) {
                if (count($userkeyword) == 1) {
                    $sql .= " AND tender_result_info.title  LIKE '%" . $userkeyword[$i] . "%'";
                }
                if (count($userkeyword) > 1) {
                    if ($i == 0) {
                        $sql .= " AND (tender_result_info.title LIKE '%" . $userkeyword[$i] . "%' OR ";
                    } else if ($i == (count($userkeyword) - 1)) {
                        $sql .= " tender_result_info.title LIKE '%" . $userkeyword[$i] . "%')";
                    } else {
                        $sql .= " tender_result_info.title LIKE '%" . $userkeyword[$i] . "%' OR ";
                    }
                }
            }
        }
    }




    if (!empty($u_val['Min_Amount']) && $u_val['Min_Amount'] != '' && !empty($u_val['Max_Amount']) && $u_val['Max_Amount'] != '') {

        $sql .= " and awarded_value >=" . $u_val['Min_Amount'] . "  and awarded_value <=" . $u_val['Max_Amount'];
    } else if (!empty($u_val['Min_Amount']) && $u_val['Min_Amount'] != '') {

        $sql .= " and awarded_value >=" . $u_val['Min_Amount'];
    } else if (!empty($u_val['Max_Amount']) && $u_val['Max_Amount'] != '') {

        $sql .= " and awarded_value <=" . $u_val['Max_Amount'];
    }

    if (!empty($u_val['refine_keyword']) && $u_val['refine_keyword'] != '') {

        $sql .= " AND title LIKE '%" . $u_val['refine_keyword'] . "%' ";
    }



    if (!empty($u_val['excludingkeyword'])) {

        $userexcludingkeyword = explode(",", $u_val['excludingkeyword']);

        for ($j = 0; $j < count($userexcludingkeyword); $j++) {
            if (count($userexcludingkeyword) == 1) {
                $sql .= " AND tender_result_info.title NOT LIKE '%" . $userexcludingkeyword[$j] . "%'";
            }
            if (count($userexcludingkeyword) > 1) {
                if ($j == 0) {
                    $sql .= " AND (tender_result_info.title NOT LIKE '%" . $userexcludingkeyword[$j] . "%' AND ";
                } else if ($j == (count($userexcludingkeyword) - 1)) {

                    $sql .= " tender_result_info.title NOT LIKE '%" . $userexcludingkeyword[$j] . "%')";
                } else {
                    $sql .= " tender_result_info.title NOT LIKE '%" . $userexcludingkeyword[$j] . "%' AND ";
                }
            }
        }
    }


    if ($u_val['state'] != '') {
        //$state_explode = explode(',', $u_val['state']);
        //$state1 = "'" . implode("','", $state_explode) . "'";
        
        $sql .= " AND `state_id` IN  ( " . $u_val['state'] . ") ";
    }


    
    if (!empty($my_new_result_list_tender)) {
        
        $sql .=" or tender_result_info.tender_id in($my_tender_for_user)";
        
        
    }

    $sql .= " group by tender_result_info.id order by tender_result_info.id desc LIMIT 1000";
    
    //echo $monday."<br>";
    //echo $sql_tender;
    //echo "<br><br>".$sql;
    //die();
    
    $my_fresh_result = mysqli_query($dbh1,$sql);
    $u_tender_listing = array();

    while ($k = mysqli_fetch_assoc($my_fresh_result)) {
        $u_tender_listing[] = $k;
    }


    $tender_count = 0;

    if (!empty($u_tender_listing)) {

        $tender_count = 0;
        $tender_count = count($u_tender_listing);
        $subject .= "(" . $tender_count . ") - " . $dates . " || " . $company_name;
    } else {

        $tender_count = 0;

        $subject .= "(" . $tender_count . ") - " . $dates . " || " . $company_name;
    }
    $body .= '<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <center>
      <table class="container600" cellpadding="0" cellspacing="0" border="0" width="100%" style="width:calc(100%);margin: 0 auto;">
        <tr>
          <td width="100%" style="text-align: left;">

            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
                <tr>
                    <td align="left">
                        <h3 style="font-family:Arial;margin-bottom:5px;">Welcome ' . $uname . '</h3>
                        <h4 style="font-family:Arial;margin-top:5px;">' . $company_name . '</h4>
                    </td>
                    <td align="right">
                        <img src="'.$logourl.'" width="100" alt="'.$alt_title.'">
                    </td>
                </tr>
            </table>
            
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
                <tr>
                    <td width="100%">
                        <hr width="100%" align="center" style="margin-top: 0px;margin-bottom: 0px;">
                    </td>
                </tr>
            </table>
            
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
                <tr>
                    <td align="left">
                        <p style="font-family:Arial;color:#'.$colorcode.';">For assistance, Call on '.$phonenumber.'</p>
                    </td>
                    <td align="right">
                        <p style="font-family:Arial;color:#f7931d;"><a style="color:#'.$colorcode.';" alt="'.$alt_title.'" title="'.$alt_title.'" href="mailto:'.$mailto.'" target="_blank">'.$mailto.'</a></p>
                    </td>
                </tr>
            </table>
            
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
                <tr>
                    <td width="100%">
                        <hr width="100%" align="center" style="margin-top: 0px;margin-bottom: 0px;">
                    </td>
                </tr>
            </table>
            
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
                <tr>
                    <td width="100%">
                        <p>We at <a href="'.$siteurl.'"><span style="color:windowtext">'.$siteurlname.'</span></a> provide information of Fresh Tenders Result with Full AOC Details</p>
                    </td>
                </tr>
            </table>
            
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;margin-bottom:5px;">
                <tr>
                    <td>
                        <table class="ol col49 reorder" width="100%" align="left" style="width: calc(50%);" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="50%" style="color:#'.$colorcode.';">Tender Result For Your Category</td>
                            </tr>
                        </table>
                        <table class="ol col49 reorder" width="100%" align="right" style="width: calc(50%);" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="50%" align="right" style="color:#'.$colorcode.';">Tender Bidding Window</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;margin-bottom:5px;">
                <tr>
                    <td>
                        <table class="ol col49 reorder" width="100%" align="left" style="width: calc(50%);" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="50%" style="color:#'.$colorcode.';">No More Junk Tender Result</td>
                            </tr>
                        </table>
                        
                        <table class="ol col49 reorder" width="100%" align="right" style="width: calc(50%);" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="50%" align="right" style="color:#'.$colorcode.';">Sub Contracting /liasoning services</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;margin-bottom:5px;">
                <tr>
                    <td>
                        <table class="ol col49 reorder" width="100%" align="left" style="width: calc(50%);" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="50%" style="color:#'.$colorcode.';">Quality Support</td>
                            </tr>
                        </table>
                        
                        <table class="ol col49 reorder" width="100%" align="right" style="width: calc(50%);" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="50%" align="right" style="color:#'.$colorcode.';">Quality Information</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;margin-top:10px;">
              <tr>
                <td style="background-color:#F8F7F0;padding:15px 0px;">

                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                      <td width="100%" valign="top" style="min-width: 100%;">

                        <table class="ol col49 reorder" width="100%" align="left" style="width: calc(100%);" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                            <td width="100%" valign="top" style="background-color:#ffffff;color:#000000;">
                              <table width="100%" cellpadding="5" cellspacing="0" border="" style="border-top:1px solid #afafaf;border-bottom:1px solid #afafaf;min-width:100%;">
                                <thead style="background-color:#'.$colorcode.';color:#fff;">
                                <tr>
                                  <th align="center">Sr. No</th>
                                  <th align="center">TRID</th>
                                  <th align="center" width="35%">Description</th>
                                  <th align="center">Authority Name</th>
                                  <th align="center">Tender Value</th>
                                  <th align="center">Location</th>
                                  <th align="center">Aoc Date</th>
                                  <th align="center">Action</th>
                                </tr>
                                </thead>
                                <tbody>';
                                if (!empty($u_tender_listing)) {

                                    // echo "heloo";die();
                                    $im = 0;

                                    foreach ($u_tender_listing as $key => $val) {

                                        

                                        $str = $val['description'];
                                        $str = preg_replace('~[\r\n]+~', '', trim($str));
                                        $str = preg_replace('/\s+/', ' ', $str);
                                        $str = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $str);
                                        
                                        $str = (strlen($str) > 300) ? substr($str, 0, 300).'...' : $str; // change 2022-06-08 
            
                                        
                                        $im++;
                                        //to send email or not for particular tender    
                                        //setting email template view for user interface

                                        $body .= '<tr>
                                        <td>'.$im.'</td>
                                        <td>'.$val['ntid'].'</td>
                                        <td><a href="'.$full_details_path.'?tid='.base64_encode($val['ntid']).'&uid='.$user_id.'" target="_blank">'.ucwords(strtolower($str)).'</a></td>
                                        <td>'.ucwords(strtolower($val['organisation_name'])).'</td>
                                        <td>'.$val['tender_value'].' (approx.)</td>
                                        <td>'.$val['location'].'</td>
                                        <td>'.$val['latest_date'].'</td>
                                        <td style="text-align: center;"><a href="'.$full_details_path.'?tid='.base64_encode($val['ntid']).'&uid='.$user_id.'" style="background-color:#'.$colorcode.';color:#fff;text-decoration:none;padding:5px 15px;width:auto;" target="_blank">View</a></td>
                                    </tr>';
                                        $email_sent_status = 1;
                                        $tender_array[] = $val['ntid'];
                                        }
                                    } else {
                                        $body .= '<tr>
                                            <td colspan="8" align="center"><h3 style="font-family:Arial;">No Fresh Tender Result</h3></td>
                                        </tr>';
                                    }
                                $body .= '</tbody>
                              </table>
                            </td>
                          </tr>
                        </table>

                        <table class="ol col2 ghost-column" width="100%" align="left" style="width: calc(2%);" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                            <td width="100%" valign="top" style="line-height: 20px;">
                              &nbsp;
                            </td>
                          </tr>
                        </table>

                      </td>
                    </tr>
                  </table>

                </td>
              </tr>
            </table>

            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
                <tr>
                    <td width="100%">
                        <p style="margin:5px 0px;">Note : If you are not getting Proper Tender Result then mail us at '.$mailto.'  with Desire Keyword / Categories.</p>
                    </td>
                </tr>
            </table>
            
           
            
           
            
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
                <tr>
                    <td width="100%">
                        <p style="margin:5px 0px;">Thanks & Regards,</p>
                    </td>
                </tr>
            </table>
            
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
                <tr>
                    <td width="100%">
                        <p style="margin:5px 0px;">Happy Tendering Result.</p>
                    </td>
                </tr>
            </table>
            
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
                <tr>
                    <td width="100%">
                        <p style="margin:5px 0px;">For any support please contact : <br>
                            Support : '.$phonenumber.'<br>
                            Email :- '.$mailto.'</p>
                    </td>
                </tr>
            </table>
            
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
                <tr>
                    <td width="100%">
                        <p style="margin:10px 0px;">If you do not want to receive this mailer, <a
        href="'.$siteurl.'/site/unsubscribe?email='.$u_val['email'].'&type=result" style="color: #ed7e2c;" title="'.$fromname.'" target="_blank">Unsubscribe</a></p>
                    </td>
                </tr>
            </table>

            </td>
            </tr>
        </table>
    </center>
</body>
</html>';




    $email_recipients[] = $u_val['email'];



    //$mail->AddAddress($u_val['email'], $u_val['user_first_name']);
    if (!empty($u_val['alt_email'])) {

        $secondary_email = explode(',', $u_val['alt_email']);

        foreach ($secondary_email as $km => $vm) {

            //$mail->AddAddress($vm, $u_val['user_first_name']);
            $email_recipients[] = $vm;
        }
    }
    
    //echo $body;die();
        
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= 'From: '.$from. "\r\n";
    $headers .= 'Cc: '.$mailto. "\r\n";
    $email_to = implode(',', $email_recipients);
    //print_r($email_recipients);die();
    //echo $email_to;die();
    //$status = mail($email_to, $subject, $body, $headers);
    
    $mailsent = email_phpmailer($email_recipients, $subject, $body,$emailUser,$emailPassword,$from,$fromname,$host);
    sleep(1);
    
    $body = '';
    $email_to = '';
    $subject = '';
    $email_recipients = array();
}
?>