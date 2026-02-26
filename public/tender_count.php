<?php
include('/home/u920518903/domains/tenderkhabar.in/public_html/public/config_mysqli.php');

// Define the log file path
$log_file = '/home/u920518903/domains/tenderkhabar.in/public_html/logs/tender_count.log';

// Function to log messages
function log_message($message, $log_file) {
    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "[{$timestamp}] {$message}" . PHP_EOL;
    
    $file_handle = fopen($log_file, 'a');
    fwrite($file_handle, $log_entry);
    fclose($file_handle);
}

log_message("Script started", $log_file);

$dayname = date('l');
$dt = date('Y-m-d');
$prev_date = date('Y-m-d', strtotime('-1 day', strtotime($dt)));
$sat_prev_date = date('Y-m-d', strtotime('-2 day', strtotime($dt)));

log_message("Current date: $dt, Previous date: $prev_date, Saturday previous date: $sat_prev_date", $log_file);

if($dayname == 'Tuesday'){
   $sql_fresh = "SELECT COUNT(*) AS totalfresh FROM tenderinfo_2017 WHERE (dt = '$sat_prev_date' OR dt = '$prev_date')";
} else {
   $sql_fresh = "SELECT COUNT(*) AS totalfresh FROM tenderinfo_2017 WHERE dt = '$prev_date'";
}

$sql_global_fresh = "SELECT COUNT(*) AS totalglobalfresh FROM live_globaltender WHERE dt = '$dt'";
$sql_global_live = "SELECT COUNT(*) AS totalgloballive FROM live_globaltender WHERE closed_date >= '$dt'";
$sql_global_archive = "SELECT COUNT(*) AS totalglobalarchive FROM globaltender_2017 WHERE closed_date < '$dt'";

$sql_live = "SELECT COUNT(*) AS totallive FROM tenderinfo_2017 WHERE submitdate >= '$dt'";
$sql_archive = "SELECT COUNT(*) AS totalarchive FROM tenderinfo_2017 WHERE submitdate < '$dt'";
$sql_archive2017 = "SELECT COUNT(*) AS totalarchive FROM tender_2018 WHERE submitdate < '$dt'";
$sql_archive2018 = "SELECT COUNT(*) AS totalarchive FROM tender_2018 WHERE submitdate < '$dt'";
$sql_archive2019 = "SELECT COUNT(*) AS totalarchive FROM tender_2019 WHERE submitdate < '$dt'";
$sql_result = "SELECT COUNT(*) AS totalresult FROM tender_result_info";

function execute_query($dbh, $sql, $description) {
    global $log_file;
    log_message("Executing query: $description", $log_file);
    $result = mysqli_query($dbh, $sql);
    if ($result === false) {
        log_message("Query failed: $description. Error: " . mysqli_error($dbh), $log_file);
        return null;
    }
    $data = mysqli_fetch_assoc($result);
    log_message("Query result: $description - " . print_r($data, true), $log_file);
    return $data;
}

$fresh = execute_query($dbh2, $sql_fresh, "Fresh tenders");
$live = execute_query($dbh2, $sql_live, "Live tenders");
$archive = execute_query($dbh2, $sql_archive, "Archive tenders");

if ($fresh === null || $live === null || $archive === null) {
    log_message("One or more queries failed. Aborting script.", $log_file);
    die("Error: One or more queries failed. Check the log for details.");
}

$totalfresh = $fresh['totalfresh'];
$totallive = $live['totallive'];
$totalarchive = $archive['totalarchive'];

log_message("Totals calculated - Fresh: $totalfresh, Live: $totallive, Archive: $totalarchive", $log_file);

$status_update = "UPDATE daily_tender_count SET live='$totallive', fresh='$totalfresh', archive='$totalarchive' WHERE id=1";
log_message("Executing update query: $status_update", $log_file);

$updatestatus = mysqli_query($dbh2, $status_update);

if ($updatestatus === false) {
    log_message("Update query failed. Error: " . mysqli_error($dbh2), $log_file);
    die("Error: Failed to update daily tender count. Check the log for details.");
}

log_message("Daily tender count updated successfully", $log_file);
log_message("Script finished", $log_file);

echo "finish";
?>