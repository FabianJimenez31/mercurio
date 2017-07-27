<?php


function load_libs($name){

include(APPDIR."libs/".$name.".php");

}


function load_module_libs($module,$name){

include(APPDIR."modules/".$module."/libs/".$name.".php");

}

function load_view($name){

include(APPDIR."views/".$name.".php");

}

function load_module_view($module,$name){

include(APPDIR."modules/".$module."/views/".$name.".php");

}

function dynamic_view($name,$array){

$template=file_get_contents(APPDIR."views/".$name.".php");

$initial=replace_for($template,$array);
$second=replace_custom($initial,$array);
$final=replace_variables($second,$array);

echo $final;
}

function dynamic_module_view($module,$name,$array){

$template=file_get_contents(APPDIR."modules/".$module."/views/".$name.".php");

$initial=replace_custom($template,$array);
$second=replace_for($initial,$array);
$final=replace_variables($second,$array);

echo $final;
}

function dynamic_view_string($string,$array){

$template=$string;
$initial=replace_for($template,$array);
$second=replace_custom($initial,$array);
$final=replace_variables($second,$array);

echo $final;
}

function replace_for($template,$array){

preg_match_all('!foreach {\[(.*)\]} as ([^\!]*)!', $template, $matches);
$mmm=count($matches[0]);
for($x=0;$x<=($mmm-1);$x++){
$index=$matches[1][$mmm-$x-1];

$variable=$matches[2][$mmm-$x-1];
preg_match("/!foreach {\[$index\]} as $variable!(.*)!end $variable!/s",$template,$match2);
$partial=$match2[1];
$rep="";
foreach($array[$index] as $variable_name){
$part=$partial;

preg_match_all("/{\[$variable:(.*?)\]}/",$template,$values);

$vor=$values[1];

foreach($vor as $replaces){

$value=$replaces;
$value_nofunctions=explode("|",$value);
$value_no=$value_nofunctions[0];

$valid=str_replace("$value_no",$variable_name[$value_nofunctions[0]],$value);

$replaced=replace_functions($valid);

$part=str_replace("{[$variable:$replaces]}",$replaced,$part);
}
$rep.=$part;
}

$template=str_replace("!foreach {[$index]} as $variable!$partial!end $variable!",$rep,$template);
}

return $template;
}


function replace_functions($string){

$base_a=explode("|",$string);
$base=$base_a[0];
$functions_a=str_replace($base."|","",$string);
$functions=explode("|",$functions_a);
$result=$base;
foreach($functions as $f){

$to=explode(":",$f);
switch ($to[0]){

case 'md5':
	$result=md5($result);
	break;
case 'append':
	$result=$result.$to[1];
	break;

case 'prepend':
	$result=$to[1].$result;
	break;

case 'escape':
	$result=htmlspecialchars(strtolower($result),ENT_QUOTES,'UTF-8');
	break;
case 'upper':
	$result=strtoupper($result);
	break;
case 'lower':
	$result=strtolower($result);
	break;
case '+':
	$result=$to[1]+$result;
	break;
case '-':
	$result=$result-$to[1];
	break;
case '*':
	$result=$to[1]*$result;
	break;
case '/':
	$result=$result/$to[1];
	break;

}

}

return $result;
}

function replace_variables($string,$array){
preg_match_all("/{\[(.*?)\]}/",$string,$values);
$vor=$values[1];
foreach($vor as $v){
$no_functions=explode("|",$v);
$no_f=$no_functions[0];
$functions=str_replace($no_f,"",$v);


$arr=explode("][",$v);
if(count($arr)>1){
$value=$array;
foreach($arr as $s){
$value=$value[$s];
}

}else{
$value=$array[$no_f];
}


$string=str_replace("{[$v]}",replace_functions($value.$functions),$string);


}
return $string;
}


function replace_custom($string,$array){
preg_match_all("/{\[\\\$\((.*?)\]}/",$string,$values);

$vor=$values[1];
foreach($vor as $v){
$no_functions=explode("|",$v);
$no_f=$no_functions[0];
$functions=str_replace($no_f,"",$v);

$val=strlen($no_f)-1;
$value=substr($no_f,0,$val);

$string=str_replace("{[\$($v]}",replace_functions($value.$functions),$string);


}
return $string;
}

function load_action($module="home",$action="dashboard"){

include(APPDIR."modules/".$module."/actions/".$action.".php");

}
?>
