<?php
  /*
  ==Manage  Items page gere ()
  == You can Add[Edit] Delete Items from here(vous pouvez ajouter[modéfier] Effacer les elemants d'ici)
  */
  ob_start();
  session_start();
  $pageTitle = 'Items';
  //$nonavbar = '';
  //print_r($_SESSION);

if (isset($_SESSION['username'])) {

  include ('init.php');

$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

  if ($do == 'Manage') {      //Manage page (gestion page)

    //select users except Admins
    $stmt = $con ->prepare("SELECT
                               items. * , categories.name AS category_name, users.username AS member_name
                            FROM items
                            INNER JOIN
                                categories
                            ON
                                categories.ID = items.cat_ID
                            INNER JOIN
                                users
                            ON
                                users.userID = items.user_ID");
    //execute the stmt
    $stmt->execute();
    //asign all data in variables
    $items = $stmt->fetchAll();
    ?>
      <h1 class="text-center"> Manage Items</h1>
      <div class="container">
        <div class="table-responsive">
          <table class="main-table text-center table table-bordered">
            <tr>
              <td>#ID</td>
              <td>name</td>
              <td>Description</td>
              <td>Price</td>
              <td>Adding Date</td>
              <td>Category</td>
              <td>User Name</td>
              <td>Control</td>
            </tr>
          <?php foreach ($items as $item){
            echo "<tr>";
            echo "<td>" . $item['item_ID'] . "</td>";
            echo "<td>" . $item['name'] . "</td>";
            echo "<td>" . $item['description'] . "</td>";
            echo "<td>" . $item['price'] . "</td>";
            echo "<td>" . $item['add_Date'] . "</td>";
              echo "<td>" . $item['category_name'] . "</td>";
                echo "<td>" . $item['member_name'] . "</td>";
            echo "<td>
            <a href='items.php?do=Edit&item_ID=" . $item[item_ID] . "'  class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
            <a href='items.php?do=Delete&item_ID=" . $item[item_ID] . "'  class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
            if ($item['RegStatus'] == 0) {
          echo "<a href='items.php?do=Activate&item_ID=" . $item[item_ID] . "'  class='btn btn-info activate'><i class='fa fa-hand-pointer-o'></i>Activate</a>";
            }
            echo  "</td>";
            echo "</tr>";
          }
             ?>
          </table>
        </div>
        <a href='items.php?do=Add' class="btn btn-primary"><i class="fa fa-plus"></i>Add new Item</a>
      </div>
      <?php
}elseif($do == 'Add') { ?>
    <h1 class="text-center"> Add new Items</h1>
    <div class="container">
      <form class="form-horizontal" action="?do=insert" method="POST">
        <!--Start uname field-->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-lebel">Name</label>
          <div class="col-sm-10 col-md-4">
            <input type="text"
            name="name"
             class="form-control"
             required="required"
             placeholder="Name of the item">
          </div>
        </div>
        <!--End name field-->
        <!--Start description field-->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-lebel">Description</label>
          <div class="col-sm-10 col-md-4">
            <input type="text"
            name="description"
             class="form-control"
             required="required"
            placeholder="Description of the item">
          </div>
        </div>
        <!--End description field-->
        <!--Start Price field-->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-lebel">Price</label>
          <div class="col-sm-10 col-md-4">
            <input type="text"
            name="price"
             class="form-control"
             required="required"
            placeholder="Price of the item">
          </div>
        </div>
        <!--End Price field-->
        <!--Start Price field-->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-lebel">Country </label>
          <div class="col-sm-10 col-md-4">
            <input type="text"
            name="country"
             class="form-control"
             required="required"
            placeholder="Country which made the Item">
          </div>
        </div>
        <!--End Country field-->
        <!--Start Status field-->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-lebel">Status</label>
          <div class="col-sm-10 col-md-4">
            <select class="form-control" name="status">
              <option value="0">....</option>
              <option value="1">New</option>
              <option value="2"> Like New</option>
              <option value="3">Medle Case</option>
              <option value="4">Old</option>
              <option value="5">Very Old</option>
            </select>
          </div>
        </div>
        <!--End Status field-->
        <!--Start Members field-->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-lebel">Member</label>
          <div class="col-sm-10 col-md-4">
            <select class="form-control" name="member">
              <option value="0">....</option>
              <?php
              $stmtA = $con->prepare("SELECT * FROM users");
              $stmtA->execute();
              $users = $stmtA->fetchAll();
              foreach ($users as $user) {
                echo "<option value='" . $user['userID'] . "'>" . $user['username'] . "</option>";
              }
               ?>
            </select>
          </div>
        </div>
        <!--End Members field-->
        <!--Start Categories field-->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-lebel">Category</label>
          <div class="col-sm-10 col-md-4">
            <select class="form-control" name="category">
              <option value="0">....</option>
              <?php
              $stmt = $con->prepare("SELECT * FROM categories");
              $stmt->execute();
              $cats = $stmt->fetchAll();
              foreach ($cats as $cat) {
                echo "<option value='" . $cat['ID'] . "'>" . $cat['name'] . "</option>";
              }
               ?>
            </select>
          </div>
        </div>
        <!--End Categories field-->
        <!--Start buttom field-->
        <div class="form-group form-group-lg">
          <div class="col-sm-offset-2 col-sm-10">
            <input type="submit" value="Add Item" class="btn btn-primary btn-lg">
          </div>
        </div>
        <!--End buttom field-->
      </form>
    </div>


    <?php

}elseif ($do == 'insert') {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    echo "<h1 class='text-center'> insert Item</h1>";
    echo "<div class='container'>";
      //Get variables from form
      //Get variables from form
      $name     = $_POST['name'];
      $desc     = $_POST['description'];
      $price    = $_POST['price'];
      $country  = $_POST['country'];
      $status   = $_POST['status'];
      $member   = $_POST['member'];
      $cat   = $_POST['category'];

      //check validate form before
      $formerrors = array();
      if (empty($name)) {
        $formerrors[] = "Name can't be <strong>empty</strong>";
      }
      if (empty($desc)) {
        $formerrors[] = "Description can't be <strong>empty</strong>";
      }
      if (empty($price)) {
        $formerrors[] = "Price can't be <strong>empty</strong>";
      }
      if (empty($country)) {
        $formerrors[] = "Country can't be <strong>empty</strong>";
      }
      if ($status == 0){
        $formerrors[] = "Status can't be <strong>empty</strong>";
      }
      if ($member == 0){
        $formerrors[] = "You must choose member can't be <strong>empty</strong>";
      }
      if ($cat == 0){
        $formerrors[] = "You must choose category can't be <strong>empty</strong>";
      }
      foreach ($formerrors as $error) {
        echo "<div class='alert alert-danger'>" . $error . "</div>";
      }
      //chech if there is no errors proced the data base
      if (empty($error)) {
        $stmt = $con->prepare("INSERT INTO items(name, description, price,
           country_made, status, add_Date, cat_ID, user_ID)
  VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember)");
          $stmt->execute(array(
            'zname'  =>$name,
            'zdesc'  =>$desc,
            'zprice'  =>$price,
            'zcountry'  =>$country,
            'zstatus'  =>$status,
            'zmember'  =>$member,
            'zcat'  =>$cat
          ));
        //echo success message
        echo "<div class='container'>";
        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " record Inserted</div>";
            RedirectHome($theMsg);
            echo "</div>";
      }

    }else {
      echo "<div class='container'>";
    $theMsg = "<div class='alert alert-danger'>Sorry you cannot browse this page directly</div>";
    RedirectHome($theMsg);
    echo "</div>";

    }

  }elseif ($do == 'Edit') {
    //Edit page (modéfie page)
       $itemID = isset($_GET['item_ID']) && is_numeric($_GET['item_ID']) ? intval($_GET['item_ID']) : 0;


       //SELECT user depend on userID
       //check if user exist
       $stmt = $con->prepare("SELECT * FROM items WHERE item_ID = ?");

       //execute query
       $stmt->execute(array($itemID));

       //fetch the data
       $item = $stmt->fetch();

       //check changes in row count
       $count = $stmt->rowCount();


       //check if there is such ID show the form
       if ($count > 0) { ?>

                 <h1 class="text-center"> Edit Items</h1>
                 <div class="container">
                   <form class="form-horizontal" action="?do=Update" method="POST">
                     <!--Start uname field-->
                     <div class="form-group form-group-lg">
                       <label class="col-sm-2 control-lebel">Name</label>
                       <div class="col-sm-10 col-md-4">
                         <input type="text"
                         name="name"
                          class="form-control"
                          required="required"
                          placeholder="Name of the item"
                            value="<?php echo $item['name'] ?>">
                       </div>
                     </div>
                     <!--End name field-->
                     <!--Start description field-->
                     <div class="form-group form-group-lg">
                       <label class="col-sm-2 control-lebel">Description</label>
                       <div class="col-sm-10 col-md-4">
                         <input type="text"
                         name="description"
                          class="form-control"
                          required="required"
                         placeholder="Description of the item"
                          value="<?php echo $item['description']; ?>">
                       </div>
                     </div>
                     <!--End description field-->
                     <!--Start Price field-->
                     <div class="form-group form-group-lg">
                       <label class="col-sm-2 control-lebel">Price</label>
                       <div class="col-sm-10 col-md-4">
                         <input type="text"
                         name="price"
                          class="form-control"
                          required="required"
                         placeholder="Price of the item"
                          value="<?php echo $item['price']; ?>">
                       </div>
                     </div>
                     <!--End Price field-->
                     <!--Start Price field-->
                     <div class="form-group form-group-lg">
                       <label class="col-sm-2 control-lebel">Country </label>
                       <div class="col-sm-10 col-md-4">
                         <input type="text"
                         name="country"
                          class="form-control"
                          required="required"
                         placeholder="Country which made the Item"
                          value="<?php echo $item['country_made']; ?>">
                       </div>
                     </div>
                     <!--End Country field-->
                     <!--Start Status field-->
                     <div class="form-group form-group-lg">
                       <label class="col-sm-2 control-lebel">Status</label>
                       <div class="col-sm-10 col-md-4">
                         <select class="form-control" name="status">
                           <option value="0">....</option>
                           <option value="1" <?php if ($item['status'] == 1){echo "selected";} ?>>New</option>
                           <option value="2"<?php if ($item['status'] == 2){echo "selected";} ?>> Like New</option>
                           <option value="3"<?php if ($item['status'] == 3){echo "selected";} ?>>Medle Case</option>
                           <option value="4"<?php if ($item['status'] == 4){echo "selected";} ?>>Old</option>
                           <option value="5"<?php if ($item['status'] == 5){echo "selected";} ?>>Very Old</option>
                         </select>
                       </div>
                     </div>
                     <!--End Status field-->
                     <!--Start Members field-->
                     <div class="form-group form-group-lg">
                       <label class="col-sm-2 control-lebel">Member</label>
                       <div class="col-sm-10 col-md-4">
                         <select class="form-control" name="member">
                           <option value="0">....</option>
                           <?php
                           $stmtA = $con->prepare("SELECT * FROM users");
                           $stmtA->execute();
                           $users = $stmtA->fetchAll();
                           foreach ($users as $user) {
                             echo "<option value='" . $user['userID'] . "'";
                             if ($item['user_ID'] == $user['userID']){echo "selected";}
                            echo ">"  . $user['username'] . "</option>";
                           }
                            ?>
                         </select>
                       </div>
                     </div>
                     <!--End Members field-->
                     <!--Start Categories field-->
                     <div class="form-group form-group-lg">
                       <label class="col-sm-2 control-lebel">Category</label>
                       <div class="col-sm-10 col-md-4">
                         <select class="form-control" name="category">
                           <option value="0">....</option>
                           <?php
                           $stmt = $con->prepare("SELECT * FROM categories");
                           $stmt->execute();
                           $cats = $stmt->fetchAll();
                           foreach ($cats as $cat) {
                             echo "<option value='" . $cat['ID'] . "'";
                             if ($item['cat_ID'] == $cat['ID']){echo "selected";}
                             echo ">" . $cat['name'] . "</option>";
                           }
                            ?>
                         </select>
                       </div>
                     </div>
                     <!--End Categories field-->
                     <!--Start buttom field-->
                     <div class="form-group form-group-lg">
                       <div class="col-sm-offset-2 col-sm-10">
                         <input type="submit" value="Save Item" class="btn btn-primary btn-lg">
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

}elseif ($do == 'Delete') {

}elseif ($do = 'Approve') {

}
   include $tpl . "footer.php";
}else {

  header('location: index.php');

  exit();
}

ob_end_flush();
