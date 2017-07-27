<?php

global $user_array;
global $current_traslado;
global $application_config;

$person_array=select_mysql("*","people","person_id=".$user_array['person_id']);
$person=$person_array['result'][0];
if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');
?>

        <div class="container">
          <div class="row">
            <div class="col-md-12">

 
                  <div class="padd invoice">
                    
                    <div class="row">


                      <div class="col-md-4">
                        <h4><strong>Origen:</strong></h4>
                        <p class="hidden-print">
<div class="form-group">
  <select class="form-control hidden-print" id="location_id" onchange="javascript:update_locationid(this.value);">
<option value="0" selected> - Seleccione un Orígen - </option>
<?php

$lugares=select_mysql("*","locations","deleted!=1");

foreach($lugares['result'] as $l){

echo "<option value=\"".$l['location_id']."\">".$l['name']."</option>";

}
?>
  </select>
</div>
                        </p>

<div id="location_text"></div>

                      </div>





                      <div class="col-md-4">
                        <p>
<div class="form-group">
  <label for="comment">Destino:</label>
  <textarea class="form-control" rows="4" id="send_address" onchange="javascript:update_sendaddress(this.value);" placeholder="Dirección de Envío..."></textarea>
</div>
                        </p>
                      </div>


                      <div class="col-md-4">
                        <p>
                          Creado por: <?php echo $person['first_name']." ".$person['last_name']; ?><br/>
                          <?php echo date("d-m-Y"); ?><br/>
<div class="form-group">			  <label for="referencial"># Traslado</label> <input type="text" class="form-control" value="" id="referencial" placeholder="Número de Traslado" onchange="javascript:update_trasladoreferencial(this.value);"/>
</div>
                        </p>
                      </div>



                      <div class="col-md-6 hidden-print">
                        <h4><strong>Agregar Items</strong></h4>
                        <p>
                          Buscar: <input type="text" id="search_sku" placeholder="Buscar Artículos..."  onkeyup="javascript: resultados_sku(this.value);" onchange="javascript: resultados_sku(this.value);"/><br/>
<div id="sku_encontrados" class="table-responsive"></div>
<div id="sku_activo"></div>
<div id="seriales" class="table-responsive"></div>
                        </p>
                      </div>


<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dt-responsive nowrap" id="traslado" width="100%">
<thead>
<tr>
<th>SKU</th>
<th>Cantidad</th>
<th>Números de Serie</th>
</tr>
</thead>
<tbody id="articulos" class="sa">

</tbody>
</table>




                    </div>

                    <div class="row">

                      <div class="col-md-12">
                        <hr />
			                      <div class="col-md-4">
                        <p>
<div class="form-group">
  <label for="comments">Comentarios:</label>
  <textarea class="form-control" rows="4" id="comments" onchange="javascript:update_comments(this.value);"></textarea>
</div>
                        </p>
                      </div>			
							
                      </div>

                    </div>

                  </div>
                  <div class="widget-foot">
					<div class="pull-right">
					<a href="?mod=traslados&proc=save_first" onclick="javascript: return confirm('Esta acción Guardará la Órden de Traslado.\n¿Desea Continuar?');" class="hidden-print btn btn-info btn-sm">Guardar</a>&nbsp; 
						<a href="?mod=traslados&proc=reset" onclick="return confirm('Esta acción eliminará cualquier cambio realizado.\n¿Desea Continuar?');" title="Cancelar" class="hidden-print btn btn-default btn-sm">Cancelar</a>
					</div>
                    <div class="clearfix"></div>

              
            </div>
          </div>
        </div>

<script>


function update_trasladoreferencial(valor_nuevo){
$.post( "?mod=traslados&proc=update_referencial", { refo : valor_nuevo }, function( data ) {

update_screen();

}, "json");
}

function update_sendaddress(valor_nuevo){
$.post( "?mod=traslados&proc=update_sendaddress", { refo : valor_nuevo }, function( data ) {

update_screen();

}, "json");
}

function update_locationid(valor_nuevo){
$.post( "?mod=traslados&proc=update_locationid", { refo : valor_nuevo }, function( data ) {

update_screen();

}, "json");
}

function update_comments(valor_nuevo){
$.post( "?mod=traslados&proc=update_comments", { refo : valor_nuevo }, function( data ) {

update_screen();

}, "json");
}


function resultados_sku(buscar){

$.post( "?mod=traslados&proc=search_sku", { term : buscar }, function( data ) {

$("#sku_encontrados").html(data);
$("#seriales").html('');
$("#sku_activo").html('');
});

}

function activo_sku(idea,etiqueta){

$.post( "?mod=traslados&proc=buscar_disponibles", { term : idea }, function( data ) {
$("#sku_encontrados").html('');
$("#search_sku").val('');
$("#sku_activo").html('<strong>SKU: ' + etiqueta +  '</strong>');
$("#seriales").html(data);

});

}

function agrega_serial(idea,scout,seriado){
var seleccionado = "#resultados_" + idea ;
$.post( "?mod=traslados&proc=agrega_serial", { inventario : idea , referencia : scout , numero : seriado }, function( data ) {
update_screen();
$( seleccionado ).remove();
});


}

function elimina_serial(idea){
var seleccionado = "?mod=traslados&proc=quita_serial&inv_id=" + idea ;
$.post( seleccionado , function( data ) {
update_screen();

});


}



function update_screen(){
$.post( "?mod=traslados&proc=update_screen",  function( data ) {

$("#referencial").val(data.referencial);
$("#location_id").val(data.location_id);
$("#send_address").val(data.send_address);
$("#articulos").html(data.tabla);
$("#location_text").html(data.location_text);
$("#comments").val(data.comments);

},"json");


}



update_screen();
</script>


<?php

load_template('partial','footer');
}?>
