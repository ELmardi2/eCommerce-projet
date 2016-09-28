<?php
 function lang($phrase) //la fonction qui va traduire la phrase
{
static $lang =  array(
  'MESSAGE' => 'Bienvenue',
  'ADMIN' => 'Adminstrateur'
);
return $lang[$phrase];
}
