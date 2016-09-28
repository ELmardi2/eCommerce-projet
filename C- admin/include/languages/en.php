<?php
 function lang($phrase)  //the which translate the phrase
{
static $lang =  array(
  'MESSAGE'=> 'Welcome',
  'ADMIN' => 'Adminstrator'
);
return $lang[$phrase];
}
