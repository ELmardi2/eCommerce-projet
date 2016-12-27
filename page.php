<?php
      /*
      Categories [Mnage(Edit)->[Update] +Add(insert) -Delete()|Statics ]
      */
      $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
      /*$do = '';
      if (isset($_GET['do'])) {
      $do = $_GET['do'];
    }else {
      $do = 'Manage';
    }*/
     //If The Page Is main Page
     if ($do == 'Manage') {

       echo "Welcome You Are in Manage Categories Page";
       echo "'<a href=''?do=insert'> Add New Category +</a>";

     }elseif ($do == 'Add') {

        echo "Welcome You Are in Add Categories Page";

     }
     elseif ($do == 'insert') {

        echo "Welcome You Are in insert Categories Page";

     }else {

       echo "There is no page with this name";

     }
 ?>
