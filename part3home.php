<?php
require_once('protect.php');
require "part3menuheader.php";
require "deletecss.php";
require "textcss.php";
require "formcss.php";
?>
<p class="p1">What would you like to do, Admin?</p>
<!-- method="get" means that the variable names and values are transmitted in
the URL: this means that they can be bookmarked  -->
<!-- method="post" means that the variable names and values are transmitted in 
the http header: these values won't be bookmarked -->
<style>
div {
  padding-right: 30px;
}
 </style>
<form method="get" action="bidderform1.php"> <!-- so that users can more easily fix errors, we use the same file to enter and submit -->
<div>
<p><input type="submit" name="submit2" value="I would like to print off bidder forms"></p>
</div>
</form>
</body>
<form method="post" action="enterbidderinformation.php"> <!-- so that users can more easily fix errors, we use the same file to enter and submit -->
<div>
<p><input type="submit" name="submit" value="I would like to enter new bidder information"></p>
</div>                                      
</form>       
<form method="get" action="listbidders.php"> <!-- so that users can more easily fix errors, we use the same file to enter and submit -->
<div>
<p><input type="submit" name="submit" value="I would like to view bidder data"></p>
</div>
</form>    
<form method="get" action="listlots.php"> <!-- so that users can more easily fix errors, we use the same file to enter and submit -->
<div>
<p><input type="submit" name="submit" value="I would like view lot data"></p>
</div>
</form>
<form method="get" action="listallbidders.php"> <!-- so that users can more easily fix errors, we use the same file to enter and submit -->
<div>
<p><input type="submit" name="submit" value="I would like view all bidders in the auction"></p>
</div>
</form>
</body>