<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php /*?><?php include('../sb/email.php');?><?php */?>
<?php

$insertGoTo = $url_main . "property.php?id=" . getID(htmlspecialchars($row_user['user_stafid'], ENT_QUOTES));
if ((isset($_POST["MM_insert"])) && (isset($_POST['noproperty'])!=1) && ($_POST["MM_insert"] == "formproperty")) {		
	  $insertSQL = sprintf("INSERT INTO user_property (userproperty_by, userproperty_date_d,userproperty_date_m, userproperty_date_y, user_stafid, property_id, userproperty_detail, owner_id, userproperty_address1, userproperty_address2, userproperty_address3, userproperty_poscode, userproperty_city, state_id, userproperty_regno, userproperty_owned_date, userproperty_quantity, userproperty_amount, source_id, userproperty_instituteloan, userproperty_totalloan, userproperty_monthlyloan, userproperty_start_date, userproperty_end_date, userproperty_durationloan, userproperty_note) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString(date('d'), "text"),
						   GetSQLValueString(date('m'), "text"),
						   GetSQLValueString(date('Y'), "text"),
				           GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString($_POST['type'], "int"),
						   GetSQLValueString($_POST['userproperty_detail'], "text"),
						   GetSQLValueString($_POST['owner'], "int"),
						   GetSQLValueString($_POST['userproperty_address1'], "text"),
						   GetSQLValueString($_POST['userproperty_address2'], "text"),
						   GetSQLValueString($_POST['userproperty_address3'], "text"),
						   GetSQLValueString($_POST['userproperty_poscode'], "text"),
						   GetSQLValueString($_POST['userproperty_city'], "text"),
						   GetSQLValueString($_POST['state_id'], "int"),
						   GetSQLValueString($_POST['userproperty_regno'], "text"),
						   GetSQLValueString($_POST['userproperty_owned_date'], "text"),
						   GetSQLValueString($_POST['userproperty_quantity'], "text"),
						   GetSQLValueString($_POST['userproperty_amount'], "text"),
						   GetSQLValueString($_POST['source'], "int"),
						   GetSQLValueString($_POST['userproperty_instituteloan'], "text"),
						   GetSQLValueString($_POST['userproperty_totalloan'], "text"),
						   GetSQLValueString($_POST['userproperty_monthlyloan'], "text"),
						   GetSQLValueString($_POST['userproperty_start_date'], "text"),
						   GetSQLValueString($_POST['userproperty_end_date'], "text"),
						   GetSQLValueString($_POST['userproperty_durationloan'], "text"),
						   GetSQLValueString($_POST['userproperty_note'], "text"));
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	  
	  $insertGoTo .= "&msg=add";
	  }
	  
	  elseif(isset($_POST['noproperty'])==1)
	  {
	  $insertSQL = sprintf("INSERT INTO user_property (userproperty_by, userproperty_date_d, userproperty_date_m, userproperty_date_y, user_stafid, userproperty_noproperty) VALUES (%s, %s, %s, %s,%s, %s)",
	  GetSQLValueString($row_user['user_stafid'], "text"),
	  GetSQLValueString(date('d'), "text"),
	  GetSQLValueString(date('m'), "text"),
	  GetSQLValueString(date('Y'), "text"),
	  GetSQLValueString($row_user['user_stafid'], "text"),
	  GetSQLValueString($_POST['noproperty'], "int"));
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	  
	  // $emailto = array();
//	   $emailto[] = htmlspecialchars($row_user['user_stafid'], ENT_QUOTES); // array emailstafid[0] = Staf ID yg memohon
//		
	   $userpropertyid = getUserPropertyID($row_user['user_stafid'],date('d'), date('m'), date('Y'));
//		
		sys_prorec('hr', 'user_property', $row_user['user_stafid'], '2', 'id=' . $userpropertyid);
//		
//		emailPropertyAdd($emailto, 0, 0, 1, $userpropertyid);
	  
	  $insertGoTo .= "&msg=add";
	  }else {
		  $insertGoTo .= "&msg=error";
		  };
		  
		  header(sprintf("Location: %s", $insertGoTo));
?>