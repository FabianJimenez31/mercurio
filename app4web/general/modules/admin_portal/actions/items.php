<?php
global $var_array;
global $server;
global $x;
if($var_array['username']=='tiendasadmin'){


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
