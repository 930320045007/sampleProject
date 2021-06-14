<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php include('../sb/email.php');?>
<?php
	// Email kpd ICT utk aduan yang tidak diselesaikan dalam tempoh 7 hari
	cronemailICTReportFeedbackByDate(0, 0, 0, 1, 0); 

	mysql_select_db($database_hrmsdb, $hrmsdb);
	$query_app = "SELECT user_report.* FROM ict.user_report WHERE userreport_star = 0 AND userreport_status = 1 AND userreport_result = 0 AND EXISTS (SELECT * FROM ict.user_reportfeedback WHERE urf_status = 1 AND feedbacktype_id = 0 AND user_reportfeedback.userreport_id = user_report.userreport_id)";
	$app = mysql_query($query_app, $hrmsdb) or die(mysql_error());
	$row_app = mysql_fetch_assoc($app);
	$total2 = mysql_num_rows($app);
	
	if($total2 > 0) {
		do {
			if(!checkFeedbackApprovalByUserReportID($row_app['userreport_id'])){
				
				//kiraan hari bagi kes diselesaikan
				$day = ((mktime(0, 0, 0, date('m'), date('d'), date('Y')) - mktime(0, 0, 0, getFeedbackEndDateByUserReportID($row_app['userreport_id'], 2), getFeedbackEndDateByUserReportID($row_app['userreport_id'], 1), getFeedbackEndDateByUserReportID($row_app['userreport_id'], 3)))/86400);
				
				if((($day % 7) == 0) && $day > 0)
				{
					//semak sama ada kes telah selesai dan kes belum disahkan
					if(checkFeedbackEndByUserReportID($row_app['userreport_id']) && !checkFeedbackApprovalByUserReportID($row_app['userreport_id']))
					{
						// Staf ID yang membuat aduan tp masih tak approve
						$emailto2 = $row_app['user_stafid']; 
						cronemailICTReportFeedbackApprovalByDate($emailto2, 0, 0, 1, $row_app['userreport_id']);
					}
				}
			}
		} while($row_app = mysql_fetch_assoc($app));
	}
	
	mysql_free_result($app);
?>