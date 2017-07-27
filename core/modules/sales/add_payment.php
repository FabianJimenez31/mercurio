<?php

global $user_array;
global $current_sale_array;
if(permitido($user_array['person_id'],$_GET['mod'])){


$current_sale_array['payments'][]=array(
'type'=>$_POST['type'],
'ammount'=>$_POST['ammount'],
'comment'=>$_POST['comm']

);


load_process("sales","reload_sale");
}

?>
