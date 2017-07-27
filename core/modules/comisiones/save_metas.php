<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){

$datos=$_POST;
unset($datos['submitf']);


if(isset($_POST['id'])){

unset($datos['item_id']);

$m=update_mysql("metas_asignar",$datos,"id=".$_POST['id']);


$message=label_me('saved_info')." ".label_me('with_id')." ".$_POST['id'];


}else{

$m=insert_mysql("metas_asignar",$datos);



if($m['last_id']<=0){
$message=label_me('error_saving');
}else{
$message=label_me('saved_info')." ".label_me('with_id')." ".$m['last_id'];
}



}


echo $message;


}


?>
