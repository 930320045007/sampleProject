<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
if(isset($_POST['url']) && $_POST['url']==1)
	$insertGoTo = $url_main . "admin/staffleavedetail.php";
else
	$insertGoTo = $url_main . "leave/permenant.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formplc2")) 
{
	if(getDesignationType($_POST['user_stafid']))
	{
		
		if($_POST['usplc_total']<=countLeaveBalance($_POST['user_stafid'],$_POST['usplc_date_y']) || checkUserSysAcc($row_user['user_stafid'], 5, 23, 1))
		{ 
			// semakkan PLC yang melebihi dari jumlah baki cuti atau dimasukkan oleh HR
			$usplctotal = $_POST['usplc_total'];
		  	$insertGoTo2 = $insertGoTo . "?id=" . getUserIDByStafID(htmlspecialchars($_POST['user_stafid'], ENT_QUOTES)) . "&msg=add";
			
		} else {
	  		$usplctotal = countLeaveBalance(htmlspecialchars($_POST['user_stafid'], ENT_QUOTES),htmlspecialchars($_POST['user_stafid'], ENT_QUOTES)); // jika lebih, maka baki cuti akan diambil
		  	$insertGoTo2 = $insertGoTo . "?id=" . getUserIDByStafID(htmlspecialchars($_POST['user_stafid'], ENT_QUOTES)) . "&ep=3&balance=" . $usplctotal;
		};
		
		if($usplctotal != 0)
		{			
			$insertSQL = sprintf("INSERT INTO user_plc (usplc_by, usplc_date, user_stafid, usplc_date_y, usplc_total) VALUES (%s, %s, %s, %s, %s)",
								 GetSQLValueString($row_user['user_stafid'], "text"),
								 GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
								 GetSQLValueString($_POST['user_stafid'], "text"),
								 GetSQLValueString($_POST['usplc_date_y'], "text"),
								 GetSQLValueString($usplctotal, "int"));
		  
			mysql_select_db($database_hrmsdb, $hrmsdb);
			$Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
			
		} else {
	  		$insertGoTo2 = $insertGoTo . "?id=" . getUserIDByStafID($_POST['user_stafid']) . "&ep=4";
		};
		
	} else {
	  $insertGoTo2 = $insertGoTo . "?id=" . getUserIDByStafID($_POST['user_stafid']) . "&ep=1";
	};
	
} else {
	$insertGoTo2 = $insertGoTo . "?id=" . getUserIDByStafID($_POST['user_stafid']) . "&msg=error";
};
	
header(sprintf("Location: %s", $insertGoTo2));
?>