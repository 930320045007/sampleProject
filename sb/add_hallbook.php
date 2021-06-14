<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php include('../sb/email.php');?>
<?php
$insertGoTo = $url_main . "tadbir/index.php";

if((isset($_POST['hallbook']) && $_POST['hallbook']!=NULL) && (isset($_POST['hallbook_name']) && $_POST['hallbook_name']!=NULL))
{
		if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "tarikh"))
		{
			$id = array(); // simpan Booking ID utk email
			
			foreach($_POST['hallbook'] AS $key => $value)
			{
				$hallbook = explode("/", htmlspecialchars($value, ENT_QUOTES));
					
				$morning = 0;
				$noon = 0;
				$night = 0;
				
				if($hallbook[3]==1 && !checkHallByDate($hallbook[0], $hallbook[1], $hallbook[2], $_POST['hall_id'], 1, 0, 0))
					$morning = 1;
				else if($hallbook[3]==2 && !checkHallByDate($hallbook[0], $hallbook[1], $hallbook[2], $_POST['hall_id'], 0, 1, 0))
					$noon = 1;
				else if($hallbook[3]==3 && !checkHallByDate($hallbook[0], $hallbook[1], $hallbook[2], $_POST['hall_id'], 0, 0, 1))
					$night = 1;
			
				  $insertSQL = sprintf("INSERT INTO tadbir.hall_book (hallbook_date_d, hallbook_date_m, hallbook_date_y, hallbook_date_h, user_stafid, hall_id, hallbook_start_d, hallbook_start_m, hallbook_start_y, hallbook_morning, hallbook_noon, hallbook_night, hallbook_name, hallbook_detail) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
									  GetSQLValueString(date('d'), "text"),
									  GetSQLValueString(date('m'), "text"),
									  GetSQLValueString(date('Y'), "text"),
									  GetSQLValueString(date('h:i:s A'), "text"),
									  GetSQLValueString($row_user['user_stafid'], "text"),
									   GetSQLValueString($_POST['hall_id'], "int"),
									   GetSQLValueString($hallbook[0], "text"),
									   GetSQLValueString($hallbook[1], "text"),
									   GetSQLValueString($hallbook[2], "text"),
									   GetSQLValueString($morning, "text"),
									   GetSQLValueString($noon, "text"),
									   GetSQLValueString($night, "text"),
									   GetSQLValueString($_POST['hallbook_name'], "text"),
									   GetSQLValueString($_POST['hallbook_detail'], "text"));
				
				  mysql_select_db($database_tadbirdb, $tadbirdb);
				  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());
				  
				  $id[] = getBookingID($row_user['user_stafid'], $_POST['hall_id'], $hallbook[0], $hallbook[1], $hallbook[2], $morning, $noon, $night);
			}
				  
				  $emailto = array();
				  $emailto[] = $row_user['user_stafid']; // array emailstafid[0] = Staf ID yg memohon
				  $emailto = array_merge($emailto,getUserIDSysAcc(10, 40)); //Pentadbiran yg ada kelulusan Modul
				  
				  emailHallBook($emailto, 0, 0, 1, $id);
		
		  $insertGoTo .= "?hall=" . htmlspecialchars($_POST['hall_id'], ENT_QUOTES) . "&bulan=" . $hallbook[1] . "%2F" . $hallbook[2] . "&msg=add";
		}
} else {
  $insertGoTo .= "?msg=error";
}
header(sprintf("Location: %s", $insertGoTo));
?>