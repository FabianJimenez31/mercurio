<?php
global $user_array;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){

if($_POST['modelo']!="-1"){


$respuestas=array();
$cuenta_no=0;
foreach($_POST as $i=>$v){

$pos = strpos($i, 'regunt');

if($i=="modelo"){

$modelo=$v;

}elseif($pos !== false){

$respuestas[(str_replace("pregunta_","",$i))]=$v;
if($v==1){
$cuenta_no++;
}
}


}

$esquema=select_mysql("*","geeksify_modelos","modelos_id=$modelo");
$tipo_v=array(
'1'=>$esquema['result'][0]['tipo_a'],
'2'=>$esquema['result'][0]['tipo_b'],
'3'=>$esquema['result'][0]['tipo_c'],
'4'=>$esquema['result'][0]['tipo_d']);


if($cuenta_no==0){
$tipo_final=1;
}elseif($cuenta_no==1){
$tipo_final=2;
}elseif($cuenta_no>1 && $cuenta_no<6){
$tipo_final=3;
}else{
$tipo_final=4;
}
$quitar=0;

$preguntas=select_mysql("*","geeksify_cuestionario","status=1");

foreach($preguntas['result'] as $pp){

if($respuestas[$pp['pregunta_id']]==1){
if($tipo_final<$pp['auto_clas']){$tipo_final=$pp['auto_clas'];}
$quitar+=$pp['restar'];

}

}
$tipo_string=array(
'1'=>"TIPO A",
'2'=>"TIPO B",
'3'=>"TIPO C",
'4'=>"TIPO D");



//echo $tipo_final."->".($tipo_v[$tipo_final]-$quitar);

?>

				<div style="color:red;">
					<h1><?php echo $tipo_string[$tipo_final]."  <br/>Valor: $ ".number_format(($tipo_v[$tipo_final]-$quitar),2,',','.'); ?></h1>
				</div>
<div>
<form onsubmit="javascript: return completar_form();" method="post" accept-charset="utf-8" id="n_form2" class="form-horizontal">
   <input type="hidden" name="respuestas" value='<?php echo json_encode($respuestas); ?>'/>
   <input type="hidden" name="modelo" value="<?php echo $modelo; ?>"/>

Cliente: <select name="customer" >
<option value="-1">Seleccione un Cliente</option>

<?php
$clientes=select_mysql("*","customers","deleted=0");

foreach($clientes['result'] as $cli){

$actual=select_mysql("*","people","person_id=".$cli['person_id']);

foreach($actual['result'] as $ac){

echo "<option value=\"".$ac['person_id']."\">".$cli['account_number']." ".$ac['first_name']." ".$ac['last_name']."</option>";

}

}
?>
</select>

<br/>IMEI: <input type="Text" name="imei" />

<br/>IMEI Liberado: <select name="free_imei" >
<option value="1">SI</option>
<option value="2">NO</option>
</select>


					<div class="form-actions">
				<input type="submit" name="submitf" value="Completar" id="submitf" class="submit_button btn btn-primary"  />				</div>
			</form>		
</div>
<div id="end_aqui"></div>

<?php


}else{
echo "Seleccione un Modelo";
}
}

?>
