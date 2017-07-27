<?php
global $user_array;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){

insert_mysql("geeksify_cuestionario",array('status'=>'1','valor'=>$_POST['nuevo'],'restar'=>$_POST['ti_a'],'auto_clas'=>$_POST['ti_b']));

}

?>

