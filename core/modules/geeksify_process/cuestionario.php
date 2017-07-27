<?php
global $user_array;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');
if($_GET['id']!="-1"){

$informacion=select_mysql("*","geeksify_envio","envios_id=".$_GET['id']);
$respuestas=select_mysql("*","geeksify_respuestas","envio_id=".$_GET['id']);

?>
<br/><br/>


<form onsubmit="return false;" method="post" accept-charset="utf-8" id="item_form" class="form-horizontal">

	<div class="row" id="form">
		<div class="col-md-12">
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="fa fa-align-justify"></i>									
					</span>
					<h5>Cuestionario Trámite <?php echo $informacion['result'][0]['envios_id']; ?> [ <?php echo $informacion['result'][0]['certificado_registro']; ?> ]</h5>
				</div>
				<div class="widget-content nopadding">
					<div class="row">
					<div class="span7 ">

<?php



foreach($respuestas['result'] as $r){
$preguntas=select_mysql("*","geeksify_cuestionario","pregunta_id=".$r['pregunta_id']);
$p=$preguntas['result'][0];

?>

					<div class="form-group">
						<label for="item_number" class="col-sm-3 col-md-3 col-lg-2 control-label wide"><?php echo $p['valor']?>:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
<?php

echo ($r['valor']==1)?"NO":"SI";

?>
						</div>
					</div>



<?php

}

?>



				
                    <div class="clear"></div>
				</div>
					
								
		
				

			<div class="item_navigation">
				
							</div>
			
			</div>
		</div>
	</div>
</div>

	</form>	
</div>


<?php
}
load_template('partial','footer');
}

?>
