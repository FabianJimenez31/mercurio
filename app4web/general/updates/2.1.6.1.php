<?php

global $server;
global $x;

$server[$x]['version']='2.1.6.1 - Permite Recepcion de Pedidos Adicionales cuando Falta Producto';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campo prev_id';


$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."requisitions` LIKE 'prev_id'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

if($exists==FALSE){

ejecutar("alter table ".$tt['prefix']."requisitions add prev_id int(10) not null");
ejecutar("alter table ".$tt['prefix']."requisitions add force_close int(10) not null");



$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}


}








?>
