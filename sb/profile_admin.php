<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php //include('../sb/email.php');?>
<?php

	$insertGoTo = $url_main . "main.php";

	$datetoday = date('d/m/Y h:i:s A');
	
	if(isset($_POST['userjob_start_d']))
		$datestart_d = htmlspecialchars($_POST['userjob_start_d'], ENT_QUOTES);
	else
		$datestart_d = date('d');
		
	if(isset($_POST['userjob_start_m']))
		$datestart_m = htmlspecialchars($_POST['userjob_start_m'], ENT_QUOTES);
	else
		$datestart_m = date('m');
		
	if(isset($_POST['userjob_start_y']))	
		$datestart_y = htmlspecialchars($_POST['userjob_start_y'], ENT_QUOTES);
	else
		$datestart_y = date('Y');
	
	if(isset($_POST['user_by']))
		$userby = htmlspecialchars($_POST['user_by'], ENT_QUOTES);
	else
		$userby = $row_user['user_stafid'];
		
	if(isset($_GET['id']))
		$userid = getUserIDByStafID(htmlspecialchars($_GET['id'], ENT_QUOTES));
	else
		$userid = "0";
		
	if(isset($_POST['gredkhas_id']))
		$gk = htmlspecialchars($_POST['gredkhas_id'], ENT_QUOTES);
	else
		$gk = 0;
		
//update status dalam login_status
if ((isset($_POST["MM_update_status"])) && ($_POST["MM_update_status"] == "formstatus")) 
{
	// semak user access level	
	if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 3))
	{ 
		if($_POST['login_status']=='0')
		{
			$sd = $_POST['login_date_d'];
			$sm = $_POST['login_date_m'];
			$sy = $_POST['login_date_y'];
		} else {
			$sd = '';
			$sm = '';
			$sy = '';
		};
		
	  $updateSQL = sprintf("UPDATE www.login SET login_status=%s, login_date_d=%s, login_date_m=%s, login_date_y=%s WHERE user_stafid=%s",
						   GetSQLValueString($_POST['login_status'], "int"),
						   GetSQLValueString($sd, "text"),
						   GetSQLValueString($sm, "text"),
						   GetSQLValueString($sy, "text"),
						   GetSQLValueString($_POST['user_stafid'], "text"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
	}
	
	if(isset($_GET['url']) && $_GET['url']=='edit')
		$insertGoTo = $url_main . "admin/edit.php?id=" . $userid . "&msg=add";
}
	
	//edit profile dalam table user
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formprofile")) {
	if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 3)){ // semak user access level
	  $updateSQL = sprintf("UPDATE www.user SET title_id=%s, user_firstname=%s, user_lastname=%s, user_noic=%s, user_dob_d=%s, user_dob_m=%s, user_dob_y=%s, user_nationality=%s, user_gender=%s, user_race=%s, religion_id=%s WHERE user_stafid=%s",
						   GetSQLValueString($_POST['title_id'], "int"),
						   GetSQLValueString($_POST['user_firstname'], "text"),
						   GetSQLValueString($_POST['user_lastname'], "text"),
						   GetSQLValueString($_POST['user_noic'], "text"),
						   GetSQLValueString($_POST['user_dob_d'], "text"),
						   GetSQLValueString($_POST['user_dob_m'], "text"),
						   GetSQLValueString($_POST['user_dob_y'], "text"),
						   GetSQLValueString($_POST['user_nationality'], "text"),
						   GetSQLValueString($_POST['user_gender'], "text"),
						   GetSQLValueString($_POST['user_race'], "text"),
						   GetSQLValueString($_POST['religion_id'], "int"),
						   GetSQLValueString($_POST['user_stafid'], "text"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
	}
	
	if(isset($_GET['url']) && $_GET['url']=='edit')
		$insertGoTo = $url_main . "admin/edit.php?id=" . $userid . "&msg=add";
};
	
	//add Jawatan2 kedalam table user_job2
if ((isset($_POST["MM_insert_job2"])) && ($_POST["MM_insert_job2"] == "formjob2")) 
{
	if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 2))
	{ 
		// semak user access level
		$insertSQL = sprintf("INSERT INTO www.user_job2 (userjob2_date, userjob2_by, user_stafid, userjob2_date_d, userjob2_date_m, userjob2_date_y, jobss_id) VALUES (%s, %s, %s, %s, %s, %s, %s)",
							 GetSQLValueString($datetoday, "text"),
							 GetSQLValueString($userby, "text"),
							 GetSQLValueString($_POST['user_stafid'], "text"),
							 GetSQLValueString($_POST['userjob2_date_d'], "text"),
							 GetSQLValueString($_POST['userjob2_date_m'], "text"),
							 GetSQLValueString($_POST['userjob2_date_y'], "text"),
							 GetSQLValueString($_POST['jobss_id'], "int"));
	  
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	};
	
	if(isset($_GET['url']) && $_GET['url']=='edit')
		$insertGoTo = $url_main . "admin/edit.php?id=" . $userid . "&msg=add";
};

