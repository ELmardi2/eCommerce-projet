<?php
  /*
  ==Manage members page gere (gere les members)
  == You can Add[Edit] Delete Members from here(vous pouvez ajouter[modéfier] Effacer les Members d'ici)
  */
  session_start();
  $pageTitle = 'Members';
  //$nonavbar = '';
  //print_r($_SESSION);
if (isset($_SESSION['username'])) {

  include ('init.php');

$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

  //Start Manage page(commence guestion page)
  if ($do == 'Manage') {//Manage page (gere page)


  }elseif ($do == 'Edit') {  //Edit page (modéfie page)


//: check if  userID is numeric and get his integer value:::::::
    /*if(isset($_GET['userID']) && is_numeric($_GET['userID'])) {echo intval($_GET['userID']);}else {  echo 0;}*/
    $userID = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0;


    //SELECT user depend on userID
    //check if user exist
    $stmt = $con->prepare("SELECT * FROM users WHERE userID = ? LIMIT 1");

    //execute query
    $stmt->execute(array($userID));

    //fetch the data
    $row = $stmt->fetch();

    //check changes in row count
    $count = $stmt->rowCount();

    //check if there is such ID show the form
    if ($stmt->rowCount() > 0) { ?>

              <h1 class="text-center"> Edit Members</h1>

              <div class="container">
                <form class="form-horizontal" action="?do=Update" method="POST">
                  <input type="hidden" name="userID" value="<?php echo $userID ?>">
                  <!--Start username field-->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-lebel">username</label>
                    <div class="col-sm-10 col-md-4">
                      <input type="text" name="username" value="<?php echo $row['username']; ?>" class="form-control" autocomplete="off" required="required">
                    </div>
                  </div>
                  <!--End username field-->
                  <!--Start password field-->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-lebel">password</label>
                    <div class="col-sm-10 col-md-4">
                      <input type="hidden" name="oldpassword" value="<?php echo $row['password']; ?>" >
                        <input type="password" name="newpassword" class="form-control" autocomplete="new-password" required="required">
                    </div>
                  </div>
                  <!--End password field-->
                  <!--Start e-mail field-->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-lebel">E-mail</label>
                    <div class="col-sm-10 col-md-4">
                      <input type="email" name="Email"  value="<?php echo $row['Email']; ?>" class="form-control" required="required">
                    </div>
                  </div>
                  <!--End e-mail field-->
                  <!--Start fullname field-->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-lebel">full name</label>
                    <div class="col-sm-10 col-md-4">
                      <input type="text" name="fullname"  value="<?php echo $row['fullname']; ?>" class="form-control">
                    </div>
                  </div>
                  <!--End fullname field-->
                  <!--Start buttom field-->
                  <div class="form-group form-group-lg">
                    <div class="col-sm-offset-2 col-sm-10">
                      <input type="submit" value="Save" class="btn btn-primary btn-lg">
                    </div>
                  </div>
                  <!--End buttom field-->
                </form>
              </div>

  <?php

  // else show error message
}else {
  echo "Oops there is no such ID with this name";
}
}elseif ($do == 'Update') {
  echo "<h1 class='text-center'> Update Members</h1>";
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Get variables from form
    $id   = $_POST['userID'];
    $user = $_POST['username'];
    $email = $_POST['Email'];
    $name = $_POST['fullname'];

    //password trich
    $pass =  empty($_POST['newpassword']) ?  $_POST['oldpassword'] : sha1($_POST['newpassword']);

    //check form before
    $formerrors = array();
    if (strlen($user) < 4) {
      $formerrors[] = "<div class='alert alert-danger'> user can't be less than <strong>4</strong>charecters</div>";
    }
    if (empty($user)) {
      $formerrors[] ="<div class='alert alert-danger'> user request <strong>obigation</strong> </div>";
    }
    if (empty($email)) {
      $formerrors[] = " <div class='alert alert-danger'> Email <strong>obigation</strong> </div>";
    }
    if (empty($name)) {
      $formerrors[] = " <div class='alert alert-danger'> Name is requested </div>";
    }
    foreach ($formerrors as $error) {
      echo $error;
    }
    //chech if there is no errors proced the data base
    if (empty($error)) {
      //Update the data base with these formation
      $stmt = $conn->prepare("UPDATE users SET username = ?, Email = ?, fullname = ? WHERE userID = ?, pass = ?");
      $stmt->execute(array($user, $email, $name, $id, $pass));

      //echo success message
      echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'record Updated</div>';

    }

  }else {
    echo "sorry you cannot browse this page";
  }
}

   include $tpl . "footer.php";
}else {

  header('location: index.php');

  exit();
}


 ?>
