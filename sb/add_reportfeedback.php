<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php /*include('../sb/email.php');*/?>
<?php
$GoTo = $url_main . "ict/reportadmindetail.php?id=" . htmlspecialchars($_POST['userreport_id'], ENT_QUOTES);

if(checkUserSysAcc($row_user['user_stafid'], 6, 28, 2) && !checkFeedbackEndByUserReportID($_POST['userreport_id']))
{
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "reportfeedback")) 
	{
		  if(isset($_POST['urf_stafid']))
		  	$stafidz = $_POST['urf_stafid'];
		  else
		  	$stafidz = 0;
			
		  if(isset($_POST['urf_pembekalan']))
		  	$pembekalan = htmlspecialchars($_POST['urf_pembekalan'], ENT_QUOTES);
		  else
		  	$pembekalan = 0;
			
		  $insertSQL = sprintf("INSERT INTO ict.user_reportfeedback (urf_by, urf_date_d, urf_date_m, urf_date_y, urf_date_h, userreport_id, feedbacktype_id, urf_stafid, urf_note, urf_pembekalan) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
							   GetSQLValueString($row_user['user_stafid'], "text"),
							   GetSQLValueString(date('d'), "text"),
							   GetSQLValueString(date('m'), "text"),
							   GetSQLValueString(date('Y'), "text"),
							   GetSQLValueString(date('h:i:s A'), "text"),
							   GetSQLValueString($_POST['userreport_id'], "text"),
							   GetSQLValueString($_POST['feedbacktype_id'], "text"),
							   GetSQLValueString($stafidz, "text"),
							   GetSQLValueString($_POST['urf_note'], "text"),
							   GetSQLValueString($pembekalan, "int"));
		
		  mysql_select_db($database_hrmsdb, $hrmsdb);
		  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
		  
		  if($_POST['feedbacktype_id']!=0 && $stafidz!='0')
		  {  // email untuk perhatian StafID
			$emailtoAct = array();
			$emailtoAct[] = htmlspecialchars($_POST['urf_stafid'], ENT_QUOTES); // array emailstafid[0] = Staf ID yg memohon
			
			emailFeedbackICTAction($emailtoAct, 0, 0, 1, $_POST['userreport_id']);
		  }
		  
		  if($_POST['feedbacktype_id']==0)
		  { // 0 = feedback Tamat
			$emailto = array();
			$emailto[] = getUserReportByReportID($_POST['userreport_id']); // array emailstafid[0] = Staf ID yg memohon
			$emailto = array_merge($emailto,getUserIDSysAcc(6, 28));//ICT yg ada kelulusan Modul
			
			//emailFeedbackICT($emailto, 0, 0, 1, $_POST['userreport_id']);
		  }
		
		  $GoTo .= "&msg=edit";
	} else {
		$GoTo .= "&msg=error";
	};
	
} else {
	$GoTo .= "&eul=1";
};

header(sprintf("Location: %s", $GoTo));
?>
