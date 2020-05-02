<?php

//FOR AUTHORIZATION
//==========================================
ini_set("display_errors", 1);

require_once("../../auth/AuthClient.php");
//==========================================

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

include_once('../../config/Database.php');
include_once('../../models/Booking.php');

//instantiate db and connect
$database = new Database();
$db = $database->connect();

//instantiate booking object
$booking = new Booking($db);

//get raw data
$data = json_decode(file_get_contents("php://input"));


//FOR AUTHORIZATION
//======================================================
$headers = getallheaders();
$token = $headers["Authorization"];

$auth = new AuthClient(null, $token);
$payload = $auth->request_auth();

if(isset($payload->data)){
    //echo("Authorized");
    $booking->creation_date = $data->creation_date;
    $booking->booking_date = $data->booking_date;
    $booking->start_time = $data->start_time;
    $booking->end_time = $data->end_time;
    $booking->status = $data->status;
    $booking->rating = $data->rating;
    $booking->comments = $data->comments;
    $booking->customer_id = $data->customer_id;
    $booking->worker_id = $data->worker_id;

    //create booking
    if($booking->create_booking()){
      echo json_encode(
        array('message' => 'Booking Created')
      );
    }else{
      echo json_encode(
        array('message' => 'Booking Not Created')
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
