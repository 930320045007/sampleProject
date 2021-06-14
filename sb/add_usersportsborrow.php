<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/sportsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sportsfunc.php');?>
<?php include('../sb/email.php');?>
<?php
$insertGoTo = $url_main . "sports/record.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "alat")) 
{
	
	$total = count($_POST['subcatk']);
	$dmy = explode('/', htmlspecialchars($_POST['dmy'], ENT_QUOTES));
	
	if($total>0)
	{
		
		if(($dmy[0]>=date('d') && $dmy[1]== date('m') && $dmy[2]== date('Y')) || ($dmy[1]> date('m') && $dmy[2]=date('Y')) || ($dmy[2]>date('Y')))
		{
			// semakkan tarikh pinjaman 
			
			if(getTotalUserBorrowByDate($_POST['user_stafid'], $dmy[0], $dmy[1], $dmy[2])<=3)
			{
				// semakkan pinjaman pada tarikh tidak melebihi 3 kali
			  $insertSQL = sprintf("INSERT INTO user_borrow (userborrow_by, userborrow_date, user_stafid, userborrow_title, userborrow_date_d, userborrow_date_m, userborrow_date_y, userborrow_duration, durationtype_id, userborrow_time_h, userborrow_time_m, userborrow_time_ap, userborrow_location, userborrow_note, userborrow_type) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
								   GetSQLValueString($row_user['user_stafid'], "text"),
								   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
								   GetSQLValueString($_POST['user_stafid'], "text"),
								   GetSQLValueString($_POST['userborrow_title'], "text"),
								   GetSQLValueString($dmy[0], "text"),
								   GetSQLValueString($dmy[1], "text"),
								   GetSQLValueString($dmy[2], "text"),
								   GetSQLValueString($_POST['userborrow_duration'], "int"),
								   GetSQLValueString($_POST['durationtype_id'], "int"),
								   GetSQLValueString($_POST['userborrow_time_h'], "text"),
								   GetSQLValueString($_POST['userborrow_time_m'], "text"),
								   GetSQLValueString($_POST['userborrow_time_ap'], "text"),
								   GetSQLValueString($_POST['userborrow_location'], "text"),
								   GetSQLValueString($_POST['userborrow_note'], "text"),
								   GetSQLValueString($_POST['userborrow_type'], "int"));
			
			  mysql_select_db($database_sportsdb, $sportsdb);
			  $Result1 = mysql_query($insertSQL, $sportsdb) or die(mysql_error());
			  
			  foreach($_POST['subcatk'] AS $key => $value)
			  {
				  if($value != 0)
				  {
					  for($i=1; $i<=$value; $i++)
					  {
						  $insertSQL = sprintf("INSERT INTO item_borrow (user_stafid, userborrow_id, userborrow_type, subcategory_id) VALUES (%s, %s, %s, %s)",
											   GetSQLValueString($_POST['user_stafid'], "text"),
											   GetSQLValueString(getUserBorrowIDByUserID($_POST['user_stafid'], $dmy[0], $dmy[1], $dmy[2]), "int"),
											   GetSQLValueString('2', "int"),
											   GetSQLValueString($_POST['subcat'][$key], "text"));
						
						  mysql_select_db($database_sportsdb, $sportsdb);
						  $Result1 = mysql_query($insertSQL, $sportsdb) or die(mysql_error());
					  };
				  };
			  };
			  
			  $borrowid = getUserBorrowIDByUserID($_POST['user_stafid'], $dmy[0], $dmy[1], $dmy[2]);
						  
			  $emailto = array();
			  $emailto[] = $_POST['user_stafid']; // array emailstafid[0] = Staf ID yg memohon
			  $emailto = array_merge($emailto,getUserIDSysAcc(19, 103));//Sains Sukan yg ada kelulusan Modul
			  
			  emailPinjamanBaruSportsSains($emailto, 0, 0, 1, $borrowid);

  			$insertGoTo  = $url_main . "sports/recorddetail.php?id=" . getID($borrowid) . "&msg=add";
			
			} else {
  				$insertGoTo .= "?eib=3";
			};
			
		} else {
  			$insertGoTo .= "?eib=2";
		};
		
	} else {
  		$insertGoTo .= "?eib=1";
	};
	
} else {
	$insertGoTo .= "?msg=error";
};

header(sprintf("Location: %s", $insertGoTo));
?>