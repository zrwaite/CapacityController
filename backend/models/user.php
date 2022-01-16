<?php
//Imports

use JetBrains\PhpStorm\ArrayShape;

//dev array shape import

require_once __DIR__ . "/../modules/checkers.php";
require_once __DIR__ . "/../auth/tokens.php";
require_once __DIR__ . "/../modules/mailer.php";


class PostUser
{ //Class for json response
    public string $email = "";
    public string $name, $password, $hash;
    public int $confirmation_code, $store_id;

    public function __construct()
    {
        $this->createConfirmationCode();
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

    public function checkPassword(): array
    {
        return checkPassword($this->password);
    }

    public function createHash()
    {
        $this->hash = password_hash($this->password, PASSWORD_DEFAULT);
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
        $token = createToken(new tokenBody($this->email));
        setcookie("token", $token, time() + (86400 * 30), "/");
        return $token;
    }

    public function sendEmailConfirmation(): bool
    { //Dev development url
        $mailHtml = "
                <h1>Validate your email <a href='http://localhost:3000/confirmEmail?email=" . $this->email . "'>here</a></h1> 
                <p>Confirmation Code: " . $this->confirmation_code . "</p>
            ";
        $mailText = "
                Validate your email here: http://localhost:3000/confirmEmail?email=" . $this->email . "
                Confirmation Code: " . $this->confirmation_code;
        sendMail([$this->email], "Validate Email - Capacity Controller", $mailHtml, $mailText);
        return true;
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
            $param = getBody($current_param);
            if (!$param) continue; //If the parameter isn't defined continue, otherwise check the switch for special cases
            switch ($current_param) {
                case "name": case "store_id":
                    break;
                case "password":
                    $old_password = getBody("old_password");
                    if (!$old_password) {
                        array_push($errors, "old_password not defined");
                    } else {
                        $password_status = validatePassword($old_password, $email);
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