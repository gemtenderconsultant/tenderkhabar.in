<?php
header('Content-Type: application/json');

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

if (empty($input['data'])) {
    echo json_encode(["status"=>"error","message"=>"No data received"]);
    exit;
}
// $conn->begin_transaction();

try {

    $sql = "
    INSERT INTO tenderinfo_2017
    (
        ourrefno, TenderNo, purfromdate, submitdate, opendate,
        tenderamount, earnestamount, doccost, org_name, agencyid,
        address, city, pincode, Work, countryid, state_name,
        stateid, dt, documentpath, tender_ref_id, link2,
        is_corro, tender_catgeory2, tender_catgeory1,
        link, form_of_contract, item
    )
    VALUES (
        ?,?,?,?,?,?,?,?,?,?,
        ?,?,?,?,?,?,?,?,?,?,
        ?,?,?,?,?,?,?
    )
    ON DUPLICATE KEY UPDATE ourrefno = ourrefno
    ";
    $stmt = $dbh1->prepare($sql);
    foreach ($input['data'] as $row) {
        $stmt->bind_param(
            "issssdddssississississssss",
            $row['ourrefno'],
            $row['TenderNo'],
            $row['purfromdate'],
            $row['submitdate'],
            $row['opendate'],
            $row['tenderamount'],
            $row['earnestamount'],
            $row['doccost'],
            $row['org_name'],
            $row['agencyid'],
            $row['address'],
            $row['city'],
            $row['pincode'],
            $row['Work'],
            $row['countryid'],
            $row['state_name'],
            $row['stateid'],
            $row['dt'],
            $row['documentpath'],
            $row['tender_ref_id'],
            $row['link2'],
            $row['is_corro'],
            $row['tender_catgeory2'],
            $row['tender_catgeory1'],
            $row['link'],
            $row['form_of_contract'],
            $row['item']
        );

        $stmt->execute();
    }

    $dbh1->commit();
    echo json_encode(["status"=>"success","inserted"=>count($input['data'])]);

} catch (Exception $e) {
    $dbh1->rollback();
    echo json_encode(["status"=>"error","message"=>$e->getMessage()]);
}

$stmt->close();
$dbh1->close();