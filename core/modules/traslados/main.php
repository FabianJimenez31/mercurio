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
				<div class="list-group">
					
			
										
						<a href="?mod=traslados&proc=generate_main" class="list-group-item" id="generate"><i class="fa fa-edit"></i>	Generar Traslado</a>
						<!--<a href="#" class="list-group-item" id="receive"><i class="fa fa-download"></i>	Recibir Traslado [Sólo Generados por Mercurio]</a>-->
<a href="?mod=traslados&proc=statuses" class="list-group-item" id="boxes_main"><i class="fa fa-table"></i>	Proceso de Traslados</a>
										
					
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
