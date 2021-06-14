<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php
$insertGoTo = $url_main . "admin/gl.php";

if(checkUserSysAcc($row_user['user_stafid'], 5, 117, 2))
{
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formusergl")) 
	{
	  $insertSQL = sprintf("INSERT INTO user_gl (usergl_by, usergl_date_d, usergl_date_m, usergl_date_y, usergl_date_h, usergl_siri, usergl_start_d, usergl_start_m, usergl_start_y, usergl_end_d, usergl_end_m, usergl_end_y, user_stafid, relationship_id, usergl_name, usergl_ic, usergl_hospital, usergl_salary, usergl_salaryskill, usergl_pejabat, usergl_ref, usergl_refdate, usergl_ketua, usergl_jawatan, usergl_ketuaphone) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString(date('d'), "text"),
						   GetSQLValueString(date('m'), "text"),
						   GetSQLValueString(date('Y'), "text"),
						   GetSQLValueString(date('h:i A'), "text"),
						   GetSQLValueString($_POST['usergl_siri'], "int"),
						   GetSQLValueString($_POST['usergl_start_d'], "text"),
						   GetSQLValueString($_POST['usergl_start_m'], "text"),
						   GetSQLValueString($_POST['usergl_start_y'], "text"),
						   GetSQLValueString($_POST['usergl_end_d'], "text"),
						   GetSQLValueString($_POST['usergl_end_m'], "text"),
						   GetSQLValueString($_POST['usergl_end_y'], "text"),
						   GetSQLValueString($_POST['user_stafid'], "text"),
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
						   GetSQLValueString($_POST['usergl_ketuaphone'], "text"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	  
	  $insertGoTo = $url_main . "admin/gldetail.php?id=" . getID(getGLIDByUserID($_POST['user_stafid'], $_POST['usergl_siri'], date('d'), date('m'), date('Y'))) . "&msg=add";
	  
	} else {
		$insertGoTo .= "?msg=error";
	};
	
} else {
  $insertGoTo .= "?eul=1";
};

header(sprintf("Location: %s", $insertGoTo));
?>