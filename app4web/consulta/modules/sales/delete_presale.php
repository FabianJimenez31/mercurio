<?php
global $user_array;
load_template('partial','header');
load_template('partial','menu');
if(permitido($user_array['person_id'],$_GET['mod'])){



$m=update_mysql("presales",array('deleted'=>1),"presale_id=".$_GET['presale_id']);





?>

<script>
alert('<?php echo label_me('reg_deleted'); ?>');
window.location.href = '?mod=sales&proc=presales_main';
</script>

<?php

}
load_template('partial','footer');

?>
