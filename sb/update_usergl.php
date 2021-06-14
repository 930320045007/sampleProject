<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php
$insertGoTo = $url_main . "admin/gl.php";

if(checkUserSysAcc($row_user['user_stafid'], 5, 117, 2))
{
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formusergl"))
	{
	  $insertSQL = sprintf("UPDATE www.user_gl SET usergl_by=%s, usergl_start_d=%s, usergl_start_m=%s, usergl_start_y=%s, usergl_end_d=%s, usergl_end_m=%s, usergl_end_y=%s, relationship_id=%s, usergl_name=%s, usergl_ic=%s, usergl_hospital=%s, usergl_salary=%s, usergl_salaryskill=%s, usergl_pejabat=%s, usergl_ref=%s, usergl_refdate=%s, usergl_ketua=%s, usergl_jawatan=%s, usergl_ketuaphone=%s WHERE usergl_id=%s",
						   GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString($_POST['usergl_start_d'], "text"),
						   GetSQLValueString($_POST['usergl_start_m'], "text"),
						   GetSQLValueString($_POST['usergl_start_y'], "text"),
						   GetSQLValueString($_POST['usergl_end_d'], "text"),
						   GetSQLValueString($_POST['usergl_end_m'], "text"),
						   GetSQLValueString($_POST['usergl_end_y'], "text"),
						   GetSQLValueString($_POST['relationship_id'], "int"),
						   GetSQLValueString($_POST['usergl_name'], "text"),
						   GetSQLValueString($_POST['usergl_ic'], "text"),
						   GetSQLValueString($_POST['usergl_hospital'], "text"),
						   GetSQLValueString($_POST['usergl_salary'], "text"),
						   GetSQLValueString($_POST['usergl_salaryskill'], "text"),
						   GetSQLValueString($_POST['usergl_pejabat'], "text"),
						   GetSQLValueString($_POST['usergl_ref'], "text"),
						   GetSQLValueString($_POST['usergl_refdate'], "text"),
						   GetSQLValueString($_POST['usergl_ketua'], "text"), 
						   GetSQLValueString($_POST['usergl_jawatan'], "text"), 
						   GetSQLValueString($_POST['usergl_ketuaphone'], "text"),
						   GetSQLValueString($_POST['usergl_id'], "int"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	  
	  $insertGoTo .= "?id=" . getID(htmlspecialchars($_POST['usergl_id'], ENT_QUOTES),1) . "&msg=edit";
	} else {
		$insertGoTo .= "?id=" . getID(htmlspecialchars($_POST['usergl_id'], ENT_QUOTES),1) . "&msg=error";
	};
	
} else {
  $insertGoTo = "?id=" . getID(htmlspecialchars($_POST['usergl_id'], ENT_QUOTES),1) . "&eul=1";
};

header(sprintf("Location: %s", $insertGoTo));
?>
