-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 14-07-2015 a las 18:26:25
-- Versión del servidor: 10.0.20-MariaDB-1~trusty-log
-- Versión de PHP: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `sgpv-hayuelos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_app_config`
--

CREATE TABLE IF NOT EXISTS `phppos_app_config` (
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_app_files`
--

CREATE TABLE IF NOT EXISTS `phppos_app_files` (
  `file_id` int(10) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_data` longblob NOT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_closures`
--

CREATE TABLE IF NOT EXISTS `phppos_closures` (
  `closures_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `session_box` int(11) NOT NULL,
  `start` float NOT NULL,
  `system_start` float NOT NULL,
  `end` float NOT NULL,
  `system_end` float NOT NULL,
  `approval` int(11) NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  `date_end` datetime NOT NULL,
  PRIMARY KEY (`closures_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_cuentascontables`
--

CREATE TABLE IF NOT EXISTS `phppos_cuentascontables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) NOT NULL,
  `debito` varchar(100) NOT NULL,
  `credito` varchar(100) NOT NULL,
  `i_credito` varchar(100) NOT NULL,
  `i_debito` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_customers`
--

CREATE TABLE IF NOT EXISTS `phppos_customers` (
  `person_id` int(10) NOT NULL,
  `account_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `balance` decimal(23,10) NOT NULL DEFAULT '0.0000000000',
  `taxable` int(1) NOT NULL DEFAULT '1',
  `cc_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cc_preview` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_issuer` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `tier_id` int(10) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `account_number` (`account_number`),
  KEY `person_id` (`person_id`),
  KEY `deleted` (`deleted`),
  KEY `cc_token` (`cc_token`),
  KEY `phppos_customers_ibfk_2` (`tier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_employees`
--

CREATE TABLE IF NOT EXISTS `phppos_employees` (
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `person_id` int(10) NOT NULL,
  `language` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `username` (`username`),
  KEY `person_id` (`person_id`),
  KEY `deleted` (`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_employees_locations`
--

CREATE TABLE IF NOT EXISTS `phppos_employees_locations` (
  `employee_id` int(10) NOT NULL,
  `location_id` int(10) NOT NULL,
  PRIMARY KEY (`employee_id`,`location_id`),
  KEY `phppos_employees_locations_ibfk_2` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_facturacion_proveedor`
--

CREATE TABLE IF NOT EXISTS `phppos_facturacion_proveedor` (
  `fact_id` int(11) NOT NULL AUTO_INCREMENT,
  `proveedor` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `factura_id` int(11) DEFAULT NULL,
  `factura` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `ses` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `requisition_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `codigo_sku` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `valor_unitario` int(255) DEFAULT NULL,
  `cantidad` int(255) DEFAULT NULL,
  `valor_total` int(255) DEFAULT NULL,
  PRIMARY KEY (`fact_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_facturacion_proveedor_sn`
--

CREATE TABLE IF NOT EXISTS `phppos_facturacion_proveedor_sn` (
  `fact_sn_id` int(11) NOT NULL AUTO_INCREMENT,
  `fact_id` int(11) DEFAULT NULL,
  `serial_number` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`fact_sn_id`),
  KEY `fact_id` (`fact_id`) USING BTREE,
  KEY `serial_number` (`serial_number`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_facturacion_registro`
--

CREATE TABLE IF NOT EXISTS `phppos_facturacion_registro` (
  `factura_id` int(50) NOT NULL AUTO_INCREMENT,
  `factura_numero` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `proveedor` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `ses` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `total_factura` int(15) DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `fecha_radicacion` date DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `obs` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`factura_id`,`factura_numero`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_giftcards`
--

CREATE TABLE IF NOT EXISTS `phppos_giftcards` (
  `giftcard_id` int(11) NOT NULL AUTO_INCREMENT,
  `giftcard_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` decimal(23,10) NOT NULL,
  `customer_id` int(10) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`giftcard_id`),
  UNIQUE KEY `giftcard_number` (`giftcard_number`),
  KEY `deleted` (`deleted`),
  KEY `phppos_giftcards_ibfk_1` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_inventory`
--

CREATE TABLE IF NOT EXISTS `phppos_inventory` (
  `trans_id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_items` int(11) NOT NULL DEFAULT '0',
  `trans_user` int(11) NOT NULL DEFAULT '0',
  `trans_date` datetime DEFAULT NULL,
  `trans_comment` text COLLATE utf8_unicode_ci NOT NULL,
  `trans_inventory` decimal(23,10) NOT NULL DEFAULT '0.0000000000',
  `location_id` int(11) NOT NULL,
  `serialNumber` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `cost_price` decimal(23,10) DEFAULT NULL,
  `state` varchar(45) COLLATE utf8_unicode_ci DEFAULT 'Disponible',
  `traslate_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `traslate_fecha` datetime DEFAULT NULL,
  `requisitionId` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `requisition_fecha` datetime DEFAULT NULL,
  `sale_Id` int(11) DEFAULT NULL,
  `sale_fecha` datetime DEFAULT NULL,
  `sale_price` decimal(10,0) DEFAULT NULL,
  `tax_percent` int(2) DEFAULT NULL,
  `tax_price` decimal(10,0) DEFAULT NULL,
  `discount` decimal(10,0) DEFAULT NULL,
  `discount_percent` int(2) DEFAULT NULL,
  `sale_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `FAC` int(11) DEFAULT NULL,
  `FAC_DATE` date DEFAULT NULL,
  `NC` int(11) DEFAULT NULL,
  `NC_DATE` date DEFAULT NULL,
  `SSCLUB` int(255) DEFAULT NULL,
  `SSCLUB_DATE` date DEFAULT NULL,
  `PROMO` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PROMO_DATE` date DEFAULT NULL,
  `EXHIBICION` int(255) DEFAULT NULL,
  `EXHIBICION_DATE` date DEFAULT NULL,
  `BAJA_PRECIO` int(255) DEFAULT NULL,
  `BAJA_PRECIO_DATE` date DEFAULT NULL,
  PRIMARY KEY (`trans_id`,`serialNumber`),
  KEY `phppos_inventory_ibfk_1` (`trans_items`),
  KEY `phppos_inventory_ibfk_2` (`trans_user`),
  KEY `location_id` (`location_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_inventory_history`
--

CREATE TABLE IF NOT EXISTS `phppos_inventory_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_id` int(11) DEFAULT NULL,
  `date_trans` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` varchar(45) DEFAULT NULL,
  `usuario_create` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_items`
--

CREATE TABLE IF NOT EXISTS `phppos_items` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_items_dates`
--

CREATE TABLE IF NOT EXISTS `phppos_items_dates` (
  `fecha_lista` date DEFAULT NULL,
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
  PRIMARY KEY (`item_id`),
  UNIQUE KEY `item_number` (`item_number`),
  UNIQUE KEY `product_id` (`product_id`),
  KEY `phppos_items_ibfk_1` (`supplier_id`),
  KEY `name` (`name`),
  KEY `category` (`category`),
  KEY `deleted` (`deleted`),
  KEY `phppos_items_ibfk_2` (`image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_items_history`
--

CREATE TABLE IF NOT EXISTS `phppos_items_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `date_trans` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `description` varchar(45) DEFAULT NULL,
  `user_create` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_items_taxes`
--

CREATE TABLE IF NOT EXISTS `phppos_items_taxes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `item_id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `percent` decimal(15,3) NOT NULL,
  `cumulative` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_tax` (`item_id`,`name`,`percent`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_items_tier_prices`
--

CREATE TABLE IF NOT EXISTS `phppos_items_tier_prices` (
  `tier_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `unit_price` decimal(23,10) DEFAULT '0.0000000000',
  `percent_off` int(11) DEFAULT NULL,
  PRIMARY KEY (`tier_id`,`item_id`),
  KEY `phppos_items_tier_prices_ibfk_2` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_item_kits`
--

CREATE TABLE IF NOT EXISTS `phppos_item_kits` (
  `item_kit_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_kit_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_included` int(1) NOT NULL DEFAULT '0',
  `unit_price` decimal(23,10) DEFAULT NULL,
  `cost_price` decimal(23,10) DEFAULT NULL,
  `override_default_tax` int(1) NOT NULL DEFAULT '0',
  `deleted` int(1) NOT NULL DEFAULT '0',
  `iva` int(11) NOT NULL,
  `postpay` int(11) NOT NULL,
  PRIMARY KEY (`item_kit_id`),
  UNIQUE KEY `item_kit_number` (`item_kit_number`),
  UNIQUE KEY `product_id` (`product_id`),
  KEY `name` (`name`),
  KEY `deleted` (`deleted`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_item_kits_taxes`
--

CREATE TABLE IF NOT EXISTS `phppos_item_kits_taxes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `item_kit_id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `percent` decimal(15,3) NOT NULL,
  `cumulative` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_tax` (`item_kit_id`,`name`,`percent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_item_kits_tier_prices`
--

CREATE TABLE IF NOT EXISTS `phppos_item_kits_tier_prices` (
  `tier_id` int(10) NOT NULL,
  `item_kit_id` int(10) NOT NULL,
  `unit_price` decimal(23,10) DEFAULT '0.0000000000',
  `percent_off` int(11) DEFAULT NULL,
  PRIMARY KEY (`tier_id`,`item_kit_id`),
  KEY `phppos_item_kits_tier_prices_ibfk_2` (`item_kit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_item_kit_items`
--

CREATE TABLE IF NOT EXISTS `phppos_item_kit_items` (
  `item_kit_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` decimal(23,10) NOT NULL,
  PRIMARY KEY (`item_kit_id`,`item_id`,`quantity`),
  KEY `phppos_item_kit_items_ibfk_2` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_locations`
--

CREATE TABLE IF NOT EXISTS `phppos_locations` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci,
  `address` text COLLATE utf8_unicode_ci,
  `phone` text COLLATE utf8_unicode_ci,
  `fax` text COLLATE utf8_unicode_ci,
  `email` text COLLATE utf8_unicode_ci,
  `receive_stock_alert` text COLLATE utf8_unicode_ci,
  `stock_alert_email` text COLLATE utf8_unicode_ci,
  `timezone` text COLLATE utf8_unicode_ci,
  `mailchimp_api_key` text COLLATE utf8_unicode_ci,
  `enable_credit_card_processing` text COLLATE utf8_unicode_ci,
  `merchant_id` text COLLATE utf8_unicode_ci,
  `merchant_password` text COLLATE utf8_unicode_ci,
  `default_tax_1_rate` text COLLATE utf8_unicode_ci,
  `default_tax_1_name` text COLLATE utf8_unicode_ci,
  `default_tax_2_rate` text COLLATE utf8_unicode_ci,
  `default_tax_2_name` text COLLATE utf8_unicode_ci,
  `default_tax_2_cumulative` text COLLATE utf8_unicode_ci,
  `default_tax_3_rate` text COLLATE utf8_unicode_ci,
  `default_tax_3_name` text COLLATE utf8_unicode_ci,
  `default_tax_4_rate` text COLLATE utf8_unicode_ci,
  `default_tax_4_name` text COLLATE utf8_unicode_ci,
  `default_tax_5_rate` text COLLATE utf8_unicode_ci,
  `default_tax_5_name` text COLLATE utf8_unicode_ci,
  `deleted` int(1) DEFAULT '0',
  PRIMARY KEY (`location_id`),
  KEY `deleted` (`deleted`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_location_items`
--

CREATE TABLE IF NOT EXISTS `phppos_location_items` (
  `location_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cost_price` decimal(23,10) DEFAULT NULL,
  `unit_price` decimal(23,10) DEFAULT NULL,
  `promo_price` decimal(23,10) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `quantity` decimal(23,10) DEFAULT '0.0000000000',
  `reorder_level` decimal(23,10) DEFAULT NULL,
  `override_default_tax` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`location_id`,`item_id`),
  KEY `phppos_location_items_ibfk_2` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_location_items_taxes`
--

CREATE TABLE IF NOT EXISTS `phppos_location_items_taxes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `item_id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `percent` decimal(16,3) NOT NULL,
  `cumulative` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_tax` (`location_id`,`item_id`,`name`,`percent`),
  KEY `phppos_location_items_taxes_ibfk_2` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_location_items_tier_prices`
--

CREATE TABLE IF NOT EXISTS `phppos_location_items_tier_prices` (
  `tier_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `location_id` int(10) NOT NULL,
  `unit_price` decimal(23,10) DEFAULT '0.0000000000',
  `percent_off` int(11) DEFAULT NULL,
  PRIMARY KEY (`tier_id`,`item_id`,`location_id`),
  KEY `phppos_location_items_tier_prices_ibfk_2` (`location_id`),
  KEY `phppos_location_items_tier_prices_ibfk_3` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_location_item_kits`
--

CREATE TABLE IF NOT EXISTS `phppos_location_item_kits` (
  `location_id` int(11) NOT NULL,
  `item_kit_id` int(11) NOT NULL,
  `unit_price` decimal(23,10) DEFAULT NULL,
  `cost_price` decimal(23,10) DEFAULT NULL,
  `override_default_tax` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`location_id`,`item_kit_id`),
  KEY `phppos_location_item_kits_ibfk_2` (`item_kit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_location_item_kits_taxes`
--

CREATE TABLE IF NOT EXISTS `phppos_location_item_kits_taxes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `item_kit_id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `percent` decimal(16,3) NOT NULL,
  `cumulative` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_tax` (`location_id`,`item_kit_id`,`name`,`percent`),
  KEY `phppos_location_item_kits_taxes_ibfk_2` (`item_kit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_location_item_kits_tier_prices`
--

CREATE TABLE IF NOT EXISTS `phppos_location_item_kits_tier_prices` (
  `tier_id` int(10) NOT NULL,
  `item_kit_id` int(10) NOT NULL,
  `location_id` int(10) NOT NULL,
  `unit_price` decimal(23,10) DEFAULT '0.0000000000',
  `percent_off` int(11) DEFAULT NULL,
  PRIMARY KEY (`tier_id`,`item_kit_id`,`location_id`),
  KEY `phppos_location_item_kits_tier_prices_ibfk_2` (`location_id`),
  KEY `phppos_location_item_kits_tier_prices_ibfk_3` (`item_kit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_messages`
--

CREATE TABLE IF NOT EXISTS `phppos_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(100) NOT NULL,
  `label` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_modules`
--

CREATE TABLE IF NOT EXISTS `phppos_modules` (
  `name_lang_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `desc_lang_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(10) NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `module_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`module_id`),
  UNIQUE KEY `desc_lang_key` (`desc_lang_key`),
  UNIQUE KEY `name_lang_key` (`name_lang_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_modules_actions`
--

CREATE TABLE IF NOT EXISTS `phppos_modules_actions` (
  `action_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `module_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `action_name_key` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`action_id`,`module_id`),
  KEY `phppos_modules_actions_ibfk_1` (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_people`
--

CREATE TABLE IF NOT EXISTS `phppos_people` (
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `comments` text COLLATE utf8_unicode_ci NOT NULL,
  `image_id` int(10) DEFAULT NULL,
  `person_id` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`person_id`),
  KEY `first_name` (`first_name`),
  KEY `last_name` (`last_name`),
  KEY `email` (`email`),
  KEY `phppos_people_ibfk_1` (`image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_permissions`
--

CREATE TABLE IF NOT EXISTS `phppos_permissions` (
  `module_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `person_id` int(10) NOT NULL,
  PRIMARY KEY (`module_id`,`person_id`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_permissions_actions`
--

CREATE TABLE IF NOT EXISTS `phppos_permissions_actions` (
  `module_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `person_id` int(11) NOT NULL,
  `action_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`module_id`,`person_id`,`action_id`),
  KEY `phppos_permissions_actions_ibfk_2` (`person_id`),
  KEY `phppos_permissions_actions_ibfk_3` (`action_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_presales`
--

CREATE TABLE IF NOT EXISTS `phppos_presales` (
  `presale_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `show_comment_on_receipt` int(1) NOT NULL DEFAULT '0',
  `presale_id` int(10) NOT NULL AUTO_INCREMENT,
  `payment_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cc_ref_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `deleted_by` int(10) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `suspended` int(1) NOT NULL DEFAULT '0',
  `store_account_payment` int(1) NOT NULL DEFAULT '0',
  `location_id` int(11) NOT NULL,
  `tier_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`presale_id`),
  KEY `customer_id` (`customer_id`),
  KEY `employee_id` (`employee_id`),
  KEY `deleted` (`deleted`),
  KEY `location_id` (`location_id`),
  KEY `phppos_presales_ibfk_4` (`deleted_by`),
  KEY `presales_search` (`location_id`,`store_account_payment`,`presale_time`,`presale_id`),
  KEY `phppos_presales_ibfk_5` (`tier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_presales_items`
--

CREATE TABLE IF NOT EXISTS `phppos_presales_items` (
  `presale_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `serialnumber` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `quantity_purchased` decimal(23,10) NOT NULL DEFAULT '0.0000000000',
  `item_cost_price` decimal(23,10) NOT NULL,
  `item_unit_price` decimal(23,10) NOT NULL,
  `discount_percent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`presale_id`,`item_id`,`line`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_presales_items_taxes`
--

CREATE TABLE IF NOT EXISTS `phppos_presales_items_taxes` (
  `presale_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `percent` decimal(15,3) NOT NULL,
  `cumulative` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`presale_id`,`item_id`,`line`,`name`,`percent`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_presales_item_kits`
--

CREATE TABLE IF NOT EXISTS `phppos_presales_item_kits` (
  `presale_id` int(10) NOT NULL DEFAULT '0',
  `item_kit_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `quantity_purchased` decimal(23,10) NOT NULL DEFAULT '0.0000000000',
  `item_kit_cost_price` decimal(23,10) NOT NULL,
  `item_kit_unit_price` decimal(23,10) NOT NULL,
  `discount_percent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`presale_id`,`item_kit_id`,`line`),
  KEY `item_kit_id` (`item_kit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_presales_item_kits_taxes`
--

CREATE TABLE IF NOT EXISTS `phppos_presales_item_kits_taxes` (
  `presale_id` int(10) NOT NULL,
  `item_kit_id` int(10) NOT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `percent` decimal(15,3) NOT NULL,
  `cumulative` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`presale_id`,`item_kit_id`,`line`,`name`,`percent`),
  KEY `item_id` (`item_kit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_presales_payments`
--

CREATE TABLE IF NOT EXISTS `phppos_presales_payments` (
  `payment_id` int(10) NOT NULL AUTO_INCREMENT,
  `presale_id` int(10) NOT NULL,
  `payment_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_amount` decimal(23,10) NOT NULL,
  `truncated_card` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `card_issuer` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `payment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`payment_id`),
  KEY `presale_id` (`presale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_price_tiers`
--

CREATE TABLE IF NOT EXISTS `phppos_price_tiers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_receivings`
--

CREATE TABLE IF NOT EXISTS `phppos_receivings` (
  `receiving_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `supplier_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `receiving_id` int(10) NOT NULL AUTO_INCREMENT,
  `payment_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `deleted_by` int(10) DEFAULT NULL,
  `suspended` int(1) NOT NULL DEFAULT '0',
  `location_id` int(11) NOT NULL,
  PRIMARY KEY (`receiving_id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `employee_id` (`employee_id`),
  KEY `deleted` (`deleted`),
  KEY `location_id` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_receivings_items`
--

CREATE TABLE IF NOT EXISTS `phppos_receivings_items` (
  `receiving_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `serialnumber` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `line` int(3) NOT NULL,
  `quantity_purchased` decimal(23,10) NOT NULL DEFAULT '0.0000000000',
  `item_cost_price` decimal(23,10) NOT NULL,
  `item_unit_price` decimal(23,10) NOT NULL,
  `discount_percent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`receiving_id`,`item_id`,`line`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_register_log`
--

CREATE TABLE IF NOT EXISTS `phppos_register_log` (
  `register_log_id` int(10) NOT NULL AUTO_INCREMENT,
  `employee_id` int(10) NOT NULL,
  `shift_start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `shift_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `open_amount` decimal(23,10) NOT NULL,
  `close_amount` decimal(23,10) NOT NULL,
  `cash_sales_amount` decimal(23,10) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `cierre_turno` int(11) DEFAULT NULL,
  PRIMARY KEY (`register_log_id`),
  KEY `phppos_register_log_ibfk_1` (`employee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_requisitions`
--

CREATE TABLE IF NOT EXISTS `phppos_requisitions` (
  `requisitionId` int(11) NOT NULL AUTO_INCREMENT,
  `requisitionDate` datetime DEFAULT NULL,
  `requisitionNumber` varchar(45) DEFAULT NULL,
  `userCreator` int(10) DEFAULT NULL,
  `state` varchar(45) DEFAULT 'Solicitud Enviada',
  `eta` date DEFAULT NULL,
  `comment` text,
  `acceptsDate` datetime DEFAULT NULL,
  `requisition_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`requisitionId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_requisitions_items`
--

CREATE TABLE IF NOT EXISTS `phppos_requisitions_items` (
  `requisitionItemId` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(10) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `cost_price` decimal(23,10) DEFAULT NULL,
  `requisitionId` int(11) DEFAULT NULL,
  `quantity_accepts` int(11) DEFAULT NULL,
  PRIMARY KEY (`requisitionItemId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_sales`
--

CREATE TABLE IF NOT EXISTS `phppos_sales` (
  `sale_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `show_comment_on_receipt` int(1) NOT NULL DEFAULT '0',
  `sale_id` int(10) NOT NULL AUTO_INCREMENT,
  `payment_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cc_ref_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `deleted_by` int(10) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `suspended` int(1) NOT NULL DEFAULT '0',
  `store_account_payment` int(1) NOT NULL DEFAULT '0',
  `location_id` int(11) NOT NULL,
  `tier_id` int(10) DEFAULT NULL,
  `anulacion` int(1) NOT NULL DEFAULT '0',
  `id_manual` int(255) DEFAULT NULL,
  `resolucion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `salesman` int(11) NOT NULL,
  PRIMARY KEY (`sale_id`),
  KEY `customer_id` (`customer_id`),
  KEY `employee_id` (`employee_id`),
  KEY `deleted` (`deleted`),
  KEY `location_id` (`location_id`),
  KEY `phppos_sales_ibfk_4` (`deleted_by`),
  KEY `sales_search` (`location_id`,`store_account_payment`,`sale_time`,`sale_id`),
  KEY `phppos_sales_ibfk_5` (`tier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_sales_items`
--

CREATE TABLE IF NOT EXISTS `phppos_sales_items` (
  `sale_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `serialnumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `quantity_purchased` decimal(23,10) NOT NULL DEFAULT '0.0000000000',
  `item_cost_price` decimal(23,10) NOT NULL,
  `item_unit_price` decimal(23,10) NOT NULL,
  `discount_percent` int(11) NOT NULL DEFAULT '0',
  `anulado` int(3) DEFAULT NULL,
  `contrato` longblob NOT NULL,
  `contrato_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `contrato_extension` varchar(130) COLLATE utf8_unicode_ci NOT NULL,
  `num_tel` varchar(130) COLLATE utf8_unicode_ci NOT NULL,
  `post_first` int(11) NOT NULL,
  PRIMARY KEY (`sale_id`,`item_id`,`line`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_sales_items_taxes`
--

CREATE TABLE IF NOT EXISTS `phppos_sales_items_taxes` (
  `sale_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `percent` decimal(15,3) NOT NULL,
  `cumulative` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sale_id`,`item_id`,`line`,`name`,`percent`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_sales_item_kits`
--

CREATE TABLE IF NOT EXISTS `phppos_sales_item_kits` (
  `sale_id` int(10) NOT NULL DEFAULT '0',
  `item_kit_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `quantity_purchased` decimal(23,10) NOT NULL DEFAULT '0.0000000000',
  `item_kit_cost_price` decimal(23,10) NOT NULL,
  `item_kit_unit_price` decimal(23,10) NOT NULL,
  `discount_percent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sale_id`,`item_kit_id`,`line`),
  KEY `item_kit_id` (`item_kit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_sales_item_kits_taxes`
--

CREATE TABLE IF NOT EXISTS `phppos_sales_item_kits_taxes` (
  `sale_id` int(10) NOT NULL,
  `item_kit_id` int(10) NOT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `percent` decimal(15,3) NOT NULL,
  `cumulative` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sale_id`,`item_kit_id`,`line`,`name`,`percent`),
  KEY `item_id` (`item_kit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_sales_payments`
--

CREATE TABLE IF NOT EXISTS `phppos_sales_payments` (
  `payment_id` int(10) NOT NULL AUTO_INCREMENT,
  `sale_id` int(10) NOT NULL,
  `payment_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_amount` decimal(23,10) NOT NULL,
  `truncated_card` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `card_issuer` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `payment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `session_box` int(10) DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `sale_id` (`sale_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_sessions`
--

CREATE TABLE IF NOT EXISTS `phppos_sessions` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_is` int(11) NOT NULL,
  `session_box` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date_start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_end` datetime NOT NULL,
  `consignacion` text NOT NULL,
  `consignacion_file` int(11) NOT NULL,
  `consignacion_content` longblob NOT NULL,
  `consignacion_type` varchar(32) NOT NULL,
  `datafono` text NOT NULL,
  `datafono_file` int(11) NOT NULL,
  `datafono_content` longblob NOT NULL,
  `datafono_type` varchar(32) NOT NULL,
  `consignado` double NOT NULL,
  `consignado_datafonos` double NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_sol_nc`
--

CREATE TABLE IF NOT EXISTS `phppos_sol_nc` (
  `sol_nc_id` int(11) NOT NULL AUTO_INCREMENT,
  `nc_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `proveedor` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tipo_nc` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `serial_equipo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sku` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ean` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fac_proveedor` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `valor_base` int(20) DEFAULT NULL,
  `porcentaje_aplicar` int(20) DEFAULT NULL,
  `valor_aplicar` int(20) DEFAULT NULL,
  `estado` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_sol` date DEFAULT NULL,
  `fecha_recibo` date DEFAULT NULL,
  PRIMARY KEY (`sol_nc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_store_accounts`
--

CREATE TABLE IF NOT EXISTS `phppos_store_accounts` (
  `sno` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `transaction_amount` decimal(23,10) NOT NULL DEFAULT '0.0000000000',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `balance` decimal(23,10) NOT NULL DEFAULT '0.0000000000',
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`sno`),
  KEY `phppos_store_accounts_ibfk_1` (`sale_id`),
  KEY `phppos_store_accounts_ibfk_2` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_suppliers`
--

CREATE TABLE IF NOT EXISTS `phppos_suppliers` (
  `person_id` int(10) NOT NULL,
  `company_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `account_number` (`account_number`),
  KEY `person_id` (`person_id`),
  KEY `deleted` (`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_temporal_contratos`
--

CREATE TABLE IF NOT EXISTS `phppos_temporal_contratos` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(100) NOT NULL,
  `name` varchar(120) NOT NULL,
  `extension` varchar(10) NOT NULL,
  `meta` varchar(50) NOT NULL,
  `file` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_tomafisica`
--

CREATE TABLE IF NOT EXISTS `phppos_tomafisica` (
  `tomafisica_id` int(11) NOT NULL AUTO_INCREMENT,
  `ses` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `serial_number` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `obs` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`tomafisica_id`),
  KEY `fact_id` (`fecha`) USING BTREE,
  KEY `serial_number` (`serial_number`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_traslado`
--

CREATE TABLE IF NOT EXISTS `phppos_traslado` (
  `traslado_id` int(11) NOT NULL AUTO_INCREMENT,
  `traslado_Number` varchar(45) DEFAULT NULL,
  `userCreator` int(10) DEFAULT NULL,
  `state` varchar(45) DEFAULT 'Solicitud Enviada',
  `eta` date DEFAULT NULL,
  `traslado_solicitud_date` datetime DEFAULT NULL,
  `traslado_envio_date` datetime DEFAULT NULL,
  `traslado_llegada_date` datetime DEFAULT NULL,
  `acceptsDate` datetime DEFAULT NULL,
  `comment` text,
  `traslado_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`traslado_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_traslado_items`
--

CREATE TABLE IF NOT EXISTS `phppos_traslado_items` (
  `traslado_Item_Id` int(11) NOT NULL AUTO_INCREMENT,
  `traslado_Id` int(11) DEFAULT NULL,
  `item_id` int(10) DEFAULT NULL,
  `serial_number` int(11) DEFAULT NULL,
  `cost_price` decimal(23,0) DEFAULT NULL,
  `fact_id` int(11) DEFAULT NULL,
  `factura` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`traslado_Item_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phppos_working_hour`
--

CREATE TABLE IF NOT EXISTS `phppos_working_hour` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state` varchar(45) DEFAULT 'Sin Conciliar',
  `efectivo_ini` varchar(45) DEFAULT NULL,
  `debito_ini` varchar(45) DEFAULT NULL,
  `master_ini` varchar(45) DEFAULT NULL,
  `visa_ini` varchar(45) DEFAULT NULL,
  `diners_ini` varchar(45) DEFAULT NULL,
  `american_ini` varchar(45) DEFAULT NULL,
  `efectivo_fin` varchar(45) DEFAULT NULL,
  `debito_fin` varchar(45) DEFAULT NULL,
  `master_fin` varchar(45) DEFAULT NULL,
  `visa_fin` varchar(45) DEFAULT NULL,
  `diners_fin` varchar(45) DEFAULT NULL,
  `dateIni` datetime DEFAULT NULL,
  `dateFin` datetime DEFAULT NULL,
  `obervaciones` text,
  `base_ini` varchar(45) DEFAULT NULL,
  `base_fin` varchar(45) DEFAULT NULL,
  `cajero` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- AQUI LLENAMOS CON VALORES POR DEFECTO
--

INSERT INTO `phppos_app_config` (`key`, `value`) VALUES
('additional_payment_types', 'MasterCard Credito:voucher;Visa Credito:voucher;American Express Credito:voucher;Dinners Credito:voucher;MasterCard Debito:voucher;Visa Debito:voucher;CMR:voucher;Nota de Credito:voucher'),
('always_show_item_grid', '1'),
('auto_focus_on_item_after_sale_and_receiving', '1'),
('automatically_email_receipt', '0'),
('automatically_show_comments_on_receipt', '0'),
('averaging_method', 'historical_average'),
('barcode_price_include_tax', '0'),
('calculate_average_cost_price_from_receivings', '1'),
('change_sale_date_when_completing_suspended_sale', '0'),
('change_sale_date_when_suspending', '0'),
('company', 'Nombre de la Tienda y NIT'),
('company_logo', '6'),
('currency_symbol', '$'),
('customers_store_accounts', '0'),
('date_format', 'Mensaje que se mueve aqui. Cambiar en configuracion.'),
('default_payment_type', 'Efectivo'),
('default_tax_1_name', 'IVA'),
('default_tax_1_rate', '16'),
('default_tax_2_cumulative', '0'),
('default_tax_2_name', ''),
('default_tax_2_rate', ''),
('default_tax_3_name', ''),
('default_tax_3_rate', ''),
('default_tax_4_name', ''),
('default_tax_4_rate', ''),
('default_tax_5_name', ''),
('default_tax_5_rate', ''),
('default_tax_rate', '8'),
('disable_confirmation_sale', '0'),
('disable_giftcard_detection', '0'),
('disable_subtraction_of_giftcard_amount_from_sales', '0'),
('finResolucionActual', '1000000'),
('finResolucionSiguiente', ''),
('hide_customer_recent_sales', '236610'),
('hide_dashboard_statistics', '13551902'),
('hide_layaways_sales_in_reports', '14354101'),
('hide_signature', '6135951001'),
('hide_store_account_payments_in_reports', '41359502'),
('id_to_show_on_sale_interface', 'number'),
('inicioResolucionActual', '10001'),
('inicioResolucionSiguiente', ''),
('language', 'spanish'),
('number_of_items_per_page', '500'),
('prices_include_tax', '0'),
('print_after_sale', '1'),
('resolucionActual', '320001171931'),
('resolucionSiguiente', ''),
('return_policy', 'Mediante mi firma en este documento acepto la compra y certifico que he recibido las instrucciones pertinentes en cuanto a las características, usos, garantías y cuidados de los productos, a la vez que he recibido los artículos en este documento a satisfacción. Igualmente me han informado que todos los productos contenidos en este documento están amparados por las garantías de sus fabricantes y que de ninguna manera estas cubren los daños ocasionados por una utilización indebida o abuso de los mismos. En caso que requiera cambiar un producto me comprometo a hacer devolución del articulo y de su empaque en perfectas condiciones. Si el producto es usado o el empaque alterado (roto, manipulado, en malas condiciones), soy consiente de que la tienda no realizará cambio. He sido informado del procedimiento en caso de eventuales reclamaciones por garantía y acepto las condiciones.'),
('round_cash_on_sales', '1'),
('sale_prefix', 'PC'),
('show_receipt_after_suspending_sale', '24080101'),
('spreadsheet_format', 'SMH'),
('time_format', '12040101'),
('track_cash', '11050625'),
('version', 'CAJA'),
('website', '-');

--
-- Volcado de datos para la tabla `phppos_employees`
--

INSERT INTO `phppos_employees` (`username`, `password`, `person_id`, `language`, `deleted`) VALUES
('admin', 'bc19f6f8b733e475e3b68f4684b895cd', 1, 'spanish', 0);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `phppos_employees`
--


INSERT INTO `phppos_locations` (`location_id`, `name`, `address`, `phone`, `fax`, `email`, `receive_stock_alert`, `stock_alert_email`, `timezone`, `mailchimp_api_key`, `enable_credit_card_processing`, `merchant_id`, `merchant_password`, `default_tax_1_rate`, `default_tax_1_name`, `default_tax_2_rate`, `default_tax_2_name`, `default_tax_2_cumulative`, `default_tax_3_rate`, `default_tax_3_name`, `default_tax_4_rate`, `default_tax_4_name`, `default_tax_5_rate`, `default_tax_5_name`, `deleted`) VALUES
(1, 'Tienda Inicial', 'Direccion ', '000000000000', '', '', '1', 'email@example.com', 'America/Bogota', '0', '0', '0', '0', '16', 'IVA', NULL, NULL, '0', NULL, '', NULL, '', NULL, '', 0);

INSERT INTO `phppos_messages` (`id`, `tag`, `label`) VALUES
(5, 'providers', 'Proveedores'),
(6, 'sales', 'Ventas'),
(7, 'requisitions', 'Solicitud de Pedido'),
(8, 'suppliers', 'Proveedores'),
(9, 'reports', 'Reportes'),
(10, 'presales', 'Preventa'),
(11, 'locations', 'Ubicaciones'),
(12, 'item_kits', 'Kits'),
(13, 'giftcards', 'Tarjetas de Regalo'),
(14, 'entries', 'Ingreso de Pedido'),
(15, 'employees', 'Vendedores'),
(16, 'dialogos', 'Mensajes'),
(17, 'customers', 'Clientes'),
(18, 'contratos', 'Contratos'),
(19, 'contable', 'Contable'),
(20, 'config', 'Configuracion'),
(21, 'accepts', 'Recepcion de Pedido'),
(22, 'logout', 'Salir'),
(23, 'welcome', 'Bienvenid@'),
(24, 'reg_deleted', 'Registros Eliminados'),
(25, 'item', 'Articulo'),
(26, 'sku', 'SKU'),
(27, 'q_requested', 'Cantidad Solicitada'),
(28, 'q_received', 'Cantidad Recibida'),
(29, 'end', 'Terminar'),
(30, 'sale', 'Venta'),
(31, 'receive', 'Recibir'),
(32, 'edit', 'Editar'),
(33, 'saved_info', 'Informacion Guardada'),
(34, 'red_fields', 'Los Campos en Rojo'),
(35, 'are', 'son'),
(36, 'required', 'Requeridos'),
(37, 'accept_id', 'Pedido ID'),
(38, 'accept_number', 'Numero de Pedido'),
(39, 'date', 'Fecha'),
(40, 'created', 'de Creacion'),
(41, 'eta', 'Fecha Estimada de Llegada'),
(42, 'sure_delete_1', 'Se eliminaran ( '),
(43, 'sure_delete_2', ' ) elementos seleccionados. Esta Accion no podra deshacerse'),
(44, 'system', 'Sistema'),
(45, 'of', 'de'),
(46, 'successfully', 'Exitosamente'),
(47, 'accept', 'Aceptar'),
(48, 'archivo_contable', 'Archivo Contable'),
(49, 'new_account', 'Nueva Cuenta'),
(50, 'delete', 'Eliminar'),
(51, 'category', 'Categoria'),
(52, 'internal_id', 'ID Interno'),
(53, 'account_for', 'Cuenta de '),
(54, 'credit', '( Credito )'),
(55, 'debit', ' ( Debito )'),
(56, 'inventory', 'Inventario'),
(57, 'cash_line', 'Caja'),
(58, 'used_by', 'Usada por'),
(59, 'start_day', 'Desea iniciar el dia con estos montos'),
(60, 'closure_of', 'Cierre de Caja'),
(61, 'end_day', 'Desea Terminar el dia con estos montos'),
(62, 'success', 'Exito!!'),
(63, 'sure_delete_undone', 'Se eliminara este registro. Esta accion no podra deshacerse'),
(64, 'retake', 'Retomar'),
(65, 'close', 'Cerrar'),
(66, 'of_account', 'de la Cuenta'),
(67, 'information', 'Informacion'),
(68, 'save_changes', 'Guardar Cambios'),
(69, 'with_id', 'con ID'),
(70, 'error_saving', 'Hubo un error guardando su informacion, verifique sus datos e intente de nuevo.'),
(71, 'create', 'Crear'),
(72, 'date_rank', 'Rango de Fechas'),
(73, 'start_date', 'Fecha de Inicio'),
(74, 'end_date', 'Fecha Final'),
(75, 'for', 'Para'),
(76, 'export', 'Exportar'),
(77, 'csv_file', 'Archivo CSV'),
(78, 'generate', 'Generar'),
(79, 'configurate', 'Configurar'),
(80, 'select', 'Seleccione'),
(81, 'an_option', 'una opcion'),
(82, 'accounts', 'Cuentas'),
(83, 'categories', 'Categorias'),
(84, 'main', 'Principal'),
(85, 'search', 'Buscar'),
(86, 'by', 'por'),
(87, 'and_or', 'y/o'),
(88, 'upload', 'Subir'),
(89, 'contract', 'Contrato'),
(90, 'contracts', 'Contratos'),
(91, 'number_of', 'Numero de'),
(92, 'search_by', 'Buscar por'),
(93, 'phone_number', 'Numero Telefonico'),
(94, 'invoice', 'Factura'),
(95, 'id', 'ID'),
(96, 'dates', 'Fechas');


--
-- Volcado de datos para la tabla `phppos_modules`
--

INSERT INTO `phppos_modules` (`name_lang_key`, `desc_lang_key`, `sort`, `icon`, `module_id`) VALUES
('module_accepts', 'module_accepts_desc', 130, 'cloud-download', 'accepts'),
('module_config', 'module_config_desc', 100, 'cogs', 'config'),
('module_contable', 'module_contable_desc', 90, 'table', 'contable'),
('module_contratos', 'module_contratos_desc', 90, 'table', 'contratos'),
('module_customers', 'module_customers_desc', 10, 'group', 'customers'),
('module_dialogos', 'module_dialogos_desc', 90, 'table', 'dialogos'),
('module_employees', 'module_employees_desc', 80, 'user', 'employees'),
('module_entries', 'module_entries_desc', 140, 'upload', 'entries'),
('module_giftcards', 'module_giftcards_desc', 90, 'credit-card', 'giftcards'),
('module_item_kits', 'module_item_kits_desc', 30, 'inbox', 'item_kits'),
('module_items', 'module_items_desc', 20, 'table', 'items'),
('module_locations', 'module_locations_desc', 110, 'home', 'locations'),
('module_presales', 'module_presales_desc', 150, 'plus-circle', 'presales'),
('module_receivings', 'module_receivings_desc', 60, 'cloud-upload', 'receivings'),
('module_recepcion_turnos', 'module_recepcion_turnos_desc', 170, 'money', 'recepcion_turnos'),
('module_reports', 'module_reports_desc', 50, 'bar-chart-o', 'reports'),
('module_requisitions', 'module_requisitions_desc', 120, 'download', 'requisitions'),
('module_sales', 'module_sales_desc', 70, 'shopping-cart', 'sales'),
('module_suppliers', 'module_suppliers_desc', 40, 'download', 'suppliers'),
('module_working_hours', 'module_working_hours_desc', 160, 'lock', 'working_hours');


INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES
('add_update', 'accepts', 'module_action_add_update', 350),
('add_update', 'customers', 'module_action_add_update', 1),
('add_update', 'employees', 'module_action_add_update', 130),
('add_update', 'entries', 'module_action_add_update', 360),
('add_update', 'giftcards', 'module_action_add_update', 200),
('add_update', 'item_kits', 'module_action_add_update', 70),
('add_update', 'items', 'module_action_add_update', 40),
('add_update', 'locations', 'module_action_add_update', 240),
('add_update', 'presales', 'module_action_add_update', 370),
('add_update', 'requisitions', 'module_action_add_update', 340),
('add_update', 'suppliers', 'module_action_add_update', 100),
('assign_all_locations', 'employees', 'module_action_assign_all_locations', 151),
('delete', 'customers', 'module_action_delete', 20),
('delete', 'employees', 'module_action_delete', 140),
('delete', 'giftcards', 'module_action_delete', 210),
('delete', 'item_kits', 'module_action_delete', 80),
('delete', 'items', 'module_action_delete', 50),
('delete', 'locations', 'module_action_delete', 250),
('delete', 'suppliers', 'module_action_delete', 110),
('delete_sale', 'sales', 'module_action_delete_sale', 230),
('delete_suspended_sale', 'sales', 'module_action_delete_suspended_sale', 181),
('delete_taxes', 'sales', 'module_action_delete_taxes', 182),
('edit_sale', 'sales', 'module_edit_sale', 190),
('edit_sale_price', 'sales', 'module_edit_sale_price', 170),
('edit_store_account_balance', 'customers', 'customers_edit_store_account_balance', 31),
('give_discount', 'sales', 'module_give_discount', 180),
('search', 'customers', 'module_action_search_customers', 30),
('search', 'employees', 'module_action_search_employees', 150),
('search', 'giftcards', 'module_action_search_giftcards', 220),
('search', 'item_kits', 'module_action_search_item_kits', 90),
('search', 'items', 'module_action_search_items', 60),
('search', 'locations', 'module_action_search_locations', 260),
('search', 'suppliers', 'module_action_search_suppliers', 120),
('see_cost_price', 'items', 'module_see_cost_price', 61),
('see_quantities', 'sales', 'see_numbers', 189),
('see_stock_quantities', 'items', 'module_see_stock_quantities', 333),
('show_cost_price', 'reports', 'reports_show_cost_price', 290),
('show_profit', 'reports', 'reports_show_profit', 280),
('view_categories', 'reports', 'reports_categories', 100),
('view_customers', 'reports', 'reports_customers', 120),
('view_deleted_sales', 'reports', 'reports_deleted_sales', 130),
('view_discounts', 'reports', 'reports_discounts', 140),
('view_employees', 'reports', 'reports_employees', 150),
('view_giftcards', 'reports', 'reports_giftcards', 160),
('view_inventory_reports', 'reports', 'reports_inventory_reports', 170),
('view_item_kits', 'reports', 'module_item_kits', 180),
('view_items', 'reports', 'reports_items', 190),
('view_payments', 'reports', 'reports_payments', 200),
('view_profit_and_loss', 'reports', 'reports_profit_and_loss', 210),
('view_receivings', 'reports', 'reports_receivings', 220),
('view_register_log', 'reports', 'reports_register_log_title', 230),
('view_sales', 'reports', 'reports_sales', 240),
('view_sales_generator', 'reports', 'reports_sales_generator', 110),
('view_store_account', 'reports', 'reports_store_account', 250),
('view_suppliers', 'reports', 'reports_suppliers', 260),
('view_taxes', 'reports', 'reports_taxes', 270);


INSERT INTO `phppos_people` (`first_name`, `last_name`, `phone_number`, `email`, `address_1`, `address_2`, `city`, `state`, `zip`, `country`, `comments`, `image_id`, `person_id`) VALUES
('Administrador', 'Admin', '555-555-5555', 'admin@example.com', 'Address 1', '', '', '', '', '', '', NULL, 1);


INSERT INTO `phppos_permissions` (`module_id`, `person_id`) VALUES
('accepts', 1),
('config', 1),
('contable', 1),
('contratos', 1),
('customers', 1),
('dialogos', 1),
('employees', 1),
('entries', 1),
('giftcards', 1),
('item_kits', 1),
('items', 1),
('locations', 1),
('presales', 1),
('receivings', 1),
('recepcion_turnos', 1),
('reports', 1),
('requisitions', 1),
('sales', 1),
('suppliers', 1),
('working_hours', 1);

INSERT INTO `phppos_permissions_actions` (`module_id`, `person_id`, `action_id`) VALUES
('accepts', 1, 'add_update'),
('customers', 1, 'add_update'),
('customers', 1, 'delete'),
('customers', 1, 'edit_store_account_balance'),
('customers', 1, 'search'),
('employees', 1, 'add_update'),
('employees', 1, 'assign_all_locations'),
('employees', 1, 'delete'),
('employees', 1, 'search'),
('entries', 1, 'add_update'),
('giftcards', 1, 'add_update'),
('giftcards', 1, 'delete'),
('giftcards', 1, 'search'),
('item_kits', 1, 'add_update'),
('item_kits', 1, 'delete'),
('item_kits', 1, 'search'),
('items', 1, 'add_update'),
('items', 1, 'delete'),
('items', 1, 'search'),
('items', 1, 'see_cost_price'),
('items', 1, 'see_stock_quantities'),
('locations', 1, 'add_update'),
('locations', 1, 'delete'),
('locations', 1, 'search'),
('presales', 1, 'add_update'),
('reports', 1, 'show_cost_price'),
('reports', 1, 'show_profit'),
('reports', 1, 'view_categories'),
('reports', 1, 'view_customers'),
('reports', 1, 'view_deleted_sales'),
('reports', 1, 'view_discounts'),
('reports', 1, 'view_employees'),
('reports', 1, 'view_giftcards'),
('reports', 1, 'view_inventory_reports'),
('reports', 1, 'view_item_kits'),
('reports', 1, 'view_items'),
('reports', 1, 'view_payments'),
('reports', 1, 'view_profit_and_loss'),
('reports', 1, 'view_receivings'),
('reports', 1, 'view_register_log'),
('reports', 1, 'view_sales'),
('reports', 1, 'view_sales_generator'),
('reports', 1, 'view_store_account'),
('reports', 1, 'view_suppliers'),
('reports', 1, 'view_taxes'),
('requisitions', 1, 'add_update'),
('sales', 1, 'delete_sale'),
('sales', 1, 'delete_suspended_sale'),
('sales', 1, 'delete_taxes'),
('sales', 1, 'edit_sale'),
('sales', 1, 'edit_sale_price'),
('sales', 1, 'give_discount'),
('sales', 1, 'see_quantities'),
('suppliers', 1, 'add_update'),
('suppliers', 1, 'delete'),
('suppliers', 1, 'search');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `phppos_customers`
--
ALTER TABLE `phppos_customers`
  ADD CONSTRAINT `phppos_customers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `phppos_people` (`person_id`),
  ADD CONSTRAINT `phppos_customers_ibfk_2` FOREIGN KEY (`tier_id`) REFERENCES `phppos_price_tiers` (`id`);

--
-- Filtros para la tabla `phppos_employees`
--
ALTER TABLE `phppos_employees`
  ADD CONSTRAINT `phppos_employees_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `phppos_people` (`person_id`);

--
-- Filtros para la tabla `phppos_employees_locations`
--
ALTER TABLE `phppos_employees_locations`
  ADD CONSTRAINT `phppos_employees_locations_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `phppos_employees` (`person_id`),
  ADD CONSTRAINT `phppos_employees_locations_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `phppos_locations` (`location_id`);

--
-- Filtros para la tabla `phppos_giftcards`
--
ALTER TABLE `phppos_giftcards`
  ADD CONSTRAINT `phppos_giftcards_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `phppos_customers` (`person_id`);

--
-- Filtros para la tabla `phppos_inventory`
--
ALTER TABLE `phppos_inventory`
  ADD CONSTRAINT `phppos_inventory_ibfk_1` FOREIGN KEY (`trans_items`) REFERENCES `phppos_items` (`item_id`),
  ADD CONSTRAINT `phppos_inventory_ibfk_2` FOREIGN KEY (`trans_user`) REFERENCES `phppos_employees` (`person_id`),
  ADD CONSTRAINT `phppos_inventory_ibfk_3` FOREIGN KEY (`location_id`) REFERENCES `phppos_locations` (`location_id`);

--
-- Filtros para la tabla `phppos_items`
--
ALTER TABLE `phppos_items`
  ADD CONSTRAINT `phppos_items_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `phppos_suppliers` (`person_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `phppos_items_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `phppos_app_files` (`file_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `phppos_items_taxes`
--
ALTER TABLE `phppos_items_taxes`
  ADD CONSTRAINT `phppos_items_taxes_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `phppos_items` (`item_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `phppos_items_tier_prices`
--
ALTER TABLE `phppos_items_tier_prices`
  ADD CONSTRAINT `phppos_items_tier_prices_ibfk_1` FOREIGN KEY (`tier_id`) REFERENCES `phppos_price_tiers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `phppos_items_tier_prices_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `phppos_items` (`item_id`);

--
-- Filtros para la tabla `phppos_item_kits_taxes`
--
ALTER TABLE `phppos_item_kits_taxes`
  ADD CONSTRAINT `phppos_item_kits_taxes_ibfk_1` FOREIGN KEY (`item_kit_id`) REFERENCES `phppos_item_kits` (`item_kit_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `phppos_item_kits_tier_prices`
--
ALTER TABLE `phppos_item_kits_tier_prices`
  ADD CONSTRAINT `phppos_item_kits_tier_prices_ibfk_1` FOREIGN KEY (`tier_id`) REFERENCES `phppos_price_tiers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `phppos_item_kits_tier_prices_ibfk_2` FOREIGN KEY (`item_kit_id`) REFERENCES `phppos_item_kits` (`item_kit_id`);

--
-- Filtros para la tabla `phppos_item_kit_items`
--
ALTER TABLE `phppos_item_kit_items`
  ADD CONSTRAINT `phppos_item_kit_items_ibfk_1` FOREIGN KEY (`item_kit_id`) REFERENCES `phppos_item_kits` (`item_kit_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `phppos_item_kit_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `phppos_items` (`item_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `phppos_location_items`
--
ALTER TABLE `phppos_location_items`
  ADD CONSTRAINT `phppos_location_items_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `phppos_locations` (`location_id`),
  ADD CONSTRAINT `phppos_location_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `phppos_items` (`item_id`);

--
-- Filtros para la tabla `phppos_location_items_taxes`
--
ALTER TABLE `phppos_location_items_taxes`
  ADD CONSTRAINT `phppos_location_items_taxes_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `phppos_locations` (`location_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `phppos_location_items_taxes_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `phppos_items` (`item_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `phppos_location_items_tier_prices`
--
ALTER TABLE `phppos_location_items_tier_prices`
  ADD CONSTRAINT `phppos_location_items_tier_prices_ibfk_1` FOREIGN KEY (`tier_id`) REFERENCES `phppos_price_tiers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `phppos_location_items_tier_prices_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `phppos_locations` (`location_id`),
  ADD CONSTRAINT `phppos_location_items_tier_prices_ibfk_3` FOREIGN KEY (`item_id`) REFERENCES `phppos_items` (`item_id`);

--
-- Filtros para la tabla `phppos_location_item_kits`
--
ALTER TABLE `phppos_location_item_kits`
  ADD CONSTRAINT `phppos_location_item_kits_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `phppos_locations` (`location_id`),
  ADD CONSTRAINT `phppos_location_item_kits_ibfk_2` FOREIGN KEY (`item_kit_id`) REFERENCES `phppos_item_kits` (`item_kit_id`);

--
-- Filtros para la tabla `phppos_location_item_kits_taxes`
--
ALTER TABLE `phppos_location_item_kits_taxes`
  ADD CONSTRAINT `phppos_location_item_kits_taxes_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `phppos_locations` (`location_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `phppos_location_item_kits_taxes_ibfk_2` FOREIGN KEY (`item_kit_id`) REFERENCES `phppos_item_kits` (`item_kit_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `phppos_location_item_kits_tier_prices`
--
ALTER TABLE `phppos_location_item_kits_tier_prices`
  ADD CONSTRAINT `phppos_location_item_kits_tier_prices_ibfk_1` FOREIGN KEY (`tier_id`) REFERENCES `phppos_price_tiers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `phppos_location_item_kits_tier_prices_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `phppos_locations` (`location_id`),
  ADD CONSTRAINT `phppos_location_item_kits_tier_prices_ibfk_3` FOREIGN KEY (`item_kit_id`) REFERENCES `phppos_item_kits` (`item_kit_id`);

--
-- Filtros para la tabla `phppos_modules_actions`
--
ALTER TABLE `phppos_modules_actions`
  ADD CONSTRAINT `phppos_modules_actions_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `phppos_modules` (`module_id`);

--
-- Filtros para la tabla `phppos_people`
--
ALTER TABLE `phppos_people`
  ADD CONSTRAINT `phppos_people_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `phppos_app_files` (`file_id`);

--
-- Filtros para la tabla `phppos_permissions`
--
ALTER TABLE `phppos_permissions`
  ADD CONSTRAINT `phppos_permissions_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `phppos_employees` (`person_id`),
  ADD CONSTRAINT `phppos_permissions_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `phppos_modules` (`module_id`);

--
-- Filtros para la tabla `phppos_permissions_actions`
--
ALTER TABLE `phppos_permissions_actions`
  ADD CONSTRAINT `phppos_permissions_actions_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `phppos_modules` (`module_id`),
  ADD CONSTRAINT `phppos_permissions_actions_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `phppos_employees` (`person_id`),
  ADD CONSTRAINT `phppos_permissions_actions_ibfk_3` FOREIGN KEY (`action_id`) REFERENCES `phppos_modules_actions` (`action_id`);

--
-- Filtros para la tabla `phppos_presales`
--
ALTER TABLE `phppos_presales`
  ADD CONSTRAINT `phppos_presales_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `phppos_employees` (`person_id`),
  ADD CONSTRAINT `phppos_presales_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `phppos_customers` (`person_id`),
  ADD CONSTRAINT `phppos_presales_ibfk_3` FOREIGN KEY (`location_id`) REFERENCES `phppos_locations` (`location_id`),
  ADD CONSTRAINT `phppos_presales_ibfk_4` FOREIGN KEY (`deleted_by`) REFERENCES `phppos_employees` (`person_id`),
  ADD CONSTRAINT `phppos_presales_ibfk_5` FOREIGN KEY (`tier_id`) REFERENCES `phppos_price_tiers` (`id`);

--
-- Filtros para la tabla `phppos_presales_items`
--
ALTER TABLE `phppos_presales_items`
  ADD CONSTRAINT `phppos_presales_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `phppos_items` (`item_id`),
  ADD CONSTRAINT `phppos_presales_items_ibfk_2` FOREIGN KEY (`presale_id`) REFERENCES `phppos_presales` (`presale_id`);

--
-- Filtros para la tabla `phppos_presales_items_taxes`
--
ALTER TABLE `phppos_presales_items_taxes`
  ADD CONSTRAINT `phppos_presales_items_taxes_ibfk_1` FOREIGN KEY (`presale_id`) REFERENCES `phppos_presales_items` (`presale_id`),
  ADD CONSTRAINT `phppos_presales_items_taxes_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `phppos_items` (`item_id`);

--
-- Filtros para la tabla `phppos_presales_item_kits`
--
ALTER TABLE `phppos_presales_item_kits`
  ADD CONSTRAINT `phppos_presales_item_kits_ibfk_1` FOREIGN KEY (`item_kit_id`) REFERENCES `phppos_item_kits` (`item_kit_id`),
  ADD CONSTRAINT `phppos_presales_item_kits_ibfk_2` FOREIGN KEY (`presale_id`) REFERENCES `phppos_presales` (`presale_id`);

--
-- Filtros para la tabla `phppos_presales_item_kits_taxes`
--
ALTER TABLE `phppos_presales_item_kits_taxes`
  ADD CONSTRAINT `phppos_presales_item_kits_taxes_ibfk_1` FOREIGN KEY (`presale_id`) REFERENCES `phppos_presales_item_kits` (`presale_id`),
  ADD CONSTRAINT `phppos_presales_item_kits_taxes_ibfk_2` FOREIGN KEY (`item_kit_id`) REFERENCES `phppos_item_kits` (`item_kit_id`);

--
-- Filtros para la tabla `phppos_presales_payments`
--
ALTER TABLE `phppos_presales_payments`
  ADD CONSTRAINT `phppos_presales_payments_ibfk_1` FOREIGN KEY (`presale_id`) REFERENCES `phppos_presales` (`presale_id`);

--
-- Filtros para la tabla `phppos_receivings`
--
ALTER TABLE `phppos_receivings`
  ADD CONSTRAINT `phppos_receivings_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `phppos_employees` (`person_id`),
  ADD CONSTRAINT `phppos_receivings_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `phppos_suppliers` (`person_id`),
  ADD CONSTRAINT `phppos_receivings_ibfk_3` FOREIGN KEY (`location_id`) REFERENCES `phppos_locations` (`location_id`);

--
-- Filtros para la tabla `phppos_receivings_items`
--
ALTER TABLE `phppos_receivings_items`
  ADD CONSTRAINT `phppos_receivings_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `phppos_items` (`item_id`),
  ADD CONSTRAINT `phppos_receivings_items_ibfk_2` FOREIGN KEY (`receiving_id`) REFERENCES `phppos_receivings` (`receiving_id`);

--
-- Filtros para la tabla `phppos_register_log`
--
ALTER TABLE `phppos_register_log`
  ADD CONSTRAINT `phppos_register_log_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `phppos_employees` (`person_id`);

--
-- Filtros para la tabla `phppos_sales`
--
ALTER TABLE `phppos_sales`
  ADD CONSTRAINT `phppos_sales_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `phppos_employees` (`person_id`),
  ADD CONSTRAINT `phppos_sales_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `phppos_customers` (`person_id`),
  ADD CONSTRAINT `phppos_sales_ibfk_3` FOREIGN KEY (`location_id`) REFERENCES `phppos_locations` (`location_id`),
  ADD CONSTRAINT `phppos_sales_ibfk_4` FOREIGN KEY (`deleted_by`) REFERENCES `phppos_employees` (`person_id`),
  ADD CONSTRAINT `phppos_sales_ibfk_5` FOREIGN KEY (`tier_id`) REFERENCES `phppos_price_tiers` (`id`);

--
-- Filtros para la tabla `phppos_sales_items`
--
ALTER TABLE `phppos_sales_items`
  ADD CONSTRAINT `phppos_sales_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `phppos_items` (`item_id`),
  ADD CONSTRAINT `phppos_sales_items_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `phppos_sales` (`sale_id`);

--
-- Filtros para la tabla `phppos_sales_items_taxes`
--
ALTER TABLE `phppos_sales_items_taxes`
  ADD CONSTRAINT `phppos_sales_items_taxes_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `phppos_sales_items` (`sale_id`),
  ADD CONSTRAINT `phppos_sales_items_taxes_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `phppos_items` (`item_id`);

--
-- Filtros para la tabla `phppos_sales_item_kits`
--
ALTER TABLE `phppos_sales_item_kits`
  ADD CONSTRAINT `phppos_sales_item_kits_ibfk_1` FOREIGN KEY (`item_kit_id`) REFERENCES `phppos_item_kits` (`item_kit_id`),
  ADD CONSTRAINT `phppos_sales_item_kits_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `phppos_sales` (`sale_id`);

--
-- Filtros para la tabla `phppos_sales_item_kits_taxes`
--
ALTER TABLE `phppos_sales_item_kits_taxes`
  ADD CONSTRAINT `phppos_sales_item_kits_taxes_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `phppos_sales_item_kits` (`sale_id`),
  ADD CONSTRAINT `phppos_sales_item_kits_taxes_ibfk_2` FOREIGN KEY (`item_kit_id`) REFERENCES `phppos_item_kits` (`item_kit_id`);

--
-- Filtros para la tabla `phppos_sales_payments`
--
ALTER TABLE `phppos_sales_payments`
  ADD CONSTRAINT `phppos_sales_payments_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `phppos_sales` (`sale_id`);

--
-- Filtros para la tabla `phppos_store_accounts`
--
ALTER TABLE `phppos_store_accounts`
  ADD CONSTRAINT `phppos_store_accounts_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `phppos_sales` (`sale_id`),
  ADD CONSTRAINT `phppos_store_accounts_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `phppos_customers` (`person_id`);

--
-- Filtros para la tabla `phppos_suppliers`
--
ALTER TABLE `phppos_suppliers`
  ADD CONSTRAINT `phppos_suppliers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `phppos_people` (`person_id`);



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
