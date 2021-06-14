<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
if (!$leaveform) 
{
	$listday = $_POST['listday']; // array
	echo $listday;
	foreach($listday as $key => $value)
	{
		list($daysend, $monthsend) = explode("/", $value);
		// 1. semakkan sama ada cuti bertindih atau tidak bagi tahun semasa
		// 2. semakkan baki cuti rehat bg tahun semasa
		if(isset($_POST['user_stafid'], $daysend, $monthsend))
		{			
			$insertSQL = sprintf("INSERT INTO pergerakan (pergerakan_stafid, pergerakan_by, pergerakan_day, pergerakan_month, pergerakan_year, pergerakan_location) VALUES (%s, %s, %s, %s, %s, %s)",
										GetSQLValueString($_POST['user_stafid'], "text"),
										GetSQLValueString($row_user['user_stafid'], "text"),
										GetSQLValueString($daysend, "text"),
									   GetSQLValueString($monthsend, "text"),
									   GetSQLValueString(date('Y'), "text"),
									   GetSQLValueString($_POST['pergerakan_lokasi'], "text"));
				
			mysql_select_db($database_hrmsdb, $hrmsdb);
			$Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
		};
	};
} else {
	$insertGoTo .= "?el=8";
};

$insertGoTo = $_SERVER['HTTP_REFERER'] . "?bulan=".$monthsend."/".date('Y');
header(sprintf("Location: %s", $insertGoTo));
?>