<?php
global $user_array;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){

update_mysql("geeksify_cuestionario",array('status'=>'2'),"pregunta_id='".$_POST['nuevo']."'");

}

?>