//Update maklumat lain dalam table user_job
if ((isset($_POST["MM_update_lain"])) && ($_POST["MM_update_lain"] == "formlain"))
{
	if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 3))
	{ 
		// semak user access level
		$updateSQL = sprintf("UPDATE www.user_job SET userjob_kwsp=%s, userjob_kwsp_d=%s, userjob_kwsp_m=%s, userjob_kwsp_y=%s, userjob_perkeso=%s, userjob_perkeso_d=%s, userjob_perkeso_m=%s, userjob_perkeso_y=%s, userjob_lhdn=%s, userjob_lhdn_d=%s, userjob_lhdn_m=%s, userjob_lhdn_y=%s, userjob_club=%s, bank_id=%s, userjob_nobank=%s WHERE user_stafid=%s",
							 GetSQLValueString(strtoupper($_POST['userjob_kwsp']), "text"),
							 GetSQLValueString($_POST['userjob_kwsp_d'], "text"),
							 GetSQLValueString($_POST['userjob_kwsp_m'], "text"),
							 GetSQLValueString($_POST['userjob_kwsp_y'], "text"),
							 GetSQLValueString(strtoupper($_POST['userjob_perkeso']), "text"),
							 GetSQLValueString($_POST['userjob_perkeso_d'], "text"),
							 GetSQLValueString($_POST['userjob_perkeso_m'], "text"),
							 GetSQLValueString($_POST['userjob_perkeso_y'], "text"),
							 GetSQLValueString(strtoupper($_POST['userjob_lhdn']), "text"),
							 GetSQLValueString($_POST['userjob_lhdn_d'], "text"),
							 GetSQLValueString($_POST['userjob_lhdn_m'], "text"),
							 GetSQLValueString($_POST['userjob_lhdn_y'], "text"),
							 GetSQLValueString($_POST['userjob_club'], "int"),
							 GetSQLValueString($_POST['bank_id'], "int"),
							 GetSQLValueString(strtoupper($_POST['userjob_nobank']), "text"),
							 GetSQLValueString($_POST['user_stafid'], "text"));
	  
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
	};
	
	if(isset($_GET['url']) && $_GET['url']=='edit')
		$insertGoTo = $url_main . "admin/edit.php?id=" . $userid . "&msg=edit";
};

