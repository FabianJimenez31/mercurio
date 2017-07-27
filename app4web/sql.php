<?php
function ejecutar($sql,$last_id="FALSE"){
$myuser=MYSQLUSER;
$mypassword=MYSQLPSSWD;
$mydb=MYSQLDB;
$myhost=MYSQLHOST;
$myid = mysqli_connect($myhost,$myuser, $mypassword);
mysqli_select_db($myid,$mydb);
$resultado=mysqli_query($myid,$sql);

if($last_id=="TRUE"){

$last_id=mysqli_insert_id($myid);

$resultado=array("result"=>$resultado,"last_id"=>$last_id,"query"=>$sql);
}
mysqli_close($myid);
return $resultado;
}

function mostrar($full){
$x=0;
$f=array();
if($full!=false){
while($r=mysqli_fetch_array($full,MYSQLI_ASSOC)){
$f[$x]=$r;
$x++;
}
}
return $f;
}

function contar($full){
if($full!=false){
$resultado=mysqli_num_rows($full);
}else{
$resultado=0;
}
return $resultado;
}



function select_mysql($fields,$table,$where="1",$order="none",$limit="none"){
$table=DBPREFIX.$table;
$where=str_replace(array(";","''","\""),array("\;","","\\\""),$where);
$query="SELECT $fields FROM $table WHERE $where";
if($order!="none"){
$query.=" ORDER BY $order";
}
if($limit!="none"){
$query.=" LIMIT $limit";
}
$query.=";";
//echo $query;
$result=ejecutar($query);
$array=mostrar($result);
$count=contar($result);
$final=array("count"=>$count,"result"=>$array,"query"=>$query);
return $final;
}


function insert_mysql($table,$values){
$table=DBPREFIX.$table;
$k="";
$v="";
$x=0;
foreach($values as $key=>$value){
if($x==0){
$k.="$key";
$value=utf8_encode(str_replace(array("\\",";","%","'","\""),array("\\\\","\;","\%","\'","\\\""),$value));
$v.=($value=="_NULO")? "NULL": "'$value'";
}else{
$k.=",$key";
$value=utf8_encode(str_replace(array("\\",";","%","'","\""),array("\\\\","\;","\%","\'","\\\""),$value));
$v.=($value=="_NULO")? ","."NULL": ",'$value'";
}
$x++;
}
$query="INSERT INTO $table ($k) VALUES ($v)";
$result=ejecutar($query,"TRUE");
return $result;
}

function update_mysql($table,$values,$where="1"){
$table=DBPREFIX.$table;

$k="";
$v="";
$f="";
$x=0;
foreach($values as $key=>$value){
if($x==0){
$k="$key";
$value=utf8_encode(str_replace(array("'","\"","\\",";","%"),array("\'","\\\"","\\\\","\;","\%"),$value));
$v=($value=="_NULO")? "NULL": "'$value'";
$f.=" $k=$v ";
}else{
$k="$key";
$value=utf8_encode(str_replace(array("'","\"","\\",";","%"),array("\'","\\\"","\\\\","\;","\%"),$value));
$v=($value=="_NULO")? "NULL": "'$value'";
$f.=" , $k=$v ";
}
$x++;
}

$query="UPDATE $table SET $f WHERE $where ;";
return array('result'=>ejecutar($query),'query'=>$query);
}

?>
