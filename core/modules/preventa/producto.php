<?php
if($_GET['item_id']>0 && is_numeric($_GET['item_id'])){
$producto=select_mysql("*","items","deleted=0 and mostrar_preventa=1 and item_id=".$_GET['item_id']);

$info=$producto['result'][0];
$informacion="";


$informacion.="";

$description=$info['description'];

$disponibles_a=select_mysql("*","preventas","deleted=0 and sale_id!=0 and item_id=".$_GET['item_id']);

$disponibles=(((($info['preventa_disponibles']-$disponibles_a['count'])<0) && $info['bloquear_na_preventa']==1))?0:($info['preventa_disponibles']-$disponibles_a['count']);
$lista_epera=($disponibles==0 && $info['bloquear_na_preventa']==0)?1:0;
$disponibles=($disponibles==0 && $info['bloquear_na_preventa']==0)?1:$disponibles;


$entiempo=((strtotime($info['mostrar_inicio_preventa']." 00:00:00")<time() &&  strtotime($info['mostrar_final_preventa']." 23:59:59")>time())

|| $info['mostrar_afterfecha_preventa']==1

)?1:0;

$informacion.="
<b>Descripcion</b>: 

".$info['description'];

$informacion.="

".(($disponibles>0 && $entiempo==1 && $lista_epera==0)?$info['mensaje_preventa']:$info['mensaje_agotado']);

$informacion.="

<b>Precio:</b> $ ".number_format(($disponibles>0 && $entiempo==1 && $lista_epera==0)?$info['precio_preventa']:$info['precio_preventa_agotada'],2,",",".")."

";

$informacion.=($info['mostrar_turno_preventa']==0 || ($entiempo==0 || $disponibles==0))?"":"

<b>Lista de Espera:</b> ".(($disponibles<=0)?abs($disponibles):"0")."

";

$informacion.=($info['mostrar_disponibles_preventa']==0)?"":"

<b>Disponibles:</b> ".(($disponibles<=0 || $entiempo==0)?"0":$disponibles)."

";

if(($disponibles!=0 && $entiempo==1)){
$informacion.="

					<div class=\"form-actions\">
				<input type=\"submit\" name=\"submitf\" value=\"Reservar\" id=\"submitf\" class=\"submit_button btn btn-primary\"  />				</div>

";
}

$ex=("<br/><br/><b>".$info['name']."</b><br/><br/>".str_replace(array("\n","\r"),"<br/>",$informacion));
echo $ex;
}
?>
