<?php



global $user_array;
global $application_config;


if(permitido($user_array['person_id'],$_GET['mod'])){

if($application_config['force_provider_invoice']!='N' && strlen($_POST['provider_invoice'])<1){

load_process('accepts','edit');

echo "<script>alert('Debe introducir el Numero de Factura del Proveedor');</script>";


}else{


load_template('partial','header');
load_template('partial','menu');

$rid=$_GET['req_id'];
$datos=$_POST;

$rq=array(
'acceptsDate'=>date('Y-m-d H:i:s'),
'state'=>'Recibido',
'provider_invoice'=>$_POST['provider_invoice']
);

update_mysql('requisitions',$rq,"requisitionId=$rid");

foreach($datos['items'] as $i){

$datos['item_'.$i]=($datos['item_'.$i]<=0)?'0':$datos['item_'.$i];

update_mysql('requisitions_items',array('quantity_accepts'=>$datos['item_'.$i]),'requisitionItemId='.$i);

}

?>

<script>
alert('<?php echo label_me('saved_info'); ?>');
window.location.href = '?mod=accepts&proc=main';
</script>

<?php
load_template('partial','footer');
}
}


?>
