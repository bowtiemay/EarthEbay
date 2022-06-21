<html>
<head><title>EarthEbay!</title>
<link href="x10.css" rel="stylesheet" type="text/css" />
</head>

</html>

<?php

  session_start();

    require 'config.php';
    require_once 'navbar.php';

  try {

      $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

      if (!isset($_SESSION['customerID'])) {
        header("Location: signin.php");
        exit();
      }

      if (!isset($_POST["submit"])) {
        header("Location: home.php");
        exit();
      }

      navbar();

      echo "<div class = \"background\"><br><br><br>";

      echo "<div class=\"signin\">";

      echo "<h1>Thank you for your purchase!</h1>";

      echo "<h3>You checked out! No refunds bro. Thanks for your purchase. Your total was \${$_SESSION['totalWithTax']}.</h3>";

      echo "<a href=\"signout.php\">Signout</a>";

      $sth = $dbh->prepare("DELETE FROM cart WHERE `user` = :customer");
      $sth->bindValue(':customer', $_SESSION['customerID']);
      $sth->execute();

      $sth1 = $dbh->prepare("INSERT INTO previouspurchases(`date_of_purchase`, `cost_of_purchase`, `user`) VALUES (:dateToday, :costOfPurchase, :user)");
      $sth1->bindValue(':dateToday', $_POST['dateToday']);
      $sth1->bindValue(':costOfPurchase', $_SESSION['totalWithTax']);
      $sth1->bindValue(':user', $_SESSION['customerID']);
      $sth1->execute();



      echo "</div></div></div>";

  }

  catch (PDOException $e) {
      echo "<p>Error: {$e->getMessage()}</p>";
  }

?>
