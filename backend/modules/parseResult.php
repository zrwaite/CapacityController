<?php
const storeTarget = [
    ["name" => "id", "type" => "int"],
    ["name" => "max_capacity", "type" => "int"],
    ["name" => "num_shoppers", "type" => "int"],
    ["name" => "actual_capacity", "type" => "int"],
    ["name" => "business_name", "type" => "string"],
    ["name" => "image_link", "type" => "string"],
    ["name" => "store_address", "type" => "string"],
    ["name" => "store_hours", "type" => "string"],
    ["name" => "phone", "type" => "string"],
    ["name" => "public_email", "type" => "string"],
    ["name" => "bio", "type" => "string"]
];

function parseResult(array $result, string $type): bool|array
{
    if ($type=="store") $target = storeTarget;
    else return false;
    $resArray = [];
    foreach($target as $key) {
        if (!$key['name']) throw new Exception('missing key->name'. json_encode($key));
        if (!$key['type']) throw new Exception('missing key->type'.  json_encode($key));
        if ($key['type'] == "string") $resArray[$key['name']] = $result[$key['name']];
        else if ($key['type'] == "int") $resArray[$key['name']] = intval($result[$key['name']]);
        else if ($key['type'] == "bool") $resArray[$key['name']] = boolval($result[$key['name']]);
        else throw new Exception ("undefined type".  $key['type']);
    }
    return $resArray;
}