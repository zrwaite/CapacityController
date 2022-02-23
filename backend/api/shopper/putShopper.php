<?php

assert($_SERVER['REQUEST_METHOD'] == "PUT");

//Imports
require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/../../models/response.php";
require_once __DIR__ . "/../../modules/database.php"; //Connect to database
require_once __DIR__ . "/../../modules/readParams.php";
require_once __DIR__ . "/../../modules/checkers.php";

//Main
$res = new Response();
$res->request_type = "PUT";
//get post queries
$id = getBody("id");
$command = getBody("command");
$number = getBody("number");
if (is_null($id)) array_push($res->errors, "missing param id");
if (is_null($command)) array_push($res->errors, "missing param command");
if (is_null($number)) array_push($res->errors, "missing param number");
else if ($command == "add" || $command == "remove"){
    $previousNumber = DB::queryFirstRow("SELECT num_shoppers FROM stores WHERE id=%s LIMIT 1", $id);
    if (is_null($previousNumber)) {
        $res->status = 404;
        array_push($res->errors, "Can not find store");
    } else {
        if ($command == "add") $newNumber = $previousNumber["num_shoppers"] + intval($number);
        else $newNumber = $previousNumber["num_shoppers"] - intval($number);
        if ($newNumber<0) $newNumber = 0;
        try {
            DB::update('stores',["num_shoppers" => $newNumber] , "id=%s", $id);
            $res->status = 200;
            $res->success = true;
            $res->objects = ["num_shoppers" => $newNumber];
        } catch (Exception $e) {
            array_push($res->errors, 'Message: ' . $e->getMessage());
        }
        $res->status = 200;
        $res->success = true;
    }
} else array_push($res->errors, "invalid command");
http_response_code($res->status);
echo json_encode($res);