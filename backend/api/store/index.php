<?php
switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        require __DIR__ . "/getStore.php";
        break;
    case "POST":
        require __DIR__ . "/postStore.php";
        break;
    case "PUT":
        require __DIR__ . "/putStore.php";
        break;
    case "DELETE":
        require __DIR__ . "/deleteStore.php";
        break;
    default:
        echo "What Request Method is this???";
}