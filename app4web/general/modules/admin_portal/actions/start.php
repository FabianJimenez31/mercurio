<?php
global $var_array;
if($var_array['get']['app_force_key']==md5('app4webmercuriounique')){



dynamic_view("partial/admin_header",$_GET);




}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
