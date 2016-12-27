<?php
 function lang($phrase)  //the which translate the phrase
{
static $lang =  array(
  //Home page....

  //navbar links
  'MESSAGE'       => 'Home',
  'CATEGORIES'    => 'Sections',
  'ITEMS'         => 'Items',
  'MEMBERS'       => 'Members',
  'STATICS'       => 'Statics',
    'COMMENTS'    => 'Comments',
  'LOGS'          => 'Logs',
  'A' => '',
  '' => '',
  '' => '',
  '' => ''
);
return $lang[$phrase];
}
