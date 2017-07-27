<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){

$datos=$_POST;
unset($datos['submitf']);


if(isset($_GET['item_id'])){

$m=update_mysql("cuentascontables",$datos,"id=".$_GET['item_id']);


$message="Artículo Guardado Exitosamente con ID ".$_GET['item_id'];


}else{

$m=insert_mysql("cuentascontables",$datos);

load_template('partial','header');
load_template('partial','menu');


if($m['last_id']<=0){
$message="Hubo un error al Guardar su informacion, verifique sus datos e intente de nuevo";
}else{
$message="Artículo Guardado Exitosamente con ID ".$m['last_id'];
}



}


?>

<script>
alert('<?php echo $message; ?>');
window.location.href = '?mod=contable&proc=config_cat';

</script>

<?php


}


?>
