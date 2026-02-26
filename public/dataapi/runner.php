<?php
date_default_timezone_set('Asia/Kolkata');

// Range
$startDate = "2024-01-01";
$endDate   = "2025-11-25";

// Convert to timestamps
$start = strtotime($startDate);
$end   = strtotime($endDate);

// Loop through all dates
for ($date = $start; $date <= $end; $date = strtotime("+1 day", $date)) {

    // Format yyyy-mm-dd
    $currentDate = date("Y-m-d", $date);

    // URL calling for each date
    $url = "https://tenderkhabar.in/dataapi/datewise_result.php?date=" . $currentDate;

    // cURL request
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    echo "Executed for date: $currentDate <br>";
}
?>
