<?php

global $server;
global $x;

$server[$x]['version']='2.0.2 - Actualizacion de Modulo Contable';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por modulo contable';


$result = ejecutar("select * from ".$tt['prefix']."modules where module_id='contable'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;


if($exists==FALSE){

ejecutar("insert into ".$tt['prefix']."modules (name_lang_key ,  desc_lang_key , sort , icon , module_id) values ('module_contable','module_contable_desc','90','table','contable');");

ejecutar("insert into ".$tt['prefix']."permissions (module_id , person_id) values ('contable','1');");


$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}


}








?>
