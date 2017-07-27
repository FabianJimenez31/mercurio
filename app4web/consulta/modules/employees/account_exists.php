<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
$extra=(isset($_GET['person_id'])) ? " and person_id!=".$_GET['person_id'] : '';
$items=select_mysql("*","employees","username='".$_POST['username']."'".$extra);
$f=($items['count']>=1) ? 'false' : 'true';

echo $f;

}


?>
