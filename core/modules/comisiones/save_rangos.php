<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){

$datos=$_POST;
unset($datos['submitf']);


if(isset($_GET['item_id'])){

$m=update_mysql("rangos",$datos,"id=".$_GET['item_id']);


$message=label_me('saved_info')." ".label_me('with_id')." ".$_GET['item_id'];


}else{

$m=insert_mysql("rangos",$datos);

load_template('partial','header');
load_template('partial','menu');


if($m['last_id']<=0){
$message=label_me('error_saving');
}else{
$message=label_me('saved_info')." ".label_me('with_id')." ".$m['last_id'];
}



}


?>

<script>
alert('<?php echo $message; ?>');
window.location.href = '?mod=comisiones&proc=config_rangos';

</script>

<?php


}


?>