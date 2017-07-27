<?php
global $user_array;
if(permitido($user_array['person_id'],$_GET['mod'])){	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
$aColumns = array( 'requisitionId' , 'requisitionNumber','requisitionDate','eta','totales','principal','estado' );
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "requisitionId";
	
	/* DB table to use */
//	$sTable = "".DBPREFIX."requisitions";


$sTable="(

SELECT t1.requisitionId, t1.requisitionNumber, t1.state as estado, t1.requisitionDate, t1.eta , if(t1.prev_id=0,'N/A',t1.prev_id) as principal, 
IFNULL((sum(t2.quantity)-sum(t2.quantity_accepts)),sum(t2.quantity)) as totales 
FROM ".DBPREFIX."requisitions AS t1
INNER JOIN ".DBPREFIX."requisitions_items AS t2 ON t1.requisitionId = t2.requisitionId

WHERE force_close=0

GROUP BY t1.requisitionId
) AS tf ";

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
//state = 'Solicitud Enviada'

			if ( $sWhere == "" )
			{
				$sWhere = "WHERE totales>0 ";
			}
			else
			{
				$sWhere .= " AND totales>0";
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

	//echo $sQuery;

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
					if($aColumns[$i]!='estado'){
						
						if($aColumns[$i]!='requisitionId' && $aColumns[$i]!='principal'){
						$row[] = utf8_encode ($aRow[ $aColumns[$i] ]);
						}elseif($aColumns[$i]=='principal'){
						$row[] = (utf8_encode ($aRow[ $aColumns[$i] ])!='N/A')?"<A href=\"?mod=receipts&proc=receivings&id='".utf8_encode ($aRow[ $aColumns[$i] ])."'\">".utf8_encode ($aRow[ $aColumns[$i] ])."</A>":utf8_encode ($aRow[ $aColumns[$i] ]);
						}else{
						$row[] = "<A href=\"?mod=receipts&proc=receivings&id='".utf8_encode ($aRow[ $aColumns[$i] ])."'\">".utf8_encode ($aRow[ $aColumns[$i] ])."</A>";
						}
					}



		}
		$row[]=($aRow['estado']=='Solicitud Enviada')?"<a title=\"\" href=\"?mod=accepts&proc=edit&req_id=".$aRow['requisitionId']."\" >".label_me('receive')."</a>":"<a title=\"\" href=\"?mod=accepts&proc=new_request&req_id=".$aRow['requisitionId']."\" >Crear Sub-Orden con Faltante</a> | <a title=\"\" href=\"?mod=accepts&proc=edit&req_id=".$aRow['requisitionId']."\" >Cerrar Completamente</a>";
		$output['aaData'][] = $row;
		
	}
	



	echo json_encode( $output );


}
?>
