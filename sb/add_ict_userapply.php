<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php include('../sb/email.php');?>
<?php
$insertGoTo = $url_main . "ict/apply.php";

if (getJob2ID($row_user['user_stafid'])!=0)
{
	if (count($_POST['stafid'])!= 0 )
	{
		if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "alat")) 
		{
		  $insertSQL = sprintf("INSERT INTO user_apply (userapply_by, userapply_date_d, userapply_date_m, userapply_date_y, dir_id, userapply_note) VALUES (%s,%s, %s, %s, %s, %s)",
							   GetSQLValueString($row_user['user_stafid'], "text"),
							   GetSQLValueString(date('d'), "text"),
							   GetSQLValueString(date('m'), "text"),
							   GetSQLValueString(date('Y'), "text"),
							   GetSQLValueString(getDirIDByUser($row_user['user_stafid']), "int"),
							   GetSQLValueString($_POST['userapply_note'], "text"));
		
		  mysql_select_db($database_ictdb, $ictdb);
		  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
			
		  //Untuk memasukkan maklumat dalam table user_applyitem
		  
		  $applyid = getApplyIDByStaffID($row_user['user_stafid'],date('d'),date('m'),date('Y'));
		  
		  foreach($_POST['stafid'] AS $key => $value)
		  {
			   $insertSQL2 = sprintf("INSERT INTO user_applyitem (userapply_id, user_stafid, reqtype_id, subcategory_id) VALUES (%s,%s,%s, %s)",
								   GetSQLValueString($applyid, "int"),
								   GetSQLValueString($value, "text"),
								   GetSQLValueString($_POST['jenis'][$key], "int"),
								   GetSQLValueString($_POST['item'][$key], "int"));
			
			  mysql_select_db($database_ictdb, $ictdb);
			  $Result2 = mysql_query($insertSQL2, $ictdb) or die(mysql_error());  
			  
		  };
		  
		  $insertGoTo = $url_main . "ict/applydetail.php?id=" . $applyid . "&msg=add";
	
		  $emailto = array();
		  $emailto[] = $row_user['user_stafid']; // array emailstafid[0] = Staf ID yg memohon
		  $emailto = array_merge($emailto,getUserIDSysAcc(6, 69));
		  
		  emailPermohonanPeralatanICT($emailto, 0, 0, 1, $applyid); 
		  
		} else {  
		  $insertGoTo .= "?msg=error";
		};
		
	}else {
		 $insertGoTo .= "?eia=1";
	};
	
} else {
	 $insertGoTo .= "?eia=2";
};

header(sprintf("Location: %s", $insertGoTo));
?>