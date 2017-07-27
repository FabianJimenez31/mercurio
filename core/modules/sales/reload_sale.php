<?php

global $user_array;
global $current_sale_array;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){
$body="";
session_start();
$_SESSION['sale']=$current_sale_array;
session_write_close ();
$line=0;
$completo=0;
$taxes=0;
$discounts=0;
$sin_seriales=0;
foreach($current_sale_array['cart']['items'] as $k=>$i){
if(substr($i['item_id'],0,1)=='K'){

$ik_id=str_replace('K','',$i['item_id']);
$item_kit_info=select_mysql("*","item_kits","item_kit_id=".$ik_id);

$info=$item_kit_info['result'][0];
$items=select_mysql('t1.item_id , t1.quantity , t2.name , t2.product_id, t2.description , t2.unit_price , t2.promo_price, t2.start_date , t2.end_date','item_kit_items as t1 inner join '.DBPREFIX.'items as t2 on t1.item_id=t2.item_id and t1.item_kit_id='.$ik_id);

$body.="

<tr class=\"cart_content_area\"> 
                                <td><a onclick=\"javascript:delete_item('$k');\" class=\"delete_item\"><i class=\"fa fa-trash-o fa fa-2x text-error\"></i></a></td>
                                <td>".$info['name']."</td>
                                <td>".$info['product_id']."</td>
                                <td>-</td>
                                <td>".$i['quantity']."</td>
                                <td>".number_format($info['unit_price'],2,',','.')."</td>

                                <td >0 %</td>
                                <td >".number_format($info['unit_price'],2,',','.')."</td>


</tr>

";
$completo+=($info['unit_price']);

if($info['iva']>0){$taxes+=ceil($i['quantity']*$info['unit_price']*($info['iva']/100));}

foreach($items['result'] as $it){

if(!(isset($current_sale_array['cart']['items'][$k][$i][$it['product_id']]['serial']))){
$current_sale_array['cart']['items'][$k][$i][$it['product_id']]['serial']='';
}

$serial=(isset($i[$it['product_id']]['serial']) && $i[$it['product_id']]['serial']!='') ? $i[$it['product_id']]['serial'] : '';
$serial_field="<input type='text' value='".$serial."' onchange=\"javascript:change_serial_kit('$k','".$it['product_id']."',this.value);\">";
if($serial==''){$sin_seriales++;}

$serial_a=select_mysql('*','inventory',"state='Disponible' and trans_items=".$it['item_id'],'trans_date ASC',1);
$serial_b=($serial_a['count']>0) ? $serial_a['result'][0]['serialNumber'] : 'N/A';

$serial_ex=select_mysql('*','inventory',"state='Disponible' and serialNumber='".$i[$it['product_id']]['serial']."' and trans_items=".$it['item_id']);
$serial_ok=($serial_ex['count']==1) ? "<p style='color:green;'><b>OK</b></p>":"<p style='color:red;'><b>SERIAL NO EXISTE</b></p>";

if($serial_ok=="<p style='color:red;'><b>SERIAL NO EXISTE</b></p>"){$sin_seriales++;}

$body.="

<tr class=\"cart_content_area\"> 
                                <td></td>
                                <td>".$it['name']."</td>
                                <td>".$it['product_id']."</td>
                                <td>-</td>
                                <td>".$i['quantity']."</td>
                                <td><del>".number_format($it['unit_price'],2,',','.')."</del></td>

                                <td colspan='3'>Incluido en ".$info['product_id']."</td>

</tr>

<tr>

<td colspan='4'>
Serial Sugerido: $serial_b
</td>

<td colspan='4'>
Serial: $serial_field
$serial_ok
</td>
</tr>

";


}


}else{
$item_info=select_mysql("*","items","item_id=".$i['item_id']);

$info=$item_info['result']['0'];
$permite_reserve=($info['mezclar_disponibles_preventa']==1)?0:1;
$vendidos_reservados=0;
if($permite_reserve==0){

$restantes=select_mysql("*","preventas","sale_id!=0 and deleted=0 and item_id=".$i['item_id']);
$vendidos_reservados=(($info['preventa_disponibles']-$restantes['count'])<0)?0:($info['preventa_disponibles']-$restantes['count']);

}

$is_service=$info['is_service'];
$is_serialized=$info['is_serialized'];
$is_forced_serial=$info['val_serial'];
$is_postpay=$info['postpay'];
$cuan=select_mysql("*","inventory","state='Disponible' and trans_items=".$i['item_id']);
$disponible=$cuan['count']-$vendidos_reservados;
$quantity=  1;
$quan_field=$quantity;
$promo_inicio=($info['start_date']!='0000-00-00' && $info['start_date']!='')?strtotime($info['start_date']." 00:00:00"):-1;
$promo_final=($info['end_date']!='0000-00-00' && $info['end_date']!='')?strtotime($info['end_date']." 23:59:59"):-5;

$current_price=(isset($i['acc_cost'])) ? number_format($i['acc_cost'],2,',','.'):'UNSET';
$current_price_aux=($promo_final>0 && $promo_inicio>0 && ($promo_final-$promo_inicio)>0) ? '<del> '.number_format($info['unit_price'],2,',','.').'</del> '.number_format($info['promo_price'],2,',','.') : number_format($info['unit_price'],2,',','.');
$current_price=($current_price=='UNSET')?$current_price_aux:$current_price;



$current_real_price=(isset($i['acc_cost'])) ? $i['acc_cost']:'UNSET';

$current_real_price_aux=($promo_final>0 && $promo_inicio>0 && ($promo_final-$promo_inicio)>0) ? $info['promo_price'] : $info['unit_price'];

$current_real_price=($current_real_price=='UNSET') ? $current_real_price_aux:$current_real_price;

$current_real_price_unmod=($promo_final>0 && $promo_inicio>0 && ($promo_final-$promo_inicio)>0) ? $info['promo_price'] : $info['unit_price'];

$cost=$current_real_price;
$cost_field=$current_price;
$sel_cf_op=($current_real_price==$current_real_price_unmod)?" selected ":"";
$cf_options="<option value='".$current_real_price_unmod."' $sel_cf_op>".number_format($current_real_price_unmod,2,",",".")."</option>";
for($xpr=1;$xpr<=10;$xpr++){
$sel_opt_cf=($current_real_price==$info['tier_'.$xpr])?" SELECTED " : "";
if($info['tier_'.$xpr.'_allow']=='Y'){
$cf_options.="<option value='".$info['tier_'.$xpr]."' $sel_opt_cf>".number_format($info['tier_'.$xpr],2,",",".")." ".$info['tier_'.$xpr.'_name']."</option>";
}
}
$cost_field.="<select onchange=\"javascript:change_item_cost('$k',this.value);\">$cf_options</select>";
$discount=(isset($i['discount'])) ? $i['discount'] : 0;
$discount_field="<table><tr><td><input type='text' class='inline' size='10' value='".number_format($discount,2)."' onchange=\"javascript:change_discount('$k',this.value);\"></td><td>%</td></tr></table>";

$serial=(isset($i['serial']) && $i['serial']!='') ? $i['serial'] : '';
$serial_field="<input type='text' value='".$serial."' onchange=\"javascript:change_serial('$k',this.value);\">";
if($serial=='' && $is_serialized>0){$sin_seriales++;}


if($is_service==1 && $is_serialized==1){

$num_tel=(isset($i['num_tel']) && $i['num_tel']!='') ? $i['num_tel'] : '';
$num_tel_field="<input type='text' value='".$num_tel."' onchange=\"javascript:change_numtel('$k',this.value);\">";
$num_tel_ok=($num_tel!='')?"<p style='color:green;'><b>OK</b></p>":"<p style='color:red;'><b>INGRESA EL  NUMERO DE TELEFONO ASIGNADO </b></p>";

if(!(isset($num_tel)) || $num_tel==''){$sin_seriales++;}

}



if($is_service==1 && $is_serialized==1){
$string=base64_encode(" unique_id='".$i['temp_contrato']."' ");
$temp_contrato=(isset($i['temp_contrato']) && $i['temp_contrato']!='') ? $i['temp_contrato'] : '';
if($temp_contrato!=''){

$valida_contrato_file=select_mysql("*","temporal_contratos",base64_decode($string));
if($valida_contrato_file['result'][0]['file']!=''){}else{$temp_contrato=''; $i['temp_contrato']='';}
}
$temp_contrato_field=(isset($i['temp_contrato']) && $i['temp_contrato']!='')? "<div id='contrato_form_div_$k'>

<a href='?mod=sales&proc=download_contrato_file&string=".$string."' target='_blank'>Descargar</a> | <a onclick=\"javascript:delete_image_contrato('$k','".$i['temp_contrato']."');\">Eliminar</a>
</div>" : "

<div id='contrato_form_div_$k'>
<form method='POST' enctype=\"multipart/form-data\" id='contrato_form_$k' action='?mod=sales&proc=upload_tmp_file'>
<input name='line' type='hidden' value='$k' />
<input type='file' name='contrato' />
<a onclick=\"javascript:upload_image_contrato('$k');\" style=\"cursor: pointer; cursor: hand;\">Subir Archivo</a>
</form>
</div>
";
$temp_contrato_ok=($temp_contrato!='')?"<p style='color:green;'><b>OK</b></p>":"<p style='color:red;'><b>INGRESA EL ARCHIVO DE LISIM</b></p>";
/* COMENTAR EL SIGUIENTE RENGLON PARA QUITAR LA OBLIGATORIEDAD DEL ARCHIVO */
//if(!(isset($temp_contrato)) || $temp_contrato==''){$sin_seriales++;}

}




if($is_postpay==1){
$check_pp=($i['post_first']=="1")?" checked ":"";
$postpay="

<tr>

<td colspan='8'>
<p><span><input type=\"checkbox\" name=\"postpay\" id=\"".$k."_postpay\" onclick=\"javascript:change_postpay('$k');\"  $check_pp /></span> Primer Pago </p>
</td>
</tr>
";
$cost=($i['post_first']=="1")?0:$cost;
}else{
$postpay="";
}

$serial_a=select_mysql('*','inventory',"state='Disponible' and trans_items=".$i['item_id'],'trans_date ASC',1);
$serial_b=($serial_a['count']>0 && $disponible>0) ? $serial_a['result'][0]['serialNumber'] : 'N/A';

$serial_ex=select_mysql('*','inventory',"state='Disponible' and serialNumber='".$i['serial']."' and trans_items=".$i['item_id']);
$serial_ok=($serial_ex['count']>=1 || ($is_forced_serial<1 && $i['serial']!='')) ? "<p style='color:green;'><b>OK</b></p>":"<p style='color:red;'><b>SERIAL NO EXISTE</b></p>";

if($is_service==1 && $is_serialized==1){
if($i['serial']==''){$serial_ok="<p style='color:red;'><b>INGRESA NUMERO DE PEDIDO</b></p>";}else{$serial_ok="<p style='color:green;'><b>OK</b></p>";}
}

if(($serial_ok=="<p style='color:red;'><b>SERIAL NO EXISTE</b></p>" || $serial_ok=="<p style='color:red;'><b>NO HAZ INGRESADO NUMERO DE LISIM</b></p>")  &&  $is_serialized>0){$sin_seriales++;}



if($info['iva']>0){$taxes+=ceil($quantity*$cost*(1-($discount/100))*($info['iva']/100));}
$discounts+=$quantity*$cost*(($discount/100));
$total=$quantity*$cost*(1-($discount/100));
$completo+=$total;
$total=number_format($total,2,',','.');

$serial_added="
<tr>

<td colspan='4'>
Serial Sugerido: $serial_b
</td>

<td colspan='4'>
Serial: $serial_field
$serial_ok
</td>
</tr>
$postpay
";

if($is_serialized==1 && $is_service==1){

$serial_added="
<tr>

<td colspan='8'>
Contrato: $serial_field
$serial_ok
</td>
</tr>


<td colspan='8'>
Imágen de Contato: $temp_contrato_field
$temp_contrato_ok
</td>
</tr>


<tr>

<td colspan='8'>
Número Telefónico: $num_tel_field
$num_tel_ok
</td>
</tr>
$postpay
";

}

if($is_serialized!=1){$serial_added="";}

$body.= "<tr class=\"cart_content_area\"> 
                                <td><a onclick=\"javascript:delete_item('$k');\" class=\"delete_item\"><i class=\"fa fa-trash-o fa fa-2x text-error\"></i></a></td>
                                <td>".$info['name']."</td>
                                <td>".$info['product_id']."</td>
                                <td>$disponible</td>
                                <td>$quan_field</td>
                                <td>$cost_field</td>
                                <td>$discount_field</td>
                                <td >$total</td>


</tr>
$serial_added
";
}

$line++;
}


if($body==""){

$body="<tr class=\"cart_content_area\">
                                    <td colspan='9'>
                                        <div class='text-center text-warning' > <h3>No hay artículos en el carrito</h3></div>
                                    </td>
                                </tr>";

}

if(isset($current_sale_array['customer'])){

$customer_b=select_mysql("*","customers","person_id=".$current_sale_array['customer']);
$customer_a=select_mysql("*","people","person_id=".$customer_b['result'][0]['person_id']);
$customer="<b> ".$customer_a['result'][0]['last_name']." , ".$customer_a['result'][0]['first_name']."</b><br/><br/>";
}else{
$customer="";
}


$pagos="";
$pagado=0;
foreach($current_sale_array['payments'] as $k=>$i){
$coo=($i['comment']=='') ? '' : "[ ".$i['comment']." ]";
$pagos.="
<tr class='info'>
<td class='left'><a onclick=\"javascript:delete_payment('$k');\" class=\"delete_payment\"><i class=\"fa fa-trash-o fa fa-2x text-error\"></i></a></td>
<td class='left'>".$i['type'].$coo."</td>
<td class='right'>$".number_format($i['ammount'],2,',','.')."</td>
</tr>

";
$pagado+=$i['ammount'];
}


$manual_validada=(($current_sale_array['is_manual'] &&  $current_sale_array['manual_folio']!='') ||  ($current_sale_array['is_manual']==false) ) ? true : false ;
$current_sale_array['resolucion']=(isset($current_sale_array['resolucion']) && $current_sale_array['resolucion']!='') ? $current_sale_array['resolucion'] : utf8_encode($application_config['resolucionActual']);

$actualiza=array('table'=>$body,'sidebar'=>'','customer'=>$customer);

if(count($current_sale_array['cart']['items'])>0 && $current_sale_array['customer']>0 && ($completo+$taxes - $pagado)<1 && $sin_seriales==0 && $manual_validada && isset($current_sale_array['resolucion']) && $current_sale_array['resolucion']!='' ){

$actualiza['complete_sale']="<input type=\"button\" class=\"btn btn-warning warning-buttons\" id=\"layaway_sale_button\" id=\"enviar_caja\" value=\"Terminar\"/ onclick=\"javascript:finish_sale();\"> ";


}else{

$actualiza['complete_sale']="";

}

$actualiza['remain']="

<tr class=\"success\">
                            <td ><h4 class=\"sales_totals success sales_amount_due\">Cantidad a Pagar:</h4></td>
                            <td ><h3 class=\"currency_totals  success amount_due\" id=\"total\">$".number_format($completo+$taxes-$pagado,2,',','.')."</h3></td>
                        </tr>

";
$actualiza['pending']=number_format($completo+$taxes - $pagado,2,'.','');
$actualiza['payments']=$pagos;
$actualiza['eta']=$current_sale_array['eta'];
$actualiza['comment']=$current_sale_array['comment'];
$actualiza['prices']="$".number_format($completo,2,',','.');
$actualiza['taxes']="$".number_format($taxes,2,',','.');
$actualiza['total']="$".number_format($taxes+$completo,2,',','.');
$actualiza['show_comments']=$current_sale_array['show_comment'];
$actualiza['show_manual']=(isset($current_sale_array['show_manual'])) ? $current_sale_array['show_manual'] : 'none';
$actualiza['is_manual']=$current_sale_array['is_manual'];
$actualiza['resolucion']=$current_sale_array['resolucion'];
$actualiza['manual_folio']=$current_sale_array['manual_folio'];

////////AGREGAR VENDEDOR

$salesmen=select_mysql("*","employees","deleted=0");
$actualiza['salesman']="<option value='0'>Selecciona un Vendedor</option>";
foreach($salesmen['result'] as $s){

$seleccc=($s['person_id']==$current_sale_array['salesman'])?" selected ":"";

$person=select_mysql("*","people","person_id=".$s['person_id']);

foreach($person['result'] as $p){

$actualiza['salesman'].="<option value='".$s['person_id']."' $seleccc>".$p['first_name']." ".$p['last_name']."</option>";

}

}



$actualiza['complete_sale'].="<input type=\"button\" class=\"btn btn-danger button_dangers\" id=\"cancel_sale_button\" value=\"Cancelar\" onclick=\"javascript:clear_sale();\" />";

session_start();
$_SESSION['sale']=$current_sale_array;
session_write_close ();


echo json_encode($actualiza);
}

?>
