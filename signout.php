<html>
<head><title>EarthEbay!</title>
<link href="x10.css" rel="stylesheet" type="text/css" />
</head>

</html>

<?php
  if (!isset($_SESSION)) {
    session_start();
    $_SESSION = array();
  }

  echo "<div class = \"background\"><br><br><br>";

  echo "<div class=\"signin\">";

  echo "<p>You've been logged out! <a href = \"signin.php\">Log back in!</a></p>";

  echo "</div></div>";

	session_destroy();  //look up the documentation for this
?>
