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
      $song_id = $_POST['song_id'];
      if ($db_connect->query("DELETE from songs WHERE song_id='$song_id'")) {
        echo 'Usunięto utwór';
      } else {
        throw new Exception($db_connect->error);
      }    

    $db_connect->close();
    header('Location: raports.php');
  }

} catch(Exception $e) {
  echo 'Błąd serwera! Przepraszamy za niedogodności.';
  echo '<br /> Informacja deweloperska:'.$e;
}     
?>