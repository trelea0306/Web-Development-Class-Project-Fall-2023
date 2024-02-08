
<!DOCTYPE html>
<html lang="en">

<!--@media print means when you hit print button-->
<!--table means to do this for all <table> tags-->
<!--classes have to start with a . -->
<style>
@media print {
  table {page-break-after: always;}
  .pagebreaker {page-break-after: always;}
}
</style>

<!--This is where we will make the outlines prettier-->
<style>
.formbox {
	width: 500px; 
	height: 130px;
  font-family: "Times New Roman", Times, serif;
  font-size: 18px;
  color: black;
  background-color: white;
  float: left;
  vertical-align: top;
  border-width: 2px;
  border-color: black;
  border-style: solid;
  padding-top: 0px;
  padding-left: 0px;
	
}
</style>
<style>
.biddernumber {
	font-family: "Times New Roman", Times, serif;
  font-size: 36px;
  text-align: center;
  color: MediumSeaGreen;
  background-color: white;
  
 }
 </style>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php 
include "part3header.php";
?>
<p class="pagebreaker">There will be a page break after this. Do not print the first page. Hit control + P to print. </p>
<?php
require "connectionfunctionbw.php";
	$conn = databaseConnection("ReadWrite");
	/*for($i=0; $i < 50; $i++) { // a loop of 1000 times 
		$newid = random_int(100, 999); //usually start with a high number to make users feel more secure 
		// the highest number should be the max allowed by the database 
//		echo "<p>New id =". $newid ."</p>";
		$SQL = "INSERT INTO Bidder (BidderID"; 
		$SQL .= ") VALUES(";
		$SQL .=":BidderID";
		$SQL.=");";
		$sth = $conn->prepare($SQL);
		$sth -> bindParam(':BidderID',$newid, PDO::PARAM_INT);
		$sth->execute(); //this actually executes
	} */
	$conn = databaseConnection("ReadOnly");
		$SQL = "SELECT BidderID";
		$SQL .= " FROM Bidder";
		$SQL .= " WHERE Name IS null";
		$SQL .= " Order By BidderID";
		$sth = $conn->prepare($SQL);
		$sth->execute();
		$result = $sth->fetch(PDO::FETCH_ASSOC); 
		do {
			//output the results, row by row
			?>
			<h1>
<p class="biddernumber">Bidder Number:<?php echo $result['BidderID']; ?> </p>
</h1>
<table>
<tr><td class="formbox">Name</td></tr>
<tr><td class="formbox">Address</th></tr>
<tr><td class="formbox">Cell Number</th></tr>
<tr><td class="formbox">Home Number</th></tr>
<tr><td class="formbox">Email Address</th></tr>
</table> <?
		} while ($result = $sth->fetch(PDO::FETCH_ASSOC));
?>

</body>


</html>