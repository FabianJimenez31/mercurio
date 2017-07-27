<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');
$items=select_mysql("*","requisitions_items","requisitionId=".$_GET['req_id']);
$pedido=select_mysql("*","requisitions","requisitionId=".$_GET['req_id']);
?>


<form action="?mod=accepts&proc=save&req_id=<?php echo $_GET['req_id']; ?>" method="post" accept-charset="utf-8" id="item_form" class="form-horizontal">
<input type="hidden" name="req_id" value="<?php echo $_GET['req_id']; ?>"/>
<br/><br/>
<div class="form-group">
	<label for="provider_invoice" class="col-md-2">Factura Proveedor:</label>
		<div class="col-md-3">
			<input type="text"  class="form-control form-inps" name="provider_invoice" value=""/>
		</div>
</div>
<br/><br/>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered nowrap dt-responsive" id="example" width="100%">
<thead>
<tr>
<th><?php echo label_me('item'); ?></th>
<th><?php echo label_me('sku'); ?></th>
<th><?php echo label_me('q_requested'); ?></th>
<th><?php echo label_me('q_received'); ?></th>
</tr>
</thead>

<tbody>


<?php
foreach($items['result'] as $i){

$item_id=$i['item_id'];
$si=select_mysql("*","items","item_id=$item_id");
$fila=$i['requisitionItemId'];
$nombre=$si['result'][0]['name'];
$sku=$si['result'][0]['product_id'];
$cantidad=$i['quantity'];
$anterior=(isset($_POST['item_'.$fila]) && $_POST['item_'.$fila]>0)?$_POST['item_'.$fila]:'0';
$a_recibir="<input type=\"hidden\" name=\"items[]\" value=\"$fila\" /><input type=\"number\" name=\"item_$fila\" value=\"$anterior\" />";

echo "
<tr>
<td>$nombre</td>
<td>$sku</td>
<td>$cantidad</td>
<td>$a_recibir</td>
</tr>
";


}

?>

</tbody>

</table>

					<div class="form-actions">
				<input type="submit" name="submitf" value="<?php echo label_me('end'); ?>" id="submitf" class="submit_button btn btn-primary"  />				</div>
			</form>			
			
		

<script>

$(document).ready(function() {
var table =   $('#example').dataTable( {
       	
    } );
});

</script>




		
		
<?php
load_template('partial','footer');
}


?>
