<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "capacitycontroller";
$conn = mysqli_connect($servername, $username, $password, $dbname); //Connect to database
if($conn->connect_error) {die("Connection failed: " . $conn->connect_error);} //If connection fails

$sql = "SELECT business_name, email, image_link, store_address, phone, max_capacity, current_capacity, actual_capacity, bio FROM stores;";
$result = mysqli_query($conn, $sql);
$rows=array();
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        array_push($rows, $row);  
    }
    echo json_encode($rows);
} else {
    echo json_encode("0");
}

//$sql = "SELECT * FROM Orders LIMIT 15, 10"; //Return 16-25
$conn->close();
?>