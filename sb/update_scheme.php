<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$updateGoTo = $url_main . "admin/emp.php";

if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3))
{
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "sch"))
	{
		$updateSQL = sprintf("UPDATE scheme SET classification_id=%s, scheme_code=%s, scheme_code2=%s, scheme_name=%s, group_id=%s, scheme_gred=%s WHERE scheme_id=%s",
							 GetSQLValueString($_POST['classification_id'],"int"),
							 GetSQLValueString($_POST['scheme_code'],"int"),
							 GetSQLValueString($_POST['scheme_code2'],"text"),
							 GetSQLValueString($_POST['scheme_name'],"text"),
							 GetSQLValueString($_POST['group_id'],"int"),
							 GetSQLValueString($_POST['scheme_gred'],"text"),
							 GetSQLValueString($_POST['scheme_id'],"int"));
	  
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
		
		$updateGoTo .= "?msg=add&cid=" . htmlspecialchars($_POST['classification_id'], ENT_QUOTES);
		
	} else {
		$updateGoTo .= "?msg=error$cid=" . htmlspecialchars($_POST['classification_id'], ENT_QUOTES);
	};
	
} else {
	$updateGoTo .= "?eul=1$cid=" . htmlspecialchars($_POST['classification_id'], ENT_QUOTES);
};

header(sprintf("Location: %s", $updateGoTo));
?>