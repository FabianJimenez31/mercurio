<?php
global $user_array;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){

if(strlen($_POST['imei'])>"10" &&  $_POST['free_imei']==1 && $_POST['customer']!="-1" && $_POST['modelo']!=-1 ){

$modelo=$_POST['modelo'];

$respuestas=json_decode($_POST['respuestas'],1);
$cuenta_no=0;


foreach($respuestas as $i=>$v){
if($v==1){
$cuenta_no++;
}
}




$esquema=select_mysql("*","geeksify_modelos","modelos_id=$modelo");
$tipo_v=array(
'1'=>$esquema['result'][0]['tipo_a'],
'2'=>$esquema['result'][0]['tipo_b'],
'3'=>$esquema['result'][0]['tipo_c'],
'4'=>$esquema['result'][0]['tipo_d']);


if($cuenta_no==0){
$tipo_final=1;
}elseif($cuenta_no==1){
$tipo_final=2;
}elseif($cuenta_no>1 && $cuenta_no<6){
$tipo_final=3;
}else{
$tipo_final=4;
}
$quitar=0;

$preguntas=select_mysql("*","geeksify_cuestionario","status=1");

foreach($preguntas['result'] as $pp){

if($respuestas[$pp['pregunta_id']]==1){
if($tipo_final<$pp['auto_clas']){$tipo_final=$pp['auto_clas'];}
$quitar+=$pp['restar'];


}

}
$tipo_string=array(
'1'=>"TIPO A",
'2'=>"TIPO B",
'3'=>"TIPO C",
'4'=>"TIPO D");



$f=insert_mysql("geeksify_envio",array(
'person_id'=>$user_array['person_id'],
'client_id'=>$_POST['customer'],
'marca_id'=>$esquema['result'][0]['marca_id'],
'modelo_id'=>$esquema['result'][0]['modelos_id'],
'tipo'=>$tipo_final,
'imei'=>$_POST['imei'],
'imei_valid'=>$_POST['free_imei'],
'valor'=>($tipo_v[$tipo_final]-$quitar),
'creacion_fecha_real'=>date("Y-m-d H:i:s")
));
$gin=$f['last_id'];
foreach($respuestas as $k=>$v){

$m=insert_mysql("geeksify_respuestas",array('envio_id'=>$gin,'pregunta_id'=>$k,'valor'=>$v));

}

echo "Espere un momento por favor...    <META http-equiv=\"refresh\" content=\"1;URL=?mod=geeksify_process&proc=edit&id=$gin\">";

}else{
echo "Error en sus Datos. Revise Por favor";
}
}

?>
