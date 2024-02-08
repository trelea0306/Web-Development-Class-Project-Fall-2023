
<?php
require "menuheader.php";
require "deletecss.php";
require "textcss.php";
require "formcss.php";
?>
<p class="p1">What would you like to do?</p>
<!-- method="get" means that the variable names and values are transmitted in
the URL: this means that they can be bookmarked  -->
<!-- method="post" means that the variable names and values are transmitted in 
the http header: these values won't be bookmarked -->
<style>
div {
  padding-right: 30px;
}
 </style>
<form method="get" action="finalprojectviewtable.php"> <!-- so that users can more easily fix errors, we use the same file to enter and submit -->
<div>
<p><input type="submit" name="submit2" value="I would like to Solicit and Gather Donations"></p>
</div>
</form>
</body>
<form method="get" action="finalprojectviewtable.php"> <!-- so that users can more easily fix errors, we use the same file to enter and submit -->
<div>
<p><input type="submit" name="submit" value="I would like to Organize Donations"></p>
</div>
</form>
<form method="get" action="finalprojectviewtable.php"> <!-- so that users can more easily fix errors, we use the same file to enter and submit -->
<div>
<p><input type="submit" name="submit" value="I would like to Record Bid Information and Contact Winners"></p>
</div>
</form>
</body>



