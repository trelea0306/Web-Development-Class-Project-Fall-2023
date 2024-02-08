<?php
error_reporting(0);
//because we are using a function, it won't output until we call it, so put it at the top
require "connectionfunctionbw.php";
//The user only sent us a rid, so there's nothing else
	$Nameerrormessage = "";
	$Addresserrormessage = "";
	$CellNumbererrormessage = "";
	$HomeNumbererrormessage = "";
	$Emailerrormessage = "";
	$formempty = true; 
	$validform = true; 
if (!empty($_POST)) {
	$formempty = false;
	$validform = true; //initializing this variable with true
	$BidderID = trim(htmlentities(stripslashes($_POST['BidderID'])));
	if (!empty($_POST['submit'])) { // to stop Warning, check to see if variable is empty
		$update = trim(htmlentities(stripslashes($_POST['submit']))); //Load value if user clicked update
		
	} else {
		$update = ""; //since the Post form field is empty, just set the variable to null
	}
	if ($update == "Update") {
//		echo "User clicked update, so time to check and then write to database";
		$Name = trim(htmlentities(stripslashes($_POST['Name'])));
		$Address = trim(htmlentities(stripslashes($_POST['Address'])));
		$CellNumber = trim(htmlentities(stripslashes($_POST['CellNumber'])));
		$HomeNumber = trim(htmlentities(stripslashes($_POST['HomeNumber'])));
		$Email = trim(htmlentities(stripslashes($_POST['Email'])));
		if (empty($Name)) {
			$validform = false;
			$Nameerrormessage .= "<span style='color:Tomato;'>A value must be entered for Name.</span>";
		}
		if (empty($Address)) {
			$validform = false;
			$Addresserrormessage .= "<span style='color:Tomato;'>A value must be entered for Address.</span>";
		}
		if (empty($CellNumber)) {
			$validform = false;
			$CellNumbererrormessage .= "<span style='color:Tomato;'>A value must be entered for Cellphone Number.</span>";
		} elseif (preg_match("/^[^0-9]*$/",$CellNumber)){ 
			$validform = false;
			$CellNumbererrormessage .= "<p style='color:Tomato;'>Cellphone Number must use only numbers (0-9).</p>";
		} elseif (strlen($CellNumber)!=10){ 
			$validform = false;
			$CellNumbererrormessage .= "<p style='color:Tomato;'>Cellphone Number must be 10 characters long.</p>";
		}
		if (empty($HomeNumber)) {
			$validform = false;
			$HomeNumbererrormessage .= "<span style='color:Tomato;'>A value must be entered for Home Number.</span>";
		} elseif (preg_match("/^[^0-9]*$/",$HomeNumber)){ 
			$validform = false;
			$HomeNumbererrormessage .= "<p style='color:Tomato;'>Home Number must use only numbers (0-9).</p>";
		} elseif (strlen($HomeNumber)!=10){ 
			$validform = false;
			$HomeNumbererrormessage .= "<p style='color:Tomato;'>Home Number must be 10 characters long.</p>";
		}
		if (empty($Email)) {
			$validform = false;
			$Emailerrormessage .= "<span style='color:Tomato;'>A value must be entered for Email Address</span>";
		} elseif (!filter_var($Email,FILTER_VALIDATE_EMAIL)){
			$validform = false;
			$Emailerrormessage .= "<span style='color:Tomato;'>The Email Address is not in the proper format</span>";
		}	
		if ($validform == true) {
			//echo "<p>All form data was valid.</p>";
			//Now, time to update database
			//We need a connection by the read-write user
			$conn = databaseConnection("ReadWrite");
			//We are just doing rid (required as PK) and title to see an easy example
			$SQL = "UPDATE Bidder SET Name = :Name, Address = :Address, CellNumber = :CellNumber, HomeNumber = :HomeNumber, Email = :Email ";
			$SQL .= " WHERE BidderID = :BidderID;";
			//the WHOLE reason for using PDO is that the user input can be sanitized by the database, not by PHP
			// in fromt of every field value, put a colon - that means it's a "parameter", entered by the user
			//NOTE: w3schools doesn't seem to show this, you would have to look at more professional sites
			$sth = $conn->prepare($SQL); // the statement needs to be pre-processed by the database server
			// Next statement is "binding" the value the user entered with the parameter listed in the VALUES clause
			$sth -> bindParam(':BidderID',$BidderID, PDO::PARAM_INT); //this is for numeric values (would NOT have single quotes)
			$sth -> bindParam(':Name',$Name, PDO::PARAM_STR,75); //this is used for non-numeric values (would have quotes)
			$sth -> bindParam(':Address',$Address, PDO::PARAM_STR,75);
			$sth -> bindParam(':CellNumber',$CellNumber, PDO::PARAM_STR,10);
			$sth -> bindParam(':HomeNumber',$HomeNumber, PDO::PARAM_STR,10);
			$sth -> bindParam(':Email',$Email, PDO::PARAM_STR,200);
			//Once everything is bound, ready to execute

			include "part3header.php";
			include "textcss.php";
			include "deletecss.php";
			$sth->execute();
?>
<p class="p3">Record Updated Succesfully!</p>
<div class="container">
  <div class="vertical-center">
  <form method="get" action="listallbidders.php">
	<button class="button button1">Return
	<input type="hidden" name="BidderID" value="<?php echo $result['BidderID']; ?>">
	</button>
	</form>
	</div>
	</div>
	<?php	

			die; //this should be the last line of the "all form data valid" section
		}
	}
	$conn = databaseConnection("ReadOnly");
	//Get the rest of the values from the database
//SELECT the columns I need from the recipe table
	$SQL = "SELECT BidderID, Name, Address, CellNumber, HomeNumber, Email";
	$SQL .= " FROM Bidder"; //we want only the recipe they clicked
	$SQL .= " WHERE BidderID = :BidderID"; //the colon means rid is a parameter - entered by user, so needs to be sanitized
	$sth = $conn->prepare($SQL); //need to prepare
	$sth -> bindParam(':BidderID', $BidderID, PDO::PARAM_INT);
	//No user-entered parameters, so can just execute
	$sth->execute();
	//now, need to grab the results from the server
	$result = $sth->fetch(PDO::FETCH_ASSOC); //this pulls the first row of the results into PHP as an array (FETCH_ASSOC)
	if ($sth->rowcount() > 0) {
		//return the results
		$Name = $result['Name'];
		$Address = $result['Address'];
		$CellNumber = $result['CellNumber'];
		$HomeNumber = $result['HomeNumber'];
		$Email = $result['Email'];
//		echo "<p>You are updating recipe number " . $result['rid'] . "</p>";
//		echo "<p>The title is " . $result['title'] . "</p>";
		$validform = false; //we're putting this here so that it doesn't try to INSERT
	} else {
		//there was an error, no results were returned
		$validform = false;
		$BidderIDerrorMessage = "Invalid Record number";
		echo $BidderIDerrormessage;
		die;
	}
} else {
	$formempty = true; //form is empty, so initialize the variables
	$validform = false;
	$BidderID = "";
	}

