<?php
global $var_array;
global $server;
global $x;
if($var_array['username']=='tiendasadmin'){



$myid = mysqli_connect($_POST['host'],$_POST['user'], $_POST['password']);

if($myid==false){
//mysqli_select_db($myid,$mydb);

$_POST['resp']="<div style='color:red;'>NO SE PUDO ESTABLECER LA CONEXION CON LA BASE DE DATOS. VERIFIQUE SU INFORMACION</div>";

dynamic_module_view("admin_portal",'import_client_mysql',$_POST);
}else{


$check_db=mysqli_select_db($myid,$_POST['database']);

if($check_db==false){

$_POST['resp']="<div style='color:red;'>EL NOMBRE DE BASE DE DATOS MYSQL ES INCORRECTO. NO EXITE ESA BASE EN EL SERVIDOR. VERIFIQUE SU INFORMACION Y PRUEBE DE NUEVO</div>";

dynamic_module_view("admin_portal",'import_client_mysql',$_POST);


}else{

$prefix_validation=mysqli_query($myid,"SELECT * FROM ".stripslashes($_POST['prefix'])."app_config");
$resultado=mysqli_num_rows($prefix_validation);

if($resultado<=0){

$_POST['resp']="<div style='color:red;'>EL PREFIJO ESCRITO NO ES VÁLIDO. VERIFIQUE SU INFORMACION Y PRUEBE DE NUEVO</div>";

dynamic_module_view("admin_portal",'import_client_mysql',$_POST);

}else{

//////IMPORTACION MYSQL


////GENERACION DE INFORMACION DE TIENDA

$new_store=insert_mysql("tiendas",array('name'=>$_POST['name'],'aliases'=>$_POST['aliases']));

$store_name="store_".$new_store['last_id'];
$prefix="store".$new_store['last_id']."_";

update_mysql("tiendas",array(
'shortname'=>$store_name,
'prefix'=>$prefix,
),"id='".$new_store['last_id']."'");

////GENERACION DE EXPORT.SQL

$tmp_folder=APPDIR."/tmp/".$store_name.date('YmdHis');
exec("mkdir -p $tmp_folder");
exec("mysqldump -u".$_POST['user']." -p".$_POST['password']." -h".$_POST['host']." ".$_POST['database']." $(mysql -u".$_POST['user']." -p".$_POST['password']." -h".$_POST['host']." -D ".$_POST['database']." -Bse \"show tables like '".$_POST['prefix']."%'\") > $tmp_folder/export.sql");

////INICIA GENERACION E IMPORTACION

$new_store_dir=str_replace("superadmin/","",APPDIR)."tiendas/".$store_name;


exec("mkdir -p $new_store_dir");




$config_php = "<?php

define('MYSQLHOST','".MYSQLHOST."');
define('MYSQLUSER','".MYSQLUSER."');
define('MYSQLPSSWD','".MYSQLPSSWD."');
define('MYSQLDB','".MYSQLDB."');
define('DBPREFIX','".$prefix."');

?>";
$fp = fopen($new_store_dir . "/config.php","w");
fwrite($fp,$config_php);
fclose($fp);


$contents_php="<?php

define('SITE_NAME','".$_POST['name']."');

?>";

$fp = fopen($new_store_dir . "/contents.php","w");
fwrite($fp,$contents_php);
fclose($fp);

exec("cd $new_store_dir && ln -s ../../core/* . ");

$temporal_import_folder=$tmp_folder;

$new_sql=$temporal_import_folder."/export.sql";

$edited_sql=str_replace($_POST['prefix'],$prefix,file_get_contents($new_sql));
$edited_root=APPDIR . "tmp/".$store_name.".sql";

$fp = fopen(APPDIR . "tmp/".$store_name.".sql","w");
fwrite($fp,$edited_sql);
fclose($fp);

exec("mysql -u".MYSQLUSER." -p".MYSQLPSSWD." -h".MYSQLHOST." ".MYSQLDB." < $edited_root");

echo "<script>alert('Tienda Creada');</script>";

$users=select_mysql("*","tiendas","deleted!=1");

foreach($users['result'] as $s){

$users_a[]=array(
"id"=>$s['id'],
"name"=>$s['name'],
"prefix"=>$s['prefix'],
"shortname"=>$s['shortname'],
"aliases"=>$s['aliases']


);

}

dynamic_module_view("admin_portal",'users',array('users'=>$users_a));

/////FIN IMPORTACION MYSQL

}


}




}



}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
