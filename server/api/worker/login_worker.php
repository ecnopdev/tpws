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
    'first_name' => $worker->first_name,
    'last_name' => $worker->last_name,
    'email' => $worker->email,
    'address' => $worker->address,
    'contact' => $worker->contact,
    'username' => $worker->username,
    'password' => $worker->password,
);

if($worker->username == null) {
    print_r(json_encode("Login failed"));
}else{
    //FOR AUTHORIZATION
    //======================================================
    $auth = new AuthClient($user_array, null);
    $returned_array = $auth->login_auth();
    
    //make JSON
    print_r(json_encode($returned_array));
    //=====================================================
}



?>
