<?php

global $server;
global $x;

$server[$x]['version']='2.0.1 - Actualizacion de Session Box para Control de Cajas';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';


$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campo session_box en sales_payments';

$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."sales_payments` LIKE 'session_box'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;
if($exists==FALSE){


ejecutar("ALTER TABLE ".$tt['prefix']."sales_payments ADD session_box int(10)");

$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}


$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por Tabla sessions';

$result = ejecutar("SHOW TABLES LIKE '".$tt['prefix']."sessions'");
$tableExists = (mysqli_num_rows($result) > 0)?TRUE:FALSE;
if($tableExists==FALSE){
$server[$x]['status'].=" - Necesita Actualizar";

ejecutar("CREATE TABLE ".$tt['prefix']."sessions (
session_id INT NOT NULL AUTO_INCREMENT,
employee_is INT NOT NULL,
session_box INT NOT NULL,
status INT NOT NULL,
date_start TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
date_end DATETIME NOT NULL,
PRIMARY KEY (session_id)
);");

}else{
$server[$x]['status'].=" - Actualizado";

}



$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por Tabla closures';

$result = ejecutar("SHOW TABLES LIKE '".$tt['prefix']."closures'");
$tableExists = (mysqli_num_rows($result) > 0)?TRUE:FALSE;
if($tableExists==FALSE){
$server[$x]['status'].=" - Necesita Actualizar";

ejecutar("CREATE TABLE ".$tt['prefix']."closures (
closures_id INT NOT NULL AUTO_INCREMENT,
employee_id INT NOT NULL,
session_box INT NOT NULL,
start FLOAT NOT NULL,
system_start FLOAT NOT NULL,
end FLOAT NOT NULL,
system_end FLOAT NOT NULL,
approval INT NOT NULL,
payment_type varchar(100) NOT NULL,
date_end DATETIME NOT NULL,
PRIMARY KEY (closures_id)
);");

}else{
$server[$x]['status'].=" - Actualizado";

}




}









?>
