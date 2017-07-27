<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){

foreach($_POST['selected_item'] as $m){

update_mysql("item_kits",array('deleted'=>1),"item_kit_id=$m");

}

echo "Registros Eliminados";

}


?>
