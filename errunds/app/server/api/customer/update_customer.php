<?php

//FOR AUTHORIZATION
//==========================================
ini_set("display_errors", 1);

require_once("../../auth/AuthClient.php");
//==========================================

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Content-Type, Authorization');


include_once('../../config/Database.php');
include_once('../../models/Customer.php');

//instantiate db and connect
$database = new Database();
$db = $database->connect();

//instantiate customer object
$customer = new Customer($db);

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
    //set ID to UPDATE
    $customer->id = $data->id;

    $customer->first_name = $data->first_name;
    $customer->last_name = $data->last_name;
    $customer->email = $data->email;
    $customer->address = $data->address;
    $customer->contact = $data->contact;
    $customer->username = $data->username;
    $customer->password = $data->password;

    //update customer
    if($customer->update_customer()){
      echo json_encode(
        array(
          'message' => 'Customer Updated'
        )
      );
    }else{
      echo json_encode(
        array(
          'message' => 'Customer Not Updated'
        )
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
