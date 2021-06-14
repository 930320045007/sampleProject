<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$deleteGoTo = $url_main . "admin/stafflist.php";

if(checkUserSysAcc($row_user['user_stafid'], 5, 5, 4))
{
	
	$colname_userprofile = "-1";
	if (isset($_GET['id']))
	{
	  $colname_userprofile = getID(htmlspecialchars($_GET['id'], ENT_QUOTES),0);
	}
	
	if ((isset($_GET['deldes'])) && ($_GET['deldes'] != ""))
	{
		$deleteSQL = sprintf("UPDATE user_designation SET userdesignation_status = '0' WHERE userdesignation_id=%s AND user_stafid=%s",
							 GetSQLValueString($_GET['deldes'], "int"),
							 GetSQLValueString($colname_userprofile, "text"));
	  
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$Result1 = mysql_query($deleteSQL, $hrmsdb) or die(mysql_error());
	  
		$deleteGoTo = $url_main . "admin/edit.php?msg=del&id=" . getUserIDByStafID($colname_userprofile);
	} else {
		$deleteGoTo = $url_main . "admin/edit.php?msg=error&id=" . getUserIDByStafID($colname_userprofile);
	};
	
} else {
	$deleteGoTo = $url_main . "admin/edit.php?del=1&id=" . getUserIDByStafID($colname_userprofile);
};

header(sprintf("Location: %s", $deleteGoTo));
?>