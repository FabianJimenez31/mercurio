<?php

global $user_array;
global $current_presale_array;
if(permitido($user_array['person_id'],$_GET['mod'])){
$body="";
session_start();
$_SESSION['presale']=$current_presale_array;
session_write_close ();
$line=0;
foreach($current_presale_array['cart']['items'] as $k=>$i){
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
                                <td>".number_format($info['unit_price'],2,',','.')."</td>
                                <td>".$i['quantity']."</td>
                                <td >N/A</td>
                                <td >0 %</td>
                                <td >".number_format($info['unit_price'],2,',','.')."</td>


</tr>

";

foreach($items['result'] as $it){

$serial_a=select_mysql('*','inventory',"state='Disponible' and trans_items=".$it['item_id'],'trans_date ASC',1);
$serial=($serial_a['count']>0) ? $serial_a['result'][0]['serialNumber'] : 'N/A';

$body.="

<tr class=\"cart_content_area\"> 
                                <td></td>
                                <td>".$it['name']."</td>
                                <td>".$it['product_id']."</td>
                                <td>-</td>
                                <td><del>".number_format($it['unit_price'],2,',','.')."</del></td>
                                <td>".$i['quantity']."</td>
                                <td colspan='3'>Incluido en ".$info['product_id']."<br>[Sugerido: $serial]</td>

</tr>


";


}


}else{
$item_info=select_mysql("*","items","item_id=".$i['item_id']);

$info=$item_info['result']['0'];

$promo_inicio=strtotime($info['start_date']." 00:00:00");
$promo_final=strtotime($info['end_date']." 23:59:59");

$current_price=($promo_final>0 && $promo_inicio>0 && ($promo_final-$promo_inicio)>0) ? '<del> '.number_format($info['unit_price'],2,',','.').'</del> '.number_format($info['promo_price'],2,',','.') : number_format($info['unit_price'],2,',','.');

$descuento=(substr($current_price,0,1)=='<') ? number_format((($info['unit_price']-$info['promo_price'])*100/$info['unit_price']),2,',','.').' %' : '0 %';

$total=number_format((substr($current_price,0,1)=='<') ? $info['promo_price'] : $info['unit_price'] , 2,',','.');

$serial_a=select_mysql('*','inventory',"state='Disponible' and trans_items=".$i['item_id'],'trans_date ASC',1);
$serial=($serial_a['count']>0) ? $serial_a['result'][0]['serialNumber'] : 'N/A';

$cuan=select_mysql("*","inventory","state='Disponible' and trans_items=".$i['item_id']);
$disponible=($cuan['count']>0 && ($cuan['count']-$i['quantity'])>=0) ? 'Disponible' : 'No Disponible';
$body.= "<tr class=\"cart_content_area\"> 
                                <td><a onclick=\"javascript:delete_item('$k');\" class=\"delete_item\"><i class=\"fa fa-trash-o fa fa-2x text-error\"></i></a></td>
                                <td>".$info['name']."</td>
                                <td>".$info['product_id']."</td>
                                <td>$disponible</td>
                                <td>$current_price</td>
                                <td>".$i['quantity']."</td>
                                <td >$serial</td>
                                <td >$descuento</td>
                                <td >$total</td>


</tr>
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

if(isset($current_presale_array['customer'])){

$customer_a=select_mysql("*","people","person_id=".$current_presale_array['customer']);

$customer="<b>".$customer_a['result'][0]['last_name']." , ".$customer_a['result'][0]['first_name']."</b><br/><br/>";
}else{
$customer="";
}



$actualiza=array('table'=>$body,'sidebar'=>'','customer'=>$customer);

if(count($current_presale_array['cart']['items'])>0 && $current_presale_array['customer']>0){

$actualiza['complete_sale']="<input type=\"button\" class=\"btn btn-warning warning-buttons\" id=\"layaway_presale_button\" id=\"enviar_caja\" value=\"Enviar a Caja\"/ onclick=\"javascript:finish_sale();\"> ";


}else{

$actualiza['complete_sale']="";

}

$actualiza['complete_sale'].="<input type=\"button\" class=\"btn btn-danger button_dangers\" id=\"cancel_presale_button\" value=\"Cancelar\" onclick=\"javascript:clear_sale();\" />";

echo json_encode($actualiza);
}

?>
