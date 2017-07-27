<?php

global $user_array;
global $current_presale_array;
if(permitido($user_array['person_id'],$_GET['mod'])){


unset($current_presale_array['cart']);
unset($current_presale_array['customer']);

load_process("presales","reload_sale");
}

?>
