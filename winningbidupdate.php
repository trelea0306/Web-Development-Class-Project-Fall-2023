<?php
error_reporting(0);
//because we are using a function, it won't output until we call it, so put it at the top
require "connectionfunctionbw.php";
//The user only sent us a rid, so there's nothing else
	$WinningBiderrormessage = "";
	$formempty = true; 
	$validform = true; 
	$WinningBiddererrormessage = "";
if (!empty($_POST)) {
	$formempty = false;
	$validform = true; //initializing this variable with true
	$LotID = trim(htmlentities(stripslashes($_POST['LotID'])));
	if (!empty($_POST['submit'])) { // to stop Warning, check to see if variable is empty
		$update = trim(htmlentities(stripslashes($_POST['submit']))); //Load value if user clicked update
		
	} else {
		$update = ""; //since the Post form field is empty, just set the variable to null
	}
	if ($update == "Update") {
//		echo "User clicked update, so time to check and then write to database";
		$WinningBid = trim(htmlentities(stripslashes($_POST['WinningBid'])));
		$WinningBidder = trim(htmlentities(stripslashes($_POST['WinningBidder'])));
		if (empty($WinningBid)) {
			$validform = false;
			$WinningBiderrormessage .= "<span style='color:Tomato;'>A value must be entered for Winning Bid</span>";
		} elseif (!is_numeric($WinningBid)) { //the ! means that this is saying not numeric
			$validform = false;
			$WinningBiderrormessage .= "<span style='color:Tomato;'> A number must be entered for Winning Bid</span>";
		}	
		if (empty($WinningBidder)) {
			$validform = false;
			$WinningBiddererrormessage .= "<span style='color:Tomato;'>A value must be entered for Winning Bidder Number</span>";
		} elseif (!is_numeric($WinningBidder)) { //the ! means that this is saying not numeric
			$validform = false;
			$WinningBiddererrormessage .= "<span style='color:Tomato;'> A number must be entered for Winning Bidder Number</span>";
		} elseif (strlen($WinningBidder)!=3) { //the ! means that this is saying not numeric
			$validform = false;
			$WinningBiddererrormessage .= "<span style='color:Tomato;'> The Winning Bidder Number must only be three characters long </span>";
		}	
		if ($validform == true) {
			//echo "<p>All form data was valid.</p>";
			//Now, time to update database
			//We need a connection by the read-write user
			$conn = databaseConnection("ReadWrite");
			//We are just doing rid (required as PK) and title to see an easy example
			$SQL = "UPDATE Lot SET WinningBid = :WinningBid, WinningBidder = :WinningBidder ";
			$SQL .= " WHERE LotID = :LotID;";
			//the WHOLE reason for using PDO is that the user input can be sanitized by the database, not by PHP
			// in fromt of every field value, put a colon - that means it's a "parameter", entered by the user
			//NOTE: w3schools doesn't seem to show this, you would have to look at more professional sites
			$sth = $conn->prepare($SQL); // the statement needs to be pre-processed by the database server
			// Next statement is "binding" the value the user entered with the parameter listed in the VALUES clause
			$sth -> bindParam(':LotID', $LotID, PDO::PARAM_INT); //this is used for numeric values (would NOT have single quotes)
			//Next statement is for text, using the max value that is allowed in the database field
			$sth -> bindParam(':WinningBid', $WinningBid, PDO::PARAM_STR);
			$sth -> bindParam(':WinningBidder', $WinningBidder, PDO::PARAM_INT);
			//Once everything is bound, ready to execute

			include "part3header.php";
			include "textcss.php";
			include "deletecss.php";
			$sth->execute();
?>
<p class="p3">Record Updated Succesfully!</p>
<div class="container">
  <div class="vertical-center">
  <form method="get" action="listlots.php">
	<button class="button button1">Return
	<input type="hidden" name="LotID" value="<?php echo $result['LotID']; ?>">
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
	$SQL = "SELECT LotID, Description, WinningBid, WinningBidder";
	$SQL .= " FROM Lot"; //we want only the recipe they clicked
	$SQL .= " WHERE LotID = :LotID"; //the colon means rid is a parameter - entered by user, so needs to be sanitized
	$sth = $conn->prepare($SQL); //need to prepare
	$sth -> bindParam(':LotID', $LotID, PDO::PARAM_INT);
	//No user-entered parameters, so can just execute
	$sth->execute();
	//now, need to grab the results from the server
	$result = $sth->fetch(PDO::FETCH_ASSOC); //this pulls the first row of the results into PHP as an array (FETCH_ASSOC)
	if ($sth->rowcount() > 0) {
		//return the results
		$Description = $result['Description'];
		$WinningBid = $result['WinningBid'];
		$WinningBidder = $result['WinningBidder'];
//		echo "<p>You are updating recipe number " . $result['rid'] . "</p>";
//		echo "<p>The title is " . $result['title'] . "</p>";
		$validform = false; //we're putting this here so that it doesn't try to INSERT
	} else {
		//there was an error, no results were returned
		$validform = false;
		$LotIDerrorMessage = "Invalid Record number";
		echo $LotIDerrormessage;
		die;
	}
} else {
	$formempty = true; //form is empty, so initialize the variables
	$validform = false;
	$LotID = "";
	}

//$LotIDerrorMessage="";
//$WinningBiderrormessage="";
//$WinningBiddererrormessage="";

//$validform = true;

//if the form was empty, no need to check for errors
if ($formempty==false) {

		if (empty($WinningBid)) {
			$validform = false;
			$WinningBiderrormessage .= "<span style='color:Tomato;'>A value must be entered for Winning Bid</span>";
		} elseif (!is_numeric($WinningBid)) { //the ! means that this is saying not numeric
			$validform = false;
			$WinningBiderrormessage .= "<span style='color:Tomato;'> A number must be entered for Winning Bid</span>";
		}	
		if (empty($WinningBidder)) {
			$validform = false;
			$WinningBiddererrormessage .= "<span style='color:Tomato;'>A value must be entered for Winning Bidder Number</span>";
		} elseif (!is_numeric($WinningBidder)) { //the ! means that this is saying not numeric
			$validform = false;
			$WinningBiderrormessage .= "<span style='color:Tomato;'> A number must be entered for Winning Bidder Number</span>";
		} elseif (strlen($WinningBidder)!=3) { //the ! means that this is saying not numeric
			$validform = false;
			$WinningBiderrormessage .= "<span style='color:Tomato;'> The Winning Bidder Number must only be three characters long </span>";
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
Update Winning Bid
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
<p class="p1">Please Update Winning Bid Information Below</p>
<form method="post" action="winningbidupdate.php"> <!-- so that users can more easily fix errors, we use the same file to enter and submit -->
<p class="p5"><label for="BidderID">Lot Number: </label><?php echo $LotID;?><input type="hidden" name="LotID" value="<?php echo $LotID;?>"></p>
<p class="p5"><label for="BidderID">Description: </label><?php echo $Description;?><input type="hidden" name="Description" value="<?php echo $Description;?>"></p>
<p class="p5"><label for="BidderID">Winning Bid Amount: </label><input type="text" name="WinningBid" value="<?php echo $WinningBid;?>"><?php echo $WinningBiderrormessage;?></p>
<p class="p5"><label for="BidderID">Winning Bidder Number: </label><input type="text" name="WinningBidder" value="<?php echo $WinningBidder;?>"><?php echo $WinningBiddererrormessage;?></p>
<p><input type="submit" name="submit" value="Update"></p>

</form>

</body>
</html>