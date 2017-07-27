<?php
global $var_array;
$profiles=get_user_profile($var_array['username'],$var_array['domain']);

if($profiles!=false && $profiles==3){


$info=select_mysql("*","domains","id=".$_GET['domain_id']);

$inf=$info['result'][0];
$inf['active_field_yes']=($inf['status']==1)?'selected':'';
$inf['active_field_no']=($inf['status']!=1)?'selected':'';

dynamic_module_view("carrier_portal",'edit_domain',$inf);




}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
