<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){

$datos=$_POST;
unset($datos['submitf']);

if(!(isset($datos['is_serialized']))){$datos['is_serialized']=0;}
if(!(isset($datos['is_service']))){$datos['is_service']=0;}
if(!(isset($datos['postpay']))){$datos['postpay']=0;}
if(!(isset($datos['val_serial']))){$datos['val_serial']=0;}

/*$datos['iva']=(isset($datos['override_default_tax']) && $datos['override_default_tax']=="1") ? 16.0 : 0.0 ;*/

if(isset($_GET['item_id'])){

$m=update_mysql("items",$datos,"item_id=".$_GET['item_id']);


echo json_encode(array('success'=>true , 'item_id'=>$_GET['item_id'] , 'message'=>"Artículo Guardado Exitosamente con ID ".$_GET['item_id']));


}else{

$m=insert_mysql("items",$datos);

if($m['last_id']<=0){
echo json_encode(array('success'=>false , 'item_id'=>$m['last_id'] , 'message'=>"Hubo un error al Guardar su informacion, verifique sus datos e intente de nuevo"));
}else{
echo json_encode(array('success'=>true , 'item_id'=>$m['last_id'] , 'message'=>"Artículo Guardado Exitosamente con ID ".$m['last_id']));
}

}
}

//log_me(grab_dump($datos));
//log_me($m['query']);

?>
