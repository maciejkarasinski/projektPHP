<?php
  session_start();
  if(!isset($_SESSION['loggedIn'])) {
    header('Location: index.php');
    exit();
  }

  if(!isset($_SESSION['songsToAdd'])) {
    $_SESSION['songsToAdd'] = 1;
    $_POST['songsToAdd'] = 1;
  }

  if(isset($_SESSION['songsToAdd']) && isset($_POST['songsToAdd'])) {
    $_SESSION['songsToAdd'] = $_POST['songsToAdd'];
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
  <title>Raporty</title>
</head>
<body>
  <?php 
    echo '
      <div class="container">
        <div class="left">';
        echo "<h3 class='bigred'>Witaj ".$_SESSION['user']."!</h3>";
    echo '
        </div>
        <div class="right">
          <a href="changePassword.php">Zmiana hasła</a>
          <a href="logout.php">Wyloguj</a>
        </div>
      </div>
    ';

    echo "<h2>Utwory dostępne w bazie</h2>";
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
          <th>Opcje</th>
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
              <td>
                <form action="deleteSong.php" method="post">
                  <input type="hidden" name="song_id" value="'.$row["song_id"].'">
                  <button class="btn btn-full" type="submit">Usuń</button>
                </form>
                <button class="btn btn-full" onClick="edit('.$row["song_id"].')">Edytuj</button>
              </td>
            </tr>
            <tr class="hidden" id="'.$row["song_id"].'_song">
              <form action="editSong.php" method="post">
                <td><input type="text" name="file_name" value="'.$row["file_name"].'"></td>
                <td><input type="text" name="title" value="'.$row["title"].'"></td>
                <td><input type="text" name="ISCR" value="'.$row["ISCR"].'"></td>
                <td><input type="text" name="composer" value="'.$row["composer"].'"></td>
                <td><input type="text" name="author" value="'.$row["author"].'"></td>
                <td><input type="text" name="sauthor" value="'.$row["sauthor"].'"></td>
                <td><input type="text" name="duration" value="'.$row["duration"].'"></td>
                <input type="hidden" name="song_id" value="'.$row["song_id"].'">
                <td><button class="btn" type="submit">Zapisz</button></td>
              </form>
            </tr>
          ';
        }
      }
      echo '
          <form action="addSong.php" method="post">
              <tr>
              <td><input type="text" name="file_name"></td>
              <td><input type="text" name="title"></td>
              <td><input type="text" name="ISCR"></td>
              <td><input type="text" name="composer"></td>
              <td><input type="text" name="author"></td>
              <td><input type="text" name="sauthor"></td>
              <td><input type="text" name="duration"></td>
              <td><button class="btn btn-full" type="submit">Dodaj utwór</button></td>
              </tr>
            </table>
          </form> 
      ';   
  ?>
  
  <?php
    echo '<div class="createRaportContainer"><h2>Tworzenie raportu</h2>';
    echo '
      <form action="createRaport.php" method="post">
        <div>
          <p>Nazwa raportu:</p>
          <input type="text" name="raport_name" placeholder="nazwa raportu">
          <p>Miesiąc:</p>
          <input type="text" name="raport_month" placeholder="miesiąc">
          <p>Rok:</p>
          <input type="text" name="raport_year" placeholder="rok">
        </div>
        <div class="songsContainer">
          <h4>Wybierz utwory:</h4>
        ';

        for ($i = 1; $i <= $_SESSION['songsToAdd']; $i++){
          echo '<div id="songContainer"><select name="songs[]">';
          if ($_SESSION['songArrays']->num_rows > 0) {
            $_SESSION['songArrays']->data_seek(0);
            while($row = $_SESSION['songArrays']->fetch_assoc() ) {
              echo '
                <option value="'.$row["song_id"].'">'.$row["title"].'</option>
              ';
          }}
          echo '
            </select>
            <input class="inputSong" type="text" name="songs_count[]" placeholder="Ilość odtworzeń">
            </div>
          ';
        }
    echo '
        </div>
        <button class="btn" style="margin-left: 10px; font-size: 24px" type="submit">Stwórz</button>
      </form>
      <form action="raports.php" method="post" id="songNumberForm">
        Ile będzie piosenek?
        <input type="text" name="songsToAdd">
        <button class="btn" type="submit">Akceptuj</button>
      </form></div>
    ';
  ?>

  <?php
    echo '<h2>Raporty dostępne w bazie</h2>';
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
  ?>

<script>
  function edit(song_id) {
    var element = document.getElementById(song_id+"_song");
    element.classList.toggle("hidden");
  }    
</script>
</body>
</html>