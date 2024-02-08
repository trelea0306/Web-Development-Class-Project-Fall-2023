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
List of Lot Winning Bidders
</title>
</head>
<body>

<?php
//include is used to drop a file in. If the file isn't found, it will WARN, but not die
//php will treat the included file the same as any other code
//it is loaded first, before executing any other code
include "part3header.php";
require "textcss.php";
include "formcss.php";
?>
<table border="1">
<table id = "donor">

<tr><th>Bidder Number</th><th>Bidder Name</th><th>Address</th><th>Cellphone Number</th><th>Home Number</th><th>Email</th><th>Total Amount Owed</th><th>Has the Amount Been Paid?</th><th>Bidder Has Paid</th><th>Bidder Has NOT Paid</th></tr>
<?php
//list of recipes from database goes here
//This time, the READ ONLY user is the one! (SELECT)
//Require also includes a file, but if the file is not found it gives a fatal error and dies
require "connectionfunctionbw.php";
$conn=databaseConnection("ReadWrite");
//SELECT the columns I need from the recipe table
	$SQL = "SELECT Bidder.BidderID , Bidder.Name , Bidder.Address, Bidder.CellNumber, Bidder.HomeNumber, Bidder.Email, SUM(Lot.WinningBid) AS 'Total Amount Owed', Coalesce(Bidder.Paid,0) AS Paid";
	$SQL .= " FROM Bidder, Lot";
	$SQL .= " WHERE Bidder.BidderID = Lot.WinningBidder";
	$SQL .= " GROUP BY Bidder.BidderID";
	$SQL .= " ORDER BY Bidder.BidderID";
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
		echo $result['BidderID'];
		echo "</td>"; //end cell
		echo "<td>"; //creates a cell for title using left alignment (default)
		echo $result['Name'];
		echo "</td>"; //end cell
		echo "<td>"; //creates a cell for title using left alignment (default)
		echo $result['Address'];
		echo "</td>"; //end cell
		echo "<td>"; //creates a cell for title using left alignment (default)
		echo $result['CellNumber'];
		echo "</td>"; //end cell
		echo "<td>"; //creates a cell for title using left alignment (default)
		echo $result['HomeNumber'];
		echo "</td>"; //end cell
		echo "<td>"; //creates a cell for title using left alignment (default)
		echo $result['Email'];
		echo "</td>"; //end cell
		echo "<td>"; //creates a cell for title using left alignment (default)
		echo $result['Total Amount Owed'];
		echo "</td>"; //end cell
		echo "<td>"; //creates a cell for title using left alignment (default)
		echo $arr[$result['Paid']];
		echo "</td>"; //end cell
		//adding a cell with a button for UPDATEing a record
		echo "<td>";
		?>
		<form method="post" action="paidstatustrue.php">
		<button class ="button button"> Mark Paid as Yes 
		<input type="hidden" name="BidderID" value="<?php echo $result['BidderID']; ?>">
		</button>
		</form>
		<?php
		echo "</td>";
		echo "<td>";
		?>
		<form method="post" action="paidstatusfalse.php">
		<button class ="button button1"> Mark Paid as No
		<input type="hidden" name="BidderID" value="<?php echo $result['BidderID']; ?>">
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