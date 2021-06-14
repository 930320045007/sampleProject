<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/skt.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$insertGoTo = $url_main . "skt/index.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1"))
{
	if($_POST['uskt_masa_mula']<=$_POST['uskt_masa_tamat'])
	{
		if($_POST['uskt_aktiviti']!=NULL)
		{
			if($_POST['uskt_kuantiti_sk'] != NULL || $_POST['uskt_masa_sk'] != NULL || $_POST['uskt_kualiti_sk'] != NULL)
			{
			  $insertSQL = sprintf("INSERT INTO user_skt (uskt_by, uskt_date_d, uskt_date_m, uskt_date_y, user_stafid, uskt_aktiviti, uskt_kuantiti, uskt_kuantiti_sk, uskt_masa, uskt_masa_sk, uskt_masa_mula, uskt_masa_tamat, uskt_kualiti, uskt_kualiti_sk, uskt_kos, uskt_kos_sk, uskt_lain, uskt_lain_sk) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
								   GetSQLValueString($row_user['user_stafid'], "text"),
								   GetSQLValueString(date('d'), "text"),
								   GetSQLValueString(date('m'), "text"),
								   GetSQLValueString(date('Y'), "text"),
								   GetSQLValueString($row_user['user_stafid'], "text"),
								   GetSQLValueString($_POST['uskt_aktiviti'], "text"),
								   GetSQLValueString($_POST['uskt_kuantiti'], "text"),
								   GetSQLValueString($_POST['uskt_kuantiti_sk'], "text"),
								   GetSQLValueString($_POST['uskt_masa'], "text"),
								   GetSQLValueString($_POST['uskt_masa_sk'], "text"),
								   GetSQLValueString($_POST['uskt_masa_mula'], "text"),
								   GetSQLValueString($_POST['uskt_masa_tamat'], "text"),
								   GetSQLValueString($_POST['uskt_kualiti'], "text"),
								   GetSQLValueString($_POST['uskt_kualiti_sk'], "text"),
								   GetSQLValueString($_POST['uskt_kos'], "text"),
								   GetSQLValueString($_POST['uskt_kos_sk'], "text"),
								   GetSQLValueString($_POST['uskt_lain'], "text"),
								   GetSQLValueString($_POST['uskt_lain_sk'], "text"));
			
			  mysql_select_db($database_skt, $skt);
			  $Result1 = mysql_query($insertSQL, $skt) or die(mysql_error());
			
			  $insertGoTo .= "?msg=add";
			  
			} else {
				$insertGoTo .= "?eskt=5";
			};
			
		} else {
			$insertGoTo .= "?eskt=4";
		};
		
	} else {
		$insertGoTo .= "?eskt=3";
	};
	
} else {
	$insertGoTo .= "?msg=error";
};

header(sprintf("Location: %s", $insertGoTo));
?>