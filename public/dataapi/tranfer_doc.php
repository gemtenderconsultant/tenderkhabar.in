<?php
// Set the global path for the log file once at the top.
$log_file = '/home/tenderkhabar/web/tenderkhabar.in/public_html/logs/tranfer_doc.log';

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

log_message("Document transfer script started.");

// --- Determine the date to process ---
if (isset($_GET['date'])) {
    $date = $_GET['date'];
} else {
    $date = date('Y-m-d', strtotime('-1 days'));
}
log_message("Processing documents for date: $date");

// --- Step 1: Make the external API call BEFORE connecting to the database ---
$url = 'https://category.nationaltenders.in/clientapi/transfer_doc.php?api_key=2e36e49990a44d10354a08d7098460c2faa542ff7576a92ec16595b84c2adbe4&date=' . $date;
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

// --- Step 2: Now that the slow API call is done, connect to the database ---
include('config_mysqli.php');

// --- Step 3: Get the last processed ID from the database ---
$sql = "SELECT MAX(id) as id FROM `tender_doc`";
$query = mysqli_query($dbh1, $sql);
$id = 0;

if ($query) {
    if (mysqli_num_rows($query) > 0) {
        $result = mysqli_fetch_assoc($query);
        if (!empty($result) && !is_null($result['id'])) {
            $id = $result['id'];
        }
    }
    log_message("Last tender document ID in database is: $id");
} else {
    log_message("MySQL Error (SELECT MAX ID): " . mysqli_error($dbh1));
    // Decide if you want to stop the script if this query fails
    // die("Could not query the database. Check logs.");
}


// --- Step 4: Process the API response ---
if (isset($response['status']) && $response['status'] === true) {
    $total_docs = count($response['result']);
    log_message("API returned success with $total_docs documents.", $total_docs);

    $inserted_count = 0;
    $failed_count = 0;

    foreach ($response['result'] as $key => $val) {
        // It is safer to escape values, but keeping original logic as requested.
        $insert_id = $val['id'];
        $ourrefno = $val['ourrefno'];
        $documentpath = $val['documentpath'];
        $flag = $val['flag'];
        $date_val = $val['date']; // Renamed to avoid conflict with $date variable from above

        $sqlinsert = "INSERT INTO `tender_doc`(`id`, `ourrefno`, `documentpath`, `flag`, `date`) VALUES ('$insert_id','$ourrefno','$documentpath','$flag','$date_val')";
        $insert = mysqli_query($dbh1, $sqlinsert);

        if ($insert) {
            $inserted_count++;
        } else {
            $failed_count++;
            // Log the specific error for the failed insertion
            log_message("Failed to insert document: ID=$insert_id, ourrefno=$ourrefno. Error: " . mysqli_error($dbh1));
        }
    }

    // Log a final summary of the operation
    log_message("--- Operation Summary ---");
    log_message("Total documents received: $total_docs");
    log_message("Successfully inserted: $inserted_count");
    log_message("Failed to insert: $failed_count");
} else {
    // Log the exact reason why the API call returned a false status
    log_message("API returned false status. Full Response: " . json_encode($response));
}

log_message("Document transfer script finished.");
echo "finish";
