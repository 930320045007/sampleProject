<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php include('../sb/email.php');?>
<?php
$status = 0; 
 
 $_SESSION['stafidt'] = NULL;
  unset($_SESSION['stafidt']);
  
   $_SESSION['from'] = NULL;
  unset($_SESSION['from']);
  
  $_SESSION['to'] = NULL;
  unset($_SESSION['to']);
  
  $_SESSION['dated'] = NULL;
  unset($_SESSION['dated']);
  
  $_SESSION['datem'] = NULL;
  unset($_SESSION['datem']);
  
  $_SESSION['datey'] = NULL;
  unset($_SESSION['datey']);
  
  $_SESSION['time'] = NULL;
  unset($_SESSION['time']);
  
$insertGoTo = $url_main . "tadbir/transport.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") && isset($_POST['passenger']) && count($_POST['passenger'])>0 && isset($_POST['tfrom']) && count($_POST['tfrom'])>0)
{		
		
  $insertSQL = sprintf("INSERT INTO transport_book (transbook_date_d, transbook_date_m, transbook_date_y, transbook_by, transbook_title, transbook_ref, transbook_notrans, transbook_note) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                    
					   GetSQLValueString(date('d'), "text"),
					   GetSQLValueString(date('m'), "text"),
					   GetSQLValueString(date('Y'), "text"),
					   GetSQLValueString($row_user['user_stafid'], "text"),
                       GetSQLValueString($_POST['transbook_title'], "text"),
                       GetSQLValueString($_POST['transbook_ref'], "text"),
                       GetSQLValueString($_POST['transbook_notrans'], "text"),
                       GetSQLValueString($_POST['transbook_note'], "text"));
					   
  mysql_select_db($database_tadbirdb, $tadbirdb);
  $Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());
  
  $status = 1;
  $transbookID = getTransbookID($row_user['user_stafid'], date('d'), date('m'), date('Y'));

if(isset($_POST['passenger']) && count($_POST['passenger'])!=0)
{
	foreach($_POST['passenger'] AS $key => $value)
	{
	  $insertSQL2 = sprintf("INSERT INTO passenger (transbook_id, user_stafid) VALUES (%s, %s)",
						   GetSQLValueString($transbookID, "int"),
						   GetSQLValueString($value, "text"));
	
	  mysql_select_db($database_tadbirdb, $tadbirdb);
	  $Result2 = mysql_query($insertSQL2, $tadbirdb) or die(mysql_error());
	  
	  $status = 1;
	}
}

if(isset($_POST['tfrom']) && count($_POST['tfrom'])!=0)
{
	foreach($_POST['tfrom'] AS $key => $value)
	{
		list($hour, $minit) = explode(":", $_POST['th'][$key], 2);
		
	  $insertSQL3 = sprintf("INSERT INTO journey (transbook_id, journey_from, journey_to, journey_date_d, journey_date_m, journey_date_y, journey_time_h, journey_time_m) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($transbookID, "int"),
						   GetSQLValueString($value, "text"),
						   GetSQLValueString($_POST['tto'][$key], "text"),
						   GetSQLValueString($_POST['td'][$key], "int"),
						   GetSQLValueString($_POST['tm'][$key], "int"),
						   GetSQLValueString($_POST['ty'][$key], "int"),
						   GetSQLValueString($hour, "int"),
						   GetSQLValueString($minit, "int"));
	
	  mysql_select_db($database_tadbirdb, $tadbirdb);
	  $Result3 = mysql_query($insertSQL3, $tadbirdb) or die(mysql_error());
	  
	  $status = 1;
	}
}

if($status == 1)
	$insertGoTo = $url_main . "tadbir/transportdetail.php?id=" . $transbookID . "&msg=add";
 else 
	$insertGoTo = $url_main . "tadbir/transport.php?msg=error";

if($status == 1)
{
	$emailto = array(); // array StafID penerima email
	$emailto[] = $_POST['user_stafid']; // array emailstafid[0] = pemohon no fail
	
	$emailto = array_merge($emailto,getUserIDSysAcc(10, 81)); // Pentadbiran yg ada kelulusan Modul
	
	emailPermohonanKenderaan($emailto, 0, 0, 1, $transbookID);
};

} else {
		$insertGoTo = $url_main . "tadbir/transport.php?msg=error";
};
	
  header(sprintf("Location: %s", $insertGoTo));
?>