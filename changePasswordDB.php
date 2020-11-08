<?php
  session_start();
  if(!isset($_SESSION['loggedIn'])) {
    header('Location: index.php');
    exit();
  }

  if(!isset($_POST['password']) || !isset($_POST['new_password'])) {
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
      $password = $_POST['password'];
      $new_password = $_POST['new_password'];
      $user_id = $_SESSION['user_id'];

      $query = $db_connect->query("SELECT * from users WHERE user_id = '$user_id'");
      if(!$query) throw new Exception($db_connect->error);
        // echo 'Podano prawidłowe hasło';
      $row = $query->fetch_assoc();
      if(password_verify($password, $row['password'])) {
        //echo 'hasla sie zgadzaja';
        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

        if ($db_connect->query("UPDATE users SET password = '$new_password_hash' WHERE user_id = '$user_id'")) {
        echo 'Pomyślnie zmieniono hasło';
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