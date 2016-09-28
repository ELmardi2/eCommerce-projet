<?php

include 'init.php';
include $tpl. "header.php";
include 'include/languages/en.php';
 ?>
 <form class="login" action="" method="post">
   <input class="form-control" type="text" name="user" placeholder="username" autocomplete="off">
   <input class="form-control" type="password" name="pass"placeholder="password" autocomplete="new-password">
   <input class="btn btn-primary btn-block" type="submit" name="" value="login">
 </form>
 <?php
 include $tpl . "footer.php";
  ?>
