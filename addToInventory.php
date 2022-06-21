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

    navbar();

    echo "<div class = \"background\"><br><br><br>";

    echo "<div class=\"signin\">";



    $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

    if (isset($_POST['productName'])) {
      $productName = htmlspecialchars($_POST['productName']);
    }
    else {
      $_SESSION['error2'] = "Invalid input.";
      header('Location: admin.php');
      exit();
    }

    if (isset($_POST['cost']) && is_numeric($_POST['cost'])) {
      $cost = htmlspecialchars($_POST['cost']);
    }
    else {
      $_SESSION['error2'] = "Invalid input.";
      header('Location: admin.php');
      exit();
    }
    if (isset($_POST['numberInStock']) && is_numeric($_POST['numberInStock'])) {
      $numberInStock = htmlspecialchars($_POST['numberInStock']);
    }
    else {
      $_SESSION['error2'] = "Invalid input.";
      header('Location: admin.php');
      exit();
    }

    $sth4 = $dbh->prepare("INSERT INTO inventory (`product_name`, `cost`, `number_in_stock`) VALUES (:productName, :cost, :numberInStock)");
    $sth4->bindValue(':productName', $productName);
    $sth4->bindValue(':cost', $cost);
    $sth4->bindValue(':numberInStock', $numberInStock);
    $newItem = $sth4->execute();

    if (!isset($newItem)) {
      header('Location:admin.php');
      exit();
    }
    else {
      echo "<p>`{$productName}` has been added to the inventory! <a href=\"admin.php\">Back to admin!</a></p>";
    }

    echo "</div></div></div>";

  }

  catch (PDOException $e) {
      echo "<p>Error: {$e->getMessage()}</p>";
  }

 ?>
