
<?php


$ItemIDErrorMessage = " ";
$DonorIDErrorMessage = " ";
$DescriptionErrorMessage = " ";
$RetailValueErrorMessage = " ";
$LotIDErrorMessage = " ";


if (!empty($_GET)) {
	$formempty = false; //form is not empty, so load the values from POST
	$validform = true; //initializing this variable with true
	$ItemID = trim(htmlentities(stripslashes($_GET['ItemID'])));
	if (isset(($_GET['submit']))){
	if ($_GET['submit'] == "Update") {
	$update = trim(htmlentities(stripslashes($_GET['submit']))); //Load value if user clicked update
	//echo "User clicked update, so time to check and write to database";
	$DonorID = trim(htmlentities(stripslashes($_GET['DonorID'])));
	$Description = trim(htmlentities(stripslashes($_GET['Description'])));
	$RetailValue = trim(htmlentities(stripslashes($_GET['RetailValue'])));
	$LotID = trim(htmlentities(stripslashes($_GET['LotID'])));
	
	
	

	
	if (empty($DonorID)) {
		$validform = false;
		// in html, a <p> means a new paragraph. If you want to change style on the same line, you need a <span> tag
		$DonorIDErrorMessage .= "<span style='color:Tomato;'> A value must be entered for Donor ID</span>";
	} elseif (!is_numeric($DonorID)) { //the ! means that this is saying not numeric
		$validform = false;
		$DonorIDErrorMessage .= "<span style='color:Tomato;'> A number must be entered for Donor ID</span>";
	}
	if (empty($Description)) {
		$validform = false;
		$DescriptionErrorMessage .= "<span style='color:Tomato;'> A value must be entered for Description</span>";
	}
	if (empty($RetailValue)) {
		$validform = false;
		$RetailValueErrorMessage .= "<span style='color:Tomato;'> A value must be entered for Retail Value</span>";
	} elseif (!is_numeric($RetailValue)) { //the ! means that this is saying not numeric
		$validform = false;
		$RetailValueErrorMessage .= "<span style='color:Tomato;'> A number must be entered for Retail Value</span>";
	}
	
	if (empty($ItemID)) {
		$validform = false;
		$ItemIDErrorMessage .= "<span style='color:Tomato;'> A value must be entered for Item ID</span>";
	}
	 elseif (!is_numeric($ItemID)) { //the ! means that this is saying not numeric
		$validform = false;
		$ItemIDErrorMessage .= "<span style='color:Tomato;'> A number must be entered for Item ID</span>";
	}

	
	if ($validform == true){
		$servername="cis3870-mysql.mysql.database.azure.com";
		$username= "worleyba_rw";
		$password = "7d81974efbd87308fb273ce3";

		try{
			$conn = new PDO("mysql:host=$servername;dbname=worleyba_db", $username, $password);
			
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
		} catch(PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		}
		$SQL = "UPDATE Item SET ItemID = :ItemID, DonorID = :DonorID, Description = :Description, RetailValue = :RetailValue, LotID = :LotID ";
		$SQL .= "Where ItemID = :ItemID;";
		$sth = $conn->prepare($SQL);
		//Next statement is binding the value the user enter with the parameter listed in the values clause.
		$sth -> bindParam(':ItemID', $ItemID, PDO::PARAM_INT);
			$sth -> bindParam(':DonorID', $DonorID, PDO::PARAM_STR, 75);
			$sth -> bindParam(':Description', $Description, PDO::PARAM_STR, 75);
			$sth -> bindParam(':RetailValue', $RetailValue, PDO::PARAM_STR, 200);
			$sth -> bindParam(':LotID', $LotID, PDO::PARAM_STR, 75);
			

		//the reason reason for using pdo is that the user input can be sanitized by the database and not by PHP
		//Note: w#schools doesnt include show info about parametization.
		$sth->execute();
		
include "finalprojectheader.php";
include "textcss.php";
include "deletecss.php";
?>
<p class="p3">Record Updated Succesfully!</p>
<div class="container">
  <div class="vertical-center">
  <form method="get" action="finalprojectviewtable.php">
	<button class="button button1">Return
	<input type="hidden" name="ItemID" value="<?php echo $result['ItemID']; ?>">
	</button>
	</form>
	</div>
	</div>
	<?php	

		die;
		}
	}
	}
	if (isset(($_GET['submit']))){
	$update = trim(htmlentities(stripslashes($_GET['submit']))); //Load value if user clicked update
	}
	//Get the rest of the values from the database
	$servername="cis3870-mysql.mysql.database.azure.com";
	$username= "worleyba_ro";
	$password = "8125db11904027e7d3aa6f34";

try{
	$conn = new PDO("mysql:host=$servername;dbname=worleyba_db", $username, $password);
	
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
   }catch(PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
}
//Select the columns needed from the recipe table
$SQL = "SELECT ItemID, DonorID, Description, RetailValue, LotID";
$SQL .= " FROM Item"; //we want only the recipe they clicked
$SQL .= " WHERE ItemID = :ItemID";//the colon means its a parameter (entered by user), needs to be sanitized
$sth = $conn->prepare($SQL); //No user parameters, so can just execute
$sth -> bindParam(':ItemID', $ItemID, PDO::PARAM_INT);
$sth->execute();//now, need to grab results from servername
$result = $sth->fetch(PDO::FETCH_ASSOC); 
if ($sth->rowcount() > 0) {
	
	$DonorID = $result['DonorID'];
	$Description = $result['Description'];
	$RetailValue = $result['RetailValue'];
	$LotID = $result['LotID'];
	
	
//	echo "<p>You are updating number " . $result['rid'] ."</p>";
//	echo "<p>The title is " . $result['title'] ."</p>";
$validform = false; //were putting this here so that it doesnt try to insert
} else {
		$validform = false;
		$ItemIDErrorMessage = "Invalid Record Number";
		echo $ItemIDErrorMessage;
		die;
}
} else {
	$formempty = true; //form is empty, so initialize the variables
	$validform = false;
	$ItemID = "";

}





