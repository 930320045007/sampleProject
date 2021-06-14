<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/selidikdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/selidikfunc.php');?>
<?php
$updateGoTo = $url_main . "qna/surveydetail.php?id=" . htmlspecialchars($_POST['sd_id'], ENT_QUOTES);

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1"))
{
  $updateSQL = sprintf("UPDATE surveydetail SET sd_by=%s, sd_date_d=%s, sd_date_m=%s, sd_date_y=%s, sd_date_h=%s, sd_title=%s, sd_desc=%s, group_id=%s, division_id=%s, sd_end_d=%s, sd_end_m=%s, sd_end_y=%s, sd_view=%s WHERE sd_id=%s",
                       GetSQLValueString($row_user['user_stafid'], "text"),
                       GetSQLValueString($_POST['sd_date_d'], "text"),
                       GetSQLValueString($_POST['sd_date_m'], "text"),
                       GetSQLValueString($_POST['sd_date_y'], "text"),
                       GetSQLValueString(date('h:i:s A'), "text"),
                       GetSQLValueString($_POST['sd_title'], "text"),
                       GetSQLValueString($_POST['sd_desc'], "text"),
                       GetSQLValueString($_POST['group_id'], "int"),
                       GetSQLValueString($_POST['division_id'], "int"),
                       GetSQLValueString($_POST['sd_end_d'], "text"),
                       GetSQLValueString($_POST['sd_end_m'], "text"),
                       GetSQLValueString($_POST['sd_end_y'], "text"),
                       GetSQLValueString($_POST['sd_view'], "int"),
                       GetSQLValueString($_POST['sd_id'], "int"));

  mysql_select_db($database_selidikdb, $selidikdb);
  $Result1 = mysql_query($updateSQL, $selidikdb) or die(mysql_error());

  $updateGoTo .= "&msg=edit";
  
} else {
	$updateGoTo .= "&msg=error";
};

header(sprintf("Location: %s", $updateGoTo));
?>