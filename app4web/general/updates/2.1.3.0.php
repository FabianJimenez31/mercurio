<?php

global $server;
global $x;

$server[$x]['version']='2.1.3.0 - Actualizacion para Permitir el Catalogo de Items General';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';


$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campos de allow de permanent_item en items';

$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."items` LIKE 'permanent_item'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;


if($exists==FALSE){

ejecutar("ALTER TABLE  `".$tt['prefix']."items` ADD  `permanent_item` INT NOT NULL ;");

$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}
}





$result=ejecutar("SHOW TABLES LIKE 'permanent_items' ");
$server[$x]['status'].='<br/> - Revisando existencia de permanent_items';
$exists = (mysqli_num_rows($result)>0)?TRUE:FALSE;


if($exists==FALSE){

ejecutar("CREATE TABLE IF NOT EXISTS `permanent_items` (
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `item_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `size` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tax_included` int(1) NOT NULL DEFAULT '0',
  `cost_price` decimal(23,10) DEFAULT NULL,
  `unit_price` decimal(23,10) NOT NULL,
  `promo_price` decimal(23,10) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `reorder_level` decimal(23,10) DEFAULT NULL,
  `item_id` int(10) NOT NULL AUTO_INCREMENT,
  `allow_alt_description` tinyint(1) NOT NULL,
  `is_serialized` tinyint(1) NOT NULL,
  `image_id` int(10) DEFAULT NULL,
  `override_default_tax` int(1) NOT NULL DEFAULT '0',
  `is_service` int(1) NOT NULL DEFAULT '0',
  `deleted` int(1) NOT NULL DEFAULT '0',
  `color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iva` double(255,0) DEFAULT NULL,
  `categoria_ss` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postpay` int(11) NOT NULL,
  `tier_1` double NOT NULL,
  `tier_2` double NOT NULL,
  `tier_3` double NOT NULL,
  `tier_4` double NOT NULL,
  `tier_5` double NOT NULL,
  `tier_6` double NOT NULL,
  `tier_7` double NOT NULL,
  `tier_8` double NOT NULL,
  `tier_9` double NOT NULL,
  `tier_10` double NOT NULL,
  `tier_1_name` text COLLATE utf8_unicode_ci NOT NULL,
  `tier_2_name` text COLLATE utf8_unicode_ci NOT NULL,
  `tier_3_name` text COLLATE utf8_unicode_ci NOT NULL,
  `tier_4_name` text COLLATE utf8_unicode_ci NOT NULL,
  `tier_5_name` text COLLATE utf8_unicode_ci NOT NULL,
  `tier_6_name` text COLLATE utf8_unicode_ci NOT NULL,
  `tier_7_name` text COLLATE utf8_unicode_ci NOT NULL,
  `tier_8_name` text COLLATE utf8_unicode_ci NOT NULL,
  `tier_9_name` text COLLATE utf8_unicode_ci NOT NULL,
  `tier_10_name` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`item_id`),
  UNIQUE KEY `item_number` (`item_number`),
  UNIQUE KEY `product_id` (`product_id`),
  KEY `phppos_items_ibfk_1` (`supplier_id`),
  KEY `name` (`name`),
  KEY `category` (`category`),
  KEY `deleted` (`deleted`),
  KEY `phppos_items_ibfk_2` (`image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;");

$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}








?>