//$validform = true;

//if the form was empty, no need to check for errors
if ($formempty==false) {

	if (empty($DonorID)) {
		$validform = false;
		// in html, a <p> means a new paragraph. If you want to change style on the same line, you need a <span> tag
		$DonorIDErrorMessage .= "<span style='color:Tomato;'> A value must be entered for Donor ID</span>";
	} elseif (!is_numeric($DonorID)) { //the ! means that this is saying not numeric
		$validform = false;
		$DonorIDErrorMessage .= "<span style='color:Tomato;'> A number must be entered for Donor ID</span>";
	}
	if (empty($Description)) {
		$validform = false;
		$DescriptionErrorMessage .= "<span style='color:Tomato;'> A value must be entered for Description</span>";
	}
	if (empty($RetailValue)) {
		$validform = false;
		$RetailValueErrorMessage .= "<span style='color:Tomato;'> A value must be entered for Retail Value</span>";
	} elseif (!is_numeric($RetailValue)) { //the ! means that this is saying not numeric
		$validform = false;
		$RetailValueErrorMessage .= "<span style='color:Tomato;'> A number must be entered for Retail Value</span>";
	}
	
	if (empty($ItemID)) {
		$validform = false;
		$ItemIDErrorMessage .= "<span style='color:Tomato;'> A value must be entered for Item ID</span>";
	}
	 elseif (!is_numeric($ItemID)) { //the ! means that this is saying not numeric
		$validform = false;
		$ItemIDErrorMessage .= "<span style='color:Tomato;'> A number must be entered for Item ID</span>";
	}
	}
