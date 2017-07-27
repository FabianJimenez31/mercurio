<?php

global $server;
global $x;

$server[$x]['version']='2.1.4.2 - Modulo de Supervisores';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por modulo de Supervisores';


$result = ejecutar("select * from ".$tt['prefix']."modules where module_id='supervisores'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

if($exists==FALSE){

ejecutar("insert into ".$tt['prefix']."modules (name_lang_key ,  desc_lang_key , sort , icon , module_id) values ('module_supervisores','module_supervisores_desc','92','table','supervisores');");

ejecutar("insert into ".$tt['prefix']."permissions (module_id , person_id) values ('supervisores','1');");

ejecutar("alter table ".$tt['prefix']."sales add supervisor int(10) not null");

ejecutar("alter table ".$tt['prefix']."employees add supervisor int(10) not null");
ejecutar("alter table ".$tt['prefix']."employees add supervisor_who int(10) not null");


$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}


}








?>
