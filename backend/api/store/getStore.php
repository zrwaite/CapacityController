<?php
assert($_SERVER['REQUEST_METHOD'] == "GET");

use Symfony\Component\Dotenv\Dotenv;

//Imports
require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/../../models/response.php";
require_once __DIR__ . "/../../modules/database.php"; //Connect to database
require_once __DIR__ . "/../../modules/readParams.php";
require_once __DIR__ . "/../../modules/parseResult.php";
require_once __DIR__ . "/../../models/store.php";

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . "/../../modules/env/.env");

//Main
$res = new Response();
$res->request_type = "GET";

$store = new GetStore();

$id = getQuery("id");
$page = getQuery("page");
if (count($res->errors) == 0) {
    $query = "id, business_name, public_email, image_link, store_address, store_hours, phone, max_capacity, num_shoppers, actual_capacity, bio";
    if ($id) {
        $result = DB::queryFirstRow("SELECT " . $query . " FROM stores WHERE id=%s LIMIT 1", $id);
        if ($result && $store->parseResult($result)) {
            $res->status = 200;
            $res->success = true;
            $res->objects = $store;
        } else {
            $res->status = 404;
            array_push($res->errors, "Store not found");
        }
    } else if ($page) {
        $result = DB::query("SELECT " . $query . " FROM stores LIMIT 10 OFFSET %d", ($page-1)*10);
        if ($result) {
            $res->objects = [];
            foreach ($result as $element) {
                array_push($res->objects, parseResult($element, "store"));
            }
            $res->status = 200;
            $res->success = true;
        } else {
            $res->status = 404;
            array_push($res->errors, "store page ".$page." not found");
        }
    } else  array_push($res->errors, "Missing id or page query, or did you mean for a non-GET request?");
}
echo json_encode($res);