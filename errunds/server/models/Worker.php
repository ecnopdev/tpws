<?php

class Worker{
  //db stuff
  private $conn;

  //worker properties
  public $id;
  public $first_name;
  public $last_name;
  public $email;
  public $address;
  public $contact;
  public $username;
  public $password;
  public $average_rating;
  public $job_id;
  

  //constructor
  public function __construct($db){
    $this->conn = $db;
  }

  // check if worker username exists in the database
  public function login_worker(){
  
    //create query
    $query = 'SELECT worker.id, worker.username, worker.password, 
                     worker.first_name, worker.last_name, worker.email,
                     worker.address, worker.contact, worker.average_rating,
                     worker.job_id 
                FROM worker 
                WHERE worker.username = ?
                AND worker.password = ?';

    //prepare statement
    $stmt = $this->conn->prepare($query);

    //bind data
    $stmt->bindParam(1, $this->username);
    $stmt->bindParam(2, $this->password);

    //execute $query
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //set properties
    $this->id = $row['id'];
    $this->first_name = $row['first_name'];
    $this->last_name = $row['last_name'];
    $this->email = $row['email'];
    $this->address = $row['address'];
    $this->contact = $row['contact'];
    $this->job_id = $row['job_id'];
    $this->username = $row['username'];
    $this->password = $row['password'];

  }

  //get workers
  public function read_workers(){
    $start_time = isset($_GET['start_time']) ? $_GET['start_time'] : die();
    $end_time = isset($_GET['end_time']) ? $_GET['end_time'] : die();
    $booking_date = isset($_GET['booking_date']) ? $_GET['booking_date'] : die();
    
    $query = 'SELECT worker.id, worker.first_name, worker.last_name, worker.email, 
                  worker.address, worker.contact, worker.username, worker.password, 
                  worker.average_rating, worker.job_id, job.id as job_id
              FROM worker
              JOIN job ON worker.job_id = job.id 
              WHERE worker.id NOT IN 
              (SELECT booking.worker_id FROM booking 
              WHERE booking.start_time BETWEEN :start_time AND :end_time 
              AND booking.end_time BETWEEN :start_time AND :end_time
              AND booking.booking_date = :booking_date)';


    //prepare statement
    $stmt = $this->conn->prepare($query);

    //bind data
    $stmt->bindParam(':start_time', $start_time);
    $stmt->bindParam(':end_time', $end_time);
    $stmt->bindParam(':booking_date', $booking_date);

    //execute $query
    $stmt->execute();

    return $stmt;

  }

  // get single worker
  public function read_single_worker(){
    //create query
    $query = 'SELECT worker.id, worker.first_name, worker.last_name, worker.email, 
                  worker.address, worker.contact, worker.username, worker.password, 
                  worker.average_rating, worker.job_id
              FROM worker
              WHERE worker.id = :id';

    //prepare statement
    $stmt = $this->conn->prepare($query);

    //bind id
    $stmt->bindParam(':id', $this->id);

    //execute $query
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //set properties
    $this->first_name = $row['first_name'];
    $this->last_name = $row['last_name'];
    $this->email = $row['email'];
    $this->address = $row['address'];
    $this->contact = $row['contact'];
    $this->username = $row['username'];
    $this->password = $row['password'];
    $this->average_rating = $row['average_rating'];
    $this->job_id = $row['job_id'];


  }


  //update worker
  public function update_worker(){
    //create query
    $query = 'UPDATE worker
              SET
                first_name = :first_name,
                last_name = :last_name,
                email = :email, 
                address = :address, 
                contact = :contact,
                username = :username,
                password = :password,
                average_rating = :average_rating,
                job_id = :job_id
              WHERE
                worker.id = :id';

    //prepare statement
    $stmt = $this->conn->prepare($query);

    //clean data
    $this->first_name = htmlspecialchars(strip_tags($this->first_name));
    $this->last_name = htmlspecialchars(strip_tags($this->last_name));
    $this->email = htmlspecialchars(strip_tags($this->email));
    $this->address = htmlspecialchars(strip_tags($this->address));
    $this->contact = htmlspecialchars(strip_tags($this->contact));
    $this->username = htmlspecialchars(strip_tags($this->username));
    $this->password = htmlspecialchars(strip_tags($this->password));


    //bind data
    $stmt->bindParam(':first_name', $this->first_name);
    $stmt->bindParam(':last_name', $this->last_name);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':address', $this->address);
    $stmt->bindParam(':contact', $this->contact);
    $stmt->bindParam(':username', $this->username);
    $stmt->bindParam(':password', $this->password);
    $stmt->bindParam(':average_rating', $this->average_rating);
    $stmt->bindParam(':job_id', $this->job_id);
    $stmt->bindParam(':id', $this->id);


    //execute query
    if($stmt->execute()){
      return true;
    }

    //print error if something is wrong
    printf("Error: %s.\n", $stmt->error);

    return false;

  }

}


?>
