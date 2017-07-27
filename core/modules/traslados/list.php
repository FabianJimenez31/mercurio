<?php
global $user_array;
if(permitido($user_array['person_id'],$_GET['mod'])){	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
$aColumns = array( 'traslados_id', 'referencial', 'state');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "traslados_id";
	
	/* DB table to use */
	$sTable = "".DBPREFIX."traslados";
	$finicio=(isset($_GET['category']) && $_GET['category']!="" ) ? "0' and state like '%".$_GET['category']."%" : "0";


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
	if($sWhere != ""){
	$sWhere.="AND show_comments='".$finicio."'";
		}else{
	$sWhere.="WHERE show_comments='".$finicio."'";
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


/*$file = fopen("/var/www/html/sql.log", "a");
$dump= $sQuery ;
fwrite($file, $dump);
fclose($file);*/

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
		$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] == "cost_price" || $aColumns[$i] == "unit_price"  )
			{
				/* Special output formatting for 'version' column */
				$row[] = number_format($aRow[ $aColumns[$i] ],2);
			}
			else if ( $aColumns[$i] != ' ' )
			{
				/* General output */
				$row[] = utf8_encode ($aRow[ $aColumns[$i] ]);
			}
		}
$contenido="<a  href=\"?mod=traslados&proc=detalles&traslados_id=".$aRow['traslados_id']."\" >Detalles</a>";
if($aRow['state']=='Solicitado'){
$contenido.=" | <a  href=\"?mod=traslados&proc=cerrar&traslados_id=".$aRow['traslados_id']."\" onclick=\"javascript: return confirm('Esto Iniciará el Proceso de esta Órden de Traslado.\\nNo Podrá ser Cancelada y los Seriales Dejarán de Estar Disponibles para Venta.\\nNo Podrá regresar los Seriales a Disponibles hasta el Proceso de Cotejamiento.\\n¿Desea Continuar?');\" >Cerrar Órden</a>";
$contenido.=" | <a  href=\"?mod=traslados&proc=cancelar&traslados_id=".$aRow['traslados_id']."\" onclick=\"javascript: return confirm('Esto Cancelará esta Órden de Traslado.\\n¿Desea Continuar?');\" >Cancelar Órden</a>";
}
if($aRow['state']=='Cerrado'){
$contenido.=" | <a  href=\"?mod=traslados&proc=enviar&traslados_id=".$aRow['traslados_id']."\" onclick=\"javascript: return confirm('Esto Catalogará la Órden como Enviada.\\n¿Desea Continuar?');\" >Enviar Órden</a>";
$contenido.=" | <a  href=\"?mod=traslados&proc=detalles&traslados_id=".$aRow['traslados_id']."&print_now=print\" >Imprimir Traslado</a> ";
}
if($aRow['state']=='Enviado'){
$contenido.=" | <a  href=\"?mod=traslados&proc=recibir_1&traslados_id=".$aRow['traslados_id']."\" >Marcar cómo Recibido</a>";
$contenido.=" | <a  href=\"?mod=traslados&proc=detalles&traslados_id=".$aRow['traslados_id']."&print_now=print\" >Imprimir Traslado</a> ";
}

if($aRow['state']=='Recibido'){

$contenido.=" | <a  onclick=\"javascript: return confirm('Esto Finalizará la Órden.Todas las Devoluciones quedarán de nuevo como Disponibles en Inventario.\\n¿Desea Continuar?');\" href=\"?mod=traslados&proc=terminar&traslados_id=".$aRow['traslados_id']."\" >Marcar cómo Completado</a> ";

$contenido.=" | <a  href=\"?mod=traslados&proc=devoluciones&traslados_id=".$aRow['traslados_id']."\" >Procesar Devoluciones</a> ";
$contenido.=" | <a  href=\"?mod=traslados&proc=detalles&traslados_id=".$aRow['traslados_id']."&print_now=print\" >Imprimir Traslado</a> ";
}
		$row[]=$contenido;
		$output['aaData'][] = $row;

	}
	



	echo json_encode( $output );


}
?>
