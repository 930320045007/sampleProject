<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>

<?php
$insertGoTo = $url_main . "admin/salary.php";

if(checkUserSysAcc($row_user['user_stafid'], 5, 34, 2) && $row_user['user_stafid']!=$_POST['user_stafid'])
{
	if(!checkTransactionByUseriD($_POST['user_stafid'], $_POST['transaction_id'], $_POST['usersalary_date_d'], $_POST['usersalary_date_m'], $_POST['usersalary_date_y']))
	{
	$insertSQL = sprintf("INSERT INTO www.user_salary (usersalary_date_d, usersalary_date_m, usersalary_date_y, usersalary_by, usersalary_end_d, usersalary_end_m, usersalary_end_y, usersalary_end_by, usersalary_end_date, user_stafid, usersalary_kew8, usersalary_ref, transaction_id, usersalary_value) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						 GetSQLValueString($_POST['usersalary_date_d'], "text"),
						 GetSQLValueString($_POST['usersalary_date_m'], "text"),
						 GetSQLValueString($_POST['usersalary_date_y'], "text"),
						 GetSQLValueString($row_user['user_stafid'], "text"),
						 GetSQLValueString($_POST['usersalary_end_d'], "text"),
						 GetSQLValueString($_POST['usersalary_end_m'], "text"),
						 GetSQLValueString($_POST['usersalary_end_y'], "text"),
						 GetSQLValueString($row_user['user_stafid'], "text"),
						 GetSQLValueString(date('d/m/Y h:i A'), "text"),
						 GetSQLValueString($_POST['user_stafid'], "text"),
						 GetSQLValueString($_POST['usersalary_kew8'], "text"),
						 GetSQLValueString($_POST['usersalary_ref'], "text"),
						 GetSQLValueString($_POST['transaction_id'], "int"),
						 GetSQLValueString($_POST['usersalary_value'], "text"));
  
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
		
		$insertGoTo .= "?id=" . getID(htmlspecialchars($_POST['user_stafid'], ENT_QUOTES),1) . "&msg=add";
	
		$emailto = array();
		$emailto[] = htmlspecialchars($_POST['user_stafid'], ENT_QUOTES); // array emailstafid[0] = Staf ID yg memohon
		
		$usersalaryid = getUserSalaryIDByUserID($_POST['user_stafid'], $_POST['transaction_id'], $_POST['usersalary_date_d'], $_POST['usersalary_date_m'], $_POST['usersalary_date_y']);
		
		sys_prorec('hr', 'user_salary', $row_user['user_stafid'], '2', 'id=' . $usersalaryid);
		
		mail ($emailto, 0, 0, 1, $usersalaryid);
		
		$insertGoTo .= "?id=" . getID($_POST['user_stafid'],1) . "&bulan=" . htmlspecialchars($_POST['usersalary_date_m'], ENT_QUOTES) . "/" . htmlspecialchars($_POST['usersalary_date_y'], ENT_QUOTES) . "&msg=add";
		
	} else {
		$insertGoTo .= "?id=" . getID(htmlspecialchars($_POST['user_stafid'], ENT_QUOTES),1) . "&es=1";
	};
} else {
	$insertGoTo .= "?eul=1";
}
header(sprintf("Location: %s", $insertGoTo));
?>