// ADD NEW STAFF borang pendaftaran
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "addstaff") && ($_POST['scheme_id']!=NULL) && ($_POST['userscheme_gred']!=NULL))
{

	if(isset($_GET['url']) && $_GET['url']=='add')
  		$insertGoTo = $url_main . "admin/stafflist.php?msg=add";
		
	if(!checkStafID($_POST['user_stafid']) && !checkStafIC($_POST['user_stafid'], $_POST['user_noic']))
	{ // semakkan Staf ID
	
 		//add user profile dalam table user
		if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 2))
		{ 
			// semak user access level
			$insertSQL = sprintf("INSERT INTO www.user (user_date, user_by, title_id, user_firstname, user_lastname, user_noic, user_stafid, user_dob_d, user_dob_m, user_dob_y, user_nationality, user_gender, religion_id, user_race) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
								 GetSQLValueString($datetoday, "text"),
								 GetSQLValueString($userby, "text"),
								 GetSQLValueString($_POST['title_id'], "int"),
								 GetSQLValueString(strtoupper($_POST['user_firstname']), "text"),
								 GetSQLValueString(strtoupper($_POST['user_lastname']), "text"),
								 GetSQLValueString($_POST['user_noic'], "text"),
								 GetSQLValueString(strtoupper($_POST['user_stafid']), "text"),
								 GetSQLValueString($_POST['user_dob_d'], "text"),
								 GetSQLValueString($_POST['user_dob_m'], "text"),
								 GetSQLValueString($_POST['user_dob_y'], "text"),
								 GetSQLValueString($_POST['user_nationality'], "text"),
								 GetSQLValueString($_POST['user_gender'], "text"),
								 GetSQLValueString($_POST['religion_id'], "text"),
								 GetSQLValueString($_POST['user_race'], "text"));
		  
			mysql_select_db($database_hrmsdb, $hrmsdb);
			$Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
			
		} else {
			$insertGoTo = $url_main . "admin/add.php?msg=error&act=adduser";
		};
		
		//add user maklumat penjawatan dalam table user_job
		if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 2))
		{ 
			// semak user access level
			$insertSQL = sprintf("INSERT INTO www.user_job (userjob_date, userjob_by, user_stafid, userjob_start_d, userjob_start_m, userjob_start_y, userjob_promoted_d, userjob_promoted_m, userjob_promoted_y, userjob_kontrak_start_d, userjob_kontrak_start_m, userjob_kontrak_start_y, userjob_kontrak_end_d, userjob_kontrak_end_m, userjob_kontrak_end_y, userjob_in_d, userjob_in_m, userjob_in_y, userjob_kwsp, userjob_perkeso, userjob_lhdn, bank_id, userjob_nobank) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
								 GetSQLValueString($datetoday, "text"),
								 GetSQLValueString($userby, "text"),
								 GetSQLValueString(strtoupper($_POST['user_stafid']), "text"),
								 GetSQLValueString($datestart_d, "text"),
								 GetSQLValueString($datestart_m, "text"),
								 GetSQLValueString($datestart_y, "text"),
								 GetSQLValueString($_POST['userjob_promoted_d'], "text"),
								 GetSQLValueString($_POST['userjob_promoted_m'], "text"),
								 GetSQLValueString($_POST['userjob_promoted_y'], "text"),
								 GetSQLValueString($_POST['userjob_kontrak_start_d'], "text"),
								 GetSQLValueString($_POST['userjob_kontrak_start_m'], "text"),
								 GetSQLValueString($_POST['userjob_kontrak_start_y'], "text"),
								 GetSQLValueString($_POST['userjob_kontrak_end_d'], "text"),
								 GetSQLValueString($_POST['userjob_kontrak_end_m'], "text"),
								 GetSQLValueString($_POST['userjob_kontrak_end_y'], "text"),
								 GetSQLValueString($_POST['userjob_in_d'], "text"),
								 GetSQLValueString($_POST['userjob_in_m'], "text"),
								 GetSQLValueString($_POST['userjob_in_y'], "text"),
								 GetSQLValueString(strtoupper($_POST['userjob_kwsp']), "text"),
								 GetSQLValueString(strtoupper($_POST['userjob_perkeso']), "text"),
								 GetSQLValueString(strtoupper($_POST['userjob_lhdn']), "text"),
								 GetSQLValueString($_POST['bank_id'], "int"),
								 GetSQLValueString(strtoupper($_POST['userjob_nobank']), "text"));
		  
			mysql_select_db($database_hrmsdb, $hrmsdb);
			$Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
			
		} else {
			$insertGoTo = $url_main . "admin/add.php?msg=error&act=adduser";
		};
	
	} else { // semakkan Staf ID telah didaftarkan
		$insertGoTo = $url_main . "admin/add.php?e=1&act=adduser";
	};
};

