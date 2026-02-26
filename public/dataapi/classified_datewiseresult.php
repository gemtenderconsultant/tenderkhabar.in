<?php
// Set the global path for the log file once at the top.
$log_file = '/home/tenderkhabar/web/tenderkhabar.in/public_html/logs/classified_datewiseresult.log';

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

log_message("Classification result script started.");

// --- Create a status file ---
$posts = array();
$datetime = date('Y-m-d H:i:s');
$posts[] = array('id' => "1", 'time' => $datetime);
// $fp = fopen('datewiseclassificationresult.txt', 'w');
$fp = fopen(__DIR__ . "/datewiseclassificationresults.txt", "w");
if ($fp) {
    fwrite($fp, json_encode($posts));
    fclose($fp);
}

// --- Determine the date to process ---
if (isset($_GET['date'])) {
    $date = $_GET['date'];
} else {
    $date = date('Y-m-d', strtotime('-1 days'));
}
log_message("Processing classification results for date: $date");

// --- Step 1: Make the external API call BEFORE connecting to the database ---
$url = "https://category.nationaltenders.in/clientapi/result_classified_api_datewise.php?api_key=2e36e49990a44d10354a08d7098460c2faa542ff7576a92ec16595b84c2adbe4&date=" . $date;
log_message("Fetching data from API: $url");
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response_body = curl_exec($ch);

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
include('config_mysqli.php');

// --- Step 3: Process the API response ---
if (isset($response['status']) && $response['status'] === true) {
    $total_records = count($response['result']);
    log_message("API returned success with $total_records records.");

    $inserted_count = 0;
    $skipped_count = 0;
    $failed_count = 0;

    foreach ($response['result'] as $key => $val) {
        $rid = $val['rid'];
        $categoryid = $val['categoryid'];
        $subcategory = $val['subcategory'];

        // --- THIS IS THE FIX ---
        // If 'industryid' from the API is empty or not set, default it to 0. Otherwise, use its integer value.
        $industryid = !empty($val['industryid']) ? intval($val['industryid']) : 0;

        $sqlcheck = "SELECT rid FROM `tender_result_category` WHERE rid=$rid AND categoryid=$categoryid AND subcategory=$subcategory";
        $querycheck = mysqli_query($dbh1, $sqlcheck);

        if ($querycheck === false) {
            log_message("MySQL Error (SELECT): " . mysqli_error($dbh1));
            $failed_count++;
            continue; // Skip this record
        }

        $datetime = date('Y-m-d H:i:s');
        if (mysqli_num_rows($querycheck) == 0) {
            // INSERT logic
            $sqlinsert = "INSERT INTO `tender_result_category`(`rid`, `industryid`, `categoryid`, `subcategory`, `created_date`) VALUES ('$rid','$industryid','$categoryid','$subcategory','$datetime')";
            $insert = mysqli_query($dbh1, $sqlinsert);

            if ($insert) {
                $inserted_count++;
            } else {
                $failed_count++;
                log_message("Failed to INSERT record: rid=$rid. Error: " . mysqli_error($dbh1));
            }
        } else {
            // SKIP logic
            $skipped_count++;
        }
    }

    log_message("--- Operation Summary ---");
    log_message("Total records received: $total_records");
    log_message("Successfully inserted: $inserted_count");
    log_message("Skipped (already exist): $skipped_count");
    log_message("Failed operations: $failed_count");
} else {
    log_message("API returned false status. Full Response: " . json_encode($response));
}

log_message("Classification result script finished.");
echo "finish";
