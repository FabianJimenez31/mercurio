<?php

global $server;
global $x;

$server[$x]['version']='2.2.2.0.2 - Actualizacion de Modulo de Geeksify';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por modulo Geeksify';


$result = ejecutar("show tables like '".$tt['prefix']."geeksify_respuestas'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;


if($exists==FALSE){

ejecutar("insert into ".$tt['prefix']."modules (name_lang_key ,  desc_lang_key , sort , icon , module_id) values ('module_geeksify_cue','module_geeksify_cue_desc','90','calculator','geeksify_cue');");
ejecutar("insert into ".$tt['prefix']."permissions (module_id , person_id) values ('geeksify_cue','1');");

ejecutar("CREATE TABLE ".$tt['prefix']."geeksify_cuestionario
(

pregunta_id int(10) NOT NULL AUTO_INCREMENT,
valor varchar(255) NOT NULL ,
restar FLOAT NOT NULL,
auto_clas INT NOT NULL,
status INT NOT NULL,
 PRIMARY KEY (`pregunta_id`)

)

ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

");

ejecutar("CREATE TABLE ".$tt['prefix']."geeksify_respuestas
(
envio_id int(10),
pregunta_id int(10) NOT NULL,
valor varchar(55) NOT NULL 
)
");



$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}


}








?>
