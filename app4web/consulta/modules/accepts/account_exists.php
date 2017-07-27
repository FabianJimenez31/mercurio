<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
$extra=(isset($_GET['person_id'])) ? " and person_id!=".$_GET['person_id'] : '';
$items=select_mysql("*","customers","account_number='".$_POST['account_number']."'".$extra);
$f=($items['count']>=1) ? 'false' : 'true';

echo $f;

}


?>
