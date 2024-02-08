<?php
error_reporting(0);
require "deletecss.php";
require "textcss.php";
include "part3header.php";
if (!empty($_POST)) {
	$formempty = false;
	$validform = true; //initializing this variable with true
	$BidderID = trim(htmlentities(stripslashes($_POST['BidderID'])));
	//if they POSTed, we show the confirmation
	//Here, we ask if they really want to delete
?>
	<p class="p2">WARNING!</p>
	<p class="p2">All data about Bidder <?php echo $BidderID;?> will be deleted. Are you sure?</p>
	<div class="container">
  <div class="vertical-center">
	<a class="one" href="deletebidder.php?BidderID=<?php echo $BidderID; ?>&answer=yes">Yes, I want to Delete this Bidder!</a>
	</div>
	</div>
	<div class="container">
  <div class="vertical-center">
		<form method="get" action="listallbidders.php">
	<button class="button button1">No, take me back NOW!
	<input type="hidden" name="BidderID" value="<?php echo $result['BidderID']; ?>">
	</button>
	</form>
	</div>
	</div>
<?php
} if (!empty($_GET)){ //when they GET, it means they didn't POST
	$BidderID = trim(htmlentities(stripslashes($_GET['BidderID'])));
	
	$answer = trim(htmlentities(stripslashes($_GET['answer'])));
	
	//if they said "yes", we will delete
	if ($answer=="yes") {
		require "connectionfunctionbw.php";
		$conn=databaseConnection("ReadWrite");

		$SQL = "DELETE FROM Bidder";
		$SQL .= " WHERE BidderID = :BidderID;";

		$sth = $conn->prepare($SQL);
		$sth -> bindParam(':BidderID', $BidderID, PDO::PARAM_INT);
		$sth->execute();

		?>
		
<p class="p1">Record <?php echo $BidderID;?> deleted successfully.</p>
  
<div class="container">
  <div class="vertical-center">
		<form action="listallbidders.php">
	<button class="button button1">Return
	
	</button>
	</form>
	</div>
	</div>

	
	
	
		<?php
		//include is used to drop a file in. If the file isn't found, it will WARN, but not die
		//php will treat the included file the same as any other code
		//it is loaded first, before executing any other code
		

		
		?>
		</body>
		</html>
		<?php
		
	} 
}
?>
