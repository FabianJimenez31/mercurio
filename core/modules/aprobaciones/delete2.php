<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){


$m=update_mysql("sales_items",

array(

'aprobada_por'=>$user_array['person_id'],
'is_aprobada'=>'2',
'aprobacion_fecha_real'=>date('Y-m-d H:i:s'),
'razon_rechazo'=>utf8_encode($_GET['r'])


)

,"item_id='".$_GET['i']."' and sale_id='".$_GET['s']."' and line='".$_GET['l']."'");




echo "Comision Rechazada";

}


?>
