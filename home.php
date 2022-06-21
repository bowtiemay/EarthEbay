<?php

  session_start();

?>

<html>
<head><title>EarthEbay!</title>
<link href="x10.css" rel="stylesheet" type="text/css" />
</head>

</html>

<?php

  require_once 'config.php';
  require_once 'navBar.php';

  try {

    $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);



    if (!isset($_SESSION['customerID'])) {
      if (isset($_POST['customerSelect']) && isset($_POST['passwordSelect'])) {

        $sth = $dbh->prepare("SELECT `password_hash` FROM customer WHERE `username` = :username");
        $sth->bindValue(':username', htmlspecialchars($_POST['customerSelect']));
        $sth->execute();
        $customerPass = $sth->fetch();

        if (password_verify($_POST['passwordSelect'], $customerPass['password_hash'])) {
            $playerID = htmlspecialchars($_POST['customerSelect']);
            $_SESSION["customerID"] = htmlspecialchars($_POST['customerSelect']);
        }

        else {
          $_SESSION['error'] = "Incorrect password.";
          header("Location: signin.php");
          exit();
        }

      }

    	else {
        //$_SESSION['error'] = "Incorrect password.";
    		header("Location: signin.php");
        exit();
        //session_destroy();
    	}
    }

    navbar();

    $username = htmlspecialchars($_SESSION['customerID']);

    ////////////

    echo "<div class = \"background\"><br><br><br>";

    echo "<div class=\"welcome\">";

    $sth3 = $dbh->prepare("SELECT * FROM customer WHERE `username` = :username");
    $sth3->bindValue(':username', $username);
    $sth3->execute();
    $isAdmin = $sth3->fetch();

    if ($isAdmin['isAdmin'] == "true") {
      echo "<p>You are signed in as an admin! <a href=\"admin.php\">Go to the admin page!</a></p>";
    }

    echo "</div><br><br><br>";

    echo "<div class=\"signin\">";

    $sth1 = $dbh->prepare("SELECT * FROM customer WHERE `username` = :username");
    $sth1->bindValue(':username', $username);
    $sth1->execute();
    $customerName = $sth1->fetch();

    $sth2 = $dbh->prepare("SELECT * FROM inventory");
    $sth2->execute();
    $var = $sth2->fetchAll();
    echo "<h3>Choose an item to add to the cart:</h3>";

    echo "<form action = \"add.php\" method=\"post\">";

    echo "<select name=\"item\">"; // list box

//dropdown
    foreach ($var as $row){
      echo "<option value=\"".$row['id']."\">".$row['product_name']."</option>";
    }

    echo "</select>";

    echo "<input type=\"submit\" name=\"addtocart\" value=\"Add to Cart!\">";

    if (isset($_SESSION['error4'])) {
      echo "{$_SESSION['error4']}";
    }

    unset($_SESSION['error4']);

    echo "</form>";

    echo "</div><br><br>";

    echo "<br><div class=\"name\">";

    echo "<p>You are signed is as {$username}. <a href=\"signout.php\">Sign out</a></p>";

    echo "</div>";


  }

  catch (PDOException $e) {
      echo "<p>Error: {$e->getMessage()}</p>";
  }

 ?>
