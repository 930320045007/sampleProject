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
	};
	
	if ((isset($_GET['deluld'])) && ($_GET['deluld'] != "")) {
		$deleteSQL = sprintf("UPDATE user_leavedate SET userleavedate_status = '0' WHERE userleavedate_id=%s AND user_stafid=%s",
							 GetSQLValueString($_GET['deluld'], "int"),
							 GetSQLValueString($colname_userprofile, "text"));
	  
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$Result1 = mysql_query($deleteSQL, $hrmsdb) or die(mysql_error());
	  
		$deleteGoTo = $url_main . "admin/staffleavedetail.php?msg=del&id=" . getID($_GET['id']);
		
		sys_prorec('hr', 'user_leavedate', $row_user['user_stafid'], '4', 'id=' . htmlspecialchars($_GET['deluld'], ENT_QUOTES));
		
	} else {
		$deleteGoTo = $url_main . "admin/staffleavedetail.php?msg=error&id=" . getID($_GET['id']);
	};
	
} else {
	$deleteGoTo = $url_main . "admin/staffleavedetail.php?del=1&id=" . getID($_GET['id']);
};

header(sprintf("Location: %s", $deleteGoTo));
?>