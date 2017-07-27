<?php

global $user_array;
load_template('partial','header');
load_template('partial','menu');
if(permitido($user_array['person_id'],$_GET['mod'])){

?>

<h3 class="page-header text-info">Reporte de Ventas del <?php echo ((isset($_POST['finicio'])) ? $_POST['finicio'] : $_GET['finicio']);?> al <?php echo ((isset($_POST['ffinal'])) ? $_POST['ffinal'] : $_GET['ffinal']);?></h3>



<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
<thead>
<tr>
<th>Venta ID</th>
<th>Fecha</th>
<th>Cliente</th>
<th>Vendedor</th>
<th>Cajero</th>
<th>Resolucion</th>
<th>Factura Manual</th>
<th>Articulos Vendidos</th>
<th>Monto Final</th>
<th>Re-Imprimir</th>
<th>Anular</th>
</tr>
</thead>
<tbody>

<?php
$finicio=((isset($_POST['finicio'])) ? $_POST['finicio'] : $_GET['finicio'])." 00:00:00";
$ffinal=((isset($_POST['ffinal'])) ? $_POST['ffinal'] : $_GET['ffinal'])." 23:59:59";
$sales=select_mysql("*",'sales',"sale_time>='$finicio' and sale_time<='$ffinal'");


foreach($sales['result'] as $s){

$cl_a=select_mysql('*','people','person_id='.$s['customer_id']);
$client=utf8_encode($cl_a['result'][0]['first_name']." ".$cl_a['result'][0]['last_name']);

$ch_a=select_mysql('*','people','person_id='.$s['employee_id']);
$cashier=utf8_encode($ch_a['result'][0]['first_name']." ".$ch_a['result'][0]['last_name']);

$v_a=($s['cc_ref_no']!="")? select_mysql('*','presales','presale_id='.$s['cc_ref_no']) : false;
$v_b=($v_a) ? select_mysql('*','people','person_id='.$v_a['result'][0]['employee_id']) : false;
$seller=($v_a) ? utf8_encode($v_b['result'][0]['first_name']." ".$v_b['result'][0]['last_name']) : 'N/A'; 

if($seller=="N/A"){
$v_a=($s['salesman']>0)? true : false;
$v_b=($v_a) ? select_mysql('*','people','person_id='.$s['salesman']) : false;
$seller=($v_a) ? utf8_encode($v_b['result'][0]['first_name']." ".$v_b['result'][0]['last_name']) : 'N/A'; 
}

$count_items=select_mysql('*','sales_items','sale_id='.$s['sale_id']);
$ammounts=0;
$taxes=0;
foreach($count_items['result'] as $i){

$ammounts+=$i['item_unit_price'];

$tx=select_mysql('*','sales_items_taxes','sale_id='.$s['sale_id'].' and item_id='.$i['item_id']);
if($tx['result'][0]['percent']>0){
$v_t=$i['item_unit_price']*(($tx['result'][0]['percent']/100));
$taxes+=$v_t;
}

}

$item_kits=select_mysql("*",'sales_item_kits','sale_id='.$s['sale_id']);

foreach($item_kits['result'] as $ik){

$ammounts+=$ik['item_kit_unit_price'];

$tx=select_mysql("*","sales_item_kits_taxes",'sale_id='.$s['sale_id'].' and item_kit_id='.$ik['item_kit_id']);
if($tx['result'][0]['percent']>0){

$v_t=$ik['item_kit_unit_price']*(($tx['result'][0]['percent']/100));
$taxes+=$v_t;

}

$ik_q=substr($ik['description'],1);
$ik_m=explode("|",$ik_q);
$count_items['count']+=count($ik_m);


}

$total="$".number_format($ammounts+$taxes,2,',','.');


echo "

<tr>
<td>".$s['sale_id']."</td>
<td>".$s['sale_time']."</td>
<td>$client</td>
<td>$seller</td>
<td>$cashier</td>
<td>".(($s['resolucion'])?  $s['resolucion']: 'N/A' )."</td>
<td>".(($s['id_manual'])?  $s['id_manual']: 'N/A' )."</td>
<td>".$count_items['count']."</td>
<td>$total</td>
<td><a href='?mod=receipts&proc=sales&id=".$s['sale_id']."' target=\"_blank\">Re-Imprimir</a></td>
<td>".(($s['anulacion']==1) ? 'Anulada' : "<a href='?mod=reports&proc=nulify_sale&finicio=".$_POST['finicio']."&ffinal=".$_POST['ffinal']."&id=".$s['sale_id']."' onclick=\"javascript: return confirm('¿Está Seguro de Anular Esta Venta?\\nEsta Acción no puede ser Deshecha');\">Anular</a>")."</td>
</tr>

";

}

?>

</tbody>
</form>
</table>

<script>

$(document).ready(function() {
var table =   $('#example').dataTable( {
	"bJQueryUI": true,
	"aaSorting": [[ 0, "asc" ]],
        "sPaginationType": "full_numbers",
	"aLengthMenu": [[10, 50, 100,500, -1], [10, 50, 100,500, "Todos"]],
	
    } );

});


</script>

<?php


}
load_template('partial','footer');
?>
