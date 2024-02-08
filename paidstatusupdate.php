<?php
error_reporting(0);
//because we are using a function, it won't output until we call it, so put it at the top
require "connectionfunctionbw.php";
//The user only sent us a rid, so there's nothing else
	$Paiderrormessage = "";
	$formempty = true; 
	$validform = true; 
if (!empty($_POST)) {
	$formempty = false;
	$validform = true; //initializing this variable with true
	$BidderID = trim(htmlentities(stripslashes($_POST['BidderID'])));
	$Paid = trim(htmlentities(stripslashes($_POST['Paid'])));
	if (!empty($_POST['submit'])) { // to stop Warning, check to see if variable is empty
		$update = trim(htmlentities(stripslashes($_POST['submit']))); //Load value if user clicked update
		
	} else {
		$update = ""; //since the Post form field is empty, just set the variable to null
	}
	if ($update == "Update") {
//		echo "User clicked update, so time to check and then write to database";
		$Paid = trim(htmlentities(stripslashes($_POST['Paid'])));
		
		if ($validform == true) {
			//echo "<p>All form data was valid.</p>";
			//Now, time to update database
			//We need a connection by the read-write user
			$conn = databaseConnection("ReadWrite");
			//We are just doing rid (required as PK) and title to see an easy example
			$SQL = "UPDATE Bidder SET Paid = :Paid ";
			$SQL .= " WHERE BidderID = :BidderID;";
			$sth = $conn->prepare($SQL);
			$sth -> bindParam(':BidderID', $BidderID, PDO::PARAM_INT);
			$sth -> bindParam(':Paid', $Paid, PDO::PARAM_BOOL);
			//Once everything is bound, ready to execute

			include "part3header.php";
			include "textcss.php";
			include "deletecss.php";
			$sth->execute();
?>
<p class="p3">Record Updated Succesfully!</p>
<div class="container">
  <div class="vertical-center">
  <form method="get" action="listbidders.php">
	<button class="button button1">Return
	<input type="hidden" name="BidderID" value="<?php echo $result['BidderID']; ?>">
	</button>
	</form>
	</div>
	</div>
	<?php	

		die;
 //this should be the last line of the "all form data valid" section
		}
	}
	$conn = databaseConnection("ReadOnly");
	//Get the rest of the values from the database
//SELECT the columns I need from the recipe table
	$SQL = "SELECT BidderID, Name, Paid";
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
		$Paid = $result['Paid'];
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
Update Paid Status
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
<p class="p1">Please Update Paid Status Below</p>
<form method="post" action="paidstatusupdate.php"> <!-- so that users can more easily fix errors, we use the same file to enter and submit -->

<div>
<p class="p5"><label for="BidderID">Bidder Number: </label><?php echo $BidderID;?><input type="hidden" name="BidderID" value="<?php echo $BidderID;?>"></p>
<p class="p5"><label for="BidderID">Bidder Name: </label><?php echo $Name;?><input type="hidden" name="Name" value="<?php echo $Name;?>"></p>
<p class="p4">Has the Winner Paid the Total Amount Owed?:</p>
<input type="radio" name="Paid" value="0"> No <br>
<input type="radio" name="Paid" value="1"> Yes <br>
<p><input type="submit" name="submit" value="Update"></p>
</div>
</form>

</body>
</html>