<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/aktadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$updateGoTo = $url_main . "head/akta.php";

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1"))
{
	if(checkUserSysAcc($row_user['user_stafid'], 14, 47, 3))
	{
		$updateSQL = sprintf("UPDATE ap SET ap_by=%s, ap_date_d=%s, ap_date_m=%s, ap_date_y=%s, ap_date_h=%s, ap_title=%s, ap_note=%s, ap_year=%s, category_id=%s, ap_sumber=%s, apsumberurl=%s WHERE ap_id=%s",
							 GetSQLValueString($row_user['user_stafid'], "text"),
							 GetSQLValueString(date('d'), "text"),
							 GetSQLValueString(date('d'), "text"),
							 GetSQLValueString(date('d'), "text"),
							 GetSQLValueString(date('h:i:s A'), "text"),
							 GetSQLValueString($_POST['ap_title'], "text"),
							 GetSQLValueString($_POST['ap_note'], "text"),
							 GetSQLValueString($_POST['ap_year'], "text"),
							 GetSQLValueString($_POST['category_id'], "int"),
							 GetSQLValueString($_POST['ap_sumber'], "text"),
							 GetSQLValueString($_POST['apsumberurl'], "text"),
							 GetSQLValueString($_POST['ap_id'], "int")); 
	  
		mysql_select_db($database_aktadb, $aktadb);
		$Result1 = mysql_query($updateSQL, $aktadb) or die(mysql_error());
	  
		$updateGoTo .= "?msg=add";
		
	} else {
  		$updateGoTo .= "?eul=1";
	};
	
} else {
	$updateGoTo .= "?msg=error";
};

header(sprintf("Location: %s", $updateGoTo));
?>