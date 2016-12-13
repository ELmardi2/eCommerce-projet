<?php

ob_start();
  session_start();
  //print_r($_SESSION);
if (isset($_SESSION['username'])) {
  $pageTitle = 'Home';

  include ('init.php');

//echo "Welcome(Bienvenue)";
$latestUser = 6;
 $latestUser = getLatest('*', 'users', 'userID', $latestUser);

/* Start Homepage*/
$stmtB = $con->prepare("SELECT COUNT(userID) FROM users");
$stmtB->execute();
//echo  $stmtB->fetchColumn();
?>
<div class="home-stats">
  <div class="container text-center">
    <h1>Home page</h1>
    <div class="row">
          <div class="col-md-3">
            <div class="stat st-members">
              Total Members
              <span><a href="members.php"><?php echo countItem('userID', 'users') ?></a></span>
            </div>
      </div>
      <div class="col-md-3">
        <div class="stat st-pending">
          Pending Members
          <span> <a href="members.php?do=Manage&page=Pending"><?php echo checkItem('RegStatus', 'users', 0) ?></a></span>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat st-items">
          Total Items
          <span>1234</span>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat st-comment">
          Total Comments
          <span>2341</span>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="latest">
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <div class="panel panel-default">
          <div class="panel panel-heading">
            <i class="fa fa-users"></i>Latest   <?php echo $latestUser ?> registered users
          </div>
          <div class="panel-body">
               <ul class='list-unstyled latest-user'>
                <?php
                  foreach ($latestUser as $user) {
                      echo   "<li>";
                            echo   $user['username'];
                                   echo "<a href='members.php?do=Edit&userID=" . $user['userID'] . "'";
                                       echo "<span class='btn btn-success pull-right'>";
                               echo "<i class='fa fa-edit'></i> Edit";
                               if ($user['RegStatus'] == 0) {
                             echo "<a href='members.php?do=Activate&userID=" . $user[userID] . "'  class='btn btn-info pull-right activate'><i class='fa fa-hand-pointer-o'></i>Activate</a>";
                               }
                           echo "</span>";
                        echo "</a>";
                      echo "</li>";
                     }
                 ?>
           </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="panel panel-default">
          <div class="panel panel-heading">
            <i class="fa fa-tag"></i>latest Items
          </div>
          <div class="panel-body">
            test
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
/* End Homepage*/

   include $tpl . "footer.php";
}else {

  header('location: index.php');

  exit();
}
ob_end_flush();
