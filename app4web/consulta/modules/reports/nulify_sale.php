<?php

global $user_array;
load_template('partial','header');
load_template('partial','menu');
if(permitido($user_array['person_id'],$_GET['mod'])){


$venta=update_mysql('sales',array('anulacion'=>1),'sale_id='.$_GET['id']);

$inventory=array(

'state'=>'Disponible',
'sale_Id'=>"_NULO",
'sale_fecha'=>"_NULO",
'sale_price'=>"_NULO",
'tax_price'=>"_NULO",
'tax_percent'=>"_NULO",
'discount_percent'=>"_NULO",
'discount'=>"_NULO"

);

$it=update_mysql('inventory',$inventory,'sale_Id='.$_GET['id']);


$sales_items=array(
'anulado'=>1
);

$si=update_mysql('sales_items',$sales_items,'sale_id='.$_GET['id']);
?>

<script>
alert('Venta Anulada Exitosamente');
window.location.href="?mod=reports&proc=sales_report&finicio=<?php echo $_GET['finicio']; ?>&ffinal=<?php echo $_GET['ffinal']?>";

</script>

<?php

}
load_template('partial','footer');
?>
