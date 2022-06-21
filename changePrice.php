<html>
<head><title>EarthEbay!</title>
<link href="x10.css" rel="stylesheet" type="text/css" />
</head>

</html>

<?php

  session_start();

  require_once 'config.php';
  require_once 'navbar.php';

  try {

    if (!isset($_SESSION['customerID'])) {
      header("Location: signin.php");
      exit();
    }

    $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

    navbar();

    echo "<div class = \"background\"><br><br><br><br>";

    echo "<div class=\"signin\">";

    if (isset($_POST['changedItem']) && is_numeric($_POST['changedItem'])) {
      $itemToChange = htmlspecialchars($_POST['changedItem']);
    }
    else {
      $_SESSION['error'] = "Invalid input.";
      header('Location: admin.php');
      exit();
    }

    if (isset($_POST['changePriceTo']) && is_numeric($_POST['changePriceTo'])) {
      $changedProductPrice = htmlspecialchars($_POST['changePriceTo']);
    }
    else {
      $_SESSION['error'] = "Invalid input.";
      header('Location: admin.php');
      exit();
    }


    $sth2 = $dbh->prepare("SELECT * FROM inventory WHERE `id` = :item");
    $sth2->bindValue(':item', $itemToChange);
    $sth2->execute();
    $productName = $sth2->fetch();

    $sth = $dbh->prepare("UPDATE inventory SET `cost` = :cost WHERE `product_name` = :item");
    $sth->bindValue(':cost', $changedProductPrice);
    $sth->bindValue(':item', $productName['product_name']);
    $sth->execute();

    echo "<p>The price of '{$productName['product_name']}' was updated to {$changedProductPrice}! <a href=\"admin.php\">Back to admin page</a></p>";

    echo "</div></div>";

  }

  catch (PDOException $e) {
      echo "<p>Error: {$e->getMessage()}</p>";
  }

 ?>
