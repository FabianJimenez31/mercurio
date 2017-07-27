<?php

global $user_array;
global $current_sale_array;
global $application_config;


if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');

?>

<div class="row report-listing">
	<div class="col-md-6  ">
		<div class="panel">
			<div class="panel-body">
				<div class="list-group parent-list">
					
			
										
						<a href="#" class="list-group-item" id="reimpress"><i class="fa fa-table"></i>	Facturas</a>
						<a href="#" class="list-group-item" id="boxes"><i class="fa fa-table"></i>	Reporte de Cierre de Caja (Por Sesión) [No apareceran los cierres realizados por medio del módulo "Cierre General" ]</a>
<a href="#" class="list-group-item" id="boxes_main"><i class="fa fa-table"></i>	Reporte de Cierre de Caja (General) [Solo apareceran los cierres realizados por medio del módulo "Cierre General" ]</a>

						<a href="#" class="list-group-item" id="inventory_now"><i class="fa fa-table"></i>	Inventario</a>

					<a href="#" class="list-group-item" id="reimpress-orders"><i class="fa fa-table"></i>	Reimpresion de Pedidos</a>
										
					
									</div>
			</div>
		</div> <!-- /panel -->
	</div>
	<div class="col-md-6" id="report_selection">
		<div class="panel">
			<div class="panel-body child-list">
			<h3 class="page-header text-info">Seleccione un Reporte</h3>

				<div class="list-group reimpress hidden">
					<a href="?mod=reports&proc=main_sales" class="list-group-item ">
						<i class="fa fa-search report-icon"></i> Buscar </a>


				</div>

				<div class="list-group reimpress-orders hidden">
					<a href="?mod=reports&proc=main_pedidos" class="list-group-item ">
						<i class="fa fa-search report-icon"></i> Buscar </a>


				</div>

				<div class="list-group inventory_now hidden">
					<a href="?mod=reports&proc=main_inventory" class="list-group-item ">
						<i class="fa fa-table report-icon"></i> Mostrar </a>


				</div>

				<div class="list-group boxes hidden">
					<a href="?mod=reports&proc=main_boxes" class="list-group-item ">
						<i class="fa fa-search report-icon"></i> Generar </a>


				</div>

				<div class="list-group boxes_main hidden">
					<a href="?mod=reports&proc=main_boxes_general" class="list-group-item ">
						<i class="fa fa-search report-icon"></i> Generar </a>


				</div>





				
			</div>




				



		</div> <!-- /panel -->
	</div>
</div>
</div>
<script type="text/javascript">
 $('.parent-list a').click(function(e){
 	e.preventDefault();
 	$('.parent-list a').removeClass('active');
 	$(this).addClass('active');
 	var currentClass='.child-list .'+ $(this).attr("id");
 	$('.child-list .page-header').html($(this).html());
 	$('.child-list .list-group').addClass('hidden');
 	$(currentClass).removeClass('hidden');
	
	$('html, body').animate({
	    scrollTop: $("#report_selection").offset().top
	 }, 500);
 });
 </script>


<?php

load_template('partial','footer');
}?>
