<?php require_once('../Connections/hrmsdb.php');?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php //include('../sb/email.php');?>
<?php
$GoTo = $url_main . "main.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "apply")) 
{
		$msg = "&msg=add";
		
		if($_POST['url']=='2')
			$GoTo = $url_main . "admin/coursesdetail.php?id=" . htmlspecialchars($_POST['courses_id'], ENT_QUOTES);
		else
			$GoTo = $url_main . "courses/coursesdetail.php?id=" . getID(htmlspecialchars($_POST['courses_id'], ENT_QUOTES));
		
		if(isset($_POST['usercourses_as']))
			$ucas = htmlspecialchars($_POST['usercourses_as'], ENT_QUOTES);
		else
			$ucas = '0';
			
	if(checkStafID($_POST['user_stafid']))
	{	
		if($_POST['url']=='1' || $_POST['user_stafid']!=$row_user['user_stafid'])
		{
			if(!checkUserCoursesEntry($_POST['user_stafid'],$_POST['courses_id']))
			{
				if($_POST['url']=='1')
				{
					$insertSQL = sprintf("INSERT INTO user_courses (usercourses_by, usercourses_date, user_stafid, courses_id, usercourses_as) VALUES (%s, %s, %s, %s, %s)",
									   GetSQLValueString($_SESSION['user_stafid'], "text"),
									   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
									   GetSQLValueString(strtoupper($_POST['user_stafid']), "text"),
									   GetSQLValueString($_POST['courses_id'], "int"),
									   GetSQLValueString($ucas, "int"));
									   
				} else if($_POST['url']=='2'){
					
					if(!checkEndDate($_POST['courses_id']))
					{
						$appby = $row_user['user_stafid'];
						$appdate = date('d/m/Y h:i:s A');
						
					} else {
						$appby = NULL;
						$appdate = NULL;
						
					};
					
					$insertSQL = sprintf("INSERT INTO user_courses (usercourses_by, usercourses_date, user_stafid, courses_id, usercourses_as, usercourses_approvalby, usercourses_approvaldate) VALUES (%s, %s, %s, %s, %s, %s, %s)",
									   GetSQLValueString($row_user['user_stafid'], "text"),
									   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
									   GetSQLValueString(strtoupper($_POST['user_stafid']), "text"),
									   GetSQLValueString($_POST['courses_id'], "int"),
									   GetSQLValueString($ucas, "int"),
									   GetSQLValueString($appby, "text"),
									   GetSQLValueString($appdate, "text"));
				}
		
				mysql_select_db($database_hrmsdb, $hrmsdb);
				$Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
				  
				$emailto = array(); // array StafID penerima email
				$emailto[] = htmlspecialchars($_POST['user_stafid'], ENT_QUOTES); // array emailstafid[0] = pemohon no fail
				
				if(getHeadIDByUserID($_POST['user_stafid'])!=NULL)
				  $emailto[] = getHeadIDByUserID($_POST['user_stafid']); // array emailstafid[1] = Ketua Unit No Fail
				  
				//$coursesid = getCoursesID($_POST['user_stafid'], $_POST['courses_id']);
				
				if($_POST['url']=='2')
				  mail($emailto, 0, 0, 1, $coursesid);
				else
				  mail ($emailto, 0, 0, 2, $coursesid);
				  
			} else {
				$msg = "&e=1"; // pertindihan pendaftar
			};
			
		} else {
			$msg = "&ec=2"; // tidak boleh mendaftar utk diri sendiri
		};
		
	} else {
			$msg = "&e=2"; // user tidak didaftarkan atau tidak aktif
	};
	
	$GoTo .= $msg;
	
} else {
	$GoTo .= "&msg=error";
};

header(sprintf("Location: %s", $GoTo));
?>