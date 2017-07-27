<?php

global $server;
global $x;

$server[$x]['version']='2.2.1.0 - Actualizacion Para Módulo de Preventa';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';


$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campos';

$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."customers` LIKE 'preventa_id'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;
if($exists==FALSE){

ejecutar("ALTER TABLE ".$tt['prefix']."customers ADD preventa_id INT(10) NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."customers ADD habeas_preventa INT(10) NOT NULL");



ejecutar("CREATE TABLE ".$tt['prefix']."preventas
(

preventa_id int(10) NOT NULL AUTO_INCREMENT,
customer_id int(10) NOT NULL ,
item_id int(10) NOT NULL ,
presale_final_price FLOAT NOT NULL ,
name varchar(256) ,
description text NOT NULL ,
fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
src_ip varchar(64) NOT NULL DEFAULT 'NOT AVAILABLE',
 PRIMARY KEY (`preventa_id`)

)

ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

");

ejecutar("ALTER TABLE ".$tt['prefix']."preventas ADD salesman_id INT(10) NOT NULL");

$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}






}


?>


<?php

global $server;
global $x;

$server[$x]['version']='2.2.1.0-1 - Confirmación de Modulo de Preventa';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por modulo Preventa';


$result = ejecutar("select * from ".$tt['prefix']."modules where module_id='preventa'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;


if($exists==FALSE){

ejecutar("insert into ".$tt['prefix']."modules (name_lang_key ,  desc_lang_key , sort , icon , module_id) values ('module_preventa','module_preventa_desc','90','star','preventa');");

ejecutar("insert into ".$tt['prefix']."permissions (module_id , person_id) values ('preventa','1');");


$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}


}








?>












<?php

global $server;
global $x;

$server[$x]['version']='2.2.1.0-2 - Actualizacion Para Módulo de Preventa';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';


$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campos';

$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."items` LIKE 'preventas_disponibles'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;
if($exists==FALSE){
ejecutar("ALTER TABLE ".$tt['prefix']."items ADD mostrar_turno_preventa INT(10) NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."items ADD mostrar_disponibles_preventa INT(10) NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."items ADD desduplicar_preventa INT(10) NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."items ADD maximo_telefono_preventa INT(10) NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."items ADD maximo_correoelectronico_preventa INT(10) NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."items ADD preventa_disponibles float NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."items ADD mostrar_preventa INT(10) NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."items ADD bloquear_na_preventa INT(10) NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."items ADD precio_preventa float NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."items ADD precio_preventa_agotada float NOT NULL");

ejecutar("ALTER TABLE ".$tt['prefix']."items ADD mensaje_exito TEXT NOT NULL");

ejecutar("ALTER TABLE ".$tt['prefix']."items ADD mensaje_preventa TEXT NOT NULL");

ejecutar("ALTER TABLE ".$tt['prefix']."items ADD mensaje_agotado TEXT NOT NULL");

ejecutar("ALTER TABLE ".$tt['prefix']."preventas ADD agotada INT(10) NOT NULL");

ejecutar("ALTER TABLE ".$tt['prefix']."preventas ADD sale_id INT(10) NOT NULL");

$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}






}


?>













<?php

global $server;
global $x;

$server[$x]['version']='2.2.1.0-3 - Actualizacion Para Módulo de Preventa';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';


$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campos';

$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."small_strikes_ip` LIKE 'ip_id'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;
if($exists==FALSE){

ejecutar("CREATE TABLE ".$tt['prefix']."small_strikes_ip
(

ip_id int(10) NOT NULL AUTO_INCREMENT,
ip varchar(32) NOT NULL ,
fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`ip_id`)

)

ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

");

ejecutar("CREATE TABLE ".$tt['prefix']."full_strikes_ip
(

ip_id int(10) NOT NULL AUTO_INCREMENT,
ip varchar(32) NOT NULL ,
fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`ip_id`)

)

ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

");

ejecutar("ALTER TABLE ".$tt['prefix']."preventas ADD salesman_id INT(10) NOT NULL");

$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}






}


?>


<?php

global $server;
global $x;

$server[$x]['version']='2.2.1.0-4 - Actualizacion Para Módulo de Preventa';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';


$server[$x]['status'].='<br/> - Revisando superadmin por campos';

$result = ejecutar("SHOW COLUMNS FROM `small_strikes_ip` LIKE 'ip_id'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;
if($exists==FALSE){

ejecutar("CREATE TABLE small_strikes_ip
(

ip_id int(10) NOT NULL AUTO_INCREMENT,
ip varchar(32) NOT NULL ,
fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`ip_id`)

)

ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

");

ejecutar("CREATE TABLE full_strikes_ip
(

ip_id int(10) NOT NULL AUTO_INCREMENT,
ip varchar(32) NOT NULL ,
fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`ip_id`)

)

ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

");

$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}

?>


<?php

global $server;
global $x;

$server[$x]['version']='2.2.1.0-2.0 - Configuracion Pedidos';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campo show_presales_button';


$result = ejecutar("SELECT * FROM `".$tt['prefix']."app_config` where `key` = 'show_presales_button'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

if($exists==FALSE){

ejecutar("insert into ".$tt['prefix']."app_config (`key`,`value`) values ('show_presales_button','NO')");



$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}


}

?>






<?php

global $server;
global $x;

$server[$x]['version']='2.2.1.0-2 - Actualizacion Para Módulo de Preventa';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';


$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campos';

$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."items` LIKE 'mostrar_inicio_preventa'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;
if($exists==FALSE){
ejecutar("ALTER TABLE ".$tt['prefix']."items ADD mostrar_afterfecha_preventa INT(10) NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."items ADD mostrar_inicio_preventa date NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."items ADD mostrar_final_preventa date NOT NULL");


$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}






}


?>








<?php

global $server;
global $x;

$server[$x]['version']='2.2.1.0-2.0 - Configuracion Pedidos';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campo show_presales_button';


$result = ejecutar("SELECT * FROM `".$tt['prefix']."app_config` where `key` = 'show_presales_button'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

if($exists==FALSE){

ejecutar("insert into ".$tt['prefix']."app_config (`key`,`value`) values ('show_presales_button','NO')");



$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}


}

?>






<?php

global $server;
global $x;

$server[$x]['version']='2.2.1.0-2 - Actualizacion Para Módulo de Preventa';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';


$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campos';

$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."items` LIKE 'mezclar_disponibles_preventa'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;
if($exists==FALSE){
ejecutar("ALTER TABLE ".$tt['prefix']."items ADD mezclar_disponibles_preventa INT(10) NOT NULL");

$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}






}


?>




<?php

global $server;
global $x;

$server[$x]['version']='2.2.1.1- Actualizacion Para Módulo de Preventa';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';


$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campos';

$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."preventas` LIKE 'deleted'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;
if($exists==FALSE){
ejecutar("ALTER TABLE ".$tt['prefix']."preventas ADD deleted INT(10) NOT NULL");

$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}






}


?>












<?php

global $server;
global $x;

$server[$x]['version']='2.2.1.2- Actualizacion Para Módulo de Preventa';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';


$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campos';

$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."people` LIKE 'preventa_id'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;
if($exists==FALSE){
ejecutar("ALTER TABLE ".$tt['prefix']."people ADD preventa_id INT(10) NOT NULL");

$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}






}


?>
