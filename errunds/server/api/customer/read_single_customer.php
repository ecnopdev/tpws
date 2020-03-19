<?php

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/Customer.php');

//instantiate db and connect
$database = new Database();
$db = $database->connect();

//instantiate Customer object
$customer = new Customer($db);

//get ID
$customer->id = isset($_GET['id']) ? $_GET['id'] : die();

//get customer
$customer->read_single_customer();


//create array
$user_array = array(
    'id' => $customer->id,
    'first_name' => $customer->first_name,
    'last_name' => $customer->last_name,
    'email' => $customer->email,
    'address' => $customer->address,
    'contact' => $customer->contact,
    'username' => $customer->username,
    'password' => $customer->password,
);

//make JSON
print_r(json_encode($user_array));

?>
