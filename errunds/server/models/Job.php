<?php

class Job{
  //db stuff
  private $conn;

  //job properties
  public $id;
  public $name;
  public $fee;


  //constructor
  public function __construct($db){
    $this->conn = $db;
  }

  //get jobs
  public function read_jobs(){
    $query = 'SELECT job.id, job.name, job.fee 
                FROM job';


    //prepare statement
    $stmt = $this->conn->prepare($query);

    //execute $query
    $stmt->execute();

    return $stmt;

  }



}


?>
