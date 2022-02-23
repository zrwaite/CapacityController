<?php
switch ($_SERVER['REQUEST_METHOD']) {
    case "PUT":
        require __DIR__ . "/putShopper.php";
        break;
    default:
        echo "Invalid request method";
}