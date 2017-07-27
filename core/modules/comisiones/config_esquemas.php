<?php
global $user_array;
load_template('partial','header');
load_template('partial','menu');
if(permitido($user_array['person_id'],$_GET['mod'])){
//echo table_pagination('items','deleted=0',$actual=false,$intervalo=500);


?>
<script>

   function checkboxes()
      {
       var inputElems = $('[name="selected_item[]"]:checked').length;



	if(inputElems==1){ $( "#edit" ).removeClass( "disabled" ); $( "#delete" ).removeClass( "disabled" ); }
	if(inputElems>1){$( "#delete" ).removeClass( "disabled" ); $( "#edit" ).addClass( "disabled" );}
	if(inputElems<1){$( "#delete" ).addClass( "disabled" ); $( "#edit" ).addClass( "disabled" );}


     }

function borrar(){






}



</script>
<div class="modal fade hidden-print" id="modal_nuevo"></div>
		<div class="row">
			<div class="col-md-12 center" style="text-align: right;">					
				<div class="btn-group  ">
								 
					
						<a href="?mod=comisiones&proc=new_esquemas" class="btn btn-medium btn-primary" title="Nuevo Rango"><i class="fa fa-plus   hidden-lg fa fa-2x tip-bottom" data-original-title="Nuevo Artículo"></i> <span class="visible-lg" >Nuevo Esquema de Pagos</span></a>
					
					
			
					<a  id="delete" class="btn btn-danger disabled" title="Borrar"><i class="fa fa-trash-o hidden-lg fa fa-2x tip-bottom" data-original-title="Borrar"></i><span class="visible-lg"><?php echo label_me('delete'); ?></span></a>	

					<a  id="edit" class="btn btn-danger disabled" title="Borrar"><i class="fa fa-pencil hidden-lg fa fa-2x tip-bottom" data-original-title="Editar"></i><span class="visible-lg"><?php echo label_me('edit'); ?></span></a>					
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
<th>Nombre</th>
<th><?php echo label_me('description'); ?></th>
<th>Parametros Agregadas</th>
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
        "ajax": "?mod=comisiones&proc=list_esquemas"	
    } );

    $('#category').change( function() {
	var valor=$('#category').val();
	var nueva="?mod=comisiones&proc=list&category=" + valor;
	table.ajax.url(nueva).load();

    } );

    $('#delete').click( function() {


var inputElemsCount = $('[name="selected_item[]"]:checked').length;
var inputElemsValues = $('[name="selected_item[]"]:checked').serialize();

var r = confirm("<?php echo label_me('sure_delete_1'); ?>" + inputElemsCount + "<?php echo label_me('sure_delete_2'); ?>");

if(r == true){

$.post( "?mod=comisiones&proc=delete_esquemas", inputElemsValues , function( data ) {
gritter("\u00c9xito",data,'gritter-item-success');
reload_table();
} );



}

    } );



    $('#edit').click( function() {


var inputElemsValues = $('[name="selected_item[]"]:checked').val();
	window.location.href = '?mod=comisiones&proc=edit_esquemas&item_id=' + inputElemsValues;


    } );



	

	function reload_table(){
		table.ajax.reload();	
	}



} );
		</script>
<?php


}
load_template('partial','footer');

?>
