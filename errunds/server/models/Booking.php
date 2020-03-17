<?php

class Booking{
  //db stuff
  private $conn;

  //booking properties
  public $id;
  public $creation_date;
  public $booking_date;
  public $start_time;
  public $end_time;
  public $status;
  public $rating;
  public $comments;

  public $customer_id;
  public $worker_id;
  public $worker_firstname;
  public $worker_lastname;

  //constructor
  public function __construct($db){
    $this->conn = $db;
  }

  //get bookings
  public function read_customer_bookings(){
    $query = 'SELECT booking.id, booking.creation_date, booking.booking_date, 
                booking.start_time, booking.end_time, booking.status, booking.rating, 
                booking.comments, booking.customer_id, booking.worker_id, 
                worker.id as worker_id, worker.first_name as worker_firstname, 
                worker.last_name as worker_lastname 
                FROM booking 
                JOIN worker ON booking.worker_id = worker.id 
                WHERE booking.customer_id = ?';


    //prepare statement
    $stmt = $this->conn->prepare($query);

    //bind id
    $stmt->bindParam(1, $this->customer_id);

    //execute $query
    $stmt->execute();

    return $stmt;

  }

  // get single booking
  public function read_single_booking(){
    //create query
    $query = 'SELECT booking.id, booking.creation_date, booking.booking_date, 
                booking.start_time, booking.end_time, booking.status, booking.rating, 
                booking.comments, booking.customer_id, booking.worker_id, 
                worker.id as worker_id, worker.first_name as worker_firstname, 
                worker.last_name as worker_lastname 
                FROM booking 
                JOIN worker ON booking.worker_id = worker.id 
                WHERE booking.id = ?';


    //prepare statement
    $stmt = $this->conn->prepare($query);

    //bind id
    $stmt->bindParam(1, $this->id);

    //execute $query
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //set properties
    $this->creation_date = $row['creation_date'];
    $this->booking_date = $row['booking_date'];
    $this->start_time = $row['start_time'];
    $this->end_time = $row['end_time'];
    $this->status = $row['status'];
    $this->rating = $row['rating'];
    $this->comments = $row['comments'];

    $this->worker_id = $row['worker_id'];
    $this->customer_id = $row['customer_id'];
    $this->worker_firstname = $row['worker_firstname'];
    $this->worker_lastname = $row['worker_lastname'];

  }

  //create booking
  public function create_booking(){
    //create query
    $query = 'INSERT INTO booking (creation_date, booking_date, start_time, end_time,  
                status, rating, comments, worker_id, customer_id) 
                VALUES (:creation_date, :booking_date, :start_time, :end_time, 
                :status, :rating, :comments, :worker_id, :customer_id)';


    //prepare statement
    $stmt = $this->conn->prepare($query);

    //clean data
    $this->booking_date = htmlspecialchars(strip_tags($this->booking_date));
    $this->start_time = htmlspecialchars(strip_tags($this->start_time));
    $this->end_time = htmlspecialchars(strip_tags($this->end_time));


    //bind data
    $stmt->bindParam(':creation_date', $this->creation_date);
    $stmt->bindParam(':booking_date', $this->booking_date);
    $stmt->bindParam(':start_time', $this->start_time);
    $stmt->bindParam(':end_time', $this->end_time);
    $stmt->bindParam(':status', $this->status);
    $stmt->bindParam(':rating', $this->rating);
    $stmt->bindParam(':comments', $this->comments);
    $stmt->bindParam(':worker_id', $this->worker_id);
    $stmt->bindParam(':customer_id', $this->customer_id);
    

    //execute query
    if($stmt->execute()){
      return true;
    }

    //print error if something is wrong
    printf("Error: %s.\n", $stmt->error);

    return false;

  }

  //update booking of customer
  public function update_booking(){
    //create query
    $query = 'UPDATE booking
              SET
                booking_date = :booking_date,
                start_time = :start_time,
                end_time = :end_time, 
                status = :status,
                rating = :rating,
                comments = :comments,
                worker_id = :worker_id
              WHERE
                booking.id = :id';

    //prepare statement
    $stmt = $this->conn->prepare($query);

    //clean data
    $this->booking_date = htmlspecialchars(strip_tags($this->booking_date));
    $this->start_time = htmlspecialchars(strip_tags($this->start_time));
    $this->end_time = htmlspecialchars(strip_tags($this->end_time));
    $this->comments = htmlspecialchars(strip_tags($this->comments));


    //bind data
    $stmt->bindParam(':booking_date', $this->booking_date);
    $stmt->bindParam(':start_time', $this->start_time);
    $stmt->bindParam(':end_time', $this->end_time);
    $stmt->bindParam(':status', $this->status);
    $stmt->bindParam(':rating', $this->rating);
    $stmt->bindParam(':comments', $this->comments);
    $stmt->bindParam(':worker_id', $this->worker_id);
    $stmt->bindParam(':id', $this->id);


    //execute query
    if($stmt->execute()){
      return true;
    }

    //print error if something is wrong
    printf("Error: %s.\n", $stmt->error);

    return false;

  }

  // delete booking
  public function delete_booking(){
    //create query
    $query = 'DELETE FROM booking WHERE id = :id';

    //prepare statement
    $stmt = $this->conn->prepare($query);

    //bind data
    $stmt->bindParam(':id', $this->id);

    //execute query
    if($stmt->execute()){
      return true;
    }

    //print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;

  }

}


?>
