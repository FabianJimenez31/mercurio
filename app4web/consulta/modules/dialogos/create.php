<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');
unset($_POST['submitf']);



$km=insert_mysql('messages',$_POST);



?>
<script>
alert('Informacion Guardada Exitosamente');
window.location.href = '?mod=dialogos&proc=main';

</script>
<?php


load_template('partial','footer');
}


?>
