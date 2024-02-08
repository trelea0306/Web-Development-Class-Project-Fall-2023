<!DOCTYPE html>
<html>
<head>
<style>
#donor {
  font-family: Arial, Helvetica, sans-serif;
  font-size: 12px;
  border-collapse: collapse;
  width: 100%;
  text-align: center;
  
}

#donor td, #donor th {
  border: 1px solid #ddd;
  padding: 8px;
}

#donor tr:nth-child(even){background-color: #f2f2f2;}

#donor tr:hover {background-color: #ddd;}

#donor th {
  padding: 12px;
  
  text-align: left;
  background-color: #999999;
  color: white;
}
</style>
</head>
<head>
<style>
#tax {
  font-family: Arial, Helvetica, sans-serif;
  font-size: 12px;
  border-collapse: collapse;
  width: 100%;
  text-align: center;
}

#tax td, #tax th {
  border: 1px solid #ddd;
  padding: 8px;
}

#tax tr:nth-child(even){background-color: #f2f2f2;}

#tax tr:hover {background-color: #ddd;}

#tax th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #C00000;
  color: white;
}
</style>
</head>
<head>
<style>
#item {
  font-family: Arial, Helvetica, sans-serif;
  font-size: 12px;
  border-collapse: collapse;
  width: 100%;
  text-align: center;
}

#item td, #item th {
  border: 1px solid #ddd;
  padding: 8px;
}

#item tr:nth-child(even){background-color: #f2f2f2;}

#item tr:hover {background-color: #ddd;}

#item th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #999999;
  color: white;
}

</style>
</head>
<style>
.button {
  background-color: #4CAF50; 
  border: none;
  color: white;
  padding: 8px 19px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 12px;
  border-radius: 12px;
  cursor: pointer;
}

.button:hover {
  background-color: #45a049;
}

.button1 {
  background-color: #f44336; 
  border: none;
  color: white;
  padding: 8px 19px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 12px;
  border-radius: 12px;
  cursor: pointer;
}

.button1:hover {
  background-color: red;
}
.button2 {
  background-color: #E2FFFE; 
  border: none;
  color: black;
  padding: 8px 19px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 12px;
  border-radius: 12px; 
  cursor: pointer;
}
.button2:hover {
  background-color: #C2E9E8;
}
</style>
<body>

<?php
error_reporting(0);

//include is used to drop a file in. If the file isnt found, it wall warn, but not die
//php will treat the file the same as code - it is loaded first, before executing any other code
//
include "finalprojectheader.php";
require "textcss.php";
include "formcss.php";

?>
<div>
<p class="p1">List Of Donors</p>
<table border="1">
<table id="donor">
<tr><th>DonorID</th><th>Business Name</th><th>Contact Name</th><th>Contact Email</th><th>Contact Title</th><th>Address</th><th>City</th><th>State</th><th>Zip Code</th><th>Tax Receipt</th><th>Update</th><th>Delete</th><th>Mark Receipt as Sent</th><th>Generate Receipt</th><th>Generate Letter</th></tr>
<?php
//list of recipes from database goes here
//This time, the READ ONLY user is the one! (SELECT)

//Require also includes a file, but if the file is not found it gives a fatal error and dies.

require "readonlyconn.php";

