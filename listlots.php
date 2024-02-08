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
</head>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>
Lot Portal
</title>
</head>
<body>

<?php
//include is used to drop a file in. If the file isn't found, it will WARN, but not die
//php will treat the included file the same as any other code
//it is loaded first, before executing any other code
include "part3header.php";
?>
<table border="1">
<table id ="donor">
<tr><th>Lot Number</th><th>Lot Description</th><th>Update Winners</th><th>Current Highest Bidder</th><th>Has Lot Been Delivered?</th><th>Lot Has Been Delivered</th><th>Lot Has NOT Been Delivered</th></tr>
<?php
//list of recipes from database goes here
//This time, the READ ONLY user is the one! (SELECT)

//Require also includes a file, but if the file is not found it gives a fatal error and dies
require "connectionfunctionbw.php";
$conn=databaseConnection("ReadWrite");
//SELECT the columns I need from the recipe table
	$SQL = "SELECT Lot.LotID, Lot.Description, Lot.WinningBidder, Coalesce(Lot.Delivered,0) AS Delivered";
	$SQL .= " FROM Lot";
	$sth = $conn->prepare($SQL); //need to prepare
	//No user-entered parameters, so can just execute
	$sth->execute();
	//now, need to grab the results from the server
	$result = $sth->fetch(PDO::FETCH_ASSOC); //this pulls the first row of the results into PHP as an array (FETCH_ASSOC)
	//next, we need to loop through the result and show each row
	//going to DO until we run out of records to show
	$arr = array(1 => 'Yes', 0 => 'No');
	do {
		//output the results, row by row
		echo "<tr>"; //start the row
		echo "<td align='right'>"; //creates a cell for rid using right alignment (number) - don't forget to switch to single quotes
		echo $result['LotID'];
		echo "</td>"; //end cell
		echo "<td>"; //creates a cell for title using left alignment (default)
		//link around the recipe title
		echo $result['Description'];
		echo "</td>"; //end cell
		//adding a cell with a button for UPDATEing a record
		echo "<td>";
		?>
		<form method="post" action="winningbidupdate.php">
		<input type="hidden" name="LotID" value="<?php echo $result['LotID']; ?>">
		<button class ="button button2"> Update Winning Bid
		</button>
		</form>
		<?php
		echo "</td>";
		echo "<td>";
		echo $result ['WinningBidder'];
		echo "</td>";
		echo "<td>";
		echo $arr[$result ['Delivered']];
		echo "</td>";
		echo "<td>";
		?>
		<form method="post" action="deliverystatustrue.php">
		<input type="hidden" name="LotID" value="<?php echo $result['LotID']; ?>">
		<button class ="button button"> Mark Lot as Delivered
		</button>
		</form>
		<?php
		echo "</td>";
		echo "<td>";
		?>
		<form method="post" action="deliverystatusfalse.php">
		<input type="hidden" name="LotID" value="<?php echo $result['LotID']; ?>">
		<button class ="button button1"> Mark Lot as Not Delivered
		</button>
		</form>
		<?php
		echo "</td>";
		echo "</tr>"; //end row	
	} while ($result = $sth->fetch(PDO::FETCH_ASSOC)); //at the end of each loop, it pulls in the next row

?>
</table>
</body>
</html>