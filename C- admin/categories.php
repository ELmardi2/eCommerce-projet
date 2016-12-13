<?php
/*
==categories page
== You can Add[Edit] Delete Categories from here(vous pouvez ajouter[modéfier] Effacer les Members d'ici)
*/
ob_start();
session_start();
$pageTitle = 'Categories';

if (isset($_SESSION['username'])) {

      include ('init.php');

      $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

//Start Categories page
if ($do == 'Manage') {
  $stmtA = $con->prepare("SELECT * FROM categories");
  $stmtA->execute();
  $cats = $stmtA->fetchAll(); ?>
  <h1 class="text-center">Manage Categories</h1>
  <div class="container category">
    <div class="panel panel-default">
      <div class="panel-heading"> Manage Categories</div>
        <div class="panel-body">
          <?php
          foreach ($cats as $cat) {
            echo "<div class='cat'>";
            echo "<h3>" . $cat['name'] . "</h3>";
              echo "<p>";if ($cat['description'] == '') {echo "there is no description for this category";
              }else {echo $cat['description'];} echo "</p>";
                if ( $cat['visibility'] == 1) { echo "<span class='visibility'>Hidden</span>";}
                if ( $cat['comment'] == 0) { echo "<span class='commenting'>comment disable</span>";}
                if (  $cat['adv'] == 0) { echo "<span class='advertises'>Ads disable</span>";}
                  echo "</div>";
              echo "<hr>";
          }
           ?>
        </div>
    </div>
  </div>

  <?php

}elseif($do == 'Add') {   ?>

  <h1 class="text-center"> Add new Category</h1>
  <div class="container">
    <form class="form-horizontal" action="?do=insert" method="POST">
      <!--Start uname field-->
      <div class="form-group form-group-lg">
        <label class="col-sm-2 control-lebel">Name</label>
        <div class="col-sm-10 col-md-4">
          <input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Name of the category">
        </div>
      </div>
      <!--End name field-->
      <!--Start password field-->
      <div class="form-group form-group-lg">
        <label class="col-sm-2 control-lebel">Description</label>
        <div class="col-sm-10 col-md-4">
            <input type="text" name="description" class="  form-control" placeholder="describe the category">
        </div>
      </div>
      <!--End description field-->
      <!--Start Ordering field-->
      <div class="form-group form-group-lg">
        <label class="col-sm-2 control-lebel">Ordering</label>
        <div class="col-sm-10 col-md-4">
          <input type="text" name="ordering" class="form-control" placeholder="Number to arrange the category">
        </div>
      </div>
      <!--End Ordering field-->
      <!--Start visibility field-->
      <div class="form-group form-group-lg">
        <label class="col-sm-2 control-lebel">Visible</label>
        <div class="col-sm-10 col-md-6">
          <div>
            <input id="vis-yes" type="radio" name="visibility" value="0" checked />
            <label for="vis-yes">Yes</label>
          </div>
          <div>
            <input id="vis-no" type="radio" name="visibility" value="1" />
            <label for="vis-no">No</label>
          </div>
        </div>
      </div>
      <!--End visibility field-->
      <!--Start visibility field-->
      <div class="form-group form-group-lg">
        <label class="col-sm-2 control-lebel"> Allow Comment</label>
        <div class="col-sm-10 col-md-6">
          <div>
            <input id="vis-yes" type="radio" name="comment" value="0" checked />
            <label for="vis-yes">Yes</label>
          </div>
          <div>
            <input id="com-no" type="radio" name="comment" value="1" />
            <label for="com-no">No</label>
          </div>
        </div>
      </div>
      <!--End comments field-->
      <!--Start Ads field-->
      <div class="form-group form-group-lg">
        <label class="col-sm-2 control-lebel">Allow Ads</label>
        <div class="col-sm-10 col-md-6">
          <div>
            <input id="ads-yes" type="radio" name="ads" value="0" checked />
            <label for="ads-yes">Yes</label>
          </div>
          <div>
            <input id="ads-no" type="radio" name="ads" value="1" />
            <label for="ads-no">No</label>
          </div>
        </div>
      </div>
      <!--End Ads field-->
      <!--Start buttom field-->
      <div class="form-group form-group-lg">
        <div class="col-sm-offset-2 col-sm-10">
          <input type="submit" value="Add Category" class="btn btn-primary btn-lg">
        </div>
      </div>
      <!--End buttom field-->
    </form>
  </div>


  <?php

}elseif ($do == 'insert') {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    echo "<h1 class='text-center'> insert Category</h1>";
    echo "<div class='container'>";
    //Get variables from form
    $name    = $_POST['name'];
    $desc    = $_POST['description'];
    $order   = $_POST['ordering'];
    $visible = $_POST['visibility'];
    $comm    = $_POST['comment'];
    $advs    = $_POST['ads'];



        //check if Category exist in the data base
        $check = checkItem('name', 'categories', $name);
        if ($check == 1) {
          echo "<div class='container'>";
        $theMsg = "<div class='alert alert-danger'>Sorry this Category  is already exist</div>";
        RedirectHome($theMsg, 'back', 7);
        echo "</div>";
        }else{

          //Insert Category info into data base
        $stmtA = $con->prepare("INSERT INTO
          categories(name, description, ordering, visibility,
          allow_comment, allow_adv)
         VALUES(:zname, :zdescription, :zordering, :zvisibility, :zcomment, :zads)");


          $stmtA->execute(array(
            'zname'          =>$name,
            'zdescription'   =>$desc,
            'zordering'      =>$order,
            'zvisibility'    =>$visible,
            'zcomment'       =>$comm,
            'zads'           =>$advs
          ));
          $count = $stmtA->rowCount();
        //echo success message
        echo "<div class='container'>";
        $theMsg = "<div class='alert alert-success'>" . $count . " record Inserted</div>";
            RedirectHome($theMsg, 'back');
            echo "</div>";
    }
      }else {
      echo "<div class='container'>";
    $theMsg = "<div class='alert alert-danger'>sorry you cannot browse this page directly</div>";
    RedirectHome($theMsg, 'back', 7);
    echo "</div>";
    }
}elseif ($do == 'Edit') {

}elseif ($do == 'Update') {

}elseif ($do == 'Delete') {

      }

 include $tpl . "footer.php";
}else {

header('location: index.php');

exit();
}

ob_end_flush();
 ?>
