<?php

ob_start();
  session_start();
  //print_r($_SESSION);
if (isset($_SESSION['username'])) {
  $pageTitle = 'Home';

  include ('init.php');

//echo "Welcome to(Bienvenue)";
$numtUsers = 6;  //number of last users
 $latestUser = getLatest('*', 'users', 'userID', $numtUsers);

 $numItems = 6;  //Number of last Items
 $latestItems = getLatest('*', 'items', 'item_ID', $numItems);

 $numComments = 4;  //Number of last Comments
  $latestComments = getLatest('*', 'comments', 'C_ID', $numComments);
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
              <i class="fa fa-users"></i>
              <div class="info">
                Total Members
                <span><a href="members.php"><?php echo countItem('userID', 'users') ?></a></span>
              </div>
            </div>
      </div>
      <div class="col-md-3">
        <div class="stat st-pending">
        <i class="fa fa-user-plus"></i>
            <div class="info">
              Pending Members
              <span> <a href="members.php?do=Manage&page=Pending"><?php echo checkItem('RegStatus', 'users', 0) ?></a></span>
            </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat st-items">
        <i class="fa fa-tag"></i>
              <div class="info">
                Total Items
                <span><a href="items.php"><?php echo countItem('item_ID', 'items') ?></a></span>
              </div>
              </div>
      </div>
      <div class="col-md-3">
        <div class="stat st-comment">
        <i class="fa fa-comment"></i>
            <div class="info">
              Total Comments
              <span><a href="comments.php"><?php echo countItem('C_ID', 'comments') ?></span>
            </div>
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
            <i class="fa fa-users"></i>Latest   <?php echo $numtUsers ?> registered users
            <span class=" toggle-info pull-right">
              <i class="fa fa-plus fa-lg"></i>
            </span>
          </div>
          <div class="panel-body">
               <ul class='list-unstyled latest-user'>
                <?php
                if (! empty($latestUser)) {
                  foreach ($latestUser as $user) {
                      echo   "<li>";
                            echo   $user['username'];
                                   echo "<a href='members.php?do=Edit&userID=" . $user['userID'] . "'";
                                       echo "<span class='btn btn-success pull-right'>";
                               echo "<i class='fa fa-edit'></i> Edit";
                               if ($user['RegStatus'] == 0) {
                             echo "<a href='members.php?do=Activate&userID=" . $user['userID'] . "'
                              class='btn btn-info pull-right activate'><i class='fa fa-hand-pointer-o'></i>Activate</a>";
                               }
                           echo "</span>";
                        echo "</a>";
                      echo "</li>";
                     }
                     }else{
                       echo "There is No User To Show";
                     }
                 ?>
           </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="panel panel-default">
          <div class="panel panel-heading">
            <i class="fa fa-tag"></i>latest <?php echo $numItems ?> Items
            <span class=" toggle-info pull-right">
              <i class="fa fa-plus fa-lg"></i>
            </span>
          </div>
          <div class="panel-body">
            <ul class='list-unstyled latest-user'>
             <?php
             if (! empty($latestItems)) {
               foreach ($latestItems as $item) {
                   echo   "<li>";
                         echo   $item['name'];
                                echo "<a href='items.php?do=Edit&item_ID=" . $item['item_ID'] . "'";
                                    echo "<span class='btn btn-success pull-right'>";
                            echo "<i class='fa fa-edit'></i> Edit";
                            if ($item['Approve'] == 0) {
                          echo "<a href='items.php?do=Approve&item_ID=" . $item['item_ID'] . "'
                           class='btn btn-info pull-right activate'><i class='fa fa-check'></i>Approve</a>";
                            }
                        echo "</span>";
                     echo "</a>";
                   echo "</li>";
                  }
                }else {
                  echo "There is No Items To Show";
                }
              ?>
        </ul>
          </div>
        </div>
      </div>
    </div>
      <!--Start row Comments-->
    <div class="row">
      <div class="col-sm-6">
        <div class="panel panel-default">
          <div class="panel panel-heading">
            <i class="fa fa-comments-o"></i>Latest <?php echo $numComments ?> comments
            <span class=" toggle-info pull-right">
              <i class="fa fa-plus fa-lg"></i>
            </span>
          </div>
          <div class="panel-body">
            <?php
            $stmt = $con ->prepare("SELECT comments.*,users.username AS member
                                    FROM
                                        comments
                                    INNER JOIN
                                        users
                                    ON
                                    users.userID = comments.user_ID
                                    ORDER BY C_ID DESC
                                    LIMIT $numComments");
            //execute the stmt
            $stmt->execute();
            //asign all data in variables
            $comments = $stmt->fetchAll();
            if (! empty($comments)) {
                foreach ($comments as $comment) {
                  echo "<div class='comment-box'>";
                  echo '<span class="member-n"><a href="members.php?do=Add&userID="></a>' . $comment['user_ID'] . "</span>";
                  echo '<p class="member-c">' . $comment['comment'] . "</p>";
                  echo "</div>";
                }
            }else {
              echo "There is No Comments To Show";
            }
             ?>
          </div>
        </div>
      </div>
    </div>
    <!--End row Comments-->
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
