<?php
assert($_SERVER['REQUEST_METHOD'] == "POST");

//Imports
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../models/response.php";
require_once __DIR__ . "/../modules/readParams.php";
require_once __DIR__ . "/../modules/checkers.php";
require_once __DIR__ . "/tokens.php";

//Main
$res = new Response();

$username = getBody("username");
$password = getBody("password");
if (is_null($username)) array_push($res->errors, "missing username query");
if (is_null($password)) array_push($res->errors, "missing password query");

if (count($res->errors) == 0) {
    $query = "id, password_hash, store_id";
    $result = DB::queryFirstRow("SELECT " . $query . " FROM users WHERE username=%s LIMIT 1", $username);
    if ($result['id']) $res->status = (password_verify($password, $result['password_hash'])) ? 200 : 400;
    else $res->status = 404;
    if ($res->status == 200) {
        $tokenBody = new tokenBody($username);
        $token = createToken($tokenBody);
        $res->status = 200;
        $res->success = true;
        $res->objects = ["token" => $token, "store_id" => $result['store_id']];
    } else if ($res->status == 404) array_push($res->errors, "user not found");
    else array_push($res->errors, "incorrect password");
}
http_response_code($res->status);
echo json_encode($res);