<?php
global $user_array;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){

$mm=select_mysql("*","geeksify_cuestionario","status=1");

foreach($mm['result'] as $f){
$tips=array(
'1'=>'Tipo A',
'2'=>'Tipo B',
'3'=>'Tipo C',
'4'=>'Tipo D',

);
echo "<tr>
<td>".$f['valor']."</td>
<td> ".$f['restar']."</td>
<td> ".$tips[$f['auto_clas']]."</td>
<td> <a onclick=\"javascript: delete_pregunta(".$f['pregunta_id'].");\">Eliminar</a></td>
</tr>";

}
}

?>
