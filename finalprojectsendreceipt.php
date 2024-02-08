
<?php
require "connectionfunction.php";

$conn = databaseConnection("ReadWrite");

$SQL = "SELECT DonorID, BusinessName, ContactName, ContactEmail, ContactTitle, Address, City, State, ZipCode, TaxReceipt";
$SQL .= " FROM Donor"; //we want only the recipe they clicked
$SQL .= " WHERE DonorID = :DonorID";//the colon means its a parameter (entered by user), needs to be sanitized
$sth = $conn->prepare($SQL); //No user parameters, so can just execute
$sth -> bindParam(':DonorID', $DonorID, PDO::PARAM_INT);
$sth->execute();//now, need to grab results from servername
$result = $sth->fetch(PDO::FETCH_ASSOC); 
if ($sth->rowcount() > 0) {
	
	$BusinessName = $result['BusinessName'];
	$ContactName = $result['ContactName'];
	$ContactEmail = $result['ContactEmail'];
	$ContactTitle = $result['ContactTitle'];
	$Address = $result['Address'];
	$City = $result['City'];
	$State = $result['State'];
	$ZipCode = $result['ZipCode'];
	$TaxReceipt = $result['TaxReceipt'];
	echo $BusinessName;
	echo "TEST";
}

$conn = databaseConnection("ReadWrite");
$True = true;
$DonorID = trim(htmlentities(stripslashes($_GET['DonorID'])));
$SQL = "UPDATE Donor SET DonorID = :DonorID, TaxReceipt = :TaxReceipt ";
		$SQL .= "Where DonorID = :DonorID;";
		$sth = $conn->prepare($SQL);
		//Next statement is binding the value the user enter with the parameter listed in the values clause.
		$sth -> bindParam(':DonorID', $DonorID, PDO::PARAM_INT);
		$sth -> bindParam(':TaxReceipt', $True, PDO::PARAM_BOOL);
$sth->execute();

/*$conn = databaseConnection("ReadWrite");
$SQL = "INSERT INTO Donor (DonorID, BusinessName, ContactName, ContactEmail, ContactTitle, Address, City, State, ZipCode, TaxReceipt) VALUES (";
$SQL .= ":DonorID, :BusinessName, :ContactName, :ContactEmail, :ContactTitle, :Address, :City, :State, :ZipCode, :TaxReceipt";
$SQL .= ");"; //.= means apppend text to the variable
$sth = $conn->prepare($SQL);
//Next statement is binding the value the user enter with the parameter listed in the values clause.
$sth -> bindParam(':DonorID', $DonorID, PDO::PARAM_INT);
$sth -> bindParam(':BusinessName', $BusinessName, PDO::PARAM_STR, 75);
$sth -> bindParam(':ContactName', $ContactName, PDO::PARAM_STR, 75);
$sth -> bindParam(':ContactEmail', $ContactEmail, PDO::PARAM_STR, 200);
$sth -> bindParam(':ContactTitle', $ContactTitle, PDO::PARAM_STR, 75);
$sth -> bindParam(':Address', $Address, PDO::PARAM_STR, 75);
$sth -> bindParam(':City', $City, PDO::PARAM_STR, 30);
$sth -> bindParam(':State', $State, PDO::PARAM_STR, 2);
$sth -> bindParam(':ZipCode', $ZipCode, PDO::PARAM_STR, 5);
$sth -> bindParam(':TaxReceipt', $TaxReceipt, PDO::PARAM_BOOL);
//the reason reason for using pdo is that the user input can be sanitized by the database and not by PHP
//Note: w#schools doesnt include show info about parametization.
//echo "<br />SQL statement was ". $SQL;
		
			<form method="get" action="finalprojectviewtable.php">
	<input type="hidden" name="DonorID" value="<?php echo $result['DonorID']; ?>">
	<input type="submit" value="Back To Table">
	</form>
	<form method="get" action="https://appstate-cis3870-worleyba.azurewebsites.net/scriptToPDF.php">
	<input type="hidden" name="DonorID" value="<?php echo $result['DonorID']; ?>">
	<input type="submit" value="Download PDF">
	</form>
$sth->execute(); */

header("Location: https://appstate-cis3870-worleyba.azurewebsites.net/finalprojectviewtable.php");	

		?>
