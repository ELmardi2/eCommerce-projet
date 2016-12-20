//Edit page (modéfie page)
    $itemID = isset($_GET['itemID']) && is_numeric($_GET['itemID']) ? intval($_GET['itemID']) : 0;


    //SELECT Items depend on uitemID
    //check if user exist
    $stmt = $con->prepare("SELECT * FROM items WHERE item_ID = ? ");

    //execute query
    $stmt->execute(array($itemID));

    //fetch the data
    $item = $stmt->fetch();

    //check changes in row count
    $count = $stmt->rowCount();


    //check if there is such ID show the form
    if ($count > 0) { ?>

      <h1 class="text-center">Edit Items</h1>
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
