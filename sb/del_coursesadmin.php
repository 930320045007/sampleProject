<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$deleteGoTo = $url_main . "admin/courseslist.php";

if(checkUserSysAcc($row_user['user_stafid'], 5, 11, 4))
{
	if ((isset($_GET['delc'])) && ($_GET['delc'] == "1"))
	{
		$deleteSQL = sprintf("UPDATE courses SET courses_status = '0' WHERE courses_id=%s",
							 GetSQLValueString($_GET['cid'], "int"));
	  
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$Result1 = mysql_query($deleteSQL, $hrmsdb) or die(mysql_error());
	  
		$deleteGoTo .= "?msg=del";
	};
	
} else {
	$deleteGoTo .= "?del=1";
};

header(sprintf("Location: %s", $deleteGoTo));
?>