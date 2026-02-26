<?php
//ini_set('max_execution_time', 0);  // no time limit
//ini_set('memory_limit', '-1');     // unlimited memory
// Define the log file path
$log_file = '/home/tenderkhabar/web/tenderkhabar.in/public_html/logs/datewise_livetenders.log';

// Function to log messages
function log_message($message, $log_file)
{
    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "[{$timestamp}] {$message}" . PHP_EOL;

    // Ensure the logs directory exists
    if (!is_dir(dirname($log_file))) {
        mkdir(dirname($log_file), 0755, true);
    }

    $file_handle = fopen($log_file, 'a');
    fwrite($file_handle, $log_entry);
    fclose($file_handle);
}

log_message("Script started", $log_file);

$page   = 1;
$limit  = 10000;
$total  = 0;
$pages  = 1;
$checkpage = 1;

if (isset($_GET['start']) && isset($_GET['end'])) {
    $page = $_GET['start'];
    $pages = $_GET['end'];
} else {
    //$date = date('Y-m-d', strtotime('-1 days'));
}


if (isset($_GET['date'])) {
    $date = $_GET['date'];
} else {
    $date = date('Y-m-d', strtotime('-1 days'));
}
//echo $page;die();
do {

    //log_message("Processing date: $date", $log_file);
    //public_html/gautish/clientapi/live_tenders_api_datewise.php
    // Step 1: Make the external API call first to avoid database timeouts.
    $url = 'https://category.nationaltenders.in/clientapi/all_live_tenders_api.php?api_key=2e36e49990a44d10354a08d7098460c2faa542ff7576a92ec16595b84c2adbe4&page=' . $page;
    //echo "<br>start ".$url;die();

    /*$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response2 = curl_exec($ch);
if ($response2 === false) {
    log_message("cURL Error: " . curl_error($ch), $log_file);
    die("Error: Failed to fetch data from API. Check the log for details.");
}
curl_close($ch);
*/
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response2 = curl_exec($ch);
    curl_close($ch);


    if ($page == 5) {
        //print_r($responsedata);die();
    }


    $response = json_decode($response2, true);

    if ($response === null) {
        log_message("JSON Decode Error: " . json_last_error_msg(), $log_file);
        die("Error: Failed to decode API response. Check the log for details.");
    }
    // print_r($response);die();
    // Step 2: Now that the slow API call is done, include the database configuration.
    include('/home/tenderkhabar/web/tenderkhabar.in/public_html/public/dataapi/config_mysqli.php');

    if ($response['status'] === true) {
        $totalrecords = $response['total'];

        if (isset($_GET['start']) && isset($_GET['end'])) {
        } else {
            if ($page == $checkpage) {
                // First time we get total count
                $total = isset($response['total']) ? (int)$response['total'] : 0;
                $pages = ceil($total / $limit);
                echo "Total Records: $total, Total Pages: $pages\n";
            }
        }

        log_message("Total records from API: $totalrecords", $log_file);

        if (isset($_GET['start']) && isset($_GET['end'])) {
        } else {
            if ($page == $checkpage) {
                $sqlchecklive = "SELECT COUNT(*) as totaldate FROM live_tenders";
                //echo $sqlchecklive;//die();
                log_message("start total count from query", $log_file);
                $queryalllivecount = mysqli_query($dbh1, $sqlchecklive); // UPDATED to use $dbh1
                log_message("get total count from query", $log_file);
                //echo "Query Success<br>";die();
                if ($queryalllivecount === false) {
                    log_message("MySQL Error: " . mysqli_error($dbh1), $log_file); // UPDATED to use $dbh1
                    die("Error: Failed to query database. Check the log for details.");
                }

                $rowtotal = mysqli_fetch_assoc($queryalllivecount);
                $totaldate = $rowtotal['totaldate'];
                // $totaldate = 10000;

                log_message("Total records in database for date $date: $totaldate", $log_file);
            }
        }



        if ($totaldate != $totalrecords) {

            log_message("Mismatch in record count. Updating database.", $log_file);

            foreach ($response['result'] as $key => $val) {
                $ourrefno = $val['ourrefno'];
                // The custom_real_escape_string function will now correctly use $dbh1
                $TenderNo = custom_real_escape_string($val['TenderNo']);
                $purfromdate = $val['purfromdate'];
                $submitdate = $val['submitdate'];
                $opendate = $val['opendate'];
                $tenderamount = $val['tenderamount'];
                $earnestamount = $val['earnestamount'];
                $doccost = $val['doccost'];
                $org_name = custom_real_escape_string($val['org_name']);
                $agencyid = $val['agencyid'];
                $address = custom_real_escape_string($val['address']);
                $Work = custom_real_escape_string($val['Work']);
                $state_name = $val['state_name'];
                $stateid = $val['stateid'];
                $city = $val['city'];
                $dt = $val['dt'];
                $documentpath = $val['documentpath'];
                $tender_ref_id = custom_real_escape_string($val['tender_ref_id']);
                $link2 = $val['link2'];
                $tendertype = custom_real_escape_string($val['tendertype']);
                $form_of_contract = custom_real_escape_string($val['form_of_contract']);
                $pincode = $val['pincode'];
                $countryid = $val['countryid'];
                $type_2 = custom_real_escape_string($val['type_2']);
                $link = custom_real_escape_string($val['link']);

                // Check and insert/update live_tenders
                $sqlcheck = "SELECT ourrefno FROM `live_tenders` WHERE ourrefno='$ourrefno'";
                $querycheck = mysqli_query($dbh1, $sqlcheck); // UPDATED to use $dbh1
                if ($querycheck === false) {
                    log_message("MySQL Error (live_tenders insert): " . mysqli_error($dbh1), $log_file); // UPDATED to use $dbh1
                } else {
                    log_message("count into live_tenders: $ourrefno", $log_file);
                }
                if (mysqli_num_rows($querycheck) == 0) {
                    $sqlinsert = "INSERT INTO `live_tenders` (`ourrefno`, `TenderNo`, `purfromdate`, `submitdate`, `opendate`, `tenderamount`, `earnestamount`, `doccost`, `org_name`, `agencyid`, `address`, `city`, `pincode`, `Work`, `countryid`, `state_name`, `stateid`, `dt`, `documentpath`, `tender_ref_id`, `link2`, `is_corro`, `tender_catgeory1`, `tender_catgeory2`, `link`, `form_of_contract`, `item`) VALUES 
                ('$ourrefno','$TenderNo','$purfromdate','$submitdate','$opendate','$tenderamount','$earnestamount','$doccost','$org_name','$agencyid','$address','$city','$pincode','$Work','$countryid','$state_name','$stateid','$dt','$documentpath','$tender_ref_id','$link2','0','$tendertype','$type_2','$link','$form_of_contract','')";

                    $insert = mysqli_query($dbh1, $sqlinsert); // UPDATED to use $dbh1
                    if ($insert === false) {
                        log_message("MySQL Error (live_tenders): " . mysqli_error($dbh1), $log_file); // UPDATED to use $dbh1
                    } else {
                        log_message("Inserted new record into live_tenders: $ourrefno", $log_file);
                    }
                } else {

                    $sqlupdate = "UPDATE `live_tenders` SET 
                `TenderNo` = '$TenderNo',
                `purfromdate` = '$purfromdate',
                `submitdate` = '$submitdate',
                `opendate` = '$opendate',
                `tenderamount` = '$tenderamount',
                `earnestamount` = '$earnestamount',
                `doccost` = '$doccost',
                `org_name` = '$org_name',
                `agencyid` = '$agencyid',
                `address` = '$address',
                `city` = '$city',
                `pincode` = '$pincode',
                `Work` = '$Work',
                `countryid` = '$countryid',
                `state_name` = '$state_name',
                `stateid` = '$stateid',
                `dt` = '$dt',
                `documentpath` = '$documentpath',
                `tender_ref_id` = '$tender_ref_id',
                `link2` = '$link2',
                `is_corro` = '0',
                `tender_catgeory1` = '$tendertype',
                `tender_catgeory2` = '$type_2',
                `link` = '$link',
                `form_of_contract` = '$form_of_contract',
                `item` = ''
            WHERE `ourrefno` = '$ourrefno'";

                    $update = mysqli_query($dbh1, $sqlupdate);
                    if ($update === false) {
                        log_message("MySQL Error (live_tenders update): " . mysqli_error($dbh1), $log_file); // UPDATED to use $dbh1
                    } else {
                        log_message("Inserted new record into live_tenders: $ourrefno", $log_file);
                    }
                }

                // Check and insert/update tenderinfo_2017
                $sqlcheck2 = "SELECT ourrefno FROM `tenderinfo_2017` WHERE ourrefno='$ourrefno'";
                $querycheck2 = mysqli_query($dbh1, $sqlcheck2); // UPDATED to use $dbh1
                if ($querycheck2 === false) {
                    log_message("MySQL Error (tenderinfo_2017): " . mysqli_error($dbh1), $log_file); // UPDATED to use $dbh1
                } else {
                    log_message("count into tenderinfo_2017: $ourrefno", $log_file);
                }
                if (mysqli_num_rows($querycheck2) == 0) {
                    $sqlinsert2 = "INSERT INTO `tenderinfo_2017` (`ourrefno`, `TenderNo`, `purfromdate`, `submitdate`, `opendate`, `tenderamount`, `earnestamount`, `doccost`, `org_name`, `agencyid`, `address`, `city`, `pincode`, `Work`, `countryid`, `state_name`, `stateid`, `dt`, `documentpath`, `tender_ref_id`, `link2`, `is_corro`, `tender_catgeory1`, `tender_catgeory2`, `link`, `form_of_contract`, `item`) VALUES 
                ('$ourrefno','$TenderNo','$purfromdate','$submitdate','$opendate','$tenderamount','$earnestamount','$doccost','$org_name','$agencyid','$address','$city','$pincode','$Work','$countryid','$state_name','$stateid','$dt','$documentpath','$tender_ref_id','$link2','0','$tendertype','$type_2','$link','$form_of_contract','')";

                    $insert2 = mysqli_query($dbh1, $sqlinsert2); // UPDATED to use $dbh1

                    if ($insert2 === false) {
                        log_message("MySQL Error (tenderinfo_2017 insert): " . mysqli_error($dbh1), $log_file); // UPDATED to use $dbh1
                    } else {
                        log_message("Inserted new record into tenderinfo_2017: $ourrefno", $log_file);
                    }
                } else {
                    $sqlupdate2 = "UPDATE `tenderinfo_2017` SET 
                `TenderNo` = '$TenderNo',
                `purfromdate` = '$purfromdate',
                `submitdate` = '$submitdate',
                `opendate` = '$opendate',
                `tenderamount` = '$tenderamount',
                `earnestamount` = '$earnestamount',
                `doccost` = '$doccost',
                `org_name` = '$org_name',
                `agencyid` = '$agencyid',
                `address` = '$address',
                `city` = '$city',
                `pincode` = '$pincode',
                `Work` = '$Work',
                `countryid` = '$countryid',
                `state_name` = '$state_name',
                `stateid` = '$stateid',
                `dt` = '$dt',
                `documentpath` = '$documentpath',
                `tender_ref_id` = '$tender_ref_id',
                `link2` = '$link2',
                `is_corro` = '0',
                `tender_catgeory1` = '$tendertype',
                `tender_catgeory2` = '$type_2',
                `link` = '$link',
                `form_of_contract` = '$form_of_contract',
                `item` = ''
            WHERE `ourrefno` = '$ourrefno'";

                    $update2 = mysqli_query($dbh1, $sqlupdate2);
                    if ($update === false) {
                        log_message("MySQL Error (tenderinfo_2017 update): " . mysqli_error($dbh1), $log_file); // UPDATED to use $dbh1
                    } else {
                        log_message("Inserted new record into tenderinfo_2017: $ourrefno", $log_file);
                    }
                }
            }
        } else {
            log_message("No mismatch in record count. No updates needed.", $log_file);
        }
    } else {
        // This will log the exact reason the API returned a false status
        log_message("API returned false status. Full Response: " . json_encode($response), $log_file);
    }
    echo $page . " " . $pages . "<br>";
    $page++;
    echo $page . " gj " . $pages . "<br>";
} while ($page <= $pages);

log_message("Script finished", $log_file);
echo "finish";
