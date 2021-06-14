<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php
$insertGoTo = $url_main . "admin/kew8.php";

if(checkUserSysAcc($row_user['user_stafid'], 5, 37, 2))
{
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formuserkewe")) 
	{
	  $insertSQL = sprintf("INSERT INTO user_kewe (userkewe_by, userkewe_date_d, userkewe_date_m, userkewe_date_y, userkewe_date_h, userkewe_siri, userkewe_start_d, userkewe_start_m, userkewe_start_y, userkewe_end_d, userkewe_end_m, userkewe_end_y, user_stafid, kewe_id, userkewe_content, userkewe_salary, userkewe_imbuhan,userkewe_salaryskill, userkewe_note, userkewe_ref, userkewe_refdate, userkewe_refdatekewe, userkewe_pelulus, userkewe_jawatan,userkewe_pelulus2, userkewe_jawatan2, userkewe_gred_memangku) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString(substr($_POST['userkewe_signdate'], 8,2), "text"), //day
						   GetSQLValueString(substr($_POST['userkewe_signdate'], 5,2), "text"), //month
						   GetSQLValueString(substr($_POST['userkewe_signdate'], 0,4), "text"), //year
						   GetSQLValueString(date('h:i A'), "text"),
						   GetSQLValueString($_POST['userkewe_siri'], "int"),
						   GetSQLValueString($_POST['userkewe_start_d'], "text"),
						   GetSQLValueString($_POST['userkewe_start_m'], "text"),
						   GetSQLValueString($_POST['userkewe_start_y'], "text"),
						   GetSQLValueString($_POST['userkewe_end_d'], "text"),
						   GetSQLValueString($_POST['userkewe_end_m'], "text"),
						   GetSQLValueString($_POST['userkewe_end_y'], "text"),
						   GetSQLValueString($_POST['user_stafid'], "text"),
						   GetSQLValueString($_POST['kewe_id'], "int"),
						   GetSQLValueString($_POST['userkewe_content'], "text"),
						   GetSQLValueString($_POST['userkewe_salary'], "text"),
						   GetSQLValueString($_POST['userkewe_imbuhan'], "text"),
						   GetSQLValueString($_POST['userkewe_salaryskill'], "text"),
						   GetSQLValueString($_POST['userkewe_note'], "text"),
						   GetSQLValueString($_POST['userkewe_ref'], "text"),
						   GetSQLValueString($_POST['userkewe_refdate'], "text"),
						   GetSQLValueString($_POST['userkewe_refdatekewe'], "text"),
						   GetSQLValueString($_POST['userkewe_pelulus'], "text"),
						   GetSQLValueString($_POST['userkewe_jawatan'], "text"),
						   GetSQLValueString($_POST['userkewe_pelulus2'], "text"),
						   GetSQLValueString($_POST['userkewe_jawatan2'], "text"),
						   GetSQLValueString($_POST['userkewe_gred_memangku'], "text"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	  
	  $insertGoTo = $url_main . "admin/kew8detail.php?id=" . getID(getKew8IDByUserID($_POST['user_stafid'], $_POST['userkewe_siri'], date('d'), date('m'), date('Y'))) . "&msg=add";
	  
	} else {
		$insertGoTo .= "?msg=error";
	};
	
} else {
  $insertGoTo .= "?eul=1";
};

header(sprintf("Location: %s", $insertGoTo));
?>