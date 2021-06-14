<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php
$updateGoTo = $url_main . "admin/salary.php";

if(checkUserSysAcc($row_user['user_stafid'], 5, 34, 3) && $row_user['user_stafid']!=$_POST['user_stafid'])
{
	if(isset($_SESSION['user_stafid']) && $_POST['kl']==getPassKey(getPassOldByUserID($row_user['user_stafid']),'2'))
	{
		  if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2"))
		  {
				  $updateSQL = sprintf("UPDATE www.user_salary SET usersalary_date_d=%s, usersalary_date_m=%s, usersalary_date_y=%s, usersalary_end_d=%s, usersalary_end_m=%s, usersalary_end_y=%s, usersalary_end_by=%s, usersalary_end_date=%s, user_stafid=%s, usersalary_kew8=%s, usersalary_ref=%s, transaction_id=%s, usersalary_value=%s WHERE usersalary_id=%s",
									   GetSQLValueString($_POST['usersalary_date_d'], "text"),
									   GetSQLValueString($_POST['usersalary_date_m'], "text"),
									   GetSQLValueString($_POST['usersalary_date_y'], "text"),
									   GetSQLValueString($_POST['usersalary_end_d'], "text"),
									   GetSQLValueString($_POST['usersalary_end_m'], "text"),
									   GetSQLValueString($_POST['usersalary_end_y'], "text"),
									   GetSQLValueString($row_user['user_stafid'], "text"),
									   GetSQLValueString(date('d / m /Y h:i A'), "text"),
									   GetSQLValueString($_POST['user_stafid'], "text"),
									   GetSQLValueString($_POST['usersalary_kew8'], "text"),
									   GetSQLValueString($_POST['usersalary_ref'], "text"),
									   GetSQLValueString($_POST['transaction_id'], "int"),
									   GetSQLValueString($_POST['usersalary_value'], "double"),
									   GetSQLValueString($_POST['usersalary_id'], "int"));
				
				  mysql_select_db($database_hrmsdb, $hrmsdb);
				  $Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
				
				  $updateGoTo .= "?id=" . getID(htmlspecialchars($_POST['user_stafid'], ENT_QUOTES),1) . "&bulan=" . htmlspecialchars($_GET['bulan'], ENT_QUOTES) . "&msg=edit";
				  
				  sys_prorec('hr', 'user_salary', $row_user['user_stafid'], '3', 'id=' . htmlspecialchars($_POST['usersalary_id'], ENT_QUOTES));
				  
		} else {
			$updateGoTo .= "?id=" . getID(htmlspecialchars($_POST['user_stafid'], ENT_QUOTES),1) . "&bulan=" . htmlspecialchars($_GET['bulan'], ENT_QUOTES) . "&msg=error";
		};
		
	} else {
		$updateGoTo .= "?id=" . getID(htmlspecialchars($_POST['user_stafid'], ENT_QUOTES),1) . "&bulan=" . htmlspecialchars($_GET['bulan'], ENT_QUOTES) . "&msg=passev";
	};
	
} else {
	$updateGoTo .= "?id=" . getID(htmlspecialchars($_POST['user_stafid'], ENT_QUOTES),1) . "&bulan=" . htmlspecialchars($_GET['bulan'], ENT_QUOTES) . "&eul=1";
};

header(sprintf("Location: %s", $updateGoTo));
?>
