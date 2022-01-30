<?php

use JetBrains\PhpStorm\ArrayShape;

#[ArrayShape(["set" => "boolean", "value" => "string"])] //dev Array Shape reference
function getBody(string $param): array
{
    if (isset($_POST[$param])) return ["set"=>true, "value"=>htmlspecialchars(stripslashes(trim($_POST[$param])))];
    else {
        $req = json_decode(file_get_contents('php://input'), true);
        if ($req[$param]) return ["set"=>true, "value"=>htmlspecialchars(stripslashes(trim($req[$param])))];
    }
    return ["set"=>false, "value"=>""];
}
#[ArrayShape(["set" => "boolean", "value" => "string"])] //dev Array Shape reference
function getQuery(string $param): array
{
    if (isset($_GET[$param])) return ["set"=>true, "value"=>htmlspecialchars(stripslashes(trim($_GET[$param])))];
    else return ["set"=>false, "value"=>""];
}