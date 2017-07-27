<?php
global $user_array;
global $user_box;
global $application_config;
if($user_box>0){
load_template('partial','header');
load_template('partial','menu');
if(permitido($user_array['person_id'],$_GET['mod'])){
global $application_config;
?>

<!-- INICIO DE LISTA DE ITEMS -->
<div style="opacity: 0.8;z-index:999999999;background-color:#000000;color:#FFFFFF;position:fixed;top:0;left:0;right:0;bottom:0;display:none;" id="subiendo_archivo">
<br/><br/><br/><br/><br/><br/><br/>
<center><b>Subiendo archivo...<br/>
Espere un momento por favor</b>
</center>
</div>


<div class="row">
    <div class="sale_register_leftbox col-md-9">
        <div class="row forms-area">
                            <div class="col-md-8 no-padd">
                    <div class="input-append">
                        <form action="?mod=sales&proc=add" onSubmit="javascript:add_item();return false;" method="post" accept-charset="utf-8" id="add_item_form" class="form-inline" autocomplete="off">                        <input type="text" name="item" value="" id="item" class="input-xlarge" accesskey="k" placeholder="Ingresa un artículo o de código de barras escaneado"  />     
<a href="?mod=sales&proc=presales_main" class="btn btn-primary none suspended_sales_btn" title="Ventas Suspendidas"><div class='small_button'> <?php echo label_me('presales'); ?> </div></a>
<?php if(strtoupper($application_config['averaging_method'])!='NO'){?>
<a href="?mod=sales&proc=end_day" class="btn btn-primary none suspended_sales_btn" onclick="return confirm('¿Esta seguro de realizar un Cierre de Caja?');" title="Cerrar Caja"><div class='small_button'> <?php echo label_me('close'); ?> <?php echo label_me('cash_line'); ?> </div></a>
<?php }?>
                               </form>
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
                                <th class="sales_item sales_items_number">

                                    # de Artículo
                                </th>
                                <th class="sales_stock">Inventario Actual</th>
                                <th class="sales_quality">Cantidad</th>
                                <th >Precio</th>
                                <th >Descuento</th>
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


    <div class="col-md-3 sale_register_rightbox">
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
                                                    <form action="?mod=sales&proc=select_customer" onSubmit="javascript:add_customer();return false;"  method="post" accept-charset="utf-8" id="select_customer_form" autocomplete="off">                            <input type="text" name="customer" value="" id="customer" size="25" placeholder="Empieza a escribir el nombre del proveedor..." accesskey="c"  />                            </form>
                            <div id="add_customer_info">
                                <div id="common_or" class="common_or">
                                    O                                    <a href="?mod=customers&proc=new&redirect=sales" class="btn btn-primary none" title="Cliente Nuevo" id="new-customer"><div class='small_button'> <span>Cliente Nuevo</span> </div></a>                                


                                                                                                     </div>
                            </div>
<br/>
<br/>
<br/>
Vendedor: 
<select id="salesman" onchange='javascript:update_salesman(this.value);'>
<option value=0>Seleccione un Vendedor</option>
</select>
<br/>
<br/>
<br/>
                    <table id="sales_items" class="table">
                                                                                                    <tr class="info">
                            <td class="left">Subtotal:</td>
                            <td class="right" id="prices"></td>
                        </tr>
                                                    <tr class="color1" id=>
                                <td class="left">

                                                                           
                                                                        IVA:</td>
                                <td class="right" id='taxes'></td>
                            </tr>
                                                <tr class="success">
                            <td ><h3 class="sales_totals">Total:</h3></td>
                            <td ><h3 class="currency_totals" id="total"></h3></td>
                        </tr>
                    </table>
 <table id="payments" class="table">


</table>

<table class="table sales_totals" id="remain">
</table>



<br/>
Agregar Pago

<select id="payment_type" onchange='javascript:mostrar_voucher(this.value);'>
<?php

$payment_types=array(

'Efectivo',

);

$additional_payments=explode(";",$application_config['additional_payment_types']);

foreach($additional_payments as $a_p){

$n_p=str_replace(":voucher","",$a_p);
array_push($payment_types,$n_p );

}

foreach ($payment_types as $p_T){
echo "<option value=\"$p_T\" >$p_T</options>";
}

?>
</select>
<input type='text' placeholder='Monto a Pagar' id='ammount'>
<input type='text' placeholder='Voucher/Autorizado Por' id='p_info' style='display:none;'>
<button onclick='javascript:add_payment();' class="btn btn-primary none">Agregar Pago</button>





<div style="padding: 0 10px 0 10px;">


          
			    </br></br>
			    <label for="comment">Comentarios:</label>
                            <textarea name="comment" cols="20" rows="4" id="comment" onchange="javascript:change_comment(this.value);"></textarea>


<input type='checkbox' value='1' id='show_comments' >Mostrar Comentarios en Recibo
<br/>
<input type='checkbox' value='1' id='is_manual' >Venta Manual

<input type='text' placeholder='Folio Manual' id='manual_folio' style="display:none;" onchange="javascript:change_manual_folio(this.value);">


<br/>
<input type='text' placeholder='Resolucion' id='resolucion' style="display:none;" onchange="javascript:change_resolucion(this.value);">


<div>



</div>


</div>



                                                </div>
                </div>
            </li>




        </ul>

    </div>
</div>

<script>

function change_manual_folio(new_comment){

$.post( "?mod=sales&proc=change_manual_folio", { comment : new_comment }, function( data ) {

reload_sale_end();

}, "json");

}

function change_resolucion(new_comment){

$.post( "?mod=sales&proc=change_resolucion", { comment : new_comment }, function( data ) {

reload_sale();

}, "json");

}


function update_salesman(new_comment){

$.post( "?mod=sales&proc=change_salesman", { comment : new_comment }, function( data ) {

reload_sale();

}, "json");

}


$("#is_manual").change( function(){
   if( $(this).is(':checked') ) {


$.post( "?mod=sales&proc=change_is_manual" ,{modes : 'yes' },function(data){

 reload_sale();
});
document.getElementById("manual_folio").style.display='block';
document.getElementById("resolucion").style.display='block';

}else{

$.post( "?mod=sales&proc=change_is_manual" ,{modes : 'no' },function(data){

 reload_sale();
});
document.getElementById("manual_folio").style.display='none';
document.getElementById("resolucion").style.display='none';
}
});





$("#show_comments").change( function(){
   if( $(this).is(':checked') ) {


$.post( "?mod=sales&proc=change_comments_print" ,{modes : 'yes' },function(data){

 reload_sale();
});


}else{

$.post( "?mod=sales&proc=change_comments_print" ,{modes : 'no' },function(data){

 reload_sale();
});

}
});


function add_payment(){
var tipo = $('#payment_type').val();
var monto = $('#ammount').val();
var voucher = $('#p_info').val();

$.post( "?mod=sales&proc=add_payment", { type: tipo , ammount: monto , comm : voucher }, function( data ) {
setTimeout(reload_sale(), 2000);


$('#ammount').val('');
$('#p_info').val('');
}, "json");


}


$("#eta").datepicker({

	format: "yyyy-mm-dd"
});



function mostrar_voucher(valor){

<?php

$payment_types=array(

'Efectivo',

);
$is_voucher="";
$additional_payments=explode(";",$application_config['additional_payment_types']);
$x=0;
foreach($additional_payments as $a_p){

if(strpos($a_p, ':voucher')!=false){
$ap=str_replace(':voucher','',$a_p);
$is_voucher.=($x<=0)? " valor=='$ap' " :" || valor=='$ap'";
$x++;
}

}


?>


if(<?php echo (($is_voucher=="")?'valor != valor':$is_voucher); ?>){

document.getElementById("p_info").style.display='block';

}else{

document.getElementById("p_info").style.display='none';
}

}


function finish_sale(){

var envio = confirm('¿Desea terminar esta solicitud?');

if(envio){



$.post( "?mod=sales&proc=end_sale",{action:'reload'},function( data ) {

gritter(data.message_header,data.message,data.success ? 'gritter-item-success' : 'gritter-item-error',false,false);
setTimeout(reload_sale(), 3000);

window.location.href = '?mod=receipts&proc=sales&sale_show=yes&id=' + data.req_id;
},'json');



}

}

function clear_sale(){

$("#eta").val('');
$.post( "?mod=sales&proc=clear" ,{action : 'clear' },function(data){

 reload_sale();
});

}

function reload_sale(){

reload_sale_end();

}

function reload_sale_end(){

$.post( "?mod=sales&proc=reload_sale", { action: 'reload' }, function( data ) {

$( "#cart_contents" ).html( data.table );
$( "#salesman" ).html( data.salesman );
$( "#customer_selected" ).html( data.customer );
$( "#complete_sale" ).html( data.complete_sale );
$( "#prices" ).html( data.prices );
$( "#taxes" ).html( data.taxes );
$( "#total" ).html( data.total );
$( "#payments" ).html( data.payments );
$( "#comment" ).val( data.comment );
$( "#ammount" ).val( data.pending );
$( "#resolucion" ).val( data.resolucion );
$( "#remain" ).html( data.remain );
$( "#show_comments" ).attr( 'checked', data.show_comments );
$( "#is_manual" ).attr( 'checked', data.is_manual );
document.getElementById("manual_folio").style.display=data.show_manual;
document.getElementById("resolucion").style.display=data.show_manual;
$( "#manual_folio" ).val( data.manual_folio );

}, "json");

$("#item").val('');
$("#customer").val('');

}








function delete_item(item_borrar){


$.post( "?mod=sales&proc=delete", { line: item_borrar }, function( data ) {
setTimeout(reload_sale(), 2000);
}, "json");

$("#item").val('');


}


function delete_payment(item_borrar){


$.post( "?mod=sales&proc=delete_payment", { line: item_borrar }, function( data ) {
setTimeout(reload_sale(), 2000);
}, "json");

$("#item").val('');


}


function add_customer(){

var customer_i = $("#customer").val();
$.post( "?mod=sales&proc=select_customer", { customer_id: customer_i }, function( data ) {
setTimeout(reload_sale(), 2000);

}, "json");

$("#customer").val('');



}

function change_discount(item,new_cost){

$.post( "?mod=sales&proc=change_cost", { line: item , cost: new_cost }, function( data ) {
setTimeout(reload_sale(), 2000);

}, "json");

}

function change_quantity(item,new_quantity){

$.post( "?mod=sales&proc=change_quantity", { line: item , quantity: new_quantity }, function( data ) {
setTimeout(reload_sale(), 2000);

}, "json");

}







function change_item_cost(item,new_quantity){

$.post( "?mod=sales&proc=change_item_cost", { line: item , serial: new_quantity }, function( data ) {
setTimeout(reload_sale(), 2000);

}, "json");

}



function change_serial(item,new_quantity){

$.post( "?mod=sales&proc=change_serial", { line: item , serial: new_quantity }, function( data ) {
setTimeout(reload_sale(), 2000);

}, "json");

}

function change_numtel(item,new_quantity){

$.post( "?mod=sales&proc=change_numtel", { line: item , serial: new_quantity }, function( data ) {
setTimeout(reload_sale(), 2000);

}, "json");

}

function upload_image_contrato(value){

var target = '#contrato_form_div_' + value ;
var img_form = 'contrato_form_' + value;

document.getElementById("subiendo_archivo").style.display="block";
$.ajax( {
      url: '?mod=sales&proc=upload_tmp_file',
      type: 'POST',
      data: new FormData( document.getElementById(img_form) ),
      processData: false,
      contentType: false,
      success: function(result){
        $(target).html(result);
	reload_sale();
document.getElementById("subiendo_archivo").style.display="none";
    }

    } );


}



function delete_image_contrato(item,new_quantity){

$.post( "?mod=sales&proc=change_contrato_file", { line: item , quantity: new_quantity }, function( data ) {
setTimeout(reload_sale(), 2000);

}, "json");

}




function change_postpay(item){
var itt = "#" + item + "_postpay";
if( $(itt).is(':checked') ) {
var new_val = "1";
}else{
var new_val = "0";
}


$.post( "?mod=sales&proc=change_postfirst", { line: item , serial: new_val }, function( data ) {
setTimeout(reload_sale(), 2000);

}, "json");

}


function change_serial_kit(item,inde,new_quantity){

$.post( "?mod=sales&proc=change_serial_kit", { line: item , item: inde , serial: new_quantity }, function( data ) {
setTimeout(reload_sale(), 2000);

}, "json");

}

function change_number_req(req_id){

$.post( "?mod=sales&proc=change_number_req", { number_req: req_id }, function( data ) {
setTimeout(reload_sale(), 2000);

}, "json");

}

function change_comment(new_comment){

$.post( "?mod=sales&proc=change_comments", { comment : new_comment }, function( data ) {

reload_sale_end();

}, "json");

}

function reload_customer(new_cust){

$.post( "?mod=sales&proc=select_customer", { customer_id: new_cust }, function( data ) {
setTimeout(reload_sale(), 2000);

}, "json");

$("#customer").val('');
window.location.href = '?mod=sales&proc=main';

}

<?php if(isset($_GET['reload_customer'])){ echo "reload_customer(".$_GET['reload_customer'].");";} ?>

function add_item(){

var item_i = $("#item").val();

$.post( "?mod=sales&proc=add", { item_id: item_i }, function( data ) {
setTimeout(reload_sale(), 2000);
}, "json");

$("#item").val('');




}

    $(document).ready(function ()
    {
	reload_sale();
        $("#item").autocomplete({
            source: '?mod=sales&proc=suggest_items',
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
            source: '?mod=sales&proc=suggest_customer',
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
load_template('partial','footer');}else{
?>
<script>
window.location.href="?mod=sales&proc=start_day";
</script>
<?php

}

?>
