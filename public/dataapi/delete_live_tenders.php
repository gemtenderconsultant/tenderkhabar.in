<?php
// Set the global path for the log file once at the top.
$log_file = '/home/tenderkhabar/web/tenderkhabar.in/public_html/logs/delete_live_tenders.log';
// NOTE: The include path is based on your original script. Adjust if needed.
include('config_mysqli.php');

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

// --- Helper function to execute and log queries ---
function execute_query($dbh, $sql, $description)
{
    log_message("Executing: $description");
    $result = mysqli_query($dbh, $sql);

    if ($result === false) {
        log_message(" -> FAILED. Error: " . mysqli_error($dbh));
        return -1; // Return -1 to indicate failure
    }

    $affected_rows = mysqli_affected_rows($dbh);
    log_message(" -> SUCCESS. Rows affected: $affected_rows");
    return $affected_rows;
}


log_message("==================================================");
log_message("Cleanup script started.");

$date = date('Y-m-d');
log_message("Using expiration date: Older than $date");

// --- Step 1: Delete expired tenders from `live_tenders` ---
$sql_delete_tenders = "DELETE FROM live_tenders WHERE submitdate < '$date' AND submitdate != '0000-00-00'";
$deleted_tenders_count = execute_query($dbh1, $sql_delete_tenders, "Delete expired tenders from live_tenders");

// --- Step 2: Delete orphaned category entries ---
$sql_delete_category = "DELETE FROM livetendercategory WHERE ourrefno NOT IN (SELECT ourrefno FROM live_tenders)";
$deleted_category_count = execute_query($dbh1, $sql_delete_category, "Delete orphaned entries from livetendercategory");

// --- Step 3: Delete orphaned item entries ---
$sql_delete_items = "DELETE FROM live_tenderinfo_items WHERE ourrefno NOT IN (SELECT ourrefno FROM live_tenders)";
$deleted_items_count = execute_query($dbh1, $sql_delete_items, "Delete orphaned entries from live_tenderinfo_items");

// --- Final Summary ---
log_message("--- Cleanup Summary ---");
if ($deleted_tenders_count !== -1) {
    log_message("Deleted $deleted_tenders_count expired tenders.");
} else {
    log_message("Failed to delete expired tenders.");
}

if ($deleted_category_count !== -1) {
    log_message("Deleted $deleted_category_count orphaned category links.");
} else {
    log_message("Failed to delete orphaned category links.");
}

if ($deleted_items_count !== -1) {
    log_message("Deleted $deleted_items_count orphaned tender items.");
} else {
    log_message("Failed to delete orphaned tender items.");
}

log_message("Cleanup script finished.");
log_message("==================================================");


// Output result for the command line or browser
echo "Script execution completed. Check the log file for details: $log_file";
