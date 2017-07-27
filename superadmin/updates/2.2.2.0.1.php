<?php

global $server;
global $x;

$server[$x]['version']='2.2.2.0.1 - Actualizacion de Modulo de Geeksify';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por modulo Geeksify';


$result = ejecutar("select * from ".$tt['prefix']."modules where module_id='geeksify_receive'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;


if($exists==FALSE){

ejecutar("insert into ".$tt['prefix']."modules (name_lang_key ,  desc_lang_key , sort , icon , module_id) values ('module_geeksify_receive','module_geeksify_receive_desc','90','calculator','geeksify_receive');");

ejecutar("insert into ".$tt['prefix']."modules (name_lang_key ,  desc_lang_key , sort , icon , module_id) values ('module_geeksify_process','module_geeksify_process_desc','90','calculator','geeksify_process');");

ejecutar("insert into ".$tt['prefix']."permissions (module_id , person_id) values ('geeksify_process','1');");
ejecutar("insert into ".$tt['prefix']."permissions (module_id , person_id) values ('geeksify_receive','1');");


$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}


}








?>
