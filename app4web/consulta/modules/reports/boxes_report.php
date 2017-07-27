<?php

global $user_array;
global $application_config;
load_template('partial','header');
load_template('partial','menu');
if(permitido($user_array['person_id'],$_GET['mod'])){

?>

<h3 class="page-header text-info">Reporte de Cierre de Cajas del <?php echo ((isset($_POST['finicio'])) ? $_POST['finicio'] : $_GET['finicio']);?> al <?php echo ((isset($_POST['ffinal'])) ? $_POST['ffinal'] : $_GET['ffinal']);?></h3>



<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
<thead>
<tr>
<th>Cajero</th>
<th>Caja</th>
<th>Fecha Inicio</th>
<th>Fecha Fin</th>
<th>Inicio (reportado)</th>
<th>Final (reportado)</th>
<th>Final (en sistema)</th>
<th>Detalles</th>
<th>Facturas</th>
</tr>
</thead>
<tbody>

<?php

$payment_types=array(

'Efectivo'

);

$additional_payments=explode(";",$application_config['additional_payment_types']);

foreach($additional_payments as $a_p){

$n_p=str_replace(":voucher","",$a_p);
array_push($payment_types,$n_p );

}

$finicio=((isset($_POST['finicio'])) ? $_POST['finicio'] : $_GET['finicio'])." 00:00:00";
$ffinal=((isset($_POST['ffinal'])) ? $_POST['ffinal'] : $_GET['ffinal'])." 23:59:59";
$sessions=select_mysql("*",'sessions',"date_start>='$finicio' and date_start<='$ffinal' and force_closed=0");

foreach($sessions['result'] as $s){

$caj_a=select_mysql("*",'people',"person_id=".$s['employee_is']);
$cajero=$caj_a['result'][0]['first_name']." ".$caj_a['result'][0]['last_name'];


$suma_inicio_a=select_mysql("sum(start) as suma_inicio , sum(end) as suma_final , sum(system_end) as suma_sistema",'closures','session_box='.$s['session_id']);

$suma_inicio="$".number_format($suma_inicio_a['result'][0]['suma_inicio'],2,',','.');
$suma_final=($suma_inicio_a['result'][0]['suma_sistema']==$suma_inicio_a['result'][0]['suma_final'])?"$".number_format($suma_inicio_a['result'][0]['suma_final'],2,',','.'):"<p class='required'>$".number_format($suma_inicio_a['result'][0]['suma_final'],2,',','.')."</p>";
$suma_sistema="$".number_format($suma_inicio_a['result'][0]['suma_sistema'],2,',','.');

$new_id=guid();

$detalles="<a onclick=\"javascript:mostrar_detalles('$new_id');\" id='".$new_id."_mostrar'>Mostrar</a><a onclick=\"javascript:ocultar_detalles('$new_id');\" id='".$new_id."_ocultar' style='display:none'>Ocultar</a><table id='$new_id' style='display:none;'><tr><th>Tipo de Pago</th><th>Monto Inicial (reportado)</th><th>Monto Final (reportado)</th><th>Monto Final (en sistema)</th></tr>";
foreach($payment_types as $pt){

$suma_inicio_a_2=select_mysql("sum(start) as suma_inicio , sum(end) as suma_final , sum(system_end) as suma_sistema",'closures','session_box='.$s['session_id']." and payment_type='$pt'");

$suma_inicio_2="$".number_format($suma_inicio_a_2['result'][0]['suma_inicio'],2,',','.');
$suma_final_2=($suma_inicio_a_2['result'][0]['suma_sistema']==$suma_inicio_a_2['result'][0]['suma_final'])?"$".number_format($suma_inicio_a_2['result'][0]['suma_final'],2,',','.'):"<p class='required'>$".number_format($suma_inicio_a_2['result'][0]['suma_final'],2,',','.')."</p>";
$suma_sistema_2="$".number_format($suma_inicio_a_2['result'][0]['suma_sistema'],2,',','.');



$detalles.= "<tr><td>$pt</td><td>$suma_inicio_2</td><td>$suma_final_2</td><td>$suma_sistema_2</td></tr>";



}

$detalles.="</table>";
$efectivo=0;
$otros=0;
$new_id=guid();

$facturas="<a onclick=\"javascript:mostrar_detalles_facturas('$new_id');\" id='".$new_id."_mostrar_facturas'>Mostrar</a><a onclick=\"javascript:ocultar_detalles_facturas('$new_id');\" id='".$new_id."_ocultar_facturas' style='display:none'>Ocultar</a><table id='$new_id' style='display:none;'><tr><th>Factura</th><th>Tipo de Pago</th><th>Monto</th></tr>";

$fac_arr=select_mysql("*","sales_payments",'session_box='.$s['session_id']);
foreach($fac_arr['result'] as $fact){

$sale_ids=select_mysql("*","sales","sale_id=".$fact['sale_id']);
$s_id=($sale_ids['result'][0]['id_manual']!=0 && !(is_null($sale_ids['result'][0]['id_manual'])))?$sale_ids['result'][0]['id_manual']:$fact['sale_id'];


$numeros_celulares=select_mysql("*","sales_items","sale_id='".$fact['sale_id']."'");
$agrega_al_sid="[";
$agrega_al_sid_c=0;
foreach($numeros_celulares['result'] as $numcelus){

if($numcelus['num_tel']!=""){

if($agrega_al_sid_c>0){
$agrega_al_sid.=",".$numcelus['num_tel'];
}else{
$agrega_al_sid.=$numcelus['num_tel'];
$agrega_al_sid_c++;
}

}

}

if($agrega_al_sid=="["){$agrega_al_sid="";}else{$agrega_al_sid.="]";}

if($fact['payment_type']=='Efectivo'){$efectivo+=$fact['payment_amount'];$tupo='Efectivo';}else{$otros+=$fact['payment_amount'];$tupo='Voucher';}

$facturas.="<tr><td>$s_id $agrega_al_sid</td><td>".$fact['payment_type']."</td><td>".number_format($fact['payment_amount'],2,',','.')."</td></tr>";

}

$consignacion=($s['consignacion']!='')? "[ ".$s['consignacion']." ] <a onclick=\"javascript:delete_folio_consignacion('$new_id',".$s['session_id'].");\">Eliminar</a>" :"<input type='text' id='".$new_id."_consignacion' /> <a onclick=\"javascript:guardar_folio_consignacion('$new_id',".$s['session_id'].");\">Asignar</a>";
$valido_monto="";
if($s['consignado']>0 && $s['consignado']<$efectivo){
$valido_monto="<br/><span style='color:red;'>NO COINCIDE EL MONTO CONSIGNADO FALTAN $ ".number_format($efectivo-$s['consignado'],2,',','.')."</span><br/>";
}

if($s['consignado']>0 && $s['consignado']>$efectivo){
$valido_monto="<br/><span style='color:red;'>NO COINCIDE EL MONTO CONSIGNADO SOBRAN $ ".number_format($s['consignado']-$efectivo,2,',','.')."</span><br/>";
}

$consignacion_monto=($s['consignado']>0)? "[ ".number_format($s['consignado'],2,',','.')." ] $valido_monto <a onclick=\"javascript:delete_folio_monto('$new_id',".$s['session_id'].",'$efectivo');\">Eliminar</a>" :"<input type='text' id='".$new_id."_monto' /> <a onclick=\"javascript:guardar_folio_monto('$new_id',".$s['session_id'].",'$efectivo');\">Asignar</a>";


$consignacion_imagen=($s['consignacion_file']>0)?"<a href='?mod=reports&proc=download_consignacion_file&session_id=".$s['session_id']."' target='_blank'>Descargar</a> | <a onclick=\"javascript:delete_image_consignacion('$new_id',".$s['session_id'].");\">Eliminar</a>":"<form id=\"".$new_id."_image_form_consignacion\" enctype=\"multipart/form-data\"><input type='file' name='imagen_consignacion' /><input type='hidden' name='container' value='$new_id' /> <input type='hidden' name='session_id' value='".$s['session_id']."'></form><a onclick=\"javascript:upload_image_consignacion('$new_id');\">Subir Archivo</a>";


$datafonos=($s['datafono']!='')? "[ ".$s['datafono']." ] <a onclick=\"javascript:delete_folio_datafono('$new_id',".$s['session_id'].");\">Eliminar</a>" :"<input type='text' id='".$new_id."_datafono' /> <a onclick=\"javascript:guardar_folio_datafono('$new_id',".$s['session_id'].");\">Asignar</a>";


$datafono_imagen=($s['datafono_file']>0)?"<a href='?mod=reports&proc=download_datafono_file&session_id=".$s['session_id']."' target='_blank'>Descargar</a> | <a onclick=\"javascript:delete_image_datafono('$new_id',".$s['session_id'].");\">Eliminar</a>":"<form id=\"".$new_id."_image_form_datafono\" enctype=\"multipart/form-data\"><input type='file' name='imagen_datafono' /><input type='hidden' name='container' value='$new_id' /> <input type='hidden' name='session_id' value='".$s['session_id']."'></form><a onclick=\"javascript:upload_image_datafono('$new_id');\">Subir Archivo</a>";









$valido_monto="";
if($s['consignado_datafonos']>0 && $s['consignado_datafonos']<$otros){
$valido_monto="<br/><span style='color:red;'>NO COINCIDE EL MONTO CONSIGNADO FALTAN $".number_format($otros-$s['consignado_datafonos'],2,',','.')."</span><br/>";
}

if($s['consignado_datafonos']>0 && $s['consignado_datafonos']>$otros){
$valido_monto="<br/><span style='color:red;'>NO COINCIDE EL MONTO CONSIGNADO SOBRAN $".number_format($s['consignado_datafonos']-$otros,2,',','.')."</span><br/>";
}

$datafono_monto=($s['consignado_datafonos']>0)? "[ ".number_format($s['consignado_datafonos'],2,',','.')." ] $valido_monto <a onclick=\"javascript:delete_datafono_monto('$new_id',".$s['session_id'].",'$otros');\">Eliminar</a>" :"<input type='text' id='".$new_id."_monto_datafono' /> <a onclick=\"javascript:guardar_datafono_monto('$new_id',".$s['session_id'].",'$otros');\">Asignar</a>";









$facturas.="</table><br/><br/>
<table id='".$new_id."_additional' style='display:none;'>
<tr><th>Total</th><th>Monto</th></tr>
<tr><td>Total Día</td><td>".number_format(($efectivo+$otros),2,',','.')."</td></tr>
<tr><td>Total en Efectivo</td><td>".number_format($efectivo,2,',','.')."</td></tr>
<tr><td>Total en Voucher</td><td>".number_format($otros,2,',','.')."</td></tr>
</table>
<br/><br/>

Número de consignación bancaria: <div id='".$new_id."_cons'> $consignacion </div><br/><br/>

Monto Consignado: <div id='".$new_id."_cons_monto'> $consignacion_monto </div><br/><br/>

Imágen de Consignación Bancaria: <div id='".$new_id."_cons_img'> $consignacion_imagen </div><br/><br/>

Número de informe de datafonos: <div id='".$new_id."_data'> $datafonos </div><br/><br/>

Monto Consignado [Datafonos]: <div id='".$new_id."_data_monto'> $datafono_monto </div><br/><br/>

Imágen de informe de datafonos: <div id='".$new_id."_data_img'> $datafono_imagen </div><br/><br/>


<a href='?mod=reports&proc=pdf_export_boxes&s_id=".$s['session_id']."' target='_blank'>Exportar a PDF</a>
";

echo "

<tr>
<td>$cajero</td>
<td>".$s['session_box']."</td>
<td>".$s['date_start']."</td>
<td>".(($s['date_end']=="0000-00-00 00:00:00") ? "En Curso":$s['date_end'])."</td>
<td>$suma_inicio</td>
<td>$suma_final</td>
<td>$suma_sistema</td>
<td>$detalles</td>
<td>$facturas</td>
</tr>

";



}

?>

</tbody>
</form>
</table>

<script>


function delete_datafono_monto(value,id_session,reported_amm){
var session_value = id_session;
var target = '#' + value + '_data_monto';
var continue_here=confirm('¿Desea Eliminar este monto de consignacion de datafono?\n(Esta acción no podrá deshacerse)');
if(continue_here){
$.post( "?mod=reports&proc=delete_datafono_monto", {session_id: session_value, to_be_report: reported_amm , container:value} , function( data ) {
  $( target ).html( data );
});
}
}

function guardar_datafono_monto(value,id_session,reported_amm){
var valor = value + '_monto_datafono' ;
var valor_final= document.getElementById(valor).value;
var session_value = id_session;
var target = '#' + value + '_data_monto';

$.post( "?mod=reports&proc=save_datafono_monto", {session_id: session_value , to_be_report: reported_amm , new_value: valor_final , container:value} , function( data ) {
  $( target ).html( data );
});

}







function delete_folio_monto(value,id_session,reported_amm){
var session_value = id_session;
var target = '#' + value + '_cons_monto';
var continue_here=confirm('¿Desea Eliminar este monto de consignacion?\n(Esta acción no podrá deshacerse)');
if(continue_here){
$.post( "?mod=reports&proc=delete_consignacion_monto", {session_id: session_value, to_be_report: reported_amm , container:value} , function( data ) {
  $( target ).html( data );
});
}
}

function guardar_folio_monto(value,id_session,reported_amm){
var valor = value + '_monto' ;
var valor_final= document.getElementById(valor).value;
var session_value = id_session;
var target = '#' + value + '_cons_monto';

$.post( "?mod=reports&proc=save_consignacion_monto", {session_id: session_value , to_be_report: reported_amm , new_value: valor_final , container:value} , function( data ) {
  $( target ).html( data );
});

}




function delete_image_datafono(value,id_session){
var session_value = id_session;
var target = '#' + value + '_data_img';
var continue_here=confirm('¿Desea Eliminar esta imágen de Consignacion Bancaria?\n(Esta acción no podrá deshacerse)');
if(continue_here){
$.post( "?mod=reports&proc=delete_datafono_file", {session_id: session_value , container:value} , function( data ) {
  $( target ).html( data );
});
}
}


function upload_image_datafono(value){

var target = '#' + value + '_data_img';
var img_form = value + '_image_form_datafono';

$.ajax( {
      url: '?mod=reports&proc=save_datafono_file',
      type: 'POST',
      data: new FormData( document.getElementById(img_form) ),
      processData: false,
      contentType: false,
      success: function(result){
        $(target).html(result);
    }

    } );


}



function delete_image_consignacion(value,id_session){
var session_value = id_session;
var target = '#' + value + '_cons_img';
var continue_here=confirm('¿Desea Eliminar esta imágen de Consignacion Bancaria?\n(Esta acción no podrá deshacerse)');
if(continue_here){
$.post( "?mod=reports&proc=delete_consignacion_file", {session_id: session_value , container:value} , function( data ) {
  $( target ).html( data );
});
}
}


function upload_image_consignacion(value){

var target = '#' + value + '_cons_img';
var img_form = value + '_image_form_consignacion';

$.ajax( {
      url: '?mod=reports&proc=save_consignacion_file',
      type: 'POST',
      data: new FormData( document.getElementById(img_form) ),
      processData: false,
      contentType: false,
      success: function(result){
        $(target).html(result);
    }

    } );


}


function delete_folio_datafono(value,id_session){
var session_value = id_session;
var target = '#' + value + '_data';
var continue_here=confirm('¿Desea Eliminar este código de datafono?\n(Esta acción no podrá deshacerse)');
if(continue_here){
$.post( "?mod=reports&proc=delete_datafono", {session_id: session_value , container:value} , function( data ) {
  $( target ).html( data );
});
}
}

function guardar_folio_datafono(value,id_session){
var valor = value + '_datafono' ;
var valor_final= document.getElementById(valor).value;
var session_value = id_session;
var target = '#' + value + '_data';

$.post( "?mod=reports&proc=save_datafono", {session_id: session_value , new_value: valor_final , container:value} , function( data ) {
  $( target ).html( data );
});

}




function delete_folio_consignacion(value,id_session){
var session_value = id_session;
var target = '#' + value + '_cons';
var continue_here=confirm('¿Desea Eliminar este código de consignacion?\n(Esta acción no podrá deshacerse)');
if(continue_here){
$.post( "?mod=reports&proc=delete_consignacion", {session_id: session_value , container:value} , function( data ) {
  $( target ).html( data );
});
}
}

function guardar_folio_consignacion(value,id_session){
var valor = value + '_consignacion' ;
var valor_final= document.getElementById(valor).value;
var session_value = id_session;
var target = '#' + value + '_cons';

$.post( "?mod=reports&proc=save_consignacion", {session_id: session_value , new_value: valor_final , container:value} , function( data ) {
  $( target ).html( data );
});

}



function mostrar_detalles(value){
var label_1 = value + "_mostrar";
var label_2 = value + "_ocultar";
document.getElementById(value).style.display='block';
document.getElementById(label_1).style.display='none';
document.getElementById(label_2).style.display='block';
}


function ocultar_detalles(value){
var label_1 = value + "_mostrar";
var label_2 = value + "_ocultar";
document.getElementById(value).style.display='none';
document.getElementById(label_1).style.display='block';
document.getElementById(label_2).style.display='none';
}

function mostrar_detalles_facturas(value){
var label_1 = value + "_mostrar_facturas";
var label_2 = value + "_ocultar_facturas";
var facturas_2 = value + "_additional";
document.getElementById(value).style.display='block';
document.getElementById(facturas_2).style.display='block';
document.getElementById(label_1).style.display='none';
document.getElementById(label_2).style.display='block';
}


function ocultar_detalles_facturas(value){
var label_1 = value + "_mostrar_facturas";
var label_2 = value + "_ocultar_facturas";
var facturas_2 = value + "_additional";
document.getElementById(value).style.display='none';
document.getElementById(facturas_2).style.display='none';
document.getElementById(label_1).style.display='block';
document.getElementById(label_2).style.display='none';
}

$(document).ready(function() {
var table =   $('#example').dataTable( {
	"bJQueryUI": true,
	"aaSorting": [[ 0, "asc" ]],
        "sPaginationType": "full_numbers",
	"aLengthMenu": [[10, 50, 100,500, -1], [10, 50, 100,500, "Todos"]],
	
    } );

});


</script>

<?php


}
load_template('partial','footer');
?>
