<?php
function log_message($message, $log_file) {
    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "[{$timestamp}] {$message}" . PHP_EOL;
    
    // Open the file in append mode, or create it if it doesn't exist
    $file_handle = fopen($log_file, 'a');
    
    // Write the log entry
    fwrite($file_handle, $log_entry);
    
    // Close the file
    fclose($file_handle);
}
?>