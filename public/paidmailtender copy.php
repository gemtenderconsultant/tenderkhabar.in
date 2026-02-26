<?php
// @ini_set('max_execution_time', 3600); // Allow script to run for 1 hour
// @ini_set('memory_limit', '512M'); 
// set_time_limit(0);

@ini_set('max_execution_time', '0');   // No time limit
@ini_set('max_input_time', '0');       // No input time limit
@ini_set('memory_limit', '2048M');        // 2 GB memory
@ini_set('post_max_size', '2048M');       // 2 GB POST data
set_time_limit(0);                     // No time limit
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
    //$mail->addCustomHeader('X-Custom-ID', uniqid());
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;
    //$mail->AltBody = "This is the plain text version of the email content";
    if(!$mail->send())
    {
    $result = "Mailer Error: " . $mail->ErrorInfo;
    }
    else
    {
    $result = "Message has been sent successfully";
    }
   return $result; 

}
function formatInIndianStyle($get_amt) {

    $amt_explode = explode('.', $get_amt);
    $amt = $amt_explode['0'];
    $amount = strlen($amt_explode['0']);
    if ($amount == 4) {
        $result = substr($amt, 0, 3);
        $my_amount = number_format(($result / 100), 2);
        return $my_amount . " Thousand";
    } else if ($amount == 5) {
        $result = substr($amt, 0, 4);
        $my_amount = number_format(($result / 100), 2);
        return $my_amount . " Thousand";
    } else if ($amount == 6) {
        $result = substr($amt, 0, 3);
        $my_amount = number_format(($result / 100), 2);
        return $my_amount . " Lakh";
    } else if ($amount == 7) {
        $result = substr($amt, 0, 4);
        $my_amount = number_format(($result / 100), 2);
        return $my_amount . " Lakh";
    } else if ($amount == 8) {
        $result = substr($amt, 0, 3);
        $my_amount = number_format(($result / 100), 2);
        return $my_amount . " CR";
    } else if ($amount == 9) {
        $result = substr($amt, 0, 4);
        $my_amount = number_format(($result / 100), 2);
        return $my_amount . " CR";
    } else if ($amount == 10) {
        $result = substr($amt, 0, 5);
        $my_amount = number_format(($result / 100), 2);
        return $my_amount . " CR";
    } else if ($amount == 11) {
        $result = substr($amt, 0, 6);
        $my_amount = number_format(($result / 100), 2);
        return $my_amount . " CR";
    } else if ($amount == 12) {
        $result = substr($amt, 0, 7);
        $my_amount = number_format(($result / 100), 2);
        return $my_amount . " CR";
    } else if ($amount == 13) {
        $result = substr($amt, 0, 8);
        $my_amount = number_format(($result / 100), 2);
        return $my_amount . " CR";
    } else if ($amount == 14) {
        $result = substr($amt, 0, 9);
        $my_amount = number_format(($result / 100), 2);
        return $my_amount . " CR";
    } else {
        return $get_amt;
    }
}

$emailUser = "emailapikey";
$emailPassword = "PHtE6r0KQe/jjjIsoBZSsfXrQJShZ957/u9ueQRFs4ZLA/MHHE1TqIp+l2DlohsjXfMWR/aTwI9t4ruU5+qBJWe+Mz1MWWqyqK3sx/VYSPOZsbq6x00ft18bfkLUVYbmdNBi1y3Rs9jfNA==";
$host = "smtp.zeptomail.in";
$from = 'noreply@tenderkhabar.com';
$fromname = 'TenderKhabar'; 

$full_details_path = "https://www.tenderkhabar.in/EmailTenderDetails";
$logo_url = "https://tenderkhabar.in/assets/img/logo.png"; // logo change otherwise mail not sent
$mailto ="sales@gemtenderconsultant.in";


$tablename = "live_tenders";
$maildate =date('Y-m-d',strtotime("-1 days"));
$ccmailto ="tenderkhabar2@gmail.com";
$phone = "(+91) 9824 89 5546";

$emailid ="sales@gemtenderconsultant.in";
$website ="www.tenderkhabar.in";
$from_email = "sales@gemtenderconsultant.in";
$colorcode = "072f54";
$tid = "GCID";
 
$finish_email_to = 'nishap.gemtenderconsultant@gmail.com';

