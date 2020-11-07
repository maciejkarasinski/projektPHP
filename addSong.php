<?php
session_start();
 if(!isset($_POST['file_name']) || !isset($_POST['title']) || !isset($_POST['ISCR']) ||
    !isset($_POST['composer']) || !isset($_POST['author']) || !isset($_POST['sauthor']) || !isset($_POST['duration']) ) {
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
      $file_name = $_POST['file_name'];
      $title = $_POST['title'];
      $ISCR = $_POST['ISCR'];
      $composer = $_POST['composer'];
      $author = $_POST['author'];
      $sauthor = $_POST['sauthor'];
      $duration = $_POST['duration'];

      if ($db_connect->query("INSERT INTO songs VALUES (NULL, '$file_name', '$title', '$ISCR',
      '$composer', '$author', '$sauthor', '$duration')")) {
        echo 'Pomyślnie dodano utwór';
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