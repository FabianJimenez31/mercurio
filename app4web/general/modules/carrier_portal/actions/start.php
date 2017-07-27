<?php
global $var_array;
$profiles=get_user_profile($var_array['username'],$var_array['domain']);

if($profiles!=false && $profiles==3){


$user_data=select_mysql("*","users","username='".$var_array['username']."' and domain='".$var_array['domain']."' and status=1");
$user_data_2=select_mysql("*","crm_information","user_id=".$user_data['result'][0]['id']);
$user_name=utf8_encode($user_data_2['result'][0]['name']." ".$user_data_2['result'][0]['last_name']);

$array=array('username'=>$user_name);

dynamic_view("partial/carrier_header",$array);




}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
