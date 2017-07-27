<?php
global $var_array;
global $server;
global $x;


if($var_array['get']['app_force_key']==md5('app4webmercuriounique')){

$query_completa="";

$m=select_mysql("*","tiendas","deleted!=1");
$xx=0;
foreach($m['result'] as $ti){

$query_completa.=($xx==0)?"
select 

'".stripslashes($ti['name'])."' as tienda , 

'".stripslashes($ti['shortname'])."' as pref , 

ceil(sum(t1.trans_inventory)) as cuantos,

t2.name as producto


 from ".$ti['prefix']."inventory as t1

left join ".$ti['prefix']."items as t2 on t1.trans_items=t2.item_id


WHERE  state='Disponible'

AND t2.product_id='".$_GET['product_id']."'

Group by t1.trans_items

":"

UNION

select 

'".stripslashes($ti['name'])."' as tienda , 

'".stripslashes($ti['shortname'])."' as pref , 

ceil(sum(t1.trans_inventory)) as cuantos,

t2.name as producto

 from ".$ti['prefix']."inventory as t1

left join ".$ti['prefix']."items as t2 on t1.trans_items=t2.item_id


WHERE state='Disponible'

AND t2.product_id='".$_GET['product_id']."'

Group by t1.trans_items

";
$xx++;
}




$completo=ejecutar($query_completa);

$arreglo=mostrar($completo);
$data=array(

'sku'=>$_GET['product_id'],
'query'=>$query_completa,
'results'=>$arreglo
);

dynamic_module_view("reports",'inventory',$data);


}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
