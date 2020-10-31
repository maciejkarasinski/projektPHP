<?php
  session_start();
  if(!isset($_SESSION['loggedIn'])) {
    header('Location: index.php');
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Raporty</title>
</head>
<body>
  <?php 
    echo '<a href="logout.php">Wyloguj</a>';
    echo "<p>Witaj ".$_SESSION['user']."!</p>";
    echo "<p>TEST@ id: ".$_SESSION['user_id']." email: ".$_SESSION['email']."</p>";
  ?>
</body>
</html>