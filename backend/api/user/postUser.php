<?php

assert($_SERVER['REQUEST_METHOD'] == "POST");

use Symfony\Component\Dotenv\Dotenv;

//Imports
require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/../../models/response.php";
require_once __DIR__ . "/../../modules/database.php"; //Connect to database
require_once __DIR__ . "/../../modules/readParams.php";
require_once __DIR__ . "/../../models/user.php";

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . "/../../modules/env/.env");

//Main
//Object declaraion
$res = new Response();
$res->request_type = "POST";

$getAdmin = getBody("admin");
if ($getAdmin["set"]) {
    if ($getAdmin["value"]) $user = new PostAdmin();
    else $user = new PostUser();
}
else {
    array_push($res->errors, "must include admin");
    $user = new PostUser();
}

//get post queries

$getUsername = getBody("username");

if ($getUsername["set"]) {
    $username = $getUsername["value"];
    $user->username = $username;
}
else array_push($res->errors, "must include username");

$getStoreId = getBody("store_id");
if ($getStoreId["set"]) {
    $storeId = $getStoreId["value"];
    $storeExists = DB::queryFirstRow("SELECT id FROM stores WHERE id=%s LIMIT 1", $storeId);
    if ($storeExists) $user->store_id = $storeId;
    else array_push($res->errors, "invalid store_id");
}
else array_push($res->errors, "must include store_id");

$getPassword = getBody("password");
if ($getPassword["set"]) {
    $password = $getPassword["value"];
    $user->password = $password;
    $res->errors = array_merge($res->errors, $user->checkPassword());
} else array_push($res->errors, "must include password");

if (count($res->errors) == 0) {
    $user->createHash();
    try {
        $result = DB::queryFirstRow("SELECT id FROM users WHERE username=%s LIMIT 1", $username);
        if (!$result) {
            DB::insert('users', array(
                'username' => $user->username,
                'password_hash' => $user->password_hash,
                'store_id' => $user->store_id,
            ));
            $res->status = 200;
            $res->success = true;
            $res->objects = $user->createResponse();
        } else array_push($res->errors, "username already in use");
    } catch (Exception $e) {
        array_push($res->errors, "database error");
    }
}
http_response_code($res->status);
echo json_encode($res);