<?php

global $user_array;
global $current_sale_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$path=addslashes(file_get_contents($_FILES['contrato']['tmp_name']));
$type=$_FILES['contrato']['type'];
$ext = $_FILES['contrato']['name'];
$this_reference=guid();
$reference=insert_mysql('temporal_contratos',array('unique_id'=>$this_reference));

$where=" unique_id='$this_reference' ";
$j=ejecutar("UPDATE ".DBPREFIX."temporal_contratos set file='$path' , meta='$type' , name='$ext' where $where");


$item_id=$_POST['line'];

$current_sale_array['cart']['items'][$item_id]['temp_contrato']=$this_reference;


load_process("sales","reload_sale");


}else{

echo "NO TIENE PERMISOS PARA INGRESAR EN ESTE SITIO";

}

?>
