<?php

assert($_SERVER['REQUEST_METHOD'] == "PUT");

//Imports
require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/../../models/response.php";
require_once __DIR__ . "/../../modules/database.php"; //Connect to database
require_once __DIR__ . "/../../modules/readParams.php";
require_once __DIR__ . "/../../models/store.php";
require_once __DIR__ . "/../../modules/checkers.php";

//Main
$res = new Response();
$res->request_type = "PUT";
$store = new PutStore();
//get post queries
$id = getBody("id");

$puts = array();
if (is_null($id)) array_push($res->errors, "Must include id");
else {
    $user_puts_and_errors = $store->getPutArray($id);
    $res->errors = $user_puts_and_errors["errors"];
    $puts = $user_puts_and_errors["puts"];
    if (count($res->errors) == 0) {
        if (count($puts) == 0) array_push($res->errors, "You didn't send anything to update ");
        else $res->objects = $puts;
    }
}
if (count($res->errors) == 0) {
    try {
        $result = DB::queryFirstRow("SELECT id FROM stores WHERE id=%s LIMIT 1", $id);
        if ($result) {
            DB::update('stores', $puts, "id=%s", $id);
            $res->status = 200;
            $res->success = true;
        } else {
            $res->status = 404;
            array_push($res->errors, "Can not find store");
        }
    } catch (Exception $e) {
        array_push($res->errors, 'Message: ' . $e->getMessage());
    }
}
http_response_code($res->status);
echo json_encode($res);