if(date('w') != 0){
$subject_date = date('Y-m-d');
//echo $subject_date;die();
$is_send = false;
$delhi_ncr = array('Bhiwani', 'Faridabad', 'Gurgaon', 'Jhajjar', 'Mahendragarh', 'Panipat', 'Rewari', 'Rohtak', 'Sonipat', 'Mewat', 'Palwal', 'Jind', 'Karnal', 'Baghpat', 'Bulandshahr', 'Gautam Buddha Nagar', 'Ghaziabad', 'Muzaffarnagar', 'Meerut', 'Hapur', 'Alwar', 'Bharatpur', 'Noida', 'Delhi', 'New Delhi', 'SHAKURBASTI', 'TUGLAKABAD', 'Sakurbasit', 'Adarsh Nagar', 'Badli', 'Brar Square', 'Bijwasan', 'Chanakyapuri', 'Shivaji Bridge', 'Azadpur', 'Dayabasti', 'Delhi Cantt', 'Delhi Sarai Rohilla', 'Delhi KishanGanj', 'Old Delhi', 'Indrapuri', 'Shahdara', 'Sadar Bazar', 'Delhi Safdarjung', 'Ghevra', 'Holambi Kalan', 'Khera Kalan', 'Lodi Colony', 'Lajpat Nagar', 'Mangolpuri', 'Mundka', 'Naya Azadpur', 'Nangloi', 'Naraina Vihar', 'Narela', 'Delhi Hazrat Nizamuddin', 'Okhla', 'Pragati Maidan', 'Palam', 'Patel Nagar', 'Rajlu Garhi', 'Sardar Patel Road', 'Sandal Kalan', 'Shahabad Mohamadpur', 'Sarojini Nagar', 'Sewa Nagar', 'Delhi Sabzi Mandi', 'Tilak Bridge', 'Vivek Vihar', 'Vivekanand Puri Halt');

//list user and user product info
$dates = date('Y-m-d');
//check mail sent date
$sql_tender_sent = 'select sent_date from tenders_date where flag="p" order by sent_date desc limit 0,1';
$query_tender_sent = mysqli_query($dbh1,$sql_tender_sent);
if(mysqli_num_rows($query_tender_sent) > 0){
    $result_tender_sent = mysqli_fetch_assoc($query_tender_sent);
    $my_paid_mail_date = $result_tender_sent['sent_date'];
    if (empty($my_paid_mail_date)) {
        $my_paid_mail_date = $dates;
    }
}


$paid_user_tender = array();

$sql1 = 'SELECT user.id as u_id,user.email,user.alt_email,user.status,user.name,user.company_name,userproduct.* from users as user LEFT JOIN userproduct on user.id=userproduct.user_id  where user.is_tender=1 and userproduct.todate>="' . $dates . '" and user.status="Paid" AND user.id NOT IN(SELECT user_id FROM userinfo WHERE userinfo.tender_date="' . $dates . '") group by user.id order by user.id asc';
//echo $sql1;die();
$my_users = mysqli_query($dbh2,$sql1);

if (mysqli_num_rows($my_users) > 0) {
while ($m = mysqli_fetch_assoc($my_users)) {
    $paid_user_tender[] = $m;
}
} else {
    //save tender display date
    $prev_dates = date('Y-m-d', strtotime('-1 day'));
    $sql_tender_dates = "insert into tenders_date (sent_date,flag) values ('$prev_dates','p')";
    $my_query_execute = mysqli_query($dbh2,$sql_tender_dates);
   
}

 //"<pre>";print_r($paid_user_tender);
//die();
$sub_category = array();
$user_state = array();

$body = '';
$tender_array = array();
/* user loop start  for paid user */
foreach ($paid_user_tender as $u_key => $u_val) {
    echo "Processing user ID: " . $u_val['u_id'] . " - " . $u_val['email'] . "\n";
    if($is_send == true){
        break;
    }
    
    //print_r($u_val);die();
    $uname = '';
    $company_name = '';
    $uname = $u_val['name'];
    if (!empty($u_val['company_name'])) {
        $company_name = $u_val['company_name'];
    }

    $email_recipients = array();
    $user_id = '';
    $user_id = base64_encode($u_val['u_id']);
    $secondary_email = '';
    $body = '';
    $status = 0;
    $tender_array = array();
    $email_sent_status = 0;
    //sending email to paid user according to their business info

    $sql = '';
    $u_tender_listing = array();
    /* tender listing */
    
    if($u_val['productid'] == "" && $u_val['categoryid'] == "" && $u_val['subcategoryid'] == "" && $u_val['keyword'] == ""){
        
        $email_sent_status = 1;
        $tender_count = 0;
        $subject = " Fresh Tender of Your Category (" . $tender_count . ") - " . $subject_date . " || " . $company_name;
        
        $body .= '<center>
        <div style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#464545;line-height:20px">
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tbody>
            <tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%">
                        <tbody>
                            <tr>
                                <td align="left">
                                    <h3 style="font-family:Arial;margin-bottom:5px">Welcome '.$uname.'</h3>
                                    <h4 style="font-family:Arial;margin-top:5px">'.$company_name.'</h4>
                                </td>
                                <td align="right">
                                 <img src="'.$logo_url.'" width="300" alt="'.$fromname.'">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%">
                        <tbody>
                            <tr>
                                <td width="100%">
                                    <hr width="100%" align="center" style="margin-top:0px;margin-bottom:0px">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%">
                        <tbody>
                            <tr>
                                <td width="100%">
                                    <hr width="100%" align="center" style="margin-top:0px;margin-bottom:0px">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
              <td>
                
              </td>
            </tr>
            <tr>
              <td style="font-family:sans-serif;color:#464545;padding:15px 0 0 0">Dear Member,<br>If the tenders sent to you are not relevant or the query needs to be updated,we request you to mail us at <a style="text-decoration:none;color:#105fff!important" href="mailto:'.$mailto.'" target="_blank">'.$mailto.'</a> with the exact Product / Service / Categories of which you would like to receive the tenders to serve you better.<br>
              </td>
            </tr>
            <tr>
              <td>
                <table cellspacing="0" cellpadding="0" style="font-family:Arial,Helvetica,sans-serif;border:1px solid #'.$colorcode.'">
                  <thead>
                    <tr style="background-color:#'.$colorcode.'">
                      <td style="width:65%;line-height:14px;text-transform:uppercase;border-right:1px solid #a69e9e;border-bottom:1px solid #dfdfdf" align="left" valign="middle">
                        <p style="font-family:sans-serif;color:#fff;margin-left:9px;float:left;font-size:13px;font-stretch:normal">
                          <b>TENDER DETAILS</b>
                        </p>
                      </td>
                      <td style="width:20%;line-height:14px;text-transform:uppercase;border-bottom:1px solid #dfdfdf;border-right:1px solid #a69e9e" valign="middle">
                        <p style="font-size:13px;font-stretch:normal;text-align:center;font-family:sans-serif;color:#fff">
                          <b>ORGANIZATION &amp; LOCATION</b>
                        </p>
                      </td>
                      <td style="width:15%;line-height:14px;text-transform:uppercase;border-bottom:1px solid #dfdfdf" valign="middle">
                        <p style="font-size:13px;font-stretch:normal;text-align:center;font-family:sans-serif;color:#fff">
                          <b>VALUE &amp; DEADLINE</b>
                        </p>
                      </td>
                    </tr>
                  </thead>
                  <tbody>
         
        <tr><td><div style="float:left;width:100%;height:auto;">
        <div style="float:left;width:92%;height:auto; margin:2%; padding: 2%; border: 1px solid #ccc;"> 
        <div style="float:left;width:100%;height:auto;">  
        <span style="margin-right:10px;font-weight:bold;font-size:20px;">Todays! No Fresh Tender for You.</span>
        </div>
        </div>
        </div></td></tr>
        
        </tbody>
                </table>
              </td>
            </tr>
        
            <tr>
              <td>
                <br>
              </td>
            </tr>
            
            <tr>
              <td style="font-family:sans-serif;color:#464545;padding:15px 0 0 0">If you have any query or problem, please feel free to contact our support team:<br><br>You have received this mail from '.$fromname.'.com because you have subscribed to our Tender alert service.<br>
                <br>If you do not want to receive this mailer, 
                 <a href="" style="color: #ed7e2c;" title="'.$fromname.'" target="_blank">Unsubscribe</a>
              </td>
            </tr>
            <tr>
              <td>
                
              </td>
            </tr>
          </tbody>
        </table>
        </div>
        </center>';
        
    } else {
        //echo "#####";die();
    if ($u_val['productid'] == "" && $u_val['categoryid'] == "" && $u_val['subcategoryid'] == "" && $u_val['exe_productid'] == "" && $u_val['exe_categoryid'] == "" && $u_val['exe_subcategoryid'] == "" && $u_val['keyword'] != "") {
             
             $sql = "SELECT t.*,'India' as country,t.state_name as name,t.org_name as agencyname from ".$tablename." as t
                LEFT JOIN live_tenderinfo_items as lti ON t.ourrefno=lti.ourrefno
                where 1 = 1 ";  
    }else{
     
                 $sql = "SELECT t.*,tc.categoryid,tc.categoryid,tc.subcategory,'India' as country,t.state_name as name,t.org_name as agencyname from ".$tablename." as t
                INNER JOIN livetendercategory as tc ON t.ourrefno = tc.ourrefno 
                LEFT JOIN category as ct ON ct.id=tc.categoryid 
                LEFT JOIN industry as ti ON ti.id=ct.industry_id
                LEFT JOIN live_tenderinfo_items as lti ON t.ourrefno=lti.ourrefno
                where 1 = 1 ";
    }
    
     /********** item query start***********/
        $sql_items = "";
        if (!empty($u_val['keyword']) && $u_val['keyword'] != "") {
            $userkeyword = explode(",", $u_val['keyword']);
            $userkeyword = array_filter($userkeyword); 
            for ($i = 0; $i < count($userkeyword); $i++) {
                $sql_items .= " lti.item LIKE '%" . $userkeyword[$i] . "%' OR ";
                
            }
            $sql_items = trim($sql_items);
            $sql_items = rtrim($sql_items,'OR');
            $sql_items = trim($sql_items); 
            
            $sql_items = " OR ($sql_items)";
        }
        
        $sql_items = "";
        /********** item query end***********/
            
    if (!empty($u_val['productid']) || !empty($u_val['categoryid']) || !empty($u_val['subcategoryid']) || !empty($u_val['exe_productid']) || !empty($u_val['exe_categoryid']) || !empty($u_val['exe_subcategoryid'])) {
    
        	$product_ids = $u_val['productid'];
        
        	$cat_ids = $u_val['categoryid'];
        	
        	$subcat_ids = $u_val['subcategoryid'];
        	
        	$eproduct_ids = $u_val['exe_productid'];
        	
        	$ecat_ids = $u_val['exe_categoryid'];
        	
        	$esubcat_ids = $u_val['exe_subcategoryid'];
        	
        	$str_query = "";
        	if (!empty($u_val['productid']) || !empty($u_val['categoryid']) || !empty($u_val['subcategoryid'])) {
            
                    if ($product_ids != "") {
                        $str_query .= " ti.id IN (" . $product_ids . ") OR";
                    }
                    if ($cat_ids != "") {
                        $str_query .= " tc.categoryid IN (" . $cat_ids . ") OR";
                    }
                    if ($subcat_ids != "") {
                        $str_query .= " tc.subcategory IN (" . $subcat_ids . ") OR";
                    }
                    
                    $str_query = trim($str_query);
                    $str_query = rtrim($str_query,'OR');
                    $str_query = trim($str_query);
        	}
        	
            $str_query2 = "";
            $cate_table_name = "livetendercategory";
           if (!empty($u_val['exe_productid']) || !empty($u_val['exe_categoryid']) || !empty($u_val['exe_subcategoryid'])) {

               $str_query2 .= "SELECT ilc.ourrefno FROM $cate_table_name as ilc LEFT JOIN category as iec ON ilc.categoryid=iec.id WHERE ";
                if ($eproduct_ids != "") {
                    $str_query2 .= " iec.industry_id IN (" . $eproduct_ids . ") OR";//AND g
                }
                if ($ecat_ids != "") {
                    $str_query2 .= " ilc.categoryid IN (" . $ecat_ids . ") OR";//AND g
                }
                if ($esubcat_ids != "") {
                    $str_query2 .= " ilc.subcategory IN (" . $esubcat_ids . ") OR";//AND g
                }
                
                $str_query2 = trim($str_query2);
                $str_query2 = rtrim($str_query2,'OR');//AND g
                $str_query2 = trim($str_query2);

           }
             $sql .= " AND ( ";
             
                if($str_query != "" && $str_query2 != ""){
                    $sql .=  "(".$str_query.")";
                    //$sql .=  " AND (".$str_query2.")";
                }else if($str_query != ""){    
                $sql .=  "(".$str_query.")";
                }else if($str_query2 != ""){    
                //$sql .=  "(".$str_query2.")";
                }
                
                if (isset($u_val['is_exact_keyword']) && $u_val['is_exact_keyword'] == 1) {

                    if (!empty($u_val['keyword'])) {
                        //$sql .= " OR ( ";
                        if (!empty($u_val['productid']) || !empty($u_val['categoryid']) || !empty($u_val['subcategoryid'])) {
                            $sql .= " OR ( ";
                        } else {
                            $sql .= " ( ";
                        }
                        $userkeyword = explode(",", $u_val['keyword']);
                        $userkeyword = array_filter($userkeyword);
                        $sstr_ekeyword = "";
                        
                        for ($i = 0; $i < count($userkeyword); $i++) {

                            if($userkeyword[$i] != ""){
                            $sstr_ekeyword .= " t.Work LIKE '% " . $userkeyword[$i] . " %' OR ";
                            }
                        }
                        
                        $sstr_ekeyword = trim($sstr_ekeyword);
                        $sstr_ekeyword = rtrim($sstr_ekeyword,'OR');
                        $sstr_ekeyword = trim($sstr_ekeyword);
                        $sql .= $sstr_ekeyword;
                        $sql .= " ) ";
                    }
                } else {

                    if (!empty($u_val['keyword'])) {
                        
                        if (!empty($u_val['productid']) || !empty($u_val['categoryid']) || !empty($u_val['subcategoryid'])) {
                            $sql .= " OR ( ";
                        } else {
                            $sql .= " ( ";
                        }
                        $userkeyword = explode(",", $u_val['keyword']);
                        $userkeyword = array_filter($userkeyword);
                        $sstr_keyword = "";
                        for ($i = 0; $i < count($userkeyword); $i++) {

                            if($userkeyword[$i] != ""){
                             $sstr_keyword .= " t.Work LIKE '%" . $userkeyword[$i] . "%' OR ";
                            }
                        }
                        $sstr_keyword = trim($sstr_keyword);
                        $sstr_keyword = rtrim($sstr_keyword,'OR');
                        $sstr_keyword = trim($sstr_keyword);
                        $sql .= $sstr_keyword;
                        $sql .= " ) ";
                    }
                    
                    
                }
                
        $sql .= " $sql_items ) ";
        
       if($str_query2 != ""){    
            $sql .=  " AND t.ourrefno NOT IN (".$str_query2.")";
        }
        
    } else {

        if ($u_val['categoryid'] != 0 && $u_val['categoryid'] != '') {
            $sql .= " AND tc.categoryid IN (" . $u_val['categoryid'] . ")";
        }

        if ($u_val['subcategoryid'] != 0 && $u_val['subcategoryid'] != '') {
            $sql .= " AND tc.subcategory IN (" . $u_val['subcategoryid'] . ")";
        }

        if (isset($u_val['is_exact_keyword']) && $u_val['is_exact_keyword'] == 1) {

            if (!empty($u_val['keyword'])) {

                $userkeyword = explode(",", $u_val['keyword']);
                $userkeyword = array_filter($userkeyword);
                for ($i = 0; $i < count($userkeyword); $i++) {
                    
                    if($userkeyword[$i] != ""){
                        if (count($userkeyword) == 1) {
                            //$sql .= " AND t.Work  LIKE '% " . $userkeyword[$i] . " %'";
                            $sql .= " AND (t.Work  LIKE '% " . $userkeyword[$i] . " %' $sql_items)";
                        }
                        if (count($userkeyword) > 1) {
                            if ($i == 0) {
                                $sql .= " AND ((t.Work LIKE '% " . $userkeyword[$i] . " %' OR ";
                            } else if ($i == (count($userkeyword) - 1)) {
                                $sql .= " t.Work LIKE '% " . $userkeyword[$i] . " %') $sql_items)";
                            } else {
                                $sql .= " t.Work LIKE '% " . $userkeyword[$i] . " %' OR ";
                            }
                        }
                    }
                }
            }
        } else {

            if (!empty($u_val['keyword'])) {

                $userkeyword = explode(",", $u_val['keyword']);
                $userkeyword = array_filter($userkeyword);
                for ($i = 0; $i < count($userkeyword); $i++) {
                    if($userkeyword[$i] != ""){
                        if (count($userkeyword) == 1) {
                            //$sql .= " AND t.Work  LIKE '%" . $userkeyword[$i] . "%'";
                            $sql .= " AND (t.Work  LIKE '%" . $userkeyword[$i] . "%' $sql_items)";
                        }
                        if (count($userkeyword) > 1) {
                            if ($i == 0) {
                                $sql .= " AND ((t.Work LIKE '%" . $userkeyword[$i] . "%' OR ";
                            } else if ($i == (count($userkeyword) - 1)) {
                                $sql .= " t.Work LIKE '%" . $userkeyword[$i] . "%') $sql_items)";
                            } else {
                                $sql .= " t.Work LIKE '%" . $userkeyword[$i] . "%' OR ";
                            }
                        }
                    }
                }
            }
        }
    }

    //gautish
    $sdate = date('Y-m-d',strtotime("+3 days"));
    //$sql .= " AND t.submitdate >= '$sdate' ";  
    
    $sql .=  " AND (t.link2 != 'https://www.nationaltenders_manually.com')";  
    if (!empty($u_val['Min_Amount']) && !empty($u_val['Max_Amount'])) {
        $sql .= " AND `t`.`tenderamount` BETWEEN '" . $u_val['Min_Amount'] . "' AND  '" . $u_val['Max_Amount'] . "' ";
    } else if (!empty($u_val['Min_Amount']) && empty($u_val['Max_Amount'])) {
        $sql .= " AND (`t`.`tenderamount` >= '" . $u_val['Min_Amount'] . "' OR `t`.`tenderamount` = 0)";
    } else if (empty($u_val['Min_Amount']) && !empty($u_val['Max_Amount'])) {
        $sql .= " AND (`t`.`tenderamount` <= '" . $u_val['Max_Amount'] . "' OR `t`.`tenderamount` = 0)";
    }

    if (!empty($u_val['refine_keyword']) && !empty($u_val['refine_keyword'])) {
        $userrefinekeyword = explode(",", $u_val['refine_keyword']);
        $userrefinekeyword = array_filter($userrefinekeyword);
        for ($i = 0; $i < count($userrefinekeyword); $i++) {
            if($userrefinekeyword[$i] != ""){
            if (count($userrefinekeyword) == 1) {
                $sql .= " AND t.Work  LIKE '%" . $userrefinekeyword[$i] . "%'";
            }
            if (count($userrefinekeyword) > 1) {
                if ($i == 0) {
                    $sql .= " AND (t.Work LIKE '%" . $userrefinekeyword[$i] . "%' OR ";
                } else if ($i == (count($userrefinekeyword) - 1)) {
                    $sql .= " t.Work LIKE '%" . $userrefinekeyword[$i] . "%')";
                } else {
                    $sql .= " t.Work LIKE '%" . $userrefinekeyword[$i] . "%' OR ";
                }
            }
            }
        }
    }

    if (!empty($u_val['Agency'])) {
        $sql .= " AND t.agencyid IN (" . $u_val['Agency'] . ")";
    }
    if (!empty($u_val['excluding_agency'])) {
        $sql .= " AND t.agencyid NOT IN (" . $u_val['excluding_agency'] . ")";
    }

    if (!empty($u_val['excludingkeyword'])) {
        $userexcludingkeyword = explode(",", $u_val['excludingkeyword']);
        $userexcludingkeyword = array_filter($userexcludingkeyword);
        for ($j = 0; $j < count($userexcludingkeyword); $j++) {
            if($userexcludingkeyword[$j] != ""){
                if (count($userexcludingkeyword) == 1) {
                    $sql .= " AND t.Work NOT LIKE '%" . trim($userexcludingkeyword[$j]) . "%'";
                }
                if (count($userexcludingkeyword) > 1) {
                    if ($j == 0) {
                        $sql .= " AND (t.Work NOT LIKE '%" . trim($userexcludingkeyword[$j]) . "%' AND ";
                    } else if ($j == (count($userexcludingkeyword) - 1)) {
    
                        $sql .= " t.Work NOT LIKE '%" . trim($userexcludingkeyword[$j]) . "%')";
                    } else {
                        $sql .= " t.Work NOT LIKE '%" . trim($userexcludingkeyword[$j]) . "%' AND ";
                    }
                }
            }
            
        }
    }

    if (!empty($u_val['zone']) && empty($u_val['state'])) {
        $my_zone_state = array();
        $my_state = '';
        $zone_list = array();
        $zone_string = $u_val['zone'];
        $sql_p = "select * from state where zone_id in($zone_string)";
        $my_state_zone = mysqli_query($dbh1,$sql_p);
        while ($k_zone = mysqli_fetch_assoc($my_state_zone)) {
            $zone_list[] = $k_zone;
        }
        
        if (!empty($zone_list)) {
            foreach ($zone_list as $k => $v) {
                $my_zone_state[] = $v['id'];
            }
            $my_state = implode(',', $my_zone_state);
            $sql .= " AND `t`.`stateid` IN ( " . $my_state . " )";
        }
    }

    $state_ncr = array();
    if ($u_val['state'] != 0 && $u_val['state'] != '') {
        $state_ncr = explode(',', $u_val['state']);
        if ($u_val['city'] == '' && !empty($state_ncr) && in_array('380017', $state_ncr)) {

            $sql .= " AND ( t.stateid IN (" . $u_val['state'] . ")";
            $sql .= " or t.city IN ('Bhiwani','Faridabad','Gurgaon','Jhajjar','Mahendragarh','Panipat','Rewari','Rohtak','Sonipat', 'Mewat' , 'Palwal' , 'Jind' , 'Karnal' , 'Baghpat' , 'Bulandshahr' ,'Gautam Buddha Nagar', 'Ghaziabad' , 'Muzaffarnagar' , 'Meerut' , 'Hapur' , 'Alwar' , 'Bharatpur','Noida','Delhi','New Delhi','SHAKURBASTI','TUGLAKABAD','Sakurbasit','Adarsh Nagar','Badli','Brar Square','Bijwasan','Chanakyapuri','Shivaji Bridge','Azadpur','Dayabasti','Delhi Cantt','Delhi Sarai Rohilla','Delhi KishanGanj','Old Delhi','Indrapuri','Shahdara','Sadar Bazar','Delhi Safdarjung','Ghevra','Holambi Kalan','Khera Kalan','Lodi Colony','Lajpat Nagar','Mangolpuri','Mundka','Naya Azadpur','Nangloi','Naraina Vihar','Narela','Delhi Hazrat Nizamuddin','Okhla','Pragati Maidan','Palam','Patel Nagar','Rajlu Garhi','Sardar Patel Road','Sandal Kalan','Shahabad Mohamadpur','Sarojini Nagar','Sewa Nagar','Delhi Sabzi Mandi','Tilak Bridge','Vivek Vihar','Vivekanand Puri Halt')";
            $sql .= " )";
        } else {
            $sql .= " AND t.stateid IN (" . $u_val['state'] . ")";
        }
    }
    if ($u_val['city'] != '') {      
        $city_explode=array();
        $city_explode = explode(',', $u_val['city']);

        $city1 = "'" . implode("','", $city_explode) . "'";
        $sql .= " AND t.city IN (" . $city1 . ")";
    }
  
    if (!empty($u_val['form_of_contract'])) {
        $my_contract = explode(',', $u_val['form_of_contract']);
        $contract = "'" . implode("','", $my_contract) . "'";
        $sql .= " AND (`t`.`form_of_contract` in ($contract) or `t`.`form_of_contract` ='')";
    }

    if (!empty($u_val['portal']) && $u_val['portal'] != "") {
    
        if($u_val['portal'] == "GEM")
        {   
            $sql .= " AND t.link2 in ('https://bidplus.gem.gov.in','https://bidplus.gem.gov.in/bunch','https://bidplus.gem.gov.in/custom','https://bidplus.gem.gov.in/sbunch','https://bidplus.gem.gov.in/service')";
        }else{
            $sql .= " AND t.link2 not in ('https://bidplus.gem.gov.in','https://bidplus.gem.gov.in/bunch','https://bidplus.gem.gov.in/custom','https://bidplus.gem.gov.in/sbunch','https://bidplus.gem.gov.in/service')";
        }
    }
    $sql1 = $sql;
    $sql .= " AND t.dt > '" . $my_paid_mail_date . "' AND t.submitdate >= '" . date('Y-m-d') . "' group by t.ourrefno ORDER BY t.ourrefno ASC LIMIT 1000"; //t.state_name
    $sql1 .= " AND t.dt > '" . $my_paid_mail_date . "' AND t.submitdate >= '" . date('Y-m-d') . "' group by t.ourrefno limit 0,1000";
 //echo $sql;die();
    $my_fresh_tender = mysqli_query($dbh1,$sql); // gautish
   
    if ($my_fresh_tender === false) {
        echo "  -> SQL query failed for this user: " . mysqli_error($dbh1) . "\n";
        continue; // Skip to the next user
    }

    $u_tender_listing = array();

    while ($k = mysqli_fetch_assoc($my_fresh_tender)) {
        $u_tender_listing[] = $k;
    }
    
    $res = array();
    $my_names = '';
    if (!empty($u_val['keyword'])) {
        $my_names = $u_val['keyword'];
    }

    if (!empty($my_names)) {
        $str1 = trim($my_names);
        $str2 = preg_replace('/\s*,\s*/', ',', $str1);
        $str_4 = explode(',', $str2);
        $res = array_filter($str_4);
        $res = array_values($res);
        array_multisort(array_map('strlen', $res), $res);
        $res = array_reverse($res);
    }

    if (!empty($u_tender_listing)) { //$subject_date $latest_date
        $tender_count = 0;
        $tender_count = count($u_tender_listing);
        $subject = " Fresh Tender of Your Category (" . $tender_count . ") - " . $subject_date . " || " . $company_name;
    } else {
        $tender_count = 0;
        $subject = " Fresh Tender of Your Category (" . $tender_count . ") - " . $subject_date . " || " . $company_name;
    }
     
$body .= '<center>
<div style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#464545;line-height:20px">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tbody>
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%">
                <tbody>
                    <tr>
                        <td align="left">
                            <h3 style="font-family:Arial;margin-bottom:5px">Welcome '.$uname.'</h3>
                            <h4 style="font-family:Arial;margin-top:5px">'.$company_name.'</h4>
                        </td>
                        <td align="right">
                         <img src="'.$logo_url.'"  width="250" alt="'.$fromname.'">
                        </td>
                    </tr>
                </tbody>
            </table>
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%">
                <tbody>
                    <tr>
                        <td width="100%">
                            <hr width="100%" align="center" style="margin-top:0px;margin-bottom:0px">
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%">
                <tbody>
                    <tr>
                        <td width="100%">
                            <hr width="100%" align="center" style="margin-top:0px;margin-bottom:0px">
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
      <td>
        
      </td>
    </tr>
    <tr>
      <td style="font-family:sans-serif;color:#464545;padding:15px 0 0 0">Dear Member,<br>If the tenders sent to you are not relevant or the query needs to be updated,we request you to mail us at <a style="text-decoration:none;color:#105fff!important" href="mailto:'.$mailto.'" target="_blank">'.$mailto.'</a> with the exact Product / Service / Categories of which you would like to receive the tenders to serve you better.<br>
      </td>
    </tr>
    <tr>
      <td>
        <table cellspacing="0" cellpadding="0" style="font-family:Arial,Helvetica,sans-serif;border:1px solid #'.$colorcode.'">
          <thead>
            <tr style="background-color:#'.$colorcode.'">
              <td style="width:65%;line-height:14px;text-transform:uppercase;border-right:1px solid #a69e9e;border-bottom:1px solid #dfdfdf" align="left" valign="middle">
                <p style="font-family:sans-serif;color:#fff;margin-left:9px;float:left;font-size:13px;font-stretch:normal">
                  <b>TENDER DETAILS</b>
                </p>
              </td>
              <td style="width:20%;line-height:14px;text-transform:uppercase;border-bottom:1px solid #dfdfdf;border-right:1px solid #a69e9e" valign="middle">
                <p style="font-size:13px;font-stretch:normal;text-align:center;font-family:sans-serif;color:#fff">
                  <b>ORGANIZATION &amp; LOCATION</b>
                </p>
              </td>
              <td style="width:15%;line-height:14px;text-transform:uppercase;border-bottom:1px solid #dfdfdf" valign="middle">
                <p style="font-size:13px;font-stretch:normal;text-align:center;font-family:sans-serif;color:#fff">
                  <b>VALUE &amp; DEADLINE</b>
                </p>
              </td>
            </tr>
          </thead>
          <tbody>';

    if (!empty($u_tender_listing)) {
       
        // echo "heloo";die();
        $im = 0;
        foreach ($u_tender_listing as $key => $val) {
            $im++;
           
            if (count($res) >= 1) {
                //$str = $val['Work'];
                $str = (strlen($val['Work']) > 300) ? substr($val['Work'], 0, 300).'...' : $val['Work'];
                
                $str = preg_replace('~[\r\n]+~', '', trim($str));
                $str = preg_replace('/\s+/', ' ', $str);
                $str = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $str);
                
                for ($i = 0; $i < count($res); $i++) {
                    if (!empty($res[$i])) {
                        $keyword = $res[$i];
                        $lengthkeyword = strlen($keyword);
                        if($lengthkeyword > 2){
                        $str = @preg_replace("/($keyword)/i", '<span style="font-weight:bold;color:#ef0c0c;">$1</span>', $str);
                        }
                    }
                }
                 
            } else {
                $str = $val['Work'];
            }
            if($str == ""){
                $str = $val['Work'];
            }
           
            if (!empty($val['city']) && in_array($val['city'], $delhi_ncr) && !empty($val['name'])) {
                $my_state_name = "[" . ucwords(strtolower($val['name'])) . " / " . " Delhi NCR]";
            } else {
                $my_state_name = ucwords(strtolower($val['name']));
            }

$state_name = strtolower($my_state_name);
$state_name = $state_name . ' tenders';
$state_name = str_replace('/', '', $state_name);
$state_name = str_replace('.', '', $state_name);
$state_name = str_replace(',', '', $state_name);
$state_name = str_replace('(', '', $state_name);
$state_name = str_replace(')', '', $state_name);
$state_name = urlencode($state_name);
$state_name = trim($state_name);
$state_name = str_replace('+', '-', $state_name);
$state_name = trim($state_name);
 
$org_name = strtolower($val['agencyname']);
$org_name = $org_name . ' tenders';
$org_name = str_replace('/', '', $org_name);
$org_name = str_replace('.', '', $org_name);
$org_name = str_replace(',', '', $org_name);
$org_name = str_replace('(', '', $org_name);
$org_name = str_replace(')', '', $org_name);
$org_name = urlencode($org_name);
$org_name = trim($org_name);
$org_name = str_replace('+', '-', $org_name);
$org_name = trim($org_name);

$my_org_name = strtolower($val['org_name']);
$my_org_name = ucwords(trim($my_org_name));

$city_name = strtolower($val['city']);
$city_name = $city_name . ' tenders';
$city_name = str_replace('/', '', $city_name);
$city_name = str_replace('.', '', $city_name);
$city_name = str_replace(',', '', $city_name);
$city_name = str_replace('(', '', $city_name);
$city_name = str_replace(')', '', $city_name);
$city_name = urlencode($city_name);
$city_name = trim($city_name);
$city_name = str_replace('+', '-', $city_name);
$city_name = trim($city_name);
$my_city_name = $val['city'];
$my_city_name = strtolower($my_city_name);
$my_city_name = ucwords(trim($my_city_name));  

            $str = (strlen($str) > 300) ? substr($str, 0, 300).'...' : $str; // change 2022-06-08   
          $body .=' <tr>
              <td width="65%" style="border-right:1px solid #a69e9e;border-bottom:1px solid #'.$colorcode.';padding-bottom:5px">
                <table width="100%" style="font-family:sans-serif;font-size:13px">
                  <tbody>
                    <tr>
                      <td>
                        <table>
                          <tbody>
                            <tr>
                              <td width="5%;" style="padding-top:10px">
                                <strong>' . $im . '.</strong>
                              </td>
                              <td width="95%;" style="padding-top:10px;font-family:Arial,sans-serif">'.$tid.' : 
                                <label style="color:black;font-size:15px;line-height:20px">'.$val['ourrefno'].'</label>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="padding-top:5px;font-family:Arial,sans-serif;text-transform:capitalize">
           
                        <a href="' . $full_details_path . '?tid=' . base64_encode($val['ourrefno']) . '&uid=' . $user_id . '" style="text-decoration:none;color:black;font-size:15px;line-height:20px" target="_blank">' . $str . '</a>
                      </td>
                    </tr>
                    <tr>
                      <td width="45%;" align="right">
                        
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
              <td style="width:20%;color:#41515e;text-align:center;border-bottom:1px solid #'.$colorcode.';padding-bottom:5px;border-right:1px solid #a69e9e">
                <p style="font-family:sans-serif;font-size:13px;font-stretch:normal;line-height:23px">
                  <span style="color:#000;font-weight:bold;padding:0px 2px">'.$my_org_name.'</span><br><br>'.$my_city_name.', '.$my_state_name.'</p>
              </td>
              <td style="width:15%;color:#41515e;text-align:center;border-bottom:1px solid #'.$colorcode.';padding-bottom:5px">
                <p style="font-family:sans-serif;font-size:13px;font-stretch:normal;line-height:23px">
                  <span style="color:#464545"><span style="color:black">'.$val['tenderamount'].' (approx.) </span></span><br><br>'.$val['submitdate'].'
                </p>
              </td>
            </tr>';

            $email_sent_status = 1;
            $tender_array[] = $val['ourrefno'];
        } // end loop 

    } else {
        $email_sent_status = 1;
         
            $body .= '<tr><td><div style="float:left;width:100%;height:auto;">
            <div style="float:left;width:92%;height:auto; margin:2%; padding: 2%; border: 1px solid #ccc;"> 
            <div style="float:left;width:100%;height:auto;">  
            <span style="margin-right:10px;font-weight:bold;font-size:20px;">Todays! No Fresh Tender for You.</span>
            </div>
            </div>
            </div></td></tr>';
                }


$body .=' </tbody>
        </table>
      </td>
    </tr>

    <tr>
      <td>
        <br>
      </td>
    </tr>
    
    <tr>
      <td style="font-family:sans-serif;color:#464545;padding:15px 0 0 0">If you have any query or problem, please feel free to contact our support team:<br><br>You have received this mail from '.$fromname.'.com because you have subscribed to our Tender alert service.<br>
        <br>If you do not want to receive this mailer, 
         <a href="" style="color: #ed7e2c;" title="'.$fromname.'" target="_blank">Unsubscribe</a>
      </td>
    </tr>
    <tr>
      <td>
      
        <p> <b>Warm Regards,</b></p>
        <p>'.$fromname.'</p>
        <p>For Support: '.$phone.'</p>
        <p>E-mail Id : '.$emailid.'</p>
        <p>Website: '.$website.'</p>

      </td>
    </tr> 
    
    <tr>
      <td>
      <br>
        <p> <b>Disclaimers :</b> The information transmitted is meant only for the addressee and may contain confidential and/or privileged information. Any review re-transmission, dissemination, use either in part or in full, by any person other than the intended recipient is prohibited. If you have received this mail in error, please return to the sender and delete the received material. All mails transmitted from '.$fromname.' is virus checked. However please do a virus check at your end before opening or downloading the message or attachments. We will not accept any liability whatsoever for damages through virus.</p>
      </td>
    </tr>
  </tbody>
</table>
</div>
</center>';  

}
//echo $body;die();
    $email_recipients[] = $u_val['email'];

    //$mail->AddAddress($u_val['email'], $u_val['user_first_name']);
    if (!empty($u_val['alt_email'])) {
        $secondary_email = explode(',', $u_val['alt_email']);
        foreach ($secondary_email as $km => $vm) {
            //$mail->AddAddress($vm, $u_val['user_first_name']);
            $email_recipients[] = trim($vm);
        }
    }
    //print_r($email_recipients); die();
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
   
    // More headers
    $headers .= 'From:'.$emailid . "\r\n";
    $headers .= 'X-Mailer: PHP/'."\r\n";
    $headers .= 'Cc: '.$ccmailto. "\r\n";
    $headers .= "X-Priority: 1 (Highest)\n";
    $headers .= "X-MSMail-Priority: High\n";
    $headers .= "Importance: High\n";
    
    $email_to = implode(',', $email_recipients);
    $chk_userid = $u_val['user_id'];
    $todaydate = date('Y-m-d');

    $querychecksend = "SELECT * FROM userinfo WHERE user_id = '$chk_userid' AND tender_date='$todaydate'";
  
    $resultchk = mysqli_query($dbh2,$querychecksend);
    if ($resultchk) {
      if (mysqli_num_rows($resultchk) > 0) {
        echo 'exist!';
      } else {
        echo 'sent';

            /*****************mail send using smtp for domain email id***********************/
            //print_r($email_recipients); die();
            $mailsent = email_phpmailer($email_recipients, $subject, $body,$emailUser,$emailPassword,$from,$fromname,$host);
            sleep(1);
            
            /*****************mail send using smtp for domain email id***********************/
             
             $totalemail = count($email_recipients);
             $totalemail = $totalemail + 1;
             $emailtype = 1; //for 0 self 1 for own
             $emailstatus = 1; //for free 1 for paid  
             
            if ($email_sent_status == 1) {
              
                $live_tender_count = 0;
                if($mailsent == "Message has been sent successfully"){
                  
                $sql = "insert into userinfo (user_id,tender_date,status,is_live_tender_setting,total_fresh,total_live,support_executive,no_tender_available,emailtype) values ('" . $u_val['user_id'] . "','" . date('Y-m-d') . "','$emailstatus','0','" . $tender_count . "','" . $live_tender_count . "','0','$totalemail','$emailtype')";
                
                $my_query_execute = mysqli_query($dbh2,$sql);
                
                }else{
                    echo $mailsent."<br><br>";
                }
               
            }
    
      }
    } else {
        echo 'Error checking userinfo: '.mysqli_error($dbh2); // <-- CORRECT
    }
    $body = '';
    $email_to = '';
    $subject = '';
    $email_recipients = array();
    
}

