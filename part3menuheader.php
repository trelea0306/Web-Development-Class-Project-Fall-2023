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
  
}

.header a.logo {
  font-size: 25px;
  font-weight: bold;
  cursor: default;
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
  <a class="logo">BID AND LOT ADMIN HOME</a>
  <div class="header-right">
    <a href="https://appstate-cis3870-worleyba.azurewebsites.net/finalprojectmenu.php">Back to Main Menu</a>
  </div>
</div>

<div style="padding-left:20px">
</div>

</body>
</html>