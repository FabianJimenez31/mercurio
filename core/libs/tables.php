<?php

function table_pagination($table,$conditions='',$actual=false,$intervalo=500){

//Limito la busqueda 
$TAMANO_PAGINA = $intervalo; 

//examino la página a mostrar y el inicio del registro a mostrar 
$pagina = $actual; 
if (!$pagina) { 
   	$inicio = 0; 
   	$pagina=1; 
} 
else { 
   	$inicio = ($pagina - 1) * $TAMANO_PAGINA; 
}

$registros=select_mysql("*",$table,$conditions);

$num_total_registros=$registros['count'];

$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA); 

//pongo el número de registros total, el tamaño de página y la página que se muestra 
$m= "Número de registros encontrados: " . $num_total_registros . "<br>".
"Se muestran páginas de " . $TAMANO_PAGINA . " registros cada una<br>".
"Mostrando la página " . $pagina . " de " . $total_paginas . "<p>";
$r['paginas']=$total_paginas;
$r['actual']=$pagina;
$r['tamano']=$TAMANO_PAGINA;
$r['result']=$registros['result'];
$r['registros']=$num_total_registros;
return $r;

}

?>
