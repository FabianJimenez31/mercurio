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
					
			
										
						<a href="#" class="list-group-item" id="reimpress"><i class="fa fa-gear"></i>	<?php echo label_me('configurate'); ?></a>
						<a href="#" class="list-group-item" id="boxes"><i class="fa fa-table"></i>	<?php echo label_me('generate'); ?> <?php echo label_me('report'); ?></a>

					
										
					
									</div>
			</div>
		</div> <!-- /panel -->
	</div>
	<div class="col-md-6" id="report_selection">
		<div class="panel">
			<div class="panel-body child-list">
			<h3 class="page-header text-info"><?php echo label_me('select'); ?> <?php echo label_me('an_option'); ?></h3>

				<div class="list-group reimpress hidden">
					<a href="?mod=comisiones&proc=config_cat" class="list-group-item ">
						<i class="fa fa-tasks report-icon"></i> Configurar Categorias  </a>

					<a href="?mod=comisiones&proc=config_rangos" class="list-group-item ">
						<i class="fa fa-arrows-h report-icon"></i> Configurar Rangos </a>

					<a href="?mod=comisiones&proc=config_metas" class="list-group-item ">
						<i class="fa fa-flag-o report-icon"></i> Configurar Metas </a>

					<a href="?mod=comisiones&proc=config_esquemas" class="list-group-item ">
						<i class="fa fa-list-alt report-icon"></i> Configurar Esquemas de Pago </a>


				</div>

				<div class="list-group boxes hidden">
					<a href="?mod=comisiones&proc=main_conta" class="list-group-item ">
						<i class="fa fa-search report-icon"></i> <?php echo label_me('generate'); ?> </a>


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
