<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST");

//to handle the JSON payload from the axios post request
$post_data = json_decode(file_get_contents('php://input'), true);

if (isset($post_data["name"])){
    $name = $post_data["name"];
}else{
    $name = "missing name";
}    

//response data
$response_data = doCreateBooking($name);

//format data into json
echo json_encode($response_data);


function doCreateBooking($name){
    //insert code to insert user to database

    return array("status" => 200, 
                "message" => "Booking successfully created.",
                "name" => $name); 
}

?>