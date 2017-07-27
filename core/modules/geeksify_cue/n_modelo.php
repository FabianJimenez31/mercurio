<?php
global $user_array;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){

$ff=insert_mysql("geeksify_modelos",array('valor'=>$_POST['nuevo'],'tipo_a'=>$_POST['ti_a'],'tipo_b'=>$_POST['ti_b'],'tipo_c'=>$_POST['ti_c'],'tipo_d'=>$_POST['ti_d'],'marca_id'=>$_POST['marc']));


}

?>

