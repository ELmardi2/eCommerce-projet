<?php
session_start();
if (isset($_SESSION['username'])) {
  echo "welcome" . $_SESSION['username'];
    //  header('location: home.php');//redirect to page page
}else {
  header('location: index.php');
  exit();
}
