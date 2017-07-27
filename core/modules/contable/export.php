<?php

global $user_array;
if(permitido($user_array['person_id'],$_GET['mod'])){
global $application_config;


$name="REPORT_CONT_".date("Ymdhis");
$name.="-".md5($name).".csv";

header('Content-Type: application/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename=\''.$name.'\'');
header('Pragma: no-cache');



$sales=select_mysql("*","sales","sale_time>='".$_POST['finicio']." 00:00:00' and sale_time<='".$_POST['ffinal']." 23:59:59'");

echo "TIPO;NUMERO DOC.;FECHA;CUENTA;CONCEPTO;CENTRO;SKU;VALOR;NATURALEZA;NIT O CC DEL TERCERO;NOMBRE O RAZÓN SOCIAL";
$tipo=$application_config['spreadsheet_format'];
$centro=$application_config['time_format'];

foreach($sales['result'] as $s){

if($s['anulacion']==0){

$numero_doc=($s['id_manual']>0)?$s['id_manual']:$s['sale_id'];
$fecha=substr($s['sale_time'],0,10);
$customer_info=select_mysql('*','customers','person_id='.$s['customer_id']);
$cc=str_replace(";","",$customer_info['result'][0]['account_number']);
$person_info=select_mysql('*','people','person_id='.$s['customer_id']);
$full_name=str_replace(";","",$person_info['result'][0]['first_name']." ".$person_info['result'][0]['last_name']);

$items=select_mysql("*","sales_items",'sale_id='.$s['sale_id']);

foreach($items['result'] as $it){

$it_arr=select_mysql("*","items","item_id=".$it['item_id']);
$sku=str_replace(";","",$it_arr['result'][0]['product_id']);
$concepto=str_replace(";","",$it_arr['result'][0]['name']);
$natura=select_mysql("*","cuentascontables","categoria='".$it_arr['result'][0]['category']."'");
$cuenta_credito=($natura['count']>0)? $natura['result'][0]['credito'] : $application_config['hide_signature'] ;
$cuenta_i_credito=($natura['count']>0)? $natura['result'][0]['i_credito'] : $application_config['hide_store_account_payments_in_reports'] ;
$cuenta_i_debito=($natura['count']>0)? $natura['result'][0]['i_debito'] : $application_config['hide_layaways_sales_in_reports'] ;
$descuento=$it['discount_percent'];
$iva_arr=select_mysql("*",'sales_items_taxes',"item_id=".$it['item_id']." and sale_id=".$s['sale_id']."  ");
$iva=($iva_arr['count']>0)?$iva_arr['result'][0]['percent']:0;
$monto=number_format($it['item_unit_price'],2,'.','');
$inventory_arr=select_mysql("*","inventory","serialNumber like '".$it['serialnumber']."' and trans_items=".$it['item_id']);

//echo "TIPO;NUMERO DOC.;FECHA;CUENTA;CONCEPTO;CENTRO;SKU;VALOR;NATURALEZA;NIT O CC DEL TERCERO;NOMBRE O RAZÓN SOCIAL";



////MOVIMIENTO EN VENTA

///utf8_encode(str_replace(array("\n","\r",chr(8)),"",$full_name));


//if($descuento>0){
//$monto_1=number_format($monto/(1-($descuento/100)),2,'.','');
//$monto_2=number_format($monto_1-$monto,2,'.','');

//echo "\n".utf8_encode(str_replace(array("\n","\r",chr(8)),"","$tipo;$numero_doc;$fecha;$cuenta_credito;$concepto;$centro;$sku;$monto_1;C;$cc;$full_name"));
//echo "\n".utf8_encode(str_replace(array("\n","\r",chr(8)),"","$tipo;$numero_doc;$fecha;$cuenta_credito;$concepto;$centro;$sku;$monto_2;D;$cc;//$full_name"));
//}else{
echo "\n".utf8_encode(str_replace(array("\n","\r",chr(8)),"","$tipo;$numero_doc;$fecha;$cuenta_credito;$concepto;$centro;$sku;$monto;C;$cc;$full_name"));
//}

///IVA

if($iva>0){
echo "\n".utf8_encode(str_replace(array("\n","\r",chr(8)),"","$tipo;$numero_doc;$fecha;".$application_config['show_receipt_after_suspending_sale'].";IVA;$centro;N/A;".number_format(ceil($monto*($iva/100)),2).";C;$cc;$full_name"));
}

//////CREE

echo "\n".utf8_encode(str_replace(array("\n","\r",chr(8)),"","$tipo;$numero_doc;$fecha;".$application_config['hide_customer_recent_sales'].";RETENCION CREE;$centro;N/A;".number_format(ceil($monto*0.016),2).";C;$cc;$full_name"));
echo "\n".utf8_encode(str_replace(array("\n","\r",chr(8)),"","$tipo;$numero_doc;$fecha;".$application_config['hide_dashboard_statistics'].";RETENCION CREE;$centro;N/A;".number_format(ceil($monto*0.016),2).";D;$cc;$full_name"));

//////CAJA
//if($iva>0){
echo "\n".utf8_encode(str_replace(array("\n","\r",chr(8)),"","$tipo;$numero_doc;$fecha;".$application_config['track_cash'].";".$application_config['version'].";$centro;N/A;".number_format($monto+ceil($monto*(($iva/100))),2).";D;$cc;$full_name"));
//}

///////COSTEO DE INVENTARIO

//$serial_arr=select_mysql("*","inventory","serialNumber='".$it['serialnumber']."' and sale_Id='".$s['sale_id']."'");
//$costos=$serial_arr['result'][0]['cost_price'];
$costos=number_format($inventory_arr['result'][0]['cost_price'],2,'.','');

echo "\n".utf8_encode(str_replace(array("\n","\r",chr(8)),"","$tipo;$numero_doc;$fecha;".$cuenta_i_credito.";$concepto;$centro;$sku;$costos;C;$cc;$full_name"));
echo "\n".utf8_encode(str_replace(array("\n","\r",chr(8)),"","$tipo;$numero_doc;$fecha;".$cuenta_i_debito.";$concepto;$centro;$sku;$costos;D;$cc;$full_name"));




}



}





}





}
?>