//add user taraf penjawatan (cth: kontrak / tetap) dalam table user_designation
if ((isset($_POST["MM_insert_dgn"])) && ($_POST["MM_insert_dgn"] == "formdgn"))
{
	if(isset($_POST['MM_insert']) && $_POST['MM_insert'] == 'addstaff')
	{
		$dgn_d = $datestart_d;
		$dgn_m = $datestart_m;
		$dgn_y = $datestart_y;
		
	} else {
		$dgn_d = htmlspecialchars($_POST['userdesignation_date_d'], ENT_QUOTES);
		$dgn_m = htmlspecialchars($_POST['userdesignation_date_m'], ENT_QUOTES);
		$dgn_y = htmlspecialchars($_POST['userdesignation_date_y'], ENT_QUOTES);
	};
		
	if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 2))
	{ 
		// semak user access level
		$insertSQL = sprintf("INSERT INTO www.user_designation (userdesignation_by, userdesignation_date, userdesignation_date_d, userdesignation_date_m, userdesignation_date_y, user_stafid, jobtype_id, userdesignation_period) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
							 GetSQLValueString($userby, "text"),
							 GetSQLValueString($datetoday, "text"),
							 GetSQLValueString($dgn_d, "text"),
							 GetSQLValueString($dgn_m, "text"),
							 GetSQLValueString($dgn_y, "text"),
							 GetSQLValueString(strtoupper($_POST['user_stafid']), "text"),
							 GetSQLValueString($_POST['jobtype_id'], "text"),
							 GetSQLValueString($_POST['userdesignation_period'], "int"));
	  
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	};
	
	if(isset($_GET['url']) && $_GET['url']=='edit')
		$insertGoTo = $url_main . "admin/edit.php?id=" . $userid . "&msg=add";
};
	
