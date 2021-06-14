<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/hartadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/hartafunc.php');?>
<?php /*include('../sb/email.php');*/?>
<?php
$insertGoTo = $url_main . "harta/index.php";

if(checkLimitReport($row_user['user_stafid'], date('d'), date('m'), date('Y')))
{
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "aduanform")) 
	{
		if($_POST['rc_id']!=0 && $_POST['userreport_location']!=NULL)
		{
		  $insertSQL = sprintf("INSERT INTO harta.user_report (user_stafid, userreport_date_d, userreport_date_m, userreport_date_y, userreport_date_h, userreport_ticket, rc_id, userreport_location) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
							   GetSQLValueString($row_user['user_stafid'], "text"),
							   GetSQLValueString(date('d'), "text"),
							   GetSQLValueString(date('m'), "text"),
							   GetSQLValueString(date('Y'), "text"),
							   GetSQLValueString(date('h:i:s A'), "text"),
							   GetSQLValueString(getNewReportTicketByRCID($_POST['rc_id']), "int"),
							   GetSQLValueString($_POST['rc_id'], "int"),
							   GetSQLValueString($_POST['userreport_location'], "text"));
		
		  mysql_select_db($database_hartadb, $hartadb);
		  $Result1 = mysql_query($insertSQL, $hartadb) or die(mysql_error());
					  
		  $emailto = array();
		  $emailto[] = $row_user['user_stafid']; // array emailstafid[0] = Staf ID yg memohon
		  $emailto = array_merge($emailto,getUserIDSysAcc(12, 45));//ICT yg ada kelulusan Modul
		  
		 /* emailAduanBaruHarta($emailto, 0, 0, 1, getReportID($_POST['rc_id'], $row_user['user_stafid'], date('d'), date('m'), date('Y')));
	*/
			$insertGoTo = $url_main . "harta/reportdetail.php?id=" . getReportID($_POST['rc_id'], $row_user['user_stafid'], date('d'), date('m'), date('Y')) . "&msg=add";
		} else {
			$insertGoTo = $url_main . "harta/index.php?msg=error";
		}
	} else {
		$insertGoTo = $url_main . "harta/index.php?msg=error";
	};
} else {
	$insertGoTo = $url_main . "harta/index.php?eh=2";
};
header(sprintf("Location: %s", $insertGoTo));
?>