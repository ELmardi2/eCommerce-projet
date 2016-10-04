<?php

include'connect.php';

//Routes....
      $tpl = "include/template/";   //template Directory
      $css = "Design_layout/css";  //css path Directory
      $js = "Design_layout/js";  //js path Directory

      //include the important fichiers (files)
      include 'include/languages/en.php';
      include $tpl. "header.php";


        //include  the navbar in all pages except $navbar
        if (!isset($nonavbar)) {
          include $tpl. "navbar.php";
        }

 ?>
