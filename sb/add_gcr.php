<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
if(isset($_POST['url']) && $_POST['url']==1)
	$insertGoTo = $url_main . "admin/staffleavedetail.php";
else
	$insertGoTo = $url_main . "leave/permenant.php";
  
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formgcr2")) 
{
	
	if(getDesignationType($_POST['user_stafid']))
	{

		$thisyearGCR = countTotalGCR($_POST['user_stafid'])+$_POST['uspgcr_total']; 
		
		// semakkan jumalah yg ditambah tidak melebih limit		
		if(($_POST['uspgcr_total'] <= countGCRPLCLimit($_POST['user_stafid'],$_POST['uspgcr_date_y']) && $thisyearGCR <= getGCRLimit()) || checkUserSysAcc($row_user['user_stafid'], 5, 23, 1))
		{ 
			// semakkan Jumlah Hari tidak melebihi separuh dari cuti tahunan atau dimasukkan oleh HR
			$totalday = htmlspecialchars($_POST['uspgcr_total'], ENT_QUOTES);
		  	$insertGoTo2 = $insertGoTo . "?id=" . getUserIDByStafID($_POST['user_stafid']) . "&msg=add";
			
		} else if($thisyearGCR > getGCRLimit()) {
			
			$totalday = $_POST['uspgcr_total']-($thisyearGCR-getGCRLimit());
			$insertGoTo2 = $insertGoTo . "?id=" . getUserIDByStafID($_POST['user_stafid']) . "&ep=2&balance=" . $totalday;
			
		} else {
			
	  		$totalday = countGCRPLCLimit($_POST['user_stafid'],$_POST['uspgcr_date_y']); // jika lebih, hanya jumlah baki cuti yg ada akan dikira
		  	$insertGoTo2 = $insertGoTo . "?id=" . getUserIDByStafID($_POST['user_stafid']) . "&ep=4&balance=" . $totalday;
		};
		
		if($totalday!=0)
		{	
		  $insertSQL = sprintf("INSERT INTO user_gcr (uspgcr_by, uspgcr_date, user_stafid, uspgcr_date_y, uspgcr_total) VALUES (%s, %s, %s, %s, %s)",
							   GetSQLValueString($row_user['user_stafid'], "text"),
							   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
							   GetSQLValueString($_POST['user_stafid'], "text"),
							   GetSQLValueString($_POST['uspgcr_date_y'], "text"),
							   GetSQLValueString($totalday, "int"));
		
		  mysql_select_db($database_hrmsdb, $hrmsdb);
		  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
		  
		} else {
	  		$insertGoTo2 = $insertGoTo . "?id=" . getUserIDByStafID($_POST['user_stafid']) . "&ep=4";
		}
		
	} else {
  		$insertGoTo2 = $insertGoTo . "?id=" . getUserIDByStafID($_POST['user_stafid']) . "&ep=1";
	}
}

  header(sprintf("Location: %s", $insertGoTo2));
?>