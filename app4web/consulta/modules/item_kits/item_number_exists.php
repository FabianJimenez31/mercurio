<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
$extra=(isset($_GET['item_number'])) ? " and item_id!=".$_GET['item_number'] : '';
$extra2=(isset($_GET['item_number'])) ? " and item_kit_id!=".$_GET['item_number'] : '';
$items=select_mysql("*","items","item_number='".$_POST['item_kit_number']."'".$extra);
$items2=select_mysql("*","item_kits","item_kit_number='".$_POST['item_kit_number']."'".$extra2);
$f=($items['count']>=1 || $items2['count']>=1) ? 'false' : 'true';

echo $f;

}


?>
