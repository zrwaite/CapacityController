<?php

assert($_SERVER['REQUEST_METHOD'] == "POST");

use Symfony\Component\Dotenv\Dotenv;

//Imports
require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/../../models/response.php";
require_once __DIR__ . "/../../modules/database.php"; //Connect to database
require_once __DIR__ . "/../../modules/readParams.php";
require_once __DIR__ . "/../../models/store.php";
require_once __DIR__ . "/../../modules/parse.php";


$dotenv = new Dotenv();
$dotenv->load(__DIR__ . "/../../modules/env/.env");

//Main
//Object declaraion
$res = new Response();
$res->request_type = "POST";

$store = new PostStore();

$store->name = getBody("name");
$store->public_email = getBody("public_email");
$store->address = getBody("address");
$store->hours = getBody("hours");
$store->phone = getBody("phone");
$store->bio = getBody("bio");
$store->max_capacity = getBody("max_capacity");
$store->actual_capacity = getBody("actual_capacity");
$store->admin_username = getBody("admin_username");

if (!is_null($store->admin_username)) {
    $adminExists = DB::queryFirstRow("SELECT id FROM users WHERE username=%s LIMIT 1", $store->admin_username);
    if (!$adminExists) array_push($res->errors, "invalid admin_username");
}
$res->errors = array_merge($res->errors, $store->getAttributeErrors());

if (count($res->errors) == 0) {
    try {
        DB::insert('stores', removeNullFromArray([
            "name" => $store->name,
            "public_email" => $store->public_email,
            "address" => $store->address,
            "hours" => $store->hours,
            "phone" => $store->phone,
            "bio" => $store->bio,
            "max_capacity" => $store->max_capacity,
            "actual_capacity" => $store->actual_capacity,
            "admin_username" => $store->admin_username
            ]));
        $res->status = 200;
        $res->success = true;
        $res->objects = $store->createResponse();
    } catch (Exception $e) {
        array_push($res->errors, "database error");
    }
}
http_response_code($res->status);
echo json_encode($res);