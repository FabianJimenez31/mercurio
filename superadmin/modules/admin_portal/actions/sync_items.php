<?php
global $var_array;
global $server;
global $x;
if($var_array['username']=='tiendasadmin'){


$tiendas=select_mysql("*","tiendas","deleted!=1");

$items=select_mysql("*","permanent_items");

foreach($items['result'] as $it){

foreach($tiendas['result'] as $tt){
$it['supplier_id']="_NULO";
//$it['image_id']="0";
unset($it['supplier_id']);
unset($it['image_id']);
$current=select_mysql("*","".$tt['prefix']."items","product_id='".$it['product_id']."'");
if($current['count']>0){
unset($it['item_id']);
$it['permanent_item']=1;
$up=update_mysql("".$tt['prefix']."items",$it,"item_id=".$current['result'][0]['item_id']);
//echo "<br/>".$up['query'];
}else{
unset($it['item_id']);
$it['permanent_item']=1;
$in=insert_mysql("".$tt['prefix']."items",$it);
//echo "<br/>".$in['query'];

}
}

}

echo "<script>alert('Inventario Sincronizado');</script>";

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
