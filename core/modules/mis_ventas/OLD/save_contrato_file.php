<?php

global $user_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$path=addslashes(file_get_contents($_FILES['imagen_contrato']['tmp_name']));
$type=$_FILES['imagen_contrato']['type'];
$ext = $_FILES['imagen_contrato']['name'];
$where="sale_id='".$_POST['sale_id']."' and line='".$_POST['line']."' and serialnumber='".$_POST['serialnumber']."' and item_id='".$_POST['item_id']."'";
$j=ejecutar("UPDATE ".DBPREFIX."sales_items set contrato='$path' , contrato_type='$type' , contrato_extension='$ext' where $where");

$string=base64_encode(" sale_id='".$_POST['sale_id']."' and line='".$_POST['line']."' and serialnumber='".$_POST['serialnumber']."' and item_id='".$_POST['item_id']."'");


echo "
<form id=\"".$_POST['container']."_contrato\">
<input type='hidden' name='container' value='".$_POST['container']."' /> 
<input type='hidden' name='sale_id' value='".$_POST['sale_id']."'>
<input type='hidden' name='line' value='".$_POST['line']."'>
<input type='hidden' name='serialnumber' value='".$_POST['serialnumber']."'>
<input type='hidden' name='item_id' value='".$_POST['item_id']."'>
</form>



<a href='?mod=contratos&proc=download_contrato_file&string=".$string."' target='_blank'>Descargar</a> | <a onclick=\"javascript:delete_image_contrato('".$_POST['container']."');\">Eliminar</a>
";

}else{

echo "NO TIENE PERMISOS PARA INGRESAR EN ESTE SITIO";

}

?>
