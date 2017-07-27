<?php
define('DBPREFIX','');
include("config.php");
include("sql.php");


define('APPDIR', str_replace("migrate.php","",$_SERVER['SCRIPT_FILENAME']));

$tiendas_a=select_mysql("*",'tiendas');

if($tiendas_a['count']<=0){

ejecutar("CREATE TABLE IF NOT EXISTS `tiendas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `shortname` varchar(50) NOT NULL,
  `prefix` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");

ejecutar("INSERT INTO `tiendas` (`id`, `name`, `shortname`, `prefix`) VALUES
(1, 'Tienda Inicial', 'inicial', 'phppos_');");

$new_store_dir=str_replace("superadmin/","",APPDIR)."tiendas/inicial";


exec("mkdir -p $new_store_dir");




$config_php = "<?php

define('MYSQLHOST','".MYSQLHOST."');
define('MYSQLUSER','".MYSQLUSER."');
define('MYSQLPSSWD','".MYSQLPSSWD."');
define('MYSQLDB','".MYSQLDB."');
define('DBPREFIX','phppos_');

?>";
$fp = fopen($new_store_dir . "/config.php","w");
fwrite($fp,$config_php);
fclose($fp);


$contents_php="<?php

define('SITE_NAME','Tienda Inicial');

?>";

$fp = fopen($new_store_dir . "/contents.php","w");
fwrite($fp,$contents_php);
fclose($fp);

exec("cd $new_store_dir && ln -s ../../core/* . ");


////////REWRITE CONFIG.PHP MAIN

$config_php = "<?php

define('MYSQLHOST','".MYSQLHOST."');
define('MYSQLUSER','".MYSQLUSER."');
define('MYSQLPSSWD','".MYSQLPSSWD."');
define('MYSQLDB','".MYSQLDB."');
define('DBPREFIX','');

?>";
$new_config=str_replace("superadmin/","",APPDIR);
exec("cp ".$new_config . "/config.php"." ".$new_config."/config.php.BU.".date("YmdHis"));
$fp = fopen($new_config . "/config.php","w");
fwrite($fp,$config_php);
fclose($fp);


echo "Migración En Proceso, Actualice para ver los cambios";
}else{

echo "SERVIDOR SE ENCUENTRA EN MULTITIENDA";

}
?>
