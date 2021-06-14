<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$updateGoTo = $url_main . "admin/salary.php";

if (isset($_GET['delus']))
{
	if(checkUserSysAcc($row_user['user_stafid'], 5, 34, 4) && $row_user['user_stafid']!=$_GET['usid'])
	{
		  $updateSQL = sprintf("UPDATE www.user_salary SET usersalary_status=0 WHERE usersalary_id=%s AND usersalary_date_m=%s AND usersalary_date_y=%s AND user_stafid=%s AND transaction_id=%s",
							   GetSQLValueString(getID($_GET['delus'],0), "text"),
							   GetSQLValueString(getID($_GET['usdm'],0), "text"),
							   GetSQLValueString(getID($_GET['usdy'],0), "text"),
							   GetSQLValueString(getID($_GET['usid'],0), "text"),
							   GetSQLValueString(getID($_GET['tid'],0), "text"));
		
		  mysql_select_db($database_hrmsdb, $hrmsdb);
		  $Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
		  
		  sys_prorec('hr', 'user_salary', $row_user['user_stafid'], '4', 'id=' . getID(htmlspecialchars($_GET['delus'], ENT_QUOTES),0));
		
		  $updateGoTo .= "?msg=del&id=" . htmlspecialchars($_GET['usid'], ENT_QUOTES) . "&bulan=" . getID($_GET['dm'],0) . "/" . getID($_GET['dy'],0);
		  
	} else {
  		$updateGoTo .= "?eul=1&id=" . htmlspecialchars($_GET['usid'], ENT_QUOTES) . "&bulan=" . htmlspecialchars($_GET['usdm'], ENT_QUOTES);
	};
	
} else {
	$updateGoTo .= "?msg=error&id=" . htmlspecialchars($_GET['usid'], ENT_QUOTES) . "&bulan=" . htmlspecialchars($_GET['usdm'], ENT_QUOTES);
};

header(sprintf("Location: %s", $updateGoTo));
?>
