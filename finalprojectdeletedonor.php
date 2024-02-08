<?php
error_reporting(0);
require "deletecss.php";
require "textcss.php";
include "finalprojectheader.php";
if (!empty($_POST)) {
	$formempty = false;
	$validform = true; //initializing this variable with true
	$DonorID = trim(htmlentities(stripslashes($_POST['DonorID'])));
	//if they POSTed, we show the confirmation
	//Here, we ask if they really want to delete

	echo "WARNING All data about donor " . $DonorID ." will be INCLUDING donated items will deleted. Are you sure?";
	?>
	<a href="finalprojectdeletedonor.php?DonorID=<?php echo $DonorID; ?>&answer=yes"></a>
	<a href="finalprojectdeletedonor.php?DonorID=<?php echo $DonorID; ?>&answer=no">No</a>

	<?php	
} if (!empty($_GET)){ //when they GET, it means they didn't POST
	$DonorID = trim(htmlentities(stripslashes($_GET['DonorID'])));
	
	$answer = trim(htmlentities(stripslashes($_GET['answer'])));
	if ($answer != "yes"){
	?>
	<p class="p2">WARNING!</p>
	<p class="p2">All data about Donor <?php echo $DonorID;?> INCLUDING donated items will be deleted. Are you sure?</p>

	
	
	
<div class="container">
  <div class="vertical-center">
	<a class="one" href="finalprojectdeletedonor.php?DonorID=<?php echo $DonorID; ?>&answer=yes">Yes, I want to Delete this Donor!</a>
	</div>
	</div>

	<?php
	}	
	//if they said "yes", we will delete
	if ($answer=="yes") {
		require "readwriteconn.php";

		$SQL = "DELETE FROM Donor";
		$SQL .= " WHERE DonorID = :DonorID;";

		$sth = $conn->prepare($SQL);
		$sth -> bindParam(':DonorID', $DonorID, PDO::PARAM_INT);
		$sth->execute();
		//Now, delete the ingredients
		$SQL = "DELETE FROM Item";
		$SQL .= " WHERE DonorID = :DonorID;";

		$sth = $conn->prepare($SQL);
		$sth -> bindParam(':DonorID', $DonorID, PDO::PARAM_INT);
		$sth->execute();
		?>
		
<p class="p1">Record <?php echo $DonorID;?> deleted successfully.</p>
  
<div class="container">
  <div class="vertical-center">
		<form action="finalprojectviewtable.php">
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
		
	} else { //typical to not execute an action if they say anything but "yes"
		?>
		<div class="container">
  <div class="vertical-center">
		<form method="get" action="finalprojectviewtable.php">
	<button class="button button1">No, take me back NOW!
	<input type="hidden" name="DonorID" value="<?php echo $result['DonorID']; ?>">
	</button>
	</form>
	</div>
	</div>
	<?php
	}
}
?>
