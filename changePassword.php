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
  <link rel="stylesheet" href="style.css" type="text/css">
  <link rel="stylesheet" href="main.css" type="text/css">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
  <title>Zmiana hasła</title>
</head>
<body>
  <form action="changePasswordDB.php" method="post">
    <p class="label">Podaj aktualne hasło:</p>
    <input type="password" name="password">
    <p class="label">Podaj nowe hasło:</p>
    <input type="password" name="new_password">
    <div>
      <button class="btn" type="submit">Zmiana hasła</button>
    </div>
  </form>
</body>
</html>