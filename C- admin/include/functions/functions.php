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
 ?>
