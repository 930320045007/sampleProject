<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/func.php');?>
<?php include('../sb/email.php');?>
<?php

$insertGoTo = $url_main;
	
if (isset($_POST["MM_insert_formKL"]) && $_POST["MM_insert_formKL"] == "formKL") 
{
	$emailv = htmlspecialchars($_POST['isnmail'], ENT_QUOTES) . "@msn.gov.my";
	$emailvx = htmlspecialchars($_POST['isnmail'], ENT_QUOTES);

	$stafidemail = getStafIDByEmailLike($emailvx);
	// if(checkEmailValid($stafidemail, $emailvx))
	if($stafidemail!='' and $emailvx!='')

	{
		if(!checkPassDateFail($stafidemail))
		{
			$insertSQL = sprintf("INSERT INTO fail (fail_date_d, fail_date_m, fail_date_y, user_stafid) VALUES (%s, %s, %s, %s)",
								  GetSQLValueString(date('d'), "text"),
								  GetSQLValueString(date('m'), "text"),
								 GetSQLValueString(date('Y'), "text"),
								 GetSQLValueString($stafidemail, "text"));
		  
			mysql_select_db($database_hrmsdb, $hrmsdb);
			$Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
			
			$emailto = array(); // array StafID penerima email
			$emailto[] = $stafidemail; // array emailstafid[0] = pemohon no fail
					
			emailFailKatalaluan($emailto, 0, 0, 1, $stafidemail);
			
			$insertGoTo .= "?ef=1";
			
		} else {
			$insertGoTo .= "fail.php?ef=3";
		};
		
	} else {
		$insertGoTo .= "fail.php?ef=2";
	};
	
} else {
	$insertGoTo .= "fail.php?msg=error";
};
	
header(sprintf("Location: %s", $insertGoTo));
?>