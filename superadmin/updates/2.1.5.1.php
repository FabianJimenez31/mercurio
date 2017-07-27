<?php

global $server;
global $x;

$server[$x]['version']='2.1.5.1 - Modulo de Cierre General';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por modulo de Cierre General';


$result = ejecutar("select * from ".$tt['prefix']."modules where module_id='cierre_general'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

if($exists==FALSE){

ejecutar("insert into ".$tt['prefix']."modules (name_lang_key ,  desc_lang_key , sort , icon , module_id) values ('module_cierre_general','module_cierre_general_desc','92','lock','cierre_general');");

ejecutar("insert into ".$tt['prefix']."permissions (module_id , person_id) values ('cierre_general','1');");

ejecutar("alter table ".$tt['prefix']."closures add force_closed int(10) not null");
ejecutar("alter table ".$tt['prefix']."sessions add force_closed int(10) not null");



$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}


}








?>
