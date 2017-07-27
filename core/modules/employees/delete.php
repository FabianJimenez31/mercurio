<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){

foreach($_POST['selected_item'] as $m){

$m=update_mysql("employees",array('deleted'=>1),"person_id=$m");


}

echo "Registros Eliminados";

}


?>
