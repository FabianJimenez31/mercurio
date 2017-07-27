<?php

global $user_array;
global $current_sale_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

foreach($current_sale_array as $k=>$v){

unset($current_sale_array[$k]);

}
unset($GLOBALS['current_sale_array']);
unset($current_sale_array['cart']);
unset($current_sale_array['customer']);
unset($current_sale_array['eta']);
unset($current_sale_array['req_id']);
unset($current_sale_array['comment']);

load_process("sales","reload_sale");
}

?>
