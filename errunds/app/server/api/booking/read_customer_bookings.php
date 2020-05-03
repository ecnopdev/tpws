<?php

//FOR AUTHORIZATION
//==========================================
ini_set("display_errors", 1);

require_once("../../auth/AuthClient.php");
//==========================================

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

include_once('../../config/Database.php');
include_once('../../models/Booking.php');

//instantiate db and connect
$database = new Database();
$db = $database->connect();


//FOR AUTHORIZATION
//======================================================
$headers = getallheaders();
$token = $headers["Authorization"];

$auth = new AuthClient(null, $token);
$payload = $auth->request_auth();

if(isset($payload->data)){
    //instantiate Booking object
    $booking = new Booking($db);

    //get User ID
    $booking->customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : die();

    //booking query
    $result = $booking->read_customer_bookings();

    //get row count
    $row_count = $result->rowCount();

    //check if there are bookings
    if($row_count > 0){
      //Booking array
      $bookings_array = array();
      $bookings_array['data'] = array();

      while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $booking_item = array(
          'id' => $id,
          'creation_date' => $creation_date,
          'booking_date' => $booking_date,
          'start_time' => $start_time,
          'end_time' => $end_time,
          'status' => $status,
          'rating' => $rating,
          'comments' => $comments,
          'customer_id' => $customer_id,
          'worker_id' => $worker_id,
          'worker_firstname' => $worker_firstname,
          'worker_lastname' => $worker_lastname, 
          'customer_firstname' => $customer_firstname,
          'customer_lastname' => $customer_lastname
        );

        //push to data
        array_push($bookings_array['data'], $booking_item);

      }

      //turn to JSON and output
      echo json_encode($bookings_array);

    }else{
      //no bookings
      echo json_encode(
        array('message' => 'No Bookings Found')
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
