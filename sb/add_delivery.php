<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
  
$insertGoTo = $url_main . "document/delivery.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "dokumen")) {
		
  $insertSQL = sprintf("INSERT INTO doc_status (doc_id, user_stafid,  docstatus_date_in) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['doc_id'], "int"),
					   GetSQLValueString($row_user['user_stafid'], "text"),
					   GetSQLValueString(date('d/m/Y h:i:s A'), "text"));

  mysql_select_db($database_tadbirdb, $tadbirdb);
  $Result = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());

 $insertGoTo .= "?msg=add";
} else {  
	$insertGoTo .= "?msg=error";
};

header(sprintf("Location: %s", $insertGoTo));
?>