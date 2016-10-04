<?php
session_start(); //Start The  session

session_unset(); // unset the Data

session_destroy(); //Destroy th session

header('location: index.php');

exit();

 ?>
