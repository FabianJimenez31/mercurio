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

	

<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered nowrap dt-responsive" id="example" width="100%">
<thead>
<tr>
<th><?php echo label_me('accept_id'); ?></th>
<th><?php echo label_me('accept_number'); ?></th>
<th><?php echo label_me('date'); ?> <?php echo label_me('created'); ?></th>
<th><?php echo label_me('eta'); ?></th>
<th>Artículos Pendientes por Ingresar</th>
<th>Órden Principal</th>
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
var table =   $('#example').dataTable( {
        "ajax": "?mod=accepts&proc=list"
	
    } );



    $('#delete').click( function() {


var inputElemsCount = $('[name="selected_item[]"]:checked').length;
var inputElemsValues = $('[name="selected_item[]"]:checked').serialize();

var r = confirm("<?php echo label_me('sure_delete_1'); ?> " + inputElemsCount + " <?php echo label_me('sure_delete_2'); ?>");

if(r == true){

$.post( "?mod=accepts&proc=delete", inputElemsValues , function( data ) {
gritter("\u00c9xito",data,'gritter-item-success');
reload_table();
} );



}

    } );



    $('#edit').click( function() {


var inputElemsValues = $('[name="selected_item[]"]:checked').val();
	window.location.href = '?mod=accepts&proc=edit&person_id=' + inputElemsValues;


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
