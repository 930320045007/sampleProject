<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/skt.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sktfunc.php');?>
<?php
$insertGoTo = $url_main . "admin/pp.php?id=" . htmlspecialchars($_POST['user_stafid'], ENT_QUOTES);

if(checkUserSysAcc($row_user['user_stafid'], 5, 62, 2))
{
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) 
	{
		if((getStatusTFByStafID($_POST['pp_ppp']) && $_POST['pp_ppp']!=$_POST['user_stafid']) && getStatusTFByStafID($_POST['pp_ppk']) && $_POST['pp_ppk']!=$_POST['user_stafid'])
		{
			if(getPP($_POST['user_stafid']))
			{
					  $insertSQL = sprintf("UPDATE skt.pp SET pp_by=%s, pp_date_d=%s, pp_date_m=%s, pp_date_y=%s, pp_ppp=%s, pp_ppk=%s WHERE user_stafid=%s",
										   GetSQLValueString($row_user['user_stafid'], "text"),
										   GetSQLValueString(date('d'), "text"),
										   GetSQLValueString(date('m'), "text"),
										   GetSQLValueString(date('Y'), "text"),
										   GetSQLValueString($_POST['pp_ppp'], "text"),
										   GetSQLValueString($_POST['pp_ppk'], "text"), 
										   GetSQLValueString($_POST['user_stafid'], "text"));
					  
					  $insertGoTo .= "&msg=add";
			} else {
					  $insertSQL = sprintf("INSERT INTO pp (pp_by, pp_date_d, pp_date_m, pp_date_y, user_stafid, pp_ppp, pp_ppk) VALUES (%s, %s, %s, %s, %s, %s, %s)",
										   GetSQLValueString($row_user['user_stafid'], "text"),
										   GetSQLValueString(date('d'), "text"),
										   GetSQLValueString(date('m'), "text"),
										   GetSQLValueString(date('Y'), "text"),
										   GetSQLValueString($_POST['user_stafid'], "text"),
										   GetSQLValueString($_POST['pp_ppp'], "text"),
										   GetSQLValueString($_POST['pp_ppk'], "text"));
					  
					  $insertGoTo .= "&msg=edit";
			};
					
			  mysql_select_db($database_skt, $skt);
			  $Result1 = mysql_query($insertSQL, $skt) or die(mysql_error());
			  
		} else {
			$insertGoTo .= "&eskt=1";
		};
		
	} else {
		$insertGoTo .= "&msg=error";
	};
	
} else {
	$insertGoTo .= "$eul=1";
};

header(sprintf("Location: %s", $insertGoTo));
?>