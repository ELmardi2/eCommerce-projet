<?php
      /*
      ** Title function that echo the page Title in case the page has the variable...
      ** $pageTitle and echo defaulf for the other.
      */
      function getTitle(){
        global $pageTitle;

        if (isset($pageTitle)) {
          echo $pageTitle;
        }else {
          echo "Default";
        }
      }
      /*
      **redirect function v2.0
      ** Redirect  function that [acept parameters]...
      ** $theMsg = echo the  message[Error | success | Warning|].
      **$url = the link to Redirect
      **second before Redirected
      */
      function RedirectHome($theMsg, $url = null, $second = 10){
        if ($url === null) {
          $url = 'index.php';
          $link = 'Homepage';
        }else {
          if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
            $url = $_SERVER['HTTP_REFERER'];
            $link = 'Previouspage';
          }else {
            $url = 'index.php';
            $link = 'Homepage';
          }

        }
        echo $theMsg;
        echo "<div class='alert alert-info'> You will be redirected to $link after : $second</div>";
        header("refresh:$second;url=$url");
        exit();
      }
      /*
      **function check Items V1
      **  function  [acept parameters]...
      ** $select = the item to select [example: user, item, category......ect].
      **$from = the table selected [example: users, Items, categories]
      **$values = the values to select[example: username, password, technolog,....etc]
      */
      function checkItem($select, $from, $value)
      {
        global $con;
        $stmtA = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
        $stmtA->execute(array($value));
        $count = $stmtA->rowCount();
        return $count;
      }
 ?>
