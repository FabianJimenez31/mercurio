<?php
global $user_array;
load_template('partial','header');
load_template('partial','menu');
if(permitido($user_array['person_id'],$_GET['mod'])){
$rid=$_GET['req_id'];
$datos=$_POST;

$rq=array(
'acceptsDate'=>date('Y-m-d H:i:s'),
'state'=>'Recibido'
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

}
load_template('partial','footer');

?>
