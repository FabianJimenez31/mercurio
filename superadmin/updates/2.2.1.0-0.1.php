<?php

global $server;
global $x;

$server[$x]['version']='2.2.1.0-0.1 - Permitir/Rechazar Seriales Duplicados en Artículos Diferentes';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campo todos_seriales_diferentes_global';


$result = ejecutar("SELECT * FROM `".$tt['prefix']."app_config` where `key` = 'todos_seriales_diferentes_global'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

if($exists==FALSE){

ejecutar("insert into ".$tt['prefix']."app_config (`key`,`value`) values ('todos_seriales_diferentes_global','N')");



$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}


}


