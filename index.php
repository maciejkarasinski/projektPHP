<?php
  session_start();

  if(isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'])==true) {
    header('Location: raports.php');
    exit();
  } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Strona główna</title>
</head>
<body>
  <form action="login.php" method="post">
    <p>Login:</p>
    <input type="text" name="login">
    <p>Hasło:</p>
    <input type="password" name="password">
    <div>
      <button type="submit">Zaloguj się</button>
    </div>
  </form>
  <?php
    if(isset($_SESSION['blad'])){
      echo $_SESSION['blad'];
    }
  ?>
</body>
</html>