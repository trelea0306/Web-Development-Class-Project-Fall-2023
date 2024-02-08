<?php
require "connectionfunctionbw.php";
$conn=databaseConnection("FullControl");
//create a variable to store my SQL command
$SQL = "CREATE TABLE bidder (";
$SQL .= "BidderID int, "; //.= means append text to the variable 
$SQL .= "Name	varchar(75), "; //varchar is a variable length up to the limit. char() would be fixed length (more space, but faster)
$SQL .= "Address	varchar(75), ";
$SQL .= "CellNumber	varchar(10), ";
$SQL .= "HomeNumber	varchar(10), ";
$SQL .= "Email	varchar(200), ";
$SQL .= "Paid	bool, ";
$SQL .= "CONSTRAINT PK_bidder PRIMARY KEY (BidderID)"; //If you use a test field for the PK, use char
$SQL .= ");";

echo $SQL; //for debugging purposes

//Preparing a statement is most important when you have gotten data from a user
$stmt = $conn->prepare($SQL); //use the connection to sanitize the SQL statement 
$stmt->execute(); //The stmt is a sanitary SQL command, so execute it 
$conn=databaseConnection("ReadWrite");
$SQL = "INSERT INTO bidder (BidderID, Name, Address, CellNumber, HomeNumber, Email, Paid) VALUES (";
$SQL .= ");"; //.= means apppend text to the variable
die;
?>