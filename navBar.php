<?php

  function navbar() {

    try {

    $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
    $sth3 = $dbh->prepare("SELECT * FROM customer WHERE `username` = :username");
    $sth3->bindValue(':username', $_SESSION['customerID']);
    $sth3->execute();
    $isAdmin = $sth3->fetch();

    echo "<div class = \"navbar\">";
    echo "<h1>EarthEbay!</h1>";
    echo "<nav>";
    echo "<a href = \"home.php\" id=\"home\"> Shop </a>";

    if ($isAdmin['isAdmin'] == "false") {
      echo "<a href = \"shopperAboutUs.php\" id=\"shopperAboutUs\"> Backstory </a>";
    }
    else {
      echo "<a href = \"adminAboutUs.php\" id=\"adminAboutUs\"> Backstory </a>";
    }

    echo "<a href = \"individualPrevPurchases.php\" id=\"previousPurchases\"> Previous Purchases </a>";

    if ($isAdmin['isAdmin'] == "true") {
      echo "<a href = \"admin.php\" id=\"admin\"> Admin Page </a>";
    }
    echo "<a href = \"cart.php\" id=\"cart\"> Cart </a>";
    echo "<a href = \"signout.php\" id=\"signout\"> Sign Out </a>";
    echo "</nav>";
    echo "</div>";

  }

  catch (PDOException $error) {
    echo "<p>Error</p>";
  }
  }
?>