$SQL = "SELECT DonorID, BusinessName, ContactName, ContactEmail, ContactTitle, Address, City, State, ZipCode, TaxReceipt";
$SQL .= " FROM Donor";
$sth = $conn->prepare($SQL); //No user parameters, so can just execute
$sth->execute();//now, need to grab results from servername
$result = $sth->fetch(PDO::FETCH_ASSOC); //next we need to loop through the result and show each row.

	
//Going to DO until we run out of records to show
do {
	//output the results, row by row
if ($result['TaxReceipt'] == false){
	$TaxMessage = "Not Sent";
} else {
	$TaxMessage = "Sent";
}
	echo "<tr>";
		echo"<td>";
	echo $result['DonorID'];
	echo "</td>";
	echo"<td>";
	echo $result['BusinessName'];
	echo "</td>";
	echo"<td>";
	echo $result['ContactName'];
	echo "</td>";
	echo"<td>";
	echo $result['ContactEmail'];
	echo "</td>";
	echo"<td>";
	echo $result['ContactTitle'];
	echo "</td>";
	echo"<td>";
	echo $result['Address'];
	echo "</td>";
	echo"<td>";
	echo $result['City'];
	echo "</td>";
	echo"<td>";
	echo $result['State'];
	echo "</td>";
	echo"<td>";
	echo $result['ZipCode'];
	echo "</td>";
	echo"<td>";
	echo $TaxMessage;
	echo "</td>";
	//adding a cell with a button for updating a record
	echo"<td>";
	?>
	<form method="get" action="finalprojectupdatedonor.php">
	<button class="button button">Update
	<input type="hidden" name="DonorID" value="<?php echo $result['DonorID']; ?>">
	</button>
	</form>
	<?php
	echo "</td>";
	echo"<td>";
	?>
	<form method="get" action="finalprojectdeletedonor.php">
	<button class="button button1">Delete
	<input type="hidden" name="DonorID" value="<?php echo $result['DonorID']; ?>">
	</button>
	</form>
	<?php
	echo "</td>"; 
	echo"<td>";
	?>
	<form method="get" action="finalprojectsendreceipt.php">
	<button class="button button2">Mark Receipt as Sent
	<input type="hidden" name="DonorID" value="<?php echo $result['DonorID']; ?>">
	</button>
	</form>
	<?php
	echo "</td>";
	echo"<td>";
	?>
	<form method="get" action="scriptToPDF.php">
	<button class="button button2">Generate Receipt
	<input type="hidden" name="DonorID" value="<?php echo $result['DonorID']; ?>">
	</button>
	</form>
	<?php
	echo "</td>";
	echo"<td>";
	?>
	<form method="get" action="scriptToPDF2.php">
	<button class="button button2">Generate Letter
	<input type="hidden" name="DonorID" value="<?php echo $result['DonorID']; ?>">
	</button>
	</form>
	<?php
	echo "</td>";
	/*echo "<td>";
		?>
		<!-- Script for onsubmit should jump to the function, and not submit if return false -->
		<form method="get" action="finalprojectdeletedonor.php" onsubmit="return clickDelete<?php echo $result['DonorID']; ?>();">
		<input type="hidden" name="DonorID" value="<?php echo $result['DonorID']; ?>">
		<input type="submit" value="Delete">
		</form>
		<!-- The span tag is for inline elements (no line break) -->
		<!-- The id for a tag needs to be unique -->
		<span id="DeleteText<?php echo $result['DonorID']; ?>"></span>
		<!-- The script tag is for javascript. Between the tags, you use Javascript commands -->
		<script>
		// use functions when code should run as a response to an event
		function clickDelete<?php echo $result['DonorID']; ?>() { //this function would run when they click the delete button
			//Change the text next to the button
			//document.getElementByID will connect to the tag of that ID
			//innerHTML is the reference to the html code inside that tag
			document.getElementById("DeleteText<?php echo $result['DonorID']; ?>").innerHTML = "Are you sure?";
			//return false will abort submitting the form
			return false;
		}
		</script>
		<?php
		echo "<td>";*/
	echo "</tr>";
} while ($result = $sth->fetch(PDO::FETCH_ASSOC));

?>

<table border="1">
<table id="item">
<p class="p1">List Of Donated Items</p>
<tr><th>DonorID</th><th>ItemID</th><th>Description</th><th>RetailValue</th><th>Update</th><th>Delete</th></tr>
<?php

$SQL = "SELECT DonorID, ItemID, LotID, Description, RetailValue";
$SQL .= " FROM Item";
$sth = $conn->prepare($SQL); //No user parameters, so can just execute
$sth->execute();//now, need to grab results from servername
$result = $sth->fetch(PDO::FETCH_ASSOC); //next we need to loop through the result and show each row.
//Going to DO until we run out of records to show
do {
	//output the results, row by row
if ($result['LotID'] == 0){
	$LotMessage = "Not Assigned";
} else {
	$LotMessage = $result['LotID'];;
}
	
	//output the results, row by row

	echo "<tr>";
	echo"<td>";
	echo $result['DonorID'];
	echo "</td>";
	echo"<td>";
	echo $result['ItemID'];
	echo "</td>";
	echo"<td>";
	echo $result['Description'];
	echo "</td>";
	echo"<td>";
	echo $result['RetailValue'];
	echo "</td>";
	
	echo"<td>";
	?>
	<form method="get" action="finalprojectupdateitem.php">
	<button class="button button">Update
	<input type="hidden" name="ItemID" value="<?php echo $result['ItemID']; ?>">
	</button>
	</form>
	<?php
	echo "</td>";
	echo"<td>";
	?>
	<form method="get" action="finalprojectdeleteitem.php">
	<button class="button button1">Delete
	<input type="hidden" name="ItemID" value="<?php echo $result['ItemID']; ?>">
	</button>
	</form>
	<?php
	echo "</td>"; 
	
	
	echo "</tr>";
} while ($result = $sth->fetch(PDO::FETCH_ASSOC));

//list of recipes from database goes here
//This time, the READ ONLY user is the one! (SELECT)
require "readonlyconn.php";

$SQL = "SELECT DonorID, BusinessName";
$SQL .= " FROM Donor";
$SQL .= " WHERE TaxReceipt = 0";
$sth = $conn->prepare($SQL); //No user parameters, so can just execute
$sth->execute();//now, need to grab results from servername
$result = $sth->fetch(PDO::FETCH_ASSOC); //next we need to loop through the result and show each row.
$lmao = 0;//Require also includes a file, but if the file is not found it gives a fatal error and dies.
do {
	//output the results, row by row

	$lmao += $result['DonorID'];
	
	
} while ($result = $sth->fetch(PDO::FETCH_ASSOC));

