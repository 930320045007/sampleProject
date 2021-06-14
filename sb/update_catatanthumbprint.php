<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$updateGoTo = $url_main . "admin/stafleaveindv.php?id=" . getStaffBySoyalID($_POST['soyal_id']); 

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "hrnote")) {
	 $updateSQL = sprintf("INSERT INTO www.leave_note (soyal_id, leavenote_date_d, leavenote_date_m, leavenote_date_y, leave_hrnote) VALUES (%s, %s, %s, %s, %s)", 
	 GetSQLValueString($_POST['soyal_id'], "int"),
	 GetSQLValueString(date('d'), "text"),
	 GetSQLValueString(date('m'), "text"),
	 GetSQLValueString(date('Y'), "text"),
	 GetSQLValueString($_POST['leave_hrnote'], "int"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
		$Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
			
		$updateGoTo .= "&msg=add";
	} else {
		$updateGoTo .= "&msg=error";
	};
 header(sprintf("Location: %s", $updateGoTo));
?>
