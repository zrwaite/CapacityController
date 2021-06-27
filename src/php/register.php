<?php
class Business {
    public $bname;
    public $username;
    public $hash;
    public $address;
    public $email;
  }
function check_username($username, $conn){
    $stmt = $conn->prepare("SELECT 1 FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute(); 
    $result = $stmt->get_result();
    $response = $result->fetch_assoc();
    $stmt->close();
    if (is_null($response)){return True;}
    else{return False;}
}
if (!empty($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $new = new Business();
    $errors = array();
    if(isset($_POST['bname'])){$new->bname = stripslashes(trim(htmlspecialchars($_POST['bname'])));}
    else {array_push($errors,"no bname");} //Confirm business name
    if(isset($_POST['username'])){$new->username = stripslashes(trim(htmlspecialchars($_POST['username'])));}
    else {array_push($errors,"no username");} //COnfirm username
    if(isset($_POST['pword'])){$new->hash = password_hash(stripslashes(trim(htmlspecialchars($_POST['pword']))), PASSWORD_DEFAULT);}
    else {array_push($errors,"no password");} //Confirm password
    if(!isset($_POST['pword2'])){array_push($errors,"no password2");} //Confirm password
    if(isset($_POST['address'])){$new->address = stripslashes(trim(htmlspecialchars($_POST['address'])));}
    else {array_push($errors,"no address");} //Confirm address
    if(isset($_POST['email'])){$new->email = stripslashes(trim(htmlspecialchars($_POST['email'])));}
    else {array_push($errors,"no email");} //confirm email twice
    if (!filter_var($new->email, FILTER_VALIDATE_EMAIL)) {array_push($errors,"email");}
    if ($_POST['pword'] != $_POST['pword2']){array_push($errors,"password");}
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "capacitycontroller";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {die("Error: " . $conn->connect_error);}
    if (!check_username($new->username, $conn)){array_push($errors,"username");}
    if (!$errors){
/*
        $info = pathinfo($_FILES['image']['name']);
        $ext = $info['extension']; // get the extension of the file
        $newname = $new->bname."Logo.".$ext; 

        $target = '../../files/images/'.$newname;
        if(move_uploaded_file($_FILES['image']['name'], $target)){
            echo json_encode($target);
        }
        else{
            echo json_encode('nope');
        }
        
        */

        $stmt = $conn->prepare("INSERT INTO stores (business_name, admin_username, password_hash, store_address, email) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $new->bname, $new->username, $new->hash, $new->address, $new->email);
        $stmt->execute(); 
        echo json_encode("Stores");

        $sql = "SELECT id FROM stores;"; //WHERE username = '$new->username';
        $result = mysqli_query($conn, $sql);
        $rows=array();
        echo "hello".$result;
        /*
        echo mysqli_num_rows($result);
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                array_push($rows, $row);  
            }
            echo json_encode($rows);
        } else {
            echo json_encode("0");
        }
        */

        $stmt = $conn->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
        $stmt->bind_param("ss", $new->username, $new->hash);
        $stmt->execute(); 
        echo json_encode("Users");


        /*
        $stmt = $conn->prepare('SELECT * FROM stores WHERE username = ?');
        $stmt->bind_param("s", $new->username);
        */
            /*
            
            $stmt->execute(); 
            $result = $stmt->get_result();
            echo json_encode($result);
            $response = $result->fetch_assoc();
            echo json_encode($response);
            echo json_encode("Id");

        */
        
        
        
        $stmt->close();
        $conn->close();
    }
    else {
        $conn->close();
        $response = $errors;
        echo json_encode($errors);
    }
}
else{echo "Error";}

?>