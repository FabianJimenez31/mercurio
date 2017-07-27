<?php
global $var_array;
$profiles=get_user_profile($var_array['username'],$var_array['domain']);

if($profiles!=false && $profiles==1){



$user=array(

'username'=>$_POST['username'],
'password'=>md5($_POST['password']),
'test'=>1,
'domain'=>'admin.nodoip.com',
'profile'=>3,
'status'=>1,
'email_address'=>$_POST['email_address']


);

$user_info=insert_mysql("users",$user);

$crm_info=array(

'user_id'=>$user_info['last_id'],
'name'=>$_POST['name'],
'last_name'=>$_POST['last_name'],
'address_1'=>$_POST['address_1'],
'address_2'=>$_POST['address_2'],
'state'=>$_POST['state'],
'citi'=>$_POST['citi'],
'postal_code'=>$_POST['postal_code'],
'country'=>$_POST['country'],
'phone_1'=>$_POST['phone_1'],
'phone_2'=>$_POST['phone_2']

);

insert_mysql("crm_information",$crm_info);

$users=select_mysql("*","users","domain='admin.nodoip.com' ");
echo "<script>alert('Usuario Creado Exitosamente');</script>";
foreach($users['result'] as $s){

$crm_info_a=select_mysql("*","crm_information","user_id='".$s['id']."'");
$crm_info=$crm_info_a['result'][0];
$domains=select_mysql("*","domains","main_user='".$s['id']."'");

switch($s['status']){

case 1:
	$status="Activo";
	break;

case 2:
	$status="Inactivo";
	break;

case 3:
	$status="Eliminado";
	break;


}

$users_a[]=array(
"id"=>$s['id'],
'name'=>$crm_info['name'].",".$crm_info['last_name'],
'domains'=>$domains['count'],
'country'=>$crm_info['country'],
'status'=>$status

);

}

$asunto="Bienvenido a NodoIP";
$mensaje="
Bienvenid@ ".$_POST['name']." ".$_POST['last_name']." a la Red NodoIP
<br/>
<br/>
Felicidades y Gracias por darnos la oportunidad de darle un servicio de excelente calidad para sus comunicaciones de VozIP.
Ahora que ha creado su cuenta con nosotros puede ingresar al sitio http://localhost/nodoip/ con los siguientes accesos:
<br/>
<br/>
<b>Usuario:</b> ".$_POST['username']." <br/>
<b>Contraseña:</b> ".$_POST['password']."
<br/>
<br/>
Ahora ingrese al sitio y empice por crear su primer dominio (Empresa) y prepárese para probar nuestros servicios.
<br/>
Recuerde que tiene 7 días para probar nuestros servicios. 


 

";
$destino=$_POST['email_address'];
$nombre=$_POST['name']." ".$_POST['last_name'];

enviar_correo($asunto,$mensaje,$destino,$nombre);

dynamic_module_view("admin_portal",'users',array('users'=>$users_a));

}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
