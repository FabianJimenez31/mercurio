<?php

global $user_array;
global $current_presale_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$item_id=$_POST['item_id'];
$table="";
$sql=select_mysql("*","items","item_id=".$item_id);
$uid=guid();
$table.= "<tr id=\"".$uid."\">
								<td><a onclick=\"javascript:delete_item('".$uid."');\" class=\"delete_item\"><i class=\"fa fa-trash-o fa fa-2x text-error\"></i></a><input type=\"hidden\" name=\"articulos[]\" value='$item_id'></td>
								<td>".$sql['result'][0]['name']."</td>
								<td>1</td>
</tr>
";

echo json_encode(array('table'=>$table));

}



?>
