<?php

class Customer{
  //db stuff
  private $conn;

  //customer properties
  public $id;
  public $first_name;
  public $last_name;
  public $email;
  public $address;
  public $contact;
  public $username;
  public $password;


  //constructor
  public function __construct($db){
    $this->conn = $db;
  }


  // check if customer username exists in the database
  public function login_customer(){
  
    //create query
    $query = 'SELECT customer.id, customer.first_name, customer.last_name, customer.email, customer.address, 
    customer.contact, customer.username, customer.password 
                FROM customer 
                WHERE customer.username = ?
                AND customer.password = ?';

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
    $this->username = $row['username'];
    $this->password = $row['password'];

  }

  // get single customer
  public function read_single_customer(){
    //create query
    $query = 'SELECT customer.id, customer.first_name, customer.last_name, customer.email, customer.address, 
                customer.contact, customer.username, customer.password 
                FROM customer 
                WHERE customer.id = ?';

    //prepare statement
    $stmt = $this->conn->prepare($query);

    //bind id
    $stmt->bindParam(1, $this->id);

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

  }


  //update customer
  public function update_customer(){
    //create query
    $query = 'UPDATE customer
              SET
              first_name = :first_name,
              last_name = :last_name,
              email = :email, 
              address = :address,
              contact = :contact,
              username = :username,
              password = :password 
              WHERE
                customer.id = :id';

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
    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':first_name', $this->first_name);
    $stmt->bindParam(':last_name', $this->last_name);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':address', $this->address);
    $stmt->bindParam(':contact', $this->contact);
    $stmt->bindParam(':username', $this->username);
    $stmt->bindParam(':password', $this->password);


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
