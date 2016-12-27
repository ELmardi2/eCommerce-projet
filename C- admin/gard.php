<?php
//La pour savoir comment "post" peux envoyer
  session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $firstname	= $_POST['firstname'];
        $lastname	= $_POST['lastname'];
        $username	= $_POST['username'];
        $email		= $_POST['E-mail'];
        $password	= $_POST['password'];

        echo $firstname . "<br>";
          echo $lastname . "<br>";
            echo $username . "<br>";
              echo $email . "<br>";
                echo $password . "<br>";
  }else {
    echo " Error: You can't browse this page directly";
  }
 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>connexion</title>
   </head>
   <body>
     <h2>Bienvenue sur la site de  connexion</h2>
     <form class="form" action="lonig.php" method="POST">
       <input type="text" name="prénom" value="" placeholder="votre Nom ici"><br>
        <input type="text" name="E-mail" value="" placeholder="votre E-mail ici"><br>
         <input type="password" name="mdpass" value="" placeholder="votre Mot de pass ici"><br>
         <input type="submit" name="connectez-vous" value="connectez-vous">
     </form>
     <br><br><br><br>
     <h2>Welcome to login form</h2>
     <form class="form" action="login.php" method="POST">
        <input type="text" name="firstname" value="" placeholder="type your firstname here"><br>
         <input type="text" name="lastname" value="" placeholder="type your lastname here"><br>
       <input type="text" name="username" value="" placeholder="type your name here"><br>
        <input type="text" name="E-mail" value="" placeholder="your E-mail here"><br>
         <input type="password" name="password" value="" placeholder="type your password"><br>
         <input type="submit" name="login" value="log in">
     </form>
   </body>
 </html>



<?php






include('conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


  $user = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

        $sql = "SELECT * FROM users WHERE name='$user' and password='$password'";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $active = $row['name'];


        $count = mysqli_num_rows($result);

        if ($count == 1) {
            $sql_1 = "INSERT INTO checkin (name) VALUES ('$active')";
            $result_1 = mysqli_query($db, $sql_1);

           echo "hello";
        } else {
            $error = 'Your Login Name or Password is invalid or you are already enter today';
        }
}
