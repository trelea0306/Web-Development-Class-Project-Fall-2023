<?php
require "connectionfunctionbw.php";

$conn = databaseConnection("ReadWrite");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['BidderID'])) {
    $BidderID = trim(htmlentities(stripslashes($_POST['BidderID'])));
    $SQL = "UPDATE Bidder SET Paid = 1 WHERE BidderID = :BidderID";
    $sth = $conn->prepare($SQL);
    $sth->bindParam(':BidderID', $BidderID, PDO::PARAM_INT);
    $sth->execute();
}

header("Location: https://appstate-cis3870-leachtj.azurewebsites.net/listbidders.php");
?>