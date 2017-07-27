<?php

global $server;
global $x;

$server[$x]['version']='2.1.5.1-3 - Modulo de Cierre General [complementario]';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campo global_id';


$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."closures` LIKE 'global_id'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

if($exists==FALSE){

ejecutar("alter table ".$tt['prefix']."closures add global_id int(10) not null");
ejecutar("alter table ".$tt['prefix']."sessions add global_id int(10) not null");



$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}


}








?>
