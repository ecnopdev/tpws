<?php

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/Booking.php');

//instantiate db and connect
$database = new Database();
$db = $database->connect();

//instantiate Booking object
$booking = new Booking($db);

//get ID
$booking->id = isset($_GET['id']) ? $_GET['id'] : die();

//get booking
$booking->read_single_booking();

//create array
$booking_array = array(
    'id' => $booking->id,
    'creation_date' => $booking->creation_date,
    'booking_date' => $booking->booking_date,
    'start_time' => $booking->start_time,
    'end_time' => $booking->end_time,
    'status' => $booking->status,
    'rating' => $booking->rating,
    'comments' => $booking->comments,
    'customer_id' => $booking->customer_id,
    'worker_id' => $booking->worker_id,
    'worker_firstname' => $booking->worker_firstname,
    'worker_lastname' => $booking->worker_lastname 
);

//make JSON
print_r(json_encode($booking_array));

?>
