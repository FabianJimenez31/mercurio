<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');
unset($_POST['submitf']);

foreach($_POST as $k=>$v){

$km=update_mysql('app_config',array('`value`'=>$v),'`key`=\''.$k.'\'');

if($k=="inicioResolucionActual" && $v>0){
$validation=ejecutar("ALTER TABLE ".DBPREFIX."sales AUTO_INCREMENT = $v;");
}

}
?>
<script>
alert('<?php echo label_me('saved_info'); ?> <?php echo label_me('successfully'); ?>');
window.location.href = '?mod=config&proc=main';

</script>
<?php


load_template('partial','footer');
}


?>
