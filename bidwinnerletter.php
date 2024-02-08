<?php
//because we are using a function, it won't output until we call it, so put it at the top
require "connectionfunctionbw.php";
//The user only sent us a rid, so there's nothing else
	$formempty = true; 
	$validform = true; 
if (!empty($_POST)) {
	$formempty = false;
	$validform = true; //initializing this variable with true
	$LotID = trim(htmlentities(stripslashes($_POST['LotID'])));
	if (!empty($_POST['submit'])) { // to stop Warning, check to see if variable is empty
		$update = trim(htmlentities(stripslashes($_POST['submit']))); //Load value if user clicked update
		
	} else {
		$update = ""; //since the Post form field is empty, just set the variable to null
	}
	$conn = databaseConnection("ReadOnly");
	//Get the rest of the values from the database
//SELECT the columns I need from the recipe table
	$SQL = "SELECT LotID,";
	$SQL .= " FROM Lot"; //we want only the recipe they clicked
	$SQL .= " WHERE LotID = :LotID"; //the colon means rid is a parameter - entered by user, so needs to be sanitized
	$sth = $conn->prepare($SQL); //need to prepare
	$sth -> bindParam(':LotID', $LotID, PDO::PARAM_INT);
	//No user-entered parameters, so can just execute
	$sth->execute();
	//now, need to grab the results from the server
	$result = $sth->fetch(PDO::FETCH_ASSOC); //this pulls the first row of the results into PHP as an array (FETCH_ASSOC)
	$LotID = "";
}

?>

<!-- method="get" means that the variable names and values are transmitted in
the URL: this means that they can be bookmarked  -->
<!-- method="post" means that the variable names and values are transmitted in 
the http header: these values won't be bookmarked -->
<form method="post" action="bidwinnerletter.php"> <!-- so that users can more easily fix errors, we use the same file to enter and submit -->
<p>Lot Number: <?php echo $LotID;?><input type="hidden" name="LotID" value="<?php echo $LotID;?>"></p>

</form>

</body>
</html>