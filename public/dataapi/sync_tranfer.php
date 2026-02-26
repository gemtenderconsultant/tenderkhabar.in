<?php 

$last_id = 0;

do {

    $fetch_url = "https://tenderkhabar.com/dataapi/tenderinfo2017old.php?last_id=".$last_id;
    $response = json_decode(file_get_contents($fetch_url), true);
$response_json = file_get_contents($fetch_url);
    $response = json_decode($response_json, true);

    if (!$response || $response['count'] == 0) {
        echo "✅ Transfer Completed\n";
        break;
    }

    $payload = json_encode(["data" => $response['data']]);
    // if ($response['count'] == 0) {
    //     break;
    // }

    // $payload = json_encode(["data" => $response['data']]);

    $ch = curl_init("https://tenderkhabar.in/dataapi/insertdata.php");
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => $payload
    ]);

    // curl_exec($ch);
    $insert_response = curl_exec($ch);

    if ($insert_response === false) {
        echo "❌ CURL ERROR: " . curl_error($ch) . "\n";
        curl_close($ch);
        exit;
    }

    curl_close($ch);

    $last_row = end($response['data']);
    $last_id  = $last_row['ourrefno'];

    echo "Inserted till ID: ".$last_id."\n";
    flush();

} while (true);
//     curl_close($ch);

//     $last_row = end($response['data']);
//     $last_id  = $last_row['ourrefno'];

//     sleep(1); // server load protection

// } while (true);

echo "Transfer completed";