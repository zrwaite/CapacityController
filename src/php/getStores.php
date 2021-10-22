<?php

//Creates object for response
include 'response.php';
$res = new Response;

//Allows for connection to server
include 'database.php';
if($conn->connect_error) {
    array_push($res->errors, $conn->connect_error);
} 

else{
    //Connected to database
    $res->connected = true;
    $sql = "SELECT business_name, email, image_link, store_hours, store_address, phone, max_capacity, current_capacity, actual_capacity, bio FROM stores;";
    //Result of sql query
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {//If there is data
        while($row = mysqli_fetch_assoc($result)) { //Go through each row
            array_push($res->objects, $row);  //Add data to array
        }
        $res->success = true; //Successful
    }
}
echo json_encode($res);
$conn->close();

//Code for controller which stores are pulled in long list 
//$sql = "SELECT * FROM Orders LIMIT 15, 10"; //Return 16-25
?>