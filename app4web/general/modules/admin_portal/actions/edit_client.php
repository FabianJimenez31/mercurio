<?php
global $var_array;
$profiles=get_user_profile($var_array['username'],$var_array['domain']);

if($profiles!=false && $profiles==1){



$c_id=select_mysql("*","users","id=".$_GET['client_id']);
$c_inf=$c_id['result'][0];
$crm_info_a=select_mysql("*","crm_information","user_id='".$c_inf['id']."'");
$cr_inf=$crm_info_a['result'][0];

$user_info=array(
'name'=>$cr_inf['name'],
'last_name'=>$cr_inf['last_name'],
'address_1'=>$cr_inf['address_1'],
'address_2'=>$cr_inf['address_2'],
'state'=>$cr_inf['state'],
'citi'=>$cr_inf['citi'],
'postal_code'=>$cr_inf['postal_code'],
'country'=>$cr_inf['country'],
'mexico_sel'=>($cr_inf['country']=='Colombia')?'':'selected',
'colombia_sel'=>($cr_inf['country']=='Colombia')?'selected':'',
'phone_1'=>$cr_inf['phone_1'],
'phone_2'=>$cr_inf['phone_2'],
'id'=>$c_inf['id'],
'email_address'=>$c_inf['email_address'],
'username'=>$c_inf['username']

);

dynamic_module_view("admin_portal",'edit_client',$user_info);


}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
