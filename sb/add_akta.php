<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/aktadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php  
$insertGoTo = $url_main . "head/akta.php";
if(checkUserSysAcc($row_user['user_stafid'], 14, 47, 2)){
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
	if($_POST['apsumberurl']=="http://")
		$surl = NULL;
	else
		$surl = htmlspecialchars($_POST['apsumberurl'], ENT_QUOTES);
		
  $insertSQL = sprintf("INSERT INTO ap (ap_date_d, ap_date_m, ap_date_y, ap_date_h, ap_by, ap_title, ap_note, ap_year, category_id, ap_sumber, apsumberurl) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString(date('d'), "text"),
                       GetSQLValueString(date('m'), "text"),
                       GetSQLValueString(date('Y'), "text"),
                       GetSQLValueString(date('h:i:s A'), "text"),
                       GetSQLValueString($row_user['user_stafid'], "text"),
                       GetSQLValueString($_POST['ap_title'], "text"),
                       GetSQLValueString($_POST['ap_note'], "text"),
                       GetSQLValueString($_POST['ap_year'], "text"),
                       GetSQLValueString($_POST['category_id'], "int"),
                       GetSQLValueString($_POST['ap_sumber'], "text"),
                       GetSQLValueString($surl, "text"));

  mysql_select_db($database_aktadb, $aktadb);
  $Result1 = mysql_query($insertSQL, $aktadb) or die(mysql_error());
  
  $insertGoTo .= "?msg=add";
}
}
header(sprintf("Location: %s", $insertGoTo));
?>