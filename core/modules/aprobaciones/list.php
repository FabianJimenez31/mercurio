<?php
global $user_array;
if(permitido($user_array['person_id'],$_GET['mod'])){	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */

/*

<th>SKU</th>
<th>Numero de Contrato / Serial</th>
<th>Teléfono</th>
<th>Factura</th>
<th>Cliente</th>
<th>Vendedor</th>
<th>Contrato Subido</th>

*/


$aColumns = array( 'item_id','sku', 'customer_id' , 'employee_id' ,'line' , 'contrato', 'telefono','factura' , 'cliente' , 'vendedor' , 'subido','fecha');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "fecha";
	
	/* DB table to use */
	$sTable = "
(

SELECT 
t1.item_id as item_id,
t5.customer_id as customer_id,
t5.salesman as employee_id,
t1.line as line,
t2.product_id as sku , 
t1.serialnumber as contrato,
t1.num_tel as telefono,
t1.sale_id as factura,
concat(t3.first_name , ' ' , t3.last_name) as cliente,
concat(t4.first_name , ' ' , t4.last_name) as vendedor,
if( t2.is_serialized=1 AND t2.is_service=1, if(t1.contrato='' , 'NO' , 'SI'),'N/A') as subido , 
t5.sale_time as fecha

from

".DBPREFIX."sales_items AS t1 

INNER JOIN ".DBPREFIX."items AS t2 ON t1.item_id = t2.item_id
INNER JOIN ".DBPREFIX."sales AS t5 ON t1.sale_id = t5.sale_id
INNER JOIN ".DBPREFIX."people AS t3 ON t5.customer_id = t3.person_id
INNER JOIN ".DBPREFIX."people AS t4 ON t5.salesman = t4.person_id
LEFT JOIN ".DBPREFIX."employees AS t6 ON t5.salesman = t6.person_id


WHERE

t1.is_aprobada=0 AND t2.categoria_id>0 and t6.metas_id>0 and t6.esquema_id>0 

) as t23


";

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
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{

//$aColumns = array( 'item_id','sku' , 'line' ,'contrato', 'telefono','factura' , 'cliente' , 'vendedor' , 'subido','fecha');
				if($aColumns[$i]  != 'item_id' && $aColumns[$i]  != 'line' && $aColumns[$i]!='customer_id' && $aColumns[$i]!='employee_id'){

					switch($aColumns[$i]){
					case 'sku':
					$row[] = "<a href=\"?mod=items&proc=edit&item_id=".$aRow['item_id']."\">".$aRow['sku']."</a>";
					break;

					case 'factura':
					$row[] = "<a href=\"?mod=receipts&proc=sales&id=".$aRow['factura']."\">".$aRow['factura']."</a>";
					break;

					case 'cliente':
					$row[] = "<a href=\"?mod=customers&proc=edit&person_id=".$aRow['customer_id']."\">".$aRow['cliente']."</a>";
					break;

					case 'vendedor':
					$row[] = "<a href=\"?mod=employees&proc=edit&person_id=".$aRow['employee_id']."\">".$aRow['vendedor']."</a>";
					break;

					case 'subido':
					$row[] = ($aRow['subido']=='N/A')? 'N/A': "<form action=\"?mod=contratos&proc=list\" method='POST'><input type=\"hidden\" name=\"contrato\"  value=\"".$aRow['contrato']."\" ><button type='submit' class=\"btn btn-default\">".$aRow['subido']."</button></form>";
					break;

					default:
					$row[] = $aRow[ $aColumns[$i] ] ;
					}



				}

		}
$row[] ="<a href='#' onclick=\"javascript:aprobar_item('".$aRow['item_id']."','".$aRow['line']."','".$aRow['factura']."');\">Aprobar</a> | <a href='#' onclick=\"javascript:rechazar_item('".$aRow['item_id']."','".$aRow['line']."','".$aRow['factura']."');\">Rechazar</a>";
		$output['aaData'][] = $row;

	}
	



	echo json_encode( $output );


}
?>
