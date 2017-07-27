<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){

//$datos=$_POST;
$datos['status']='1';

$datos['id']=$_POST['id'];
$datos['name']=$_POST['name'];
$datos['description']=$_POST['description'];
$datos['periodical']=$_POST['periodical'];
$datos['month_start']=$_POST['month_start'];



$m=update_mysql("esquemas",$datos,"id=".$_GET['item_id']);


$message=label_me('saved_info')." ".label_me('with_id')." ".$_GET['item_id'];


echo $message;



}


?>
