<?php

global $server;
global $x;

$server[$x]['version']='2.0.5 - Instalación de Módulo de Contratos';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';


$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campos de contratos';


$result = ejecutar("select * from ".$tt['prefix']."modules where module_id='contratos'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

if($exists==FALSE){

ejecutar("insert into ".$tt['prefix']."modules (name_lang_key ,  desc_lang_key , sort , icon , module_id) values ('module_contratos','module_contratos_desc','90','table','contratos');");

ejecutar("insert into ".$tt['prefix']."permissions (module_id , person_id) values ('contratos','1');");

ejecutar("ALTER TABLE  `".$tt['prefix']."sales_items` 
ADD  `contrato` LONGBLOB NOT NULL ,
ADD  `contrato_type` VARCHAR(30) NOT NULL,
ADD  `contrato_extension` VARCHAR(130) NOT NULL
;");

$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}


}










?>
