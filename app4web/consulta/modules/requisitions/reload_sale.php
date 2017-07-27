<?php

global $user_array;
global $current_requisition_array;


if(permitido($user_array['person_id'],$_GET['mod'])){
$body="";
session_start();
$_SESSION['requisition']=$current_requisition_array;
session_write_close ();
$line=0;
$completo=0;
foreach($current_requisition_array['cart']['items'] as $k=>$i){

$item_info=select_mysql("*","items","item_id=".$i['item_id']);

$info=$item_info['result']['0'];


$cuan=select_mysql("*","inventory","state='Disponible' and trans_items=".$i['item_id']);
$disponible=$cuan['count'];
$quantity= (isset($i['quantity'])) ? $i['quantity'] : 1;
$quan_field="<input type='text' value='$quantity' onchange=\"javascript:change_quantity('$k',this.value);\">";
$cost=(isset($i['cost'])) ? $i['cost'] : $info['cost_price'];
$cost_field="<input type='text' value='".number_format($cost,2)."' onchange=\"javascript:change_cost('$k',this.value);\">";
$total=$quantity*$cost;
$completo+=$total;
$total=number_format($total,2,',','.');
$body.= "<tr class=\"cart_content_area\"> 
                                <td><a onclick=\"javascript:delete_item('$k');\" class=\"delete_item\"><i class=\"fa fa-trash-o fa fa-2x text-error\"></i></a></td>
                                <td>".$info['name']."</td>
                                <td>".$info['product_id']."</td>
                                <td>$disponible</td>
                                <td>$quan_field</td>
                                <td>$cost_field</td>
                                <td >$total</td>


</tr>
";


$line++;
}


if($body==""){

$body="<tr class=\"cart_content_area\">
                                    <td colspan='9'>
                                        <div class='text-center text-warning' > <h3>No hay artículos en el carrito</h3></div>
                                    </td>
                                </tr>";

}

if(isset($current_requisition_array['customer'])){

$customer_b=select_mysql("*","suppliers","person_id=".$current_requisition_array['customer']);
$customer_a=select_mysql("*","people","person_id=".$customer_b['result'][0]['person_id']);
$customer="<b>[ ".$customer_b['result'][0]['company_name']." ] ".$customer_a['result'][0]['last_name']." , ".$customer_a['result'][0]['first_name']."</b><br/><br/>";
}else{
$customer="";
}



$actualiza=array('table'=>$body,'sidebar'=>'','customer'=>$customer);

if(count($current_requisition_array['cart']['items'])>0 && $current_requisition_array['req_id']!='' && $current_requisition_array['eta']!=''){

$actualiza['complete_sale']="<input type=\"button\" class=\"btn btn-warning warning-buttons\" id=\"layaway_requisition_button\" id=\"enviar_caja\" value=\"Terminar\"/ onclick=\"javascript:finish_sale();\"> ";


}else{

$actualiza['complete_sale']="";

}
$actualiza['numeroPedido']=$current_requisition_array['req_id'];
$actualiza['eta']=$current_requisition_array['eta'];
$actualiza['comment']=$current_requisition_array['comment'];
$actualiza['prices']="<h4 class='success table'>Total: $ ".number_format($completo,2,',','.')."</h4>";

$actualiza['complete_sale'].="<input type=\"button\" class=\"btn btn-danger button_dangers\" id=\"cancel_requisition_button\" value=\"Cancelar\" onclick=\"javascript:clear_sale();\" />";

echo json_encode($actualiza);
}

?>
