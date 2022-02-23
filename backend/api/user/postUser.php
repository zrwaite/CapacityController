<?php

assert($_SERVER['REQUEST_METHOD'] == "POST");

use Symfony\Component\Dotenv\Dotenv;

//Imports
require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/../../models/response.php";
require_once __DIR__ . "/../../modules/database.php"; //Connect to database
require_once __DIR__ . "/../../modules/readParams.php";
require_once __DIR__ . "/../../models/user.php";
require_once __DIR__ . "/../../models/admin.php";

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . "/../../modules/env/.env");

//Main
//Object declaraion
$res = new Response();
$res->request_type = "POST";

$admin = getBody("admin");
if ($admin) {
    $user = new PostAdmin();
    $user->email = getBody("email");
} else {
    $user = new PostUser();
    $user->store_id = getBody("store_id");
    if (is_null($user->store_id)) array_push($res->errors, "missing param store_id");
    else {
        $storeExists = DB::queryFirstRow("SELECT id FROM stores WHERE id=%s LIMIT 1", $user->store_id);
        if (!$storeExists) array_push($res->errors, "invalid store_id");
    }
}
$user->password = getBody("password");
$user->username = getBody("username");

$res->errors = array_merge($res->errors, $user->getAttributeErrors());

if (count($res->errors) == 0) {
    $user->createHash();
    try {
        $result = DB::queryFirstRow("SELECT id FROM users WHERE username=%s LIMIT 1", $user->username);
        if (!$result) {
            DB::insert('users', array(
                'username' => $user->username,
                'password_hash' => $user->password_hash,
                'store_id' => $user->store_id,
                'admin' => $user->admin,
                'email' => $user->email,
            ));
            $res->status = 200;
            $res->success = true;
            $res->objects = $user->createResponse();
            if ($user->admin) $user->sendEmailConfirmation();
        } else array_push($res->errors, "username already in use");
    } catch (Exception $e) {
        array_push($res->errors, "database error");
    }
}
http_response_code($res->status);
echo json_encode($res);