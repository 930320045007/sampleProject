<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/hartadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/hartafunc.php');?>
<?php
$updateGoTo = $url_main . "harta/reportdetail_admin.php";

if(checkUserSysAcc($row_user['user_stafid'], 12, 45, 4))
{
	if(!checkFeedbackEnd($_GET['urid']))
	{
		  $updateSQL = sprintf("UPDATE user_item SET useritem_status=0 WHERE useritem_id=%s AND userreport_id=%s",
							   GetSQLValueString($_GET['id'], "int"),
							   GetSQLValueString($_GET['urid'], "int")); 
		
		  mysql_select_db($database_hartadb, $hartadb);
		  $Result1 = mysql_query($updateSQL, $hartadb) or die(mysql_error());
		
		  $updateGoTo .= "?id=" . htmlspecialchars($_GET['urid'], ENT_QUOTES) . "&msg=del";
		} else {
			$insertGoTo .= "?id=" . htmlspecialchars($_GET['urid'], ENT_QUOTES) . "&msg=error";
		};
		
} else {
	$updateGoTo .= "?id=" . htmlspecialchars($_GET['urid'], ENT_QUOTES) . "&eul=1";
};

header(sprintf("Location: %s", $updateGoTo));
?>