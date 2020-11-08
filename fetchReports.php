<?php
session_start();
 if(!isset($_POST['raport_id'])){
  exit();
 }

require_once "connect.php";
  
mysqli_report(MYSQLI_REPORT_STRICT);
try {
  $db_connect = new mysqli($host, $db_user, $db_password, $db_name);
  if($db_connect->connect_errno!=0) {
    throw new Exception(mysqli_connect_errno());
  } else {
      $raport_id = $_POST['raport_id'];
      $raport_name = $_POST['raport_name'];
      $raport_month = $_POST['raport_month'];
      $raport_year = $_POST['raport_year'];

      $query = $db_connect->query("SELECT s.title, s.iscr, s.composer, s.author, s.sauthor, s.duration, er.count 
        FROM songs s, emitraport er  WHERE er.song_id = s.song_id AND er.raport_id = '$raport_id'");
      if(!$query) throw new Exception($db_connect->error);
      
      echo '<h2>'.$raport_name.'</h2>';
      echo '<h3>'.$raport_month.' '.$raport_year.'</h3>';
      echo '
      <table class="table">
        <tr>
          <th>L.p.</th>
          <th>Tytuł</th>
          <th>kod ISRC</th>
          <th>Kompozytor</th>
          <th>Autor</th>
          <th>Autor opracowania</th>
          <th>Czas trwania [s]</th>
          <th>Ilość wyświetleń</th>
        </tr>';

      if ($query->num_rows > 0) {
        $counter = 1;
        while($row = $query->fetch_assoc() ) {
          echo '
            <tr>
              <td>'.$counter.'</td>
              <td>'.$row["title"].'</td>
              <td>'.$row["iscr"].'</td>
              <td>'.$row["composer"].'</td>
              <td>'.$row["author"].'</td>
              <td>'.$row["sauthor"].'</td>
              <td>'.$row["duration"].'</td>
              <td>'.$row["count"].'</td>';
          $counter++;
        }}
    $db_connect->close();
    // header('Location: raports.php');
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
  <title>Podgląd raportu</title>
</head>
<body>
</body>
</html>