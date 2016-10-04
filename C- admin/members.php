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


  }elseif ($do == 'Edit') {  //Edit page (modéfie page)?>

<h1 class="text-center"> Edit Members</h1>

<div class="container">
  <form class="form-horizontal">
    <!--Start username field-->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-lebel">username</label>
      <div class="col-sm-10 col-md-4">
        <input type="text" name="username" class="form-control" autocomplete="off">
      </div>
    </div>
    <!--End username field-->
    <!--Start password field-->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-lebel">password</label>
      <div class="col-sm-10 col-md-4">
        <input type="password" name="password" class="form-control" autocomplete="new-password">
      </div>
    </div>
    <!--End password field-->
    <!--Start e-mail field-->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-lebel">E-mail</label>
      <div class="col-sm-10 col-md-4">
        <input type="email" name="E-mai" class="form-control">
      </div>
    </div>
    <!--End e-mail field-->
    <!--Start fullname field-->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-lebel">full name</label>
      <div class="col-sm-10 col-md-4">
        <input type="text" name="full" class="form-control">
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

  <?php }
   include $tpl . "footer.php";
}else {

  header('location: index.php');

  exit();
}


 ?>
