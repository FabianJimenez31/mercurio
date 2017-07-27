<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){

$datos=$_POST;

if(isset($_GET['item_kit_id']) && $_GET['item_kit_id']>0){

ejecutar("DELETE FROM ".DBPREFIX."item_kit_items WHERE item_kit_id=".$_GET['item_kit_id']);

$principal=array(
'item_kit_number'=>$datos['item_kit_number'],
'product_id'=>$datos['product_id'],
'name'=>$datos['name'],
'iva'=>$datos['iva'],
'unit_price'=>$datos['unit_price'],
'description'=>$datos['description'],
'category'=>$datos['category']

);


$m=update_mysql("item_kits",$principal,"item_kit_id=".$_GET['item_kit_id']);

foreach($datos['articulos'] as $a){

insert_mysql('item_kit_items',array('quantity'=>1 , 'item_id'=>$a , 'item_kit_id'=>$_GET['item_kit_id']));

}


echo json_encode(array('success'=>true , 'item_id'=>$_GET['item_kit_id'] , 'message'=>"Kit Guardado Exitosamente con ID ".$_GET['item_kit_id']));


}else{

$principal=array(
'item_kit_number'=>$datos['item_kit_number'],
'product_id'=>$datos['product_id'],
'name'=>$datos['name'],
'iva'=>$datos['iva'],
'unit_price'=>$datos['unit_price'],
'description'=>$datos['description'],
'category'=>$datos['category']

);


$m=insert_mysql("item_kits",$principal);

foreach($datos['articulos'] as $a){

insert_mysql('item_kit_items',array('quantity'=>1 , 'item_id'=>$a , 'item_kit_id'=>$m['last_id']));

}


echo json_encode(array('success'=>true , 'item_id'=>$m['last_id'] , 'message'=>"Kit Guardado Exitosamente con ID ".$m['last_id']));

}
}


?>
