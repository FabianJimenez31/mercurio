<?php
global $var_array;

if($var_array['username']=='tiendasadmin'){

load_action('admin_portal','start'); 

}else{

echo "ERROR: Comuniquese con el administrador de Sistema";

}

?>
