<?php 
set_time_limit(0);

$last_id = 0;

do {

    $fetch_url = "https://tenderkhabar.com/dataapi/tenderinfo2017old.php?last_id=".$last_id;

    $response_json = file_get_contents($fetch_url);
    $response = json_decode($response_json, true);

    if (!$response || $response['count'] == 0) {
        
        echo "✅ Transfer Completed\n";
        echo "Source Count: " . $response['count'] . "\n";
        break;
    }

    $payload = json_encode(["data" => $response['data']]);

    $ch = curl_init("https://tenderkhabar.in/dataapi/insertdata.php");
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => $payload
    ]);

    $insert_response = curl_exec($ch);

    if ($insert_response === false) {
        echo "❌ CURL ERROR: " . curl_error($ch) . "\n";
        exit;
    }else{
    echo "Insert Response: " . $insert_response . "\n";
}
    curl_close($ch);

    $last_row = end($response['data']);
    $last_id  = $last_row['ourrefno'];

    echo "Inserted till ID: ".$last_id."\n";

} while (true);

echo "Transfer completed\n";;