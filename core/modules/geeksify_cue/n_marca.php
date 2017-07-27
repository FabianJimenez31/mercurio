<?php
global $user_array;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){

insert_mysql("geeksify_marcas",array('valor'=>$_POST['nuevo']));

}

?>

