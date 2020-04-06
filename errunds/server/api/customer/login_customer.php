<?php

//headers
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');


include_once('../../config/Database.php');
include_once('../../models/Customer.php');

//instantiate db and connect
$database = new Database();
$db = $database->connect();

//instantiate Customer object
$customer = new Customer($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

//get username and password
$customer->username = $data->username;
$customer->password = $data->password;

//get customer
$customer->login_customer();


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

if($customer->username == null) {
    print_r(json_encode("Login failed"));
}else{
    //make JSON
    print_r(json_encode($user_array));
}



?>
