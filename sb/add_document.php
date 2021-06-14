<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php

  $_SESSION['lokasi'][] = NULL;
  unset($_SESSION['lokasi']);
  
  $_SESSION['staf'][] = NULL;
  unset($_SESSION['staf']);
  
$insertGoTo = $url_main . "document/record.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "penerima")) {
	
	$total = count($_POST['receiver']);
	
	if($total>0){
		
  $insertSQL = sprintf("INSERT INTO document (doc_by, doc_date_d, doc_date_m, doc_date_y, category_id, doc_refno, doc_title) VALUES (%s,%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($row_user['user_stafid'], "text"),
                       GetSQLValueString(date('d'), "text"),
                       GetSQLValueString(date('m'), "text"),
                       GetSQLValueString(date('Y'), "text"),
					   GetSQLValueString($_POST['category_id'], "int"), 
					   GetSQLValueString($_POST['doc_refno'], "text"),
					   GetSQLValueString($_POST['doc_title'], "text"));

  mysql_select_db($database_tadbirdb, $tadbirdb);
  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());
    
  //Untuk memasukkan maklumat dalam table user_applyitem
  
  $docreceiverid = getDocIDByStaffID($row_user['user_stafid'],date('d'),date('m'),date('Y'));
  
  if(isset($_POST['receiver']) && count($_POST['receiver'])!=0)
		{
			foreach($_POST['receiver'] AS $key => $value)
			{
   $insertSQL2 = sprintf("INSERT INTO document_receiver (doc_id, docreceiver_dir, docreceiver_staf) VALUES (%s,%s,%s)",
                       GetSQLValueString($docreceiverid, "int"),
					   GetSQLValueString($_POST['dir'][$key], "int"),
					   GetSQLValueString($value, "text"));

  mysql_select_db($database_tadbirdb, $tadbirdb);
  $Result2 = mysql_query($insertSQL2, $tadbirdb) or die(mysql_error());  
  };
				  };
				  
		
				  
  
  $insertGoTo .= "?msg=add";
} else {  
	$insertGoTo .= "?msg=error";
};
} else {
  		$insertGoTo = $url_main . "document/index.php?eul=1";
	};

header(sprintf("Location: %s", $insertGoTo));
?>