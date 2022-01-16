<?php
switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        require __DIR__ . "/getUser.php";
        break;
    case "POST":
        require __DIR__ . "/postUser.php";
        break;
    case "PUT":
        require __DIR__ . "/putUser.php";
        break;
    case "DELETE":
        require __DIR__ . "/deleteUser.php";
        break;
    default:
        echo "What Request Method is this???";
}