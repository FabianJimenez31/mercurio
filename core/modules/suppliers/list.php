<?php
global $user_array;
if(permitido($user_array['person_id'],$_GET['mod'])){	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
$aColumns = array( 't1`.`person_id', 't1`.`company_name', 't2`.`email', 't2`.`phone_number', 't1`.`person_id');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "t1`.`person_id";
	
	/* DB table to use */
	$sTable = "".DBPREFIX."suppliers AS t1 INNER JOIN ".DBPREFIX."people AS t2 ON t1.person_id = t2.person_id AND t1.deleted=0";

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
	if ( ! $gaSql['link'] = mysqli_connect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) )
	{
		fatal_error( 'Could not open connection to server' );
	}

	if ( ! mysqli_select_db( $gaSql['link'] , $gaSql['db'] ) )
	{
		fatal_error( 'Could not select database ' . $gaSql['db'] );
	}
	
	
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_POST['iDisplayStart'] ) && $_POST['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysqli_real_escape_string( $gaSql['link'] ,  $_POST['iDisplayStart'] ).", ".
			mysqli_real_escape_string( $gaSql['link'] ,  $_POST['iDisplayLength'] );
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
				 	mysqli_real_escape_string( $gaSql['link'] ,  $_POST['sSortDir_'.$i] ) .", ";
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
			$sWhere .= "`".$aColumns[$i]."` LIKE '%".mysqli_real_escape_string( $gaSql['link'] ,  $_POST['sSearch'] )."%' OR ";
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
			$sWhere .= "`".$aColumns[$i]."` LIKE '%".mysqli_real_escape_string( $gaSql['link'] , $_POST['sSearch_'.$i])."%' ";
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



	$rResult = mysqli_query( $gaSql['link'], $sQuery  ) or fatal_error( 'MySQL Error: ' . mysqli_errno($gaSql['link']) );

	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";


	$rResultFilterTotal = mysqli_query($gaSql['link'],  $sQuery ) or fatal_error( 'MySQL Error: ' . mysqli_errno($gaSql['link']) );
	$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	/* Total data set length */
	$sQuery = "
		SELECT COUNT(`".$sIndexColumn."`)
		FROM   $sTable
		$sWhere
	";


	$rResultTotal = mysqli_query( $gaSql['link'] , $sQuery ) or fatal_error( 'MySQL Error: ' . mysqli_errno($gaSql['link']) );
	$aResultTotal = mysqli_fetch_array($rResultTotal);
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


	
	while ( $aRow = mysqli_fetch_array( $rResult ) )
	{
		//var_dump($aRow);
		$row = array();
		$row[]="<input onclick='javascript:checkboxes();' type='checkbox' name='selected_item[]' value='".$aRow['person_id']."'>";
		$row[]=$aRow['person_id'];
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
				if(str_replace(array("`",".","t1","t2"),"",$aColumns[$i] ) != 'person_id'){
					$row[] = utf8_encode ($aRow[ str_replace(array("`",".","t1","t2"),"",$aColumns[$i] )]);
				}

		}
		$row[]="<a title=\"\" href=\"?mod=suppliers&proc=edit&supplier_id=".$aRow['person_id']."\" >Editar</a>";
		$output['aaData'][] = $row;

	}
	



	echo json_encode( $output );


}
?>
