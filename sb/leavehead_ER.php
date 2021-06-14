<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../sb/email.php');?>
<?php

$deleteGoTo = htmlspecialchars($_POST['url'], ENT_QUOTES);
	
if(isset($_SESSION['user_stafid']) && $_POST['kl']==getPassKey(getPassOldByUserID($row_user['user_stafid']),'2'))
{
				  
		$emailto = array(); // array StafID penerima email
		$emailto[] = $row_user['user_stafid']; // array emailstafid[0] = pemohon no fail
		
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$query_entry = "SELECT user_sysacc.* FROM user_sysacc WHERE usersysacc_status='1' AND submenu_id = '23'";
		$entry = mysql_query($query_entry, $hrmsdb) or die(mysql_error());
		$row_entry = mysql_fetch_assoc($entry);
		$totalRows_entry = mysql_num_rows($entry);
		
		do {
			$emailto[] = $row_entry['user_stafid']; // array emailstafid[1] = Staf ID mendaftar
		} while ($row_entry = mysql_fetch_assoc($entry));
		
		emailALERApproval($emailto, $row_user['user_stafid'], 0, 2, 0);
		
		$deleteGoTo .= "?msg=send";	
		
} else {
		$deleteGoTo .= "?msg=passev";
}

header(sprintf("Location: %s", $deleteGoTo));
?>