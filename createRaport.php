<?php
session_start();
 if(!isset($_POST['raport_name']) || !isset($_POST['raport_month']) || !isset($_POST['raport_year']) ||
    !isset($_POST['songs']) || !isset($_POST['songs_count'])) {
  header('Location: index.php');
  exit();
 }
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
      $raport_name = $_POST['raport_name'];
      $raport_month = $_POST['raport_month'];
      $raport_year = $_POST['raport_year'];
      $songs = $_POST['songs'];
      $songs_count = $_POST['songs_count'];

      //echo $raport_name, $raport_month, $raport_year, $songs[0], $songs_count[0];

      if ($db_connect->query("INSERT INTO raports VALUES (NULL, '$raport_year', '$raport_month', '$raport_name')")) {
        echo 'Pomyślnie dodano raport';
      } else {
        throw new Exception($db_connect->error);
      } 
      $lastRow = $db_connect->query("SELECT * FROM raports ORDER BY raport_id DESC LIMIT 1");
      $lastRow = $lastRow->fetch_assoc();
      $lastRow_id = $lastRow['raport_id'];
      if(!$lastRow) throw new Exception($db_connect->error);

      for ($i = 0; $i < sizeof($songs); $i++) {
        $song_id = $songs[$i];
        $song_count = $songs_count[$i];
        if ($db_connect->query("INSERT INTO emitraport VALUES (NULL, '$lastRow_id', '$song_id', '$song_count')")) {
          echo 'Pomyślnie dodano utwór';
        } else {
          throw new Exception($db_connect->error);
        }
      }
      

    $db_connect->close();
    header('Location: raports.php');
  }

} catch(Exception $e) {
  echo 'Błąd serwera! Przepraszamy za niedogodności.';
  echo '<br /> Informacja deweloperska:'.$e;
}     
?>