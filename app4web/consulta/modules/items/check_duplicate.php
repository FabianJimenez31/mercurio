<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
$extra=(isset($_GET['item_id'])) ? " and item_id!=".$_GET['item_id'] : '';
$items=select_mysql("*","items","name='".$_POST['term']."'".$extra);
$f=($items['count']>=1) ? true : false;
$m=array('duplicate'=>$f);

echo json_encode($m);

}


?>
