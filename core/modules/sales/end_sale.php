<?php

global $user_array;
global $current_sale_array;
global $user_box;
$line=0;
if(permitido($user_array['person_id'],$_GET['mod']) && $current_sale_array['customer']>0 ){

$supervisor_arr=select_mysql("*","employees","person_id='".(($current_sale_array['salesman']>0)?$current_sale_array['salesman']:$user_array['person_id'])."'");
$supervisor_value=$supervisor_arr['result'][0]['supervisor_who'];

$sale=array(

'customer_id'=>$current_sale_array['customer'],
'employee_id'=>$user_array['person_id'],
'show_comment_on_receipt'=>($current_sale_array['show_comment']) ? 1:0,
'location_id'=>'1',
'resolucion'=>$current_sale_array['resolucion'],
'comment'=>$current_sale_array['comment'],
'salesman'=>(($current_sale_array['salesman']>0)?$current_sale_array['salesman']:$user_array['person_id']),
'supervisor'=>$supervisor_value

);

if($current_sale_array['is_manual']){

$info=select_mysql('MIN( sale_id ) AS minimo','sales');

$sale['sale_id']=$info['result'][0]['minimo']-1;
$sale['id_manual']=$current_sale_array['manual_folio'];

}

if(isset($current_sale_array['presale_id']) && $current_sale_array['presale_id']>0){

update_mysql('presales',array('suspended'=>'3'),"presale_id=".$current_sale_array['presale_id']);
$sale['cc_ref_no']=$current_sale_array['presale_id'];

}

$venta=insert_mysql('sales',$sale);

if(isset($sale['sale_id'])){$venta['last_id']=$sale['sale_id'];}

foreach($current_sale_array['cart']['items'] as $i){

if(substr($i['item_id'],0,1)=='K'){

$ik_id=str_replace('K','',$i['item_id']);

$item_info=select_mysql("*","item_kits",'item_kit_id='.$ik_id);
$info=$item_info['result'][0];




$seriales_kit="";

foreach($i as $y=>$v){

if(is_array($i[$y])){

$seriales_kit.="|".$y.":::".$i[$y]['serial'];
$id_item=select_mysql("*",'items',"product_id like '".$y."'" );
$idd=$id_item['result'][0]['item_id'];

$inventory=array(

'state'=>'Vendido',
'sale_Id'=>$venta['last_id'],
'sale_fecha'=>date("Y-m-d H:i:s"),
'sale_price'=>0,
'tax_price'=>0,
'tax_percent'=>0,
'discount_percent'=>100,
'discount'=>$id_item['unit_price']

);
$k=update_mysql('inventory',$inventory,"trans_items=".$idd." AND serialNumber='".$i[$y]['serial']."'");





}
}


$item_kits=array(
'sale_id'=>$venta['last_id'],
'item_kit_id'=>$ik_id,
'description'=>$seriales_kit,
'line'=>$line,
'quantity_purchased'=>1,
'item_kit_unit_price'=>$info['unit_price'],


);

$line++;

$gf=insert_mysql('sales_item_kits',$item_kits);




if($info['iva']>0){

$taxes=array(
'sale_id'=>$venta['last_id'],
'item_kit_id'=>$ik_id,
'line'=>$line,
'name'=>'IVA',
'percent'=>$info['iva']

);
$line++;
$rm=insert_mysql('sales_item_kits_taxes',$taxes);

}


}else{



$item_info=select_mysql("*","items",'item_id='.$i['item_id']);
$info=$item_info['result'][0];
$numtel=($i['num_tel']!='')?$i['num_tel']:'N/A';
$promo_inicio=($info['start_date']!='0000-00-00' && $info['start_date']!='')?strtotime($info['start_date']." 00:00:00"):-1;
$promo_final=($info['end_date']!='0000-00-00' && $info['end_date']!='')?strtotime($info['end_date']." 23:59:59"):-5;
$current_real_price=($promo_final>0 && $promo_inicio>0 && ($promo_final-$promo_inicio)>0) ? $info['promo_price'] : $info['unit_price'];
$current_real_price=(isset($i['acc_cost']))?$i['acc_cost']:$current_real_price;
$total=$i['quantity']*$current_real_price*(1-($i['discount']/100));
$total_nopost=$total;
$total=($i['post_first']=="1")? '0':$total;
$post_first=($i['post_first']=="1")? '1':'0';
$item=array(
'sale_id'=>$venta['last_id'],
'item_id'=>$i['item_id'],
'quantity_purchased'=>$i['quantity'],
'description'=>$info['product_id'],
'item_cost_price'=>$info['cost_price'],
'item_unit_price'=>$total,
'real_item_unit_price'=>$total_nopost,
'discount_percent'=>$i['discount'],
'serialnumber'=>$i['serial'],
'num_tel'=>$i['num_tel'],
'line'=>$line,
'post_first'=>$post_first
);

if($i['temp_contrato']!=''){
$temporal_contato=select_mysql("*","temporal_contratos","unique_id='".$i['temp_contrato']."'");
$addicionales=$temporal_contato['result'][0];
$item['contrato_type']=$addicionales['meta'];
$item['contrato_extension']=$addicionales['name'];

}


$j=insert_mysql('sales_items',$item);

if($i['temp_contrato']!=''){

$where=" sale_id='".$venta['last_id']."' and  item_id='".$i['item_id']."' and line='$line' ";

ejecutar("UPDATE ".DBPREFIX."sales_items set contrato='".addslashes($addicionales['file'])."' where $where");
ejecutar("DELETE FROM  ".DBPREFIX."temporal_contratos  where unique_id='".$i['temp_contrato']."'");
}

$line++;

if($info['is_service']!=1){
$inventory=array(

'state'=>'Vendido',
'sale_Id'=>$venta['last_id'],
'sale_fecha'=>date("Y-m-d H:i:s"),
'sale_price'=>$total,
'tax_price'=>($info['iva']>0)?($total*($info['iva']/100)):0,
'tax_percent'=>($info['iva']>0)?$info['iva']:0,
'discount_percent'=>$i['discount'],
'discount'=>$current_real_price*($i['discount']/100)

);
if($info['val_serial']==1){$k=update_mysql('inventory',$inventory,"trans_items=".$i['item_id']." AND serialNumber='".$i['serial']."' LIMIT 1");}
}
if($info['iva']>0){
$taxes=array(
'sale_id'=>$venta['last_id'],
'item_id'=>$i['item_id'],
'line'=>$line,
'name'=>'IVA',
'percent'=>$info['iva']


);
$line++;
$h=insert_mysql('sales_items_taxes',$taxes);

}

}


}


foreach($current_sale_array['payments'] as $p){

$table=array(
'sale_id'=>$venta['last_id'],
'payment_type'=>$p['type'],
'payment_amount'=>$p['ammount'],
'truncated_card'=>$p['comment'],
'session_box'=>$user_box

);

$w=insert_mysql('sales_payments',$table);

}


foreach($current_sale_array as $k=>$v){

unset($current_sale_array[$k]);

}

session_start();
$_SESSION['sale']=$current_sale_array;
session_write_close ();

$actualiza=array('message'=>label_me('saved_info'),'message_header'=>label_me('success'),'success'=>true,'req_id'=>$venta['last_id'],'error_out'=>'ninguno');
echo json_encode($actualiza);
}else{

$actualiza=array('message'=>"INVALID REQUEST",'message_header'=>"INVALID REQUEST",'success'=>true,'req_id'=>'INVALID REQUEST','error_out'=>'a999');
echo json_encode($actualiza);
}

?>
