<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');

$envio=select_mysql("*","geeksify_envio","envios_id=".$_GET['id']);
$mas=$envio['result'][0];
?>

<a href="?mod=geeksify_process&proc=cuestionario&id=<?php echo $_GET['id']; ?>">Mostrar Cuestionario</a><br/>
<a href="?mod=geeksify_process&proc=acta&id=<?php echo $_GET['id']; ?>">Imprimir Acta de Entrega</a>

<form>
					<div class="form-group">
						<label for="item_number" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Operador:</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" id="operador" class="form-control" value="<?php echo $mas['operador']?>">
							<a onclick="javascript: update_valor('operador','<?php echo $_GET['id']?>','#operador','#op_check');">Actualizar</a>
							<span id="op_check"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="item_number" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Número de Factura de Compra:</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" id="factura" class="form-control" value="<?php echo $mas['factura']?>">
							<a onclick="javascript: update_valor('factura','<?php echo $_GET['id']?>','#factura','#factura_check');">Actualizar</a>
							<span id="factura_check"></span>
						</div>
					</div>


					<div class="form-group">
						<label for="item_number" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Número de Certificado de Registro:</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" id="certificado_registro" class="form-control" value="<?php echo $mas['certificado_registro']?>">
							<a onclick="javascript: update_valor('certificado_registro','<?php echo $_GET['id']?>','#certificado_registro','#certificado_registro_check');">Actualizar</a>
							<span id="certificado_registro_check"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="item_number" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Fotocopia Cédula:</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<select id="cedula" class="form-control">
								<option value="0" <?php echo (($mas['cedula'])==1)?'':' selected '; ?>>NO</option>
								<option value="1" <?php echo (($mas['cedula'])==1)?' selected ':''; ?>>SI</option>
							</select>
<a onclick="javascript: update_valor('cedula','<?php echo $_GET['id']?>','#cedula','#cedula_check');">Actualizar</a>
							<span id="cedula_check"></span>
						</div>
					</div>



					<div class="form-group">
						<label for="item_number" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Documento de Trapaso:</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<select id="documento_traspaso" class="form-control">
								<option value="0" <?php echo (($mas['documento_traspaso'])==1)?'':' selected '; ?>>NO</option>
								<option value="1" <?php echo (($mas['documento_traspaso'])==1)?' selected ':''; ?>>SI</option>
							</select>
<a onclick="javascript: update_valor('documento_traspaso','<?php echo $_GET['id']?>','#documento_traspaso','#documento_traspaso_check');">Actualizar</a>
							<span id="documento_traspaso_check"></span>
						</div>
					</div>


					<div class="form-group">
						<label for="item_number" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Desenlazado de Cuentas:</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<select id="desenlazar" class="form-control">
								<option value="0" <?php echo (($mas['desenlazar'])==1)?'':' selected '; ?>>NO</option>
								<option value="1" <?php echo (($mas['desenlazar'])==1)?' selected ':''; ?>>SI</option>
							</select>
<a onclick="javascript: update_valor('desenlazar','<?php echo $_GET['id']?>','#desenlazar','#desenlazar_check');">Actualizar</a>
							<span id="desenlazar_check"></span>
						</div>
					</div>



					<div class="form-group">
						<label for="item_number" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Restaurado a Fábrica:</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<select id="fabrica" class="form-control">
								<option value="0" <?php echo (($mas['fabrica'])==1)?'':' selected '; ?>>NO</option>
								<option value="1" <?php echo (($mas['fabrica'])==1)?' selected ':''; ?>>SI</option>
							</select>
<a onclick="javascript: update_valor('fabrica','<?php echo $_GET['id']?>','#fabrica','#fabrica_check');">Actualizar</a>
							<span id="fabrica_check"></span>
						</div>
					</div>


</form>

<a href="?mod=geeksify_receive&proc=main">Nueva Recepción</a>
<script>
function update_valor(clave,donde,desde,resultado){

var nuevo=$(desde).val();

$(resultado).html(" Guardando...");
$.post( "?mod=geeksify_process&proc=update", { llave: clave , valor: nuevo , registro: donde }, function( data ) {

$(resultado).html(data);

});

}
</script>


<?php


load_template('partial','footer');
}


?>
