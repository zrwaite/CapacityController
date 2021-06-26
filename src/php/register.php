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
    if(isset($_POST['bname'])){
        $new->bname = stripslashes(trim(htmlspecialchars($_POST['bname'])));
    }
    else {
        array_push($errors,"bname");
    }
    if(isset($_POST['username'])){
        $new->username = stripslashes(trim(htmlspecialchars($_POST['username'])));
    }
    else {
        array_push($errors,"username");
    }
    if(isset($_POST['password'])){
        $new->hash = password_hash(stripslashes(trim(htmlspecialchars($_POST['password']))), PASSWORD_DEFAULT);
    }
    else {
        array_push($errors,"password");
    }
    if(isset($_POST['address'])){
        $new->username = stripslashes(trim(htmlspecialchars($_POST['address'])));
    }
    else {
        array_push($errors,"address");
    }
    if(isset($_POST['email'])){
        $new->email = stripslashes(trim(htmlspecialchars($_POST['email'])));
    }
    else {
        array_push($errors,"email");
    }
    if (!filter_var($new->email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors,"email");
    }
    if (!$errors){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "capacitycontroller";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {die("Error: " . $conn->connect_error);} 

        $stmt = $conn->prepare('SELECT 1 FROM ssyc22_attendees WHERE email = ?');
        $stmt->bind_param('s', $email); // 's' specifies the variable type => 'string'
        $stmt->execute(); 
        $result = $stmt->get_result();
        $response = $result->fetch_assoc();
        if (is_null($response)){$response="Valid";}
        else{$response="Used";}
        $stmt->close();
        $conn->close();
    }
    echo json_encode($response);
}
else{echo "Error";}

?>