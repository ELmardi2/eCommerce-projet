<?php
  /*
  ==Manage members page gere (gere les members)
  == You can Add[Edit] Delete Members from here(vous pouvez ajouter[modéfier] Effacer les Members d'ici)
  */
  ob_start();
  session_start();
  $pageTitle = '';
  //$nonavbar = '';
  //print_r($_SESSION);
if (isset($_SESSION['username'])) {

  include ('init.php');



  //Start Manage page(commence guestion page)
  if ($do == 'Manage') {//Manage page (gestion page)

 }elseif($do == 'Add') {

}elseif ($do == 'insert') {

}elseif ($do == 'Edit') {

}elseif ($do == 'Update') {

}elseif ($do == 'Delete') {

        }elseif ($do = 'Activat') {

}
   include $tpl . "footer.php";
}else {

  header('location: index.php');

  exit();
}

ob_end_flush();



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

echo "<h1 class='text-center'> Insert Category</h1>";
echo "<div class='container'>";
  //Get variables from form
  $name    = $_POST['name'];
  $desc    = $_POST['description'];
  $order   = $_POST['ordering'];
  $visible = $_POST['visibility'];
  $comm    = $_POST['comment'];
  $advs    = $_POST['ads'];

    //check if Category exist in the data base
    $check = checkItem('name', 'Categories', $name);
    if ($check == 1) {
      echo "<div class='container'>";
    $theMsg = "<div class='alert alert-danger'>Sorry this category  is already exist</div>";
    RedirectHome($theMsg, 'back', 7);
    echo "</div>";
    }else {

    $stmt = $con->prepare("INSERT INTO Categories(name, description, ordering, visibility, allow_comment, allow_adv)
       VALUES(:zname, :zdescription, :zordering, :zcomment, :zads)");
      $stmt->execute(array(
        'zname'          =>$name,
        'zdescription'   =>$desc,
        'zordering'      =>$order,
        'zvisibility'    =>$visible,
        'zcomment'       =>$comm,
        'zads'           =>$advs
      ));
      //echo success message
      echo "<div class='container'>";
      $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " record Inserted</div>";
          RedirectHome($theMsg, 'back');
          echo "</div>";


}
}
else {
  echo "<div class='container'>";
$theMsg = "<div class='alert alert-danger'>sorry you cannot browse this page directly</div>";
RedirectHome($theMsg, 'back', 7);
echo "</div>";
}
echo "</div>"
$stmt = $con->prepare("SELECT * FROM categories");
$stmt-<execute();
$cats = $stmt->fetchAll();
?>
<h1 class="text-center">Manage Categories</h1>
<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading"> Manage Categories</div>
      <div class="panel-body">
        <?php
        foreach ($cats as $cat) {
          echo $cat['name'] . "<br>";
        }
         ?>
      </div>
  </div>
</div>
<?php
echo "<h1 class='text-center'> insert Items</h1>";
echo "<div class='container'>";

  //Get variables from form
  $name  = $_POST['name'];
  $desc  = $_POST['description'];
  $price = $_POST['price'];
  $country  = $_POST['country'];
  $status  = $_POST['status'];

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
foreach ($formerrors as $error) {
  echo "<div class='alert alert-danger'>" . $error . "</div>";
}
 ?>
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {

 echo "<h1 class='text-center'> insert Item</h1>";
 echo "<div class='container'>";
   //Get variables from form


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
   foreach ($formerrors as $error) {
     echo "<div class='alert alert-danger'>" . $error . "</div>";
   }
   //chech if there is no errors proced the data base
   if (empty($error)) {    //Insert thes info to data base
     $stmt = $con->prepare("INSERT INTO items(name, description, price, country_made, status, add_Date)
VALUES(:zname, :zdesc, :zprice, :zcountry, zstatus, now())");
       $stmt->execute(array(
         'zname'         =>$name,
         'zdescription'  =>$desc,
         'zprice'        =>$price,
         'zcountry'      =>$country,
         'zstatus'       =>$status
       ));
     //echo success message
     echo "<div class='container'>";
     $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " record Inserted</div>";
         RedirectHome($theMsg, 'back');
         echo "</div>";
 }

 }else {
   echo "<div class='container'>";
 $theMsg = "<div class='alert alert-danger'>sorry you cannot browse this page directly</div>";
 RedirectHome($theMsg, 'back', 7);
 echo "</div>";
 }
}
