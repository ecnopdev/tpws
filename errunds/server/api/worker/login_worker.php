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

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

//get username and password
$worker->username = $data->username;
$worker->password = $data->password;

//get worker
$worker->login_worker();


//create array
$user_array = array(
    'id' => $worker->id,
    'username' => $worker->username,
    'password' => $worker->password,
);

if($worker->username == null) {
    print_r(json_encode("Login failed"));
}else{
    //make JSON
    print_r(json_encode($user_array));
}



?>
