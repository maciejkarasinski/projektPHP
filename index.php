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
      
      $raports = $db_connect->query("SELECT * FROM raports");
      if(!$raports) throw new Exception($db_connect->error);

      $_SESSION['raportArray'] = $raports;
        
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
  <link rel="stylesheet" href="main.css" type="text/css">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
  <title>Strona główna</title>
</head>
<body>
  <div>
    <h3>Zaloguj się</h3>
    <form action="login.php" method="post">
      <p class="label">Login:</p>
      <input type="text" name="login">
      <p class="label">Hasło:</p>
      <input type="password" name="password">
      <div>
        <button type="submit" class="btn">Zaloguj się</button>
      </div>
    </form>
  <div>
  <?php
    if(isset($_SESSION['blad'])){
      echo $_SESSION['blad'];
    }
  ?>

  <?php
    echo '<div style="margin-top: 30px" ><h2>Dostępne utwory w serwisie:</h2></div>';
    echo '
    <table class="table" style="margin-top: 30px">
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

<?php
    echo '
      <div class="raportsContainer">
        <h2>Dostępne raporty:</h2>
    ';
    if ($_SESSION['raportArray']->num_rows > 0) {
      $counter = 1;
      while($row = $_SESSION['raportArray']->fetch_assoc() ) {
        echo '<h2>'.$counter.'. Nazwa raportu: '.$row['name'].'</h2>';
        echo '<h3>miesiąc: '.$row['month'].', rok: '.$row['year'].'</h3>';
        echo '
          <form action="fetchReports.php" method="post">
            <input type="hidden" name="raport_id" value="'.$row["raport_id"].'">
            <input type="hidden" name="raport_name" value="'.$row["name"].'">
            <input type="hidden" name="raport_month" value="'.$row["month"].'">
            <input type="hidden" name="raport_year" value="'.$row["year"].'">
            <button class="btn" type="submit">Wyświetl raport</button>
          </form>';
        $counter++;
      }
    }
    echo '</div>';
  ?>
</body>
</html>