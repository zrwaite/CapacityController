<?php
assert($_SERVER['REQUEST_METHOD'] == "GET");

use Symfony\Component\Dotenv\Dotenv;

//Imports
require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/../../models/response.php";
require_once __DIR__ . "/../../modules/database.php"; //Connect to database
require_once __DIR__ . "/../../modules/readParams.php";
require_once __DIR__ . "/../../modules/parse.php";
require_once __DIR__ . "/../../models/store.php";

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . "/../../modules/env/.env");

//Main
$res = new Response();
$res->request_type = "GET";

$id = getQuery("id");
$page = getQuery("page");
$owner = getQuery("owner");
$name = getQuery("name");
$query = "id, name, public_email, image_link, address, hours, phone, max_capacity, num_shoppers, actual_capacity, bio";
if (!is_null($id) || !is_null($owner)) {
    if (!is_null($id)){
        $result = DB::queryFirstRow("SELECT " . $query . " FROM stores WHERE id=%s LIMIT 1", $id);
    } else {
        $result = DB::queryFirstRow("SELECT " . $query . " FROM stores WHERE admin_username=%s", $owner);
    }
    if ($result) $parsedResult = getParseResult($result, "store");
    if ($result && $parsedResult) {
        $res->status = 200;
        $res->success = true;
        $res->objects = $parsedResult;
    } else {
        $res->status = 404;
        array_push($res->errors, "Store not found");
    }
} else if (!is_null($page)) {
    $result = DB::query("SELECT " . $query . " FROM stores LIMIT 10 OFFSET %d", ($page-1)*10);
    if ($result) {
        $res->objects = [];
        foreach ($result as $element) {
            array_push($res->objects, getParseResult($element, "store"));
        }
        $res->status = 200;
        $res->success = true;
    } else {
        $res->status = 404;
        array_push($res->errors, "store page ".$page." not found");
    }
} else if (!is_null($name)) {
    $result = DB::query("SELECT " . $query . " FROM stores WHERE name LIKE '%".$name."%'");
    if ($result) {
        $res->objects = [];
        foreach ($result as $element) {
            array_push($res->objects, getParseResult($element, "store"));
        }
        $res->status = 200;
        $res->success = true;
    } else {
        $res->status = 404;
        $res->objects = [];
        $res->success = true;
    }
} else array_push($res->errors, "Missing id, owner or page query, or did you mean for a non-GET request?");

http_response_code($res->status);
echo json_encode($res);