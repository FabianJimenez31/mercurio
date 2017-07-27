<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');

$infos=select_mysql("*","esquemas","id=".$_GET['item_id']);
$info=$infos['result'][0];

$partial_id['last_id']=$_GET['item_id'];
$categorias=select_mysql("*","categorias","status!=3");
$rangos=select_mysql("*","rangos","status!=3");

$opciones_porcentaje['result'][0]['id']=0;
$opciones_porcentaje['result'][0]['name']='Valor Fijo  (Por Artículo Vendido en ésta Categoría)';

$opciones_porcentaje['result'][1]['id']=1;
$opciones_porcentaje['result'][1]['name']='% del Valor del Producto (Sin IVA)';

$opciones_porcentaje['result'][2]['id']=2;
$opciones_porcentaje['result'][2]['name']='% del Valor del Producto (Con IVA)';

$opciones_pror=array(

array('id'=>'0' , 'value'=>'Nunca'),
array('id'=>'1' , 'value'=>'Si (sólo metas)'),
array('id'=>'2' , 'value'=>'Si (sólo valor de comisiones)'),
array('id'=>'3' , 'value'=>'Si (metas y valor de comisiones)')

);

$calendar_op=array(

array('id'=>'0' , 'value'=>'Ninguno (Deshabilita Prorrateo)'),
array('id'=>'1' , 'value'=>'Diario'),
array('id'=>'2' , 'value'=>'Semanal'),
array('id'=>'3' , 'value'=>'Quincenal [1-15 y 16 a fin de mes]'),
array('id'=>'4' , 'value'=>'Mensual'),
array('id'=>'5' , 'value'=>'Bimestral [Impares (Inicia en Febrero)]'),
array('id'=>'6' , 'value'=>'Bimestral [Pares (Inicia en Enero)]'),
array('id'=>'7' , 'value'=>'Semestral'),
array('id'=>'8' , 'value'=>'Anual')


);

?>


<form action="#" onsubmit="return guardar_cambios();" method="post" accept-charset="utf-8" id="metas" class="form-horizontal">

<input type="hidden" value="<?php echo $partial_id['last_id']; ?>" name="id" />

	<div class="row" id="form">
		<div class="col-md-12">
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="fa fa-align-justify"></i>									
					</span>
					<h5>Esquema de Pagos: <?php echo $info['name']; ?></h5>
				</div>
				<div class="widget-content nopadding">
					<div class="row">
					<div class="span7 ">
					
					<div class="form-group">
						<label for="name" class="col-sm-3 col-md-3 col-lg-2 control-label  wide">Nombre:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" name="name" value="<?php echo $info['name']; ?>" id="name" class="form-control form-inps"  />						</div>
					</div>

 					<div class="form-group">
					<label for="description" class="col-sm-3 col-md-3 col-lg-2 control-label  wide"><?php echo label_me('description'); ?>:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<textarea name="description" value="" id="description" class="form-control" rows="3" ><?php echo $info['description']; ?></textarea>
									</div>
					</div>


					<div class="form-group">
						<label for="name" class="col-sm-3 col-md-3 col-lg-2 control-label  wide">Prorrateo para Nuevo Ingreso:</label>						
<div class="col-sm-9 col-md-9 col-lg-10">
							<select class="form-control" name='periodical' >

<?php

foreach($opciones_pror as $op){
$selected_g=($op['id']==$info['periodical'])?' selected ': '';
echo "<option value='".$op['id']."' $selected_g>".$op['value']."</option>";


}


?>


							</select>
							
						</div>
					</div>


					<div class="form-group">
						<label for="name" class="col-sm-3 col-md-3 col-lg-2 control-label  wide">Duración del Periodo:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
							<select class="form-control" name='month_start' >

<?php

foreach($calendar_op as $op){
$selected_g=($op['id']==$info['month_start'])?' selected ': '';
echo "<option value='".$op['id']."' $selected_g>".$op['value']."</option>";


}


?>


							</select>
							
						</div>
					</div>




					
					
				</div>




								
		
				
			
					<div class="form-actions">
				<input type="submit" name="submitf" value="Guardar" id="submitf" class="submit_button btn btn-primary"  />

<a href="#" onclick="javascript:confirma_salir();" class="submit_button btn btn-warning">Regresar</a>

<script type="text/javascript">
function confirma_salir() {
var answer = confirm ("¿Saldrá sin Guardar los cambios?")
if (answer)
window.location="?mod=comisiones&proc=config_esquemas";
}
</script>

