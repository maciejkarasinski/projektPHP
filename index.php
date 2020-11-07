<?php
  session_start();

  if(isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'])==true) {
    header('Location: raports.php');
    exit();
  } 

  require_once "connect.php";
  mysqli_report(MYSQLI_REPORT_STRICT);
  try {
    $db_connect = new mysqli($host, $db_user, $db_password, $db_name);
    if($db_connect->connect_errno!=0) {
      throw new Exception(mysqli_connect_errno());
    } else {
      $songs = $db_connect->query("SELECT * FROM songs");
      if(!$songs) throw new Exception($db_connect->error);

      $_SESSION['songArrays'] = $songs;       
      $db_connect->close();
    }
  } catch(Exception $e) {
    echo 'Błąd serwera! Przepraszamy za niedogodności.';
    echo '<br /> Informacja deweloperska:'.$e;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css" type="text/css">
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

  <?php
    echo '
    <table class="table">
      <tr>
        <th>Nazwa pliku</th>
        <th>Tytuł</th>
        <th>kod ISRC</th>
        <th>Kompozytor</th>
        <th>Autor</th>
        <th>Autor opracowania</th>
        <th>Czas trwania [s]</th>
      </tr>';

    if ($_SESSION['songArrays']->num_rows > 0) {
      while($row = $_SESSION['songArrays']->fetch_assoc() ) {
        echo '
          <tr>
            <td>'.$row["file_name"].'</td>
            <td>'.$row["title"].'</td>
            <td>'.$row["ISCR"].'</td>
            <td>'.$row["composer"].'</td>
            <td>'.$row["author"].'</td>
            <td>'.$row["sauthor"].'</td>
            <td>'.$row["duration"].'</td>
          </tr>
        ';
      }
    }
    echo '</table>';
  ?>
</body>
</html>