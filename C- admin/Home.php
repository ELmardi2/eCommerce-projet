<?php
session_start();
if (isset($_SESSION['user'])) {
echo "Bienvenue" . $_SESSION['user'];
}else {
header('location:index.php');}
 ?>
