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

$admin = getBody("admin");
if (is_null($admin)) {
    array_push($res->errors, "must include admin");
    $user = new PostUser();
} else {
    if ($admin) $user = new PostAdmin();
    else $user = new PostUser();
}

//get post queries

$user->username = getBody("username");
if (is_null($user->username)) array_push($res->errors, "must include username");

$user->store_id = getBody("store_id");
if (is_null($user->store_id)) array_push($res->errors, "must include store_id");
else {
    $storeExists = DB::queryFirstRow("SELECT id FROM stores WHERE id=%s LIMIT 1", $user->store_id);
    if (!$storeExists) array_push($res->errors, "invalid store_id");
}

$user->password = getBody("password");
if (is_null($user->password)) array_push($res->errors, "must include password");
else $res->errors = array_merge($res->errors, $user->checkPassword());

if (count($res->errors) == 0) {
    $user->createHash();
    try {
        $result = DB::queryFirstRow("SELECT id FROM users WHERE username=%s LIMIT 1", $user->username);
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