<?php

global $user_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$path=addslashes(file_get_contents($_FILES['imagen_datafono']['tmp_name']));
$type=$_FILES['imagen_datafono']['type'];

update_mysql('sessions',array('datafono_file'=>1 , 'datafono_type'=>$type),'session_id='.$_POST['session_id']);
$j=ejecutar("UPDATE ".DBPREFIX."sessions set datafono_content='$path' where session_id=".$_POST['session_id']);

echo "<a href='?mod=reports&proc=download_datafono_file&session_id=".$_POST['session_id']."' target='_blank'>Descargar</a> | <a onclick=\"javascript:delete_image_datafono('".$_POST['container']."',".$_POST['session_id'].");\">Eliminar</a>";

}else{

echo "NO TIENE PERMISOS PARA INGRESAR EN ESTE SITIO";

}

?>