$is_send = true; // for break second time 
//dislaying message
$latest_date = date('Y-m-d');
$comment = "Admin has sent email to paid user at " . $latest_date;


date_default_timezone_set('Asia/Kolkata');
$subject = 'Paid User '.$fromname.' Tender Mail '.date('Y-m-d')." Today";
$body = $comment.' '.date('Y-m-d H:i:s')." Today!";

$sql_remaining_send_email = "SELECT COUNT(*) as total from users as user LEFT JOIN userproduct on user.id=userproduct.user_id where user.is_tender=1 and userproduct.todate>='".$dates."' and user.status='Paid' AND user.id NOT IN(SELECT user_id FROM userinfo WHERE userinfo.tender_date='".$dates."')";

$query_remaining_send_email = mysqli_query($dbh2,$sql_remaining_send_email);
$row_remaining_send_email = mysqli_fetch_assoc($query_remaining_send_email);
$count_remaining_send_email = $row_remaining_send_email['total'];

if ($count_remaining_send_email == 0) { 
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        // More headers
        $headers .= 'From: '.$fromname.' <'.$from_email.'>' . "\r\n";
        //$this_mail = mail($finish_email_to, $subject, $body,$headers);
        $email_recipients = array('nishap.gemtenderconsultant@gmail.com');
         $mailsent = email_phpmailer($email_recipients, $subject, $body,$emailUser,$emailPassword,$from,$fromname,$host);
        //sleep(1);
}
 
}
?>