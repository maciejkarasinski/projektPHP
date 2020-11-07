<?php
  session_start();
  if(!isset($_SESSION['loggedIn'])) {
    header('Location: index.php');
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <title>Raporty</title>
</head>
<body>
  <?php 
    echo '<a href="logout.php">Wyloguj</a>';
    echo "<p>Witaj ".$_SESSION['user']."!</p>";

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
                  <button type="submit">Usuń</button>
                </form>
                <button>Edytuj</button>
              </td>
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
              <td><button type="submit">Dodaj utwór</button></td>
              </tr>
            </table>
          </form> 
      ';   
  ?>
</body>
</html>