<html>
<head><title>EarthEbay!</title>
<link href="x10.css" rel="stylesheet" type="text/css" />
</head>

</html>

<?php

  session_start();

    require 'config.php';
    require_once 'navBar.php';

  try {

      if (!isset($_SESSION['customerID'])) {
        header("Location: signin.php");
        exit();
      }

      if (!isset($_SESSION['totalPrice'])) {
        $_SESSION['totalPrice'] = 0;
      }

      navbar();

      echo "<div class = \"background\"><br><br><br><br>";

      echo "<div class=\"signin\">";

      $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

      echo "<h1>Checkout</h1>";

      echo "<form action =\"thanks.php\" method = \"post\">";

      $subtotal = $_SESSION['totalPrice'];
      echo "Subtotal: \${$subtotal}<br>";
      echo "Shipping and handling: Free<br>";
      $totalWithTax = $subtotal * 1.06;
      $tax = $totalWithTax-$subtotal;
      echo "Tax: \${$tax}<br>";
      echo "<strong>Total: \${$totalWithTax}<strong>";

      $_SESSION['totalWithTax'] = $totalWithTax;

      echo "<h3>Enter your credit card number (format: 1111-1111-1111):</h3>";
      echo "<input type=\"tel\" id=\"phone\" name=\"phone\" pattern=\"[0-9]{4}-[0-9]{4}-[0-9]{4}\" placeholder=\"ex. 1111-1111-1111\" required>";

      echo "<h3>What is your birthday?</h3>";
      echo "<input type=\"date\" id=\"birthday\" name=\"birthday\" min=\"1903-01-02\" required>";

      echo "<h3>Enter your email:</h3>";
      echo "<input type=\"email\" id=\"email\" name=\"email\" placeholder=\"ex. booradley@hotmail.com\" required>";

      echo "<h3>Enter your phone number (format: 111-111-1111):</h3>";
      echo "<input type=\"tel\" id=\"phone\" name=\"phone\" pattern=\"[0-9]{3}-[0-9]{3}-[0-9]{4}\" placeholder=\"ex. 111-111-1111\" required>";

      echo "<h3>Enter your address:</h3>";
      echo "<input type=\"text\" id=\"address\" name=\"address\" placeholder=\"ex. 1269 Cherry Lane\" required>";

      echo "<h3>What is today's date?</h3>";
      echo "<input type=\"date\" id=\"dateToday\" name=\"dateToday\" min=\"2021-07-26\" required>";

      echo "<br><br><input type=\"submit\" name=\"submit\" value=\"Checkout!\">";

      echo "</form>";

      echo "</div></div>";
  }

  catch (PDOException $e) {
      echo "<p>Error: {$e->getMessage()}</p>";
  }

?>
