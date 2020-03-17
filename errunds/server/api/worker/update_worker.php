<?php

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');

include_once('../../config/Database.php');
include_once('../../models/Worker.php');

//instantiate db and connect
$database = new Database();
$db = $database->connect();

//instantiate worker object
$worker = new Worker($db);

//get raw data
$data = json_decode(file_get_contents("php://input"));

//set ID to UPDATE
$worker->id = $data->id;

$worker->first_name = $data->first_name;
$worker->last_name = $data->last_name;
$worker->email = $data->email;
$worker->address = $data->address;
$worker->contact = $data->contact;
$worker->username = $data->username;
$worker->password = $data->password;
$worker->average_rating = $data->average_rating;
$worker->job_id = $data->job_id;

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

?>