//$LotIDerrorMessage="";
//$WinningBiderrormessage="";
//$WinningBiddererrormessage="";

//$validform = true;

//if the form was empty, no need to check for errors
if ($formempty==false) {

		if (empty($Name)) {
			$validform = false;
			$Nameerrormessage .= "<span style='color:Tomato;'>A value must be entered for Name.</span>";
		}
		if (empty($Address)) {
			$validform = false;
			$Addresserrormessage .= "<span style='color:Tomato;'>A value must be entered for Address.</span>";
		}
		if (empty($CellNumber)) {
			$validform = false;
			$CellNumbererrormessage .= "<span style='color:Tomato;'>A value must be entered for Cellphone Number.</span>";
		} elseif (preg_match("/^[^0-9]*$/",$CellNumber)){ 
			$validform = false;
			$CellNumbererrormessage .= "<span style='color:Tomato;'>Cellphone Number must use only numbers (0-9).</span>";
		} elseif (strlen($CellNumber)!=10){ 
			$validform = false;
			$CellNumbererrormessage .= "<span style='color:Tomato;'>Cellphone Number must be 10 characters long.</span>";
		}
		if (empty($HomeNumber)) {
			$validform = false;
			$HomeNumbererrormessage .= "<span style='color:Tomato;'>A value must be entered for Home Number.</span>";
		} elseif (preg_match("/^[^0-9]*$/",$HomeNumber)){ 
			$validform = false;
			$HomeNumbererrormessage .= "<span style='color:Tomato;'>Home Number must use only numbers (0-9).</span>";
		} elseif (strlen($HomeNumber)!=10){ 
			$validform = false;
			$HomeNumbererrormessage .= "<span style='color:Tomato;'>Home Number must be 10 characters long.</span>";
		}
		if (empty($Email)) {
			$validform = false;
			$Emailerrormessage .= "<span style='color:Tomato;'>A value must be entered for Email Address</span>";
		} elseif (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
			$validform = false;
			$Emailerrormessage .= "<span style='color:Tomato;'>The Email Address is not in the proper format</span>";
		}
} //end of form empty check
if ($validform == false) {
	if($formempty == false) { //if the form was empty, we don't have any errors.
		//echo "<p style='color:Tomato;'>Please fix the highlighted errors:</p>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>
Update Bidder Information
</title>
</head>
<body>
<?php
//include is used to drop a file in. If the file isnt found, it wall warn, but not die
//php will treat the file the same as code - it is loaded first, before executing any other code
require "part3header.php";
require "formcss.php";
require "textcss.php";

?>
<p class="p1">Please Update Bidder Information Below</p>
<form method="post" action="bidderinfoupdate.php"> <!-- so that users can more easily fix errors, we use the same file to enter and submit -->
<p class="p5"><label for="BidderID">Bidder Number: </label><?php echo $BidderID;?><input type="hidden" name="BidderID" value="<?php echo $BidderID;?>"></p>
<p class="p5"><label for="BidderID">Full Name: </label><input type="text" name="Name" value="<?php echo $Name;?>"><?php echo $Nameerrormessage;?></p>
<p class="p5"><label for="BidderID">Address: </label><input type="text" name="Address" value="<?php echo $Address;?>"><?php echo $Addresserrormessage;?></p>
<p class="p5"><label for="BidderID">Cell Number: </label><input type="text" name="CellNumber" value="<?php echo $CellNumber;?>"><?php echo $CellNumbererrormessage;?></p>
<p class="p5"><label for="BidderID">Home Number: </label><input type="text" name="HomeNumber" value="<?php echo $HomeNumber;?>"><?php echo $HomeNumbererrormessage;?></p>
<p class="p5"><label for="BidderID">Email: </label><input type="text" name="Email" value="<?php echo $Email;?>"><?php echo $Emailerrormessage;?></p>
<p><input type="submit" name="submit" value="Update"></p>

</form>

</body>
</html>