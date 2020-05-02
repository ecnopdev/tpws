<?php

//FOR AUTHORIZATION
//==========================================
ini_set("display_errors", 1);

require_once("../../auth/AuthClient.php");
//==========================================

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Content-Type');

include_once('../../config/Database.php');
include_once('../../models/Booking.php');

//instantiate db and connect
$database = new Database();
$db = $database->connect();

//instantiate booking object
$booking = new Booking($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));


//FOR AUTHORIZATION
//======================================================
$headers = getallheaders();
$token = $headers["Authorization"];

$auth = new AuthClient(null, $token);
$payload = $auth->request_auth();

if(isset($payload->data)){
    //echo("Authorized");
    //set ID to update
    $booking->id = $data->id;

    //delete booking
    if($booking->delete_booking()){
      echo json_encode(
        array('message' => 'Booking Deleted')
      );
    }else{
      echo json_encode(
        array('message' => 'Booking Not Deleted')
      );
    }

}else{
  //echo("Not authorized");
  echo json_encode(
    array(
      'message' => 'User not authorized'
    )
  );
}
//=====================================================


?>
