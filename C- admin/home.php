<?php
  session_start();
  //$nonavbar = '';
  //print_r($_SESSION);
if (isset($_SESSION['username'])) {

  //$pageTitle = 'Home';

  //echo "Bienvenue" . '...!!' . $_SESSION['username'];

  include ('init.php');

echo "Bienvenue";

   include $tpl . "footer.php";
}else {

  header('location: index.php');

  exit();
}
