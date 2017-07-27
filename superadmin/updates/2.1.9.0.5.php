<?php

global $server;
global $x;

$server[$x]['version']='2.1.9.0.5 - Normalizar Fechas de Aprobacion de Ventas';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por fechas dispares';


$result = ejecutar("SELECT * FROM `".$tt['prefix']."sales_items` where is_aprobada!=0 and aprobacion_fecha_real='0000-00-00 00:00:00'");
$exists = (mysqli_num_rows($result))?FALSE:TRUE;

if($exists==FALSE){

ejecutar("UPDATE ".$tt['prefix']."sales_items set 

aprobacion_fecha_real=aprobacion_fecha

where is_aprobada!=0 and aprobacion_fecha_real='0000-00-00 00:00:00'");





$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}


}








?>
