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

    if (isset($_SESSION['customerID'])) {
      header("Location: home.php");
      exit();
    }

    echo "<div class = \"background\"><br>";

    echo "<br><div class=\"signin\">";

    echo "<h2>Sign up for a new account!</h2>";

    echo "<form action = \"newacc.php\" method=\"post\">";

    echo "<p>Set a username:</p>";

    echo "<input type=\"text\" name=\"newusername\" required = \"required\"/> ";

    echo "<p>Set a password:</p>";

    echo "<input type=\"password\" name=\"newpassword\" required = \"required\"/> ";

    echo "<br>";

    echo "<p>Confirm password:</p>";

    echo "<input type=\"password\" name=\"confirmpassword\" required = \"required\"/> ";

    if (isset($_SESSION['error8'])) {
      echo "<br><br>{$_SESSION['error8']}";
    }

    echo "<br><br><br><input type=\"submit\" name=\"createaccount\" value=\"Create Account!\">";

    echo "</form>";

    if (isset($_SESSION['error7'])) {
      echo "{$_SESSION['error7']}";
    }

    unset($_SESSION['error7']);

    echo "</div><br><br>";

    echo "<div class=\"welcome\">";

    echo "<p>Already have an account? <a href=\"signin.php\">Sign in!</a></p>";

    echo "</div></div>";

  }

  catch (PDOException $e) {
      echo "<p>Error: {$e->getMessage()}</p>";
  }

 ?>
