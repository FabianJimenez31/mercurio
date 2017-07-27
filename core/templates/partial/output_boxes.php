<?php
global $application_config;
$sessions=select_mysql("*",'sessions',"session_id=".$_GET['s_id']);


$payment_types=array(

'Efectivo'

);

$additional_payments=explode(";",$application_config['additional_payment_types']);

foreach($additional_payments as $a_p){

$n_p=str_replace(":voucher","",$a_p);
array_push($payment_types,$n_p );

}
foreach($sessions['result'] as $s){

$caj_a=select_mysql("*",'people',"person_id=".$s['employee_is']);
$cajero=$caj_a['result'][0]['first_name']." ".$caj_a['result'][0]['last_name'];


$suma_inicio_a=select_mysql("sum(start) as suma_inicio , sum(end) as suma_final , sum(system_end) as suma_sistema",'closures','session_box='.$s['session_id']);

$suma_inicio="$".number_format($suma_inicio_a['result'][0]['suma_inicio'],2,',','.');
$suma_final=($suma_inicio_a['result'][0]['suma_sistema']==$suma_inicio_a['result'][0]['suma_final'])?"$".number_format($suma_inicio_a['result'][0]['suma_final'],2,',','.'):"<p class='required'>$".number_format($suma_inicio_a['result'][0]['suma_final'],2,',','.')."</p>";
$suma_sistema="$".number_format($suma_inicio_a['result'][0]['suma_sistema'],2,',','.');

$new_id=guid();

$detalles="<table id='$new_id' border=1><tr><th>Tipo de Pago</th><th>Monto Inicial (reportado)</th><th>Monto Final (reportado)</th><th>Monto Final (en sistema)</th></tr>";
foreach($payment_types as $pt){

$suma_inicio_a_2=select_mysql("sum(start) as suma_inicio , sum(end) as suma_final , sum(system_end) as suma_sistema",'closures','session_box='.$s['session_id']." and payment_type='$pt'");

$suma_inicio_2="$".number_format($suma_inicio_a_2['result'][0]['suma_inicio'],2,',','.');
$suma_final_2=($suma_inicio_a_2['result'][0]['suma_sistema']==$suma_inicio_a_2['result'][0]['suma_final'])?"$".number_format($suma_inicio_a_2['result'][0]['suma_final'],2,',','.'):"<p style='color:red;'>$".number_format($suma_inicio_a_2['result'][0]['suma_final'],2,',','.')."</p>";
$suma_sistema_2="$".number_format($suma_inicio_a_2['result'][0]['suma_sistema'],2,',','.');



$detalles.= "<tr><td>$pt</td><td>$suma_inicio_2</td><td>$suma_final_2</td><td>$suma_sistema_2</td></tr>";



}

$detalles.="</table>";
$efectivo=0;
$otros=0;
$new_id=guid();

$facturas="<table><tr><td><table id='$new_id' border=1><tr><th>Factura</th><th>Tipo de Pago</th><th>Monto</th></tr>";
$add_to_sess="";
if($s['is_general']==1){



$f_sid_array=select_mysql("*","sessions","global_id='".$s['session_id']."'");

if($f_sid_array['count']>0){

$add_to_sess="";
foreach($f_sid_array['result'] as $fsa_ii){

$add_to_sess.=" OR session_box=".$fsa_ii['session_id'];

}

}else{
$add_to_sess="";
}



}


$fac_arr=select_mysql("*","sales_payments",'session_box='.$s['session_id'].$add_to_sess);
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

$facturas.="<tr><td>$s_id $agrega_al_sid</td><td>".$fact['payment_type']."</td><td>$".number_format($fact['payment_amount'],2,',','.')."</td></tr>";

}

$consignacion=($s['consignacion']!='')? " ".$s['consignacion'] :"No Asignado";
$valido_monto="";
if($s['consignado']>0 && $s['consignado']<$efectivo){
$valido_monto="<span style='color:red;'> [ NO COINCIDE EL MONTO CONSIGNADO FALTAN $ ".number_format($efectivo-$s['consignado'],2,',','.')." ] </span>";
}

if($s['consignado']>0 && $s['consignado']>$efectivo){
$valido_monto="<br/><span style='color:red;'> [ NO COINCIDE EL MONTO CONSIGNADO SOBRAN $ ".number_format($s['consignado']-$efectivo,2,',','.')." ] </span>";
}

$consignacion_monto=($s['consignado']>0)? "$ ".number_format($s['consignado'],2,',','.')." $valido_monto " :"No Asignado";


$consignacion_imagen=($s['consignacion_file']>0)?"En Sistema":" [ No se ha subido al Sistema ] ";


$datafonos=($s['datafono']!='')? " ".$s['datafono']:"No Asignado";


$datafono_imagen=($s['datafono_file']>0)?"En Sistema":" [ No se ha subido al Sistema ] ";


$valido_monto="";
if($s['consignado_datafonos']>0 && $s['consignado_datafonos']<$otros){
$valido_monto="<span style='color:red;'> [ NO COINCIDE EL MONTO CONSIGNADO FALTAN $".number_format($otros-$s['consignado_datafonos'],2,',','.')." ] </span>";
}

if($s['consignado_datafonos']>0 && $s['consignado_datafonos']>$otros){
$valido_monto="<span style='color:red;'> [ NO COINCIDE EL MONTO CONSIGNADO SOBRAN $".number_format($s['consignado_datafonos']-$otros,2,',','.')." ] </span>";
}

$datafono_monto=($s['consignado_datafonos']>0)? "$ ".number_format($s['consignado_datafonos'],2,',','.')."  $valido_monto " :"No Asignado";









$facturas.="</table></td><td style='width:20px;'></td><td style='text-align:right;vertical-align:middle;'>
<table id='".$new_id."_additional' border=1>
<tr><th>Total</th><th>Monto</th></tr>
<tr><td>Total Día</td><td>$".number_format(($efectivo+$otros),2,',','.')."</td></tr>
<tr><td>Total en Efectivo</td><td>$".number_format($efectivo,2,',','.')."</td></tr>
<tr><td>Total en Voucher</td><td>$".number_format($otros,2,',','.')."</td></tr>
</table>
</td></tr></table>
<br/><br/>

Número de consignación bancaria:  $consignacion <br/>

Monto Consignado:  $consignacion_monto<br/>

Imágen de Consignación Bancaria: $consignacion_imagen <br/>

Número de informe de datafonos: $datafonos <br/>

Monto Consignado [Datafonos]: $datafono_monto <br/>

Imágen de informe de datafonos: $datafono_imagen <br/>

";

echo "
<h1>Cajero: $cajero</h1><br/>
<h2>Fecha: ".$s['date_start']." al ".(($s['date_end']=="0000-00-00 00:00:00") ? "En Curso":$s['date_end'])."</h2><br/>
<h3>Caja: ".$s['session_box']."</h3><br/>

$detalles<br/><br/>

$facturas<br/><br/>


";



}

?>
