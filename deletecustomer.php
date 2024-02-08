<?php
if (!empty($_POST)) {
	$formempty = false;
	$validform = true; //initializing this variable with true
	$uid = trim(htmlentities(stripslashes($_POST['uid'])));
	//if they POSTed, we show the confirmation
	//Here, we ask if they really want to delete

	echo "Are you sure you want to delete user number " . $uid ."?";
	?>
	<a href="deletecustomer.php?uid=<?php echo $uid; ?>&answer=yes">Yes</a>
	<a href="deletecustomer.php?uid=<?php echo $uid; ?>&answer=no">No</a>

	<?php	
} elseif (!empty($_GET)){ //when they GET, it means they didn't POST
	$uid = trim(htmlentities(stripslashes($_GET['uid'])));
	$answer = trim(htmlentities(stripslashes($_GET['answer'])));
	//if they said "yes", we will delete
	if ($answer=="yes") {
		require "readwriteconn.php";

		$SQL = "DELETE FROM customers";
		$SQL .= " WHERE uid = :uid;";

		$sth = $conn->prepare($SQL);
		$sth -> bindParam(':uid', $uid, PDO::PARAM_INT);
		$sth->execute();
		?><!DOCTYPE html>
		<html>
		<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>
		Customer List
		</title>
		</head>
		<body>
		<?php
		//include is used to drop a file in. If the file isn't found, it will WARN, but not die
		//php will treat the included file the same as any other code
		//it is loaded first, before executing any other code
		echo "Record " .$uid. " deleted successfully.";
		?>
		</body>
		</html>
		<?php
		
	} else { //typical to not execute an action if they say anything but "yes"
		header("Location: mysqlphpskillcheckq3.php"); //any headers are best BEFORE any text is written (no echos)
	}
}
?>

