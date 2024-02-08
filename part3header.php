

<!DOCTYPE html>
<html>
<head>

<style>


.header {
  overflow: hidden;
  background-color: #f1f1f1;
  padding: 20px 10px;
}

.header a {
  float: left;
  color: black;
  text-align: center;
  padding: 12px;
  text-decoration: none;
  font-size: 18px; 
  line-height: 25px;
  border-radius: 4px;
}

.header a.logo {
  font-size: 25px;
  font-weight: bold;
}

.header a:hover {
  background-color: #ddd;
  color: black;
}

.header a.active {
  background-color: dodgerblue;
  color: white;
}

.header-right {
  float: right;
}

@media screen and (max-width: 500px) {
  .header a {
    float: none;
    display: block;
    text-align: left;
  }
  
  .header-right {
    float: none;
  }
}
</style>
</head>
<body>

<div class="header">
  <a href="https://appstate-cis3870-worleyba.azurewebsites.net/finalprojectmenu.php" class="logo">MAIN MENU</a>
  <div class="header-right">
    <a href="bidderform1.php">Print Off Bidder Forms</a>
	<a href="enterbidderinformation.php">Enter New Bidder Information</a>
    <a href="listbidders.php">View All Winning Bidder Data</a>
    <a href="listlots.php">View All Lot Data</a>
	<a href="listallbidders.php">View All Bidders in the Auction</a>

  </div>
</div>

<div style="padding-left:20px">
</div>

</body>
</html>