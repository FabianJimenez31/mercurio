<?php

global $user_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$efectivo=$_POST['to_be_report'];
update_mysql('sessions',array('consignado_datafonos'=>0),'session_id='.$_POST['session_id']);
echo "<input type='text' id='".$_POST['container']."_monto_datafono' /> <a onclick=\"javascript:guardar_datafono_monto('".$_POST['container']."',".$_POST['session_id'].",'$efectivo');\">Asignar</a>";

}else{

echo "NO TIENE PERMISOS PARA INGRESAR EN ESTE SITIO";

}

?>
