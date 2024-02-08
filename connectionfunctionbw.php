<?php
function databaseConnection($connType) {
	$servername="cis3870-mysql.mysql.database.azure.com";
	if ($connType =="ReadWrite") {
		$username= "worleyba_rw";
		$password = "7d81974efbd87308fb273ce3";
    } else if($connType =="ReadOnly") {
		$username= "worleyba_ro";
		$password = "8125db11904027e7d3aa6f34";	
	} else if($connType =="FullControl") {
		$username= "worleyba_fc";
		$password = "c787e95f7bbbb6d3d7a2e1d8";	
	} else {
		echo "<p>Invalid Connection type.</p>";
	}
	try{
		$conn = new PDO("mysql:host=$servername;dbname=worleyba_db", $username, $password);
		
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//	echo "Connected succesfully";
	} catch(PDOException $e) {
		echo "<p>Connection failed: " . $e->getMessage() ."</p>";
	}
	return $conn;
}//end of databaseConnection function
?>