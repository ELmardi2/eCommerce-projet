<?php

include 'init.php';
include $tpl. "header.php";
include 'include/languages/en.php';

//for control login allow only post method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['user'];
  $password = $_POST['pass'];
  $hashedpass = sha1($password);


  //check if user exist
  $stmt =$con->prepare("SELECT username, password FROM users WHERE username = ? AND password = ?");
  $stmt->execute(array($username, $hashedpass));
  $count = $stmt->rowCount();
  //check count if > 0 mean the user is admin or have an special resourcebundle_get_error_code
  if ($count > 0) {
    echo "Bienvenue" . "Welcome" . $username;
  }else {
    echo "vous normale utilisateur";
  }
}

 ?>


 <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
   <h3 class="text-center">Admin login</h3>
   <input class="form-control" type="text" name="user" placeholder="username" autocomplete="off">
   <input class="form-control" type="password" name="pass" placeholder="password" autocomplete="new-password">
   <input class="btn btn-primary btn-block" type="submit" value="login">
 </form>
 <?php
 include $tpl . "footer.php";
  ?>
