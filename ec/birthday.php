<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ekad.php'); ?>
<?php include('../inc/func.php');?>
<?php include('../inc/ekadfunc.php');?>
<?php include('../sb/email.php');?>
<?php 
	
	$sql_where = " login.login_status = '1' AND user.user_dob_d = '" . date('d') . "' AND user.user_dob_m = '" . date('m') . "'";
	mysql_select_db($database_hrmsdb, $hrmsdb);
	$query_staf = sqlAllStaf($sql_where);
	$staf = mysql_query($query_staf, $hrmsdb) or die(mysql_error());
	$row_staf = mysql_fetch_assoc($staf);
	
	$total = mysql_num_rows($staf);
	
	if($total > 0)
	{
		do {
			$ucapan = "Selamat Ulang Tahun Kelahiran yang ke-" . getAgeByUserID($row_staf['user_stafid']);
		
			$message = getCardDesign('11', getFullNameByStafID($row_staf['user_stafid']), $ucapan, '0');	
			
			if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
			{
				$ep = '"' . getFullNameByStafID($row_staf['user_stafid']) . '" <' . getEmailISNByUserID($row_staf['user_stafid']) . '>'; 
					
				//server SMTP tak mengizinkan host lain untuk menjadi from header. pakai isn header.
				$headers["From"] = $systitle_short . ' <support@isn.gov.my>'; 
				$headers["To"] = $ep;
				$headers["MIME-Version"] = "1.0";
				$headers["Content-Type"] = "text/html; charset=ISO-8859-1";
				$headers["Subject"] = "Selamat Ulang Tahun Kelahiran"; 
				
				if(getStatusTFByStafID($row_staf['user_stafid']))
				{ 
					$smtp = emailset();
					$mail = $smtp->send($ep, $headers, $message);
				}
			}
		} while($row_staf = mysql_fetch_assoc($staf));
	}
	
	mysql_free_result($staf);
?>