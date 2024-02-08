<?php
require "connectionfunction.php";
$servername="cis3870-mysql.mysql.database.azure.com";
	$username= "worleyba_fc"; //Dont use full control user!
	$password = "c787e95f7bbbb6d3d7a2e1d8";

	try{
		$conn = new PDO("mysql:host=$servername;dbname=worleyba_db", $username, $password);
		
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo "Connected succesfully";
		} catch(PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
		}

$SQL = "CREATE TABLE Donor (";
$SQL .= "DonorID 	int, "; //.= means apppend text to the variable
$SQL .= "BusinessName	varchar(75), "; //varchar is a variable length up to a limit. char() would be a fixed length (more space but faster)
$SQL .= "ContactName	varchar(75), ";
$SQL .= "ContactEmail	varchar(200), ";
$SQL .= "ContactTitle	varchar(75), ";
$SQL .= "Address	varchar(75), ";
$SQL .= "City	varchar(30), ";
$SQL .= "State	varchar(2), ";
$SQL .= "ZipCode	varchar(5), ";
$SQL .= "TaxReceipt	bool, ";
$SQL .= "    CONSTRAINT PK_Donor PRIMARY KEY (DonorID)"; //If you use a text field for the PK, use char
$SQL .= ");";

echo $SQL; //for debugging
//Preparing a statement is most important when you have gotten data from a user.
 $stmt = $conn->prepare($SQL); //use the connection to sanitize the statement
 $stmt->execute(); //The stmt is a sanitary SQL command, so execute it


 //create a second table
$SQL = "CREATE TABLE Item (";
$SQL .= "ItemID 	int, "; //.= means apppend text to the variable
$SQL .= "Description	varchar(75), "; //varchar is a variable length up to a limit. char() would be a fixed length (more space but faster)
$SQL .= "RetailValue	decimal(10,2), ";
$SQL .= "DonorID	int, ";
$SQL .= "LotID	int, ";

$SQL .= "    CONSTRAINT PK_Item PRIMARY KEY (ItemID, DonorID)"; //If you use a text field for the PK, use char
$SQL .= ");";



//Preparing a statement is most important when you have gotten data from a user.
 $stmt = $conn->prepare($SQL); //use the connection to sanitize the statement
 $stmt->execute(); //The stmt is a sanitary SQL command, so execute it
$conn = databaseConnection("ReadWrite");
 /*$servername="cis3870-mysql.mysql.database.azure.com";
$username = "worleyba_rw";
$password = "7d81974efbd87308fb273ce3";

try{
	$conn = new PDO("mysql:host=$servername;dbname=worleyba_db", $username, $password);
	
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "Connected succesfully";
} catch(PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
}*/
$SQL = "INSERT INTO Donor (DonorID, BusinessName, ContactName, ContactEmail, ContactTitle, Address, City, State, ZipCode, TaxReceipt) VALUES (";
$SQL .= ");"; //.= means apppend text to the variable
$SQL = "INSERT INTO Item (ItemID, Description, RetailValue, DonorID, LotID) VALUES (";
$SQL .= ");"; //.= means apppend text to the variable
die;
?>

