<?php

echo "<br>2.0.9.0.4 Ejecutando Revision de Sistema de Bases de Datos";
echo "<br><br>Actualizacion de Campos Label y banner? ";

////validate if colummn exists

$result = ejecutar("SELECT * FROM `phppos_messages` where tag like  'dates'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

echo ($exists)?"SI":"NO [creando...]";

if($exists==FALSE){

ejecutar("TRUNCATE TABLE phppos_messages;");

ejecutar("INSERT INTO `phppos_messages` (`id`, `tag`, `label`) VALUES
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
");

ejecutar("UPDATE phppos_app_config set `value`='Banner con Mensaje. Cambiar en configuracion' where `key`='date_format'");

echo "<br>Creacion > [ OK ]";
}




?>
