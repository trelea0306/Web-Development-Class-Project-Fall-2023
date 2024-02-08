

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
  <a href="#default" class="logo">CIS PROJECT</a>
  <div class="header-right">
    <a href="finalprojectviewtable.php">View Tables</a>
    <a href="finalprojectenter.php">Enter New Donor Information</a>
    <a href="finalprojectitem.php">Enter Donated Items</a>

  </div>
</div>

<div style="padding-left:20px">
</div>

</body>
</html>