<html>
<head><title>EarthEbay!</title>
<link href="x10.css" rel="stylesheet" type="text/css" />
</head>

</html>

<?php

  session_start();

  require_once 'config.php';

  try {

    require_once 'navbar.php';

    if (!isset($_SESSION['customerID'])) {
      header("Location: signin.php");
      exit();
    }

    $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

    navbar();

    echo "<div class = \"background\"><br><br><br>";

    echo "<div class=\"signin\">";

    if (isset($_POST['removeItem']) && is_numeric($_POST['removeItem'])) {
      $removedItem = $_POST['removeItem'];
    }
    else {
      $_SESSION['error3'] = "Invalid input.";
      header('Location: admin.php');
      exit();
    }

    $sth3 = $dbh->prepare("SELECT * FROM inventory WHERE `id` = :item");
    $sth3->bindValue(':item', $removedItem);
    $sth3->execute();
    $productName = $sth3->fetch();


    $sth4 = $dbh->prepare("DELETE FROM inventory WHERE `product_name` = :productName");
    $sth4->bindValue(':productName', $productName['product_name']);
    $sth4->execute();

    echo "<p>'{$productName['product_name']}' has been removed from the inventory! <a href=\"admin.php\">Back to admin page</a></p>";

    echo "</div></div></div>";


  }

  catch (PDOException $e) {
      echo "<p>Error: {$e->getMessage()}</p>";
  }

 ?>
