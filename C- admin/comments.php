<?php
  /*
  ==Manage Comments  page gere (gerer Comments)
  == You can [Edit] Delete comment from here(vous pouvez ajouter[modéfier] Effacer les Members d'ici)
  */
  session_start();
  $pageTitle = 'Comments';
  //$nonavbar = '';
  //print_r($_SESSION);
if (isset($_SESSION['username'])) {

  include ('init.php');

$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

  //Start Manage page(commence guestion page)
  if ($do == 'Manage') {//Manage  Comments page (gestion page)
    //select users except Admins
    $stmt = $con ->prepare("SELECT comments.*,items.name AS item_name,users.username AS member
                            FROM
                                comments
                           INNER JOIN
                                items
                           ON
                                items.item_ID = comments.item_ID
                            INNER JOIN
                                users
                            ON
                            users.userID = comments.user_ID
                            ORDER BY C_ID DESC
                            ");
    //execute the stmt
    $stmt->execute();
    //asign all data in variables
    $comments = $stmt->fetchAll();
    if(! empty($comments)){
    ?>
      <h1 class="text-center"> Manage Comments</h1>
      <div class="container">
        <div class="table-responsive">
          <table class="main-table text-center table table-bordered">
            <tr>
              <td>ID</td>
              <td>Comment</td>
              <td>Item Name</td>
              <td>User name</td>
              <td>Add Date</td>
              <td>Control</td>
            </tr>
          <?php foreach ($comments as $comment){
            echo "<tr>";
            echo "<td>" . $comment['C_ID'] . "</td>";
            echo "<td>" . $comment['comment'] . "</td>";
            echo "<td>" . $comment['item_name'] . "</td>";
            echo "<td>" . $comment['member'] . "</td>";
            echo "<td>" . $comment['comment_Date'] . "</td>";
            echo "<td>
            <a href='comments.php?do=Edit&commID=" . $comment['C_ID'] . "'  class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
            <a href='comments.php?do=Delete&commID=" . $comment['C_ID'] . "'  class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
            if ($comment['status'] == 0) {
          echo "<a href='comments.php?do=Approve&commID=" . $comment['C_ID'] . "'
          class='btn btn-info activate'><i class='fa fa-check'></i>Approve</a>";
            }
            echo  "</td>";
            echo "</tr>";
          }
             ?>
          </table>
        </div>
      </div>
      <?php }else{
        echo "<div class='container'>";
          echo "<div class='alert alert-info nice-msg'>There Is No members To Show</div>";
          echo "</div>";
      } ?>

  <?php }elseif ($do == 'Edit') {        //Edit page (modéfie page)

    $commID = isset($_GET['commID']) && is_numeric($_GET['commID']) ? intval($_GET['commID']) : 0;


    //SELECT user depend on userID
    //check if user exist
    $stmt = $con->prepare("SELECT * FROM comments WHERE C_ID = ? ");

    //execute query
    $stmt->execute(array($commID));

    //fetch the data
    $row = $stmt->fetch();

    //check changes in row count
    $count = $stmt->rowCount();


    //check if there is such ID show the form
    if ($count > 0) { ?>

              <h1 class="text-center"> Edit Comment</h1>
              <div class="container">
                <form class="form-horizontal" action="?do=Update" method="POST">
                  <input type="hidden" name="commID" value="<?php echo $commID ?>">
                  <!--Start Comments field-->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-lebel">Comment</label>
                    <div class="col-sm-10 col-md-4">
                      <textarea class="form-control" name="comment"><?php echo $row['comment']; ?></textarea>
                    </div>
                  </div>
                  <!--End uComment field-->
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
  echo "<h1 class='text-center'> Update Comment</h1>";
  echo "<div class='container'>";
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Get variables from form
    $commID    = $_POST['commID'];
    $comment = $_POST['comment'];

      //Update the data base with these formation
      $stmt = $con->prepare("UPDATE comments SET comment = ? WHERE C_ID = ?");
      $stmt->execute(array($comment, $commID));
        $stmt->rowCount();

      //echo success message
    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'record Updated</div>';
        RedirectHome($theMsg, 'back');


  }else {
    $theMsg = "<div class='alert alert-danger'>sorry you cannot browse this page directly</div>";
      RedirectHome($theMsg);
  }
  echo "</div>";
}elseif ($do == 'Delete') {
  //Delete page
echo  '<h1 class="text-center"> Delete Comment</h1>';
echo  '<div class="container">';
          //echo "Welcome to Delete page";

          $commID = isset($_GET['commID']) && is_numeric($_GET['commID']) ? intval($_GET['commID']) : 0;


          //SELECT user depend on userID
          $check = checkItem('C_ID', 'comments', $commID);

          //check if there is such ID show the form
          if ($check > 0) {

          $stmt = $con->prepare("DELETE FROM comments WHERE C_ID = :zcommID");

          $stmt->bindParam(':zcommID', $commID);

          $stmt->execute();
          $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'record Deleted</div>';
          RedirectHome($theMsg, 'back');
          }else {
            $theMsg =  "<div class='alert alert-danger'> Non! cet ID n'est pas exist</div>";
                RedirectHome($theMsg);
          }
            echo "</div>";
        }elseif ($do = 'Approve') {
          //echo "Bienvenue à l'Activate page";

          //Activate page
        echo  '<h1 class="text-center"> Approve Comment</h1>';
        echo  '<div class="container">';
                  //echo "Welcome to Delete page";

                  $commID = isset($_GET['commID']) && is_numeric($_GET['commID']) ? intval($_GET['commID']) : 0;


                  //SELECT user depend on userID
                  $check = checkItem('C_ID', 'comments', $commID);

                  //check if there is such ID show the form
                  if ($check > 0) {

                  $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE C_ID = ?");

                  $stmt->execute(array($commID));
                  $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'record Approved</div>';
                  RedirectHome($theMsg, 'back');
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
