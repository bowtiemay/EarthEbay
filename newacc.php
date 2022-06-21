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

  // if (!isset($_SESSION['customerID'])) {
  //   header("Location: signin.php");
  //   exit();
  // }

  try {

    echo "<div class = \"background\"><br><br>";

    echo "<div class=\"signin\">";

    //if confirm password and pswd r not equal, go back to createaccount and echo error
    //have to check the unhashed versions
    if (isset($_POST['confirmpassword']) && isset($_POST['newpassword'])) {
      $confirmPassword = $_POST['confirmpassword'];
      $newPassword = $_POST['newpassword'];

      //strcmp bc == isnt case sensitive
      if (strcmp($confirmPassword, $newPassword) != 0) {
        $_SESSION['error8'] = "Passwords do not match.";
        header("Location: createaccount.php");
        exit();
      }

    }
    else {
      header("Location: createaccount.php");
      exit();
    }

    // if (isset($_POST['confirmpassword'])) {
    //   $confirmPassword = $_POST['confirmpassword'];
    // }
    // else {
    //   header("Location: createaccount.php");
    //   exit();
    // }

    if (isset($_POST['newusername'])) {
      $username = htmlspecialchars($_POST['newusername']);   //will need this
    }
    else {
      header("Location: createaccount.php");
      exit();
    }

    //hash the password
    $password = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
    // }
    // else {
    //   header("Location: createaccount.php");
    //   exit();
    // }

    //if confirm password and pswd r not equal, go back to createaccount and echo error
    // if ($confirmPassword != $password) {
    //   $_SESSION['error8'] = "Passwords no not match.";
    //   header("Location: createaccount.php");
    //   exit();
    // }

    $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);


    $password = htmlspecialchars($password);


    $sth0 = $dbh->prepare("SELECT * FROM customer");
    $sth0->execute();
    $usernames = $sth0->fetchAll();

    //var_dump($usernames);

    foreach ($usernames as $user) {
      if ($username == $user['username']) {
        $_SESSION['error7'] = "Username already exists.";
        header('Location: createaccount.php');
        exit();
      }
    }


    // $_SESSION['username'] = $username;
    // $_SESSION['password'] = $password;

    $sth = $dbh->prepare("INSERT INTO customer (`username`, `password_hash`, `isAdmin`) VALUES (:username, :password, 'false')");
    $sth->bindValue(':username', $username);
    $sth->bindValue(':password', $password);
    $newaccount = $sth->execute();

    echo "<p>Successfully created account for {$username}! <a href = \"signin.php\">Back to signin!</a></p>";

    echo "</div></div></div>";

  }
  catch (PDOException $e) {
      echo "<p>Error: {$e->getMessage()}</p>";
  }
?>
