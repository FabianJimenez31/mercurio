<?php

global $server;
global $x;

$server[$x]['version']='2.1.9.0.1 - Actualizacion de Modulo de Comisiones';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por modulo Comisiones';


$result = ejecutar("select * from ".$tt['prefix']."modules where module_id='comisiones'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;


if($exists==FALSE){

ejecutar("insert into ".$tt['prefix']."modules (name_lang_key ,  desc_lang_key , sort , icon , module_id) values ('module_comisiones','module_comisiones_desc','90','calculator','comisiones');");

ejecutar("insert into ".$tt['prefix']."permissions (module_id , person_id) values ('comisiones','1');");


$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}


}








?>
