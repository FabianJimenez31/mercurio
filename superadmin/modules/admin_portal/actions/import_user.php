<?php
global $var_array;
global $server;
global $x;
if($var_array['username']=='tiendasadmin'){



$new_store=insert_mysql("tiendas",array('name'=>guid()));

$store_name="store_".$new_store['last_id'];
$prefix="store".$new_store['last_id']."_";

update_mysql("tiendas",array(
'shortname'=>$store_name,
'prefix'=>$prefix,
),"id='".$new_store['last_id']."'");

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

$temporal_import_folder=APPDIR."tmp/newstore_".date("YmdHis");

exec("mkdir -p $temporal_import_folder");
move_uploaded_file($_FILES["files"]["tmp_name"],$temporal_import_folder."/export.zip");

exec("unzip $temporal_import_folder/export.zip -d $temporal_import_folder/");

$store_info=json_decode(file_get_contents("$temporal_import_folder/store_info.json"));



update_mysql("tiendas",array(
'name'=>$store_info->name
),"id='".$new_store['last_id']."'");


$new_sql=$temporal_import_folder."/export.sql";

$edited_sql=str_replace($store_info->prefix,$prefix,file_get_contents($new_sql));
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

}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
