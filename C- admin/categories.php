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

  $sort = 'asc';
  $sort_array  = array('asc', 'desc');
  if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {
      $sort = $_GET['sort'];
  }
  $stmtA = $con->prepare("SELECT * FROM categories ORDER BY ordering $sort");

  $stmtA->execute();

  $cats = $stmtA->fetchAll(); ?>

  <h1 class="text-center">Manage Categories</h1>
  <div class="container category">
    <div class="panel panel-default">
      <div class="panel-heading">
        <i class="fa fa-edit"></i>Manage Categories
        <div class="option pull-right">
           <i class="fa fa-sort"></i>Ordering :[
          <a class="<?php if($sort == 'asc'){echo 'active';} ?>" href="?sort= asc">Asc</a>
          <a class="<?php if($sort == 'desc'){echo 'active';} ?>" href="?sort=desc">Desc</a>]
          <i class="fa fa-eye"></i>View :[
          <span class="active" data-view="full">Full</span>  |
          <span data-view="">Classic</span>]
        </div>
      </div>
        <div class="panel-body">
          <?php
          foreach ($cats as $cat) {
            echo "<div class='cat'>";
            echo "<div class='hidden-button'>";
            echo "<a href='categories.php?do=Edit&catID=" . $cat['ID'] . "' class='btn btn-primary'><i class='fa fa-edit'></i>Edit</a>";
            echo "<a href='categories.php?do=Delete&catID=" . $cat['ID'] . "' class=' confirm btn btn-danger'><i class='fa fa-close'></i>Delete</a>";
            echo "</div>";
            echo "<h3>" . $cat['name'] . "</h3>";
            echo "<div class='full-view'>";
              echo "<p>";if ($cat['description'] == '') {echo "there is no description for this category";
                  }else {echo $cat['description'];} echo "</p>";
                    if ( $cat['visibility'] == 1) { echo "<span class='visibility'><i class='fa fa-eye'></i>Hidden</span>";}
                    if ( $cat['comment'] == 1) { echo "<span class='commenting'><i class='fa fa-close'></i>comment disable</span>";}
                    if (  $cat['adv'] == 1) { echo "<span class='advertises'><i class='fa fa-close'></i>Ads disable</span>";}
                echo "</div>";
              echo "</div>";
            echo "<hr>";
          }
           ?>
        </div>
    </div>
      <a class="btn btn-primary add-category" href="categories.php?do=Add"><i class="fa fa-plus">Add New Category</i></a>
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
  //Edit page (modéfie page)
//: check if  catID is numeric and get his integer value:::::::

    $catID = isset($_GET['catID']) && is_numeric($_GET['catID']) ? intval($_GET['catID']) : 0;


    //SELECT user depend on userID
    //check if user exist
    $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");

    //execute query
    $stmt->execute(array($catID));

    //fetch the data
    $cat = $stmt->fetch();

    //check changes in row count
    $count = $stmt->rowCount();


    //check if there is such ID show the form
    if ($count > 0) { ?>
      <h1 class="text-center"> Edit Category</h1>
      <div class="container">
        <form class="form-horizontal" action="?do=Update" method="POST">
            <input type="hidden" name="catID" value="<?php echo $catID ?>">
          <!--Start uname field-->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-lebel">Name</label>
            <div class="col-sm-10 col-md-4">
              <input type="text" name="name" class="form-control" required="required" placeholder="Name of the category" value="<?php echo $cat['name'] ?>">
            </div>
          </div>
          <!--End name field-->
          <!--Start password field-->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-lebel">Description</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="description" class="  form-control" placeholder="describe the category"  value="<?php echo $cat['description'] ?>">
            </div>
          </div>
          <!--End description field-->
          <!--Start Ordering field-->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-lebel">Ordering</label>
            <div class="col-sm-10 col-md-4">
              <input type="text" name="ordering" class="form-control" placeholder="Number to arrange the category"  value="<?php echo $cat['ordering'] ?>">
            </div>
          </div>
          <!--End Ordering field-->
          <!--Start visibility field-->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-lebel">Visible</label>
            <div class="col-sm-10 col-md-6">
              <div>
                <input id="vis-yes" type="radio" name="visibility" value="0" <?php if ($cat['visibility'] == 0) {echo "checked";} ?> />
                <label for="vis-yes">Yes</label>
              </div>
              <div>
                <input id="vis-no" type="radio" name="visibility" value="1" <?php if ($cat['visibility'] == 1) {echo "checked";} ?>/>
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
                <input id="vis-yes" type="radio" name="comment" value="0" <?php if ($cat['allow_comment'] == 0) {echo "checked";} ?> />
                <label for="vis-yes">Yes</label>
              </div>
              <div>
                <input id="com-no" type="radio" name="comment" value="1" <?php if ($cat['allow_comment'] == 1) {echo "checked";} ?>/>
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
                <input id="ads-yes" type="radio" name="ads" value="0" <?php if ($cat['allow_adv'] == 0) {echo "checked";} ?> />
                <label for="ads-yes">Yes</label>
              </div>
              <div>
                <input id="ads-no" type="radio" name="ads" value="1"  <?php if ($cat['allow_adv'] == 1) {echo "checked";} ?> />
                <label for="ads-no">No</label>
              </div>
            </div>
          </div>
          <!--End Ads field-->
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
  echo "<h1 class='text-center'> Update Category</h1>";
  echo "<div class='container'>";
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Get variables from form
    $id   = $_POST['catID'];
    $catname = $_POST['name'];
    $desc = $_POST['description'];
    $order = $_POST['ordering'];
    $visible = $_POST['visibility'];
    $comm = $_POST['comment'];
    $ads = $_POST['ads'];

      //Update the data base with these formation
      $stmt = $con->prepare("UPDATE categories
        SET name = ?, description = ?, ordering = ?, visibility = ?, allow_comment = ?, allow_adv = ?
         WHERE ID = ?");
      $stmt->execute(array($catname, $desc, $order, $visible, $comm, $ads, $id));
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
echo  '<h1 class="text-center"> Delete Category</h1>';
echo  '<div class="container">';
          //echo "Welcome to Delete page";

          $catID = isset($_GET['catID']) && is_numeric($_GET['catID']) ? intval($_GET['catID']) : 0;


          //SELECT user depend on userID
          $check = checkItem('ID', 'categories', $catID);

          //check if there is such ID show the form
          if ($check > 0) {

          $stmt = $con->prepare("DELETE FROM categories WHERE ID = :zid");

          $stmt->bindParam(':zid', $catID);

          $stmt->execute();
          $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'record Deleted</div>';
          RedirectHome($theMsg, 'back');
          }else {
            $theMsg =  "<div class='alert alert-danger'> Non! cet ID n'est pas exist</div>";
                RedirectHome($theMsg);
          }
            echo "</div>";
      }

 include $tpl . "footer.php";
}else {

header('location: index.php');

exit();
}

ob_end_flush();
 ?>
