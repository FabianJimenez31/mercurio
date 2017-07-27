<?php
global $user_array;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){

update_mysql("geeksify_modelos",array('status'=>'2'),"modelos_id='".$_POST['nuevo']."'");

}

?>

