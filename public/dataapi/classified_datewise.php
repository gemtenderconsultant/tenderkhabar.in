<?php
// Set the global path for the log file ONCE at the top.
$log_file = '/home/tenderkhabar/web/tenderkhabar.in/public_html/logs/classification.log';

// --- Reusable Logging Function (IMPROVED) ---
// The function now automatically uses the global $log_file variable.
function log_message($message)
{
    global $log_file; // Access the global variable

    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "[{$timestamp}] {$message}" . PHP_EOL;

    // Ensure the logs directory exists before writing
    if (!is_dir(dirname($log_file))) {
        mkdir(dirname($log_file), 0755, true);
    }

    // Append the message to the log file
    $file_handle = fopen($log_file, 'a');
    fwrite($file_handle, $log_entry);
    fclose($file_handle);
}

log_message("Classification script started");

// --- Create a status file ---
$posts = array();
$datetime = date('Y-m-d H:i:s');
$posts[] = array('id' => "1", 'time' => $datetime);
// $fp = fopen('datewiseclassification.txt', 'w');
$fp = fopen(__DIR__ . "/datewiseclassification.txt", "w");
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
log_message("Processing classifications for date: $date");

// --- Step 1: Make the external API call BEFORE connecting to the database ---
$url = 'https://category.nationaltenders.in/clientapi/live_tenders_classified_api_datewise.php?api_key=2e36e49990a44d10354a08d7098460c2faa542ff7576a92ec16595b84c2adbe4&date=' . $date;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response_body = curl_exec($ch);

// --- Error Handling for API Request ---
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

// --- Step 3: Process the response ---
if (isset($response['status']) && $response['status'] === true) {
    $records = $response['result'];
    $record_count = count($records);
    log_message("API returned success with $record_count records.");

    $inserted_live_count = 0;
    $inserted_2017_count = 0;

    foreach ($records as $key => $val) {
        // Sanitize inputs
        $ourrefno = intval($val['ourrefno']);
        $categoryid = intval($val['categoryid']);
        $subcategory = intval($val['subcategory']);

        $datetime = date('Y-m-d H:i:s');

        // --- Process `livetendercategory` table ---
        $sqlcheck = "SELECT ourrefno FROM `livetendercategory` WHERE ourrefno=$ourrefno AND categoryid=$categoryid AND subcategory=$subcategory";
        $querycheck = mysqli_query($dbh1, $sqlcheck);

        if ($querycheck === false) {
            log_message("MySQL Error (SELECT livetendercategory): " . mysqli_error($dbh1));
            continue; // Skip to the next record
        }

        if (mysqli_num_rows($querycheck) == 0) {
            $sqlinsert = "INSERT INTO `livetendercategory`(`ourrefno`, `categoryid`, `subcategory`, `created_date`) VALUES ('$ourrefno','$categoryid','$subcategory','$datetime')";
            $insert = mysqli_query($dbh1, $sqlinsert);

            if ($insert) {
                $inserted_live_count++;
            } else {
                log_message("Failed to insert into livetendercategory: " . mysqli_error($dbh1));
            }
        }

        // --- Process `tendercategory_2017` table ---
        $sqlcheck2 = "SELECT ourrefno FROM `tendercategory_2017` WHERE ourrefno=$ourrefno AND categoryid=$categoryid AND subcategory=$subcategory";
        $querycheck2 = mysqli_query($dbh1, $sqlcheck2);

        if ($querycheck2 === false) {
            log_message("MySQL Error (SELECT tendercategory_2017): " . mysqli_error($dbh1));
            continue; // Skip to the next record
        }

        if (mysqli_num_rows($querycheck2) == 0) {
            $sqlinsert2 = "INSERT INTO `tendercategory_2017`(`ourrefno`, `categoryid`, `subcategory`, `created_date`) VALUES ('$ourrefno','$categoryid','$subcategory','$datetime')";
            $insert2 = mysqli_query($dbh1, $sqlinsert2);

            if ($insert2) {
                $inserted_2017_count++;
            } else {
                log_message("Failed to insert into tendercategory_2017: " . mysqli_error($dbh1));
            }
        }
    }

    log_message("Summary: Inserted $inserted_live_count new records into livetendercategory.");
    log_message("Summary: Inserted $inserted_2017_count new records into tendercategory_2017.");
} else {
    // Log the exact reason why the API call failed
    log_message("API returned false status. Full Response: " . json_encode($response));
}

log_message("Classification script finished.");
echo "finish";
