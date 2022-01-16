<?php

const storeTarget = [
    "strings" => ["business_name", "image_link", "store_address", "store_hours", "phone", "public_email", "bio"],
    "ints" => ["id", "max_capacity", "num_shoppers", "actual_capacity"],
    "bools" => []
];

function getParseResult(array $result, string $type): bool|array
{
    if ($type=="store") $target = storeTarget;
    else return false;
    $resArray = [];
    foreach($target['strings'] as $elem) $resArray[$elem] = $result[$elem];
    foreach($target['ints'] as $elem) $resArray[$elem] = intval($result[$elem]);
    foreach($target['bools'] as $elem) $resArray[$elem] = boolval($result[$elem]);
    return $resArray;
}