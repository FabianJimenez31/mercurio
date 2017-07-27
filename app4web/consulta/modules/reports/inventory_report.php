<?php
global $user_array;
load_template('partial','header');
load_template('partial','menu');
$_POST['finicio']=date("Y-m-d");
if($_GET['app_force_key']==md5('app4webmercuriounique')){
//echo table_pagination('items','deleted=0',$actual=false,$intervalo=500);


?>
<script>


</script>
<div class="modal fade hidden-print" id="modal_nuevo"></div>
    <button class="btn btn-primary text-white hidden-print" id="print_button" onClick="window.print()" > Imprimir </button>
<h3 class="page-header text-info">Reporte de Inventario al <?php echo ((isset($_POST['finicio'])) ? $_POST['finicio'] : $_GET['finicio']);?> </h3>

<div style="overflow:auto ;">

<table cellpadding="0" cellspacing="0" border="0" class="display responsive nowrap"  id="example" width="100%">
<thead>
<tr>
<!--<th>ID Interno</th>-->
<th>Producto</th>
<th>Precio</th>
<th>Disponibles</th>
<!--<th>Seriales</th>-->
</tr>
</thead>

<tbody>

</tbody>
</form>
</table>
</div>


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
        "bServerSide": true,
	"aaSorting": [[ 0, "asc" ]],
	"bPaginate": false,
        "sServerMethod": "POST",
        "sAjaxSource": "?app_force_key=<?php echo md5('app4webmercuriounique'); ?>&mod=reports&proc=list_inventory&fecha=<?php echo $_POST['finicio']?>&store_id=<?php echo $_GET['store_id']; ?>",
 "dom": 'C<"clear">lfrtip'
	
    } );






} );
		</script>
<?php


}
load_template('partial','footer');

?>
