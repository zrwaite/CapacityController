<?php
class Business {
    public $bname;
    public $username;
    public $hash;
    public $address;
    public $email;
  }
if (!empty($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $new = new Business();
    $errors = array();
    if(isset($_POST['bname'])){$new->bname = stripslashes(trim(htmlspecialchars($_POST['bname'])));}
    else {array_push($errors,"bname");} //Confirm business name
    if(isset($_POST['username'])){$new->username = stripslashes(trim(htmlspecialchars($_POST['username'])));}
    else {array_push($errors,"username");} //COnfirm username
    if(isset($_POST['password'])){$new->hash = password_hash(stripslashes(trim(htmlspecialchars($_POST['password']))), PASSWORD_DEFAULT);}
    else {array_push($errors,"password");} //Confirm password
    if(isset($_POST['address'])){$new->username = stripslashes(trim(htmlspecialchars($_POST['address'])));}
    else {array_push($errors,"address");} //Confirm address
    if(isset($_POST['email'])){$new->email = stripslashes(trim(htmlspecialchars($_POST['email'])));}
    else {array_push($errors,"email");} //confirm email twice
    if (!filter_var($new->email, FILTER_VALIDATE_EMAIL)) {array_push($errors,"email");}
    if (!$errors){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "capacitycontroller";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {die("Error: " . $conn->connect_error);}
        
        $stmt = $conn->prepare("INSERT INTO ssyc22_attendees (first_name, last_name, email, password_hash, password_set) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $registrant->fname, $registrant->lname, $registrant->email, $registrant->hash, 1);
        $stmt->execute(); 
        $result = $stmt->get_result();
        if ($result){$response = "Success";}
        else{$response = "Failure";}

        $stmt->close();
        $conn->close();
    }
    else {
        $response = $errors;
    }
    echo json_encode($response);
}
else{echo "Error";}

?>