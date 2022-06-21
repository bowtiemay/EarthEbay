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

  require_once 'navBar.php';
  require_once 'config.php';
  $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

  navbar();
  try {

    if (!isset($_SESSION['customerID'])) {
      if (!isset($_POST['customerSelect'])) {
        header("Location: signin.php");
        exit();
      }
    }

    if (isset($_POST['item']) && is_numeric($_POST['item'])) {
      $item = $_POST['item'];
    }

    else {
      $_SESSION['error4'] = "Invalid input.";
      header("Location: home.php");
      exit();
    }

    require_once 'config.php';

    echo "<div class = \"background\"><br><br><br>";

    echo "<div class=\"signin\">";

    if (isset($_SESSION['customerID'])) {
      $customer = $_SESSION['customerID'];
    }
    else {
      $customer = '[not set]';
      echo "Session customer ID is not set.";
    }

    $sth = $dbh->prepare("SELECT `number_in_stock` FROM inventory WHERE `id` = :id");
    $sth->bindValue(':id', $item);
    $sth->execute();
    $numberInStock = $sth->fetch();

    $sth2 = $dbh->prepare("SELECT `product_name` FROM inventory WHERE `id` = :id");
    $sth2->bindValue(':id', $item);
    $sth2->execute();
    $productName = $sth2->fetch();

    $sth5 = $dbh->prepare("SELECT `product_name` FROM cart WHERE `user` = :customer");
    $sth5->bindValue(':customer', $_SESSION['customerID']);
    $sth5->execute();
    $productNames = $sth5->fetchAll(); //everything in a particular user's cart (names)

    //var_dump($productNames); //yay outputting list of product names lol

    foreach ($productNames as $product) {

      $sth6 = $dbh->prepare("SELECT * FROM inventory WHERE `product_name` = :productNames");
      $sth6->bindValue(':productNames', $product['product_name']);
      $sth6->execute();
      $nameInInventory = $sth6->fetch();

      $sth3 = $dbh->prepare("UPDATE inventory SET `number_in_stock` = :newNumber WHERE `product_name` = :productName");
      $sth3->bindValue(':productName', $product['product_name']);
      $changedNumInStock = $nameInInventory['number_in_stock']-1;
      $sth3->bindValue(':newNumber', $changedNumInStock);
      $aVariable = $sth3->execute();

    }

    if ($numberInStock['number_in_stock'] <= 0) {
      echo "{$productName['product_name']} is not in stock. <a href=\"home.php\"> Continue Shopping </a>";
    }

    else {
      $sth1 = $dbh->prepare("SELECT `cost` FROM inventory WHERE `id` = :id");
      $sth1->bindValue(':id', $item);
      $sth1->execute();
      $productPrice = $sth1->fetch();

    
      $sth3 = $dbh->prepare("INSERT INTO cart (`product_name`, `product_price`, `user`) VALUES (:product, :price, :user)");
      $sth3->bindValue(':product', $productName['product_name']);
      $sth3->bindValue(':price', $productPrice['cost']);
      $sth3->bindValue(':user', $_SESSION['customerID']);
      $inserted = $sth3->execute();

      //var_dump($inserted);

      echo "'{$productName['product_name']}' has been added to your cart! <a href=\"home.php\">Continue Shopping!</a>";

    }

    echo "</div></div></div>";

  }

  catch (PDOException $error) {
    echo "<p>Error</p>";
  }

?>
