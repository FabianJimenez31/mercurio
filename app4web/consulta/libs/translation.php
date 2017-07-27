<?php

function label_me($tag){

$tags=select_mysql("*","messages","tag='".$tag."'");

return ($tags['count']>0)?utf8_decode($tags['result'][0]['label']):$tag;

}
