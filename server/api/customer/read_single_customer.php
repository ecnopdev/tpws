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
include_once('../../models/Customer.php');

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
