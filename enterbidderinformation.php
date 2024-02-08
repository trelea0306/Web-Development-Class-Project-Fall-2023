<?php
error_reporting(0);
if(!empty($_GET)) {
	$formempty = false; //form is not empty, so load values from GET
	$validform = true; //initializing this variable with true 
	$BidderID = trim(htmlentities(stripslashes($_GET['BidderID'])));
	$Name = trim(htmlentities(stripslashes($_GET['Name'])));
	$Address = trim(htmlentities(stripslashes($_GET['Address'])));
	$CellNumber = trim(htmlentities(stripslashes($_GET['CellNumber'])));
	$HomeNumber = trim(htmlentities(stripslashes($_GET['HomeNumber'])));
	$Email = trim(htmlentities(stripslashes($_GET['Email'])));
	
}else {
	$formempty = true; //form is empty, so initialize the variables
	$validform = false;
	$BidderID = "";
	$Name = "";
	$Address = "";
	$CellNumber = "";
	$HomeNumber = "";
	$Email = "";
}



$BidderIDerrormessage =" ";
$Nameerrormessage =" ";
$Addresserrormessage =" ";
$CellNumbererrormessage =" ";
$HomeNumbererrormessage =" ";
$Emailerrormessage =" ";

//$validform = true;

//if form was empty, no need to check for errors
if ($formempty != true) {

	if (empty($BidderID)) {
		$validform = false;
		// in html a <p> means a new paragraph. If you want to change style on the same line, you need a <span>
		$BidderIDerrormessage .= "<span style='color:Tomato;'>A value must be entered for Bidder ID.</span>"; //&nbsp is a special html character that stands for "non-breaking space"
	} elseif (!is_numeric($BidderID)) { 
		$validform = false;
		$BidderIDerrormessage .= "<span style='color:Tomato;'>A number must be entered for User ID.</span>";
	} elseif (strlen($BidderID) != 3) {
		$validform = false;
		$BidderIDerrormessage .= "<span style='color:Tomato;'>Bidder ID must be 3 characters long.</span>";
	}
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
		$CellNumbererrormessage .= "<span style='color:Tomato;'>Cellphone Number must use only numbers (0-9).</p>";
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
	} elseif (!filter_var($Email,FILTER_VALIDATE_EMAIL)){
		$validform = false;
		$Emailerrormessage .= "<span style='color:Tomato;'>The Email Address is not in the proper format</span>";
	}
}//end of form check 
if ($validform == false) {
	if($formempty == false) {
	}
} else {
	require "connectionfunctionbw.php";
	$conn=databaseConnection("ReadWrite");
		//We are just doing rid (required as PK) and title to see an easy example
	$SQL = "UPDATE Bidder SET Name = :Name, Address = :Address, CellNumber = :CellNumber, HomeNumber = :HomeNumber, Email = :Email ";
	$SQL .= " WHERE BidderID = :BidderID;";
	$sth = $conn->prepare($SQL); //the statement needs to be pre-processed by the database server
	//Next step is "binding" the value the user entered with the parameter listed in the VALUES clause
	$sth -> bindParam(':BidderID',$BidderID, PDO::PARAM_INT); //this is for numeric values (would NOT have single quotes)
	$sth -> bindParam(':Name',$Name, PDO::PARAM_STR,75); //this is used for non-numeric values (would have quotes)
	$sth -> bindParam(':Address',$Address, PDO::PARAM_STR,75);
	$sth -> bindParam(':CellNumber',$CellNumber, PDO::PARAM_STR,10);
	$sth -> bindParam(':HomeNumber',$HomeNumber, PDO::PARAM_STR,10);
	$sth -> bindParam(':Email',$Email, PDO::PARAM_STR,200);
		//Once everything is bound, ready to execute
	$sth->execute(); //this actually executes
include "part3header.php";
include "textcss.php";
include "deletecss.php";
?>
<p class="p3">Bidder Information Entered Succesfully!</p>
	<?php	
	die; //this should be the last line of the "all form data valid" section
	}

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>
Enter Bidder Information
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
<p class="p1">Please Enter Bidder Information Below</p>

<!-- method = "get" means that the variable names and values are transmitted in the URL: 
this means that they can be bookmarked -->
<!-- method = "post" means that the variable names and values are transmitted in the HTTP header: 
these values won't be bookmarked -->
<div>
<form method="get" action="enterbidderinformation.php"> <!-- so that users can more easily fix errors, we use the same file to enter and submit -->

<p><label for="BidderID">Bidder Number</label></p><p>
    <input type="text" id="BidderID" name="BidderID" placeholder="Your bidder number here.." value="<?php echo $BidderID;?>"><?php echo $BidderIDerrormessage;?>
</p>
    <p><label for="Name">Full Name</label></p><p>
    <input type="text" id="Name" name="Name" placeholder="Your full name here.." value="<?php echo $Name;?>"><?php echo $Nameerrormessage;?>
</p>	
	<p><label for="Address">Address</label></p><p>
    <input type="text" id="Address" name="Address" placeholder="Your address here.." value="<?php echo $Address;?>"><?php echo $Addresserrormessage;?>
</p>	
	<p><label for="CellNumber">Cell Number</label></p><p>
    <input type="text" id="CellNumber" name="CellNumber" placeholder="Your cell number here.." value="<?php echo $CellNumber;?>"><?php echo $CellNumbererrormessage;?>
</p>	
	<p><label for="HomeNumber">Home Number</label></p><p>
    <input type="text" id="HomeNumber" name="HomeNumber" placeholder="Your home number here.." value="<?php echo $HomeNumber;?>"><?php echo $HomeNumbererrormessage;?>
</p>	
	<p><label for="Email">Email</label></p><p>
    <input type="text" id="Email" name="Email" placeholder="Your email here.." value="<?php echo $Email;?>"><?php echo $Emailerrormessage;?>
</p>
<p><input type="submit" name="submit" value="Update"></p>

</div>

</form>

</body>
</html>