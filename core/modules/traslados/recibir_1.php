<?php

global $user_array;
global $current_traslado;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){
$cancelados=select_mysql("*","traslados","state='Enviado' and show_comments=0 and traslados_id=".$_GET['traslados_id']);
if($cancelados['count']>0){

load_template('partial','header');
load_template('partial','menu');
?>

<div class="clear"></div>
	<div class="row" id="form">
		<div class="col-md-12">
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="fa fa-align-justify"></i>									
					</span>
					<h5>Recepción de Órden de Traslado</h5>
					
				</div>
				<div class="widget-content">

					<ul class="text-error" id="error_message_box"></ul>
					<h2>Acuse de Recibo </h2>
				<form action="?mod=traslados&proc=recibir_2&traslados_id=<?php echo $_GET['traslados_id'];?>" method="POST" onsubmit="return confirm('Está a Punto de Guardar como Recibido ésta Órden de Traslado.\nEsta acción no se puede deshacer.\n¿Desea Continuar?');">
					<p>Persona que Recibe: <input type="text" name="received_por" placeholder="Nombre del Receptor" /></p>
										<button type="submit" class="btn btn-info btn-sm">Continuar</button>	
									</form>
				</div>
			</div>
		</div>
	</div>

<?php
load_template('partial','footer');
}else{
header('Location: ?mod=traslados&proc=statuses');

}

}
