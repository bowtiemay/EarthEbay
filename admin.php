<html>
<head><title>EarthEbay!</title>
<link href="x10.css" rel="stylesheet" type="text/css" />
</head>

</html>

<?php

  session_start();

  require 'config.php';
  require_once 'navbar.php';

  $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);


  $sth3 = $dbh->prepare("SELECT * FROM customer WHERE `username` = :username");
  $sth3->bindValue(':username', $_SESSION['customerID']);
  $sth3->execute();
  $isAdmin = $sth3->fetch();

  if ($isAdmin['isAdmin'] == "false")  {
    header("Location: home.php");
    exit();
  }

  if (!isset($_SESSION['customerID'])) {
    header("Location: signin.php");
    exit();
  }

  navbar();

  echo "<div class = \"background\"><br><br>";

  echo "<div class=\"signin\">";

  echo "<h1>Edit the Inventory:</h1>";

  echo "<h3>Add an item to the inventory!</h3>";

  echo "<form action = \"addToInventory.php\" method=\"post\">";

  echo "<h4>Choose a product name:</h4>";

  echo "<input type=\"text\" name=\"productName\" required = \"required\"/> ";

  echo "<h4>How much will the product cost?:</h4>";

  echo "<input type=\"number\" name=\"cost\" minimum=\"-1\" required = \"required\"/> ";

  echo "<h4>How many are in stock?:</h4>";

  echo "<input type=\"number\" name=\"numberInStock\" required = \"required\"/> ";

  echo "<input type=\"submit\" name=\"addtoinventory\" value=\"Add to Inventory!\">";

  if (isset($_SESSION['error2'])) {
    echo "{$_SESSION['error2']}";
  }

  unset($_SESSION['error2']);

  echo "</form>";

  ///////////////////////

  $sth1 = $dbh->prepare("SELECT * FROM inventory");
  $sth1->execute();
  $res1 = $sth1->fetchAll();

  //dropdown menu to change the price of an item

  echo "<form action =\"changePrice.php\" method = \"post\">";

  echo "<h3>Edit the price of items in the inventory!</h3>";

  echo "<select name = \"changedItem\">";

  foreach ($res1 as $row) {
    echo "<option value=\"".$row['id']."\">".$row['product_name']."</option>";
  }

  echo "</select>";

  echo "<input type=\"number\" name=\"changePriceTo\" required = \"required\"/> ";

  echo"<input type=\"submit\" name=\"submit\" value=\"Update Price\"/>";

  if (isset($_SESSION['error'])) {
    echo "{$_SESSION['error']}";
  }

  unset($_SESSION['error']);

  echo "</form>";

  //dropdown menu to change the number in stock

  echo "<form action =\"changeNumInStock.php\" method = \"post\">";

  echo "<h3>Edit number in stock!</h3>";

  echo "<select name = \"changedItem\">";

  foreach ($res1 as $row) {
    echo "<option value=\"".$row['id']."\">".$row['product_name']."</option>";
  }

  echo "</select>";

  echo "<input type=\"number\" name=\"changeNumInStockTo\" required = \"required\"/> ";

  echo"<input type=\"submit\" name=\"submit\" value=\"Update Number in Stock\"/>";

  if (isset($_SESSION['error1'])) {
    echo "{$_SESSION['error1']}";
  }

  unset($_SESSION['error1']);

  echo "</form>";

  //dropdown menu to select which item to remove from the inventory

  echo "<form action =\"removeFromInventory.php\" method = \"post\">";

  echo "<h3>Remove items in the inventory!</h3>";

  echo "<select name = \"removeItem\">";

  foreach ($res1 as $row) {
    echo "<option value=\"".$row['id']."\">".$row['product_name']."</option>";
  }

  echo "</select>";

  echo"<input type=\"submit\" name=\"submit\" value=\"Remove from inventory\"/>";

  echo "</form>";

  if (isset($_SESSION['error3'])) {
    echo "{$_SESSION['error3']}";
  }

  unset($_SESSION['error3']);

  echo "</div><br><br>";

  echo "<div class = \"welcome\">";

  echo "<a href=\"previousPurchases.php\"> See all previous purchases</a>";

  echo "</div></div></div>";

?>
