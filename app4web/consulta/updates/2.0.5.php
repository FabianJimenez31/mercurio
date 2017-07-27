<?php

echo "<br>2.0.5 Ejecutando Revision de Sistema de Bases de Datos";
echo "<br><br>Existe Modulo Contratos en BD? ";

////validate if colummn exists

$result = ejecutar("select * from phppos_modules where module_id='contratos'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

echo ($exists)?"SI":"NO [creando...]";

if($exists==FALSE){

ejecutar("insert into phppos_modules (name_lang_key ,  desc_lang_key , sort , icon , module_id) values ('module_contratos','module_contratos_desc','90','table','contratos');");

ejecutar("insert into phppos_permissions (module_id , person_id) values ('contratos','1');");

ejecutar("ALTER TABLE  `phppos_sales_items` 
ADD  `contrato` LONGBLOB NOT NULL ,
ADD  `contrato_type` VARCHAR(30) NOT NULL,
ADD  `contrato_extension` VARCHAR(130) NOT NULL
;");

echo "<br>Creacion > [ OK ]";
}




?>
