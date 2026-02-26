<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
set_time_limit(0);
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

// $input = json_decode(file_get_contents("php://input"), true);

// if (empty($input['data'])) {
//     echo json_encode(["status"=>"error","message"=>"No data received"]);
//     exit;
// }
// // $conn->begin_transaction();
// $dbh1->begin_transaction();
// try {

//     $sql = "
//     INSERT INTO tenderinfo_2017
//     (
//         ourrefno, TenderNo, purfromdate, submitdate, opendate,
//         tenderamount, earnestamount, doccost, org_name, agencyid,
//         address, city, pincode, Work, countryid, state_name,
//         stateid, dt, documentpath, tender_ref_id, link2,
//         is_corro, tender_catgeory2, tender_catgeory1,
//         link, form_of_contract, item
//     )
//     VALUES (
//         ?,?,?,?,?,?,?,?,?,?,
//         ?,?,?,?,?,?,?,?,?,?,
//         ?,?,?,?,?,?,?
//     )
//     ON DUPLICATE KEY UPDATE ourrefno = ourrefno
//     ";
//     $stmt = $dbh1->prepare($sql);
//     if (!$stmt) {
//         echo json_encode(["status"=>"error","message"=>$dbh1->error]);
//         exit;
//     }
//     foreach ($input['data'] as $row) {
//         $stmt->bind_param(
//             "issssdddssississississssss",
//             $row['ourrefno'],
//             $row['TenderNo'],
//             $row['purfromdate'],
//             $row['submitdate'],
//             $row['opendate'],
//             $row['tenderamount'],
//             $row['earnestamount'],
//             $row['doccost'],
//             $row['org_name'],
//             $row['agencyid'],
//             $row['address'],
//             $row['city'],
//             $row['pincode'],
//             $row['Work'],
//             $row['countryid'],
//             $row['state_name'],
//             $row['stateid'],
//             $row['dt'],
//             $row['documentpath'],
//             $row['tender_ref_id'],
//             $row['link2'],
//             $row['is_corro'],
//             $row['tender_catgeory2'],
//             $row['tender_catgeory1'],
//             $row['link'],
//             $row['form_of_contract'],
//             $row['item']
//         );

//         $stmt->execute();
//     }

//     $stmt->commit();
//     echo json_encode(["status"=>"success","inserted"=>count($input['data'])]);

// } catch (Exception $e) {
//     $stmt->rollback();
//     echo json_encode(["status"=>"error","message"=>$e->getMessage()]);
// }

// $stmt->close();
// $stmt->close();
// $input = json_decode(file_get_contents("php://input"), true);

// if (!$input || !isset($input['data'])) {
//     echo json_encode(["status"=>"error","message"=>"Invalid JSON"]);
//     exit;
// }

// $data = $input['data'];

// if (empty($data)) {
//     echo json_encode(["status"=>"success","inserted"=>0]);
//     exit;
// }

// $dbh1->begin_transaction();


// $columns = "
// ourrefno, TenderNo, purfromdate, submitdate, opendate,
// tenderamount, earnestamount, doccost, org_name, agencyid,
// address, city, pincode, Work, countryid, state_name,
// stateid, dt, documentpath, tender_ref_id, link2,
// is_corro, tender_catgeory2, tender_catgeory1,
// link, form_of_contract, item
// ";

// $values = [];
// $types  = "";
// $params = [];

// foreach ($data as $row) {

//     $values[] = "(" . rtrim(str_repeat("?,", 27), ",") . ")";

//     $types .= "issssdddssississississssss";

//     foreach ($row as $value) {
//         $params[] = $value;
//     }
// }

// $sql = "INSERT INTO tenderinfo_2017 ($columns) VALUES "
//      . implode(",", $values)
//      . " ON DUPLICATE KEY UPDATE ourrefno=ourrefno";

// $stmt = $dbh1->prepare($sql);

// if (!$stmt) {
//     echo json_encode(["status"=>"error","message"=>$dbh1->error]);
//     exit;
// }

// $stmt->bind_param($types, ...$params);

// if (!$stmt->execute()) {
//     $dbh1->rollback();
//     echo json_encode(["status"=>"error","message"=>$stmt->error]);
//     exit;
// }


// $dbh1->commit();

// echo json_encode([
//     "status"=>"success",
//     "inserted"=>count($data)
// ]);

// $stmt->close();
// $dbh1->close();
$input = json_decode(file_get_contents("php://input"), true);

if (!$input || !isset($input['data'])) {
    echo json_encode(["status"=>"error","message"=>"Invalid JSON"]);
    exit;
}

$data = $input['data'];

if (empty($data)) {
    echo json_encode(["status"=>"success","inserted"=>0]);
    exit;
}

$dbh1->begin_transaction();

$values = [];