if ($validform == false) {
	if($formempty == false) { //if the form was empty, we don't have any errors.
		//echo "<p>Please update with customer information that is both new and valid</p>";
	}
	
}	else{
	//echo "<p style='color:MediumSeaGreen;'>All form data was valid</p>";
	//We need a connection by the read-write user

$servername="cis3870-mysql.mysql.database.azure.com";
$username= "worleyba_rw";
$password = "7d81974efbd87308fb273ce3";

try{
	$conn = new PDO("mysql:host=$servername;dbname=worleyba_db", $username, $password);
	
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
} catch(PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
}//, LastName, Address, City, State, Zip, cat, picture
$SQL = "INSERT INTO Donor (ItemID, DonorID, Description, RetailValue, LotID) VALUES (";
$SQL .= ":ItemID, :DonorID, :Description, :RetailValue, :LotID";
$SQL .= ");"; //.= means apppend text to the variable
$sth = $conn->prepare($SQL);
//Next statement is binding the value the user enter with the parameter listed in the values clause.
$sth -> bindParam(':ItemID', $ItemID, PDO::PARAM_INT);
$sth -> bindParam(':DonorID', $DonorID, PDO::PARAM_INT);
$sth -> bindParam(':Description', $Description, PDO::PARAM_STR, 200);
$sth -> bindParam(':RetailValue', $RetailValue, PDO::PARAM_STR, 75);
$sth -> bindParam(':LotID', $LotID, PDO::PARAM_INT);
//the reason reason for using pdo is that the user input can be sanitized by the database and not by PHP
//Note: w#schools doesnt include show info about parametization.
//echo "<br />SQL statement was ". $SQL;
$sth->execute();
include "finalprojectheader.php";
include "textcss.php";
include "deletecss.php";
?>
<p class="p3">Record Updated Succesfully!</p>
<div class="container">
  <div class="vertical-center">
  <form method="get" action="finalprojectviewtable.php">
	<button class="button button1">Return
	<input type="hidden" name="DonorID" value="<?php echo $result['DonorID']; ?>">
	</button>
	</form>
	</div>
	</div>
	<?php	

		die;
		}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>
Update Item
</title>
</head>
<body>
<?php
//include is used to drop a file in. If the file isnt found, it wall warn, but not die
//php will treat the file the same as code - it is loaded first, before executing any other code
require "finalprojectheader.php";
require "formcss.php";
require "textcss.php";

?>
<p class="p1">Please Update Item Information Below</p>



<!-- method="get" means that the variable names and values are transmitted in
the URL: this means that they can be bookmarked  -->
<!-- method="post" means that the variable names and values are transmitted in 
the http header: these values won't be bookmarked -->
<form method="get" action="finalprojectupdateitem.php"> <!-- so that users can more easily fix errors, we use the same file to enter and submit -->

<div>
 <!-- so that users can more easily fix errors, we use the same file to enter and submit -->
<p><label for="ItemID">Item ID</label></p><p><?php echo $ItemID;?><input type="hidden" name="ItemID" value="<?php echo $ItemID;?>"><?php echo $ItemIDErrorMessage;?></p>
<p><label for="LotID"></label></p><p><input type="hidden" name="LotID" value="<?php echo $LotID;?>"><?php echo $LotIDErrorMessage;?></p>
<p><label for="Description">Item Description</label></p><p> <input type="text" name="Description" placeholder="Your description here.."value="<?php echo $Description;?>"><?php echo $DescriptionErrorMessage;?></p>
<p><label for="Retail Value">Item's Retail Value</label></p><p> <input type="text" name="RetailValue" placeholder="Your item's retail value here.."value="<?php echo $RetailValue;?>"><?php echo $RetailValueErrorMessage;?></p>
<p><label for="DonorID">Donor ID for Donor of Item</label></p><input type="text" name="DonorID" placeholder="Your item's Donor ID here.."value="<?php echo $DonorID;?>"><?php echo $DonorIDErrorMessage;?></p>

<p><input type="submit" name="submit" value="Update"></p>
</div>
</form>

</body>
</html>