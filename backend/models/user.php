<?php
//Imports

use JetBrains\PhpStorm\ArrayShape;

//dev array shape import

require_once __DIR__ . "/../modules/checkers.php";
require_once __DIR__ . "/../auth/tokens.php";
require_once __DIR__ . "/../modules/mailer.php";


class PostUser
{ //Class for json response
    public array $neededParams = ["username", "password", "password", "admin"];
    public string|null $username, $password, $password_hash, $email = null;
    public int|null $store_id;
    public bool $admin;

    public function __construct()
    {
        $this->admin = false;
    }

    public function checkPassword(): array
    {
        return checkPassword($this->password);
    }

    public function createHash()
    {
        $this->password_hash = password_hash($this->password, PASSWORD_DEFAULT);
    }

    #[ArrayShape(["request" => "mixed", "token" => "string"])] //Dev Array shape implementation
    public function createResponse(): array
    {
        return [
            "request" => json_decode(file_get_contents('php://input'), true),
            "token" => $this->createSetToken()
        ];
    }

    public function createSetToken(): string
    {
        $token = createToken(new tokenBody($this->username));
        setcookie("token", $token, time() + (86400 * 30), "/");
        return $token;
    }

    public function getAttributeErrors(): array{
        $errors = [];
        $thisObject = get_object_vars($this);
        foreach ($this->neededParams as $key) {
            $value = $thisObject[$key];
            if (is_null($value)) array_push($errors, "missing param ".$key);
            else {
                if ($key=="password") {
                    $errors = array_merge($errors, $this->checkPassword());
                }
            }
        }
        return $errors;
    }
}

class PutUser
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
            $getParam = getBody($current_param);
            if (!$getParam["set"]) continue; //If the parameter isn't defined continue, otherwise check the switch for special cases
            $param = $getParam["value"];
            switch ($current_param) {
                case "name": case "store_id":
                    break;
                case "password":
                    $getOldPassword = getBody("old_password");
                    if (!$getOldPassword["set"]) {
                        array_push($errors, "old_password not defined");
                    } else {
                        $oldPassword = $getOldPassword["value"];
                        $password_status = validatePassword($oldPassword, $email);
                        if ($password_status == 400 || $password_status == 404) $error = true;
                        if ($password_status == 400) array_push($errors, "invalid password"); //Check for failed password
                        else if ($password_status == 404) array_push($errors, "account not found"); //Check for failed account
                    }
                    $password_errors = checkPassword($param); //Check that new password is valid
                    if (count($password_errors) != 0) {
                        $errors = array_merge($errors, $password_errors);
                        $error = true;
                    }
                    if (!$error) {
                        $puts["password_hash"] = password_hash($param, PASSWORD_DEFAULT);
                        $error = true; //Set to true to avoid adding password to database instead of hash
                    }
                    break;
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