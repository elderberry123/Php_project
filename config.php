<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'vai');
define('DB_PASSWORD', 'pass');
define('DB_NAME', 'user_information');


/* Attempt to connect to MySQL database */
$mysqli= new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection 
if ($mysqli->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


  // $sql_i = "CREATE TABLE user_d(
  //     id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  //     email VARCHAR(30) NOT NULL,
  //     fname VARCHAR(30) NOT NULL,
  //     lname VARCHAR(30) NOT NULL,
  //     pass VARCHAR(30) NOT NULL,
  //     numb INT(11) NOT NULL,
  //     cpass  VARCHAR(30) NOT NULL,
  //     city  VARCHAR(30) NOT NULL,
  //     gender  VARCHAR(30) NOT NULL,
  //     departments VARCHAR(30) NOT NULL,
  //     dob DATE,
  //     filee VARCHAR(70),
  //     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  //     )";
      
  //     if ($mysqli->query(
  //       $sql_i) === TRUE) {
  //       echo "";
  //     } 



?>