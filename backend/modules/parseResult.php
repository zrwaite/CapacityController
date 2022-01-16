<?php

const storeTarget = [
    "strings" => ["name", "image_link", "address", "hours", "phone", "public_email", "bio"],
    "ints" => ["id", "max_capacity", "num_shoppers", "actual_capacity"],
    "bools" => []
];

const userTarget = [
    "strings" => ["username"],
    "ints" => ["id", "store_id"],
    "bools" => []
];

function getParseResult(array $result, string $type): bool|array
{
    if ($type=="store") $target = storeTarget;
    else if ($type=="user") $target = userTarget;
    else return false;
    $resArray = [];
    foreach($target['strings'] as $elem) $resArray[$elem] = $result[$elem];
    foreach($target['ints'] as $elem) $resArray[$elem] = intval($result[$elem]);
    foreach($target['bools'] as $elem) $resArray[$elem] = boolval($result[$elem]);
    return $resArray;
}