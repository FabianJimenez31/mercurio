<?php

global $user_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$path=addslashes(file_get_contents($_FILES['imagen_consignacion']['tmp_name']));
$type=$_FILES['imagen_consignacion']['type'];

update_mysql('sessions',array('consignacion_file'=>1 , 'consignacion_type'=>$type),'session_id='.$_POST['session_id']);
$j=ejecutar("UPDATE ".DBPREFIX."sessions set consignacion_content='$path' where session_id=".$_POST['session_id']);

echo "<a href='?mod=reports&proc=download_consignacion_file&session_id=".$_POST['session_id']."' target='_blank'>Descargar</a> | <a onclick=\"javascript:delete_image_consignacion('".$_POST['container']."',".$_POST['session_id'].");\">Eliminar</a>";

}else{

echo "NO TIENE PERMISOS PARA INGRESAR EN ESTE SITIO";

}

?>
