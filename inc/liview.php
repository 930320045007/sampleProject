<?php require_once('../Connections/hrmsdb.php'); ?>
<?
//set IE read from page only not read from cache
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("content-type: application/x-javascript; charset=tis-620");
?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php require_once('../Connections/sportsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php include('../inc/sktfunc.php');?>
<?php include('../inc/ideasfunc.php');?>
<?php include('../inc/sportsfunc.php');?>
<?php
if(isset($_GET['type']) && $_GET['type']=='1') // load scheme
{
	$colname_sch = "-1";
	if (isset($_GET['val'])) {
	  $colname_sch = htmlspecialchars($_GET['val'], ENT_QUOTES);
	}
	mysql_select_db($database_hrmsdb, $hrmsdb);
	$query_sch = sprintf("SELECT * FROM www.scheme WHERE classification_id = %s AND scheme_status = '1' ORDER BY scheme_name ASC", GetSQLValueString($colname_sch, "int"));
	$sch = mysql_query($query_sch, $hrmsdb) or die(mysql_error());
	$row_sch = mysql_fetch_assoc($sch);
	$totalRows_sch = mysql_num_rows($sch);
	
	if($totalRows_sch > 0) {
	echo "<option value=\"0\" disabled=\"disabled\">Pilih Skim</option>";
	do {  
	
	  echo "<option value=\"" . $row_sch['scheme_id'] . "\">" . $row_sch['scheme_name'] . "</option>";
	
	} while ($row_sch = mysql_fetch_assoc($sch));
	  $rows = mysql_num_rows($sch);
	  if($rows > 0) {
		  mysql_data_seek($sch, 0);
		  $row_sch = mysql_fetch_assoc($sch);
	  }
	} else {
		echo "<option value=\"0\" disabled=\"disabled\">Tiada Rekod Skim</option>";
	}
	mysql_free_result($sch);
} else if(isset($_GET['type']) && $_GET['type']=='2') // load gred
{
	$colname_sch = "-1";
	if (isset($_GET['val'])) {
	  $colname_sch = htmlspecialchars($_GET['val'], ENT_QUOTES);
	}
	
	mysql_select_db($database_hrmsdb, $hrmsdb);
	$query_sch = sprintf("SELECT * FROM scheme WHERE scheme_id = %s AND scheme_status = '1' ORDER BY group_id ASC", GetSQLValueString($colname_sch, "int"));
	$sch = mysql_query($query_sch, $hrmsdb) or die(mysql_error());
	$row_sch = mysql_fetch_assoc($sch);
	$totalRows_sch = mysql_num_rows($sch);
	
	if($totalRows_sch > 0)
	{
		$gredarray = explode(',', $row_sch['scheme_gred']);
		
		foreach($gredarray as $value)
		{
			echo "<option value=\"" . $value . "\">" . $value . "</option>";
		}
		
	  	echo "<option value=\"0\">Gred Khas</option>";
		
	} else {
			echo "<option value=\"0\">Tiada rekod dijumpai</option>";
	}
	
	mysql_free_result($sch);
} else if(isset($_GET['type']) && $_GET['type']=='3') // sub menu
{
	$colname_sch = "-1";
	if (isset($_GET['val'])) {
	  $colname_sch = htmlspecialchars($_GET['val'], ENT_QUOTES);
	} 
	
	mysql_select_db($database_hrmsdb, $hrmsdb);
	$query_sch = sprintf("SELECT * FROM submenu WHERE submenu_status = 1 AND menu_id = %s", GetSQLValueString($colname_sch, "int"));
	$sch = mysql_query($query_sch, $hrmsdb) or die(mysql_error());
	$row_sch = mysql_fetch_assoc($sch);
	$totalRows_sch = mysql_num_rows($sch);
	do {  
	
	  echo "<option value=\"" . $row_sch['submenu_id'] . "\">" . $row_sch['submenu_name'] . "</option>";
	
	} while ($row_sch = mysql_fetch_assoc($sch));
	
} else if(isset($_GET['type']) && $_GET['type']=='4') // load gred khas
{
	if (isset($_GET['val']) && $_GET['val']==0) {
		
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$query_sch = "SELECT * FROM gredkhas ORDER BY gredkhas_id ASC";
		$sch = mysql_query($query_sch, $hrmsdb) or die(mysql_error());
		$row_sch = mysql_fetch_assoc($sch);
		
		do {  
		
		  echo "<option value=\"" . $row_sch['gredkhas_id'] . "\">" . $row_sch['gredkhas_name'] . "</option>";
		
		} while ($row_sch = mysql_fetch_assoc($sch));
	} else {
		echo "<option value=\"0\">Tiada</option>";
	}
	
	mysql_free_result($sch);
} else if(isset($_GET['type']) && $_GET['type']=='5') // load sub kategori Modul ICT
{
	if (isset($_GET['val'])) {
		
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$query_sch = "SELECT subcategory.* FROM ict.subcategory WHERE category_id = '" . htmlspecialchars($_GET['val'], ENT_QUOTES) . "' AND subcategory_status = '1' ORDER BY subcategory_name ASC";
		$sch = mysql_query($query_sch, $hrmsdb) or die(mysql_error());
		$row_sch = mysql_fetch_assoc($sch);
		$totalRows_sch = mysql_num_rows($sch);
		
		if($totalRows_sch>0){
			do {  
			
			  echo "<option value=\"" . $row_sch['subcategory_id'] . "\">" . $row_sch['subcategory_name'] . "</option>";
			
			} while ($row_sch = mysql_fetch_assoc($sch));
		} else {
			echo "<option value=\"0\">Tiada</option>";
		}
	} else {
		echo "<option value=\"0\">Tiada</option>";
	}
	
	mysql_free_result($sch);
} else if(isset($_GET['type']) && $_GET['type']=='6') // load kuantiti item yg boleh dipinjam
{
	if (isset($_GET['val'])) {
		
		$total = getTotalItemCanBorrow($_GET['val'], $_GET['vall']);
		
		if($total!=0)
		{
			for($i=1; $i<=$total; $i++)
			{
				  echo "<option value=\"" . $i . "\">" . $i . " Unit </option>";
			}
		} else {
			  echo "<option value=\"0\">Tiada</option>";
		}
	} else {
		echo "<option value=\"0\">Sila Pilih Peralatan</option>";
	}
	
} else if(isset($_GET['type']) && $_GET['type']=='7') // load item yg available dan boleh dipinjam
{
	if (isset($_GET['val'])) {
		
		$query_subcat = "SELECT item.item_id, item.item_isnsiri, item_nosiri, item.brand_id, item.item_model FROM ict.item LEFT JOIN ict.subcategory ON subcategory.subcategory_id = item.subcategory_id WHERE item_borrow = 1 AND item_status = '1' AND item.subcategory_id = '" . htmlspecialchars($_GET['val'], ENT_QUOTES) . "' AND NOT EXISTS (SELECT * FROM ict.item_borrow LEFT JOIN ict.user_borrow ON user_borrow.userborrow_id = item_borrow.userborrow_id WHERE item_borrow.item_id = item.item_id AND item_borrow.itemborrow_status = 1 AND item_borrow.ict_return != 1 AND user_borrow.ict_status != 2) ORDER BY subcategory.subcategory_name ASC";
		$subcat = mysql_query($query_subcat, $ictdb) or die(mysql_error());
		$row_subcat = mysql_fetch_assoc($subcat);
		$total = mysql_num_rows($subcat);
		
		if($total>0){
			do {
				echo "<option value=\"" . $row_subcat['item_id'] . "\">" . getItemISNSiriByID($row_subcat['item_id']) . " &bull; " . getItemBrandNameByID($row_subcat['brand_id']) . " " . $row_subcat['item_model'] . "</option>";
			} while ($row_subcat = mysql_fetch_assoc($subcat));
		} else {
			echo "<option value=\"0\">Sila pilih Kategori</option>";
		}
	} else {
		echo "<option value=\"0\">Sila pilih Kategori</option>";
	}
	
	mysql_free_result($subcat);
} else if(isset($_GET['type']) && $_GET['type']=='8') // load report subtype
{
	if (isset($_GET['val'])) {
		
		$query_subcat = "SELECT report_symptom.reportsubtype_id FROM ict.report_answer LEFT JOIN ict.report_symptom ON report_symptom.reportsymptom_id = report_answer.reportsymptom_id WHERE report_symptom.reporttype_id = '" . htmlspecialchars($_GET['val'], ENT_QUOTES) . "' AND report_answer.reportanswer_status = '1' GROUP BY report_symptom.reportsubtype_id";
		$subcat = mysql_query($query_subcat, $ictdb) or die(mysql_error());
		$row_subcat = mysql_fetch_assoc($subcat);
		$total = mysql_num_rows($subcat);
		
		if($total>0){
			do {
				echo "<option value=\"" . $row_subcat['reportsubtype_id'] . "\">" . getReportSubTypeByID($row_subcat['reportsubtype_id']) . "</option>";
			} while ($row_subcat = mysql_fetch_assoc($subcat));
		}
	} else {
		echo "<option value=\"0\">Tiada</option>";
	}
	
	mysql_free_result($subcat);
} else if(isset($_GET['type']) && $_GET['type']=='9') // load report subtype
{
	if (isset($_GET['val'])) {
		
		$query_subcat = "SELECT report_subtype.reportsubtype_id FROM ict.report_subtype WHERE report_subtype.reporttype_id = '" . htmlspecialchars($_GET['val'], ENT_QUOTES) . "' AND report_subtype.reportsubtype_status = '1'";
		$subcat = mysql_query($query_subcat, $ictdb) or die(mysql_error());
		$row_subcat = mysql_fetch_assoc($subcat);
		$total = mysql_num_rows($subcat);
		
		if($total>0){
			do {
				echo "<option value=\"" . $row_subcat['reportsubtype_id'] . "\">" . getReportSubTypeByID($row_subcat['reportsubtype_id']) . "</option>";
			} while ($row_subcat = mysql_fetch_assoc($subcat));
		}
	} else {
		echo "<option value=\"0\">Tiada</option>";
	}
	
	mysql_free_result($subcat);
} else if(isset($_GET['type']) && $_GET['type']=='10') // load transaksi
{
	if (isset($_GET['val'])) {
		
		$query_subcat = "SELECT * FROM www.transaction WHERE transaction_fixed = 0 AND transaction_status = 1 AND transactiontype_id = '" . htmlspecialchars($_GET['val'], ENT_QUOTES) . "' ORDER BY transaction_name ASC";
		$subcat = mysql_query($query_subcat, $ictdb) or die(mysql_error());
		$row_subcat = mysql_fetch_assoc($subcat);
		$total = mysql_num_rows($subcat);
		
		if($total>0){
			do {
				echo "<option value=\"" . $row_subcat['transaction_id'] . "\">" . $row_subcat['transaction_name'] . "</option>";
			} while ($row_subcat = mysql_fetch_assoc($subcat));
		}
	} else {
		echo "<option value=\"0\">Tiada</option>";
	}
	
	mysql_free_result($subcat);
} else if(isset($_GET['type']) && $_GET['type']=='11') // load senarai ahli ICT
{
	if (isset($_GET['val']) && $_GET['val']!=0)
	{
		echo "<select name=\"urf_stafid\" id=\"urf_stafid\">";
		$stafict = array();
		$stafict = getUserIDSysAcc(6, 28, $row_user['user_stafid']); // Modul ICT > Aduan
		
		echo "<option value=\"0\">Tiada</option>";
		
		if(count($stafict)>0)
		{
			foreach($stafict AS $key => $value)
			{
					echo "<option value=\"" . $value . "\">" . getFullNameByStafID($value) . " (" . $value . ")" . "</option>";
			}
		};
		
	echo "</select>";
		
	} else {
		echo "<select name=\"urf_pembekalan\" id=\"urf_pembekalan\">";
		echo "<option value=\"0\">Tiada</option>";
		echo "<option value=\"1\">Rekod Pembekalan</option>";
		echo "</select>";
	};
} else if(isset($_GET['type']) && $_GET['type']=='12') // load sub kategori Aduan Harta
{
	if (isset($_GET['val']) && $_GET['val']!=0) {
		
		$query_subcat = "SELECT * FROM harta.subcategory WHERE subcategory_status = 1 AND category_id = '" . htmlspecialchars($_GET['val'], ENT_QUOTES) . "' ORDER BY subcategory_name ASC";
		$subcat = mysql_query($query_subcat, $ictdb) or die(mysql_error());
		$row_subcat = mysql_fetch_assoc($subcat);
		$total = mysql_num_rows($subcat);
		
		if($total>0){
			echo "<option value=\"0\">Sila pilih</option>";
			do {
				echo "<option value=\"" . $row_subcat['subcategory_id'] . "\">" . $row_subcat['subcategory_name'] . "</option>";
			} while ($row_subcat = mysql_fetch_assoc($subcat));
		} else {
			echo "<option value=\"0\">Tiada</option>";
		};		
	} else {
		echo "<option value=\"0\">&laquo; Sila Pilih Kategori</option>";
	};
	
	mysql_free_result($subcat);
} else if(isset($_GET['type']) && $_GET['type']=='13') // load sub kategori Aduan Harta
{
	if (isset($_GET['val']) && $_GET['val']!=0) {
		
		$query_subcat = "SELECT * FROM harta.report_case WHERE rc_status = 1 AND subcategory_id = '" . htmlspecialchars($_GET['val'], ENT_QUOTES) . "' ORDER BY rc_id DESC";
		$subcat = mysql_query($query_subcat, $ictdb) or die(mysql_error());
		$row_subcat = mysql_fetch_assoc($subcat);
		$total = mysql_num_rows($subcat);
		
		if($total>0){
			echo "<option value=\"0\">Sila pilih</option>";
			do {
				echo "<option value=\"" . $row_subcat['rc_id'] . "\">" . $row_subcat['rc_title'] . "</option>";
			} while ($row_subcat = mysql_fetch_assoc($subcat));
		} else {
			echo "<option value=\"0\">Tiada</option>";
		};		
	} else {
		echo "<option value=\"0\">Sila Pilih Sub Kategori</option>";
	};
	
	mysql_free_result($subcat);
} else if(isset($_GET['type']) && $_GET['type']=='14') // load senarai ahli Harta
{
	if (isset($_GET['val']) && $_GET['val']!=0) {
		
		$stafict = getUserIDSysAcc(12, 45, $row_user['user_stafid']); // Modul Harta > Aduan
		
		echo "<option value=\"0\">Tiada</option>";
		
		if(count($stafict)>0)
		{
			foreach($stafict AS $key => $value)
			{
					echo "<option value=\"" . $value . "\">" . getFullNameByStafID($value) . " (" . $value . ")" . "</option>";
			}
		};
		
	} else {
		echo "<option value=\"0\">Tiada</option>";
	};
	
	mysql_free_result($subcat);
} else if(isset($_GET['type']) && $_GET['type']=='15') // SKT feedbacktype detail
{
	if($_GET['val']=='2' && $_GET['val']!=0)
	{
		$query_subcat = "SELECT * FROM skt.petunjukpretasi WHERE ppskt_status = 1 ORDER BY ppskt_name ASC";
		$subcat = mysql_query($query_subcat, $ictdb) or die(mysql_error());
		$row_subcat = mysql_fetch_assoc($subcat);
		$total = mysql_num_rows($subcat);
		
		do {
			echo "<option value=\"" . $row_subcat['ppskt_id'] . "\">" . $row_subcat['ppskt_name'] . "</option>";
		} while ($row_subcat = mysql_fetch_assoc($subcat));
		
	}else if($_GET['val']=='3' && $_GET['val']!=0) {
		$start = getFeedbackTypeSubIDLatestBySKTID($_GET['vall']) + 5; // peratusan terkini
		for($i=$start; $i<=100; $i+=5)
		{
			echo "<option value=\"" . $i . "\">" . $i . "%</option>";
		}
	} else if($_GET['val']=='5' && $_GET['val']!=0) {
		if(getSKTMasaTamat($_GET['vall'])!=12)
		{
			for($i=1; $i<=(12-getSKTMasaTamat($_GET['vall'])); $i++)
			{
				echo "<option value=\"" . $i . "\">" . $i . " bulan</option>";
			}
		} else {
			echo "<option value=\"0\">Tiada</option>";
		}
	} else {
		echo "<option value=\"0\">Tiada</option>";
	}
} else if(isset($_GET['type']) && $_GET['type']=='16') // AM5BABG
{
	$rt = getReasonType($_GET['val']);
	if($rt == 0)
	{
		if($_GET['val']=='1' && $_GET['val']!='0') // masuk lewat
		{
			$hms = getReasonStart($_GET['val']); // array 0 - hour, 1 - minit
			$hme = getReasonEnd($_GET['val']);
			
			echo "<select name=\"from\" id=\"from\">";
			for($h=$hms[0]; $h<=$hme[0]; $h++)
			{
				for($m=0; $m<60; $m+=30)
				{
				echo "<option value=\"" . date('H/i/A', mktime($h,$m, 0, date('m'), 1, date('Y'))) . "\">" . date('h:i A', mktime($h,$m, 0, date('m'), 1, date('Y'))) . "</option>";
				};
			};
			echo "</select>";
			echo "<span class=\"inputlabel\"> &nbsp; hingga &nbsp; </span>"; 
			echo "<select name=\"till\" id=\"till\">";
			for($h=$hms[0]; $h<=$hme[0]; $h++)
			{
				for($m=0; $m<60; $m+=30)
				{
					echo "<option selected=\"selected\" value=\"" . date('H/i/A', mktime($h,$m, 0, date('m'), 1, date('Y'))) . "\">" . date('h:i A', mktime($h,$m, 0, date('m'), 1, date('Y'))) . "</option>";
				};
			};
			echo "</select>";
		} elseif($_GET['val']=='2' && $_GET['val']!='0') // masuk lewat
		{
			$hms = getReasonStart($_GET['val']); // array 0 - hour, 1 - minit
			$hme = getReasonEnd($_GET['val']);
			
			echo "<select name=\"from\" id=\"from\">";
			for($h=$hms[0]; $h<=$hme[0]; $h++)
			{
				for($m=0; $m<60; $m+=30)
				{
				echo "<option value=\"" . date('H/i/A', mktime($h,$m, 0, date('m'), 1, date('Y'))) . "\">" . date('h:i A', mktime($h,$m, 0, date('m'), 1, date('Y'))) . "</option>";
				};
			};
			echo "</select>";
			echo "<span class=\"inputlabel\"> &nbsp; hingga &nbsp; </span>"; 
			echo "<select name=\"till\" id=\"till\">";
			for($h=$hms[0]; $h<=$hme[0]; $h++)
			{
				for($m=0; $m<60; $m+=30)
				{
					echo "<option selected=\"selected\" value=\"" . date('H/i/A', mktime($h,$m, 0, date('m'), 1, date('Y'))) . "\">" . date('h:i A', mktime($h,$m, 0, date('m'), 1, date('Y'))) . "</option>";
				};
			};
			echo "</select>";
		}  elseif($_GET['val']=='0') {
			echo "<select name=\"xxx\" id=\"xxx\">";
			echo "<option value=\"0\" disabled=\"disabled\">Sila pilih sebab</option>";
			echo "</select>";
			
		}elseif($_GET['val']!='0') 
		{
			echo "<select name=\"from\" id=\"from\">";
			for($h=7; $h<=17; $h++)
			{
				for($m=0; $m<60; $m+=30)
				{
				echo "<option value=\"" . date('H/i/A', mktime($h,$m, 0, date('m'), 1, date('Y'))) . "\">" . date('h:i A', mktime($h,$m, 0, date('m'), 1, date('Y'))) . "</option>";
				};
			};
			echo "</select>";
			echo "<span class=\"inputlabel\"> &nbsp; hingga &nbsp; </span>"; 
			echo "<select name=\"till\" id=\"till\">";
			for($h=7; $h<=17; $h++)
			{
				for($m=0; $m<60; $m+=30)
				{
					echo "<option selected=\"selected\" value=\"" . date('H/i/A', mktime($h,$m, 0, date('m'), 1, date('Y'))) . "\">" . date('h:i A', mktime($h,$m, 0, date('m'), 1, date('Y'))) . "</option>";
				};
			};
			echo "</select>";
		};
		
	} elseif($_GET['val']=='0') {
			echo "<select name=\"xxx\" id=\"xxx\">";
			echo "<option value=\"0\" disabled=\"disabled\">Sila pilih sebab</option>";
			echo "</select>";
			
	} else { // view tempoh day
		echo "<select name=\"leaveoffice_day\" id=\"leaveoffice_day\">";
		for($i=1; $i<=31; $i++)
		{
			echo "<option value=\"" . $i . "\">" . $i . "</option>";
		};
		echo "</select>";
		echo "<select name=\"leaveoffice_daytype\" id=\"leaveoffice_daytype\">";
		echo "<option value=\"1\">Hari</option>";
		echo "<option value=\"2\">Minggu</option>";
		echo "<option value=\"3\">Bulan</option>";
		echo "</select>";
	}
} else if(isset($_GET['type']) && $_GET['type']=='17') {
	$stype = htmlspecialchars($_GET['val'], ENT_QUOTES);
	
	if($stype == 1)
	{
		//bahagian
		$query_dir = "SELECT dir.dir_id FROM www.dir WHERE dir_status = 1 ORDER BY dir_type ASC, dir_name ASC";
		$dir = mysql_query($query_dir, $ictdb) or die(mysql_error());
		$row_dir = mysql_fetch_assoc($dir);
		$total = mysql_num_rows($dir);
		
		echo "<select name=\"unit\" id=\"unit\">";
		
		do{
			echo "<option value=\"" . $row_dir['dir_id'] . "\">" . getFulldirectory($row_dir['dir_id'], 0) . "</option>";
		}while($row_dir = mysql_fetch_assoc($dir));
		
		echo "</select>";
		
	} elseif ($stype == 2)
	{
		//nama
		echo "<input name=\"n\" type=\"text\" class=\"w30\" id=\"n\" />";
		
	} elseif($stype == 3)
	{
		//stafid
		echo "<input name=\"si\" type=\"text\" class=\"w30\" id=\"si\" />";
		
	} elseif($stype == 4)
	{
		//kad pengenalan
		echo "<input name=\"kp\" type=\"text\" class=\"w30\" id=\"kp\" />";
		
	} elseif($stype == 5)
	{
		//alphabet
		echo "<select name=\"c\" id=\"c\">";
		foreach(range('A', 'Z') AS $alp)
		{
			echo "<option value=\"" . $alp ."\">" . $alp . "</option>";
		};
		echo "</select>";
		
	} elseif($stype == 6)
	{
		//tahun
		echo "<select name=\"tahun\" id=\"tahun\">";
		echo "</select>";
		for($i=date('Y'); $i>=2012; $i--)
		{
			echo "<option value=" . $i . ">" .$i . "</option>";
		};
	}
	
	echo "<input name=\"button4\" type=\"submit\" class=\"submitbutton\" id=\"button4\" value=\"Semak\" />";
	
} else if(isset($_GET['type']) && $_GET['type']=='18') {
	// load transport name berdasarkan transport type
	if (isset($_GET['val'])) {
		
		mysql_select_db($database_tadbirdb, $tadbirdb);
		$query_tr = "SELECT transport.* FROM tadbir.transport WHERE transporttype_id = '" . htmlspecialchars($_GET['val'], ENT_QUOTES) . "' AND transport_status = '1' ORDER BY transport_name ASC";
		$tr = mysql_query($query_tr, $tadbirdb) or die(mysql_error());
		$row_tr = mysql_fetch_assoc($tr);
		$totalRows_tr = mysql_num_rows($tr);
		
		if($totalRows_tr>0){
			do {  
			
			  echo "<option value=\"" . $row_tr['transport_id'] . "\">" . $row_tr['transport_name'] ." (". $row_tr['transport_plat'] .")</option>";
			
			} while ($row_tr = mysql_fetch_assoc($tr));
		} else {
			echo "<option value=\"0\">Tiada</option>";
		}
	} else {
		echo "<option value=\"0\">Tiada</option>";
	}
	
	mysql_free_result($tr);
	
} else if(isset($_GET['type']) && $_GET['type']=='19') {
	// IDEAS
	
	$stype = htmlspecialchars($_GET['val'], ENT_QUOTES);
	
	if($stype == 1)
	{
		// kategori
		echo "<select name=\"idstype_id\" id=\"idstype_id\">";
			echo "<option value=\"0\">Semua Kategori</option>";
		
		foreach(getAllIdeasTypeID() AS $type_key => $type_value){
			echo "<option value=\"" . $type_value . "\">" . getIdeasTypeNameByID($type_value) . "</option>";
		};
		
		echo "</select>";
		
	} elseif($stype == 2)
	{
		// kategori
		echo "<select name=\"ids_date_m\" id=\"ids_date_m\">";
		
		for($i=1; $i<=12; $i++)
		{
			echo "<option ";
			if(date('m')==$i)
				echo "selected=\"selected\"";
			echo " value=\"" . $i . "\">" . date('F', mktime(0, 0, 0, $i, 1, date('Y'))) . "</option>";
		};
		
		echo "</select>";
		
		echo "<select name=\"ids_date_y\" id=\"ids_date_y\">";
		
		for($i=date('Y'); $i>=2013; $i--)
		{
			echo "<option ";
			if(date('Y')==$i)
				echo "selected=\"selected\"";
			echo " value=\"" . $i . "\">" . $i . "</option>";
		};
		
		echo "</select>";
		
	} elseif($stype == 3)
	{
		echo "<select name=\"sb\" id=\"sb\">";
		echo "<option value=\"1\">Undian Tertinggi</option>";
		echo "<option value=\"2\">Undian Terendah</option>";
		echo "</select>";
	}
	
	if($stype != 0)
		echo "<input name=\"button4\" type=\"submit\" class=\"submitbutton\" id=\"button4\" value=\"Semak\" />";
}else if(isset($_GET['type']) && $_GET['type']=='20') // Load Senarai Staf
{
	if (isset($_GET['val']) && $_GET['val']!=0) {
		
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$query_receiver = "SELECT * FROM www.user_unit LEFT JOIN www.login ON user_unit.user_stafid = login.user_stafid WHERE login.login_status = '1' AND user_unit.userunit_status = '1' AND user_unit.dir_id = '" . htmlspecialchars($_GET['val'],ENT_QUOTES) . "'";
		
		$receiver = mysql_query($query_receiver, $hrmsdb) or die(mysql_error());
		$row_receiver = mysql_fetch_assoc($receiver);
		$total = mysql_num_rows($receiver);
		
		if($total>0){
			do {  
		echo "<option value=\"" . $row_receiver['user_stafid'] . "\">" . getFullNameByStafID($row_receiver['user_stafid']) ."</option>";
			
			} while ($row_receiver = mysql_fetch_assoc($receiver));
		} else {
			echo "<option value=\"0\">Tiada</option>";
		}
		  
	} else {
		echo "<option value=\"0\">Sila Pilih Penerima</option>";
	}
	
	mysql_free_result($receiver);
} else if(isset($_GET['type']) && $_GET['type']=='21') // load sub kategori Aduan Harta
{
	if (isset($_GET['val']) && $_GET['val']!=0) {
		
		$query_subcat = "SELECT * FROM sports.subcategory WHERE subcategory_status = 1 AND category_id = '" . htmlspecialchars($_GET['val'], ENT_QUOTES) . "' ORDER BY subcategory_name ASC";
		$subcat = mysql_query($query_subcat, $sportsdb) or die(mysql_error());
		$row_subcat = mysql_fetch_assoc($subcat);
		$total = mysql_num_rows($subcat);
		
		if($total>0){
			echo "<option value=\"0\">Sila pilih</option>";
			do {
				echo "<option value=\"" . $row_subcat['subcategory_id'] . "\">" . $row_subcat['subcategory_name'] . "</option>";
			} while ($row_subcat = mysql_fetch_assoc($subcat));
		} else {
			echo "<option value=\"0\">Tiada</option>";
		};		
	} else {
		echo "<option value=\"0\">&laquo; Sila Pilih Kategori</option>";
	};
	
	mysql_free_result($subcat);
} else if(isset($_GET['type']) && $_GET['type']=='22') // load kuantiti item yg boleh dipinjam
{
	if (isset($_GET['val'])) {
		
		$total = getTotalItemBorrow($_GET['val'], $_GET['vall']);
		
		if($total!=0)
		{
			for($i=1; $i<=$total; $i++)
			{
				  echo "<option value=\"" . $i . "\">" . $i . " Unit </option>";
			}
		} else {
			  echo "<option value=\"0\">Tiada</option>";
		}
	} else {
		echo "<option value=\"0\">Sila Pilih Peralatan</option>";
	}
	
}else if(isset($_GET['type']) && $_GET['type']=='23') // load item yg available dan boleh dipinjam
{
	if (isset($_GET['val'])) {
		
		$query_subcat = "SELECT item.item_id, item.item_isnsiri, item_nosiri, item.brand_id, item.item_model FROM sports.item LEFT JOIN sports.subcategory ON subcategory.subcategory_id = item.subcategory_id WHERE item_borrow = 1 AND item_status = '1' AND item.subcategory_id = '" . htmlspecialchars($_GET['val'], ENT_QUOTES) . "' AND NOT EXISTS (SELECT * FROM sports.item_borrow LEFT JOIN sports.user_borrow ON user_borrow.userborrow_id = item_borrow.userborrow_id WHERE item_borrow.item_id = item.item_id AND item_borrow.itemborrow_status = 1 AND item_borrow.ict_return != 1 AND user_borrow.ict_status != 2) ORDER BY subcategory.subcategory_name ASC";
		$subcat = mysql_query($query_subcat, $sportsdb) or die(mysql_error());
		$row_subcat = mysql_fetch_assoc($subcat);
		$total = mysql_num_rows($subcat);
		
		if($total>0){
			do {
				echo "<option value=\"" . $row_subcat['item_id'] . "\">" . getBorrowItemISNSiriByID($row_subcat['item_id']) . " &bull; " . getSportsItemBrandNameByID($row_subcat['brand_id']) . " " . $row_subcat['item_model'] . "</option>";
			} while ($row_subcat = mysql_fetch_assoc($subcat));
		} else {
			echo "<option value=\"0\">Sila pilih Kategori</option>";
		}
	} else {
		echo "<option value=\"0\">Sila pilih Kategori</option>";
	}
	
	mysql_free_result($subcat);
}
if(isset($_GET['type']) && $_GET['type']=='24') // load ayat senarai perubahan di tatacara
{
	if (isset($_GET['val'])) {
		$query_ayatperubahan = "SELECT kewe_desc FROM www.kewe WHERE kewe.kewe_id = '" . htmlspecialchars($_GET['val'], ENT_QUOTES) . "'";
		$ayatperubahan = mysql_query($query_ayatperubahan, $hrmsdb) or die(mysql_error());
		$row_ayatperubahan = mysql_fetch_assoc($ayatperubahan);
		$totalayatperubahan = mysql_num_rows($ayatperubahan);
		if($totalayatperubahan>0){
			// echo $row_ayatperubahan['kewe_desc'];
			echo "<textarea name=\"kewe_ayat\" id=\"kewe_ayat\" value=\"" . $row_ayatperubahan['kewe_desc'] . "\" cols=\"45\" rows=\"6\">" . $row_ayatperubahan['kewe_desc'] . "</textarea>";
		} else {
			echo "";
		}
	} else {
		echo "tiadaa llaaaa";
	}
}
if(isset($_GET['type']) && $_GET['type']=='25') // load ayat senarai perubahan di kew8
{
	if (isset($_GET['val'])) {
		$query_ayatperubahan = "SELECT kewe_desc FROM www.kewe WHERE kewe.kewe_id = '" . htmlspecialchars($_GET['val'], ENT_QUOTES) . "'";
		$ayatperubahan = mysql_query($query_ayatperubahan, $hrmsdb) or die(mysql_error());
		$row_ayatperubahan = mysql_fetch_assoc($ayatperubahan);
		$totalayatperubahan = mysql_num_rows($ayatperubahan);
		if($totalayatperubahan>0){
			// echo $row_ayatperubahan['kewe_desc'];
			echo "<textarea name=\"userkewe_content\" id=\"userkewe_content\" value=\"" . $row_ayatperubahan['kewe_desc'] . "\" cols=\"45\" rows=\"6\">" . $row_ayatperubahan['kewe_desc'] . "</textarea>";
		} else {
			echo "";
		}
	} else {
		echo "tiadaa llaaaa";
	}
}
if(isset($_GET['type']) && $_GET['type']=='26') //
{
	if (isset($_GET['val'])) {
		$query_id = "SELECT user_stafid FROM www.user WHERE user.user_stafid = '" . htmlspecialchars($_GET['val'], ENT_QUOTES) . "'";
		$id = mysql_query($query_id, $hrmsdb) or die(mysql_error());
		$row_id = mysql_fetch_assoc($id);
		$total_id = mysql_num_rows($id);
		if($total_id>0){
			echo "<span style=\"color:red\"><strong>*  ID telah wujud.</strong></span>";
		} else {
			echo "<span></span>";
		}
	} else {
		echo "tiadaa llaaaa";
	}
}
if(isset($_GET['type']) && $_GET['type']=='27') //
{
	if (isset($_GET['val'])) {
		$query_ic = "SELECT user_noic FROM www.user WHERE user.user_noic = '" . htmlspecialchars($_GET['val'], ENT_QUOTES) . "'";
		$ic = mysql_query($query_ic, $hrmsdb) or die(mysql_error());
		$row_ic = mysql_fetch_assoc($ic);
		$total_ic = mysql_num_rows($ic);
		if($total_ic>0){
			echo "<span style=\"color:red\"><strong>*  IC telah wujud.</strong></span>";
		} else {
			echo "<span></span>";
		}
	} else {
		echo "tiadaa llaaaa";
	}
}

if(isset($_GET['type']) && $_GET['type']=='28') //
{
	if (isset($_GET['val']) && $_GET['val'] == 4) {
		echo "<input id=\"userdesignation_period\" type=\"text\" class=\"w10 txt_right\" value=\"99\" disabled /><div class=\"inputlabel2\">Isi 99 jika Tamat</div>";
	} else {
		echo "<input name=\"userdesignation_period\" type=\"text\" class=\"w10 txt_right\" id=\"userdesignation_period\" value=\"12\" /><span class=\"inputlabel\"> bulan</span><div class=\"inputlabel2\">Isi 0 jika Tetap</div>";
	}
}


// if(isset($_GET['type']) && $_GET['type']=='26' && $_GET['val'] == '25') // load gaji sebelum
// {
// 	if (isset($_GET['val'])) {
		
// 		echo 
// 		"<td nowrap=\"nowrap\" class=\"label\">Gaji Sebelum *</td> 
// 			<td colspan=\"8\">
// 				<span id=\"gaji_sebelum\">
// 					<span class=\"textfieldRequiredMsg\">A value is required.</span>
// 					<span class=\"inputlabel\">RM</span>
// 					<input name=\"userkewe_salary_prev\" type=\"text\" class=\"w35\" id=\"userkewe_salary_prev\" disabled=\"true\" value=\"".$_GET['prog']."\" />
// 				</span>
// 			</td>";
// 	} else {
// 		echo "<td>tiadaa llaaaa</td>";
// 	}
// }
;
?>



