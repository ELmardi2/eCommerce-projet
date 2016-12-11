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

      /*
      //function count Items V 1.0
      **function count Items V1
      ** $item = item to count .
      ** $table = table to choose from
      */
      function countItem($item, $table)
      {
        global $con;
        $stmtB = $con->prepare("SELECT COUNT($item) FROM $table");
        $stmtB->execute();
        return $stmtB->fetchColumn();
      }

      /*
      //function latest V 1.0
      **function select the latest[users ,items,comments....;etc]
      ** $select = feild to select .
      **$table from where we choose
      **$LIMIT number of Items or the values
      */
      function getLatest($select, $table, $order, $limit = 5)
      {
        global $con;
        $stmtC = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC  LIMIT $limit");
        $stmtC->execute();
        $row = $stmtC->fetchAll();
        return $row;
      }


 ?>
