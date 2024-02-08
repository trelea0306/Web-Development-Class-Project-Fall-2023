<?php
$servername = "cis3870-mysql.mysql.database.azure.com";
$username = "leachtj_fc";
$password = "4b543755a004f8ad1e6fa2a9";

try {
  $conn = new PDO("mysql:host=$servername;dbname=leachtj_db", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
//create a variable to store my SQL command
$SQL = " DROP TABLE customers;";

echo $SQL; //for debugging purposes

//Preparing a statement is most important when you have gotten data from a user
$stmt = $conn->prepare($SQL); //use the connection to sanitize the SQL statement 
$stmt->execute(); //The stmt is a sanitary SQL command, so execute it 
?>