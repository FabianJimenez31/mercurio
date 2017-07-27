<?php

global $user_array;
if(permitido($user_array['person_id'],$_GET['mod'])){


update_mysql('sessions',array('datafono'=>''),'session_id='.$_POST['session_id']);
echo "<input type='text' id='".$_POST['container']."_datafono' /> <a onclick=\"javascript:guardar_folio_datafono('".$_POST['container']."',".$_POST['session_id'].");\">Asignar</a>";

}else{

echo "NO TIENE PERMISOS PARA INGRESAR EN ESTE SITIO";

}

?>
