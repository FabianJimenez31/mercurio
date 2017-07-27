<?php
global $user_array;
if(isset($_POST) && count($_POST>1)){


$email=str_replace(array("\n"," ","\t","\r"),"",$_POST['email']);
$phone_number=str_replace(array("\n"," ","\t","\r"),"",$_POST['phone_number']);

$has_email=(strlen($email)>4)?1:0;
$has_phone=(strlen($phone_number)>5)?1:0;

$validate_email=($has_email>0)?select_mysql("*","people","preventa_id>0 and email like '%$email%'"):null;

$validate_phone=($has_phone>0)?select_mysql("*","people","preventa_id>0 and phone_number like '%$phone_number%'"):null;

$confirm_email=(count($validate_email['result'])>0)?select_mysql("*","preventas","item_id=".$_POST['item_id']." and deleted=0 and customer_id=".$validate_email['result'][0]['person_id']):null;
$confirm_phone=(count($validate_phone['result'])>0)?select_mysql("*","preventas","item_id=".$_POST['item_id']."  and deleted=0 and customer_id=".$validate_phone['result'][0]['person_id']):null;



///////////

$ex=false;
if($_POST['item_id']>0 && is_numeric($_POST['item_id'])){
$producto=select_mysql("*","items","deleted=0 and mostrar_preventa=1 and item_id=".$_POST['item_id']);

$info=$producto['result'][0];
$informacion="";


$informacion.="";

$description=$info['description'];

$disponibles_a=select_mysql("*","preventas","deleted=0 and sale_id!=0 and item_id=".$_POST['item_id']);

$disponibles=(((($info['preventa_disponibles']-$disponibles_a['count'])<0) && $info['bloquear_na_preventa']==1))?0:($info['preventa_disponibles']-$disponibles_a['count']);
$lista_epera=($disponibles==0 && $info['bloquear_na_preventa']==0)?1:0;
$disponibles=($disponibles==0 && $info['bloquear_na_preventa']==0)?1:$disponibles;


$entiempo=((strtotime($info['mostrar_inicio_preventa']." 00:00:00")<time() &&  strtotime($info['mostrar_final_preventa']." 23:59:59")>time())

|| $info['mostrar_afterfecha_preventa']==1

)?1:0;

$informacion.="
<b>Descripcion</b>: 

".$info['description'];

$informacion.="

".(($disponibles>0 && $entiempo==1 && $lista_epera==0)?$info['mensaje_preventa']:$info['mensaje_agotado']);

$informacion.="

<b>Precio:</b> $ ".number_format(($disponibles>0 && $entiempo==1 && $lista_epera==0)?$info['precio_preventa']:$info['precio_preventa_agotada'],2,",",".")."

";

$precio_final=number_format(($disponibles>0 && $entiempo==1 && $lista_epera==0)?$info['precio_preventa']:$info['precio_preventa_agotada'],2,".","");

$informacion.=($info['mostrar_turno_preventa']==0 || ($entiempo==0 || $disponibles==0))?"":"

<b>Lista de Espera:</b> ".(($disponibles<=0)?abs($disponibles):"0")."

";

$informacion.=($info['mostrar_disponibles_preventa']==0)?"":"

<b>Disponibles:</b> ".(($disponibles<=0 || $entiempo==0)?"0":$disponibles)."

";

if(($disponibles!=0 && $entiempo==1 && $producto['count']>0)){
$ex=("<br/><br/><b>".$info['name']."</b><br/><br/>".str_replace(array("\n","\r"),"<br/>",$informacion));
}else{
$ex=false;
}
}


//////////////////


if($ex!=false && ($has_email==1 || $has_phone==1)){

if($confirm_email!=null || $confirm_phone!=null){

//////YA EXISTE CLIENTE
if($info['desduplicar_preventa']==1 && count($confirm_email['result']) >= $info['maximo_correoelectronico_preventa']){
load_process('preventa','main');
echo "<script>alert('Error. Correo Electronico ya Registrado para este Producto');</script>";
exit(0);
}

if($info['desduplicar_preventa']==1 && count($confirm_phone['result']) >= $info['maximo_telefono_preventa']){
load_process('preventa','main');
echo "<script>alert('Error. Telefono ya Registrado para este Producto');</script>";
exit(0);
}

global $user_id;
$client_email=($confirm_email['count']>0)?$confirm_email['result'][0]['customer_id']:false;
$client_phone=($confirm_phone['count']>0)?$confirm_phone['result'][0]['customer_id']:false;
if($client_email!=false && $client_phone==false){
$cliente_id=$client_email;
}

if($client_email==false && $client_phone!=false){
$cliente_id=$client_phone;
}

if($client_email!=false && $client_phone!=false){
$cliente_id=$client_email;
}


$turno=insert_mysql("preventas",

array(

'customer_id'=>$cliente_id,
'item_id'=>$_POST['item_id'],
'presale_final_price'=>$precio_final,
'name'=>$info['name'],
'description'=>$ex,
'src_ip'=>$_SERVER['REMOTE_ADDR'],
'salesman_id'=>(($user_id=='offlineuser')?0:$user_array['person_id']),
'agotada'=>$lista_epera

)

);

load_process('preventa','main');
echo "<script>alert('Registro Exitoso.\\nOperación Numero: ".$turno['last_id']."');</script>";


}else{

$persona=insert_mysql("people",
array(
'first_name'=>$_POST['first_name'],
'last_name'=>$_POST['last_name'],
'phone_number'=>$phone_number,
'email'=>$email


)

);
global $user_id;
$turno=insert_mysql("preventas",

array(

'customer_id'=>$persona['last_id'],
'item_id'=>$_POST['item_id'],
'presale_final_price'=>$precio_final,
'name'=>$info['name'],
'description'=>$ex,
'src_ip'=>$_SERVER['REMOTE_ADDR'],
'salesman_id'=>(($user_id=='offlineuser')?0:$user_array['person_id']),
'agotada'=>$lista_epera

)

);

$cliente=insert_mysql("customers",

array(

'person_id'=>$persona['last_id'],
'preventa_id'=>$turno['last_id'],
'habeas_preventa'=>1

)

);

update_mysql("people",array("preventa_id"=>$turno['last_id']),"person_id=".$persona['last_id']);

load_process('preventa','main');
echo "<script>alert('Registro Exitoso.\\nOperación Numero: ".$turno['last_id']."');</script>";

}


}else{

load_process('preventa','main');
echo "<script>alert('Error. Verifique su Informacion');</script>";

}



}else{

load_process('preventa','main');
echo "<script>alert('Error. Verifique su Informacion');</script>";


}
