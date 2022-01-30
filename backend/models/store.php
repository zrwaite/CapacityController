<?php
//Imports

use JetBrains\PhpStorm\ArrayShape;

//dev array shape import

require_once __DIR__ . "/../modules/checkers.php";
require_once __DIR__ . "/../auth/tokens.php";
require_once __DIR__ . "/../modules/mailer.php";


class PostStore
{ //Class for json response
    public string $name;
    public int $max_capacity, $num_shoppers, $actual_capacity;
    public int $admin_username;
    #[ArrayShape(["request" => "mixed", "token" => "string"])] //Dev Array shape implementation
    public function createResponse(): array
    {
        return [
            "request" => json_decode(file_get_contents('php://input'), true)
        ];
    }
}

class PutStore
{
    public array $params = ["name", "store_id", "password"];

    #[ArrayShape(["errors" => "array", "puts" => "array"])] //dev Array Shape reference
    public function getPutArray($email): array
    {
        $errors = array();
        $puts = array();
        for ($i = 0; $i < count($this->params); $i++) {
            $current_param = $this->params[$i];
            $error = false;
            $param = getBody($current_param);
            if (!$param) continue; //If the parameter isn't defined continue, otherwise check the switch for special cases
            switch ($current_param) {
                case "name": case "store_id": break;
                default:
                    $error = true;
                    array_push($errors, "Zac you forgot to implement put switch for $current_param");
                    break;
            }
            if (!$error) $puts[$current_param] = $param;
        } //End of for loop
        return [
            "errors" => $errors,
            "puts" => $puts,
        ];
    }
}

//class GetStore
//{
//    public int $id, $max_capacity, $num_shoppers, $actual_capacity;
//    public string $business_name;
//    public string|null $store_address, $store_hours, $phone, $bio, $image_link, $public_email;
//}