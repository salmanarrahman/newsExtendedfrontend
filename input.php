<?php

$mysqli = new mysqli("localhost", "root", "", "newsextended");
 
// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
 
// Escape user inputs for security
$category = $mysqli->real_escape_string($_REQUEST['addData']);
 
     // Attempt insert query execution
     $sql = "INSERT INTO category (category) VALUES ('$category')";

     
if($mysqli->query($sql) === true){
    echo "Records inserted successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
}
 
// Close connection
$mysqli->close();



?>

<!doctype html>
<html lang="en">
  <head>
  </head>
  <body>
window.location.replace("http://www.w3schools.com");
</body>
</html>