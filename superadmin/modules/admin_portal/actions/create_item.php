<?php
global $var_array;
global $server;
global $x;
if($var_array['username']=='tiendasadmin'){

if(isset($_POST['item_id']) && $_POST['item_id']>0){
$method="UPDATE";
$vali=select_mysql("*","permanent_items","( item_number='".$_POST['item_number']."' and product_id='".$_POST['product_id']."' ) and item_id!='".$_POST['item_id']."'");

}else{
$method="CREATE";
$vali=select_mysql("*","permanent_items","( item_number='".$_POST['item_number']."' and product_id='".$_POST['product_id']."' )");
}

if($vali['count']>0){

$info=$_POST;


if(isset($_POST['item_id']) || isset($_GET['plan_id']) ){
$info['item_id_field']="<input type='hidden' name='item_id' value='".$info['item_id']."' />";
}else{
$info['item_id_field']="";
}

if(isset($_GET['plan_id'])){$info['main_label']="EDITANDO ARTICULO";}else{$info['main_label']="NUEVO ARTICULO";}

$info['ck_serialized']=($info['is_serialized']==1)? " checked " : "";
$info['ck_service']=($info['is_service']==1)? " checked " : "";
$info['ck_postpay']=($info['postpay']==1)? " checked " : "";
$info['ck_val_serial']=($info['val_serial']==1)? " checked " : "";

$info['special_prices']=array();

for($x=1;$x<=10;$x++){

$info['special_prices'][$x]['label']=$x;

$info['tier_'.$x."_allch"]=($info['tier_'.$x."_allow"]=="Y")? " SELECTED ":"";
$info['tier_'.$x."_alln"]=($info['tier_'.$x."_allow"]=="Y")? "  ":" SELECTED ";

}

$info['error_log']="<p style='color:red'><b>El producto ya Existe</b></p>";

dynamic_module_view("admin_portal",'item_form',$info);


}else{


$datos=$_POST;
unset($datos['submitf']);

if(!(isset($datos['is_serialized']))){$datos['is_serialized']=0;}
if(!(isset($datos['is_service']))){$datos['is_service']=0;}
if(!(isset($datos['postpay']))){$datos['postpay']=0;}
if(!(isset($datos['val_serial']))){$datos['val_serial']=0;}


if($method=="UPDATE"){

$m=update_mysql("permanent_items",$datos,"item_id=".$_POST['item_id']);
$l=$_POST['item_id'];
}else{
$m=insert_mysql("permanent_items",$datos);
$l=$m['last_id'];
}

echo "<script>alert('Item Modificado con ID Interno $l');</script>";

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


}




}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
