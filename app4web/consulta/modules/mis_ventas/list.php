<?php
global $user_array;
load_template('partial','header');
load_template('partial','menu');
if(permitido($user_array['person_id'],$_GET['mod'])){
//echo table_pagination('items','deleted=0',$actual=false,$intervalo=500);


?>

<h3 class="page-header text-info">Resultado de Búsqueda de Contratos</h3>
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

	
<div id="toolbar_helper">

</div>


<table cellpadding="0" cellspacing="0" border="0" class="display responsive nowrap" id="example" width="100%">
<thead>
<tr>
<th>Folio Venta</th>
<th>Numero de Contrato</th>
<th>Numero de Teléfono</th>
<th>Fecha de Venta</th>
<th>Imágen</th>
</tr>
</thead>
<tbody>

<?php
///////////POR FECHA
if(isset($_POST['finicio'])){

$finicio=((isset($_POST['finicio'])) ? $_POST['finicio'] : $_GET['finicio'])." 00:00:00";
$ffinal=((isset($_POST['ffinal'])) ? $_POST['ffinal'] : $_GET['ffinal'])." 23:59:59";
$sales=select_mysql("*",'sales',"sale_time>='$finicio' and sale_time<='$ffinal'");

foreach($sales['result'] as $s){

$items=select_mysql("*","sales_items","sale_id='".$s['sale_id']."'");

foreach($items['result'] as $it){

$item_info=select_mysql("*","items","item_id=".$it['item_id']);

if($item_info['result'][0]['is_service']==1 && $item_info['result'][0]['is_serialized']==1){

$new_id=guid();
$string=base64_encode(" sale_id='".$s['sale_id']."' and line='".$it['line']."' and serialnumber='".$it['serialnumber']."' and item_id='".$it['item_id']."'");

$s_up="<div id='".$new_id."_div_contrato'>

<form id=\"".$new_id."_contrato\">
<input type='hidden' name='container' value='$new_id' /> 
<input type='hidden' name='sale_id' value='".$s['sale_id']."'>
<input type='hidden' name='line' value='".$it['line']."'>
<input type='hidden' name='serialnumber' value='".$it['serialnumber']."'>
<input type='hidden' name='item_id' value='".$it['item_id']."'>
</form>



<a href='?mod=contratos&proc=download_contrato_file&string=".$string."' target='_blank'>Descargar</a> | <a onclick=\"javascript:delete_image_contrato('$new_id');\">Eliminar</a>
</div>
";

$s_nup="<div id='".$new_id."_div_contrato'>Contrato no subido: 
<form id=\"".$new_id."_contrato\" enctype=\"multipart/form-data\">
<input type='file' name='imagen_contrato' />
<input type='hidden' name='container' value='$new_id' /> 
<input type='hidden' name='sale_id' value='".$s['sale_id']."'>
<input type='hidden' name='line' value='".$it['line']."'>
<input type='hidden' name='serialnumber' value='".$it['serialnumber']."'>
<input type='hidden' name='item_id' value='".$it['item_id']."'>
</form>
<a onclick=\"javascript:upload_image_contrato('$new_id');\">Subir Archivo</a>
</div>
";

$subir=($it['contrato']=='')?$s_nup:$s_up;



echo "<tr>
<td>".(($s['sale_id']>0)?$s['sale_id']:$s['id_manual'])."</td>
<td>".$it['serialnumber']."</td>
<td>".$it['num_tel']."</td>
<td>".$s['sale_time']."</td>
<td>$subir</td>
</tr>
";

}

}

}



}


///////////POR FOLIO DE VENTA
if(isset($_POST['factura'])){

$sales=select_mysql("*",'sales',"sale_id=".$_POST['factura']." or id_manual=".$_POST['factura']);

foreach($sales['result'] as $s){

$items=select_mysql("*","sales_items","sale_id='".$s['sale_id']."'");

foreach($items['result'] as $it){

$item_info=select_mysql("*","items","item_id=".$it['item_id']);

if($item_info['result'][0]['is_service']==1 && $item_info['result'][0]['is_serialized']==1){



$new_id=guid();
$string=base64_encode(" sale_id='".$s['sale_id']."' and line='".$it['line']."' and serialnumber='".$it['serialnumber']."' and item_id='".$it['item_id']."'");

$s_up="<div id='".$new_id."_div_contrato'>

<form id=\"".$new_id."_contrato\">
<input type='hidden' name='container' value='$new_id' /> 
<input type='hidden' name='sale_id' value='".$s['sale_id']."'>
<input type='hidden' name='line' value='".$it['line']."'>
<input type='hidden' name='serialnumber' value='".$it['serialnumber']."'>
<input type='hidden' name='item_id' value='".$it['item_id']."'>
</form>



<a href='?mod=contratos&proc=download_contrato_file&string=".$string."' target='_blank'>Descargar</a> | <a onclick=\"javascript:delete_image_contrato('$new_id');\">Eliminar</a>
</div>
";

$s_nup="<div id='".$new_id."_div_contrato'>Contrato no subido: 
<form id=\"".$new_id."_contrato\" enctype=\"multipart/form-data\">
<input type='file' name='imagen_contrato' />
<input type='hidden' name='container' value='$new_id' /> 
<input type='hidden' name='sale_id' value='".$s['sale_id']."'>
<input type='hidden' name='line' value='".$it['line']."'>
<input type='hidden' name='serialnumber' value='".$it['serialnumber']."'>
<input type='hidden' name='item_id' value='".$it['item_id']."'>
</form>
<a onclick=\"javascript:upload_image_contrato('$new_id');\">Subir Archivo</a>
</div>
";

$subir=($it['contrato']=='')?$s_nup:$s_up;



echo "<tr>
<td>".(($s['sale_id']>0)?$s['sale_id']:$s['id_manual'])."</td>
<td>".$it['serialnumber']."</td>
<td>".$it['num_tel']."</td>
<td>".$s['sale_time']."</td>
<td>$subir</td>
</tr>
";

}

}

}



}



///////////POR Número de Contrato
if(isset($_POST['contrato'])){

$aux_cont=select_mysql("*","sales_items","serialnumber like '".$_POST['contrato']."'");
foreach( $aux_cont['result'] as $ff){
$_POST['factura']=$ff['sale_id'];
$sales=select_mysql("*",'sales',"sale_id=".$_POST['factura']." or id_manual=".$_POST['factura']);

foreach($sales['result'] as $s){

$items=select_mysql("*","sales_items","sale_id='".$s['sale_id']."'");

foreach($items['result'] as $it){

$item_info=select_mysql("*","items","item_id=".$it['item_id']);

if($item_info['result'][0]['is_service']==1 && $item_info['result'][0]['is_serialized']==1){

$new_id=guid();
$string=base64_encode(" sale_id='".$s['sale_id']."' and line='".$it['line']."' and serialnumber='".$it['serialnumber']."' and item_id='".$it['item_id']."'");

$s_up="<div id='".$new_id."_div_contrato'>

<form id=\"".$new_id."_contrato\">
<input type='hidden' name='container' value='$new_id' /> 
<input type='hidden' name='sale_id' value='".$s['sale_id']."'>
<input type='hidden' name='line' value='".$it['line']."'>
<input type='hidden' name='serialnumber' value='".$it['serialnumber']."'>
<input type='hidden' name='item_id' value='".$it['item_id']."'>
</form>



<a href='?mod=contratos&proc=download_contrato_file&string=".$string."' target='_blank'>Descargar</a> | <a onclick=\"javascript:delete_image_contrato('$new_id');\">Eliminar</a>
</div>
";

$s_nup="<div id='".$new_id."_div_contrato'>Contrato no subido: 
<form id=\"".$new_id."_contrato\" enctype=\"multipart/form-data\">
<input type='file' name='imagen_contrato' />
<input type='hidden' name='container' value='$new_id' /> 
<input type='hidden' name='sale_id' value='".$s['sale_id']."'>
<input type='hidden' name='line' value='".$it['line']."'>
<input type='hidden' name='serialnumber' value='".$it['serialnumber']."'>
<input type='hidden' name='item_id' value='".$it['item_id']."'>
</form>
<a onclick=\"javascript:upload_image_contrato('$new_id');\">Subir Archivo</a>
</div>
";

$subir=($it['contrato']=='')?$s_nup:$s_up;



echo "<tr>
<td>".(($s['sale_id']>0)?$s['sale_id']:$s['id_manual'])."</td>
<td>".$it['serialnumber']."</td>
<td>".$it['num_tel']."</td>
<td>".$s['sale_time']."</td>
<td>$subir</td>
</tr>
";

}

}

}

}

}


///////////POR Número Telefónico
if(isset($_POST['telefono'])){

$aux_cont=select_mysql("*","sales_items","num_tel like '".$_POST['telefono']."'");

foreach( $aux_cont['result'] as $ff){
$_POST['factura']=$ff['sale_id'];
$sales=select_mysql("*",'sales',"sale_id=".$_POST['factura']." or id_manual=".$_POST['factura']);

foreach($sales['result'] as $s){

$items=select_mysql("*","sales_items","sale_id='".$s['sale_id']."'");

foreach($items['result'] as $it){

$item_info=select_mysql("*","items","item_id=".$it['item_id']);

if($item_info['result'][0]['is_service']==1 && $item_info['result'][0]['is_serialized']==1){

$new_id=guid();
$string=base64_encode(" sale_id='".$s['sale_id']."' and line='".$it['line']."' and serialnumber='".$it['serialnumber']."' and item_id='".$it['item_id']."'");

$s_up="<div id='".$new_id."_div_contrato'>

<form id=\"".$new_id."_contrato\">
<input type='hidden' name='container' value='$new_id' /> 
<input type='hidden' name='sale_id' value='".$s['sale_id']."'>
<input type='hidden' name='line' value='".$it['line']."'>
<input type='hidden' name='serialnumber' value='".$it['serialnumber']."'>
<input type='hidden' name='item_id' value='".$it['item_id']."'>
</form>



<a href='?mod=contratos&proc=download_contrato_file&string=".$string."' target='_blank'>Descargar</a> | <a onclick=\"javascript:delete_image_contrato('$new_id');\">Eliminar</a>
</div>
";

$s_nup="<div id='".$new_id."_div_contrato'>Contrato no subido: 
<form id=\"".$new_id."_contrato\" enctype=\"multipart/form-data\">
<input type='file' name='imagen_contrato' />
<input type='hidden' name='container' value='$new_id' /> 
<input type='hidden' name='sale_id' value='".$s['sale_id']."'>
<input type='hidden' name='line' value='".$it['line']."'>
<input type='hidden' name='serialnumber' value='".$it['serialnumber']."'>
<input type='hidden' name='item_id' value='".$it['item_id']."'>
</form>
<a onclick=\"javascript:upload_image_contrato('$new_id');\">Subir Archivo</a>
</div>
";

$subir=($it['contrato']=='')?$s_nup:$s_up;



echo "<tr>
<td>".(($s['sale_id']>0)?$s['sale_id']:$s['id_manual'])."</td>
<td>".$it['serialnumber']."</td>
<td>".$it['num_tel']."</td>
<td>".$s['sale_time']."</td>
<td>$subir</td>
</tr>
";

}

}

}

}

}


?>

</tbody>

</table>


<script type="text/javascript" charset="utf-8">

$.fn.dataTableExt.oApi.fnReloadAjax = function ( oSettings, sNewSource, fnCallback, bStandingRedraw )
{
    if ( typeof sNewSource != 'undefined' && sNewSource != null )
    {
        oSettings.sAjaxSource = sNewSource;
    }
    this.oApi._fnProcessingDisplay( oSettings, true );
    var that = this;
    var iStart = oSettings._iDisplayStart;
      
    oSettings.fnServerData( oSettings.sAjaxSource, [], function(json) {
        /* Clear the old information from the table */
        that.oApi._fnClearTable( oSettings );
          
        /* Got the data - add it to the table */
        var aData =  (oSettings.sAjaxDataProp !== "") ?
            that.oApi._fnGetObjectDataFn( oSettings.sAjaxDataProp )( json ) : json;
          
        for ( var i=0 ; i<json.aaData.length ; i++ )
        {
            that.oApi._fnAddData( oSettings, json.aaData[i] );
        }
          
        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
        that.fnDraw();
          
        if ( typeof bStandingRedraw != 'undefined' && bStandingRedraw === true )
        {
            oSettings._iDisplayStart = iStart;
            that.fnDraw( false );
        }
          
        that.oApi._fnProcessingDisplay( oSettings, false );
          
        /* Callback user function - for event handlers etc */
        if ( typeof fnCallback == 'function' && fnCallback != null )
        {
            fnCallback( oSettings );
        }
    }, oSettings );
}


$(document).ready(function() {
var table =   $('#example').dataTable( {
	responsive : true,
        "bProcessing": true,
	"bJQueryUI": true,
	"aaSorting": [[ 0, "asc" ]],
        "sPaginationType": "full_numbers",
	"aLengthMenu": [[10, 50, 100,500, -1], [10, 50, 100,500, "Todos"]],

 "dom": 'C<"clear">lfrtip'
	
    } );

    $('#category').change( function() {
	var valor=$('#category').val();
	var nueva="?mod=contable&proc=list&category=" + valor;
	table.fnReloadAjax(nueva);

    } );

    $('#delete').click( function() {


var inputElemsCount = $('[name="selected_item[]"]:checked').length;
var inputElemsValues = $('[name="selected_item[]"]:checked').serialize();

var r = confirm("¿Esta seguro de Eliminar los ( " + inputElemsCount + " ) elementos seleccionados?");

if(r == true){

$.post( "?mod=contable&proc=delete", inputElemsValues , function( data ) {
gritter("\u00c9xito",data,'gritter-item-success');
reload_table();
} );



}

    } );



    $('#edit').click( function() {


var inputElemsValues = $('[name="selected_item[]"]:checked').val();
	window.location.href = '?mod=contable&proc=edit&item_id=' + inputElemsValues;


    } );



	

	function reload_table(){
		table.fnReloadAjax();	
	}



} );



function upload_image_contrato(value){

var target = '#' + value + '_div_contrato';
var img_form = value + '_contrato';

$.ajax( {
      url: '?mod=contratos&proc=save_contrato_file',
      type: 'POST',
      data: new FormData( document.getElementById(img_form) ),
      processData: false,
      contentType: false,
      success: function(result){
        $(target).html(result);
    }

    } );


}


function delete_image_contrato(value){

var target = '#' + value + '_div_contrato';
var img_form = value + '_contrato';
var continue_here=confirm('¿Desea Eliminar esta imágen?\n(Esta acción no podrá deshacerse)');
if(continue_here){
$.ajax( {
      url: '?mod=contratos&proc=delete_contrato_file',
      type: 'POST',
      data: new FormData( document.getElementById(img_form) ),
      processData: false,
      contentType: false,
      success: function(result){
        $(target).html(result);
    }

    } );
}

}







		</script>
<?php


}
load_template('partial','footer');

?>
