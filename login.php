<?php
  session_start();
  if(!isset($_POST['login']) || !isset($_POST['password'])) {
    header('Location: index.php');
    exit();
  }

  require_once "connect.php";

  $db_connect = @new mysqli($host, $db_user, $db_password, $db_name);
  if($db_connect->connect_errno!=0) {
    echo "Error:".$db_connect->connect_errno;
  } else {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // prevent SQLInjection
    $login = htmlentities($login, ENT_QUOTES, "UTF-8");

    if($result = @$db_connect->query(
      sprintf("SELECT * FROM users WHERE user='%s'",
      mysqli_real_escape_string($db_connect, $login)))) {
      $exist = $result->num_rows;
      if($exist > 0) {
        $row = $result->fetch_assoc();
        if(password_verify($password, $row['password'])) {
          $_SESSION['loggedIn'] = true;

          $_SESSION['user_id'] = $row['user_id'];
          $_SESSION['user'] = $row['user'];
          $_SESSION['email'] = $row['email'];
          // user data from database

          unset($_SESSION['blad']);
          $result->close();
          header('Location: raports.php');
        } else {
          $_SESSION['blad']='<span style="color:red">Nieprawidłowy login lub hasło!</span>';
          header('location: index.php');
        }
      } else {
        $_SESSION['blad']='<span style="color:red">Nieprawidłowy login lub hasło!</span>';
        header('location: index.php');
      }
    }
    $db_connect->close();
  }
?>