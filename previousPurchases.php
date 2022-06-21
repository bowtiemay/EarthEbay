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

      $sth = $dbh->prepare("SELECT * FROM previouspurchases");
      $sth->bindValue(':customer', $_SESSION['customerID']);
      $sth->execute();
      $length0 = $sth->fetch();

      if ($length0 == 0) {

        navbar();

        echo "<div class = \"background\"><br><br><br><br>";
        echo "<div class=\"signin\">";

        echo "<p>No users have made any purchases. <a href=\"admin.php\">Back to admin!</a></p>";

      }

      else {

        navbar();

        echo "<div class = \"background\"><br><br><br><br>";

        echo "<div class=\"signin\">";

        $sth0 = $dbh->prepare("SELECT * FROM previouspurchases ORDER BY `id` DESC LIMIT 1");
        $sth0->execute();
        $length = $sth0->fetch();

        $sth = $dbh->prepare("SELECT * FROM previouspurchases");
        $sth->execute();
        $purchases = $sth->fetchAll();

        //var_dump($length);

        echo "<h2>Previous Purchases:</h2>";

        echo "<a href=\"admin.php\">Back to admin!</a><br><br>";

        echo "<table>";

        echo "<th><strong>User</strong></th><th><strong>Date of Purchase</strong></th><th><strong>Cost of Purchase</strong></th>";

        foreach ($purchases as $row) {
          echo "<tr><td>" . $row["user"] . "</td><td>" . $row["date_of_purchase"]. "</td><td>" . "\$" . $row["cost_of_purchase"]. "</td></tr>";
        }

        echo "</table><br>";

        echo "</div></div></div>";

      }

  }

  catch (PDOException $e) {
      echo "<p>Error: {$e->getMessage()}</p>";
  }

?>
