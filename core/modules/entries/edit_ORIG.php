<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');
$items=select_mysql("*","requisitions_items","requisitionId=".$_GET['req_id']);
$pedido=select_mysql("*","requisitions","requisitionId=".$_GET['req_id']);
?>


<form action="?mod=entries&proc=save&req_id=<?php echo $_GET['req_id']; ?>" onsubmit="javascript:return confirm('¿Desea Terminar este Ingreso?\n Este Cambio no podrá deshacerse');" method="post" accept-charset="utf-8" id="item_form" class="form-horizontal">
<input type="hidden" name="req_id" value="<?php echo $_GET['req_id']; ?>"/>
<table cellpadding="0" cellspacing="0" border="0" class="display responsive nowrap" id="example" width="100%">
<thead>
<tr>
<th>Articulo</th>
<th>SKU</th>
<th>Serial</th>
</tr>
</thead>

<tbody>


<?php
$cuanto=1;
foreach($items['result'] as $i){

$item_id=$i['item_id'];
$si=select_mysql("*","items","item_id=$item_id");
$fila=$i['requisitionItemId'];
$nombre=$si['result'][0]['name'];
$sku=$si['result'][0]['product_id'];
$cantidad=$i['quantity_accepts'];



for($x=1;$x<=$cantidad;$x++){

$a_recibir="<input type='hidden' name='item_id-$cuanto' value='$item_id'><input type='text' name='serial-$cuanto'>";

echo "
<tr>
<td>$nombre</td>
<td>$sku</td>
<td>$a_recibir</td>
</tr>
";
$cuanto++;
}


}

?>

</tbody>

</table>
<input type="hidden" name="cuantos" value="<?php echo $cuanto;?>">
					<div class="form-actions">
				<input type="submit" name="submitf" value="Terminar" id="submitf" class="submit_button btn btn-primary"  />				</div>
			</form>			
			
		

<script>

$(document).ready(function() {
var table =   $('#example').dataTable( {
	responsive : true,
	"bJQueryUI": true,
	"aaSorting": [[ 0, "asc" ]],
        "bPaginate": false,
	"aLengthMenu": [[10, 50, 100,500, -1], [10, 50, 100,500, "Todos"]]

	
    } );
});

</script>




		
		
<?php
load_template('partial','footer');
}


?>
