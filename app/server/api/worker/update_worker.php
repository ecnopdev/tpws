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
include_once('../../models/Worker.php');

//instantiate db and connect
$database = new Database();
$db = $database->connect();

//instantiate worker object
$worker = new Worker($db);

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
    //set ID to UPDATE
    $worker->id = $data->id;

    $worker->first_name = $data->first_name;
    $worker->last_name = $data->last_name;
    $worker->email = $data->email;
    $worker->address = $data->address;
    $worker->contact = $data->contact;
    $worker->username = $data->username;

    //update worker
    if($worker->update_worker()){
      echo json_encode(
        array('message' => 'Worker Updated')
      );
    }else{
      echo json_encode(
        array('message' => 'Worker Not Updated')
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
