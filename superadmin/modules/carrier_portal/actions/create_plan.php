<?php
global $var_array;
$profiles=get_user_profile($var_array['username'],$var_array['domain']);

if($profiles!=false && $profiles==1){





insert_mysql("billing_plans",$_POST);
$servers=select_mysql("*","billing_plans");

foreach($servers['result'] as $s){

$server[]=array(
"id"=>$s['id'],
'name'=>$s['name'],
'description'=>substr($s['description'],0,32),
'country'=>$s['country'],
'billing_method'=>$s['billing_method'],
'cost'=> number_format($s['cost'],2)

);

}
echo "<script>alert('Plan Creado');</script>";
dynamic_module_view("admin_portal",'plans',array('plans'=>$server));


}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
