<?php
  session_start();

  //print_r($_SESSION);
if (isset($_SESSION['username'])) {
  //$pageTitle = 'Home';

  include ('init.php');

print_r($_SESSION);

   include $tpl . "footer.php";
}else {

  header('location: index.php');

  exit();
}
