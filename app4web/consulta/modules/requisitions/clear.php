<?php

global $user_array;
global $current_requisition_array;
if(permitido($user_array['person_id'],$_GET['mod'])){


unset($current_requisition_array['cart']);
unset($current_requisition_array['customer']);
unset($current_requisition_array['eta']);
unset($current_requisition_array['req_id']);
unset($current_requisition_array['comment']);

load_process("requisitions","reload_sale");
}

?>
