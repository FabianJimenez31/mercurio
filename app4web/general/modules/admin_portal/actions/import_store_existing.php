<?php
global $var_array;
global $server;
global $x;
if($var_array['username']=='tiendasadmin'){


$tienda_id=$_POST['tienda'];


$valores=select_mysql("*","tiendas","id=$tienda_id");

$items=select_mysql("*",$valores['result'][0]['prefix']."items","deleted=0");
foreach($items['result'] as $it){

$current=select_mysql("*","permanent_items","product_id='".$it['product_id']."' and deleted=0");
if($current['count']>0){
unset($it['item_id']);
unset($it['permanent_item']);
$up=update_mysql("permanent_items",$it,"item_id=".$current['result'][0]['item_id']);

}else{
unset($it['item_id']);
unset($it['permanent_item']);
$in=insert_mysql("permanent_items",$it);
}


}

echo "<script>alert('Inventario Importado');</script>";

$servers=select_mysql("*","permanent_items");

foreach($servers['result'] as $s){

$server[]=array(
"id"=>$s['item_id'],
'name'=>$s['name'],
'product_id'=>$s['product_id'],
'category'=>$s['category'],
'cost'=> number_format($s['cost_price'],2,",","."),
'price'=> number_format($s['unit_price'],2,",",".")

);

}

dynamic_module_view("admin_portal",'plans',array('plans'=>$server));

}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
