<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include ('../sb/email.php');?>
<?php
$insertGoTo = $url_main . "leave/index.php";

if ((isset($_POST["MM_insert_leavedate"]) && ($_POST["MM_insert_leavedate"] == "formleavedate")) && !$leaveform) 
{
	$listday = $_POST['listday']; // array
	$leaveid = array();
	
	foreach($listday as $key => $value)
	{
		list($daysend, $monthsend, $yearsend) = explode("/", $value);
		
		if(isset($_POST['userleavedate_head']))
			$head = $_POST['userleavedate_head'];
		else
			$head = "";
	
		if(isset($_POST['leavecategory_id']))
			$leavecat = $_POST['leavecategory_id'];
		else if((!checkDatePast(date('Y'), $monthsend, $daysend) || ($monthsend == date('m') && $daysend==date('d'))) && (date('d/m')!=date('d/m', mktime(0, 0, 0, 1, 2, $yearsend))))
			$leavecat = '9'; // 9 = Cuti EL; tiada EL setiap 2hb Januari
		else
			$leavecat = '8'; // 8 = Cuti Rehat / Tahunan
		
		// 1. semakkan sama ada cuti bertindih atau tidak bagi tahun semasa
		// 2. semakkan baki cuti rehat bg tahun semasa
		if(!checkDayLeave($_POST['user_stafid'], 0, $daysend, $monthsend, $yearsend))
		{
			if(countLeaveBalance($_POST['user_stafid'],date('Y'))>0)
			{
				  $insertSQL = sprintf("INSERT INTO user_leavedate (userleavedate_by, userleavedate_date, user_stafid, leavetype_id, userleavedate_date_d, userleavedate_date_m, userleavedate_date_y, userleavedate_name, userleavedate_note, leavecategory_id, userleavedate_head) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
										GetSQLValueString($row_user['user_stafid'], "text"),
										GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
									   GetSQLValueString($_POST['user_stafid'], "text"),
									   GetSQLValueString($_POST['leavetype_id'], "int"),
									   GetSQLValueString($daysend, "text"),
									   GetSQLValueString($monthsend, "text"),
									   GetSQLValueString($yearsend, "text"),
									   GetSQLValueString($_POST['userleavedate_name'], "text"),
									   GetSQLValueString($_POST['userleavedate_note'], "text"),
									   GetSQLValueString($leavecat, "int"),
									   GetSQLValueString($head, "text"));
				
				  mysql_select_db($database_hrmsdb, $hrmsdb);
				  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
				  
				  $leaveid[] = getLeaveID($_POST['user_stafid'], 0, $daysend, $monthsend, $yearsend);
				  
				  $v=1;
			} else {
				$v=2;
			};
			
		} else {
			$v=0;
		};
	};
	
	if($v==1)
	{
		$insertGoTo .= "?msg=add";
	} elseif($v==0) {
		$insertGoTo .= "?el=3";
	} elseif($v==2) {
		$insertGoTo .= "?el=1";
	};
	
	if(count($leaveid)>0)
	{	  
		$emailto = array(); // array StafID penerima email
		$emailto[] = htmlspecialchars($_POST['user_stafid'], ENT_QUOTES); // array emailstafid[0] = pemohon no fail
		
		if(getHeadIDByUserID($_POST['user_stafid'])!=NULL)
		  $emailto[] = getHeadIDByUserID($_POST['user_stafid']); // array emailstafid[1] = Ketua Unit No Fail
		
		emailLeave($emailto, 0, 0, 1, $leaveid);
	};
	
} else {
	$insertGoTo .= "?el=8";
};

header(sprintf("Location: %s", $insertGoTo));
?>