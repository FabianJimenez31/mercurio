<?php

global $server;
global $x;

$server[$x]['version']='2.1.2.1 - Instalación de Módulo de Mis Ventas';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';


$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campos de modulo';


$result = ejecutar("select * from ".$tt['prefix']."modules where module_id='mis_ventas'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

if($exists==FALSE){

ejecutar("insert into ".$tt['prefix']."modules (name_lang_key ,  desc_lang_key , sort , icon , module_id) values ('module_mis_ventas','module_mis_ventas_desc','90','table','mis_ventas');");

ejecutar("insert into ".$tt['prefix']."permissions (module_id , person_id) values ('mis_ventas','1');");


$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}


}










?>
