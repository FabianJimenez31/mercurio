<?php

global $user_array;
if(permitido($user_array['person_id'],$_GET['mod'])){


update_mysql('sessions',array('consignacion_content'=>'','consignacion_file'=>'0','consignacion_type'=>''),'session_id='.$_POST['session_id']);
echo "<form id=\"".$_POST['container']."_image_form_consignacion\" enctype=\"multipart/form-data\"><input type='file' name='imagen_consignacion' /><input type='hidden' name='container' value='".$_POST['container']."' /> <input type='hidden' name='session_id' value='".$_POST['session_id']."'></form><a onclick=\"javascript:upload_image_consignacion('".$_POST['container']."');\">Subir Archivo</a>";

}else{

echo "NO TIENE PERMISOS PARA INGRESAR EN ESTE SITIO";

}

?>
