<?php

session_start();

include "config.php";

// if (isset($_COOKIE["user_email"])) {
//     echo $_COOKIE["user_email"];
// } elseif (isset($_SESSION["user_email"])) {
//     echo $_SESSION["user_email"];
// }

$sql = "SELECT id, fname, lname FROM user_d";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["id"]. " - Name: " . $row["fname"]. " " . $row["lname"]. "<br>";
  }
} else {
  echo "0 results"; 
}


$mysqli->close();



?>