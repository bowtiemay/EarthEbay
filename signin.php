<?php

  session_start();

    if (isset($_SESSION['customerID'])) {
      header("Location: home.php");
      exit();
    }

?>

<html>
<head><title>EarthEbay!</title>
<link href="x10.css" rel="stylesheet" type="text/css" />
</head>

</html>

<?php
  require_once 'config.php';

  try {

    echo "<div class = \"background\"><br>";

    echo "<br><div class=\"signin\">";

    echo "<h1>Log In To EarthEbay!</h1>";

    $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

    $sth = $dbh->prepare("SELECT * FROM customer");

    $sth->execute();

    $var = $sth->fetchAll();

    echo "<h3>Username:</h3>";

    echo "<form action = \"home.php\" method=\"post\">";

    echo "<input type=\"text\" name=\"customerSelect\" required = \"required\"/> ";


    //password

    echo "<h3>Password:</h3>";

    echo "<div id = \"pass\"><input type=\"password\" name=\"passwordSelect\"></div>";

    echo "<br><br><br>";

    echo "<input type=\"submit\" name=\"login\" value=\"Log in!\" required = \"required\">";

    if (isset($_SESSION['error'])) {
      echo "{$_SESSION['error']}";
    }

    echo "</form>";

    unset($_SESSION['error']);

    echo "</div><br><br>";

    echo "<div class=\"welcome\">";

    echo "<p>Don't have an account? <a href=\"createaccount.php\">Create one!</a></p>";

    echo "</div></div></div>";

  }

  catch (PDOException $e) {
      echo "<p>Error: {$e->getMessage()}</p>";
  }

 ?>
