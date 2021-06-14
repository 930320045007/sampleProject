<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php /*include('../sb/email.php')*/;?>
<?php
$GoTo = $url_main . "ict/report.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "reportsymptom")) 
{
	if(checkTotalReportPerDayByUserID($row_user['user_stafid']))
	{
		if(!checkReportTodayByUserID($row_user['user_stafid'], $_POST['reportsymptom_id']))
		{
			  $insertSQL = sprintf("INSERT INTO ict.user_report (user_stafid, userreport_date_d, userreport_date_m, userreport_date_y, userreport_time, reportsymptom_id, userreport_result) VALUES (%s, %s, %s, %s, %s, %s, %s)",
								   GetSQLValueString($row_user['user_stafid'], "text"),
								   GetSQLValueString(date('d'), "text"),
								   GetSQLValueString(date('m'), "text"),
								   GetSQLValueString(date('Y'), "text"),
								   GetSQLValueString(date('h:i:s A'), "text"),
								   GetSQLValueString($_POST['reportsymptom_id'], "int"),
								   GetSQLValueString($_POST['userreport_result'], "int"));
			
			  mysql_select_db($database_hrmsdb, $hrmsdb);
			  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
			  
			  if($_POST['userreport_result']==0) // 0 - panduan tidak membantu
			  {				  
				$emailto = array();
				$emailto[] = $row_user['user_stafid']; // array emailstafid[0] = Staf ID yg memohon
				$emailto = array_merge($emailto,getUserIDSysAcc(6, 28));//ICT yg ada kelulusan Modul
				
				//emailAduanBaruICT($emailto, 0, 0, 1, getUserReportIDByUserID($row_user['user_stafid'], $_POST['reportsymptom_id'], date('d'), date('m'), date('Y')));
			  };
			
			  $GoTo .= "?msg=add";
			  
		} else {
	  		$GoTo .= "?ea=3";
		};
		
	} else {
	  $GoTo .= "?ea=1";
	};
	
} else {
	$GoTo .= "?msg=error";
};

header(sprintf("Location: %s", $GoTo));
?>
