<?php

global $server;
global $x;

$server[$x]['version']='2.1.8.0 - Normalizar Fechas de Venta';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por fechas dispares';


$result = ejecutar("SELECT * FROM `".$tt['prefix']."inventory` where sale_Id is not null and sale_fecha is null");
$exists = (mysqli_num_rows($result))?FALSE:TRUE;

if($exists==FALSE){

ejecutar("UPDATE ".$tt['prefix']."inventory as a 

INNER JOIN ".$tt['prefix']."sales as b
          ON a.sale_Id = b.sale_id
SET    a.sale_fecha = b.sale_time 

WHERE a.sale_Id is not null and a.sale_fecha is null");

ejecutar("UPDATE ".$tt['prefix']."inventory set sale_Id = NULL where sale_Id=0");



$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}


}








?>
