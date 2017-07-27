<?php
global $user_array;
load_template('partial','header');
load_template('partial','menu');
if(permitido($user_array['person_id'],$_GET['mod'])){

?>


<div class="clear"></div>
	<div class="row" id="form">
		<div class="col-md-12">
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="fa fa-align-justify"></i>									
					</span>
					<h5>Realizar Cierre General</h5>
					
				</div>
				<div class="widget-content">
					<ul class="text-error" id="error_message_box"></ul>
					<h2>Atención: </h2>
					<p>Esta Función cerrará todas las sesiones activas que tiene el sistema, lo que generará que todas las cantidades y montos reportados a sistema se asuman como reales. Así mismo puede generar conflictos o mal procesamiento en ventas que esten en progreso, por lo que le invitamos a que considere que no haya ninguna venta en curso para evitar posibles problemas.<br/><br/>Use esta función con precaución.

<br/><br/>Todas las Sesiones se englobarán en una sola y se cerrarán al momento, generando un Reporte de Cierre de Caja General, se sugiere realizar esta acción un máximo de una vez al día al finaliza el mismo, con el objetivo de tener un cierre general.

<br/><br/>Las cajas que hayan sido cerradas manualmente por los cajeros no serán contadas en el reporte o en el cierre

</p>

<h3>Las Cajas que se cerrarán son las siguientes:</h3>
<br/><br/>
<ul>

<?php

$sesiones=select_mysql("*","sessions","status=0");

if($sesiones['count']>0){

foreach($sesiones['result'] as $s){

echo "<li>Caja ".$s['session_box']." [ID Interno de Sesión: ".$s['session_id']." iniciado en ".$s['date_start']."]</li>";

}

}else{

echo "<li>NO HAY SESIONES ACTIVAS</li>";

}

?>

</ul>
<br/><br/>


<?php if($sesiones['count']>0){ ?>					<a class="btn btn-info btn-sm " href="?mod=cierre_general&proc=complete">Realizar Cierre de Cajas Activas</a> <?php } ?>
					

				</div>
			</div>
		</div>
	</div>




<?php 
load_template('partial','footer');
} ?>
