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
}

if (isset($_GET['date'])) {
    $date = $_GET['date'];
} else {
    $date = date('Y-m-d', strtotime('-1 days'));
}
do {
    //log_message("Processing date: $date", $log_file);
    // Step 1: Make the external API call first to avoid database timeouts.
    $url = 'https://category.nationaltenders.in/clientapi/all_live_tenders_api.php?api_key=2e36e49990a44d10354a08d7098460c2faa542ff7576a92ec16595b84c2adbe4&page=' . $page;
    //echo "<br>start ".$url;die();

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
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
                log_message("Total records in database for date $date: $totaldate", $log_file);
            }
        }
        if ($totaldate != $totalrecords) {
            log_message("Mismatch in record count. Updating database.", $log_file);
            foreach ($response['result'] as $key => $val) {
                                        
                    $tenderid = $val['tenderid'] ?? null;
                    $sourcetenderid = custom_real_escape_string($val['sourcetenderid'] ?? '');
                    $value = $val['value'] ?? 0;
                    $biddeadline = $val['biddeadline'] ?? null;
                    $emd = $val['emd'] ?? 0;//authority
                    $documentcost = $val['documentcost'] ?? 0;//currency
                    $authority = custom_real_escape_string($val['authority'] ?? ''); //tenderdetails
                    $currency = $val['currency'] ?? null;
                    $tenderdetails = custom_real_escape_string($val['tenderdetails'] ?? '');
                    $tenderdescription = custom_real_escape_string($val['tenderdescription'] ?? '');
                    $prebidmeetingdate = $val['prebidmeetingdate'] ?? null;
                    $datecreated = $val['datecreated'] ?? null;
                    $corrigenduminfo = $val['corrigenduminfo'];
                    $sector = $val['sector'];
                    $subindustry = $val['subindustry'] ?? '';
                    $sourceurl = $val['sourceurl'] ?? '';
                    
                    $completionofwork = $val['completionofwork'] ?? '';
                    $ai_summary = $val['ai_summary'] ?? '';
                    $location = $val['location'][0] ?? [];
                    $city = $location['city'] ?? '';
                    $cityid = null;//city id
                    $state = $location['state'] ?? '';
                    $stateid = null;//state id
                    $country = $location['country'] ?? '';
                    $countryid = null;//country id
                    $documents = $val['documents'][0] ?? [];
                    $documentpath = $document['downloadLink'] ?? '';
                    $zipdocumentdownload = $val['zipdocumentdownload'] ?? '';
                    $dt = $val['datecreated'] ?? null;
                    // Check and insert/update live_tenders
                $sqlcheck = "SELECT id FROM `tenders247_data_2026` WHERE tenderid='$tenderid'";
                $querycheck = mysqli_query($dbh1, $sqlcheck); // UPDATED to use $dbh1
                if ($querycheck === false) {
                    log_message("MySQL Error (live_tenders insert): " . mysqli_error($dbh1), $log_file); // UPDATED to use $dbh1
                } else {
                    log_message("count into live_tenders: $tenderid", $log_file);
                }
                if (mysqli_num_rows($querycheck) == 0) {
                    $sqlinsert = "INSERT INTO `live_tenders` (`tenderid`, `sourcetenderid`, `value`, `biddeadline`, `emd`, `documentcost`, `authority`, `currency`, `tenderdetails`, `tenderdescription`, `prebidmeetingdate`, `datecreated`, `corrigenduminfo`, `sector`, `subindustry`, `sourceurl`, `completionofwork`, `ai_summary`, `location`, `city`, `cityid`, `state`, `stateid`, `country`, `countryid`, `documents`, `documentpath`,`zipdocumentdownload`) VALUES 
                        ('$tenderid','$sourcetenderid','$value','$biddeadline','$emd','$documentcost','$authority','$currency','$tenderdetails','$tenderdescription','$prebidmeetingdate','$datecreated','$corrigenduminfo','$sector','$subindustry','$sourceurl','$completionofwork','$ai_summary','$location','$city','$cityid','$state','$stateid','$country','$countryid','$documents','$documentpath','$zipdocumentdownload')";
                    $insert = mysqli_query($dbh1, $sqlinsert); // UPDATED to use $dbh1
                    if ($insert === false) {
                        log_message("MySQL Error (live_tenders): " . mysqli_error($dbh1), $log_file); // UPDATED to use $dbh1
                    } else {
                        log_message("Inserted new record into live_tenders: $tenderid", $log_file);
                    }
                } else {
                    $sqlupdate = "UPDATE `live_tenders` SET 
                    `sourcetenderid` = '$sourcetenderid',
                    `value` = '$value',
                    `biddeadline` = '$biddeadline',
                    `emd` = '$emd',
                    `documentcost` = '$documentcost',
                    `authority` = '$authority',
                    `currency` = '$currency',
                    `tenderdetails` = '$tenderdetails',
                    `tenderdescription` = '$tenderdescription',
                    `prebidmeetingdate` = '$prebidmeetingdate',
                    `datecreated` = '$datecreated',
                    `corrigenduminfo` = '$corrigenduminfo',
                    `sector` = '$sector',
                    `subindustry` = '$subindustry',
                    `sourceurl` = '$sourceurl',
                    `completionofwork` = '$completionofwork',
                    `ai_summary` = '$ai_summary',
                    `location` = '$location',
                    `city` = '$city',
                    `cityid` = '$cityid',
                    `state` = '$state',
                    `stateid` = '$stateid',
                    `country` = '$country',
                    `countryid` = '$countryid',
                    `documents` = '$documents',
                    `documentpath` = '$documentpath',
                    `zipdocumentdownload` = '$zipdocumentdownload'
                    WHERE `tenderid` = '$tenderid'";
                    $update = mysqli_query($dbh1, $sqlupdate);
                    if ($update === false) {
                        log_message("MySQL Error (live_tenders update): " . mysqli_error($dbh1), $log_file); // UPDATED to use $dbh1
                    } else {
                        log_message("Inserted new record into live_tenders: $tenderid", $log_file);
                    }
                }

                // Check and insert/update tenderinfo_2017
                $sqlcheck2 = "SELECT tenderid FROM `tenderinfo_2017` WHERE tenderid='$tenderid'";
                $querycheck2 = mysqli_query($dbh1, $sqlcheck2); // UPDATED to use $dbh1
                if ($querycheck2 === false) {
                    log_message("MySQL Error (tenderinfo_2017): " . mysqli_error($dbh1), $log_file); // UPDATED to use $dbh1
                } else {
                    log_message("count into tenderinfo_2017: $tenderid", $log_file);
                }
                if (mysqli_num_rows($querycheck2) == 0) {
                    $sqlinsert2 = "INSERT INTO `tenderinfo_2017` (`tenderid`, `sourcetenderid`, `value`, `biddeadline`, `emd`, `documentcost`, `authority`, `currency`, `tenderdetails`, `tenderdescription`, `prebidmeetingdate`, `city`, `pincode`, `sector`, `subindustry`, `sourceurl`, `completionofwork`, `ai_summary`, `location`, `city`, `cityid`, `state`, `stateid`, `country`, `countryid`, `documents`, `documentpath`) VALUES 
                                    ('$tenderid','$sourcetenderid','$value','$biddeadline','$emd','$documentcost','$authority','$currency','$tenderdetails','$tenderdescription','$prebidmeetingdate','$city','$pincode','$sector','$subindustry','$sourceurl','$completionofwork','$ai_summary','$location','$city','$cityid','$state','$stateid','$country','$countryid','$documents','$documentpath')";
                    $insert2 = mysqli_query($dbh1, $sqlinsert2); // UPDATED to use $dbh1
                    if ($insert2 === false) {
                        log_message("MySQL Error (tenderinfo_2017 insert): " . mysqli_error($dbh1), $log_file); // UPDATED to use $dbh1
                    } else {
                        log_message("Inserted new record into tenderinfo_2017: $tenderid", $log_file);
                    }
                } else {
                    $sqlupdate2 = "UPDATE `tenderinfo_2017` SET 
                        `sourcetenderid` = '$sourcetenderid',
                        `value` = '$value',
                        `biddeadline` = '$biddeadline',
                        `emd` = '$emd',
                        `documentcost` = '$documentcost',
                        `authority` = '$authority',
                        `currency` = '$currency',
                        `tenderdetails` = '$tenderdetails',
                        `tenderdescription` = '$tenderdescription',
                        `prebidmeetingdate` = '$prebidmeetingdate',
                        `city` = '$city',
                        `pincode` = '$pincode',
                        `sector` = '$sector',
                        `subindustry` = '$subindustry',
                        `sourceurl` = '$sourceurl',
                        `completionofwork` = '$completionofwork',
                        `ai_summary` = '$ai_summary',
                        `location` = '$location',
                        `city` = '$city',
                        `cityid` = '$cityid',
                        `state` = '$state',
                        `stateid` = '$stateid',
                        `country` = '$country',
                        `countryid` = '$countryid',
                        `documents` = '$documents',
                        `documentpath` = '$documentpath',
                        `zipdocumentdownload` = '$zipdocumentdownload'
                        WHERE `tenderid` = '$tenderid'";

                    $update2 = mysqli_query($dbh1, $sqlupdate2);
                    if ($update === false) {
                        log_message("MySQL Error (tenderinfo_2017 update): " . mysqli_error($dbh1), $log_file); // UPDATED to use $dbh1
                    } else {
                        log_message("Inserted new record into tenderinfo_2017: $tenderid", $log_file);
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