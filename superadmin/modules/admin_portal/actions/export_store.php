<?php
global $var_array;
global $server;
global $x;
if($var_array['username']=='tiendasadmin'){

$store_id=$_GET['store_id'];

$str_arr=select_mysql("*","tiendas","id=".$store_id);
$store_info=$str_arr['result'][0];
unset($store_info['id']);

/*$tablas_a=ejecutar("SHOW TABLES LIKE '".$store_info['prefix']."%'");
$tablas_b=mostrar($tablas_a);
$tablas=array();
foreach($tablas_b as $t){

$tablas[]=$t["Tables_in_".MYSQLDB." (".$store_info['prefix']."%)"];

}
*/

$tmp_folder=APPDIR."/tmp/".$store_info['shortname'].date('YmdHis');
exec("mkdir -p $tmp_folder");
exec("mysqldump -u".MYSQLUSER." -p".MYSQLPSSWD." -h".MYSQLHOST." ".MYSQLDB." $(mysql -u".MYSQLUSER." -p".MYSQLPSSWD." -h".MYSQLHOST." -D ".MYSQLDB." -Bse \"show tables like '".$store_info['prefix']."%'\") > $tmp_folder/export.sql");

$config_php = json_encode($store_info);
$fp = fopen($tmp_folder . "/store_info.json","w");
fwrite($fp,$config_php);
fclose($fp);

exec("zip -j $tmp_folder/export.zip $tmp_folder/*");
$files=$tmp_folder."/export.zip";

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"export.zip\"");
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize($files));
ob_end_flush();
@readfile($files);



}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
