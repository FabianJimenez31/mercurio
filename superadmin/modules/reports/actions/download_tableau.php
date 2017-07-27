<?php
global $var_array;
global $server;
global $x;
if($var_array['username']=='tiendasadmin'){


$query_core="";

$stores=select_mysql("*","tiendas","deleted!=1");
$m=0;
foreach($stores['result'] as $s){

if($m==0){
$query_core.="SELECT 

CONCAT(".$s['prefix']."people.last_name,',',".$s['prefix']."people.first_name) AS vendedor ,
CONCAT(".$s['prefix']."T14.last_name,',',".$s['prefix']."T14.first_name) AS supervisor ,
CONCAT(".$s['prefix']."T15.last_name,',',".$s['prefix']."T15.first_name) AS cajero ,
CONCAT(".$s['prefix']."T16.last_name,',',".$s['prefix']."T16.first_name) AS nombre_cliente ,
CONCAT(".$s['prefix']."T17.company_name,' [ ',".$s['prefix']."T17.card_issuer,' ]') AS empresa_cliente ,
CONCAT(".$s['prefix']."T16.comments,' [ ',".$s['prefix']."T17.account_number,' ]') AS identificacion_cliente ,
".$s['prefix']."T16.phone_number AS telefono_cliente ,
".$s['prefix']."T16.email AS correo_electronico_cliente ,
".$s['prefix']."T16.address_1 AS direccion_cliente ,
".$s['prefix']."T16.city AS ciudad_cliente ,
".$s['prefix']."T16.state AS departamento_cliente ,
if(".$s['prefix']."T17.cc_token=1,'SI','NO') as habeas_data_cliente,
 ".$s['prefix']."sales.sale_id AS id_venta  ,
 CAST(".$s['prefix']."sales.sale_time as date) AS fecha ,
 CAST(".$s['prefix']."sales.sale_time as time) as hora ,
 ".$s['prefix']."sales.sale_time AS fecha_hora  ,
 '".stripslashes($s['name'])."' AS tienda  ,
 '".stripslashes($s['shortname'])."' AS clase ,
 ".$s['prefix']."sales_items.description AS articulo,
 ".$s['prefix']."sales_items.line AS orden  ,
 ".$s['prefix']."sales_items.serialnumber AS serial  ,
 ".$s['prefix']."sales_items.num_tel AS numero_telefono  ,
 ".$s['prefix']."items.name AS nombre_art,
 ".$s['prefix']."items.category AS categoria_art,
 ".$s['prefix']."items.item_number AS numero_art,
 ".$s['prefix']."items.product_id AS id_art,
 ".$s['prefix']."items.description AS descripcion_art,
 ROUND(".$s['prefix']."sales_items.item_unit_price * (1+(".$s['prefix']."sales_items_taxes.percent/100))) AS precio_publico


FROM ".$s['prefix']."sales_items 

LEFT JOIN ".$s['prefix']."sales ON ".$s['prefix']."sales.sale_id=".$s['prefix']."sales_items.sale_id

LEFT JOIN ".$s['prefix']."people ON ".$s['prefix']."sales.salesman=".$s['prefix']."people.person_id

LEFT JOIN ".$s['prefix']."people as ".$s['prefix']."T14 ON ".$s['prefix']."sales.supervisor=".$s['prefix']."T14.person_id

LEFT JOIN ".$s['prefix']."people as ".$s['prefix']."T15 ON ".$s['prefix']."sales.employee_id=".$s['prefix']."T15.person_id

LEFT JOIN ".$s['prefix']."people as ".$s['prefix']."T16 ON ".$s['prefix']."sales.customer_id=".$s['prefix']."T16.person_id

LEFT JOIN ".$s['prefix']."customers as ".$s['prefix']."T17 ON ".$s['prefix']."sales.customer_id=".$s['prefix']."T17.person_id

LEFT JOIN ".$s['prefix']."items ON ".$s['prefix']."items.item_id=".$s['prefix']."sales_items.item_id

LEFT JOIN ".$s['prefix']."sales_items_taxes ON ".$s['prefix']."sales_items_taxes.sale_id=".$s['prefix']."sales.sale_id 

AND ".$s['prefix']."sales_items_taxes.item_id=".$s['prefix']."sales_items.item_id
";
$m++;
}else{
$query_core.="
UNION

SELECT 

CONCAT(".$s['prefix']."people.last_name,',',".$s['prefix']."people.first_name) AS vendedor ,
CONCAT(".$s['prefix']."T14.last_name,',',".$s['prefix']."T14.first_name) AS supervisor ,
CONCAT(".$s['prefix']."T15.last_name,',',".$s['prefix']."T15.first_name) AS cajero ,
CONCAT(".$s['prefix']."T16.last_name,',',".$s['prefix']."T16.first_name) AS nombre_cliente ,
CONCAT(".$s['prefix']."T17.company_name,' [ ',".$s['prefix']."T17.card_issuer,' ]') AS empresa_cliente ,
CONCAT(".$s['prefix']."T16.comments,' [ ',".$s['prefix']."T17.account_number,' ]') AS identificacion_cliente ,
".$s['prefix']."T16.phone_number AS telefono_cliente ,
".$s['prefix']."T16.email AS correo_electronico_cliente ,
".$s['prefix']."T16.address_1 AS direccion_cliente ,
".$s['prefix']."T16.city AS ciudad_cliente ,
".$s['prefix']."T16.state AS departamento_cliente ,
if(".$s['prefix']."T17.cc_token=1,'SI','NO') as habeas_data_cliente,
 ".$s['prefix']."sales.sale_id AS id_venta  ,
 CAST(".$s['prefix']."sales.sale_time as date) AS fecha ,
 CAST(".$s['prefix']."sales.sale_time as time) as hora ,
 ".$s['prefix']."sales.sale_time AS fecha_hora  ,
 '".stripslashes($s['name'])."' AS tienda  ,
 '".stripslashes($s['shortname'])."' AS clase ,
 ".$s['prefix']."sales_items.description AS articulo,
 ".$s['prefix']."sales_items.line AS orden  ,
 ".$s['prefix']."sales_items.serialnumber AS serial  ,
 ".$s['prefix']."sales_items.num_tel AS numero_telefono  ,
 ".$s['prefix']."items.name AS nombre_art,
 ".$s['prefix']."items.category AS categoria_art,
 ".$s['prefix']."items.item_number AS numero_art,
 ".$s['prefix']."items.product_id AS id_art,
 ".$s['prefix']."items.description AS descripcion_art,
 ROUND(".$s['prefix']."sales_items.item_unit_price * (1+(".$s['prefix']."sales_items_taxes.percent/100))) AS precio_publico


FROM ".$s['prefix']."sales_items 

LEFT JOIN ".$s['prefix']."sales ON ".$s['prefix']."sales.sale_id=".$s['prefix']."sales_items.sale_id

LEFT JOIN ".$s['prefix']."people ON ".$s['prefix']."sales.salesman=".$s['prefix']."people.person_id

LEFT JOIN ".$s['prefix']."people as ".$s['prefix']."T14 ON ".$s['prefix']."sales.supervisor=".$s['prefix']."T14.person_id

LEFT JOIN ".$s['prefix']."people as ".$s['prefix']."T15 ON ".$s['prefix']."sales.employee_id=".$s['prefix']."T15.person_id

LEFT JOIN ".$s['prefix']."people as ".$s['prefix']."T16 ON ".$s['prefix']."sales.customer_id=".$s['prefix']."T16.person_id

LEFT JOIN ".$s['prefix']."customers as ".$s['prefix']."T17 ON ".$s['prefix']."sales.customer_id=".$s['prefix']."T17.person_id

LEFT JOIN ".$s['prefix']."items ON ".$s['prefix']."items.item_id=".$s['prefix']."sales_items.item_id

LEFT JOIN ".$s['prefix']."sales_items_taxes ON ".$s['prefix']."sales_items_taxes.sale_id=".$s['prefix']."sales.sale_id 

AND ".$s['prefix']."sales_items_taxes.item_id=".$s['prefix']."sales_items.item_id
";
}



}


$s['now']=date("Y-m-d");
$s['query']=$query_core.";";
header('Content-type: text/plain');
header("Content-Disposition: attachment; filename=current_query.sql");
dynamic_module_view("reports",'download_tableau',$s);




}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
