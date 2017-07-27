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
                        <form action="?mod=requisitions&proc=add" onSubmit="javascript:add_item();return false;" method="post" accept-charset="utf-8" id="add_item_form" class="form-inline" autocomplete="off">                        <input type="text" name="item" value="" id="item" class="input-xlarge" accesskey="k" placeholder="Ingresa un artículo o de código de barras escaneado"  />                                    </form>
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
                                <th class="sales_stock">Inventario Actual</th>
                                <th class="sales_quality">Cantidad</th>
                                <th >Costo</th>
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
                <h5 class="customer-basic-information">Seleccionar Proveedor</h5>
                <div class="row nomargin">

                    <div class="clearfix" id="customer_info_shell">
                                                    <form action="?mod=requisitions&proc=select_customer" onSubmit="javascript:add_customer();return false;"  method="post" accept-charset="utf-8" id="select_customer_form" autocomplete="off">                            <input type="text" name="customer" value="" id="customer" size="25" placeholder="Empieza a escribir el nombre del proveedor..." accesskey="c"  />                            </form>
                            <div id="add_customer_info">
                                <div id="common_or" class="common_or">
                                                                                                     </div>
                            </div>
		<div id="prices"></div>

<div style="padding: 0 10px 0 10px;">

                            <label  for="numeroPedido" class="required">Número Pedido:</label>
                            <input type="text" name="numeroPedido" value="" id="numeroPedido" onchange="javascript:change_number_req(this.value);" />       
			    </br></br>
                            <label  for="eta" class="required">ETA:</label>
                            <input type="text" name="eta" value="" id="eta"/>                
			    </br></br>
			    <label for="comment">Comentarios:</label>
                            <textarea name="comment" cols="20" rows="4" id="comment" onchange="javascript:change_comment(this.value);"></textarea>

</div>



                                                </div>
                </div>
            </li>




        </ul>

    </div>
</div>

<script>



$("#eta").datepicker({

	format: "yyyy-mm-dd"
});




function finish_sale(){

var envio = confirm('¿Desea terminar esta solicitud?');

if(envio){



$.post( "?mod=requisitions&proc=end_sale",{action:'reload'},function( data ) {

gritter(data.message_header,data.message,data.success ? 'gritter-item-success' : 'gritter-item-error',false,false);
setTimeout(reload_sale(), 3000);

window.location.href = '?mod=receipts&proc=receivings&id=' + data.req_id;
},'json');



}

}

function clear_sale(){

$("#eta").val('');
$.post( "?mod=requisitions&proc=clear" ,{action : 'clear' },function(data){

 reload_sale();
});

}

function reload_sale(){
var eta = ($("#eta").val()) ? $("#eta").val() : false ;
if(eta){change_eta(eta);}else{reload_sale_end();}

}

function reload_sale_end(){

$.post( "?mod=requisitions&proc=reload_sale", { action: 'reload' }, function( data ) {

$( "#cart_contents" ).html( data.table );
$( "#customer_selected" ).html( data.customer );
$( "#complete_sale" ).html( data.complete_sale );
$( "#prices" ).html( data.prices );
$( "#numeroPedido" ).val( data.numeroPedido );
$( "#comment" ).val( data.comment );
$( "#eta" ).val( data.eta );
}, "json");

$("#item").val('');
$("#customer").val('');

}




function delete_item(item_borrar){


$.post( "?mod=requisitions&proc=delete", { line: item_borrar }, function( data ) {
reload_sale();
}, "json");

$("#item").val('');


}


function add_customer(){

var customer_i = $("#customer").val();
$.post( "?mod=requisitions&proc=select_customer", { customer_id: customer_i }, function( data ) {
reload_sale();

}, "json");

$("#customer").val('');



}

function change_cost(item,new_cost){

$.post( "?mod=requisitions&proc=change_cost", { line: item , cost: new_cost }, function( data ) {
reload_sale();

}, "json");

}

function change_quantity(item,new_quantity){

$.post( "?mod=requisitions&proc=change_quantity", { line: item , quantity: new_quantity }, function( data ) {
reload_sale();

}, "json");

}

function change_number_req(req_id){

$.post( "?mod=requisitions&proc=change_number_req", { number_req: req_id }, function( data ) {
reload_sale();

}, "json");

}

function change_eta(new_eta){

$.post( "?mod=requisitions&proc=change_eta", { eta : new_eta }, function( data ) {

reload_sale_end();

}, "json");

}


function change_comment(new_comment){

$.post( "?mod=requisitions&proc=change_comments", { comment : new_comment }, function( data ) {

reload_sale();

}, "json");

}

function reload_customer(new_cust){

$.post( "?mod=requisitions&proc=select_customer", { customer_id: new_cust }, function( data ) {
reload_sale();

}, "json");

$("#customer").val('');


}

<?php if(isset($_GET['reload_customer'])){ echo "reload_customer(".$_GET['reload_customer'].");";} ?>

function add_item(){

var item_i = $("#item").val();

$.post( "?mod=requisitions&proc=add", { item_id: item_i }, function( data ) {
reload_sale();
}, "json");

$("#item").val('');




}

    $(document).ready(function ()
    {
	reload_sale();
        $("#item").autocomplete({
            source: '?mod=requisitions&proc=suggest_items',
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
            source: '?mod=requisitions&proc=suggest_customer',
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