<a href="#" onclick="javascript:confirma_salir_2();" class="submit_button btn btn-default">Salir y Guardar</a>

<script type="text/javascript">
function confirma_salir_2() {
guardar_cambios();
window.location="?mod=comisiones&proc=config_esquemas";
}
</script>

				</div>
			</form>			
			<div class="item_navigation">
				
							</div>
			
			</div>
		</div>
	</div>
</div>
		
<div class="widget-content nopadding" id="add_meta">

<form class="form-inline" id="form_add_meta" action="#" >
  <div class="form-group">
    <label for="meta">Comision</label>
    <input type="number" class="form-control" id="comision_nueva" >
  </div>


  <div class="form-group">
    <label for="categoria">Tipo de Comision</label>
    <select class="form-control" id="porcentaje_nueva" >
	<?php 
		

			foreach($opciones_porcentaje['result'] as $c){
			
				echo "<option value=\"".$c['id']."\" >".$c['name']."</option>";
	
			}
	
	?>
    </select>
  </div>

  <div class="form-group">
    <label for="categoria">Rango</label>
    <select class="form-control" id="rango_nueva" >
	<?php 
		

			foreach($rangos['result'] as $c){
			
				echo "<option value=\"".$c['id']."\" >".$c['name']."</option>";
	
			}
	
	?>
    </select>
  </div>



  <div class="form-group">
    <label for="categoria">Categoria</label>
    <select class="form-control" id="categoria_nueva" >
	<?php 
		

			foreach($categorias['result'] as $c){
			
				echo "<option value=\"".$c['id']."\" >".$c['name']."</option>";
	
			}
	
	?>
    </select>
  </div>



<input type="hidden" value="<?php echo $partial_id['last_id']; ?>" id="group_meta_id" />


  <button type="submit" class="btn btn-default">Crear</button>
</form>

</div>


<div class="widget-content nopadding" id="edit_meta">

<form class="form-inline" id="form_edit_meta" action="#" >
  <div class="form-group">
    <label for="meta">Comision</label>
    <input type="number" class="form-control" id="comision" >
  </div>

  <div class="form-group">
    <label for="categoria">Tipo de Comision</label>
    <select class="form-control" id="porcentaje" >
	<?php 
		

			foreach($opciones_porcentaje['result'] as $c){
			
				echo "<option value=\"".$c['id']."\" >".$c['name']."</option>";
	
			}
	
	?>
    </select>

  </div>



  <div class="form-group">
    <label for="categoria">Rango</label>
    <select class="form-control" id="rango" >
	<?php 
		

			foreach($rangos['result'] as $c){
			
				echo "<option value=\"".$c['id']."\" >".$c['name']."</option>";
	
			}
	
	?>
    </select>

  </div>



  <div class="form-group">
    <label for="categoria">Categoria</label>
    <select class="form-control" id="categoria" >
	<?php 
		

			foreach($categorias['result'] as $c){
			
				echo "<option value=\"".$c['id']."\" >".$c['name']."</option>";
	
			}
	
	?>
    </select>

  </div>

<input type="hidden" value="" id="esta_meta_id" />

  <button type="submit" class="btn btn-default">Guardar</button>

</form>

</div>


				<div class="widget-content nopadding" id="esquemas">


<!--------ESQUEMA------------>

<script>

function nueva_meta_form(){ //muestra el div add_meta

 $("#add_meta").show();
 $("#edit_meta").hide();

}


function editar_meta(edit_id){ // muestra el div edit_meta
var uurl="?mod=comisiones&proc=add_comision_ass&id=" + edit_id
$.post( uurl, function( data ) {

 $("#add_meta").hide();
 $("#edit_meta").show();
/*

'comision'=>$cc['comision'],
'es_porcentaje'=>$cc['es_porcentaje'],
'rango_id'=>$cc['rango_id'],
'categoria_id'=>$cc['categoria_id'],
'ids'=>$cc['id'],

*/
  $( "#comision" ).val( data.comision );
  $( "#porcentaje" ).val( data.es_porcentaje );
  $( "#rango" ).val( data.rango_id );
  $( "#categoria" ).val( data.categoria_id );
  $( "#esta_meta_id" ).val( data.ids );

},'json');

}


