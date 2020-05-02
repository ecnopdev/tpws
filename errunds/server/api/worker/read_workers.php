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




//FOR AUTHORIZATION
//======================================================
$headers = getallheaders();
$token = $headers["Authorization"];

$auth = new AuthClient(null, $token);
$payload = $auth->request_auth();

if(isset($payload->data)){
    //instantiate Worker object
    $worker = new Worker($db);

    //get User ID
    //$worker->id = isset($_GET['user_id']) ? $_GET['user_id'] : die();

    //workers query
    $result = $worker->read_workers();

    //get row count
    $row_count = $result->rowCount();

    //check if there are workers
    if($row_count > 0){
      //Worker array
      $workers_array = array();
      $workers_array['data'] = array();

      while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $worker_item = array(
          'id' => $id,
          'first_name' => $first_name,
          'last_name' => $last_name,
          'email' => $email,
          'address' => $address,
          'contact' => $contact,
          'username' => $username,
          'password' => $password,
          'average_rating' => $average_rating,
          'job_id' => $job_id
        );

        //push to data
        array_push($workers_array['data'], $worker_item);

      }

      //turn to JSON and output
      echo json_encode($workers_array);

    }else{
      //no workers
      echo json_encode(
        array('message' => 'No Workers Found')
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
