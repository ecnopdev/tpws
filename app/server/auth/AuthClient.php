<?php

ini_set("display_errors", 1);

require_once("jwt.php");


class AuthClient {

    private $iss = "localhost";
    //private $iat = time();
    // private $nbf = $iat + 10;
    // private $exp = $iat + 30;
    // private $aud = "myusers";
    private $user_array;
    private $user_data;
    private $token;
    private $returned_array;
    private $payload_info;

    private $secret_key = '5f2b5cdbe5194f10b3241568fe4e2b24';

    //constructor
    public function __construct($user_array, $token){
        $this->token = $token;
        $this->user_array = $user_array;
        $this->user_data = array(
            "id" => $user_array['id'],
            "first_name" => $user_array['first_name'],
            "last_name" => $user_array['last_name']
        );
        $this->payload_info = array(
            // "iss" => $this->iss,
            // "iat" => $this->iat,
            // "nbf" => $this->nbf,
            // "exp" => $this->exp,
            // "aud" => $this->aud,
            "data" => $this->user_data
    
        );
    }

    // login authentication
    public function login_auth() { 

        $this->token = JWT::encode($this->payload_info, $this->secret_key);

        $this->returned_array = array(
            "status" => 1,
            "user_array" => $this->user_array,
            "token" => $this->token,
            "message" => "User logged in successfully"
        );

        return $this->returned_array;

    }


    // succeeding request authentication
    public function request_auth() {

        if(!is_null($this->token)){
            try{
                $payload = JWT::decode($this->token, $this->secret_key, array('HS256'));
                $this->returned_array = $payload;
            }catch(Exception $e){
                $this->returned_array = array('error' => $e->getMessage());
            }
        }else{
            $this->returned_array = array('error' => 'You are not logged in with a valid token.');
        }

        return $this->returned_array;
    }


}

?>

