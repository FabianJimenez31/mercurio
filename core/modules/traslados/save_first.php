<?php

global $user_array;
global $current_traslado;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){

if(isset($current_traslado) && $current_traslado!=NULL && isset($current_traslado['articulos'])){

$body="";
session_start();
unset($_SESSION['traslado']);
session_write_close ();

$j=insert_mysql("traslados",
array(
'location_id'=>$current_traslado['location_id'],
'comments'=>$current_traslado['comments'],
'send_address'=>$current_traslado['send_address'],
'referencial'=>$current_traslado['referencial'],
'created_by'=>$user_array['person_id'],
'created_at'=>date("Y-m-d H:i:s")
)
);

$current_id=$j['last_id'];

foreach($current_traslado['articulos'] as $sku=>$inf){


foreach($inf as $serial=>$id){

foreach($id as $r=>$val){


$insert_article=insert_mysql("traslados_items",array('traslados_id'=>$current_id , 'inventory_id'=>$val,'sku'=>$sku,'serial'=>$serial));


}
}

}
$person_trasladado_array=select_mysql("*","people","person_id=".$user_array['person_id']);
$person_trasladado=$person_trasladado_array['result'][0];
$comentarios_adicionales="
---------------------------------------------------------
Usuario: ".$user_array['username']."
Personal: ".$person_trasladado['first_name']." ".$person_trasladado['last_name']."
Operación: Creación de la Órden de Traslado con ID Interno $current_id
Fecha / Hora: ".date("d-m-Y H:i:s")."
---------------------------------------------------------
";
insert_mysql("traslados_history",array('traslados_id'=>$current_id , 'cuando'=>date("Y-m-d H:i:s"),'comments'=>$comentarios_adicionales));
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
					<h5>Creación de Órden de Traslado Exitosa</h5>
					
				</div>
				<div class="widget-content">
					<ul class="text-error" id="error_message_box"></ul>
					<h2>Felicidades!! </h2>
					<p>Acaba de Iniciar un Proceso de Traslado, para continuarlo por favor de click en el siguiente botón </p>
					
					<a class="btn btn-info btn-sm " href="?mod=traslados&proc=cerrar&traslados_id=<?php echo $current_id; ?>" onclick="javascript: return confirm('Esto Iniciará el Proceso de esta Órden de Traslado.\nNo Podrá ser Cancelada y los Seriales Dejarán de Estar Disponibles para Venta.\nNo Podrá regresar los Seriales a Disponibles hasta el Proceso de Cotejamiento.\n¿Desea Continuar?');\">Continuar el Proceso de Traslado</a>
						
					<h2>Importante: </h2>
					<p>Los Artículos seguirán disponilbes para venta hasta que se realice el proceso de Cierre de Pedido</p>

					
				</div>
			</div>
		</div>
	</div>

<?php
load_template('partial','footer');
unset($current_traslado);
}else{
header('Location: ?mod=traslados&proc=generate_main');

}

}