if ((isset($_POST["MM_insert_job1"])) && ($_POST["MM_insert_job1"] == "formjob1"))
{
	//add user gred (cth: F29 - Pen Peg Teknologi Maklumat) dalam table user_scheme
		
	if(isset($_POST['MM_insert']) && $_POST['MM_insert'] == 'addstaff')
	{
		$dgn_d = $datestart_d;
		$dgn_m = $datestart_m;
		$dgn_y = $datestart_y;
		
	} else{
		$dgn_d = htmlspecialchars($_POST['userscheme_in_d'], ENT_QUOTES);
		$dgn_m = htmlspecialchars($_POST['userscheme_in_m'], ENT_QUOTES);
		$dgn_y = htmlspecialchars($_POST['userscheme_in_y'], ENT_QUOTES);
	};
	
	if(isset($_POST['userscheme_no']))
		$noscheme = htmlspecialchars($_POST['userscheme_no'], ENT_QUOTES);
	else
		$noscheme = '0';
		
	if(isset($_POST['scheme_id']) && $_POST['scheme_id']!=NULL)
		$scheme = htmlspecialchars($_POST['scheme_id'], ENT_QUOTES);
	else
		$scheme = 0;
		
	if(isset($_POST['userscheme_gred']) && $_POST['userscheme_gred']!=NULL)
		$gred = htmlspecialchars($_POST['userscheme_gred'], ENT_QUOTES);
	else
		$gred = 0;

	if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 2))
	{ 
		// semak user access level
		$insertSQL = sprintf("INSERT INTO www.user_scheme (userscheme_by, userscheme_date, user_stafid, userscheme_in_d, userscheme_in_m, userscheme_in_y, scheme_id, userscheme_gred, gredkhas_id, userscheme_no) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
							 GetSQLValueString($userby, "text"),
							 GetSQLValueString($datetoday, "text"),
							 GetSQLValueString(strtoupper($_POST['user_stafid']), "text"),
							 GetSQLValueString($dgn_d, "text"),
							 GetSQLValueString($dgn_m, "text"),
							 GetSQLValueString($dgn_y, "text"),
							 GetSQLValueString($scheme, "int"),
							 GetSQLValueString($gred, "text"),
							 GetSQLValueString($gk, "int"),
							 GetSQLValueString($noscheme, "int"));
	  
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	}
	
	if(isset($_GET['url']) && $_GET['url']=='edit')
		$insertGoTo = $url_main . "admin/edit.php?id=" . $userid . "&msg=add";
  };
  
  //add unit dan lokasi user dalam table user_unit
  if ((isset($_POST["MM_insert_pen"])) && ($_POST["MM_insert_pen"] == "formpen"))
  {	
		  if(isset($_POST['MM_insert']) && $_POST['MM_insert'] == 'addstaff')
		  {
			  $dgn_d = $datestart_d;
			  $dgn_m = $datestart_m;
			  $dgn_y = $datestart_y;
			  
		  } else {
			  $dgn_d = htmlspecialchars($_POST['userunit_in_d'], ENT_QUOTES);
			  $dgn_m = htmlspecialchars($_POST['userunit_in_m'], ENT_QUOTES);
			  $dgn_y = htmlspecialchars($_POST['userunit_in_y'], ENT_QUOTES);
		  };
		  
	  if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 2))
	  { 
		  // semak user access level
		  $insertSQL = sprintf("INSERT INTO www.user_unit (userunit_date, userunit_by, userunit_in_d, userunit_in_m, userunit_in_y, user_stafid, dir_id, location_id) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($datetoday, "text"),
						   GetSQLValueString($userby, "text"),
						   GetSQLValueString($dgn_d, "text"),
						   GetSQLValueString($dgn_m, "text"),
						   GetSQLValueString($dgn_y, "text"),
						   GetSQLValueString($_POST['user_stafid'], "text"),
						   GetSQLValueString($_POST['dir_id'], "int"),
						   GetSQLValueString($_POST['location_id'], "int"));
		
		  mysql_select_db($database_hrmsdb, $hrmsdb);
		  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	  };
		  if(isset($_GET['url']) && $_GET['url']=='edit')
		  $insertGoTo = $url_main . "admin/edit.php?id=" . $userid . "&msg=add";
  };
		
//email kpd ICT untuk pendaftaran baru oleh Caw Sumber Manusia
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "addstaff") && ($_POST['scheme_id']!=NULL) && ($_POST['userscheme_gred']!=NULL))
{
	mysql_select_db($database_hrmsdb, $hrmsdb);
	$query_entry = "SELECT user_sysacc.* FROM www.user_sysacc WHERE usersysacc_status='1' AND submenu_id = '10'"; //Staf ID yg ada akses Modul ICT > Email 
	$entry = mysql_query($query_entry, $hrmsdb) or die(mysql_error());
	$row_entry = mysql_fetch_assoc($entry);
	$totalRows_entry = mysql_num_rows($entry);
		  
	$emailto = array();
	
	do {
		$emailto[] = $row_entry['user_stafid']; // array emailstafid[1] = Staf ID yg ada akses Modul ICT > Email
	} while ($row_entry = mysql_fetch_assoc($entry));
	
	//addUser($emailto, 0, 0, 1, strtoupper($_POST['user_stafid']));
}

// tamat borang pendaftaran
	
	
	
