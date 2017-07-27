<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){

foreach($_POST['selected_item'] as $m){

ejecutar("DELETE FROM ".DBPREFIX."cuentascontables WHERE id=$m");

}

echo label_me('reg_deleted');

}


?>
