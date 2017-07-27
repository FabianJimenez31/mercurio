<?php
global $user_array;
load_template('partial','header');
load_template('partial','menu');
if(permitido($user_array['person_id'],$_GET['mod'])){
//echo table_pagination('items','deleted=0',$actual=false,$intervalo=500);


?>
<!-- INICIO DE LISTA DE ITEMS -->
<div class="row">
    <div class="sale_register_leftbox col-md-9">
        <div class="row forms-area">
                            <div class="col-md-8 no-padd">
                    <div class="input-append">
                        <form action="?mod=presales&proc=add" onSubmit="javascript:add_item();return false;" method="post" accept-charset="utf-8" id="add_item_form" class="form-inline" autocomplete="off">                        <input type="text" name="item" value="" id="item" class="input-xlarge" accesskey="k" placeholder="Ingresa un artículo o de código de barras escaneado"  />                                    </form>
                    </div>
                </div>					
            
            <div class="col-md-4 no-padd">
                                <label >                                    </label>
                </form>					
            </div>

        </div>

        <div class="row" >

                            <div class="table-responsive" >
                    <table id="register" class="table table-bordered">

                        <thead>
                            <tr>
                                <th ></th>
                                <th class="item_name_heading" >Nombre</th>
                                <th class="sales_item presales_items_number">

                                    # de Artículo
                                </th>
                                <th class="sales_stock">Inventario</th>
                                <th class="sales_price">Precio</th>
                                <th class="sales_quality">Cantidad</th>
                                <th class="sales_discount">Serial Sugerido</th>
                                <th class="sales_discount">Descuento</th>
                                <th >Total</th>
                            </tr>
                        </thead>
                        <tbody id="cart_contents" class="sa">


                                                        </tbody>
                    </table>
                </div>
		
            							
        </div>


        	

    </div>


<!-- FIN DE LISTA DE ITEMS -->


    <div class="col-md-3 presale_register_rightbox">
        <ul class="list-group">
            <li class="list-group-item nopadding">
                
                <div id="complete_sale" >
                                        </div>
            </li>
            <li class="list-group-item item_tier">
                <!-- Customer info starts here-->
		<div id="customer_selected"></div>
                <h5 class="customer-basic-information">Seleccionar Cliente</h5>
                <div class="row nomargin">

                    <div class="clearfix" id="customer_info_shell">
                                                    <form action="?mod=presales&proc=select_customer" onSubmit="javascript:add_customer();return false;"  method="post" accept-charset="utf-8" id="select_customer_form" autocomplete="off">                            <input type="text" name="customer" value="" id="customer" size="25" placeholder="Empieza a escribir el nombre del cliente..." accesskey="c"  />                            </form>
                            <div id="add_customer_info">
                                <div id="common_or" class="common_or">
                                    O                                    <a href="?mod=customers&proc=new&redirect=presales" class="btn btn-primary none" title="Cliente Nuevo" id="new-customer"><div class='small_button'> <span>Cliente Nuevo</span> </div></a>                                </div>
                            </div>

                                                </div>
                </div>
            </li>




        </ul>

    </div>
</div>

<script>


function finish_sale(){

var envio = confirm('¿Desea enviar esta venta a caja?');

if(envio){



$.post( "?mod=presales&proc=end_sale",{action:'reload'},function( data ) {

gritter(data.message_header,data.message,data.success ? 'gritter-item-success' : 'gritter-item-error',false,false);
setTimeout(reload_sale(), 3000);

},'json');



}

}

function clear_sale(){


$.post( "?mod=presales&proc=clear" );
 reload_sale();
}

function reload_sale(){

$.post( "?mod=presales&proc=reload_sale", { action: 'reload' }, function( data ) {

$( "#cart_contents" ).html( data.table );
$( "#customer_selected" ).html( data.customer );
$( "#complete_sale" ).html( data.complete_sale );
}, "json");

$("#item").val('');
$("#customer").val('');

}




function delete_item(item_borrar){


$.post( "?mod=presales&proc=delete", { line: item_borrar }, function( data ) {
setTimeout(reload_sale(), 2000);
}, "json");

$("#item").val('');


}


function add_customer(){

var customer_i = $("#customer").val();

$.post( "?mod=presales&proc=select_customer", { customer_id: customer_i }, function( data ) {
setTimeout(reload_sale(), 2000);

}, "json");

$("#customer").val('');



}

function reload_customer(new_cust){

$.post( "?mod=presales&proc=select_customer", { customer_id: new_cust }, function( data ) {
setTimeout(reload_sale(), 2000);

}, "json");

$("#customer").val('');

window.location.href = '?mod=presales&proc=main';

}

<?php if(isset($_GET['reload_customer'])){ echo "reload_customer(".$_GET['reload_customer'].");";} ?>

function add_item(){

var item_i = $("#item").val();

$.post( "?mod=presales&proc=add", { item_id: item_i }, function( data ) {
setTimeout(reload_sale(), 2000);
}, "json");

$("#item").val('');




}

    $(document).ready(function ()
    {
	reload_sale();
        $("#item").autocomplete({
            source: '?mod=presales&proc=suggest_items',
            delay: 10,
            autoFocus: false,
            minLength: 1,
            select: function (event, ui)
            {
                event.preventDefault();
                $("#item").val(ui.item.value);
                add_item();
            }
        });



        $("#customer").autocomplete({
            source: '?mod=presales&proc=suggest_customer',
            delay: 10,
            autoFocus: false,
            minLength: 1,
            select: function (event, ui)
            {
                event.preventDefault();
		$("#customer").val(ui.item.value);
                add_customer();
            }
        });



    });


</script>

<?php





}
load_template('partial','footer');

?>
