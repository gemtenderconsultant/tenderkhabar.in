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
/*tenderinfo_2017*/
// $values[] = "(" .
//     (int)$row['ourrefno'] . "," .
//     "'" . mysqli_real_escape_string($dbh1,$row['TenderNo']) . "'," .
//     "'" . mysqli_real_escape_string($dbh1,$row['purfromdate']) . "'," .
//     "'" . mysqli_real_escape_string($dbh1,$row['submitdate']) . "'," .
//     "'" . mysqli_real_escape_string($dbh1,$row['opendate']) . "'," .
//     (float)$row['tenderamount'] . "," .
//     (float)$row['earnestamount'] . "," .
//     (float)$row['doccost'] . "," .
//     "'" . mysqli_real_escape_string($dbh1,$row['org_name']) . "'," .
//     (int)$row['agencyid'] . "," .
//     "'" . mysqli_real_escape_string($dbh1,$row['address']) . "'," .
//     "'" . mysqli_real_escape_string($dbh1,$row['city']) . "'," .
//     (int)$row['pincode'] . "," .   // ✅ FIXED (removed quotes)
//     "'" . mysqli_real_escape_string($dbh1,$row['Work']) . "'," .
//     (int)$row['countryid'] . "," .
//     "'" . mysqli_real_escape_string($dbh1,$row['state_name']) . "'," .
//     (int)$row['stateid'] . "," .
//     "'" . mysqli_real_escape_string($dbh1,$row['dt']) . "'," .
//     "'" . mysqli_real_escape_string($dbh1,$row['documentpath']) . "'," .
//     "'" . mysqli_real_escape_string($dbh1,$row['tender_ref_id']) . "'," .
//     "'" . mysqli_real_escape_string($dbh1,$row['link2']) . "'," .
//     (int)$row['is_corro'] . "," .
//     "'" . mysqli_real_escape_string($dbh1,$row['tender_catgeory2']) . "'," .
//     "'" . mysqli_real_escape_string($dbh1,$row['tender_catgeory1']) . "'," .
//     "'" . mysqli_real_escape_string($dbh1,$row['link']) . "'," .
//     "'" . mysqli_real_escape_string($dbh1,$row['form_of_contract']) . "'," .
//     "'" . mysqli_real_escape_string($dbh1,$row['item']) . "'" .
// ")";
    // $values[] = "(" .
    //     (int)$row['ID'] . "," .
    //     "'" . (int)$row['ourrefno'] . "'," .
    //     "'" . (int)$row['categoryid'] . "'," .
    //     "'" . (int)$row['subcategory'] . "'," .
    //     "'" . mysqli_real_escape_string($dbh1,$row['created_date']) . "'" .   
    //     ")";
    $values[] = "(" .
        (int)$row['id'] . "," .
        "'" . (int)$row['ourrefno'] . "'," .
        "'" . mysqli_real_escape_string($dbh1,$row['documentpath']) . "'," .
        "'" . (int)$row['flag'] . "'," .
        "'" . mysqli_real_escape_string($dbh1,$row['date']) . "'" .   
        ")";
}
/*tenderinfo_2017*/
// $sql = "INSERT INTO tenderinfo_2017 (
//     ourrefno, TenderNo, purfromdate, submitdate, opendate,
//     tenderamount, earnestamount, doccost, org_name, agencyid,
//     address, city, pincode, Work, countryid, state_name,
//     stateid, dt, documentpath, tender_ref_id, link2,
//     is_corro, tender_catgeory2, tender_catgeory1,
//     link, form_of_contract, item
// ) VALUES " . implode(",", $values) . "
// ON DUPLICATE KEY UPDATE ourrefno=ourrefno";

// $sql = "INSERT INTO tendercategory_2017 (
// ID, ourrefno, categoryid, subcategory, created_date) VALUES 
//  " . implode(",", $values) . "
// ON DUPLICATE KEY UPDATE ID=ID";

$sql = "INSERT INTO tender_doc (
id, ourrefno, documentpath, flag, date) VALUES 
 " . implode(",", $values) . "
ON DUPLICATE KEY UPDATE id=id";

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