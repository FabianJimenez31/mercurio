<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');
$items=select_mysql("*","requisitions_items","requisitionId=".$_GET['req_id']);
$pedido=select_mysql("*","requisitions","requisitionId=".$_GET['req_id']);
$item_info=array();
$select_options="";
$pendientes=0;
foreach($items['result'] as $it){


$item_arr=select_mysql("*","items","item_id=".$it['item_id']);
$actuales=select_mysql("*","inventory","requisitionId=".$_GET['req_id']." and trans_items=".$it['item_id']);
$totales=$it['quantity_accepts'];
$enabled=(($totales-$actuales['count'])>0)?'':'disabled';
$select_options.="<option value=\"".$it['item_id']."\">".$item_arr['result'][0]['name']." | SKU ".$item_arr['result'][0]['product_id']." [Ingresados ".$actuales['count']." de $totales]</option>";
if($enabled=='disabled'){$pendientes++;}

}
?>

<center><h1><small>Pedido <?php echo $pedido['result'][0]['requisitionNumber'];?></small></h1>

Seleccione un Item de la Lista para Iniciar el Ingreso:<select id="current_item" onchange="javascript:update_request(this.value);">
<option value="0">Seleccione un Item</option>
<?php echo $select_options; ?>
</select>

<?php
$end_ingress=(($items['count']-$pendientes)<=0)?"<br/><button class='btn-success' onclick='javascript:complete_ingress();'>Finalizar Ingreso</button>":'';
?>

<div id='complete_ingress'><?php echo $end_ingress?></div>
</center>

<div id="save_inventory">

</div>

<script>
function complete_ingress(){

$.post( "?mod=entries&proc=save", { req_id: <?php echo $_GET['req_id']?> }, function( data ) {

alert('Informacion Guardada');
window.location.href = '?mod=entries&proc=main';

});

}

function save_serial(){

$.post("?mod=entries&proc=save_item", $( "#save_serial_form" ).serialize() , function(data){

$( "#save_inventory" ).html( data.request_saving );
$( "#complete_ingress" ).html( data.complete );
if(data.update_options){

$( "#current_item" ).html( data.new_options );
}
document.getElementById("serial_number").focus();

},"json");


return false;
}


function update_request(valor){

$.post( "?mod=entries&proc=request_form", { requisition_id: <?php echo $_GET['req_id']?> , item_id: valor }, function( data ) {

$( "#save_inventory" ).html( data.request_saving );


}, "json");

}
</script>

		
		
<?php
load_template('partial','footer');
}


?>
