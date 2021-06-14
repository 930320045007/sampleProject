<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$deleteGoTo = $url_main . "admin/staffleave.php";

if(checkUserSysAcc($row_user['user_stafid'], 5, 23, 4))
{
	
	$colname_userprofile = "-1";
	if (isset($_GET['id']))
	{
	  $colname_userprofile = getStafIDByUserID(getID(htmlspecialchars($_GET['id'], ENT_QUOTES),0));
	}
	
	if ((isset($_GET['delul'])) && ($_GET['delul'] != ""))
	{
		$deleteSQL = sprintf("UPDATE user_leave SET userleave_status = '0' WHERE userleave_id=%s AND user_stafid=%s",
							 GetSQLValueString($_GET['delul'], "int"),
							 GetSQLValueString($colname_userprofile, "text"));
	  
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$Result1 = mysql_query($deleteSQL, $hrmsdb) or die(mysql_error());
		
		sys_prorec('hr', 'user_leave', $row_user['user_stafid'], '4', 'id=' . htmlspecialchars($_GET['deluld'], ENT_QUOTES));
	  
		$deleteGoTo = $url_main . "admin/staffleavedetail.php?msg=del&id=" . getID(htmlspecialchars($_GET['id'], ENT_QUOTES));
		
	} else {
		$deleteGoTo = $url_main . "admin/staffleavedetail.php?msg=error&id=" . getID(htmlspecialchars($_GET['id'], ENT_QUOTES));
	};
	
} else {
	$deleteGoTo = $url_main . "admin/staffleavedetail.php?del=1&id=" . getID(htmlspecialchars($_GET['id'], ENT_QUOTES));
};

header(sprintf("Location: %s", $deleteGoTo));
?>