<?php
global $user_array;
if(permitido($user_array['person_id'],$_GET['mod'])){	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
/*

<th>ID de Recepción</th>
<th>Cliente</th>
<th>Recibido Por</th>
<th>Marca</th>
<th>Modelo</th>
<th>IMEI</th>
<th>Tipo</th>
<th>Fecha de Recepción</th>
<th>Fecha de Envío</th>
<th>Estado</th>
<th></th>

*/



$aColumns = array( 'envios_id' , 'cliente','vendedor','marca' , 'modelo' , 'imei' , 'tipo' , 'recibido' , 'enviado' , 'actual' );
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "envios_id";
	
	/* DB table to use */
	$sTable = "(SELECT 

t1.envios_id as envios_id,
concat(t2.first_name, ' ' ,t2.last_name) as cliente,
concat(t3.first_name, ' ' ,t3.last_name) as vendedor,
t4.valor as marca,
t5.valor as modelo,
t1.imei as imei,
if(t1.tipo='1','A',if(t1.tipo='2','B',if(t1.tipo='3','C','D'))) as tipo,
t1.creacion_fecha_real as recibido,
t1.envio_fecha as enviado,
if(t1.status=1,'Recibido',if(t1.status=2,'Enviado Geeksify',if(t1.status=3,'Aprobado Geeksify','Pagado Geeksify'))) as actual
FROM

".DBPREFIX."geeksify_envio as t1
LEFT JOIN ".DBPREFIX."people as t2 on t1.client_id = t2.person_id
LEFT JOIN ".DBPREFIX."people as t3 on t1.person_id = t3.person_id
LEFT JOIN ".DBPREFIX."geeksify_marcas as t4 on t1.marca_id = t4.marcas_id
LEFT JOIN ".DBPREFIX."geeksify_modelos as t5 on t1.modelo_id = t5.modelos_id
) as t33";

//	echo $sTable;
	/* Database connection information */
	$gaSql['user']       = MYSQLUSER;
	$gaSql['password']   = MYSQLPSSWD;
	$gaSql['db']         = MYSQLDB;
	$gaSql['server']     = MYSQLHOST;
	
	/* REMOVE THIS LINE (it just includes my SQL connection user/pass) */
//	include( $_SERVER['DOCUMENT_ROOT']."/datatables/mysql.php" );
	
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP server-side, there is
	 * no need to edit below this line
	 */
	
	/* 
	 * Local functions
	 */
	function fatal_error ( $sErrorMessage = '' )
	{
		header( $_SERVER['SERVER_PROTOCOL'].' 500 Internal Server Error' );
		die( $sErrorMessage );
	}

	
	/* 
	 * MySQL connection
	 */
	if ( ! $gaSql['link'] = mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) )
	{
		fatal_error( 'Could not open connection to server' );
	}

	if ( ! mysql_select_db( $gaSql['db'], $gaSql['link'] ) )
	{
		fatal_error( 'Could not select database ' );
	}
	
	
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_POST['iDisplayStart'] ) && $_POST['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysql_real_escape_string( $_POST['iDisplayStart'] ).", ".
			mysql_real_escape_string( $_POST['iDisplayLength'] );
	}
	
	
	/*
	 * Ordering
	 */
	$sOrder = "";
	if ( isset( $_POST['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_POST['iSortingCols'] ) ; $i++ )
		{
			if ( $_POST[ 'bSortable_'.intval($_POST['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= "`".$aColumns[ intval( $_POST['iSortCol_'.$i] ) ]."` ".
				 	mysql_real_escape_string( $_POST['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	
	/* 
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	$sWhere = "";
	if ( isset($_POST['sSearch']) && $_POST['sSearch'] != "" )
	{
		$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere .= "`".$aColumns[$i]."` LIKE '%".mysql_real_escape_string( $_POST['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}

	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( isset($_POST['bSearchable_'.$i]) && $_POST['bSearchable_'.$i] == "true" && $_POST['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= "`".$aColumns[$i]."` LIKE '%".mysql_real_escape_string($_POST['sSearch_'.$i])."%' ";
		}
	}
	

	/*
	 * SQL queries
	 * Get data to display
	 */
	
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit
		";



	$rResult = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";


	$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
	$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	/* Total data set length */
	$sQuery = "
		SELECT COUNT(`".$sIndexColumn."`)
		FROM   $sTable
		$sWhere
	";

	
	$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
	$aResultTotal = mysql_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	
	
	/*
	 * Output
	 */
	$output = array(
		"sEcho" => intval($_POST['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);


	
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		//var_dump($aRow);
		$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{

					$row[] = utf8_encode ($aRow[ $aColumns[$i] ]);


		}



if($aRow['actual']=='Recibido'){

		$row[]="<a href=\"?mod=geeksify_process&proc=improve&id=".$aRow['envios_id']."\" >Enviar a Geeksify</a> | <a title=\"\" href=\"?mod=geeksify_process&proc=edit&id=".$aRow['envios_id']."\" >Editar</a>";

}elseif($aRow['actual']=='Enviado Geeksify'){

		$row[]="<a href=\"?mod=geeksify_process&proc=improve&id=".$aRow['envios_id']."\" >Aprobado por Geeksify</a>";

}elseif($aRow['actual']=='Aprobado Geeksify'){

		$row[]="<a href=\"?mod=geeksify_process&proc=improve&id=".$aRow['envios_id']."\" >Pagado por Geeksify</a>";

}else{

		$row[]=" ";

}

		$output['aaData'][] = $row;

	}
	



	echo json_encode( $output );


}
?>
