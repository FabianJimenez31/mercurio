<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){

foreach($_POST['selected_item'] as $m){

ejecutar("UPDATE ".DBPREFIX."metas_asignar set status=3 where id=$m");

}

echo label_me('reg_deleted');

}


?>
