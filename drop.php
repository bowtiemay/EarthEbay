<html>
<head>
    <title>EarthEbay!</title>
</head>
<body>
<?php
require_once "config.php";

try {
    $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
    $dbh->exec('DROP TABLE customer; DROP TABLE inventory; DROP TABLE cart; DROP TABLE previouspurchases');
    echo "<p>Successfully dropped databases</p>";
}
catch (PDOException $e) {
    echo "<p>Error: {$e->getMessage()}</p>";
}
?>
</body>
</html>
