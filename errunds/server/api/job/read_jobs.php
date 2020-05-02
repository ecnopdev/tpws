<?php

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

include_once('../../config/Database.php');
include_once('../../models/Job.php');

//instantiate db and connect
$database = new Database();
$db = $database->connect();

//instantiate job object
$job = new Job($db);

//jobs query
$result = $job->read_jobs();

//get row count
$row_count = $result->rowCount();

//check if there are jobs
if($row_count > 0){
  //Job array
  $jobs_array = array();
  $jobs_array['data'] = array();

  while($row = $result->fetch(PDO::FETCH_ASSOC)){
    extract($row);
    $job_item = array(
      'id' => $id,
      'name' => $name,
      'fee' => $fee
    );

    //push to data
    array_push($jobs_array['data'], $job_item);

  }

  //turn to JSON and output
  echo json_encode($jobs_array);

}else{
  //no jobs
  echo json_encode(
    array('message' => 'No Jobs Found')
  );
}

?>
