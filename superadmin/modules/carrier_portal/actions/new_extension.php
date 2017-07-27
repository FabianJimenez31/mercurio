<?php
global $var_array;
$profiles=get_user_profile($var_array['username'],$var_array['domain']);

if($profiles!=false && $profiles==3){



$servers=select_mysql("*","domains","main_user=".get_user_id($var_array['username'],$var_array['domain']));
$domains="";
foreach($servers['result'] as $s){

$domains.="<option value='".$s['domain']."'> ".$s['shortname']." - [".$s['domain']."] </option>";

}

dynamic_module_view("carrier_portal",'new_extension',array('domain_options'=>$domains));




}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
