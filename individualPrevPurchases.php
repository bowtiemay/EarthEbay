<html>
<head><title>EarthEbay!</title>
<link href="x10.css" rel="stylesheet" type="text/css" />
</head>

</html>

<?php

  session_start();

  require 'config.php';
  require_once 'navBar.php';

  try {

    $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

    navbar();

    echo "<div class = \"background\"><br><br><br>";
    echo "<div class=\"signin\">";

    if (!isset($_SESSION['customerID'])) {
      header("Location: signin.php");
      exit();
    }



    $sth = $dbh->prepare("SELECT * FROM previouspurchases WHERE `user` = :user ORDER BY `id` DESC LIMIT 1");
    $sth->bindValue(':user', $_SESSION['customerID']);
    $sth->execute();
    $length = $sth->fetch();

    if ($length != 0) {


      echo "<h2>Previous Purchases:</h2>";

      $sth0 = $dbh->prepare("SELECT * FROM previouspurchases WHERE `user` = :customer");
      $sth0->bindValue(':customer', $_SESSION['customerID']);
      $sth0->execute();
      $length = $sth0->fetchAll();

      //var_dump($length);

      echo "<table>";

      echo "<th><strong>User</strong></th><th><strong>Date of Purchase</strong></th><th><strong>Cost of Purchase</strong></th>";

      foreach ($length as $row) {
        echo "<tr><td>" . $row["user"] . "</td><td>" . $row["date_of_purchase"]. "</td><td>" . "\$" . $row["cost_of_purchase"]. "</td></tr>";
      }

      echo "</table><br>";


    }

    else {



      echo "<p>You have no previous purchases. <a href = \"home.php\">Go Shop!</a></p>";





    }

    echo "</div></div>";

  }

  catch (PDOException $e) {
      echo "<p>Error: {$e->getMessage()}</p>";
  }

?>
