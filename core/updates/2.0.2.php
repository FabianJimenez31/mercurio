<?php

echo "<br>2.0.2 Ejecutando Revision de Sistema de Bases de Datos";
echo "<br><br>Existe Modulo Contable en BD? ";

////validate if colummn exists

$result = ejecutar("select * from phppos_modules where module_id='contable'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

echo ($exists)?"SI":"NO [creando...]";

if($exists==FALSE){

ejecutar("insert into phppos_modules (name_lang_key ,  desc_lang_key , sort , icon , module_id) values ('module_contable','module_contable_desc','90','table','contable');");

ejecutar("insert into phppos_permissions (module_id , person_id) values ('contable','1');");


echo "<br>Creacion > [ OK ]";
}





?>
