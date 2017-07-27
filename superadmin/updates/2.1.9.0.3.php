<?php

global $server;
global $x;

$server[$x]['version']='2.1.9.0.3 - Actualizacion de Modulo de Validaciones';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por modulo aprobaciones';


$result = ejecutar("select * from ".$tt['prefix']."modules where module_id='aprobaciones'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;


if($exists==FALSE){

ejecutar("insert into ".$tt['prefix']."modules (name_lang_key ,  desc_lang_key , sort , icon , module_id) values ('module_aprobaciones','module_aprobaciones_desc','90','check','aprobaciones');");

ejecutar("update ".$tt['prefix']."modules set icon = 'book' where module_id='contable';");

ejecutar("insert into ".$tt['prefix']."permissions (module_id , person_id) values ('aprobaciones','1');");


$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}


}








?>
