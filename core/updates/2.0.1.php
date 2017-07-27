<?php

echo "<br>2.0.1 Ejecutando Revision de Sistema de Bases de Datos";
echo "<br><br>Campo session_box existe? ";

////validate if colummn exists

$result = ejecutar("SHOW COLUMNS FROM `phppos_sales_payments` LIKE 'session_box'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

echo ($exists)?"SI":"NO [creando...]";

if($exists==FALSE){

ejecutar("ALTER TABLE phppos_sales_payments ADD session_box int(10)");

echo "<br>Creacion > [ OK ]";
}

echo "<br><br> Tabla sessions existe? ";
$result = ejecutar("SHOW TABLES LIKE 'phppos_sessions'");
$tableExists = (mysqli_num_rows($result) > 0)?TRUE:FALSE;
echo ($tableExists)?"SI":"NO";

if($tableExists==FALSE){

ejecutar("CREATE TABLE phppos_sessions (
session_id INT NOT NULL AUTO_INCREMENT,
employee_is INT NOT NULL,
session_box INT NOT NULL,
status INT NOT NULL,
date_start TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
date_end DATETIME NOT NULL,
PRIMARY KEY (session_id)
);");

echo "<br>Creacion > [ OK ]";

}


echo "<br><br> Tabla closures existe? ";
$result = ejecutar("SHOW TABLES LIKE 'phppos_closures'");
$tableExists = (mysqli_num_rows($result) > 0)?TRUE:FALSE;
echo ($tableExists)?"SI":"NO";

if($tableExists==FALSE){

ejecutar("CREATE TABLE phppos_closures (
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

echo "<br>Creacion > [ OK ]";

}



?>