if ($lmao != 0){
	
	?>

<table border="1">
<table id="tax">
<p class="p2">List Of Donors who Have Not Received a Tax Receipt</p>
<tr><th>DonorID</th><th>Business Name</th><th>Contact Name</th><th>Contact Email</th><th>Contact Title</th><th>Address</th><th>City</th><th>State</th><th>Zip Code</th><th>Tax Receipt</th><th>Update</th><th>Delete</th><th>Mark Receipt as Sent</th><th>Generate Receipt</th><th>Generate Letter</th></tr>
<?php
	
require "readonlyconn.php";

$SQL = "SELECT DonorID, BusinessName, ContactName, ContactEmail, ContactTitle, Address, City, State, ZipCode, TaxReceipt";
$SQL .= " FROM Donor";
$SQL .= " WHERE TaxReceipt = 0";
$sth = $conn->prepare($SQL); //No user parameters, so can just execute
$sth->execute();//now, need to grab results from servername
$result = $sth->fetch(PDO::FETCH_ASSOC); //next we need to loop through the result and show each row.



//Going to DO until we run out of records to show
do {
	//output the results, row by row
if ($result['TaxReceipt'] == false){
	$TaxMessage = "Not Sent";
} else {
	$TaxMessage = "Sent";
}
	echo "<tr>";
	echo"<td>";
	echo $result['DonorID'];
	echo "</td>";
	echo"<td>";
	echo $result['BusinessName'];
	echo "</td>";
	echo"<td>";
	echo $result['ContactName'];
	echo "</td>";
	echo"<td>";
	echo $result['ContactEmail'];
	echo "</td>";
	echo"<td>";
	echo $result['ContactTitle'];
	echo "</td>";
	echo"<td>";
	echo $result['Address'];
	echo "</td>";
	echo"<td>";
	echo $result['City'];
	echo "</td>";
	echo"<td>";
	echo $result['State'];
	echo "</td>";
	echo"<td>";
	echo $result['ZipCode'];
	echo "</td>";
	echo"<td>";
	echo $TaxMessage;
	echo "</td>";
	//adding a cell with a button for updating a record
	echo"<td>";
	?>
	<form method="get" action="finalprojectupdatedonor.php">
	<button class="button button">Update
	<input type="hidden" name="DonorID" value="<?php echo $result['DonorID']; ?>">
	</button>
	</form>
	<?php
	echo "</td>";
	echo"<td>";
	?>
	<form method="get" action="finalprojectdeletedonor.php">
	<button class="button button1">Delete
	<input type="hidden" name="DonorID" value="<?php echo $result['DonorID']; ?>">
	</button>
	</form>
	<?php
	echo "</td>"; 
	echo"<td>";
	?>
	<form method="get" action="finalprojectsendreceipt.php">
	<button class="button button2">Mark Receipt as Sent
	<input type="hidden" name="DonorID" value="<?php echo $result['DonorID']; ?>">
	</button>
	</form>
	<?php
	echo "</td>";
	echo"<td>";
	?>
	<form method="get" action="scriptToPDF.php">
	<button class="button button2">Generate Receipt
	<input type="hidden" name="DonorID" value="<?php echo $result['DonorID']; ?>">
	</button>
	</form>
	<?php
	echo "</td>";
	echo"<td>";
	?>
	<form method="get" action="scriptToPDF2.php">
	<button class="button button2">Generate Letter
	<input type="hidden" name="DonorID" value="<?php echo $result['DonorID']; ?>">
	</button>
	</form>
	<?php
	echo "</td>";
	/*echo "<td>";
		?>
		<!-- Script for onsubmit should jump to the function, and not submit if return false -->
		<form method="get" action="finalprojectdeletedonor.php" onsubmit="return clickDelete<?php echo $result['DonorID']; ?>();">
		<input type="hidden" name="DonorID" value="<?php echo $result['DonorID']; ?>">
		<input type="submit" value="Delete">
		</form>
		<!-- The span tag is for inline elements (no line break) -->
		<!-- The id for a tag needs to be unique -->
		<span id="DeleteText<?php echo $result['DonorID']; ?>"></span>
		<!-- The script tag is for javascript. Between the tags, you use Javascript commands -->
		<script>
		// use functions when code should run as a response to an event
		function clickDelete<?php echo $result['DonorID']; ?>() { //this function would run when they click the delete button
			//Change the text next to the button
			//document.getElementByID will connect to the tag of that ID
			//innerHTML is the reference to the html code inside that tag
			document.getElementById("DeleteText<?php echo $result['DonorID']; ?>").innerHTML = "Are you sure?";
			//return false will abort submitting the form
			return false;
		}
		</script>
		<?php
		echo "<td>";*/
	echo "</tr>";
} while ($result = $sth->fetch(PDO::FETCH_ASSOC));
}
?>
</table>
</body>
</html>