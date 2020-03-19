<?php

class Database{
  //db paramerters
  private $host = 'localhost';
  private $db_name = 'errund_api';
  private $db_username = 'errunds_admin';
  private $db_password = 'ofGWydUm2Z5I';
  private $port = "8080";
  private $base_path = "/server/api/";
  private $conn;

  public function connect(){
    $this->conn = null;

    try{
      $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name,
      $this->db_username, $this->db_password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
      echo 'Connection Error: ' . $e->getMessage();
    }
    return $this->conn;
  }

}

?>
