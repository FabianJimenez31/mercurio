<?php

global $user_array;
global $current_traslado;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){
$body="";
session_start();
$_SESSION['traslado']=$current_traslado;
session_write_close ();

$responder=array();


$responder['referencial']=$current_traslado['referencial'];
$responder['tabla']="";
if(count($current_traslado['articulos'])>0){
//$current_traslado['articulos'][$_POST['referencia']][$_POST['numero']]=$_POST['inventario'];
foreach($current_traslado['articulos'] as $sku=>$inf){

$responder['tabla'].= "<tr>";

$responder['tabla'].= "<td>".$sku."</td><td>".count($current_traslado['articulos'][$sku])."</td><td>";

foreach($inf as $serial=>$id){

foreach($id as $r=>$val){

$responder['tabla'].="<p>$serial <a href=\"#articulos\" class=\"hidden-print\" onclick=\"javascript: elimina_serial('".$val."');\">Quitar</a></p>";

}
}

$responder['tabla'].= "</td></tr>";
}
}else{
$responder['tabla']="<tr><td colspan=\"4\">No se han Agregado Artículos a este Apartado</td></tr>";
}

$responder['send_address']=$current_traslado['send_address'];
$responder['comments']=$current_traslado['comments'];
$responder['location_id']=$current_traslado['location_id'];

if($current_traslado['location_id']>0){

$direccion=select_mysql("*","locations","location_id=".$current_traslado['location_id']);

$responder['location_text']=str_replace(array("\n","\r"),"<br/>",$direccion['result'][0]['address'])."<br/>".$direccion['result'][0]['phone']."<br/>".$direccion['result'][0]['email'];

}

echo json_encode($responder);

}
