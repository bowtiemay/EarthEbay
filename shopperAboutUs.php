<html>
<head><title>EarthEbay!</title>
<link href="x10.css" rel="stylesheet" type="text/css" />
</head>

<?php

  session_start();

  require_once 'config.php';
  require_once 'navBar.php';

  try {

    $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
    $sth3 = $dbh->prepare("SELECT * FROM customer WHERE `username` = :username");
    $sth3->bindValue(':username', $_SESSION['customerID']);
    $sth3->execute();
    $isAdmin = $sth3->fetch();

    if (!isset($_SESSION['customerID'])) {
      header("Location: signin.php");
      exit();
    }

    if ($isAdmin['isAdmin'] == "true")  {
      header("Location: home.php");
      exit();
    }

    navBar();

    $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

    echo "<div class = \"background\"><br><br><br><br>";

    echo "<div class = \"dystopia\">";

    echo "<h3>Humanity is on the brink of extiction. Aliens have taken over Earth, and are selling its most prized possessions per their own determination of value. That means lucky you, young alien, for it is shopping day. Buy humanity's most prized possesions with a few clicks, and get incredible deals on worthless human trinkets. Happy shopping!</h3>";

    echo "</div>";

    echo "<br><br><br><div class = \"signin\">";

    echo "<a href = \"home.php\">Go shop!</a>";

    echo "</div>";

    echo "</div>";

  }

  catch (PDOException $e) {
      echo "<p>Error: {$e->getMessage()}</p>";
  }
 ?>
