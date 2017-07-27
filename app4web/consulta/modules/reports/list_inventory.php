<?php
global $user_array;
if($_GET['app_force_key']==md5('app4webmercuriounique')){	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
$aColumns = array( 'item_id' , 'producto','precio','cuantos','seriales' );
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "item_id";
	
	/* DB table to use */
//	$sTable = "".REALDBPREFIX."requisitions";


$sTable="(

SELECT 

t1.trans_items as item_id , 
CEIL(t2.unit_price*(1+(t2.iva/100))) as precio, t2.product_id as sku, t2.name as producto , 
sum(t1.trans_inventory) as cuantos, 
GROUP_CONCAT(DISTINCT serialNumber SEPARATOR ', ' ) AS seriales


FROM ".REALDBPREFIX."inventory as t1  
LEFT JOIN ".REALDBPREFIX."items as t2 on t1.trans_items=t2.item_id

WHERE requisition_fecha<='".$_GET['fecha']." 23:59:59'  and (sale_fecha>'".$_GET['fecha']." 23:59:59' or sale_fecha IS NULL) and state!='Trasladado'

Group by t1.trans_items
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
/*
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE totales>0 ";
			}
			else
			{
				$sWhere .= " AND totales>0";
			}
*/	
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
						
						if($aColumns[$i]!='cuantos' && $aColumns[$i]!='precio' && $aColumns[$i]!='item_id'){

						$row[] = utf8_encode ($aRow[ $aColumns[$i] ]);

						}elseif($aColumns[$i]=='cuantos'){
						$row[] = number_format($aRow[ $aColumns[$i] ],0,",",".");
						}elseif($aColumns[$i]=='precio'){
						$row[] = "$ " . number_format(utf8_encode ($aRow[ $aColumns[$i] ]),2,",",".");
						}else{

						}
					}



		}

		$output['aaData'][] = $row;
		
	}
	



	echo json_encode( $output );


}
?>
