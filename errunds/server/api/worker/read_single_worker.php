<?php

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/Worker.php');

//instantiate db and connect
$database = new Database();
$db = $database->connect();

//instantiate Worker object
$worker = new Worker($db);

//get ID
$worker->id = isset($_GET['id']) ? $_GET['id'] : die();

//get worker
$worker->read_single_worker();


//create array
$worker_array = array(
    'id' => $worker->id,
    'first_name' => $worker->first_name,
    'last_name' => $worker->last_name,
    'email' => $worker->email,
    'address' => $worker->address,
    'contact' => $worker->contact,
    'username' => $worker->username,
    'password' => $worker->password,
    'average_rating' => $worker->average_rating,
    'job_id' => $worker->job_id
);

//make JSON
print_r(json_encode($worker_array));

?>
