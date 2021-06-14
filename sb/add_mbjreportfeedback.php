<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/mbjdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/mbjfunc.php');?>
<?php /*include('../sb/email.php');*/?>
<?php
$GoTo = $url_main . "mbj/reportdetail_admin.php?id=" . htmlspecialchars($_POST['userreport_id'], ENT_QUOTES);

if(checkUserSysAcc($row_user['user_stafid'], 23, 114, 2) && !checkFeedbackEndByUserReportID($_POST['userreport_id']))
{
	
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "reportfeedback")) 
	{
	
		  $insertSQL = sprintf("INSERT INTO mbj.user_reportfeedback (urf_by, urf_date_d, urf_date_m, urf_date_y, urf_date_h, userreport_id, feedbacktype_id, reporttype_id, urf_note) VALUES (%s, %s, %s, %s, %s, %s, %s, %s,%s)",
							   GetSQLValueString($row_user['user_stafid'], "text"),
							   GetSQLValueString(date('d'), "text"),
							   GetSQLValueString(date('m'), "text"),
							   GetSQLValueString(date('Y'), "text"),
							   GetSQLValueString(date('h:i:s A'), "text"),
							   GetSQLValueString($_POST['userreport_id'], "text"),
							   GetSQLValueString($_POST['fbtid'], "int"),
							   GetSQLValueString($_POST['rtid'], "int"),
							   GetSQLValueString($_POST['urf_note'], "text"));
							   
		
		  mysql_select_db($database_hrmsdb, $hrmsdb);
		  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
		  
		  
		  if($_POST['fbtid']==0)
		  { // 0 = feedback Tamat
			$emailto = array();
			$emailto[] = getReportByByID($_POST['userreport_id']); // array emailstafid[0] = Staf ID yg buat aduan
			$emailto = array_merge($emailto,getUserIDSysAcc(23, 114));//ICT yg ada kelulusan Modul
			
			/*emailFeedbackMBJ($emailto, 0, 0, 1, $_POST['userreport_id']);*/
		  };
		
		  $GoTo .= "&msg=edit";
	};
	
} else {
	$GoTo .= "&eul=1";
};

header(sprintf("Location: %s", $GoTo));
?>
