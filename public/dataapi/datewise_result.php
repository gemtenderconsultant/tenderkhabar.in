<?php
// Set the global path for the log file once at the top.
$log_file = '/home/tenderkhabar/web/tenderkhabar.in/public_html/logs/datewise_result.log';

// --- Improved Reusable Logging Function ---
// This function automatically uses the global $log_file, so you only need to pass the message.
function log_message($message)
{
    global $log_file;

    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "[{$timestamp}] {$message}" . PHP_EOL;

    // Ensure the logs directory exists before writing
    if (!is_dir(dirname($log_file))) {
        mkdir(dirname($log_file), 0755, true);
    }

    $file_handle = fopen($log_file, 'a');
    fwrite($file_handle, $log_entry);
    fclose($file_handle);
}

log_message("Result script started");

// --- Create a status file ---
$posts = array();
$datetime = date('Y-m-d H:i:s');
$posts[] = array('id' => "1", 'time' => $datetime);
// $fp = fopen('datewisetenderresult.txt', 'w');
$fp = fopen(__DIR__ . "/datewisetenderresult.txt", "w");
if ($fp) {
    fwrite($fp, json_encode($posts));
    fclose($fp);
    log_message("Created status file: datewisetenderresult.txt");
}

// --- Determine the date to process ---
if (isset($_GET['date'])) {
    $date = $_GET['date'];
} else {
    $date = date('Y-m-d', strtotime('-1 days'));
}
log_message("Processing results for date: $date");

// --- Step 1: Make the external API call BEFORE connecting to the database ---
$url = "https://category.nationaltenders.in/clientapi/result_api_datewise.php?api_key=2e36e49990a44d10354a08d7098460c2faa542ff7576a92ec16595b84c2adbe4&date=" . $date;
log_message("Fetching data from API: $url");
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response_body = curl_exec($ch);
//echo $response_body;die();
// --- Error Handling for the API Request ---
if ($response_body === false) {
    log_message("cURL Error: " . curl_error($ch));
    die("Error: Failed to fetch data from API. Check the log for details.");
}
curl_close($ch);

$response = json_decode($response_body, true);

// --- Error Handling for JSON Decoding ---
if ($response === null) {
    log_message("JSON Decode Error: " . json_last_error_msg());
    die("Error: Failed to decode API response. Check the log for details.");
}

// --- Step 2: Now that the slow part is done, connect to the database ---
include('/home/tenderkhabar/web/tenderkhabar.in/public_html/public/dataapi/config_mysqli.php');

// --- Step 3: Process the API response ---
if (isset($response['status']) && $response['status'] === true) {
    $totalrecords = $response['total'];
    log_message("API returned success with $totalrecords total records.", $totalrecords);

    $sqlcheck = "SELECT count(*) as totaldate FROM `tender_result_info` WHERE dt='$date'";
    $query = mysqli_query($dbh1, $sqlcheck);

    if ($query === false) {
        log_message("MySQL Error (SELECT COUNT): " . mysqli_error($dbh1));
        die("Could not query database to check records. See log for details.");
    }

    $rowtotal = mysqli_fetch_assoc($query);
    $totaldate = $rowtotal['totaldate'];
    log_message("Records in database for date '$date': $totaldate");

    if ($totaldate != $totalrecords) {
        
        log_message("Mismatch detected (API: $totalrecords vs DB: $totaldate). Starting update/insert process.");

        $inserted_count = 0;
        $updated_count = 0;
        $failed_count = 0;

        foreach ($response['result'] as $key => $val) {
            $id = $val['id'];

            // Your existing logic for extracting and escaping variables
            $tender_id = custom_real_escape_string($val['tender_id']);
            $tender_ref = custom_real_escape_string($val['tender_ref']);
            $title = custom_real_escape_string($val['title']);
            $Organisation = custom_real_escape_string($val['Organisation']);
            $agency_id = $val['agency_id'];
            $state = $val['state'];
            $state_id = $val['state_id'];
            $city = $val['city'];
            $tender_document = $val['tender_document'];
            $document_link1 = $val['document_link1'];
            $awarded_value = $val['awarded_value'];
            $aoc = $val['aoc'];
            $selected_bidder = custom_real_escape_string($val['selected_bidder']);
            $website_link = $val['website_link'];
            $dt = $val['dt'];
            $link = "";
            $address = "";

            $sqlcheck = "SELECT id FROM `tender_result_info` WHERE id=$id";
            $querycheck = mysqli_query($dbh1, $sqlcheck);

            if (mysqli_num_rows($querycheck) == 0) {
                // INSERT logic
                
                $sqlinsert = "INSERT INTO `tender_result_info`(`id`, `tender_id`, `tender_ref`, `title`, `Organisation`, `agency_id`, `state`, `link`, `tender_document`, `document_link1`, `awarded_value`, `aoc`, `selected_bidder`, `website_link`, `state_id`, `city`, `address`, `dt`)
                VALUES ('$id','$tender_id','$tender_ref','$title','$Organisation','$agency_id','$state','$link','$tender_document','$document_link1','$awarded_value','$aoc','$selected_bidder','$website_link','$state_id','$city','$address','$dt')";
                //echo $sqlinsert;die();
                $insert = mysqli_query($dbh1, $sqlinsert);

                if ($insert) {
                    
                    $inserted_count++;
                } else {
                    $failed_count++;
                    log_message("Failed to INSERT record with id: $id. Error: " . mysqli_error($dbh1));
                }
            } else {
                // UPDATE logic
                $sqlupdate = "UPDATE `tender_result_info` SET `tender_id`='$tender_id', `tender_ref`= '$tender_ref', `title`= '$title', `Organisation`= '$Organisation', `agency_id`= '$agency_id', `state`= '$state', `link`= '$link', `tender_document`= '$tender_document', `document_link1`= '$document_link1', `awarded_value`= '$awarded_value', `aoc`= '$aoc', `selected_bidder`= '$selected_bidder', `website_link`= '$website_link', `state_id`= '$state_id', `city`= '$city', `address`= '$address', `dt`= '$dt' WHERE `id`='$id'";
                $update = mysqli_query($dbh1, $sqlupdate);

                if ($update) {
                    $updated_count++;
                } else {
                    $failed_count++;
                    log_message("Failed to UPDATE record with id: $id. Error: " . mysqli_error($dbh1));
                }
            }
        }

        log_message("--- Operation Summary ---");
        log_message("Successfully inserted: $inserted_count");
        log_message("Successfully updated: $updated_count");
        log_message("Failed operations: $failed_count");
    } else {
        log_message("Record count matches. No updates needed.");
    }
} else {
    log_message("API returned false status. Full Response: " . json_encode($response));
}

log_message("Result script finished.");
echo "finish";
