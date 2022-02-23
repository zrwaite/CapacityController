<?php
//Imports

use JetBrains\PhpStorm\ArrayShape;

//dev array shape import

require_once __DIR__ . "/../modules/checkers.php";
require_once __DIR__ . "/../auth/tokens.php";
require_once __DIR__ . "/../modules/mailer.php";
require_once __DIR__ . "/user.php";


class PostAdmin extends PostUser
{ //Class for json response
    public int $confirmation_code;
    public string|null $email;

    public function __construct()
    {
        parent::__construct();
        $this->admin = true;
        $this->store_id = null;
        $this->createConfirmationCode();
        array_push($this->neededParams, "email");
    }
    public function createConfirmationCode()
    {
        $chars = 6;
        $data = '123456789';
        $this->confirmation_code = intval(substr(str_shuffle($data), 0, $chars));
    }

    public function checkEmail(): bool
    {
        return checkEmail($this->email);
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
                } else if ($key=="email") {
                    if (!$this->checkEmail()) array_push($errors, "invalid email");
                }
            }
        }
        return $errors;
    }

    public function sendEmailConfirmation() {
        sendEmailConfirmation($this->email, $this->confirmation_code);
    }
}

class PutAdmin
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