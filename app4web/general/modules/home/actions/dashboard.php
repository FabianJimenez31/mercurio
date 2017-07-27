<?php
global $var_array;

if($var_array['get']['app_force_key']==md5('app4webmercuriounique')){

load_action('admin_portal','start'); 

}else{

echo "ERROR: Comuniquese con el administrador de Sistema";

}

?>
