<html>
<head>
    <title>EarthEbay!</title>
</head>
<body>
<?php
  require_once "config.php";

  try {
      $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

      //file_get_contents php manual: https://www.php.net/manual/en/function.file-get-contents.php
      $query = file_get_contents('store.sql');

      //exec php manual: https://www.php.net/manual/en/pdo.exec.php
      $dbh->exec($query);
      echo "<p>Successfully installed databases</p>";
  }
  catch (PDOException $e) {
      echo "<p>Error: {$e->getMessage()}</p>";
  }
?>
</body>
</html>
