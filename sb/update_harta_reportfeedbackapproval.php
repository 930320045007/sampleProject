<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/hartadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/hartafunc.php');?>
<?php
$updateGoTo = $url_main . "harta/reportdetail.php?id=" . $_POST['userreport_id'];

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formfeedback"))
{
	if(checkFeedbackEnd($_POST['userreport_id'])){
	  $updateSQL = sprintf("UPDATE harta.user_report SET userreport_star=%s, userreport_starby=%s, userreport_stardate=%s WHERE userreport_id=%s",
			 GetSQLValueString($_POST['star'], "int"),
			 GetSQLValueString($row_user['user_stafid'], "text"),
			 GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
			 GetSQLValueString($_POST['userreport_id'], "int"));
	  
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
	
	  $updateGoTo .= "&msg=edit";
	} else {
	  $updateGoTo .= "&eh=1";
	};
	
} else {
	  $updateGoTo .= "&msg=error";
};

header(sprintf("Location: %s", $updateGoTo));
?>