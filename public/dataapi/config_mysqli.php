<?php

ini_set('post_max_size','2000M');
ini_set('upload_max_filesize','2000M');
ini_set('max_execution_time',6000000000000);
ini_set('max_input_time',6000000000000);
ini_set('memory_limit', '512M');


$dbh1 = mysqli_connect("localhost", "tenderkhabar_admin", "Dummy@007", "tenderkhabar_prod");
// Check connection
if (!$dbh1) {
    // Log the error instead of echoing, as this is a background script
    // log_message("Database connection failed: " . mysqli_connect_error(), $log_file);
    die("Connection failed: " . mysqli_connect_error());
}

// *** ADD THIS CHECK ***
if (!function_exists('custom_real_escape_string')) {
    function custom_real_escape_string($field) {
        // CORRECTED: Use the global keyword for the correct variable name, $dbh1
        global $dbh1;
        // Also check if the connection exists before using it
        if ($dbh1) {
            return mysqli_real_escape_string($dbh1, $field);
        }
        return $field; // Return the original string if connection is lost
    }
}
?>