if ((isset($_POST["MM_insert_tg"])) && ($_POST["MM_insert_tg"] == "formtg"))
{
	//add tangga gaji dalam user_salaryskill
	if(isset($_POST['MM_insert']) && $_POST['MM_insert'] == 'addstaff')
	{
		$dgn_d = $datestart_d;
		$dgn_m = $datestart_m;
		$dgn_y = $datestart_y;
		
	} else
	{
		$dgn_d = htmlspecialchars($_POST['usersalaryskill_date_d'], ENT_QUOTES);
		$dgn_m = htmlspecialchars($_POST['usersalaryskill_date_m'], ENT_QUOTES);
		$dgn_y = htmlspecialchars($_POST['usersalaryskill_date_y'], ENT_QUOTES);
	};
		
	if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 2))
	{ 
		// semak user access level
		$insertSQL = sprintf("INSERT INTO www.user_salaryskill (usersalaryskill_date, usersalaryskill_by, user_stafid, userkewe_id, usersalaryskill_date_d, usersalaryskill_date_m, usersalaryskill_date_y, usersalaryskill_code, usersalaryskill_code2, usersalaryskill_basicsalary, usersalaryskill_start_d, usersalaryskill_start_m, usersalaryskill_start_y) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
							 GetSQLValueString($datetoday, "text"),
							 GetSQLValueString($userby, "text"),
							 GetSQLValueString(strtoupper($_POST['user_stafid']), "text"),
							 GetSQLValueString($_POST['userkewe_id'], "int"),
							 GetSQLValueString($dgn_d, "text"),
							 GetSQLValueString($dgn_m, "text"),
							 GetSQLValueString($dgn_y, "text"),
							 GetSQLValueString($_POST['usersalaryskill_code'], "text"),
							 GetSQLValueString($_POST['usersalaryskill_code2'], "text"),
							 GetSQLValueString($_POST['usersalaryskill_basicsalary'], "text"),
							 GetSQLValueString($_POST['usersalaryskill_start_d'], "text"),
							 GetSQLValueString($_POST['usersalaryskill_start_m'], "text"),
							 GetSQLValueString($_POST['usersalaryskill_start_y'], "text"));
	  
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	};
	
	if(isset($_GET['url']) && $_GET['url']=='edit')
		$insertGoTo = $url_main . "admin/edit.php?id=" . $userid . "&msg=add";
};

if ((isset($_POST["MM_update_tg"])) && ($_POST["MM_update_tg"] == "formtgupdate"))
{
	//add tangga gaji dalam user_salaryskill
	if(isset($_POST['MM_update']) && $_POST['MM_update'] == 'addstaff')
	{
		$dgn_d = $datestart_d;
		$dgn_m = $datestart_m;
		$dgn_y = $datestart_y;
		
	} else
	{
		$dgn_d = htmlspecialchars($_POST['usersalaryskill_date_d'], ENT_QUOTES);
		$dgn_m = htmlspecialchars($_POST['usersalaryskill_date_m'], ENT_QUOTES);
		$dgn_y = htmlspecialchars($_POST['usersalaryskill_date_y'], ENT_QUOTES);
	};
		
	if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 2))
	{ 
		// semak user access level
		$insertSQL = sprintf("INSERT INTO www.user_salaryskill (usersalaryskill_date, usersalaryskill_by, user_stafid, userkewe_id, usersalaryskill_date_d, usersalaryskill_date_m, usersalaryskill_date_y, usersalaryskill_code, usersalaryskill_code2, usersalaryskill_basicsalary, usersalaryskill_start_d, usersalaryskill_start_m, usersalaryskill_start_y) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
							 GetSQLValueString($datetoday, "text"),
							 GetSQLValueString($userby, "text"),
							 GetSQLValueString(strtoupper($_POST['user_stafid']), "text"),
							 GetSQLValueString($_POST['userkewe_id'], "int"),
							 GetSQLValueString($dgn_d, "text"),
							 GetSQLValueString($dgn_m, "text"),
							 GetSQLValueString($dgn_y, "text"),
							 GetSQLValueString($_POST['usersalaryskill_code'], "text"),
							 GetSQLValueString($_POST['usersalaryskill_code2'], "text"),
							 GetSQLValueString($_POST['usersalaryskill_basicsalary'], "text"),
							 GetSQLValueString($_POST['usersalaryskill_start_d'], "text"),
							 GetSQLValueString($_POST['usersalaryskill_start_m'], "text"),
							 GetSQLValueString($_POST['usersalaryskill_start_y'], "text"));
	  
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	};
	
	if(isset($_GET['url']) && $_GET['url']=='edit')
		$insertGoTo = $url_main . "admin/edit.php?id=" . $userid . "&msg=add";
};
	
