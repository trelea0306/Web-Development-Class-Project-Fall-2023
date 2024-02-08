<?php
Function getID($Table,$Field,$NumberDigits,$TextDigits) {
	//By Zach Ingraham, php conversion and pronouncable ID by Russell Haines
	//generates random ID, picking new IDs until one is unique
	//text digits adds a "pronouncable" prefix
	//too many attempts have been made (usually caused if range is full and unique not possibe)
	//more likely to happen prematurely if digits is small (2)
	//range is between 10^(Digits-1) and 10^Digits-1 and produces 9*10^(Digits-1) results
	//ex: Digits = 2; Range = 10 to 99; 90 Results
	//ex: Digits = 3; Range = 100 to 999; 900 Results
	$debug=0;
	$ctr=0;
	$testID = '';
	$letters='';
	do {
		for ($n=1;$n<=$NumberDigits;$n++) {
				$testID = mt_rand(0,pow(10,$NumberDigits)-1);
		}
		for ($n=1;$n<=$TextDigits;$n++) {
			if ($n % 2 == 0) {
				//pick a vowel for the even letters
				$letters .= substr("aeiou", mt_rand(0,4), 1);
			} else {
				//pick a consonant for the odd letters
				$letters .= substr("bcdfghjklmnprstvwxyz", mt_rand(0,19), 1); //no q
			}
		}
		$testID = $letters . $testID;
		try {
			$mode=getMode();
			$conn = dbConnect("ReadOnly");
			$SQL="SELECT * FROM ". $Table ." WHERE ". $Field ."='". $testID ."'";
			$result = $conn->query($SQL);
		} catch(PDOException $e) {
			if ($mode=="test") {
				echo "Error detecting duplicates: " . $e->getMessage();
			}
			die;
		}
		$numrows=$result->rowCount();
		$ctr++;
		if ($ctr > pow(10,$NumberDigits)) {
			if (mysql_num_rows($result)) {
				$numrows=0;
				$testID = -1;
			}
		}
	} while ($numrows>0);
	return $testID;
}

Function getSequentialID($Table,$Field) {#generates new ID sequentailly
	$debug=0;
	$SQL="SELECT MAX(". $Field .") AS NewID FROM ". $Table .";";
	$result = executeSQL($SQL, $debug);
	if (mysql_num_rows($result)) {
		return (mysql_result($result,0,"NewID")+1);
	} else {
		return 1;
	}
} #End Function
?>