foreach ($data as $row) {


//     $values[] = "(" .
//         (int)$row['ourrefno'] . "," .
//         "'" . mysqli_real_escape_string($dbh1,$row['TenderNo']) . "'," .
//         "'" . mysqli_real_escape_string($dbh1,$row['purfromdate']) . "'," .
//         "'" . mysqli_real_escape_string($dbh1,$row['submitdate']) . "'," .
//         "'" . mysqli_real_escape_string($dbh1,$row['opendate']) . "'," .
//         (float)$row['tenderamount'] . "," .
//         (float)$row['earnestamount'] . "," .
//         (float)$row['doccost'] . "," .
//         "'" . mysqli_real_escape_string($dbh1,$row['org_name']) . "'," .
//         (int)$row['agencyid'] . "," .
//         "'" . mysqli_real_escape_string($dbh1,$row['address']) . "'," .
//         "'" . mysqli_real_escape_string($dbh1,$row['city']) . "'," .
//         "'" . mysqli_real_escape_string($dbh1,$row['pincode']) . "'," .
//         "'" . mysqli_real_escape_string($dbh1,$row['Work']) . "'," .
//         (int)$row['countryid'] . "," .
//         "'" . mysqli_real_escape_string($dbh1,$row['state_name']) . "'," .
//         (int)$row['stateid'] . "," .
//         "'" . mysqli_real_escape_string($dbh1,$row['dt']) . "'," .
//         "'" . mysqli_real_escape_string($dbh1,$row['documentpath']) . "'," .
//         "'" . mysqli_real_escape_string($dbh1,$row['tender_ref_id']) . "'," .
//         "'" . mysqli_real_escape_string($dbh1,$row['link2']) . "'," .
//         (int)$row['is_corro'] . "," .
//         "'" . mysqli_real_escape_string($dbh1,$row['tender_catgeory2']) . "'," .
//         "'" . mysqli_real_escape_string($dbh1,$row['tender_catgeory1']) . "'," .
//         "'" . mysqli_real_escape_string($dbh1,$row['link']) . "'," .
//         "'" . mysqli_real_escape_string($dbh1,$row['form_of_contract']) . "'," .
//         "'" . mysqli_real_escape_string($dbh1,$row['item']) . "'" .
//     ")";
// }
$values[] = "(" .
    (int)$row['ourrefno'] . "," .
    "'" . mysqli_real_escape_string($dbh1,$row['TenderNo']) . "'," .
    "'" . mysqli_real_escape_string($dbh1,$row['purfromdate']) . "'," .
    "'" . mysqli_real_escape_string($dbh1,$row['submitdate']) . "'," .
    "'" . mysqli_real_escape_string($dbh1,$row['opendate']) . "'," .
    (float)$row['tenderamount'] . "," .
    (float)$row['earnestamount'] . "," .
    (float)$row['doccost'] . "," .
    "'" . mysqli_real_escape_string($dbh1,$row['org_name']) . "'," .
    (int)$row['agencyid'] . "," .
    "'" . mysqli_real_escape_string($dbh1,$row['address']) . "'," .
    "'" . mysqli_real_escape_string($dbh1,$row['city']) . "'," .
    (int)$row['pincode'] . "," .   // ✅ FIXED (removed quotes)
    "'" . mysqli_real_escape_string($dbh1,$row['Work']) . "'," .
    (int)$row['countryid'] . "," .
    "'" . mysqli_real_escape_string($dbh1,$row['state_name']) . "'," .
    (int)$row['stateid'] . "," .
    "'" . mysqli_real_escape_string($dbh1,$row['dt']) . "'," .
    "'" . mysqli_real_escape_string($dbh1,$row['documentpath']) . "'," .
    "'" . mysqli_real_escape_string($dbh1,$row['tender_ref_id']) . "'," .
    "'" . mysqli_real_escape_string($dbh1,$row['link2']) . "'," .
    (int)$row['is_corro'] . "," .
    "'" . mysqli_real_escape_string($dbh1,$row['tender_catgeory2']) . "'," .
    "'" . mysqli_real_escape_string($dbh1,$row['tender_catgeory1']) . "'," .
    "'" . mysqli_real_escape_string($dbh1,$row['link']) . "'," .
    "'" . mysqli_real_escape_string($dbh1,$row['form_of_contract']) . "'," .
    "'" . mysqli_real_escape_string($dbh1,$row['item']) . "'" .
")";
}
$sql = "INSERT INTO tenderinfo_2017 (
    ourrefno, TenderNo, purfromdate, submitdate, opendate,
    tenderamount, earnestamount, doccost, org_name, agencyid,
    address, city, pincode, Work, countryid, state_name,
    stateid, dt, documentpath, tender_ref_id, link2,
    is_corro, tender_catgeory2, tender_catgeory1,
    link, form_of_contract, item
) VALUES " . implode(",", $values) . "
ON DUPLICATE KEY UPDATE ourrefno=ourrefno";

if (!mysqli_query($dbh1, $sql)) {
    $dbh1->rollback();
    echo json_encode(["status"=>"error","message"=>mysqli_error($dbh1)]);
    exit;
}

$dbh1->commit();

echo json_encode([
    "status"=>"success",
    "inserted"=>count($data)
]);

$dbh1->close();