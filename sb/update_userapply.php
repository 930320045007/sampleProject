<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php include('../sb/email.php');?>
<?php
$deleteGoTo = $url_main . "ict/applyadmindetail.php?id=" . htmlspecialchars($_POST['applyid'], ENT_QUOTES);

if(checkUserSysAcc($row_user['user_stafid'], 6, 69, 3))
{

	foreach ($_POST['id'] as $key => $value)
	{
		$deleteSQL = sprintf("UPDATE ict.user_applyitem SET applystatus_id=%s, ict_by=%s, ict_date=%s, ict_note=%s WHERE uai_id=%s",
							 GetSQLValueString($_POST['ict_status'][$key], "text"),
							 GetSQLValueString($row_user['user_stafid'], "text"),
							 GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
							 GetSQLValueString($_POST['ict_note'][$key], "text"),
							 GetSQLValueString($value, "int"));
	  
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$Result1 = mysql_query($deleteSQL, $hrmsdb) or die(mysql_error());	
	};

	$deleteSQL1 = sprintf("UPDATE ict.user_apply SET ict_status=%s, ict_by=%s, ict_date_d=%s, ict_date_m=%s, ict_date_y=%s WHERE userapply_id=%s",
						 GetSQLValueString(1, "int"),
						 GetSQLValueString($row_user['user_stafid'], "text"),
						 GetSQLValueString(date('d h:i:s A'), "text"),
						 GetSQLValueString(date('m h:i:s A'), "text"),
						 GetSQLValueString(date('Y h:i:s A'), "text"),
						 GetSQLValueString($_POST['applyid'], "int"));
  
	mysql_select_db($database_hrmsdb, $hrmsdb);
	$Result1 = mysql_query($deleteSQL1, $hrmsdb) or die(mysql_error());
	
	$emailto = array();
	$emailto[] = getStafIDByApplyID(htmlspecialchars($_POST['applyid'], ENT_QUOTES)); // array emailstafid[0] = Staf ID yg memohon
	
	emailKelulusanPermohonanICT($emailto, 0, 0, 1, htmlspecialchars($_POST['applyid'], ENT_QUOTES)); 
  
  $deleteGoTo .= "&msg=edit";
  
} else {
	$deleteGoTo .= "&eul=1";
};

header(sprintf("Location: %s", $deleteGoTo));
?>