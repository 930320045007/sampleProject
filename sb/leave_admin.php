<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php //include('../sb/email.php');?>
<?php
$insertGoTo = $url_main . "admin/index.php";

if(checkUserSysAcc($row_user['user_stafid'], 5, 23, 2))
{ // semakkan user akses
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formcuti")) 
	{
		if($_POST['leavetype_id']==5)
		{
			if(getGenderIDByUserID($_POST['user_stafid'])=='2')
				$ok = true;
			else
				$ok = false;
		} else 
			$ok = true;
			
		if($ok){
			if(isset($_POST['userleavedate_nofail']))
				$userleavedatenofail = htmlspecialchars($_POST['userleavedate_nofail'], ENT_QUOTES);
			else
				$userleavedatenofail = NULL;
				
			if(isset($_POST['userleavedate_approvelby']))
				$userleavedateapprovelby = htmlspecialchars($_POST['userleavedate_approvelby'], ENT_QUOTES);
			else
				$userleavedateapprovelby = NULL;
				
			if(isset($_POST['leavecategory_id']))
				$leavecategoryid = htmlspecialchars($_POST['leavecategory_id'], ENT_QUOTES);
			else
				$leavecategoryid = 0;
				
			if(isset($_POST['userleavedate_day']))
				$userleavedateday = htmlspecialchars($_POST['userleavedate_day'], ENT_QUOTES);
			else
				$userleavedateday = 1;
				
			if(isset($_POST['userleavedate_sonby']))
				$userleavedatesonby = htmlspecialchars($_POST['userleavedate_sonby'], ENT_QUOTES);
			else
				$userleavedatesonby = 0;
				
			if(isset($_POST['userleavedate_notice']))
				$userleavedatenotice = htmlspecialchars($_POST['userleavedate_notice'], ENT_QUOTES);
			else
				$userleavedatenotice = 0;
				
			if(isset($_POST['userleavedate_app']))
				$userleavedateapp = htmlspecialchars($_POST['userleavedate_app'], ENT_QUOTES);
			else
				$userleavedateapp = 1;
				
			if(isset($_POST['clinictype_id']))
				$clinictypeid = htmlspecialchars($_POST['clinictype_id'], ENT_QUOTES);
			else
				$clinictypeid = 0;
				
			if(isset($_POST['clinic_id']))
				$clinicid = htmlspecialchars($_POST['clinic_id'], ENT_QUOTES);
			else
				$clinicid = 0;
				
			if(isset($_POST['userleavedate_appby']))
				$userleavedateappby = htmlspecialchars($_POST['userleavedate_appby'], ENT_QUOTES);
			else
				$userleavedateappby = $row_user['user_stafid'];
				
			if(isset($_POST['userleavedate_appdate']))
				$userleavedateappdate = htmlspecialchars($_POST['userleavedate_appdate'], ENT_QUOTES);
			else
				$userleavedateappdate = date('d/m/Y h:i:s A');
			
			if(isset($_POST['userleavedate_note']))
				$userleavedatenote = htmlspecialchars($_POST['userleavedate_note'], ENT_QUOTES);
			else
				$userleavedatenote = NULL;
			
			if(getStatusTFByStafID($_POST['user_stafid'])){
			if(!checkDayLeave($_POST['user_stafid'], 0, $_POST['userleavedate_date_d'], $_POST['userleavedate_date_m'], $_POST['userleavedate_date_y'])){
			if(!checkHoliday($_POST['userleavedate_date_d'], $_POST['userleavedate_date_m'], $_POST['userleavedate_date_y'], $_POST['user_stafid']) || $_POST['leavetype_id']!='1'){	
			
			// enable cuti Sabtu Ahad
			/*if($_POST['leavetype_id']!='1' || checkStateWeekendByDate($_POST['user_stafid'], $_POST['userleavedate_date_d'], $_POST['userleavedate_date_m'], $_POST['userleavedate_date_y'])){ */
			if(checkdate($_POST['userleavedate_date_m'], $_POST['userleavedate_date_d'], $_POST['userleavedate_date_y'])){
			if($_POST['user_stafid']!=$row_user['user_stafid']){
		
			  $insertGoTo = $url_main . "admin/staffleavedetail.php?msg=add&id=" . getUserIDByStafID(htmlspecialchars($_POST['user_stafid'], ENT_QUOTES));
			  
			  $totalday = 1;
			  
				if($_POST['leavetype_id']=='4')
				{
					if(getTotalDayInLeaveCategory($leavecategoryid, htmlspecialchars($_POST['leavetype_id'], ENT_QUOTES))!=0)
						$countday = getTotalDayInLeaveCategory($leavecategoryid, htmlspecialchars($_POST['leavetype_id'], ENT_QUOTES));
					else
						$countday = $userleavedateday;
				} else if($_POST['leavetype_id']=='8'){
					$countday = 1;
					$totalday = $userleavedateday;
				
				} else
					$countday = $userleavedateday;
					
				for($i=1; $i<=$countday; $i++)
				{
				
					$proLeave = true;
					
					if($_POST['leavetype_id']=='2')
					{ //semkkan cuti sakit
						$newtotal = countEL($_POST['user_stafid'], $_POST['userleavedate_date_y'])+1;
						if($newtotal <= getEL($_POST['user_stafid'], $_POST['userleavedate_date_y'])) 
							$proLeave = true;
						else
							$proLeave = false;
					}
					
					if($_POST['leavetype_id']=='4')
					{ //semkkan cuti tanpa rekod
						$newtotal = countLeaveWOR($_POST['user_stafid'], $_POST['userleavedate_date_y'])+1;
						if($newtotal <= getLeaveWOR($_POST['user_stafid'], $_POST['userleavedate_date_y']))
							$proLeave = true;
						else
							$proLeave = false;
					}
					
					if($_POST['leavetype_id']=='5')
					{ //semkkan cuti bersalin
						$newtotal = countLeaveBirth($_POST['user_stafid'])+1;
						if($newtotal <= getLeaveBirth($_POST['user_stafid']))
							$proLeave = true;
						else
							$proLeave = false;
					}
					
					if($proLeave)
					{	
					//jika semua syarat dipenuhi
					$dd = date('d', mktime(0, 0, 0, $_POST['userleavedate_date_m'], $_POST['userleavedate_date_d'] + ($i-1), $_POST['userleavedate_date_y']));
					$dm = date('m', mktime(0, 0, 0, $_POST['userleavedate_date_m'], $_POST['userleavedate_date_d'] + ($i-1), $_POST['userleavedate_date_y']));
					$dy = date('Y', mktime(0, 0, 0, $_POST['userleavedate_date_m'], $_POST['userleavedate_date_d'] + ($i-1), $_POST['userleavedate_date_y']));
					
					  $insertSQL = sprintf("INSERT INTO www.user_leavedate (userleavedate_by, userleavedate_date, user_stafid, leavetype_id, userleavedate_date_d, userleavedate_date_m, userleavedate_date_y, userleavedate_nofail, userleavedate_approvelby, leavecategory_id, userleavedate_day, userleavedate_sonby, clinictype_id, clinic_id, userleavedate_notice, userleavedate_note, userleavedate_app, userleavedate_appby, userleavedate_appdate) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
										   GetSQLValueString($row_user['user_stafid'], "text"),
										   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
										   GetSQLValueString($_POST['user_stafid'], "text"),
										   GetSQLValueString($_POST['leavetype_id'], "int"),
										   GetSQLValueString($dd, "text"),
										   GetSQLValueString($dm, "text"),
										   GetSQLValueString($dy, "text"),
										   GetSQLValueString($userleavedatenofail, "text"),
										   GetSQLValueString($userleavedateapprovelby, "text"),
										   GetSQLValueString($leavecategoryid, "int"),
										   GetSQLValueString($totalday, "int"),
										   GetSQLValueString($userleavedatesonby, "int"),
										   GetSQLValueString($clinictypeid, "int"),
										   GetSQLValueString($clinicid, "int"),
										   GetSQLValueString($userleavedatenotice, "int"),
										   GetSQLValueString($userleavedatenote, "text"),
										   GetSQLValueString($userleavedateapp, "int"),
										   GetSQLValueString($userleavedateappby, "text"),
										   GetSQLValueString($userleavedateappdate, "text"));
					
					  mysql_select_db($database_hrmsdb, $hrmsdb);
					  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
					  
					} else {
			  			$insertGoTo = $url_main . "admin/staffleavedetail.php?el=1&id=" . getUserIDByStafID($_POST['user_stafid']);
					};
				};
			  
				$emailto = array();
				$emailto[] = $_POST['user_stafid']; // array emailstafid[0] = Staf ID 
			  
			  if(getHeadIDByUserID($_POST['user_stafid'])!=NULL)
			  {
			  	$emailto[] = getHeadIDByUserID($_POST['user_stafid']); // array emailstafid[1] = Ketua Unit No Fail
			  };
				
				$leaveid = getLeaveID($_POST['user_stafid'], 0, $_POST['userleavedate_date_d'], $_POST['userleavedate_date_m'], $_POST['userleavedate_date_y']);
				
				sys_prorec('hr', 'user_leavedate', $row_user['user_stafid'], '2', 'id=' . $leaveid);
				
				//emailLeave($emailto, 0, 0, 3, $leaveid); // 3- email kelulusan daripada Cawangan Sumber Manusia
				
			} else { // user login tidak boleh mengemaskini maklumatnya sendiri dalam Modul HR
			  $insertGoTo = $url_main . "admin/staffleavedetail.php?el=7&id=" . getUserIDByStafID($_POST['user_stafid']);
			};
			} else { // valid date
			  $insertGoTo = $url_main . "admin/staffleavedetail.php?el=6&id=" . getUserIDByStafID($_POST['user_stafid']);
			};
			// enable cuti Sabtu Ahad
			/*} else { // semakkan tarikh bukan sabtu / ahad
			  $insertGoTo = $url_main . "admin/staffleavedetail.php?el=5&id=" . getUserIDByStafID($_POST['user_stafid']);
			};*/
			} else { // semakkan tarikh tidak bertindih dengan cuti am
			  $insertGoTo = $url_main . "admin/staffleavedetail.php?el=4&id=" . getUserIDByStafID($_POST['user_stafid']);
			};
			} else { // semakkan tarikh tidak bertindih dengan cuti lain
			  $insertGoTo = $url_main . "admin/staffleavedetail.php?el=3&id=" . getUserIDByStafID($_POST['user_stafid']);
			}; 
			} else { // user tidak aktif
			  $insertGoTo = $url_main . "admin/staffleavedetail.php?e=3&id=" . getUserIDByStafID($_POST['user_stafid']);
			};
		} else { // semakkan jantina utk cuti bersalin
			  $insertGoTo = $url_main . "admin/staffleavedetail.php?el=2&id=" . getUserIDByStafID($_POST['user_stafid']);
		};
	};
} else { // semakkn user akses
	  $insertGoTo .= "?eul=1";
};

header(sprintf("Location: %s", $insertGoTo));
?>
