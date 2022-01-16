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

$username = getQuery("username");
$storeId = getQuery("store_id");
if (count($res->errors) == 0) {
    $query = "id, username, store_id";
    if ($username) {
        $result = DB::queryFirstRow("SELECT " . $query . " FROM users WHERE username=%s LIMIT 1", $username);
        $parsedResult = getParseResult($result, "user");
        if ($result && $parsedResult) {
            $res->status = 200;
            $res->success = true;
            $res->objects = $parsedResult;
        } else {
            $res->status = 404;
            array_push($res->errors, "User not found");
        }
    } else if ($storeId) {
        $result = DB::query("SELECT " . $query . " FROM users WHERE store_id=%s", $storeId);
        if ($result) {
            $res->objects = [];
            foreach ($result as $element) {
                array_push($res->objects, getParseResult($element, "user"));
            }
            $res->status = 200;
            $res->success = true;
        } else {
            $res->status = 404;
            array_push($res->errors, "no users found for this store");
        }
    } else array_push($res->errors, "Missing username or store_id query, or did you mean for a non-GET request?");
}
http_response_code($res->status);
echo json_encode($res);