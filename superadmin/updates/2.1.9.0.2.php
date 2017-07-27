<?php

global $server;
global $x;

$server[$x]['version']='2.1.9.0.2 - Actualizacion de Modulo de Registros de Sistema';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por modulo Registro';


$result = ejecutar("select * from ".$tt['prefix']."modules where module_id='logger'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;


if($exists==FALSE){

ejecutar("insert into ".$tt['prefix']."modules (name_lang_key ,  desc_lang_key , sort , icon , module_id) values ('module_logger','module_logger_desc','90','terminal','logger');");

ejecutar("insert into ".$tt['prefix']."permissions (module_id , person_id) values ('logger','1');");


$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}


}








?>
