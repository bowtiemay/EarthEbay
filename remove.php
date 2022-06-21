<?php

  session_start();

 ?>


 <html>
 <head><title>EarthEbay!</title>
 <link href="x10.css" rel="stylesheet" type="text/css" />
 </head>

 </html>

<?php

  try {
    require_once 'config.php';
    require_once 'navbar.php';

    navbar();

    echo "<div class = \"background\"><br><br><br>";

    echo "<div class=\"signin\">";

    if (!isset($_SESSION['customerID'])) {
      if (!isset($_POST['customerSelect'])) {
        header("Location: signin.php");
        exit();
      }
    }

    if (isset($_POST['removeItem']) && is_numeric($_POST['removeItem'])) {
      $removedItem = $_POST['removeItem'];
    }
    else {
      $_SESSION['error5'] = "Invalid input.";
      header("Location: cart.php");
      exit();
    }


    //require_once 'game.php';

    $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

    // if (isset($_POST['removeItem'])) {

    // }

    //var_dump($_POST['removeItem']);

    $sth1 = $dbh->prepare("SELECT * FROM customer WHERE `username` = :customerID");
    $sth1->bindValue(':customerID', $_SESSION['customerID']);
    $sth1->execute();
    $username = $sth1->fetch();

    $sth3 = $dbh->prepare("SELECT * FROM cart WHERE `product_name` = :item WHERE 'username' = :username");
    $sth3->bindValue(':username', $username['username']);
    $sth3->bindValue(':item', $removedItem);
    $sth3->execute();
    $item = $sth3->fetch();

    // if ($item['product_name'] != $_SESSION['customerID']) {
    //   echo "That's not your thingamabob. ";
    //   echo "<a href=\"home.php\">Back to the home page!</a>";
    // }
    // else {
    //
      $sth2 = $dbh->prepare("DELETE FROM cart WHERE `id` = :item");
      $sth2->bindValue(':item', $removedItem);
      $caught = $sth2->execute();

      echo "<p>An item has been removed from your cart. <a href=\"cart.php\">Back to the cart! </a></p>";

      echo "</div></div></div>";

    //}

  }

  catch (PDOException $error) {
    echo "<p>Error</p>";
  }

?>
