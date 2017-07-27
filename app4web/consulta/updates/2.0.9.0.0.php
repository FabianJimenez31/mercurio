<?php

echo "<br>2.0.9 Ejecutando Revision de Sistema de Bases de Datos";
echo "<br><br>Existe BD para Temporales de messages? ";

////validate if colummn exists

$result = ejecutar("SHOW TABLES LIKE 'phppos_messages'");
$tableExists = (mysqli_num_rows($result) > 0)?TRUE:FALSE;
echo ($tableExists)?"SI":"NO";

if($tableExists==FALSE){
ejecutar("insert into phppos_modules (name_lang_key ,  desc_lang_key , sort , icon , module_id) values ('module_dialogos','module_dialogos_desc','90','table','dialogos');");

ejecutar("insert into phppos_permissions (module_id , person_id) values ('dialogos','1');");
ejecutar("

CREATE TABLE IF NOT EXISTS `phppos_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(100) NOT NULL,
  `label` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


");

ejecutar("

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
(20, 'config', 'ConfiguraciÃƒÂ³n'),
(21, 'accepts', 'RecepciÃƒÂ³n de Pedido'),
(22, 'logout', 'Salir'),
(23, 'welcome', 'Bienvenid@'),
(24, 'reg_deleted', 'Registros Eliminados'),
(25, 'item', 'ArtÃƒÂ­culo'),
(26, 'sku', 'SKU'),
(27, 'q_requested', 'Cantidad Solicitada'),
(28, 'q_received', 'Cantidad Recibida'),
(29, 'end', 'Terminar'),
(30, 'sale', 'Venta'),
(31, 'receive', 'Recibir'),
(32, 'edit', 'Editar'),
(33, 'saved_info', 'InformaciÃƒÂ³n Guardada'),
(34, 'red_fields', 'Los Campos en Rojo'),
(35, 'are', 'son'),
(36, 'required', 'Requeridos'),
(37, 'accept_id', 'Pedido ID'),
(38, 'accept_number', 'NÃƒÂºmero de Pedido'),
(39, 'date', 'Fecha'),
(40, 'created', 'de CreaciÃƒÂ³n'),
(41, 'eta', 'Fecha Estimada de Llegada'),
(42, 'sure_delete_1', 'Ã‚Â¿EstÃƒÂ¡ Seguro de Eliminar los ('),
(43, 'sure_delete_2', ' ) elementos seleccionados'),
(44, 'system', 'Sistema'),
(45, 'of', 'de'),
(46, 'successfully', 'Exitosamente'),
(47, 'accept', 'Aceptar'),
(48, 'archivo_contable', 'Archivo Contable'),
(49, 'new_account', 'Nueva Cuenta'),
(50, 'delete', 'Eliminar'),
(51, 'category', 'CategorÃ­a'),
(52, 'internal_id', 'ID Interno'),
(53, 'account_for', 'Cuenta de '),
(54, 'credit', '( CrÃ©dito )'),
(55, 'debit', ' ( DÃ©bito )'),
(56, 'inventory', 'Inventario'),
(57, 'cash_line', 'Caja'),
(58, 'used_by', 'Usada por'),
(59, 'start_day', 'Desea iniciar el dia con estos montos'),
(60, 'closure_of', 'Cierre de Caja'),
(61, 'end_day', 'Desea Terminar el dia con estos montos'),
(62, 'success', 'Exito!! '),
(63, 'sure_delete_undone', 'Se eliminara este registro. Esta accion no podra deshacerse'),
(64, 'retake', 'Retomar'),
(65, 'close', 'Cerrar');

");
echo "<br>Creacion > [ OK ]";
}




?>