function guardar_cambios() {// Guarda los cambios del Esquema

$.post( "?mod=comisiones&proc=save_schema_esquemas&item_id=<?php echo $partial_id['last_id']; ?>", $( "#metas" ).serialize() , function (data) {

gritter("\u00c9xito",data,'gritter-item-success');

});


return false;

}



</script>

<script>

   function checkboxes()
      {
       var inputElems = $('[name="selected_item[]"]:checked').length;



	if(inputElems==1){ $( "#delete" ).removeClass( "disabled" ); }
	if(inputElems>1){$( "#delete" ).removeClass( "disabled" ); }
	if(inputElems<1){$( "#delete" ).addClass( "disabled" ); }


     }

function borrar(){






}



</script>
<div class="modal fade hidden-print" id="modal_nuevo"></div>
		<div class="row">
			<div class="col-md-12 center" style="text-align: right;">					
				<div class="btn-group  ">
								 
					
						<a href="#" onclick="javascript:nueva_meta_form();" class="btn btn-medium btn-primary" title="Nuevo Rango"><i class="fa fa-plus   hidden-lg fa fa-2x tip-bottom" data-original-title="Nuevo Artículo"></i> <span class="visible-lg" >Nuevo Parámetro</span></a>
					
					
			
					<a  id="delete" class="btn btn-danger disabled" title="Borrar"><i class="fa fa-trash-o hidden-lg fa fa-2x tip-bottom" data-original-title="Borrar"></i><span class="visible-lg"><?php echo label_me('delete'); ?></span></a>	

				
				</div>
			 </div>
		</div>
	
<div id="toolbar_helper">

</div>


<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dt-responsive nowrap" id="example" width="100%">
<thead>
<tr>
<th></th>
<th>ID Interno</th>
<th>Pago</th>
<th>Tipo de Pago</th>
<th>Categoria</th>
<th>Rango</th>
<th></th>
</tr>
</thead>
<form id="items_varios">
<tbody>

</tbody>
</form>
</table>


<script type="text/javascript" charset="utf-8">



$(document).ready(function() {
var table =   $('#example').DataTable( {
        "ajax": "?mod=comisiones&proc=list_esquemas_asignadas&meta_id=<?php echo $partial_id['last_id']; ?>"	
    } );


    $('#delete').click( function() {


var inputElemsCount = $('[name="selected_item[]"]:checked').length;
var inputElemsValues = $('[name="selected_item[]"]:checked').serialize();

var r = confirm("<?php echo label_me('sure_delete_1'); ?>" + inputElemsCount + "<?php echo label_me('sure_delete_2'); ?>");

if(r == true){

$.post( "?mod=comisiones&proc=delete_esquema_asignada", inputElemsValues , function( data ) {
gritter("\u00c9xito",data,'gritter-item-success');
reload_table();
} );



}

    } );





$( "#form_edit_meta" ).submit(function( event ) {
	editar_meta_form();
  event.preventDefault();
});

$( "#form_add_meta" ).submit(function( event ) {
	agregar_meta();
  event.preventDefault();
});

function agregar_meta() {// envia el form_add_meta

//meta_nueva = meta
//group_meta_id = meta_id
//categoria_nueva = categoria_id

$.post( "?mod=comisiones&proc=save_esquemas", { 
comision: $("#comision_nueva").val() , 
rango_id: $("#rango_nueva").val() , 
es_porcentaje: $("#porcentaje_nueva").val() , 
categoria_id: $("#categoria_nueva").val() ,
esquema_id: $("#group_meta_id").val() 

}, function( data ) {

gritter("\u00c9xito",data,'gritter-item-success');
reload_table();
$("#comision_nueva").val('0');
 $("#add_meta").hide();
});


}

function editar_meta_form(){ //envia el form_edit_meta

//meta = meta
//categoria=categoria_id
//esta_meta_id=id

$.post( "?mod=comisiones&proc=save_esquemas", { 

comision: $("#comision").val() , 
es_porcentaje: $("#porcentaje").val() ,
rango_id: $("#rango").val() ,
id: $("#esta_meta_id").val() , 
categoria_id: $("#categoria").val() 

}, function( data ) {

gritter("\u00c9xito",data,'gritter-item-success');
reload_table();
$("#edit_meta").hide();
});


}


	

	function reload_table(){
		table.ajax.reload();	
	}



} );

 $("#add_meta").hide();
 $("#edit_meta").hide();
		</script>




<!----------FIN ESQUEMA------>
				</div>



		
		
<?php
load_template('partial','footer');
}


?>
