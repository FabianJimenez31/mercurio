<?php

global $user_array;
load_template('partial','header');
load_template('partial','menu');
if(permitido($user_array['person_id'],$_GET['mod'])){


?>


<div class="row">
	<div class="col-md-12">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="fa fa-align-justify"></i>									
				</span>
				<h5><label for="report_date_range_label">Seleccione un Esquema de Pagos</label></h5>
			</div>
			<div class="widget-content nopadding">
<br/><br/>
					<div class="form-group">

						<label for="finicio" class="col-md-2 control-label   ">Esquema:</label>
						<div class="col-md-3">
							<select name="esquema_id" onchange="javascript:cambiar_esquema(this.value);">
								<option value="0" >- Seleccione un Esquema -</option>

<?php

$mc=select_mysql("*",'esquemas',"status!=3");

foreach($mc['result'] as $o){

echo "<option value=\"".$o['id']."\">".$o['name']."</option>";


}

?>			

							</select>
				
						</div>
					</div>
<br/>

			</div>
		</div>
	</div>
</div>
<div class="row">
<div id="formulario_reporte">

</div>
</div>

<script>

function cambiar_esquema(sid){

if(sid!='0'){

var urls="?mod=comisiones&proc=main_conta_rangos&esquema_id=" + sid;

$.post( urls , function( data ) {
  $( "#formulario_reporte" ).html( data );
});


}else{

$("#formulario_reporte").html('');

}

return true
}

</script>
<?php



}
load_template('partial','footer');
?>
