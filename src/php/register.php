<?php
//Creates object for response
include 'response.php';
$res = new Response;

class Business {
    public $bname;
    public $username;
    public $hash;
    public $address;
    public $email;
    function check_username($conn, $object){
        $stmt = $conn->prepare("SELECT 1 FROM users WHERE username = ?");
        $stmt->bind_param("s", $this->username);
        $stmt->execute(); 
        $result = $stmt->get_result();
        $response = $result->fetch_assoc();
        $stmt->close();
        if (!is_null($response)){
            array_push($object->errors,"username");
        }
    }
}

if (!empty($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $req = new Business(); //Create object for new business
    if(isset($_POST['bname'])){$req->bname = stripslashes(trim(htmlspecialchars($_POST['bname'])));}
    else {array_push($res->errors,"no bname");} //Confirm business name

    if(isset($_POST['username'])){$req->username = stripslashes(trim(htmlspecialchars($_POST['username'])));}
    else {array_push($res->errors,"no username");} //COnfirm username

    if(isset($_POST['pword'])){$req->hash = password_hash(stripslashes(trim(htmlspecialchars($_POST['pword']))), PASSWORD_DEFAULT);}
    else {array_push($res->errors,"no pword");} //Confirm password

    if(isset($_POST['pword2'])) {
        if ($_POST['pword'] != $_POST['pword2']){array_push($res->errors,"pwordMatch");}
    }
    else{array_push($res->errors,"no pword2");} //Confirm password2

    if(isset($_POST['address'])){$req->address = stripslashes(trim(htmlspecialchars($_POST['address'])));}
    else {array_push($res->errors,"no address");} //Confirm address

    if(isset($_POST['email'])){
        $req->email = stripslashes(trim(htmlspecialchars($_POST['email'])));
        if (!filter_var($req->email, FILTER_VALIDATE_EMAIL)) {array_push($res->errors,"email");}
    }
    else {array_push($res->errors,"no email");} //confirm email twice

    
    
    //That jumbled mess just confirmed that all of the inormation is included.

    //Allows for connection to server
    include 'database.php';
    if($conn->connect_error) {
        array_push($res->errors, $conn->connect_error);
    } 
    else{
        $res->connected = true;
        $req->check_username($conn, $res);
    }
    if (!$res->errors){
        //Add store information
        $stmt = $conn->prepare("INSERT INTO stores (business_name, admin_username, password_hash, store_address, email) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $req->bname, $req->username, $req->hash, $req->address, $req->email);
        $stmt->execute(); 

        //Find the id of the new store
        $stmt = $conn->prepare("SELECT id, admin_username FROM stores WHERE (admin_username = ?)");
        $stmt->bind_param("s", $req->username);
        $stmt->execute(); 
        $result = $stmt->get_result();
        $id=0;
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                if ($row["admin_username"] == $req->username){ //Confirms proper id
                    $id = $row["id"];
                }
            }
        }
        if ($id==0){
            //If ids don't match, major error.
            array_push($res->errors, "idMatch");
        }
        else{
            //Add user with store_id referenced.
            $stmt = $conn->prepare("INSERT INTO users (username, password_hash, store_id) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $req->username, $req->hash, $id);
            $stmt->execute(); 
            $res->success = true;
        }
        $stmt->close();
    }
    $conn->close();
} else{
    array_push($res->errors,"no params");
}
echo json_encode($res);


//File storage in php
/*
        $info = pathinfo($_FILES['image']['name']);
        $ext = $info['extension']; // get the extension of the file
        $newname = $req->bname."Logo.".$ext; 

        $target = '../../files/images/'.$newname;
        if(move_uploaded_file($_FILES['image']['name'], $target)){
            echo json_encode($target);
        }
        else{
            echo json_encode('nope');
        }
        
        */

?>