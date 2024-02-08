<?php
require "connectionfunctionbw.php";

$conn = databaseConnection("ReadWrite");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['LotID'])) {
    $LotID = trim(htmlentities(stripslashes($_POST['LotID'])));
    $SQL = "UPDATE Lot SET Delivered = 0 WHERE LotID = :LotID";
    $sth = $conn->prepare($SQL);
    $sth->bindParam(':LotID', $LotID, PDO::PARAM_INT);
    $sth->execute();
}

header("Location: https://appstate-cis3870-leachtj.azurewebsites.net/listlots.php");
?>