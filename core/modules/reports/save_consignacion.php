<?php

global $user_array;
if(permitido($user_array['person_id'],$_GET['mod'])){


update_mysql('sessions',array('consignacion'=>$_POST['new_value']),'session_id='.$_POST['session_id']);
echo "[ ".$_POST['new_value']." ] <a onclick=\"javascript:delete_folio_consignacion('".$_POST['container']."',".$_POST['session_id'].");\">Eliminar</a>";

}else{

echo "NO TIENE PERMISOS PARA INGRESAR EN ESTE SITIO";

}

?>
