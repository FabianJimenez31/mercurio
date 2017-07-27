<?php

global $application_config;



load_template('partial','header');
load_template('partial','menu');
?>


<form action="?mod=preventa&proc=save" method="post" accept-charset="utf-8" id="item_form" class="form-horizontal">
	<div class="row" id="form">
		<div class="col-md-12">
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="fa fa-align-justify"></i>									
					</span>
					<h5>Reservaciones</h5>
				</div>
				<div class="widget-content nopadding">
					<div class="row">
					<div class="span7 ">

					<div class="form-group">
						<label for="first_name" class="col-sm-3 col-md-3 col-lg-2 control-label  wide">Nombre(s):</label>						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" name="first_name" value="" id="first_name" class="form-control form-inps"  />						</div>
					</div>

					<div class="form-group">
						<label for="last_name" class="col-sm-3 col-md-3 col-lg-2 control-label  wide">Apellido(s):</label>						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" name="last_name" value="" id="last_name" class="form-control form-inps"  />						</div>
					</div>


					<div class="form-group">
						<label for="phone_number" class="col-sm-3 col-md-3 col-lg-2 control-label  wide">Teléfono de Contacto:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" name="phone_number" value="" id="phone_number" class="form-control form-inps"  />						</div>
					</div>


					<div class="form-group">
						<label for="email" class="col-sm-3 col-md-3 col-lg-2 control-label  wide">Correo Electrónico:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" name="email" value="" id="email" class="form-control form-inps"  />						</div>
					</div>



					<div class="form-group">
						<label for="item_id" class="col-sm-3 col-md-3 col-lg-2  control-label wide">Artículo:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
							<select name="item_id" id="item_id" class="form-control form-inps" onchange="javascript: info_producto(this.value);">
<option value="0">Seleccione un Articulo</option>
<?php

$categ=select_mysql("item_id,name","items","deleted=0 and mostrar_preventa=1");

foreach($categ['result'] as $m){

echo "<option value=\"".$m['item_id']."\">".$m['name']."</option>";

}

?>

							</select>			
						</div>
					</div>




					
					
				</div>


								
		
<div id="producto">
</div>
			
				
			

			</form>			
			<div class="item_navigation">
				
							</div>


			</div>
		</div>
	</div>
</div>
	

	
<script>
function info_producto(item_id){

var uurl="?mod=preventa&proc=producto&item_id=" + item_id
$.post( uurl, function( data ) {

  $( "#producto" ).html( data );

});

}
</script>




		


<?php


load_template('partial','footer');

?>
