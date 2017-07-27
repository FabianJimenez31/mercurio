<?php

global $user_array;
global $current_traslado;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){
$cancelados=select_mysql("*","traslados","state='Solicitado' and show_comments=0 and traslados_id=".$_GET['traslados_id']);
if($cancelados['count']>0){

update_mysql("traslados",array('state'=>'Cancelado','show_comments'=>'1'),'traslados_id='.$_GET['traslados_id']);

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
					<h5>Cancelación de Órden de Traslado Exitosa</h5>
					
				</div>
				<div class="widget-content">
					<ul class="text-error" id="error_message_box"></ul>
					<h2>Felicidades!! </h2>
					<p>Acaba de Cancelar un Proceso de Traslado</p>
										<a class="btn btn-info btn-sm " href="?mod=traslados&proc=statuses">Regresar</a>	
									
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
