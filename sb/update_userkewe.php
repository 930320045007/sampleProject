<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php
$insertGoTo = $url_main . "admin/kew8.php";

if(checkUserSysAcc($row_user['user_stafid'], 5, 37, 2))
{
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formuserkewe"))
	{
	  $insertSQL = sprintf("UPDATE www.user_kewe SET userkewe_by=%s,userkewe_date_d=%s, userkewe_date_m=%s, userkewe_date_y=%s, userkewe_start_d=%s, userkewe_start_m=%s, userkewe_start_y=%s, userkewe_end_d=%s, userkewe_end_m=%s, userkewe_end_y=%s, kewe_id=%s, userkewe_content=%s, userkewe_salary=%s, userkewe_imbuhan=%s, userkewe_salaryskill=%s, userkewe_note=%s, userkewe_ref=%s, userkewe_refdate=%s, userkewe_refdatekewe=%s, userkewe_pelulus=%s, userkewe_jawatan=%s, userkewe_pelulus2=%s, userkewe_jawatan2=%s, userkewe_gred_memangku=%s WHERE userkewe_id=%s",
						   GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString(substr($_POST['userkewe_signdate'], 8,2), "text"), //day
						   GetSQLValueString(substr($_POST['userkewe_signdate'], 5,2), "text"), //month
						   GetSQLValueString(substr($_POST['userkewe_signdate'], 0,4), "text"), //year
						   GetSQLValueString($_POST['userkewe_start_d'], "text"),
						   GetSQLValueString($_POST['userkewe_start_m'], "text"),
						   GetSQLValueString($_POST['userkewe_start_y'], "text"),
						   GetSQLValueString($_POST['userkewe_end_d'], "text"),
						   GetSQLValueString($_POST['userkewe_end_m'], "text"),
						   GetSQLValueString($_POST['userkewe_end_y'], "text"),
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
						   GetSQLValueString($_POST['userkewe_gred_memangku'], "text"),
						   GetSQLValueString($_POST['userkewe_id'], "int"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	  
	  $insertGoTo .= "?id=" . getID(htmlspecialchars($_POST['userkewe_id'], ENT_QUOTES),1) . "&msg=edit";
	} else {
		$insertGoTo .= "?id=" . getID(htmlspecialchars($_POST['userkewe_id'], ENT_QUOTES),1) . "&msg=error";
	};
	
} else {
  $insertGoTo = "?id=" . getID(htmlspecialchars($_POST['userkewe_id'], ENT_QUOTES),1) . "&eul=1";
};

header(sprintf("Location: %s", $insertGoTo));
?>
