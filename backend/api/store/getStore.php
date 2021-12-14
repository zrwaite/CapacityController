<?php
assert($_SERVER['REQUEST_METHOD'] == "GET");

use Symfony\Component\Dotenv\Dotenv;

//Imports
require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/../../models/response.php";
require_once __DIR__ . "/../../modules/database.php"; //Connect to database
require_once __DIR__ . "/../../modules/readParams.php";
require_once __DIR__ . "/../../models/store.php";

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . "/../../modules/env/.env");

//Main
$res = new Response();
$res->request_type = "GET";
//
//$sql = "SELECT business_name, email, image_link, store_hours, store_address, phone, max_capacity, current_capacity, actual_capacity, bio FROM store;";
//$result = mysqli_query($conn, $sql);
//$rows=array();
//if (mysqli_num_rows($result) > 0) {
//    // output data of each row
//    while($row = mysqli_fetch_assoc($result)) {
//        array_push($rows, $row);
//    }
//    echo json_encode($rows);
//} else {
//    echo json_encode("0");
//}
//
////$sql = "SELECT * FROM Orders LIMIT 15, 10"; //Return 16-25
//$conn->close();
?>