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
  if ($do == 'Manage') {//Manage page (gestion page)

    $query = '';
    if (isset($_GET['page']) && $_GET['page'] == 'Pending') {
      $query = 'AND RegStatus = 0';
    }
    //select users except Admins
    $stmt = $con ->prepare("SELECT * FROM users WHERE GroupID != 1   $query ORDER BY userID DESC
    ");
    //execute the stmt
    $stmt->execute();
    //asign all data in variables
    $rows = $stmt->fetchAll();
    if (! empty($rows)) {

    ?>
      <h1 class="text-center"> Manage Members</h1>
      <div class="container">
        <div class="table-responsive">
          <table class="main-table text-center table table-bordered">
            <tr>
              <td>#ID</td>
              <td>Username</td>
              <td>Email</td>
              <td>Fullname</td>
              <td>Registered Date</td>
              <td>Control</td>
            </tr>
          <?php foreach ($rows as $row){
            echo "<tr>";
            echo "<td>" . $row['userID'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['Email'] . "</td>";
            echo "<td>" . $row['fullname'] . "</td>";
            echo "<td>" . $row['Date'] . "</td>";
            echo "<td>
            <a href='members.php?do=Edit&userID=" . $row['userID'] . "'  class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
            <a href='members.php?do=Delete&userID=" . $row['userID'] . "'  class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
            if ($row['RegStatus'] == 0) {
          echo "<a href='members.php?do=Activate&userID=" . $row['userID'] . "'
          class='btn btn-info activate'><i class='fa fa-hand-pointer-o'></i>Activate</a>";
            }
            echo  "</td>";
            echo "</tr>";
          }
            ?>
          </table>
        </div>
        <a href='members.php?do=Add' class="btn btn-primary"><i class="fa fa-plus"></i>Add new Member</a>
      </div>

      <?php }else{
        echo "<div class='container'>";
          echo "<div class='alert alert-info nice-msg'>There Is No members To Show</div>";
        echo "<a href='members.php?do=Add' class='tn btn-primary'><i class='fa fa-plus'></i>Add new Member</a>";
        echo "</div>";
      }

     }elseif($do == 'Add') {
    ?>
      <h1 class="text-center"> Add new Member</h1>
      <div class="container">
        <form class="form-horizontal" action="?do=insert" method="POST">
          <!--Start username field-->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-lebel">username</label>
            <div class="col-sm-10 col-md-4">
              <input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="">
            </div>
          </div>
          <!--End username field-->
          <!--Start password field-->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-lebel">password</label>
            <div class="col-sm-10 col-md-4">
                <input type="password" name="password" class=" password form-control" required="required" placeholder="">
                <i class="show-pass fa fa-eye fa-2x"></i>
            </div>
          </div>
          <!--End password field-->
          <!--Start e-mail field-->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-lebel">E-mail</label>
            <div class="col-sm-10 col-md-4">
              <input type="email" name="Email" class="form-control" required="required" placeholder="">
            </div>
          </div>
          <!--End e-mail field-->
          <!--Start fullname field-->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-lebel">full name</label>
            <div class="col-sm-10 col-md-4">
              <input type="text" name="fullname" class="form-control"required="required" placeholder="">
            </div>
          </div>
          <!--End fullname field-->
          <!--Start buttom field-->
          <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10">
              <input type="submit" value="Add member" class="btn btn-primary btn-lg">
            </div>
          </div>
          <!--End buttom field-->
        </form>
      </div>

<?php
}elseif ($do == 'insert') {

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  echo "<h1 class='text-center'> insert Members</h1>";
  echo "<div class='container'>";
    //Get variables from form
    $user  = $_POST['username'];
    $pass  = $_POST['password'];
    $email = $_POST['Email'];
    $name  = $_POST['fullname'];
    $hashpass = sha1($_POST['password']);

    //check validate form before
    $formerrors = array();
    if (strlen($user) < 4) {
      $formerrors[] = " user can't be less than <strong>4</strong>charecters";
    }
    if (empty($user)) {
      $formerrors[] =" user request <strong>obigation</strong> ";
    }
    if (empty($pass)) {
      $formerrors[] =" password request <strong>obigation</strong> ";
    }
    if (empty($email)) {
      $formerrors[] = " Email <strong>obigation</strong> ";
    }
    if (empty($name)) {
      $formerrors[] = " Name is requested ";
    }
    foreach ($formerrors as $error) {
      echo "<div class='alert alert-danger'>" . $error . "</div>";
    }
    //chech if there is no errors proced the data base
    if (empty($error)) {    //Insert thes info to data base
      //check if user exist in the data base
      $check = checkItem('username', 'users', $user);
      if ($check == 1) {
        echo "<div class='container'>";
      $theMsg = "<div class='alert alert-danger'>Sorry this user  is already exist</div>";
      RedirectHome($theMsg, 'back', 7);
      echo "</div>";
      }else {

      $stmt = $con->prepare("INSERT INTO users(username, password, Email, fullname, RegStatus, Date)
VALUES(:zuser, :zpass, :zmail, :zname, 1, now())");
        $stmt->execute(array(
          'zuser'  =>$user,
          'zpass'  =>$hashpass,
          'zmail'  =>$email,
          'zname'  =>$name
        ));
      //echo success message
      echo "<div class='container'>";
      $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " record Inserted</div>";
          RedirectHome($theMsg, 'back');
          echo "</div>";
  }
    }


  }else {
    echo "<div class='container'>";
  $theMsg = "<div class='alert alert-danger'>sorry you cannot browse this page directly</div>";
  RedirectHome($theMsg);
  echo "</div>";
  }
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
    if ($count > 0) { ?>

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
}else {
  // else show error message

  echo "<div class='container'>";
  $theMsg = "<div class='alert alert-danger'>Oops there is no such ID with this name</div>";
      RedirectHome($theMsg);
      echo "</div>";
}
}elseif ($do == 'Update') {

  //Update page
  echo "<h1 class='text-center'> Update Members</h1>";
  echo "<div class='container'>";
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
      $formerrors[] = " user can't be less than <strong>4</strong>charecters";
    }
    if (empty($user)) {
      $formerrors[] = "user request <strong>obligation</strong> ";
    }
    if (empty($pass)) {
      $formerrors[] ="Password request <strong>obligation</strong> ";
    }
    if (empty($email)) {
      $formerrors[] = " Email <strong>obligation</strong> ";
    }
    if (empty($name)) {
      $formerrors[] = " Name is requested ";
    }
    foreach ($formerrors as $error) {
      echo  " <div class='alert alert-danger'>" . $error . "</div>";
    }
    //chech if there is no errors proced the data base
    if (empty($error)) {
      $stmtB = $con->prepare("SELECT *
                            FROM users
                            WHERE username = ?
                             AND userID  != ?");
      $stmtB->execute(array($user, $id));
      $count = $stmtB->rowCount();
      if ($count == 1) {
       echo "<div class='alert alert-info'>Sorry this user is already exist</div>";
        RedirectHome($theMsg, 'back');
     }else{
       //Update the data base with these formation
       $stmt = $con->prepare("UPDATE users SET username = ?, Email = ?, fullname = ?, pass= ?, userID= ? ");
       $stmt->execute(array($user, $email, $name, $pass, $id));
       $count =  $stmtB->rowCount();
       //echo success message
     $theMsg = "<div class='alert alert-success'>" . $count . 'record Updated</div>';
         RedirectHome($theMsg, 'back');
     }
   }

  }else {
    $theMsg = "<div class='alert alert-danger'>Sorry You Cannot Browse This Page Directly</div>";
      RedirectHome($theMsg);
  }
  echo "</div>";
}elseif ($do == 'Delete') {
  //Delete page
echo  '<h1 class="text-center"> Delete Members</h1>';
echo  '<div class="container">';
          //echo "Welcome to Delete page";

          $userID = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0;


          //SELECT user depend on userID
          $check = checkItem('userID', 'users', $userID);

          //check if there is such ID show the form
          if ($check > 0) {

          $stmt = $con->prepare("DELETE FROM users WHERE userID = :zuser");

          $stmt->bindParam(':zuser', $userID);

          $stmt->execute();
          $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Member Deleted</div>';
          RedirectHome($theMsg, 'back');
          }else {
            $theMsg =  "<div class='alert alert-danger'> Non! cet ID n'est pas exist</div>";
                RedirectHome($theMsg);
          }
            echo "</div>";
        }elseif ($do = 'Activat') {
          //echo "Bienvenue à l'Activate page";

          //Activate page
        echo  '<h1 class="text-center"> Activate Pending</h1>';
        echo  '<div class="container">';
                  //echo "Welcome to Delete page";

                  $userID = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0;


                  //SELECT user depend on userID
                  $check = checkItem('userID', 'users', $userID);

                  //check if there is such ID show the form
                  if ($check > 0) {

                  $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE userID = ?");

                  $stmt->execute(array($userID));
                  $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'record Activated</div>';
                  RedirectHome($theMsg);
        }else {
          $theMsg = "<div class='alert alert-danger'>sorry you cannot browse this page directly</div>";
            RedirectHome($theMsg);
        }
}
   include $tpl . "footer.php";
}else {

  header('location: index.php');

  exit();
}


 ?>
