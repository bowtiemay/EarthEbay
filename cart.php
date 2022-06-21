<?php
  session_start();
 ?>


<html>
<head>
<title>EarthEbay!</title>
<link href="x10.css" rel="stylesheet" type="text/css" />
</head>
</html>

<?php

  require 'config.php';
  require_once 'navBar.php';

  $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

  navbar();

  echo "<div class = \"background\"><br><br><br>";

  echo "<div class=\"signin\">";

  if (!isset($_SESSION['customerID'])) {
    if (!isset($_POST['customerSelect'])) {
      header("Location: signin.php");
      exit();
    }
  }

  $sth = $dbh->prepare("SELECT * FROM cart WHERE `user` = :user ORDER BY `id` DESC LIMIT 1");
  $sth->bindValue(':user', $_SESSION['customerID']);
  $sth->execute();
  $length = $sth->fetch();



  if ($length != 0) {

    echo "<h2>Cart:</h2>";

    $sth0 = $dbh->prepare("SELECT * FROM cart  WHERE `user` = :user");
    $sth0->bindValue(':user', $_SESSION['customerID']);
    $sth0->execute();
    $res = $sth0->fetchAll();
    //var_dump($res);

    echo "<table>";

    echo "<th><strong>Item</strong></th><th><strong>Price</strong></th>";

    foreach ($res as $row) {
      echo "<tr><td>" . $row["product_name"]. "</td><td>\$" . $row["product_price"]. "</td></tr>";
    }

    echo "</table>";

  //cart subtotal

    $sth1 = $dbh->prepare("SELECT * FROM cart where `user` = :user");
    $sth1->bindValue(':user', $_SESSION['customerID']);
    $sth1->execute();
    $res1 = $sth1->fetchAll();

    $sth2 = $dbh->prepare("SELECT * FROM cart");
    $sth2->execute();
    $res2 = $sth2->fetchAll();

    $totalPrice = 0;

    //var_dump($res1);

    echo "<form action =\"remove.php\" method = \"post\">";

    echo "<h3>Remove items from your cart!</h3>";

    echo "<select name = \"removeItem\">";

    foreach ($res1 as $row) {
      echo "<option value=\"".$row['id']."\">".$row['product_name']."</option>";

      $totalPrice += $row['product_price'];
    }

    echo "</select>";

    echo"<input type=\"submit\" name=\"submit\" value=\"Remove from cart\"/>";

    if (isset($_SESSION['error5'])) {
      echo "{$_SESSION['error5']}";
    }

    unset($_SESSION['error5']);

    echo "</form>";

    $_SESSION['totalPrice'] = $totalPrice;

    echo "<p>Subtotal: \${$totalPrice}</p>";

    echo "<a href=\"checkout.php\"> Go to Checkout!</a>";

    echo "</div></div></div>";

  }

  else {
    echo "<p>Your cart is empty. <a href=\"home.php\">Go fill it!</a></p>";
  }

 ?>
