<?php
global $var_array;
global $server;
global $x;
if($var_array['username']=='tiendasadmin'){

if(isset($_GET['plan_id']) && !(isset($_POST['is_service']))){

$plan_info=select_mysql("*","permanent_items","item_id=".$_GET['plan_id']);
$info=$plan_info['result'][0];
}else{
$info=$_POST;
}

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

dynamic_module_view("admin_portal",'item_form',$info);




}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
