<?php

global $user_array;
global $current_traslado;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){


update_mysql("traslados_items",array('regresado'=>'1','cancelacion'=>$_POST['razon']),'tx_id='.$_GET['tx_id']);

$ttte=select_mysql("*",'traslados_items','tx_id='.$_GET['tx_id']);

$traslado_id=$ttte['result'][0]['traslados_id'];


$person_trasladado_array=select_mysql("*","people","person_id=".$user_array['person_id']);
$person_trasladado=$person_trasladado_array['result'][0];
$comentarios_adicionales="
---------------------------------------------------------
Usuario: ".$user_array['username']."
Personal: ".$person_trasladado['first_name']." ".$person_trasladado['last_name']."
Operación: Devolución de Artículo de la Órden de Traslado con ID Interno ".$traslado_id."
Fecha / Hora: ".date("d-m-Y H:i:s")."

SKU: ".$ttte['result'][0]['sku']."
Serial: ".$ttte['result'][0]['serial']."
Razón: ".$_POST['razon']."
---------------------------------------------------------
";
insert_mysql("traslados_history",array('traslados_id'=>$traslado_id , 'cuando'=>date("Y-m-d H:i:s"),'comments'=>$comentarios_adicionales));


//////SSSS

$articulos=select_mysql("*","traslados_items","traslados_id=".$traslado_id);
$current_traslado=array();

foreach($articulos['result'] as $ttt){
$current_traslado['articulos'][$ttt['sku']][$ttt['serial']][$ttt['inventory_id']]['inventory_id']=$ttt['inventory_id'];
$current_traslado['articulos'][$ttt['sku']][$ttt['serial']][$ttt['inventory_id']]['regresado']=$ttt['regresado'];
$current_traslado['articulos'][$ttt['sku']][$ttt['serial']][$ttt['inventory_id']]['cancelacion']=$ttt['cancelacion'];
$current_traslado['articulos'][$ttt['sku']][$ttt['serial']][$ttt['inventory_id']]['tx_id']=$ttt['tx_id'];
}
$responder="";
if(count($current_traslado['articulos'])>0){
//$current_traslado['articulos'][$_POST['referencia']][$_POST['numero']]=$_POST['inventario'];
foreach($current_traslado['articulos'] as $sku=>$inf){

$responder.= "<tr>";

$responder.= "<td>".$sku."</td><td>".count($current_traslado['articulos'][$sku])."</td><td>";

foreach($inf as $serial=>$id){

foreach($id as $r=>$val){

if($val['regresado']=="1"){

$responder.="<p><strike><del>$serial</del></strike> [Devuelto] <a class=\"btn btn-warning btn-sm\" onclick=\"javascript: return cancelar_devolucion('".$val['tx_id']."');\">Cancelar Devolución</a></p>";

}else{

$responder.="<p>$serial <a class=\"btn btn-success btn-sm\" onclick=\"javascript: return cancelar_item('".$val['tx_id']."');\">Generar Devolución</a></p>";
}

}
}

$responder.= "</td></tr>";
}
}else{
$responder="<tr><td colspan=\"4\">No hay Artículos en esta Órden de Traslado</td></tr>";
}

echo $responder;

//////eeee

}
