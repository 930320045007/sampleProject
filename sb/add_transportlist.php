<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php

$insertGoTo = $url_main . "tadbir/transportlist.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formtransport")) {
	if(checkUserSysAcc($row_user['user_stafid'], 10, 81, 2)){
		  $insertSQL = sprintf("INSERT INTO transport (transporttype_id, transport_name, transport_plat) VALUES (%s, %s, %s)",
							   GetSQLValueString($_POST['type'], "int"),
							   GetSQLValueString($_POST['transport_name'], "text"),
							   GetSQLValueString($_POST['transport_plat'], "text"));
		
		  mysql_select_db($database_tadbirdb, $tadbirdb);
		  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());
		
		  $insertGoTo .= "?msg=add";
	} else {
		$insertGoTo .= "?eul=1";
	};
}

header(sprintf("Location: %s", $insertGoTo));
?>