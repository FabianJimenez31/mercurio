<?php

global $user_array;
if(permitido($user_array['person_id'],$_GET['mod'])){


$where="sale_id='".$_POST['sale_id']."' and line='".$_POST['line']."' and serialnumber='".$_POST['serialnumber']."' and item_id='".$_POST['item_id']."'";
$j=ejecutar("UPDATE ".DBPREFIX."sales_items set contrato='' where $where");

echo "<form id=\"".$_POST['container']."_contrato\" enctype=\"multipart/form-data\">
<input type='file' name='imagen_contrato' />
<input type='hidden' name='container' value='".$_POST['container']."' /> 
<input type='hidden' name='sale_id' value='".$_POST['sale_id']."'>
<input type='hidden' name='line' value='".$_POST['line']."'>
<input type='hidden' name='serialnumber' value='".$_POST['serialnumber']."'>
<input type='hidden' name='item_id' value='".$_POST['item_id']."'>
</form>
<a onclick=\"javascript:upload_image_contrato('".$_POST['container']."');\">Subir Archivo</a>";

}else{

echo "NO TIENE PERMISOS PARA INGRESAR EN ESTE SITIO";

}

?>
