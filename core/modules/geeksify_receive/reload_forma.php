<?php
global $user_array;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){

if($_POST['model']!="-1"){

$modelos=select_mysql("*","geeksify_modelos","status=1 and modelos_id=".$_POST['model']);

?>
<br/><br/>

<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dt-responsive nowrap" width="100%">
<thead>
<tr>
<th>Tipo A</th>
<th>Tipo B</th>
<th>Tipo C</th>
<th>Tipo D</th>
</tr>
</thead>
<tbody >
<tr>
<td>$ <?php echo number_format($modelos['result'][0]['tipo_a'],2,",","."); ?></td>
<td>$ <?php echo number_format($modelos['result'][0]['tipo_b'],2,",","."); ?></td>
<td>$ <?php echo number_format($modelos['result'][0]['tipo_c'],2,",","."); ?></td>
<td>$ <?php echo number_format($modelos['result'][0]['tipo_d'],2,",","."); ?></td>
</tr>
</tbody>
</form>
</table>

<br/><br/>

<form onsubmit="return cotizar_form();" method="post" accept-charset="utf-8" id="item_form" class="form-horizontal">

<input type="hidden" name="modelo" value="<?php echo $_POST['model']; ?>" />
	<div class="row" id="form">
		<div class="col-md-12">
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="fa fa-align-justify"></i>									
					</span>
					<h5>Cuestionario</h5>
				</div>
				<div class="widget-content nopadding">
					<div class="row">
					<div class="span7 ">

<?php

$preguntas=select_mysql("*","geeksify_cuestionario","status=1");

foreach($preguntas['result'] as $p){

?>

					<div class="form-group">
						<label for="item_number" class="col-sm-3 col-md-3 col-lg-2 control-label wide"><?php echo $p['valor']?>:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
							<select name="pregunta_<?php echo $p['pregunta_id'];?>" class="form-control">
								<option value="1" selected>NO</option>
								<option value="0">SI</option>
							</select>
						</div>
					</div>



<?php

}

?>



				
                    <div class="clear"></div>
				</div>
					
								
		
				
			
					<div class="form-actions">
				<input type="submit" name="submitf" value="Calcular" id="submitf" class="submit_button btn btn-primary"  />				</div>
				
			<div class="item_navigation">
				
							</div>
			
			</div>
		</div>
	</div>
</div>

	</form>	
</div>
<div id="resultado">
</div>

<?php
}else{
echo "Seleccione un Modelo";
}
}

?>