if ((isset($_POST["MM_insert_eml"])) && ($_POST["MM_insert_eml"] == "formeml"))
{
 	//add user emolumen dalam table user_emolumen
		
	if(isset($_POST['MM_insert']) && $_POST['MM_insert'] == 'addstaff')
	{
		$dgn_d = $datestart_d;
		$dgn_m = $datestart_m;
		$dgn_y = $datestart_y;
		
	} else
	{
		$dgn_d = htmlspecialchars($_POST['useremolumen_date_d'], ENT_QUOTES);
		$dgn_m = htmlspecialchars($_POST['useremolumen_date_m'], ENT_QUOTES);
		$dgn_y = htmlspecialchars($_POST['useremolumen_date_y'], ENT_QUOTES);
	};
		
	if(checkUserSysAcc($row_user['user_stafid'], 5, 6, 2))
	{ 
		// semak user access level
	  $insertSQL = sprintf("INSERT INTO www.user_emolumen (useremolumen_by, useremolumen_date, user_stafid, userkewe_id, useremolumen_date_d, useremolumen_date_m, useremolumen_date_y, useremolumen_start_d, useremolumen_start_m, useremolumen_start_y, useremolumen_itka, useremolumen_itkrai, useremolumen_itp, useremolumen_bsh, useremolumen_elktkl, useremolumen_posbasik, useremolumen_elpakar, useremolumen_elinsentif, useremolumen_jusa, useremolumen_elpemkhas, useremolumen_elpemrmh, useremolumen_elbhs, useremolumen_o, useremolumen_elkdriver, useremolumen_selenggara) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($userby, "text"),
						   GetSQLValueString($datetoday, "text"),
						   GetSQLValueString(strtoupper($_POST['user_stafid']), "text"),
						   GetSQLValueString($_POST['userkewe_id'], "int"),
						   GetSQLValueString($dgn_d, "text"),
						   GetSQLValueString($dgn_m, "text"),
						   GetSQLValueString($dgn_y, "text"),
						   GetSQLValueString($_POST['useremolumen_start_d'], "text"),
						   GetSQLValueString($_POST['useremolumen_start_m'], "text"),
						   GetSQLValueString($_POST['useremolumen_start_y'], "text"),
						   GetSQLValueString($_POST['useremolumen_itka'], "text"),
						   GetSQLValueString($_POST['useremolumen_itkrai'], "text"),
						   GetSQLValueString($_POST['useremolumen_itp'], "text"),
						   GetSQLValueString($_POST['useremolumen_bsh'], "text"),
						   GetSQLValueString($_POST['useremolumen_elktkl'], "text"),
						   GetSQLValueString($_POST['useremolumen_posbasik'], "text"),
						   GetSQLValueString($_POST['useremolumen_elpakar'], "text"),
						   GetSQLValueString($_POST['useremolumen_elinsentif'], "text"),
						   GetSQLValueString($_POST['useremolumen_jusa'], "text"),
						   GetSQLValueString($_POST['useremolumen_elpemkhas'], "text"),
						   GetSQLValueString($_POST['useremolumen_elpemrmh'], "text"),
						   GetSQLValueString($_POST['useremolumen_elbhs'], "text"),
						   GetSQLValueString($_POST['useremolumen_o'], "text"),
						   GetSQLValueString($_POST['useremolumen_elkdriver'], "text"),
						   GetSQLValueString($_POST['useremolumen_selenggara'], "text"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	};
	
	if(isset($_GET['url']) && $_GET['url']=='edit')
		$insertGoTo = $url_main . "admin/edit.php?id=" . $userid . "&msg=add";
};
	
if ((isset($_POST["MM_insert_cuti"])) && ($_POST["MM_insert_cuti"] == "formcuti"))
{		
	//add user annual leave and cuti ganti tahunan dalam table user_leave
	
	if(isset($_POST['userleave_day']))
		$dateday = htmlspecialchars($_POST['userleave_day'], ENT_QUOTES);
	else
		$dateday = date('d');
	
	if(isset($_POST['userleave_month']))
		$datemonth = htmlspecialchars($_POST['userleave_month'], ENT_QUOTES);
	else
		$datemonth = date('m');
	
	if(isset($_POST['userleave_year']) && $_POST['userleave_year']!=0)
		$dateyear = htmlspecialchars($_POST['userleave_year'], ENT_QUOTES);
	else
		$dateyear = date('Y');
		
	if(isset($_POST['userleave_note']))
		$note = htmlspecialchars($_POST['userleave_note'], ENT_QUOTES);
	else
		$note = "";
		
	if(isset($_POST['userleave_nofail']))
		$nofail = htmlspecialchars($_POST['userleave_nofail'], ENT_QUOTES);
	else
		$nofail = "";
		
	if(isset($_POST['userleave_approvelby']) && $_POST['userleave_approvelby']!="")
	{
		$app = htmlspecialchars($_POST['userleave_approvelby'], ENT_QUOTES);
		
	} else {
		$app = "";
	};
		
	if(checkStafID($_POST['userleave_approvelby']) || $_POST['userleave_approvelby']=="" || $_POST['userleave_approvelby']=="0")	
	{	
		
		  $insertSQL = sprintf("INSERT INTO www.user_leave (userleave_date, userleave_by, user_stafid, userleave_day, userleave_month, userleave_year, userleave_note, userleave_annual, leavetype_id, userleave_nofail, userleave_approvelby) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($datetoday, "text"),
						   GetSQLValueString($userby, "text"),
						   GetSQLValueString(strtoupper($_POST['user_stafid']), "text"),
						   GetSQLValueString($dateday, "text"),
						   GetSQLValueString($datemonth, "text"),
						   GetSQLValueString($dateyear, "text"),
						   GetSQLValueString($note, "text"),
						   GetSQLValueString($_POST['userleave_annual'], "int"),
						   GetSQLValueString($_POST['leavetype_id'], "int"),
						   GetSQLValueString($nofail, "text"),
						   GetSQLValueString($app, "text"));
		
		  mysql_select_db($database_hrmsdb, $hrmsdb);
		  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
		  
		  if($_POST['leavetype_id']=='3')
		  {
			$emailto = array();
			$emailto[] = strtoupper($_POST['user_stafid']); // array emailstafid[0] = Staf ID
		  
		  if(getHeadIDByUserID($_POST['user_stafid'])!=NULL)
			$emailto[] = getHeadIDByUserID(strtoupper($_POST['user_stafid'])); // array emailstafid[1] = Ketua Unit No Fail
			
			$leaveid = getALID($_POST['user_stafid'], $dateday, $datemonth, $dateyear, $_POST['userleave_annual']);
			
			sys_prorec('hr', 'user_leave', $row_user['user_stafid'], '2', 'id=' . $leaveid);
			
			//emailAL($emailto, 0, 0, 1, $leaveid); // 2- email untuk Cuti ganti sahaja
		  };
  
		if(isset($_GET['url']) && $_GET['url']=='edit')
			$insertGoTo = $url_main . "admin/staffleavedetail.php?id=" . $userid . "&msg=add";
			
	} else {
		
		if(isset($_GET['url']) && $_GET['url']=='edit')
			$insertGoTo = $url_main . "admin/staffleavedetail.php?id=" . $userid . "&e=2";
	};
}
		
header(sprintf("Location: %s", $insertGoTo));
?>
