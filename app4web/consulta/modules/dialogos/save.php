<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');
unset($_POST['submitf']);

foreach($_POST as $k=>$v){

$km=update_mysql('messages',array('`label`'=>$v),'`tag`=\''.$k.'\'');


}
?>
<script>
alert('Informacion Guardada Exitosamente');
window.location.href = '?mod=dialogos&proc=main';

</script>
<?php


load_template('partial','footer');
}


?>
