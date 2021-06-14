<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/mbjdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/mbjfunc.php');?>
<?php /*include('../sb/email.php')*/;?>
<?php

$insertGoTo = $url_main . "mbj/reportdetail.php";

if(checkLimitReport($row_user['user_stafid'], date('d'), date('m'), date('Y')))
{
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "aduanform")) 
	{
		if($_POST['category_id']!=0 && $_POST['userreport_note']!=NULL)
		{
			  $insertSQL = sprintf("INSERT INTO mbj.user_report (user_stafid,userreport_date_d, userreport_date_m, userreport_date_y, userreport_time,category_id,userreport_note) VALUES (%s,%s,%s,%s,%s,%s,%s)",
							       GetSQLValueString($row_user['user_stafid'], "text"),
								   GetSQLValueString(date('d'), "text"),
								   GetSQLValueString(date('m'), "text"),
								   GetSQLValueString(date('Y'), "text"),
								   GetSQLValueString(date('h:i:s A'), "text"),
								   GetSQLValueString($_POST['category_id'], "int"),
			                       GetSQLValueString($_POST['userreport_note'],"text"));
								   
			   mysql_select_db($database_mbjdb, $mbjdb);
			  $Result1 = mysql_query($insertSQL, $mbjdb) or die(mysql_error());
			 		
					  
				$emailto = array();
				$emailto[] = $row_user['user_stafid']; // array emailstafid[0] = Staf ID yg memohon
				$emailto = array_merge($emailto,getUserIDSysAcc(22, 111));//ICT yg ada kelulusan Modul
				
			/* emailAduanBaruMBJ($emailto, 0, 0, 1, getReportID($_POST['category_id'], $row_user['user_stafid'], date('d'), date('m'), date('Y')));
*/
			
			$insertGoTo = $url_main . "mbj/reportdetail.php?id=" . getReportID($_POST['category_id'], $row_user['user_stafid'], date('d'), date('m'), date('Y')) . "&msg=add";
	
		} else {
			$insertGoTo = $url_main . "mbj/report.php?msg=error";
		}
	} else {
		$insertGoTo = $url_main . "mbj/report.php?msg=error";
	};
} else {
	$insertGoTo = $url_main . "mbj/report.php?eh=2";
};

header(sprintf("Location: %s", $insertGoTo));

?>
			 
			  