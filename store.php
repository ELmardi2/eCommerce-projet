<?php
 session_start();
 $nonavbar = '';
if (isset($_SESSION['username'])) {
    header('location: home.php');  //:redirect to home page
}

include 'init.php';
include $tpl. "header.php";
include 'include/languages/en.php';

//for control login allow only post method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashedpass = sha1($password);
   //echo $username . '  ' . $password;
  //echo $hashedpass;
  $stmt = $con->prepare("SELECT username, password FROM users WHERE username = ? AND password = ? AND GroupID = 1");
  $stmt->execute(array($username, $hashedpass));
  $count = $stmt->rowCount();
  //echo $count;
  //check count if > 0  that mean the user is admin or have an special record in the data base
  if ($count > 0) {
    $_SESSION['username'] = $username; //register session name
    header('location:home.php');  //:redirect to home page
     exit();
    //echo "Bienvenue" . $username;
    //$_SESSION['user'] =  $username;


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
  <?php
  session_start();

  if(isset($_SESSION['username'])){

    echo "Bienvenue" . $_SESSION['username'];

  }else {
  //  echo "You are not authorised to view this page directly";

      header('location: index.php');  //:redirect to index  page

      exit();
  }
   ?>
