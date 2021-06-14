<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('email.php');?>
<?php
  $updateGoTo = $url_main . "property.php";
  
if(checkUserByPropertyID($row_user['user_stafid'],$_POST['userproperty_id']))
{
	 $updateSQL = sprintf("UPDATE user_property SET userproperty_by=%s, userproperty_date_d=%s,userproperty_date_m=%s, userproperty_date_y=%s, user_stafid=%s, property_id=%s, userproperty_detail=%s, owner_id=%s, userproperty_address1=%s, userproperty_address2=%s, userproperty_address3=%s, userproperty_poscode=%s, userproperty_city=%s, state_id=%s, userproperty_regno=%s, userproperty_owned_date=%s, userproperty_quantity=%s, userproperty_amount=%s, source_id=%s, userproperty_instituteloan=%s, userproperty_totalloan=%s, userproperty_monthlyloan=%s, userproperty_start_date=%s, userproperty_end_date=%s, userproperty_durationloan=%s, userproperty_note=%s WHERE userproperty_id=%s",
					   GetSQLValueString($row_user['user_stafid'], "text"),
					   GetSQLValueString(date('d'), "text"),
					   GetSQLValueString(date('m'), "text"),
					   GetSQLValueString(date('Y'), "text"),
					   GetSQLValueString($row_user['user_stafid'], "text"),
					   GetSQLValueString($_POST['propertytype_id'], "int"),
					   GetSQLValueString($_POST['userproperty_detail'], "text"),
					   GetSQLValueString($_POST['owner_id'], "int"),
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
					   GetSQLValueString($_POST['source_id'], "int"),
					   GetSQLValueString($_POST['userproperty_instituteloan'], "text"),
					   GetSQLValueString($_POST['userproperty_totalloan'], "text"),
					   GetSQLValueString($_POST['userproperty_monthlyloan'], "text"),
					   GetSQLValueString($_POST['userproperty_start_date'], "text"),
					   GetSQLValueString($_POST['userproperty_end_date'], "text"),
					   GetSQLValueString($_POST['userproperty_durationloan'], "text"),
					   GetSQLValueString($_POST['userproperty_note'], "text"),
					   GetSQLValueString($_POST['userproperty_id'], "int"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
	  
	  $emailto = array();
	  
	  $emailto[] = htmlspecialchars($_POST['user_stafid'], ENT_QUOTES); // array emailstafid[0] = Staf ID yg memohon
	  
	  $userpropertyid = getUserPropertyID($row_user['user_stafid'],date('d'), date('m'), date('Y'));
	  
	  sys_prorec('hr', 'user_property', $row_user['user_stafid'], '3', 'id=' . $userpropertyid);
	  
	  emailPropertyEdit($emailto, 0, 0, 1, $userpropertyid);
	
	  $updateGoTo .= "?msg=edit";
		  
  } else {
	  $updateGoTo .= "?msg=error";
  };
	
  header(sprintf("Location: %s", $updateGoTo));
 ?>