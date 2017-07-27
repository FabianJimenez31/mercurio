<?php
global $user_array;
if(permitido($user_array['person_id'],$_GET['mod'])){	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
$aColumns = array( 'item_id', 'product_id', 'name', 'category', 'size' ,'cost_price', 'unit_price');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "item_id";
	
	/* DB table to use */
	$sTable = "".DBPREFIX."items";
	$finicio=(isset($_GET['category']) && $_GET['category']!="" ) ? "0' and category like '%".$_GET['category']."%" : "0";


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
	$sWhere.="AND deleted='".$finicio."'";
		}else{
	$sWhere.="WHERE deleted='".$finicio."'";
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
		$row[]="<input onclick='javascript:checkboxes();' type='checkbox' name='selected_item[]' value='".$aRow['item_id']."'>";
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
		$cantidad=select_mysql("*","inventory","trans_items='".$aRow['item_id']."' and state='Disponible'");
		$row[]=($cantidad['count']>0) ? $cantidad['count'] : 'No Disponible';
		$row[]="<a title=\"\" href=\"?mod=items&proc=show_inventory&item_id=".$aRow['item_id']."\" data-toggle=\"modal\" data-target=\"#modal_inventario_".$aRow['item_id']."\" >Inventario</a><div class=\"modal fade hidden-print\" id=\"modal_inventario_".$aRow['item_id']."\"></div>";
		$row[]="<a title=\"\" href=\"?mod=items&proc=edit&item_id=".$aRow['item_id']."\" >Editar</a>";
		$output['aaData'][] = $row;

	}
	



	echo json_encode( $output );


}
?>
