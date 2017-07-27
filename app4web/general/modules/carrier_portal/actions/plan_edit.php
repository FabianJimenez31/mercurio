<?php
global $var_array;
$profiles=get_user_profile($var_array['username'],$var_array['domain']);

if($profiles!=false && $profiles==1){


$plan_info=select_mysql("*","billing_plans","id=".$_GET['plan_id']);
$info=$plan_info['result'][0];
$info['mex']=($info['country']=="MX")?"selected":"";
$info['col']=($info['country']=="CO")?"selected":"";
$info['chan']=($info['billing_method']=="XCANAL")?"selected":"";
$info['exte']=($info['billing_method']=="XEXTENSION")?"selected":"";
dynamic_module_view("admin_portal",'edit_plan',$info);




}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
