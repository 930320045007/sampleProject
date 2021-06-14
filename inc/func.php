<?php
function getDKey()
{
	return 'a1b2c3d4e5';	
}

function getPassKey($key, $convert=1)
{
	$vowels = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "1", "2", "3");
	$newvowels = array(".", "}", "&", ">", "+", "|", "~", "!", "<", ":", "(", "-", "?");
	if($convert==1)
		$newkey = str_replace($vowels, $newvowels, $key);
	else
		$newkey = str_replace($newvowels, $vowels, $key);
	
	return $newkey;
}

function getID($id, $convert=1)
{
	$vowels = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
	$newvowels = array("iGyu", "ceoW", "zZKal", "mCwpd", "Fwopk", "qxAw", "kDfB", "fffH", "nJs", "nckSd");
	if($convert==1)
		$newkey = str_replace($vowels, $newvowels, $id);
	else
		$newkey = str_replace($newvowels, $vowels, $id);
	
	return $newkey;
}

function getPassOldByUserID($user)
{
	$query_userid = "SELECT login_password FROM www.login WHERE login.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND login.login_status = '1'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	return $row_userid['login_password'];
}

function getComparePassByUserID($user)
{	
	if(getPassKey(getPassOldByUserID($user))!= getPassKey(getDKey()))
		$pass = true;
	else
		$pass = false;
		
	return $pass;
}

function checkPassDateFail($user)
{
	//semakkan tarikh masih dalam tempoh 2 minggu dari tarikh semakkan sebelum ini.
	$query_userid = "SELECT fail.* FROM www.fail WHERE fail.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND fail_status='1' ORDER BY fail_date_y DESC, fail_date_m DESC, fail_date_d DESC, fail_id DESC";
	
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	$total = mysql_num_rows($userid);
	
	if($total > 0)
	{
		$week2 = mktime(0, 0, 0, $row_userid['fail_date_m'], $row_userid['fail_date_d']+14,$row_userid['fail_date_y']);
		$today = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		
		if($week2 > $today)
		{
			$view = true; // masih dlm tempuh 2 minggu.
		} else {
			$view = false;
		};
	} else {
		$view = false;
	}
	
	return $view;
}

function getStafIDByUserID($id)
{
	$query_userid = "SELECT user_stafid FROM www.user WHERE user_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	return $row_userid['user_stafid'];
}

function checkStafID($user)
{
	$query_userid = "SELECT user_id FROM www.user WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	$total = mysql_num_rows($userid);
	
	if($total > 0 && getStatusByStafID($user)==1)
		return true;
	else
		return false;
}

function checkStafIC($user ,$useric)
{
	$query_useric = "SELECT user_noic FROM www.user WHERE user_noic = '" . htmlspecialchars($useric, ENT_QUOTES) . "'";
	$usericc = mysql_query($query_useric);
	$row_useric = mysql_fetch_assoc($usericc);
	
	$total = mysql_num_rows($usericc);
	
	if($total > 0 && getStatusByStafID($user)==1)
		return true;
	else
		return false;
}

function getStafIDByEmail($emails)
{
	$query_userid = "SELECT login.user_stafid, login.login_username FROM www.login WHERE login.login_username = '" . $emails . "' AND login.login_status = '1'";
	// echo $query_userid;

	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	return $row_userid['user_stafid'];
}
function getStafIDByEmailLike($emails)
{
	$query_userid = "SELECT login.user_stafid, login.login_username FROM www.login WHERE login.login_username like '%" . $emails . "%' AND login.login_status = '1'";
	// echo $query_userid;
	
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	return $row_userid['user_stafid'];
}
function getUserIDByStafID($user)
{
	$query_userid = "SELECT user_id FROM www.user WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	return $row_userid['user_id'];
}

function getTitle($id)
{
	$query_userid = "SELECT title_name FROM www.title WHERE title_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	return $row_userid['title_name'];
}

function checkProfilePic($id)
{
	$query_userid = "SELECT userpic_url FROM www.user_pic WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND userpic_status = '1'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	$total = mysql_num_rows($userid);
	
	if($total>0)
		return true;
	else
		return false;
}

function getImgSize()
{
	return 500000; // upload img 500Kb
}

function getImgWidth()
{
	return 10000; // width 50px
}

function getImgHeight()
{
	return 10000; // width 50px
}

function getProfilePic($id)
{
	$query_userid = "SELECT userpic_url FROM www.user_pic WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND userpic_status = '1'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	if($row_userid['userpic_url']!=NULL)
		return $GLOBALS['url_main'] . "pic/" . $row_userid['userpic_url'];
	else
		return $GLOBALS['url_main'] . "icon/user.jpg";
}

function viewProfilePic($id)
{
	return "<img align=\"top\" class=\"pic\" width=\"50\" height=\"50\" src=\"" . getProfilePic($id) . "\" />";
}

function viewProfilePicIcon($id, $size=0)
{
	if($size==1)
		$px = 100;
	else
		$px = 30;
		
	return "<img align=\"top\" class=\"pic\" width=\"" . $px . "\" height=\"" . $px . "\" src=\"" . getProfilePic($id) . "\" />";
}

function getFullNameByStafID($user, $typev=0)
{
	$view = "";
	$query_userid = "SELECT title_id, user_firstname, user_lastname, user_race, user_gender, user_nationality, religion_id FROM www.user WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	if($row_userid['title_id']!=0 && $typev==0)
		$view .= getTitle($row_userid['title_id']) . " ";
	elseif($row_userid['title_id']==0 && $typev==0 && $row_userid['user_nationality']=='130')
	{
		if($row_userid['user_gender']=='1')
			$view .= "En. ";
		else
		{
			if(getMaritalByUserID($user)=='1')
				$view .= "Cik. ";
			else
				$view .= "Pn. ";
		};
	} elseif($row_userid['user_nationality']!='130') {
		if($row_userid['user_gender']=='1')
			$view .= "Mr. ";
		else
		{
			if(getMaritalByUserID($user)=='1')
				$view .= "Ms. ";
			else
				$view .= "Mrs. ";
		};
	};
		
	if($row_userid['user_race'] == '1' && $row_userid['user_nationality'] == '130')
	{
		//Melayu
		if($row_userid['user_lastname'] == '.' )
		{
			$middle = "";
		}
		else if($row_userid['user_gender']=='1')
			$middle = "bin";
		else
			$middle = "binti";
	} elseif($row_userid['user_race'] == '3' && $row_userid['user_nationality'] == '130') 
	{
		//India
		if($row_userid['user_gender']=='1')
			$middle = "a/l";
		else
			$middle = "a/p";
	} else {
		$middle = "";
	};
		
	$view .= $row_userid['user_firstname'];
	
	if($middle!="")
		$view .= " " . $middle . " ";
	else
		$view .= " ";
	
	$lastname= "";
	if($row_userid['user_lastname'] == '.')
	{
		$view .= $lastname;
	}
	else
	$view .= $row_userid['user_lastname'];
	
	return strtoupper($view);
}

function getFullNameByStafIDKew8($user, $typev=0)
{
	$view = "";
	$query_userid = "SELECT title_id, user_firstname, user_lastname, user_race, user_gender, user_nationality, religion_id FROM www.user WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	if($row_userid['title_id']!=0 && $typev==0)
		$view .= getTitle($row_userid['title_id']) . " ";
		
	if($row_userid['user_race'] == '1' && $row_userid['user_nationality'] == '130')
	{
		//Melayu
		if($row_userid['user_gender']=='1')
			$middle = "bin";
		else
			$middle = "binti";
	} elseif($row_userid['user_race'] == '3' && $row_userid['user_nationality'] == '130') 
	{
		//India
		if($row_userid['user_gender']=='1')
			$middle = "a/l";
		else
			$middle = "a/p";
	} else {
		$middle = "";
	};
		
	$view .= $row_userid['user_firstname'];
	
	if($middle!="")
		$view .= " " . $middle . " ";
	else
		$view .= " ";
		
	$view .= $row_userid['user_lastname'];
	
	return strtoupper($view);
}

function getShortNameByStafID($user)
{
	$query_userid = "SELECT title_id, user_firstname, user_lastname, user_race FROM www.user WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	if($row_userid['user_race']==1) // Melayu
		$view = $row_userid['user_firstname'];
	else if($row_userid['user_race']==2) // Cina
		$view = $row_userid['user_firstname'] . " " . $row_userid['user_lastname'];
	else if($row_userid['user_race']==3) // India
		$view = $row_userid['user_firstname'];
	else if($row_userid['user_race']==4) // Bumiputera
		$view = $row_userid['user_firstname'] . " " . $row_userid['user_lastname'];
	else // lain-lain
		$view = $row_userid['user_firstname'] . " " . $row_userid['user_lastname'];

	return strtoupper($view);
}

function getICNoByStafID($id)
{
	$query_userid = "SELECT user_noic FROM www.user WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	return $row_userid['user_noic'];
}

function checkAddressByStafID($id)
{
	$query_userid = "SELECT userpersonal_address, userpersonal_zip, userpersonal_city FROM www.user_personal WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	if($row_userid['userpersonal_address']!=NULL && $row_userid['userpersonal_zip']!=NULL && $row_userid['userpersonal_city']!=NULL)
		return true;
	else
		return false;
}

function getAddressByStafID($id)
{
	$query_userid = "SELECT userpersonal_address, userpersonal_address2, userpersonal_address3, userpersonal_zip, userpersonal_city, userpersonal_state FROM www.user_personal WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	$add = "";
	if($row_userid['userpersonal_address']!=NULL) 
		$add .= $row_userid['userpersonal_address'] . ", ";
	if($row_userid['userpersonal_address2']!=NULL) 
		$add .= $row_userid['userpersonal_address2'] . ", ";
	if($row_userid['userpersonal_address3']!=NULL) 
		$add .= $row_userid['userpersonal_address3'] . ", ";
	if($row_userid['userpersonal_zip']!=NULL) 
		$add .= $row_userid['userpersonal_zip'] . " ";
	if($row_userid['userpersonal_city']!=NULL) 
		$add .= $row_userid['userpersonal_city'] . ", ";
	if($row_userid['userpersonal_state']!=NULL) 
		$add .= getState($row_userid['userpersonal_state']);
	
	return strtoupper($add);
}

function getShortAddressByStafID($id)
{
	$query_userid = "SELECT userpersonal_address, userpersonal_address2, userpersonal_address3 FROM www.user_personal WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	$add = "";
	if($row_userid['userpersonal_address']!=NULL) 
		$add .= $row_userid['userpersonal_address'] . ", ";
	if($row_userid['userpersonal_address2']!=NULL) 
		$add .= $row_userid['userpersonal_address2'] . ", ";
	if($row_userid['userpersonal_address3']!=NULL) 
		$add .= $row_userid['userpersonal_address3'];
	
	return strtoupper($add);
}

function getAddressZipByStafID($id)
{
	$query_userid = "SELECT userpersonal_zip FROM www.user_personal WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	return $row_userid['userpersonal_zip'];
}

function getAddressCityByStafID($id)
{
	$query_userid = "SELECT userpersonal_city FROM www.user_personal WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	return $row_userid['userpersonal_city'];
}

function getAddressStateByStafID($id)
{
	$query_userid = "SELECT userpersonal_state FROM www.user_personal WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	return $row_userid['userpersonal_state'];
}

function checkTelMByStafID($id)
{
	if(getTelMByStafID($id)!=NULL)
		return true;
	else
		return false;
}

function getTelMByStafID($id)
{
	$query_userid = "SELECT userpersonal_telm FROM www.user_personal WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	return $row_userid['userpersonal_telm'];
}

function getGender($gender){
		if($gender=='1')
			$viewgender = "Lelaki";
		else
			$viewgender = "Perempuan";
			
	return $viewgender;
}

function getGenderIDByUserID($user)
{
	$query_userid = "SELECT user_gender FROM www.user WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	return $row_userid['user_gender'];
}

 function getAgeByUserID($user)
{
	if(isset($_POST['bulan']))
	{
		$dy = explode("/", $_POST['bulan']);
		$m = $dy[0];
		$y = $dy[1];
	}else {
		$m = date('m');
		$y = date('Y');
	}
	$query_userid = "SELECT user_dob_y, user_dob_m FROM www.user WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	if($m >= $row_userid['user_dob_m'])
	$date= $y-$row_userid['user_dob_y'];
else 
	$date = ($y -$row_userid['user_dob_y']) - 1;
	return $date;
}

function getDobByUserID($user)
{
	//tarikh lahir user
	$query_userid = "SELECT user_dob_d, user_dob_m, user_dob_y FROM www.user WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	return date('d / m / Y', mktime(0, 0, 0, $row_userid['user_dob_m'], $row_userid['user_dob_d'], $row_userid['user_dob_y']));
	
}

function getMarital($marital)
{
	$query_user_marital = "SELECT marital_name FROM www.marital WHERE marital_id = '" . htmlspecialchars($marital, ENT_QUOTES) . "'";
	$user_marital = mysql_query($query_user_marital);
	$row_marital = mysql_fetch_assoc($user_marital);
	
	return strtoupper($row_marital['marital_name']);
}

function getMaritalByUserID($user)
{
	$query_user_marital = "SELECT userpersonal_marital FROM www.user_personal WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";
	$user_marital = mysql_query($query_user_marital);
	$row_marital = mysql_fetch_assoc($user_marital);
	
	return $row_marital['userpersonal_marital'];
}

function getHusbandWifeIDByUserID($user)
{
	$query_user_marital = "SELECT userec_id FROM www.user_ec WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND (userec_relation = '8' OR userec_relation = '9') AND userec_status = '1'";
	$user_marital = mysql_query($query_user_marital);
	$row_marital = mysql_fetch_assoc($user_marital);
	
	$re = array();
	
	do{
		$re[] = $row_marital['userec_id'];
	}while($row_marital = mysql_fetch_assoc($user_marital));
	
	return $re;
}

function getECByUserID($user)
{
	$query_user_marital = "SELECT userec_id FROM www.user_ec WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userec_status = '1' ORDER BY userec_id DESC LIMIT 1";
	$user_marital = mysql_query($query_user_marital);
	$row_marital = mysql_fetch_assoc($user_marital);
	
	return $row_marital['userec_id'];
}

function getHusbandWifeNameByID($id)
{
	$query_user_marital = "SELECT userec_name FROM www.user_ec WHERE userec_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND userec_status = '1'";
	$user_marital = mysql_query($query_user_marital);
	$row_marital = mysql_fetch_assoc($user_marital);
	
	return strtoupper($row_marital['userec_name']);
}

function getHusbandWifeTelMByID($id)
{
	$query_user_marital = "SELECT userec_telm FROM www.user_ec WHERE userec_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND userec_status = '1'";
	$user_marital = mysql_query($query_user_marital);
	$row_marital = mysql_fetch_assoc($user_marital);
	
	return strtoupper($row_marital['userec_telm']);
}

function getRaceByUserID($user)
{
	$query_user_marital = "SELECT user_race FROM www.user WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";
	$user_marital = mysql_query($query_user_marital);
	$row_marital = mysql_fetch_assoc($user_marital);
	
	return $row_marital['user_race'];
}

function getRace($race){
	$query_user_race = "SELECT race_name FROM www.race WHERE race_id = '" . htmlspecialchars($race, ENT_QUOTES) . "'";
	$user_race = mysql_query($query_user_race);
	$row_race = mysql_fetch_assoc($user_race);
	
	return strtoupper($row_race['race_name']);
}

function getReligion($rg){
	$query_user_rg = "SELECT religion_name FROM www.religion WHERE religion_id = '" . htmlspecialchars($rg, ENT_QUOTES) . "'";
	$user_rg = mysql_query($query_user_rg);
	$row_rg = mysql_fetch_assoc($user_rg);
	
	return strtoupper($row_rg['religion_name']);
}

function getReligionByUserID($user){
	$query_user_rg = "SELECT religion_id FROM www.user WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";
	$user_rg = mysql_query($query_user_rg);
	$row_rg = mysql_fetch_assoc($user_rg);
	
	return $row_rg['religion_id'];
}

function getSize($user)
{
	$query_user_marital = "SELECT userpersonal_size FROM www.user_personal WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";
	$user_marital = mysql_query($query_user_marital);
	$row_marital = mysql_fetch_assoc($user_marital);
	
	if($row_marital['userpersonal_size']==NULL)
		return "-";
	else
		return $row_marital['userpersonal_size'];
}

function getStafIDByEduID($id)
{
	$query_user_edu = "SELECT user_stafid FROM www.user_edu WHERE useredu_status = 1 AND useredu_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$user_edu = mysql_query($query_user_edu);
	$row_edu = mysql_fetch_assoc($user_edu);
	
	return $row_edu['user_stafid'];
}

function getEduLevelByStafID($id)
{
	$query_user_edu = "SELECT useredu_level FROM www.user_edu WHERE useredu_status = 1 AND user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY useredu_year DESC LIMIT 1";
	$user_edu = mysql_query($query_user_edu);
	$row_edu = mysql_fetch_assoc($user_edu);
	
	return $row_edu['useredu_level'];
}

function getEduMajorByStafID($id)
{
	$query_user_edu = "SELECT useredu_major FROM www.user_edu WHERE useredu_status = 1 AND user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY useredu_year DESC LIMIT 1";
	$user_edu = mysql_query($query_user_edu);
	$row_edu = mysql_fetch_assoc($user_edu);
	
	return $row_edu['useredu_major'];
}

function checkEdu($user)
{
	$query_user_edu = "SELECT useredu_id FROM www.user_edu WHERE useredu_status = 1 AND user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";
	$user_edu = mysql_query($query_user_edu);
	$row_edu = mysql_fetch_assoc($user_edu);
	
	$total = mysql_num_rows($user_edu);
	
	if($total > 0)
		return true;
	else
		return false;
}

function getEduMajor($id)
{
	$query_user_edu = "SELECT useredu_major FROM www.user_edu WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$user_edu  = mysql_query($query_user_edu);
	$row_edu  = mysql_fetch_assoc($user_edu);
	
	return $row_edu['useredu_major'];
}	
	
function getEdulevel($edu) {
	if($edu!=NULL)
	{
		$query_user_edu = "SELECT edulevel_name FROM www.edu_level WHERE edulevel_id = '" . htmlspecialchars($edu, ENT_QUOTES) . "'";
		$user_edu = mysql_query($query_user_edu);
		$row_edu = mysql_fetch_assoc($user_edu);
		
		$vedu = $row_edu['edulevel_name'];
	} else 
		$vedu = "Lain-lain";
	
	return $vedu;
}

function getEduSubjek($subjekid)
{	if($subjekid!=NULL)
	{
	$query_user_edu = "SELECT edusubjek_name FROM www.edu_subjek WHERE edusubjek_id = '" . htmlspecialchars($subjekid , ENT_QUOTES). "'";
	$user_edu = mysql_query($query_user_edu);
	$row_edu = mysql_fetch_assoc($user_edu);
	
	$vedu = $row_edu['edusubjek_name'];
	} else 
		$vedu = "Lain-lain";
	
	return $vedu;
}

function getEduGred($gredid)
{	if($gredid!=NULL)
	{
	$query_user_edu = "SELECT edugred_name FROM www.edu_gred WHERE edugred_id = '" . htmlspecialchars($gredid, ENT_QUOTES) . "'";
	$user_edu = mysql_query($query_user_edu);
	$row_edu = mysql_fetch_assoc($user_edu);
	
	$vedu = $row_edu['edugred_name'];
	} else 
		$vedu = "-";
	
	return $vedu;
}

function checkEduResult($id)
{
	$query_user_edu = "SELECT edulevel_result FROM www.edu_level WHERE edulevel_status = '1' AND edulevel_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$user_edu = mysql_query($query_user_edu);
	$row_edu = mysql_fetch_assoc($user_edu);
	
	if($row_edu['edulevel_result']=='1')
		return true;
	else
		return false;
}

function checkEduResultSubmit($user, $id=0)
{
	$query_user_edu = "SELECT usereduresult_id FROM www.user_eduresult WHERE usereduresult_status = '1' AND useredu_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";
	$user_edu = mysql_query($query_user_edu);
	$row_edu = mysql_fetch_assoc($user_edu);
	
	$total = mysql_num_rows($user_edu);
	
	if($total > 0)
		return true;
	else
		return false;
}

function getRelation($relation) 
{
	$query_rel = "SELECT relationship_name FROM www.relationship WHERE relationship_id = '" . htmlspecialchars($relation, ENT_QUOTES) . "'";
	$user_rel = mysql_query($query_rel);
	$row_rel = mysql_fetch_assoc($user_rel);
	
	return $row_rel['relationship_name'];
}

function checkWaris($user)
{
	$query_rel = "SELECT userec_id FROM www.user_ec WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userec_status = 1";
	$user_rel = mysql_query($query_rel);
	$row_rel = mysql_fetch_assoc($user_rel);
	
	$total = mysql_num_rows($user_rel);
	
	if($total>0)
		return true;
	else
		return false;
}

function getPassport($passport) {
	switch ($passport) {
    case 1:
        $viewpass = "Passport";
        break;
    case 2:
        $viewpass = "Visa";
        break;
	}
	
	return $viewpass;
}

function getPassportByUserID($user)
{
	  $query_s = "SELECT userpassport_no FROM www.user_passport WHERE user_passport.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";
	  $user_s = mysql_query($query_s);
	  $row_s = mysql_fetch_assoc($user_s);
	  
	  $total = mysql_num_rows($user_s);
	  
	  if($total > 0)
		$pass = $row_s['userpassport_no'];
	  else
	  	$pass = "0";
		
		return $pass;
}

function getState($state) 
{
	$query_s = "SELECT state_id, state_name FROM www.state WHERE state_id = '" . htmlspecialchars($state, ENT_QUOTES) . "'";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	return strtoupper($row_s['state_name']);
}

function getStartDayDate($id, $dmy=0)
{
		$query_s = "SELECT userjob_start_d, userjob_start_m, userjob_start_y FROM www.user_job WHERE user_job.userjob_status = '1' AND user_job.user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
		$user_s = mysql_query($query_s);
		$row_s = mysql_fetch_assoc($user_s);
		
		if($dmy==1)
			return $row_s['userjob_start_d'];
		else if($dmy==2)
			return $row_s['userjob_start_m'];
		else if($dmy==3)
			return $row_s['userjob_start_y'];
		else
			return date('d / m / Y (D)', mktime(0, 0, 0, $row_s['userjob_start_m'], $row_s['userjob_start_d'], $row_s['userjob_start_y']));
}

function getInDayDate($id, $dmy=0)
{
		$query_s = "SELECT userjob_in_d, userjob_in_m, userjob_in_y FROM www.user_job WHERE user_job.userjob_status = '1' AND user_job.user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
		$user_s = mysql_query($query_s);
		$row_s = mysql_fetch_assoc($user_s);
		
		if($dmy==1)
			return $row_s['userjob_in_d'];
		else if($dmy==2)
			return $row_s['userjob_in_m'];
		else if($dmy==3)
			return $row_s['userjob_in_y'];
		else
			return date('d / m / Y (D)', mktime(0, 0, 0, $row_s['userjob_in_m'], $row_s['userjob_in_d'], $row_s['userjob_in_y']));
}

function getInKontrakDayDate($id, $dmy=0)
{
		$query_s = "SELECT userjob_kontrak_start_d, userjob_kontrak_start_m, userjob_kontrak_start_y FROM www.user_job WHERE user_job.userjob_status = '1' AND user_job.user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
		$user_s = mysql_query($query_s);
		$row_s = mysql_fetch_assoc($user_s);
		
		if($dmy==1)
			return $row_s['userjob_kontrak_start_d'];
		else if($dmy==2)
			return $row_s['userjob_kontrak_start_m'];
		else if($dmy==3)
			return $row_s['userjob_kontrak_start_y'];
		else
			return date('d / m / Y (D)', mktime(0, 0, 0, $row_s['userjob_kontrak_start_m'], $row_s['userjob_kontrak_start_d'], $row_s['userjob_kontrak_start_y']));
}

function getPromotedDayDate($id, $dmy=0)
{
		$query_s = "SELECT userjob_promoted_d, userjob_promoted_m, userjob_promoted_y FROM www.user_job WHERE user_job.userjob_status = '1' AND user_job.user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
		$user_s = mysql_query($query_s);
		$row_s = mysql_fetch_assoc($user_s);
		
		if($dmy==1)
			return $row_s['userjob_promoted_d'];
		else if($dmy==2)
			return $row_s['userjob_promoted_m'];
		else if($dmy==3)
			return $row_s['userjob_promoted_y'];
		else
			return date('d / m / Y (D)', mktime(0, 0, 0, $row_s['userjob_promoted_m'], $row_s['userjob_promoted_d'], $row_s['userjob_promoted_y']));
}

function checkStartDateByMonth($id, $m, $y)
{
	$query_s = "SELECT userjob_start_d, userjob_start_m, userjob_start_y FROM www.user_job WHERE user_job.userjob_status = '1' AND user_job.user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	if(($m >= $row_s['userjob_start_m'] && $y == $row_s['userjob_start_y']) || $y > $row_s['userjob_start_y'])
		return true;
	else
		return false;		
}

function getJobtitle($user){
	$query_s = "SELECT scheme.scheme_name FROM www.user_scheme LEFT JOIN www.scheme ON scheme.scheme_id = user_scheme.scheme_id WHERE userscheme_status = '1' AND user_scheme.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' ORDER BY userscheme_in_y DESC, userscheme_in_m DESC, userscheme_in_d DESC, userscheme_id DESC";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	if(checkJob2($user))
		$view = strtoupper(getJobtitle2($user, 1));
	else
		$view = strtoupper($row_s['scheme_name']);
		
	return $view;
}

function getJobtitleReal($user){
	$query_s = "SELECT scheme.scheme_name FROM www.user_scheme LEFT JOIN www.scheme ON scheme.scheme_id = user_scheme.scheme_id WHERE userscheme_status = '1' AND user_scheme.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' ORDER BY userscheme_in_y DESC, userscheme_in_m DESC, userscheme_in_d DESC, userscheme_id DESC";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);

	$view = strtoupper($row_s['scheme_name']);
	
	return $view;
}

function getGred($userid, $uscid=0)
{
	if($uscid != 0)
		$wsql = " AND user_scheme.userscheme_id='" . htmlspecialchars($uscid, ENT_QUOTES) . "'";
	else
		$wsql = "";

	$query_s = "SELECT classification.classification_code, user_scheme.userscheme_gred, user_scheme.userscheme_no, scheme.scheme_code2 FROM www.user_scheme LEFT JOIN www.scheme ON scheme.scheme_id = user_scheme.scheme_id LEFT JOIN www.classification ON classification.classification_id = scheme.classification_id WHERE user_scheme.user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND user_scheme.userscheme_status = '1' " . $wsql . " ORDER BY userscheme_in_y DESC, userscheme_in_m DESC, userscheme_in_d DESC, userscheme_id DESC";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);

	if($row_s['userscheme_gred']==0)
	{
		$gred = getGredKhasTitle($userid);
		
	}if($row_s['userscheme_no']==0 || $row_s['scheme_code2']=="")
		$userscheme_gred = str_replace (" ", "", $row_s['userscheme_gred']);
		$gred = $row_s['classification_code'] . $userscheme_gred;
	
	if($row_s['userscheme_no']==1)
		$gred = $row_s['userscheme_gred'];
	
	if ($row_s['userscheme_no']==2)
		$gred = 'TERBUKA '  . $row_s['userscheme_gred'];
		
	if($row_s['scheme_code2']!="")
		$gred = $row_s['classification_code'] . $row_s['scheme_code2'] . $row_s['userscheme_gred'];

	return $gred;
}

function getGredByKew8($userid, $y)
{
	$query_s = "SELECT classification.classification_code, user_scheme.userscheme_gred, user_scheme.userscheme_no, scheme.scheme_code2 FROM www.user_scheme LEFT JOIN www.scheme ON scheme.scheme_id = user_scheme.scheme_id LEFT JOIN www.classification ON classification.classification_id = scheme.classification_id WHERE user_scheme.user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND user_scheme.userscheme_status = '1' AND user_scheme.userscheme_in_y < ". $y ." ORDER BY userscheme_in_y DESC, userscheme_in_m DESC, userscheme_in_d DESC, userscheme_id DESC";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);

	if($row_s['userscheme_gred']==0)
	{
		$gred = getGredKhasTitle($userid);
		
	}if($row_s['userscheme_no']==0 || $row_s['scheme_code2']=="")
		$userscheme_gred = str_replace (" ", "", $row_s['userscheme_gred']);
		$gred = $row_s['classification_code'] . $userscheme_gred;
	
	if($row_s['userscheme_no']==1)
		$gred = $row_s['userscheme_gred'];
	
	if ($row_s['userscheme_no']==2)
		$gred = 'TERBUKA '  . $row_s['userscheme_gred'];
		
	if($row_s['scheme_code2']!="")
		$gred = $row_s['classification_code'] . $row_s['scheme_code2'] . $row_s['userscheme_gred'];

	return $gred;
}

function getGredByStafID($id)
{
	$query_gred = "SELECT userscheme_gred FROM www.user_scheme  WHERE userscheme_status = '1' AND user_scheme.user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY userscheme_in_y DESC, userscheme_in_m DESC, userscheme_in_d DESC, userscheme_id DESC LIMIT 1";
	$user_gred = mysql_query($query_gred);
	$row_gred = mysql_fetch_assoc($user_gred);
	
	return $row_gred['userscheme_gred'];
}

function getClassCodeByStafID($id)
{
	//memanggil class code mengikut staf id cth: R untuk pemandu

	$query_gred = "SELECT classification.classification_code FROM www.user_scheme LEFT JOIN www.scheme ON scheme.scheme_id = user_scheme.scheme_id LEFT JOIN www.classification ON classification.classification_id = scheme.classification_id WHERE userscheme_status = '1' AND user_scheme.user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY userscheme_in_y DESC, userscheme_in_m DESC, userscheme_in_d DESC, userscheme_id DESC LIMIT 1";
	$user_gred = mysql_query($query_gred);
	$row_gred = mysql_fetch_assoc($user_gred);

	return $row_gred['classification_code'];
}

function getGredKhasTitle($userid)
{
	$query_s = "SELECT user_scheme.*, gredkhas_name FROM www.user_scheme LEFT JOIN www.gredkhas ON gredkhas.gredkhas_id = user_scheme.gredkhas_id WHERE user_scheme.user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND user_scheme.userscheme_status = '1' ORDER BY userscheme_in_y DESC, userscheme_in_m DESC, userscheme_in_d DESC, userscheme_id DESC";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	if($row_s['gredkhas_id']!=0)
		$view = $row_s['gredkhas_name'];
	else
		$view = '-';
		
	return $view;
}

function checkNoScheme($user)
{
	$query_s = "SELECT userscheme_no FROM www.user_scheme WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userscheme_status='1' ORDER BY userscheme_in_y DESC, userscheme_in_m DESC, userscheme_in_d DESC, userscheme_id DESC";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);

	if($row_s['userscheme_no']!='0')
		return true;
	else
		return false;
}

function checkNoSchemeBySchemeID($schemeid)
{
	$query_s = "SELECT userscheme_no FROM www.user_scheme WHERE userscheme_id = '" . htmlspecialchars($schemeid, ENT_QUOTES) . "' AND userscheme_status='1' ORDER BY userscheme_in_y DESC, userscheme_in_m DESC, userscheme_in_d DESC, userscheme_id DESC";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);

	if($row_s['userscheme_no']!='0')
		return true;
	else
		return false;
}

function getNoSchemeBySchemeID($schemeid)
{
	$query_s = "SELECT userscheme_no FROM www.user_scheme WHERE userscheme_id = '" . htmlspecialchars($schemeid, ENT_QUOTES) . "' AND userscheme_status='1' ORDER BY userscheme_in_y DESC, userscheme_in_m DESC, userscheme_in_d DESC, userscheme_id DESC";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);

	if($row_s['userscheme_no']=='1')
		$view='TIDAK BERSKIM';
	else if($row_s['userscheme_no']=='2')
		$view='JAWATAN TERBUKA';
	else
		$view='';
		
	return $view;
}

function getNoSchemeByUserID($userid)
{
	$query_s = "SELECT userscheme_no FROM www.user_scheme WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND userscheme_status='1' ORDER BY userscheme_in_y DESC, userscheme_in_m DESC, userscheme_in_d DESC, userscheme_id DESC";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);

	if($row_s['userscheme_no']=='1')
		$view='TIDAK BERSKIM';
	else if($row_s['userscheme_no']=='2')
		$view='JAWATAN TERBUKA';
	else
		$view='';

	return $view;
}

function getSchemeNameByID($id)
{
	if($id!='0')
	{
		$query_s = "SELECT scheme_name, classification.classification_name FROM www.scheme LEFT JOIN classification ON scheme.classification_id = classification.classification_id WHERE scheme_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
		$user_s = mysql_query($query_s);
		$row_s = mysql_fetch_assoc($user_s);

		$view = strtoupper($row_s['scheme_name'] . ", " . $row_s['classification_name']);
	} else {
		$view = "";
	}
	
	return $view;
}

function getSchemeDateByUserID($user)
{
	$query_s = "SELECT userscheme_in_d, userscheme_in_m,  userscheme_in_y FROM www.user_scheme WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userscheme_status='1' ORDER BY userscheme_in_y DESC, userscheme_in_m DESC, userscheme_in_d DESC, userscheme_id DESC";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	return $row_s['userscheme_in_d'] . "/" . $row_s['userscheme_in_m'] . "/" . $row_s['userscheme_in_y'];
}

function getClassificationAndCode2BySchemeID($scheme , $user=0)
{
	$query_s = "SELECT classification.classification_code, scheme_code2 FROM www.scheme LEFT JOIN classification ON scheme.classification_id = classification.classification_id WHERE scheme_id = '" . htmlspecialchars($scheme, ENT_QUOTES) . "'";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	if(!checkNoScheme($user))
		$view = $row_s['classification_code'] . $row_s['scheme_code2'];
	else
		$view = "";
	
	return $view;
}

function getSalarySkill($userid, $id, $m, $y)
{
	$sql = "";
	if($id!=0)
		$sql .= " AND usersalaryskill_id = '" . $id . "'";
	if($m!=0 && $y!=0)
		$sql .= " AND ((IFNULL(usersalaryskill_start_y, usersalaryskill_date_y) = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND IFNULL(usersalaryskill_start_m, usersalaryskill_date_m) <= '" . htmlspecialchars($m, ENT_QUOTES) . "') OR (IFNULL(usersalaryskill_start_y, usersalaryskill_date_y) < '" . htmlspecialchars($y, ENT_QUOTES) . "'))";

	$query_s = "SELECT usersalaryskill_code, usersalaryskill_code2 FROM www.user_salaryskill WHERE user_salaryskill.user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND user_salaryskill.usersalaryskill_status = '1' " . $sql . " ORDER BY usersalaryskill_date_y DESC, usersalaryskill_date_m DESC, usersalaryskill_date_d DESC, usersalaryskill_id DESC";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);

	if(getNoSchemeByUserID($userid)=='TIDAK BERSKIM')
		$view = "Tidak Berskim";	
	else if(getNoSchemeByUserID($userid)=='JAWATAN TERBUKA')
		$view = "Terbuka";
	else if($row_s['usersalaryskill_code2']==NULL )
		$view = $row_s['usersalaryskill_code'];
	else
	{
		$view = $row_s['usersalaryskill_code'];
		if($row_s['usersalaryskill_code2'] == '1')
			$view .= " " . " (Max)";
	};

	return $view;
}

function getSalarySkillDate($userid)
{
	$query_s = "SELECT usersalaryskill_date_d, usersalaryskill_date_m, usersalaryskill_date_y FROM www.user_salaryskill WHERE user_salaryskill.user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND user_salaryskill.usersalaryskill_status = '1' ORDER BY usersalaryskill_date_y DESC, usersalaryskill_date_m DESC, usersalaryskill_date_d DESC, usersalaryskill_id DESC";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	return $row_s['usersalaryskill_date_d'] . "/" . $row_s['usersalaryskill_date_m'] . "/" . $row_s['usersalaryskill_date_y'];
}

function getTPGByStafID($id)
{
	$query_ss = "SELECT userjob_tpg_m FROM www.user_job WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND userjob_status='1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['userjob_tpg_m'];
}

function getJobtitle2($user, $type=0)
{
	$query_s = "SELECT user_job2.jobss_id, jobss_name, jobss_shortname FROM www.user_job2 LEFT JOIN www.jobs_sub ON jobs_sub.jobss_id = user_job2.jobss_id WHERE user_job2.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND user_job2.userjob2_status = '1' ORDER BY userjob2_date_y DESC, userjob2_date_m DESC, userjob2_date_d DESC, userjob2_id DESC LIMIT 1";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	if($row_s['jobss_id']=='1' || $row_s['jobss_id']=='8')
		$jobss =  $row_s['jobss_name'] . " " . getDirTypeNameByDirTypeID(getDirTypeByDirID(getDirIDByUser($user)));
	else
	{
		$jobss =  $row_s['jobss_name'];
	//if($row_s['jobss_shortname']!="")
		$jobss .= " (" . $row_s['jobss_shortname'] . ")";
	}
	
	if($row_s['jobss_id']==NULL && $type==0)
		$jobss = "-";

	return strtoupper($jobss);
}

function getJobtitle2Date($user)
{
	$query_s = "SELECT userjob2_date_d, userjob2_date_m, userjob2_date_y FROM www.user_job2 LEFT JOIN www.jobs_sub ON jobs_sub.jobss_id = user_job2.jobss_id WHERE user_job2.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND user_job2.userjob2_status = '1' ORDER BY userjob2_date_y DESC, userjob2_date_m DESC, userjob2_date_d DESC, userjob2_id DESC";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	$total = mysql_num_rows($user_s);
	
	if($total>0)
		return date('d/m/Y', mktime(0, 0, 0, $row_s['userjob2_date_m'], $row_s['userjob2_date_d'], $row_s['userjob2_date_y']));
	else
		return "";
}

function getJob2Name($id)
{
	$query_s = "SELECT jobss_name, jobss_shortname FROM www.jobs_sub WHERE jobss_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	$jobss =  $row_s['jobss_name'];
	if($row_s['jobss_shortname']!="")
	$jobss .= " (" . $row_s['jobss_shortname'] . ")";

	return strtoupper($jobss);
}

function getJob2ID($user)
{
	if(checkJob2($user))
	{
		$query_s = "SELECT jobss_id FROM www.user_job2 WHERE user_job2.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND user_job2.userjob2_status = '1' ORDER BY userjob2_date_y DESC, userjob2_date_m DESC, userjob2_date_d DESC, userjob2_id DESC";
		$user_s = mysql_query($query_s);
		$row_s = mysql_fetch_assoc($user_s);
		$job2 = $row_s['jobss_id'];
	} else {
		$job2 = '0';
	}
		return $job2;
}

function getUserIDByJob2ID($jobtwo)
{
		$query_s = "SELECT user_job2.user_stafid FROM www.user_job2 LEFT JOIN www.login ON user_job2.user_stafid = login.user_stafid WHERE login.login_status = '1' AND user_job2.jobss_id = '" . htmlspecialchars($jobtwo, ENT_QUOTES) . "' AND user_job2.userjob2_status = '1' ORDER BY userjob2_id DESC, userjob2_date_y DESC, userjob2_date_m DESC, userjob2_date_d DESC LIMIT 1";
		$user_s = mysql_query($query_s);
		$row_s = mysql_fetch_assoc($user_s);
		
		return $row_s['user_stafid'];
}

function checkJob2View($user)
{
	$wsql = "";
	if(checkJob2($user))
		$wsql = " OR menu_id = '7'";

	$query_smenu2 = "SELECT * FROM www.menu WHERE EXISTS (SELECT * FROM www.user_sysacc WHERE usersysacc_status = 1 AND menu.menu_id = user_sysacc.menu_id AND user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "') AND menutype_id = 2 " . $wsql . " ORDER BY menu_id ASC";
	$smenu2 = mysql_query($query_smenu2);
	$row_smenu2 = mysql_fetch_assoc($smenu2);
	$total = mysql_num_rows($smenu2);	
	
	if($total > 0)
		return true;
	else
		return false;
}

function checkJob2($user)
{
	$query_s = "SELECT user_job2.user_stafid FROM www.user_job2 LEFT JOIN www.login ON login.user_stafid = user_job2.user_stafid WHERE login.login_status = '1' AND user_job2.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND user_job2.userjob2_status = '1' ORDER BY userjob2_id DESC, userjob2_date_y DESC, userjob2_date_m DESC, userjob2_date_d DESC";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	$total = mysql_num_rows($user_s);
	
	if($total > 0)
		return true;
	else
		return false;
}

function checkJob2Not1($user) // Not 1 = bukan ketua Unit, Modul Unit > leave.php 
{
	$query_s = "SELECT user_stafid FROM www.user_job2 WHERE user_job2.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND user_job2.userjob2_status = '1' AND user_job2.jobss_id >2 ORDER BY userjob2_date_y DESC, userjob2_date_m DESC, userjob2_date_d DESC, userjob2_id DESC";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	$total = mysql_num_rows($user_s);
	
	if($total > 0)
		return true;
	else
		return false;
}

function checkJob2is2($user) // 2 = KPE, Modul Unit > leave.php 
{
	$query_s = "SELECT user_stafid FROM www.user_job2 WHERE user_job2.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND user_job2.userjob2_status = '1' AND user_job2.jobss_id = '2' ORDER BY userjob2_date_y DESC, userjob2_date_m DESC, userjob2_date_d DESC, userjob2_id DESC";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	$total = mysql_num_rows($user_s);
	
	if($total > 0)
		return true;
	else
		return false;
}

function getJobtitle2ByID($id){
	$query_s = "SELECT jobss_name, jobss_shortname FROM www.user_job2 LEFT JOIN www.jobs_sub ON jobs_sub.jobss_id = user_job2.jobss_id WHERE user_job2.userjob2_status = '1' AND user_job2.userjob2_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY userjob2_date_y DESC, userjob2_date_m DESC, userjob2_date_d DESC, userjob2_id DESC";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	$jobss =  $row_s['jobss_name'];
	if($row_s['jobss_shortname']!="")
	$jobss .= " (" . $row_s['jobss_shortname'] . ")";
	
	if($jobss=="")
		$jobss = "-";

	return strtoupper($jobss);
}

function getJobtype($user){

	$query_jt = "SELECT job_type.jobtype_name FROM www.user_designation LEFT JOIN www.job_type ON job_type.jobtype_id = user_designation.jobtype_id WHERE user_designation.user_stafid= '" . htmlspecialchars($user, ENT_QUOTES) . "' AND user_designation.userdesignation_status = '1' ORDER BY userdesignation_date_y DESC, userdesignation_date_m DESC, userdesignation_date_d DESC, userdesignation_id DESC";
	$user_jt = mysql_query($query_jt);
	$row_jt = mysql_fetch_assoc($user_jt);
	
	return strtoupper($row_jt['jobtype_name']);
}

function getJobtypeIDByUserID($user) {

	$query_jt = "SELECT jobtype_id FROM www.user_designation WHERE user_designation.user_stafid= '" . htmlspecialchars($user, ENT_QUOTES) . "' AND user_designation.userdesignation_status = '1' ORDER BY userdesignation_date_y DESC, userdesignation_date_m DESC, userdesignation_date_d DESC, userdesignation_id DESC";
	$user_jt = mysql_query($query_jt);
	$row_jt = mysql_fetch_assoc($user_jt);
	
	return $row_jt['jobtype_id'];
}

function getSubJobtypeIDByUserID($user) {

	$query_jt = "SELECT subjobtype_id FROM www.user_designation WHERE user_designation.user_stafid= '" . htmlspecialchars($user, ENT_QUOTES) . "' AND user_designation.userdesignation_status = '1' ORDER BY userdesignation_date_y DESC, userdesignation_date_m DESC, userdesignation_date_d DESC, userdesignation_id DESC";
	$user_jt = mysql_query($query_jt);
	$row_jt = mysql_fetch_assoc($user_jt);
	
	return $row_jt['subjobtype_id'];
}

function getJobtypeByID($id){

	$query_jt = "SELECT job_type.jobtype_name FROM job_type WHERE job_type.jobtype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$user_jt = mysql_query($query_jt);
	$row_jt = mysql_fetch_assoc($user_jt);
	
	return strtoupper($row_jt['jobtype_name']);
}

function getDesignationType($user) // semakkan status user sebagai kontrak atau tetap
{
	$query_jt = "SELECT user_designation.jobtype_id FROM www.user_designation WHERE user_designation.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND user_designation.userdesignation_status = '1' ORDER BY userdesignation_date_y DESC, userdesignation_date_m DESC, userdesignation_date_d DESC, userdesignation_id DESC";
	$user_jt = mysql_query($query_jt);
	$row_jt = mysql_fetch_assoc($user_jt);
	
	if($row_jt['jobtype_id']==1) //tetap
		return true;
	else
		return false;
}

function getDesignationPeriod($user)
{
	$query_jt = "SELECT user_designation.userdesignation_period FROM www.user_designation WHERE user_designation.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND user_designation.userdesignation_status = '1' ORDER BY userdesignation_date_y DESC, userdesignation_date_m DESC, userdesignation_date_d DESC, userdesignation_id DESC";
	$user_jt = mysql_query($query_jt);
	$row_jt = mysql_fetch_assoc($user_jt);
	
	return $row_jt['userdesignation_period'] . " Bulan";
}

function getDesignationDate($user)
{
	$query_jt = "SELECT user_designation.userdesignation_date_d, user_designation.userdesignation_date_m, user_designation.userdesignation_date_y FROM www.user_designation WHERE user_designation.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND user_designation.userdesignation_status = '1' ORDER BY userdesignation_date_y DESC, userdesignation_date_m DESC, userdesignation_date_d DESC, userdesignation_id DESC";
	$user_jt = mysql_query($query_jt);
	$row_jt = mysql_fetch_assoc($user_jt);
	
	return $row_jt['userdesignation_date_d'] . "/" . $row_jt['userdesignation_date_m'] . "/" . $row_jt['userdesignation_date_y'];
}

function getEmailISNByUserID($user, $view=0)
{
	$query_l1 = "SELECT login_username FROM www.login WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";
	$user_l1 = mysql_query($query_l1);
	$row_l1 = mysql_fetch_assoc($user_l1);
	
	if($view!=0)
		$firstmail = strstr($row_l1['login_username'], '@', true);
	else
		$firstmail = $row_l1['login_username'];
			
	return $firstmail;
}

function checkEmailValid($user, $email)
{
	$query_ss = "SELECT * FROM www.login WHERE login.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND login_status='1'";
	$ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($ss);
	
	if($row_ss['login_username'] == $email)
		return true;
	else
		return false;
}

function checkEmailReg($email)
{
	$emailfull = $email . "@isn.gov.my";
	
	$query_ss = "SELECT login.* FROM www.login WHERE login.login_username = '" . htmlspecialchars($emailfull, ENT_QUOTES) . "' AND login_status='1'";
	$ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($ss);
	
	$total = mysql_num_rows($ss);
	
	if($total > 0)
		return true;
	else
		return false;
}

function getExtNoByUserID($user, $view=0)
{
	$query_s1 = "SELECT user_personal.userpersonal_telw, userpersonal_telo FROM www.user_personal WHERE user_personal.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";	
	$user_s1 = mysql_query($query_s1);
	$row_s1 = mysql_fetch_assoc($user_s1);
	
	if($view!=0 && $row_s1['userpersonal_telw']!=NULL)
		$extno = $GLOBALS['ext'] . $row_s1['userpersonal_telw'];
	else if($row_s1['userpersonal_telw']!=NULL)
		$extno = $row_s1['userpersonal_telw'];
	else if($row_s1['userpersonal_telo']!=NULL)
		$extno = $row_s1['userpersonal_telo'];
	else
		$extno = '-';
	
	return $extno;
}

function getDirIDByUser($user) // mendapatkan Unit ID mengikut User
{
	$query_l1 = "SELECT dir_id FROM www.user_unit WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userunit_status = '1' ORDER BY userunit_in_y DESC, userunit_in_m DESC, userunit_in_d DESC, userunit_id DESC LIMIT 1";
	$user_l1 = mysql_query($query_l1);
	$row_l1 = mysql_fetch_assoc($user_l1);
	
	return $row_l1['dir_id'];
}

function getDirDateByUser($user) // tarikh kuat kuasa penempatan
{
	$query_l1 = "SELECT userunit_in_d, userunit_in_m, userunit_in_y FROM www.user_unit WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userunit_status = '1' ORDER BY userunit_in_y DESC, userunit_in_m DESC, userunit_in_d DESC, userunit_id DESC LIMIT 1";
	$user_l1 = mysql_query($query_l1);
	$row_l1 = mysql_fetch_assoc($user_l1);
	
	return date('d/m/Y', mktime(0, 0, 0, $row_l1['userunit_in_m'], $row_l1['userunit_in_d'] , $row_l1['userunit_in_y']));
}

function getDirTypeByDirID($id)
{
	$query_l1 = "SELECT dir_type FROM www.dir WHERE dir_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$user_l1 = mysql_query($query_l1);
	$row_l1 = mysql_fetch_assoc($user_l1);
	
	return $row_l1['dir_type'];
}

function getDirTypeNameByDirTypeID($id)
{
	$query_l1 = "SELECT dirtype_name FROM www.dir_type WHERE dirtype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$user_l1 = mysql_query($query_l1);
	$row_l1 = mysql_fetch_assoc($user_l1);
	
	return $row_l1['dirtype_name'];
}

function getDirSubIDByUser($user) // mendapatkan Bahagian ID mengikut User. Digunakan bagi menyemak kursus mengikut Bahagian.
{
	$query_l1 = "SELECT dir.dir_sub FROM www.user_unit LEFT JOIN www.dir ON dir.dir_id = user_unit.dir_id WHERE user_unit.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userunit_status = '1' ORDER BY userunit_in_y DESC, userunit_in_m DESC, userunit_in_d DESC, userunit_id DESC";
	$user_l1 = mysql_query($query_l1);
	$row_l1 = mysql_fetch_assoc($user_l1);
	
	return $row_l1['dir_sub'];
}

function getDirSubName($dirsub)
{
	if($dirsub!=0)
	{
		$query_l1 = "SELECT dir_type.dirtype_name, dir.dir_name FROM www.dir LEFT JOIN dir_type ON dir_type.dirtype_id = dir.dir_type WHERE dir.dir_id = '" . htmlspecialchars($dirsub, ENT_QUOTES) . "'";
		$user_l1 = mysql_query($query_l1);
		$row_l1 = mysql_fetch_assoc($user_l1);
		
		$name = strtoupper($row_l1['dirtype_name'] . " " . $row_l1['dir_name']);
	
	} else {
		$name = "";
	};
	
	return $name;
}

function getFulldirectory($post=0, $type=1)
{
	$query_l1 = "SELECT dir.*, dir_type.dirtype_name FROM www.dir LEFT JOIN www.dir_type ON dir_type.dirtype_id = dir.dir_type WHERE dir.dir_id = '" . htmlspecialchars($post, ENT_QUOTES) . "'";
	$user_l1 = mysql_query($query_l1);
	$row_l1 = mysql_fetch_assoc($user_l1);
	
	$query_l2 = "SELECT dir.*, dir_type.dirtype_name FROM www.dir LEFT JOIN www.dir_type ON dir_type.dirtype_id = dir.dir_type WHERE dir.dir_id = '" . $row_l1['dir_sub'] . "'";
	$user_l2 = mysql_query($query_l2);
	$row_l2 = mysql_fetch_assoc($user_l2);
	
	$viewfd = $row_l1['dirtype_name'] . " " . $row_l1['dir_name'];
	
	if($row_l2['dir_name']!=NULL && $type==1)
		$viewfd .= ", " . $row_l2['dirtype_name'] . " " . $row_l2['dir_name'];
	
	return strtoupper($viewfd);
}

function getFulldirectoryByUserID($user)
{
	$query_l1 = "SELECT dir_id FROM www.user_unit WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userunit_status = '1' ORDER BY userunit_in_y DESC, userunit_in_m DESC, userunit_in_d DESC, userunit_id DESC";
	$user_l1 = mysql_query($query_l1);
	$row_l1 = mysql_fetch_assoc($user_l1);
	
	return getFulldirectory($row_l1['dir_id']);
}

function getUserUnitIDByUserID($userid)
{
	$query_s = "SELECT dir_id FROM www.user_unit WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND userunit_status = '1'";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	return $row_s['dir_id'];
}

function getStateByLocationID($locid)
{
	$query_l1 = "SELECT state_id FROM www.location WHERE location_id = '" . htmlspecialchars($locid, ENT_QUOTES) . "'";
	$user_l1 = mysql_query($query_l1);
	$row_l1 = mysql_fetch_assoc($user_l1);
	
	return $row_l1['state_id'];
}

function getStateIDByUserID($user)
{
	return getStateByLocationID(getLocationIDByUserID($user));
}

function getLocation($location){
	$query_s = "SELECT location_name FROM www.location WHERE location_id = '" . htmlspecialchars($location, ENT_QUOTES) . "'";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	return strtoupper($row_s['location_name']);
}

function getLocationByUserID($user)
{
	$query_l1 = "SELECT location_id FROM www.user_unit WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userunit_status = '1' ORDER BY userunit_in_y DESC, userunit_in_m DESC, userunit_in_d DESC, userunit_id DESC";
	$user_l1 = mysql_query($query_l1);
	$row_l1 = mysql_fetch_assoc($user_l1);
	
	return getLocation($row_l1['location_id']);
}

function getLocationIDByUserID($user)
{
	$query_l1 = "SELECT location_id FROM www.user_unit WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userunit_status = '1' ORDER BY userunit_in_y DESC, userunit_in_m DESC, userunit_in_d DESC, userunit_id DESC";
	$user_l1 = mysql_query($query_l1);
	$row_l1 = mysql_fetch_assoc($user_l1);
	
	return $row_l1['location_id'];
}

function checkLocationStateWeekendByUserID($user)
{
	$query_l1 = "SELECT state_weekend FROM www.state WHERE state_id = '" . getStateByLocationID(getLocationIDByUserID($user)) . "'";
	$user_l1 = mysql_query($query_l1);
	$row_l1 = mysql_fetch_assoc($user_l1);
	
	if($row_l1['state_weekend']==1)
		return true;
	else
		return false;
}

//ENABLE SEMAK CUTI SABTU AHAD
/* function checkStateWeekendByDate($user, $day, $month, $year)
{
	//semak utk state kelantan, terengganu dan kedah (KTK)
	
	if(checkLocationStateWeekendByUserID($user) && date('w', mktime(0, 0, 0, $month, $day, $year))==5) // KTK && friday
	{
		return false;
	} else if(checkLocationStateWeekendByUserID($user) && date('w', mktime(0, 0, 0, $month, $day, $year))==6) //KTK && saturday
	{
		return false;
	} else if(checkLocationStateWeekendByUserID($user) && date('w', mktime(0, 0, 0, $month, $day, $year))==0) //KTK && sunday
	{
		return true;
	} else if(!checkLocationStateWeekendByUserID($user) && date('w', mktime(0, 0, 0, $month, $day, $year))==5) // Bukan KTK && firday
	{
		return true;
	} else if(!checkLocationStateWeekendByUserID($user) && date('w', mktime(0, 0, 0, $month, $day, $year))==0) // Bukan KTK && sunday
	{
		return false;
	} else if(!checkLocationStateWeekendByUserID($user) && date('w', mktime(0, 0, 0, $month, $day, $year))==6) // Bukan KTK && saturday
	{
		return false;
	} else {
		return true;
	}
} */

function getReportType($type) {
	$query_s = "SELECT evofficer_name FROM www.ev_officer WHERE evofficer_id = '" . htmlspecialchars($type, ENT_QUOTES) . "'";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	return $row_s['evofficer_name'];
}

function getCitizen($citizen) {
	$query_c1 = "SELECT * FROM www.countrylist WHERE countrylist.CountryID = '" . htmlspecialchars($citizen, ENT_QUOTES) . "'";
	$user_c1 = mysql_query($query_c1);
	$row_c1 = mysql_fetch_assoc($user_c1);
	
	return $row_c1['Name'];
}

function getCitizenByUserID($user)
{
	$query_c1 = "SELECT user.user_nationality FROM www.user WHERE user.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";
	$user_c1 = mysql_query($query_c1);
	$row_c1 = mysql_fetch_assoc($user_c1);
	
	return $row_c1['user_nationality'];
}

function getServiceDate($user)
{
	$query_s1 = "SELECT user_job.userjob_start_d, user_job.userjob_start_m, user_job.userjob_start_y FROM www.user_job WHERE user_job.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";	
	$user_s1 = mysql_query($query_s1);
	$row_s1 = mysql_fetch_assoc($user_s1);
	
	return date('d / m / Y (D)', mktime(0, 0, 0, $row_s1['userjob_start_m'], $row_s1['userjob_start_d'], $row_s1['userjob_start_y']));
}

function getServiceDateYear($user)
{
	$query_s1 = "SELECT user_job.userjob_start_y FROM www.user_job WHERE user_job.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";	
	$user_s1 = mysql_query($query_s1);
	$row_s1 = mysql_fetch_assoc($user_s1);
	
	return date('Y', mktime(0, 0, 0, $row_s1['userjob_start_m'], $row_s1['userjob_start_d'], $row_s1['userjob_start_y']));
}

function getService($user) 
{ 
// tempoh berkhidmat dalam Tahun, Bulan dan Hari
	$query_s1 = "SELECT user_job.userjob_start_d, user_job.userjob_start_m, user_job.userjob_start_y FROM www.user_job WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";	
	$user_s1 = mysql_query($query_s1);
	$row_s1 = mysql_fetch_assoc($user_s1);
	
	if($row_s1['userjob_start_y']!=NULL && $row_s1['userjob_start_m']!=NULL && $row_s1['userjob_start_d']!=NULL)
	{
		$dateC = $row_s1['userjob_start_y'] . "-" . $row_s1['userjob_start_m'] . "-" . $row_s1['userjob_start_d'];
	
		$date = new DateTime($dateC);
		$diff = $date->diff(new DateTime());
		
		$dateV = array();
		
		$dateV[0] = $diff->y; // Tahun
		$dateV[1] = $diff->m; // Bulan
		$dateV[2] = $diff->d; // Hari
	} else
		$dateV = 0;
		
	return $dateV;
}

function getKWSPByUserID($user)
{
	//$query_s1 = "SELECT user_job.userjob_kwsp FROM www.user_job WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";	
	//$medan = "concat_ws(':',user_job.userjob_kwsp,'8%') as user_job.userjob_kwsp";
	$medan = "user_job.userjob_kwsp";
	$query_s1 = "SELECT $medan FROM www.user_job WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";	
	//echo '<pre>'; print_r($query_s1) . '</pre>'; # papar sql
	
	$user_s1 = mysql_query($query_s1);
	$row_s1 = mysql_fetch_assoc($user_s1);
	
	if($row_s1['userjob_kwsp']!="" && $row_s1['userjob_kwsp']!="-")
		$kwsp = $row_s1['userjob_kwsp'];
	else
		$kwsp = "";
		
	return $kwsp;
}

function checkKWSPByUserID($user)
{
	if((getKWSPByUserID($user)!=NULL && getKWSPByUserID($user)!="-") || !checkKWSPByStafID($user, date('d'), date('m'), date('Y')))
		return true;
	else
		return false;
}

function getPERKESOByUserID($user)
{
	$query_s1 = "SELECT user_job.userjob_perkeso FROM www.user_job WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";	
	$user_s1 = mysql_query($query_s1);
	$row_s1 = mysql_fetch_assoc($user_s1);
	
	if($row_s1['userjob_perkeso']!="" && $row_s1['userjob_perkeso']!="-")
		$perkeso = $row_s1['userjob_perkeso'];
	else
		$perkeso = "";
		
	return $perkeso;
}

function checkPERKESOByUserID($user)
{
	if((getPERKESOByUserID($user)!=NULL && getPERKESOByUserID($user)!="-") || !checkPERKESOByStafID($user, date('d'), date('m'), date('Y')))
		return true;
	else
		return false;
}

function getLHDNByUserID($user)
{
	$query_s1 = "SELECT user_job.userjob_lhdn FROM www.user_job WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";	
	$user_s1 = mysql_query($query_s1);
	$row_s1 = mysql_fetch_assoc($user_s1);
	
	if($row_s1['userjob_lhdn']!="" && $row_s1['userjob_lhdn']!="-")
		$lhdn = $row_s1['userjob_lhdn'];
	else
		$lhdn = "";
		
	return $lhdn;
}

function checkLHDNByUserID($user)
{
	if(getLHDNByUserID($user)!=NULL && getLHDNByUserID($user)!="-")
		return true;
	else
		return false;
}

function getBankNameByUserID($user)
{
	$query_s1 = "SELECT user_job.bank_id FROM www.user_job WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";	
	$user_s1 = mysql_query($query_s1);
	$row_s1 = mysql_fetch_assoc($user_s1);
	
	if($row_s1['bank_id']!="")
		$bank = $row_s1['bank_id'];
	else
		$bank = 0;
		
	return getBankName($bank);
}

function getBankIDByUserID($user)
{
	$query_s1 = "SELECT user_job.bank_id FROM www.user_job WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";	
	$user_s1 = mysql_query($query_s1);
	$row_s1 = mysql_fetch_assoc($user_s1);
	
	if($row_s1['bank_id']!="")
		$bank= $row_s1['bank_id'];
	else
		$bank = 0;
		
	return $bank;
}

function checkBankByUserID($user)
{
	if(getBankIDByUserID($user)!=0)
		return true;
	else
		return false;
}

function getBankName($id) {
	if($id != 0)
	{
		$query_bank = "SELECT bank_name, bank_shortname FROM www.bank WHERE bank_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
		$user_bank = mysql_query($query_bank);
		$row_bank = mysql_fetch_assoc($user_bank);
		
		if($row_bank['bank_shortname']!= NULL)
			$name = $row_bank['bank_name'] . " (" . $row_bank['bank_shortname'] . ")";
		else
			$name = $row_bank['bank_name'];
	} else {
		$name = "";
	}
		
	return $name;
}

function getAccBankByUserID($user)
{
	$query_s1 = "SELECT user_job.userjob_nobank FROM www.user_job WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";	
	$user_s1 = mysql_query($query_s1);
	$row_s1 = mysql_fetch_assoc($user_s1);
	
	if($row_s1['userjob_nobank']!="")
		$bank= $row_s1['userjob_nobank'];
	else
		$bank = "";
		
	return $bank;
}

function checkAccBankByUserID($user)
{
	if(getAccBankByUserID($user)!= NULL && getAccBankByUserID($user)!="-")
		return true;
	else
		return false;
}

function checkPencenByUserID($user)
{	
	$query_ss = "SELECT userpencen_id FROM www.user_pencen WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userpencen_status = '1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total > 0)
		return true;
	else
		return false;
}

function checkPencenByDate($user, $m, $y)
{	
	if($m==0)
	{
		$m = date('m');
	}

	if($y==0)
	{
		$y= date('Y');
	}

	$wsql = " AND ((userpencen_m <= '" . htmlspecialchars($m, ENT_QUOTES) . "' AND userpencen_y <= '" . htmlspecialchars($y, ENT_QUOTES) . "') OR (userpencen_m >= '" . htmlspecialchars($m, ENT_QUOTES) . "' AND userpencen_y < '" . htmlspecialchars($y, ENT_QUOTES) . "'))";
	
	$query_ss = "SELECT userpencen_id FROM www.user_pencen WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' " . $wsql ." AND userpencen_status = '1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	$total = mysql_num_rows($user_ss);

	if($total > 0)
		return true;
	else
		return false;
}

function getPencenDateByUserID($user, $type=0)
{
	$query_ss = "SELECT userpencen_d, userpencen_m, userpencen_y FROM www.user_pencen WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userpencen_status = '1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($type==1)
		$date = $row_ss['userpencen_d'];
	else if($type==2)
		$date = $row_ss['userpencen_m'];
	else if($type==3)
		$date = $row_ss['userpencen_d'];
	else
		$date = date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['userpencen_m'], $row_ss['userpencen_d'], $row_ss['userpencen_y']));
		
	return $date;
}

function getStatus($id)
{
	if($id=='1')
		$status = "Aktif";
	else if($id=='0')
		$status = "Tidak Aktif";
	else
		$status = "Tiada Akses";
	
	return $status;
}

function getStatusIcon($id)
{
	if($id=='1')
		$status = "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" width=\"16\" height=\"16\" alt=\"Aktif\" />";
	else if($id=='0')
		$status = "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_error.png\" width=\"16\" height=\"16\" alt=\"Tidak Aktif\" />";
	else
		$status = "<img src=\"" . $GLOBALS['url_main'] . "icon/lock.png\" width=\"16\" height=\"16\" alt=\"Tidak Aktif\" />";
	
	return $status;
}

function getStatusByStafID($user)
{
	$query_ss = "SELECT login_status FROM www.login WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['login_status'];
}

function getStatusDateByStafID($user)
{
	$query_ss = "SELECT login_date_d, login_date_m, login_date_y FROM www.login WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['login_date_m'], $row_ss['login_date_d'], $row_ss['login_date_y']));
}

function getStatusTFByStafID($user)
{
	$query_ss = "SELECT login_status FROM www.login WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['login_status']==1)
		return true;
	else
		return false;
}

function getStatusTFByDateByStafID($user, $d, $m, $y)
{
	$query_ss = "SELECT login_status FROM www.login WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND (login.login_status = '1' OR ((login.login_date_m > '" . htmlspecialchars($m, ENT_QUOTES) . "' && login.login_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "') OR (login.login_date_y > '" . htmlspecialchars($y, ENT_QUOTES) . "')))";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
  	$totalRows_ss = mysql_num_rows($user_ss);
	
	if($totalRows_ss > 0)
		return true;
	else
		return false;
}

function getGroup($id) //Group perkhidmatan: Peg, Sokongan 1, ...
{
	$query_ss = "SELECT group_name FROM www.group WHERE group_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['group_name'];
}

function getGroupByUserID($user)
{
	$query_ss = "SELECT userscheme_gred FROM www.user_scheme WHERE user_scheme.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userscheme_status = '1' ORDER BY userscheme_in_y DESC, userscheme_in_m DESC, userscheme_in_d DESC, userscheme_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return setGroupByGredRange($row_ss['userscheme_gred']);
}

function getGroupIDByUserID($user)
{
	$query_ss = "SELECT userscheme_gred FROM www.user_scheme WHERE user_scheme.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userscheme_status = '1' ORDER BY userscheme_in_y DESC, userscheme_in_m DESC, userscheme_in_d DESC, userscheme_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return getGroupByGredRange($row_ss['userscheme_gred']);
}

function getGroupByGredRange($range)
{
	$query_ss = "SELECT group_id, group_gred FROM www.group ORDER BY group_gred ASC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$groupID = "0";
	
	do {
		if($range >= $row_ss['group_gred'])
			$groupID = $row_ss['group_id'];
	} while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $groupID;
}

function setGroupByGredRange($range)
{
	$query_ss = "SELECT group_name, group_gred FROM www.group ORDER BY group_gred ASC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$groupname = "-";
	
	do {
		if($range >= $row_ss['group_gred'])
			$groupname = $row_ss['group_name'];
	} while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $groupname;
}

function getEduSponsor($id)
{
	$query_ss = "SELECT user_edu.sponsor_id, user_edu.useredu_sponsor, sponsor.sponsor_name FROM www.user_edu LEFT JOIN sponsor ON sponsor.sponsor_id = user_edu.sponsor_id WHERE user_edu.useredu_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['sponsor_id']!=0)
		$view = $row_ss['sponsor_name'];
	else if($row_ss['sponsor_id']==0 && $row_ss['useredu_sponsor']!="")
		$view = $row_ss['useredu_sponsor'];
	else
		$view = "-";
		
	return $view;
}

function setSalarySkimP()
{
	return 3;	
}

function getSalaryByStafID($id)
{
	$query_ss = "SELECT usersalaryskill_basicsalary FROM www.user_salaryskill WHERE user_stafid='" . htmlspecialchars($id, ENT_QUOTES) . "' AND usersalaryskill_status = 1 ORDER BY usersalaryskill_date_y DESC, usersalaryskill_date_m DESC, usersalaryskill_date_d DESC, usersalaryskill_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['usersalaryskill_basicsalary'];
}
?>
<?php
//Kew 8
function checkKew8ByUserID($userid)
{
	$query_ss = "SELECT user_kewe.* FROM www.user_kewe WHERE userkewe_status = 1 AND user_kewe.user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND NOT EXISTS (SELECT * FROM www.user_salary WHERE user_stafid ='" . htmlspecialchars($userid, ENT_QUOTES) . "' AND user_salary.usersalary_status = 1 AND user_salary.usersalary_kew8 = user_kewe.userkewe_id) AND NOT EXISTS (SELECT * FROM www.user_salaryskill WHERE usersalaryskill_status = 1 AND user_salaryskill.user_stafid ='" . htmlspecialchars($userid, ENT_QUOTES) . "' AND user_salaryskill.userkewe_id = user_kewe.userkewe_id) AND NOT EXISTS (SELECT * FROM www.user_emolumen WHERE useremolumen_status = 1 AND user_emolumen.user_stafid ='" . htmlspecialchars($userid, ENT_QUOTES) . "' AND user_emolumen.userkewe_id = user_kewe.userkewe_id)";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total > 0)
		return true;
	else
		return false;
}

function getKew8IDByUserID($userid, $siri, $d, $m, $y)
{
	$query_ss = "SELECT user_kewe.userkewe_id FROM www.user_kewe WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND userkewe_siri = '" . htmlspecialchars($siri, ENT_QUOTES) . "' AND userkewe_date_d = '" . htmlspecialchars($d, ENT_QUOTES) . "' AND userkewe_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "' AND userkewe_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND userkewe_status = 1 ORDER BY userkewe_start_y DESC, userkewe_start_m DESC, userkewe_start_d DESC, userkewe_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['userkewe_id'];
}

function getGLIDByUserID($userid, $siri, $d, $m, $y)
{
	$query_ss = "SELECT user_gl.usergl_id FROM www.user_gl WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND usergl_siri = '" . htmlspecialchars($siri, ENT_QUOTES) . "' AND usergl_date_d = '" . htmlspecialchars($d, ENT_QUOTES) . "' AND usergl_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "' AND usergl_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND usergl_status = 1 ORDER BY usergl_start_y DESC, usergl_start_m DESC, usergl_start_d DESC, usergl_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['usergl_id'];
}

function getKew8Siri($userid)
{
	$query_ss = "SELECT user_kewe.* FROM www.user_kewe WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND userkewe_date_m = '" . date('m') . "' AND userkewe_date_y = '" . date('Y') . "' AND userkewe_status = 1 ORDER BY userkewe_start_y DESC, userkewe_start_m DESC, userkewe_start_d DESC, userkewe_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	return ($total + 1);
}

function getGLSiri($userid)
{
	$query_ss = "SELECT user_gl.* FROM www.user_gl WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND usergl_date_m = '" . date('m') . "' AND usergl_date_y = '" . date('Y') . "' AND usergl_status = 1 ORDER BY usergl_start_y DESC, usergl_start_m DESC, usergl_start_d DESC, usergl_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	return ($total + 1);
}

function getKew8SiriByID($id)
{
	$query_ss = "SELECT user_kewe.* FROM www.user_kewe WHERE userkewe_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND userkewe_status = 1 ORDER BY userkewe_start_y DESC, userkewe_start_m DESC, userkewe_start_d DESC, userkewe_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total>0)
		return $row_ss['user_stafid'] . "/" . $row_ss['userkewe_date_m'] . "/" . $row_ss['userkewe_date_y'] . "/" . $row_ss['userkewe_siri'];
	else
		return "";
}

function getGLSiriByID($id)
{
	$query_ss = "SELECT user_gl.* FROM www.user_gl WHERE usergl_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND usergl_status = 1 ORDER BY usergl_start_y DESC, usergl_start_m DESC, usergl_start_d DESC, usergl_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total>0)
		return $row_ss['user_stafid'] . "/" . $row_ss['usergl_date_m'] . "/" . $row_ss['usergl_date_y'] . "/" . $row_ss['usergl_siri'];
	else
		return "";
}

function getKew8Date($id)
{
	$query_ss = "SELECT user_kewe.* FROM www.user_kewe WHERE userkewe_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND userkewe_status = 1 ORDER BY userkewe_start_y DESC, userkewe_start_m DESC, userkewe_start_d DESC, userkewe_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	return date('d / m / Y', mktime(0, 0, 0, $row_ss['userkewe_date_m'], $row_ss['userkewe_date_d'], $row_ss['userkewe_date_y']));
}

function viewKew8Siri($id)
{
	$query_ss = "SELECT user_kewe.* FROM www.user_kewe WHERE userkewe_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND userkewe_status = 1 ORDER BY userkewe_start_y DESC, userkewe_start_m DESC, userkewe_start_d DESC, userkewe_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	return $row_ss['userkewe_siri'];
}

function getKew8TypeByID($id)
{
	$query_ss = "SELECT kewetype_name FROM www.kewe_type WHERE kewetype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND kewetype_status='1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['kewetype_name'];
}

function getKew8NameByID($id)
{
	$query_ss = "SELECT kewe_name FROM www.kewe WHERE kewe_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND kewe_status='1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['kewe_name'];
}

function getGL8NameByID($id)
{
	$query_ss = "SELECT relationship_name FROM www.relationship WHERE relationship_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND relationship_status='1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['relationship_name'];
}

function getGL8NameByID2($id)
{
	$query_ss = "SELECT userdependents_name, userdependents_ic FROM www.user_dependents WHERE userdependents_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND userdependents_status='1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['userdependents_name'];
}

function getKew8TypeByKewID($id)
{
	$query_ss = "SELECT kewetype_id FROM www.kewe WHERE kewe_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND kewe_status='1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return getKew8TypeByID($row_ss['kewetype_id']);
}

function getKew8StartDate($userID, $keweID)
{
	$query_ss = "SELECT user_kewe.* FROM www.user_kewe WHERE user_stafid = '" . htmlspecialchars($userID, ENT_QUOTES) . "' AND userkewe_id = '" . htmlspecialchars($keweID, ENT_QUOTES) . "' AND userkewe_status = 1 ORDER BY userkewe_start_y DESC, userkewe_start_m DESC, userkewe_start_d DESC, userkewe_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['userkewe_start_m'] == null)
	{
		return "-";
	}
	else
		return date('d.m.Y', mktime(0, 0, 0, $row_ss['userkewe_start_m'], $row_ss['userkewe_start_d'], $row_ss['userkewe_start_y']));
}

function getGLStartDate($userID, $glID)
{
	$query_ss = "SELECT user_gl.* FROM www.user_gl WHERE user_stafid = '" . htmlspecialchars($userID, ENT_QUOTES) . "' AND usergl_id = '" . htmlspecialchars($glID, ENT_QUOTES) . "' AND usergl_status = 1 ORDER BY usergl_start_y DESC, usergl_start_m DESC, usergl_start_d DESC, usergl_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return date('d/m/Y', mktime(0, 0, 0, $row_ss['usergl_start_m'], $row_ss['usergl_start_d'], $row_ss['usergl_start_y']));
}

function getKew8EndDate($userID, $keweID)
{
	$query_ss = "SELECT user_kewe.* FROM www.user_kewe WHERE user_stafid = '" . htmlspecialchars($userID, ENT_QUOTES) . "' AND userkewe_id = '" . htmlspecialchars($keweID, ENT_QUOTES) . "' AND userkewe_status = 1 ORDER BY userkewe_start_y DESC, userkewe_start_m DESC, userkewe_start_d DESC, userkewe_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	// if($row_ss['userkewe_end_y']!=0 && $row_ss['userkewe_end_m']!=0 && $row_ss['userkewe_end_d']!=0)
	if($row_ss['userkewe_end_m'] == null)
	{
		return null;
	}
	else
		return date('d.m.Y', mktime(0, 0, 0, $row_ss['userkewe_end_m'], $row_ss['userkewe_end_d'], $row_ss['userkewe_end_y']));
	// else
	// 	return "";
}
?>
<?php
//Gaji 
function getSalaryErrorID($userid, $m, $y)
{
	$query_ss = "SELECT salaryerror_id FROM www.salary_error WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND salaryerror_month = '" . htmlspecialchars($m, ENT_QUOTES) . "' AND salaryerror_year = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND salaryerror_status = '1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['salaryerror_id'];
}

function checkSalaryErrorID($userid, $m, $y)
{
	if($m>=(date('m')-1) && $y == date('Y'))
	{
		$query_ss = "SELECT salaryerror_id FROM www.salary_error WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND salaryerror_month = '" . htmlspecialchars($m, ENT_QUOTES) . "' AND salaryerror_year = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND salaryerror_status = '1'";	
		$user_ss = mysql_query($query_ss);
		$row_ss = mysql_fetch_assoc($user_ss);
		
		$total = mysql_num_rows($user_ss);
		
		if($total>0)
			return true;
		else
			return false;
	} else {
		return true;
	}
}

function getDateBySchDate($m, $y)
{
	$query_ss = "SELECT salarysch_d, salarysch_m, salarysch_y FROM www.salary_sch WHERE salarysch_m='" . htmlspecialchars($m, ENT_QUOTES) . "' AND salarysch_y='" . htmlspecialchars($y, ENT_QUOTES) . "' AND salarysch_status = '1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['salarysch_d'];
}

function checkSalarySchDatePast($d, $m, $y)
{
	// 3 bulan kebelakang
	$m3 = mktime(0, 0, 0, (date('m')-4), 1, date('Y'));
	
	// bulan yg dipohon
	$mr = mktime(0, 0, 0, $m, $d, $y);
	
	//bulan semasa
	if(($m >= date('m') && $y == date('Y')) || $y>date('Y'))
	{
		$ms = mktime(0, 0, 0, $m, getDateBySchDate($m, $y), $y);
		
		if($mr >= $ms)
			return true;
		else
			return false;
			
	}else {
		
		$ms = mktime(0, 0, 0, date('m'), getDateBySchDate(date('m'), date('Y')), date('Y'));
		
		if($m3 <= $mr && $mr <= $ms)
			return true;
		else
			return false;
	};
}

function checkSalarySchDate($m, $y)
{
	$query_ss = "SELECT salarysch_id FROM www.salary_sch WHERE salarysch_m = '" . htmlspecialchars($m, ENT_QUOTES) . "' AND salarysch_y = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND salarysch_status = '1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total>0)
		return true;
	else
		return false;
}

function getBasicSalaryByUserID($id, $d, $m, $y)
{
	$bs = 0;
	
	if(getStatusTFByDateByStafID($id, $d, $m, $y) && !checkSalaryBlockByUserID($id, $m, $y) && checkStartDateByMonth($id, $m, $y))
	{
		$query_ss = "SELECT usersalaryskill_basicsalary FROM www.user_salaryskill WHERE ((IFNULL(usersalaryskill_start_y, usersalaryskill_date_y) = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND IFNULL(usersalaryskill_start_m, usersalaryskill_date_m) < '" . htmlspecialchars($m, ENT_QUOTES) . "') OR (IFNULL(usersalaryskill_start_y, usersalaryskill_date_y) < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND user_stafid='" . htmlspecialchars($id, ENT_QUOTES) . "' AND usersalaryskill_status = '1' ORDER BY usersalaryskill_date_y DESC, usersalaryskill_date_m DESC, usersalaryskill_date_d DESC, usersalaryskill_id DESC LIMIT 1";
		$user_ss = mysql_query($query_ss);
		$row_ss = mysql_fetch_assoc($user_ss);
		
		$bs = $row_ss['usersalaryskill_basicsalary'];
	
	} else {
		$bs = 0;
	}
	
	return $bs;
}

function getBasicSalaryByUserIDall($id, $d, $m, $y)
{
	$bs = 0;
	// echo $m;
	$query_ss = "SELECT usersalaryskill_basicsalary FROM www.user_salaryskill WHERE ((IFNULL(usersalaryskill_start_y, usersalaryskill_date_y) = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND IFNULL(usersalaryskill_start_m, usersalaryskill_date_m) < '" . htmlspecialchars($m, ENT_QUOTES) . "') OR (IFNULL(usersalaryskill_start_y, usersalaryskill_date_y) < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND user_stafid='" . htmlspecialchars($id, ENT_QUOTES) . "' AND usersalaryskill_status = '1' ORDER BY usersalaryskill_date_y DESC, usersalaryskill_date_m DESC, usersalaryskill_date_d DESC, usersalaryskill_id DESC LIMIT 1";
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$bs = $row_ss['usersalaryskill_basicsalary'];
	
	
	return $bs;
}

function getTotalBasicSalaryTetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getBasicSalaryByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalBasicSalaryKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getBasicSalaryByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getBasicSalaryDateStartByUserID($userid, $usersalaryID, $d, $m, $y)
{
	$query_ss = "SELECT usersalaryskill_date_d, usersalaryskill_date_m, usersalaryskill_date_y, usersalaryskill_start_d, usersalaryskill_start_m, usersalaryskill_start_y FROM www.user_salaryskill WHERE user_stafid='" . htmlspecialchars($userid, ENT_QUOTES) . "' AND usersalaryskill_status = '1' AND usersalaryskill_id = '" . htmlspecialchars($usersalaryID, ENT_QUOTES) . "' ORDER BY usersalaryskill_date_y DESC, usersalaryskill_date_m DESC, usersalaryskill_date_d DESC, usersalaryskill_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['usersalaryskill_start_m']!=NULL && $row_ss['usersalaryskill_start_d']!=NULL && $row_ss['usersalaryskill_start_y']!=NULL)
		return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['usersalaryskill_start_m'], $row_ss['usersalaryskill_start_d'], $row_ss['usersalaryskill_start_y']));
	else
		return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['usersalaryskill_date_m'], $row_ss['usersalaryskill_date_d'], $row_ss['usersalaryskill_date_y']));
}

function getEmolumenDateStartByUserID($userid, $useremoID)
{
	$query_ss = "SELECT useremolumen_date_d, useremolumen_date_m, useremolumen_date_y, useremolumen_start_d, useremolumen_start_m, useremolumen_start_y FROM www.user_emolumen WHERE user_stafid='" . htmlspecialchars($userid, ENT_QUOTES) . "' AND useremolumen_status = '1' AND useremolumen_id = '" . htmlspecialchars($useremoID, ENT_QUOTES) . "' ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['useremolumen_start_m']!=NULL && $row_ss['useremolumen_start_d']!=NULL && $row_ss['useremolumen_start_y']!=NULL)
		return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['useremolumen_start_m'], $row_ss['useremolumen_start_d'], $row_ss['useremolumen_start_y']));
	else
		return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['useremolumen_date_m'], $row_ss['useremolumen_date_d'], $row_ss['useremolumen_date_y']));
}

function getEmolumenByUserID($id, $d, $m, $y)
{
	if(getStatusTFByDateByStafID($id, $d, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($id, $m, $y) && checkStartDateByMonth($id, $m, $y)){
	$query_emo = "SELECT * FROM www.user_emolumen WHERE ((IFNULL(useremolumen_start_y, useremolumen_date_y) = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND IFNULL(useremolumen_start_m, useremolumen_date_m) <= '" . htmlspecialchars($m, ENT_QUOTES) . "') OR (IFNULL(useremolumen_start_y, useremolumen_date_y) < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND useremolumen_status = '1' AND user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC LIMIT 1";	
	$user_emo = mysql_query($query_emo);
	$row_emo = mysql_fetch_assoc($user_emo);
	
	$count = 0;
	
	if($row_emo['useremolumen_itka']!=0 && $row_emo['useremolumen_itka']!=NULL)
		$count += $row_emo['useremolumen_itka'];
	if($row_emo['useremolumen_itkrai']!=0 && $row_emo['useremolumen_itkrai']!=NULL)
		$count += $row_emo['useremolumen_itkrai'];
	if($row_emo['useremolumen_itp']!=0 && $row_emo['useremolumen_itp']!=NULL)
		$count += $row_emo['useremolumen_itp'];
	if($row_emo['useremolumen_bsh']!=0 && $row_emo['useremolumen_bsh']!=NULL)
		$count += $row_emo['useremolumen_bsh'];
	if($row_emo['useremolumen_elktkl']!=0 && $row_emo['useremolumen_elktkl']!=NULL)
		$count += $row_emo['useremolumen_elktkl'];
	if($row_emo['useremolumen_posbasik']!=0 && $row_emo['useremolumen_posbasik']!=NULL)
		$count += $row_emo['useremolumen_posbasik'];
	if($row_emo['useremolumen_elpakar']!=0 && $row_emo['useremolumen_elpakar']!=NULL)
		$count += $row_emo['useremolumen_elpakar'];
	if($row_emo['useremolumen_elinsentif']!=0 && $row_emo['useremolumen_elinsentif']!=NULL)
		$count += $row_emo['useremolumen_elinsentif'];
	if($row_emo['useremolumen_jusa']!=0 && $row_emo['useremolumen_jusa']!=NULL)
		$count += $row_emo['useremolumen_jusa'];
	if($row_emo['useremolumen_elpemkhas']!=0 && $row_emo['useremolumen_elpemkhas']!=NULL)
		$count += $row_emo['useremolumen_elpemkhas'];
	if($row_emo['useremolumen_elpemrmh']!=0 && $row_emo['useremolumen_elpemrmh']!=NULL)
		$count += $row_emo['useremolumen_elpemrmh'];
	if($row_emo['useremolumen_elbhs']!=0 && $row_emo['useremolumen_elbhs']!=NULL)
		$count += $row_emo['useremolumen_elbhs'];
	if($row_emo['useremolumen_o']!=0 && $row_emo['useremolumen_o']!=NULL)
		$count += $row_emo['useremolumen_o'];
	if($row_emo['useremolumen_elkdriver']!=0 && $row_emo['useremolumen_elkdriver']!=NULL)
		$count += $row_emo['useremolumen_elkdriver'];
	} else {
		$count = 0;
	}
	
	return $count;
}

function getEmolumenITKAByUserID($id, $d, $m, $y)
{
	if(getStatusTFByDateByStafID($id, $d, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($id, $m, $y) && checkStartDateByMonth($id, $m, $y)){
	$query_emo = "SELECT useremolumen_itka FROM www.user_emolumen WHERE ((IFNULL(useremolumen_start_y, useremolumen_date_y) = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND IFNULL(useremolumen_start_m, useremolumen_date_m) <= '" . htmlspecialchars($m, ENT_QUOTES) . "') OR (IFNULL(useremolumen_start_y, useremolumen_date_y) < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND useremolumen_status = '1' AND user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC LIMIT 1";	
	$user_emo = mysql_query($query_emo);
	$row_emo = mysql_fetch_assoc($user_emo);
	
	$count = 0;
	
	if($row_emo['useremolumen_itka']!=0 && $row_emo['useremolumen_itka']!=NULL)
		return $row_emo['useremolumen_itka'];
	else
		return 0; 
	} else {
		return 0;
	}
}

function getTotalEmolumenITKAByUserID($id, $y)
{
	$total = 0;
	
	for($i=1; $i<=12; $i++)
	{
		if($i<10)
			$i = '0' . $i;
			
		$total += getEmolumenITKAByUserID($id, 1, $i, $y);
	}
		
	return $total;
	
}

function getTotalEmolumenITKATetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenITKAByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenITKAKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenITKAByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenITKA($d, $m, $y)
{
	return (getTotalEmolumenITKATetap($d, $m, $y)+getTotalEmolumenITKAKontrak($d, $m, $y));
}







////////////////////////////////

function getEmolumenELDRIVERByUserID($id, $d, $m, $y)
{
	if(getStatusTFByDateByStafID($id, $d, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($id, $m, $y) && checkStartDateByMonth($id, $m, $y)){
	$query_emo = "SELECT useremolumen_elkdriver FROM www.user_emolumen WHERE ((IFNULL(useremolumen_start_y, useremolumen_date_y) = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND IFNULL(useremolumen_start_m, useremolumen_date_m) <= '" . htmlspecialchars($m, ENT_QUOTES) . "') OR (IFNULL(useremolumen_start_y, useremolumen_date_y) < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND useremolumen_status = '1' AND user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC LIMIT 1";	
	$user_emo = mysql_query($query_emo);
	$row_emo = mysql_fetch_assoc($user_emo);
	
	$count = 0;
	
	if($row_emo['useremolumen_elkdriver']!=0 && $row_emo['useremolumen_elkdriver']!=NULL)
		return $row_emo['useremolumen_elkdriver'];
	else
		return 0; 
	} else {
		return 0;
	}
}

function getTotalEmolumenELDRIVERByUserID($id, $y)
{
	$total = 0;
	
	for($i=1; $i<=12; $i++)
	{
		if($i<10)
			$i = '0' . $i;
			
		$total += getEmolumenELDRIVERByUserID($id, 1, $i, $y);
	}
		
	return $total;
	
}

function getTotalEmolumenELDRIVERetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenELDRIVERByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenELDRIVERKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenELDRIVERByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenELDRIVER($d, $m, $y)
{
	return (getTotalEmolumenELDRIVERetap($d, $m, $y)+getTotalEmolumenELDRIVERKontrak($d, $m, $y));
}
























function getEmolumenITPByUserID($id, $d, $m, $y)
{
	if(getStatusTFByDateByStafID($id, $d, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($id, $m, $y) && checkStartDateByMonth($id, $m, $y)){
	$query_emo = "SELECT useremolumen_itp FROM www.user_emolumen WHERE ((IFNULL(useremolumen_start_y, useremolumen_date_y) = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND IFNULL(useremolumen_start_m, useremolumen_date_m) <= '" . htmlspecialchars($m, ENT_QUOTES) . "') OR (IFNULL(useremolumen_start_y, useremolumen_date_y) < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND useremolumen_status = '1' AND user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC LIMIT 1";	
	$user_emo = mysql_query($query_emo);
	$row_emo = mysql_fetch_assoc($user_emo);
	
	$count = 0;
	
	if($row_emo['useremolumen_itp']!=0 && $row_emo['useremolumen_itp']!=NULL)
		return $row_emo['useremolumen_itp'];
	else
		return 0; 
	} else {
		return 0;
	}
}

function getTotalEmolumenITPByUserID($id, $y)
{
	$total = 0;
	
	for($i=1; $i<=12; $i++)
	{
		if($i<10)
			$i = '0' . $i;
		$total += getEmolumenITPByUserID($id, 1, $i, $y);
	}
		
	return $total;
	
}

function getTotalEmolumenITPTetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenITPByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenITPKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenITPByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenITP($d, $m, $y)
{
	return (getTotalEmolumenITPTetap($d, $m, $y)+getTotalEmolumenITPKontrak($d, $m, $y));
}

function getEmolumenITKraiByUserID($id, $d, $m, $y)
{
	if(getStatusTFByDateByStafID($id, $d, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($id, $m, $y) && checkStartDateByMonth($id, $m, $y)){
	$query_emo = "SELECT useremolumen_itkrai FROM www.user_emolumen WHERE ((IFNULL(useremolumen_start_y, useremolumen_date_y) = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND IFNULL(useremolumen_start_m, useremolumen_date_m) <= '" . htmlspecialchars($m, ENT_QUOTES) . "') OR (IFNULL(useremolumen_start_y, useremolumen_date_y) < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND useremolumen_status = '1' AND user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC LIMIT 1";	
	$user_emo = mysql_query($query_emo);
	$row_emo = mysql_fetch_assoc($user_emo);
	
	$count = 0;
	
	if($row_emo['useremolumen_itkrai']!=0 && $row_emo['useremolumen_itkrai']!=NULL)
		return $row_emo['useremolumen_itkrai'];
	else
		return 0; 
	} else {
		return 0;
	}
}

function getTotalEmolumenITKraiByUserID($id, $y)
{
	$total = 0;
	
	for($i=1; $i<=12; $i++)
	{
		if($i<10)
			$i = '0' . $i;
		$total += getEmolumenITKraiByUserID($id, 1, $i, $y);
	}
		
	return $total;
	
}

function getTotalEmolumenITKraiTetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenITKraiByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenITKraiKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenITKraiByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenITKrai($d, $m, $y)
{
	return (getTotalEmolumenITKraiTetap($d, $m, $y) + getTotalEmolumenITKraiKontrak($d, $m, $y));
}

function getEmolumenElInsentifByUserID($id, $d, $m, $y)
{
	if(getStatusTFByDateByStafID($id, $d, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($id, $m, $y) && checkStartDateByMonth($id, $m, $y)){
	$query_emo = "SELECT useremolumen_elinsentif FROM www.user_emolumen WHERE ((IFNULL(useremolumen_start_y, useremolumen_date_y) = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND IFNULL(useremolumen_start_m, useremolumen_date_m) <= '" . htmlspecialchars($m, ENT_QUOTES) . "') OR (IFNULL(useremolumen_start_y, useremolumen_date_y) < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND useremolumen_status = '1' AND user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC LIMIT 1";	
	$user_emo = mysql_query($query_emo);
	$row_emo = mysql_fetch_assoc($user_emo);
	
	$count = 0;
	
	if($row_emo['useremolumen_elinsentif']!=0 && $row_emo['useremolumen_elinsentif']!=NULL)
		return $row_emo['useremolumen_elinsentif'];
	else
		return 0; 
	} else {
		return 0;
	}
}

function getTotalEmolumenElInsentifByUserID($id, $y)
{
	$total = 0;
	
	for($i=1; $i<=12; $i++)
	{
		if($i<10)
			$i = '0' . $i;
		$total += getEmolumenElInsentifByUserID($id, 1, $i, $y);
	}
		
	return $total;
	
}

function getTotalEmolumenElInsentifTetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenElInsentifByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenElInsentifKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenElInsentifByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getEmolumenElInsentif($d, $m, $y)
{
	return (getTotalEmolumenElInsentifTetap($d, $m, $y)+getTotalEmolumenElInsentifKontrak($d, $m, $y));
}

function getEmolumenJUSAByUserID($id, $d, $m, $y)
{
	if(getStatusTFByDateByStafID($id, $d, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($id, $m, $y) && checkStartDateByMonth($id, $m, $y)){
	$query_emo = "SELECT useremolumen_jusa FROM www.user_emolumen WHERE ((IFNULL(useremolumen_start_y, useremolumen_date_y) = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND IFNULL(useremolumen_start_m, useremolumen_date_m) <= '" . htmlspecialchars($m, ENT_QUOTES) . "') OR (IFNULL(useremolumen_start_y, useremolumen_date_y) < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND useremolumen_status = '1' AND user_stafid = '" . $id . "' ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC LIMIT 1";	
	$user_emo = mysql_query($query_emo);
	$row_emo = mysql_fetch_assoc($user_emo);
	
	$count = 0;
	
	if($row_emo['useremolumen_jusa']!=0 && $row_emo['useremolumen_jusa']!=NULL)
		return $row_emo['useremolumen_jusa'];
	else
		return 0; 
	} else {
		return 0;
	}
}

function getTotalEmolumenJUSAByUserID($id, $y)
{
	$total = 0;
	
	for($i=1; $i<=12; $i++)
	{
		if($i<10)
			$i = '0' . $i;
		$total += getEmolumenJUSAByUserID($id, 1, $i, $y);
	}
		
	return $total;
	
}

function getTotalEmolumenJUSATetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenJUSAByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenJUSAKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenJUSAByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenJUSA($d, $m, $y)
{
	return (getTotalEmolumenJUSATetap($d, $m, $y)+getTotalEmolumenJUSAKontrak($d, $m, $y));
}

function getEmolumenElPemKhasByUserID($id, $d, $m, $y)
{
	if(getStatusTFByDateByStafID($id, $d, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($id, $m, $y) && checkStartDateByMonth($id, $m, $y)){
	$query_emo = "SELECT useremolumen_elpemkhas FROM www.user_emolumen WHERE ((IFNULL(useremolumen_start_y, useremolumen_date_y) = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND IFNULL(useremolumen_start_m, useremolumen_date_m) <= '" . htmlspecialchars($m, ENT_QUOTES) . "') OR (IFNULL(useremolumen_start_y, useremolumen_date_y) < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND useremolumen_status = '1' AND user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC LIMIT 1";	
	$user_emo = mysql_query($query_emo);
	$row_emo = mysql_fetch_assoc($user_emo);
	
	$count = 0;
	
	if($row_emo['useremolumen_elpemkhas']!=0 && $row_emo['useremolumen_elpemkhas']!=NULL)
		return $row_emo['useremolumen_elpemkhas'];
	else
		return 0; 
	} else {
		return 0;
	}
}

function getTotalEmolumenElPemKhasByUserID($id, $y)
{
	$total = 0;
	
	for($i=1; $i<=12; $i++)
	{
		if($i<10)
			$i = '0' . $i;
		$total += getEmolumenElPemKhasByUserID($id, 1, $i, $y);
	}
		
	return $total;
	
}

function getTotalEmolumenElPemKhasTetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenElPemKhasByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenElPemKhasKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenElPemKhasByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenElPemKhas($d, $m, $y)
{
	return (getTotalEmolumenElPemKhasTetap($d, $m, $y)+getTotalEmolumenElPemKhasKontrak($d, $m, $y));
}

function getEmolumenElPemRmhByUserID($id, $d, $m, $y)
{
	if(getStatusTFByDateByStafID($id, $d, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($id, $m, $y) && checkStartDateByMonth($id, $m, $y)){
	$query_emo = "SELECT useremolumen_elpemrmh FROM www.user_emolumen WHERE ((IFNULL(useremolumen_start_y, useremolumen_date_y) = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND IFNULL(useremolumen_start_m, useremolumen_date_m) <= '" . htmlspecialchars($m, ENT_QUOTES) . "') OR (IFNULL(useremolumen_start_y, useremolumen_date_y) < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND useremolumen_status = '1' AND user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC LIMIT 1";	
	$user_emo = mysql_query($query_emo);
	$row_emo = mysql_fetch_assoc($user_emo);
	
	$count = 0;
	
	if($row_emo['useremolumen_elpemrmh']!=0 && $row_emo['useremolumen_elpemrmh']!=NULL)
		return $row_emo['useremolumen_elpemrmh'];
	else
		return 0; 
	} else {
		return 0;
	}
}

function getTotalEmolumenElPemRmhByUserID($id, $y)
{
	$total = 0;
	
	for($i=1; $i<=12; $i++)
	{
		if($i<10)
			$i = '0' . $i;
		$total += getEmolumenElPemRmhByUserID($id, 1, $i, $y);
	}
		
	return $total;
	
}

function getTotalEmolumenElPemRmhTetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenElPemRmhByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenElPemRmhKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenElPemRmhByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenElPemRmh($d, $m, $y)
{
	return (getTotalEmolumenElPemRmhTetap($d, $m, $y)+getTotalEmolumenElPemRmhKontrak($d, $m, $y));
}

function getEmolumenElBhsByUserID($id, $d, $m, $y)
{
	if(getStatusTFByDateByStafID($id, $d, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($id, $m, $y) && checkStartDateByMonth($id, $m, $y)){
	$query_emo = "SELECT useremolumen_elbhs FROM www.user_emolumen WHERE ((IFNULL(useremolumen_start_y, useremolumen_date_y) = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND IFNULL(useremolumen_start_m, useremolumen_date_m) <= '" . htmlspecialchars($m, ENT_QUOTES) . "') OR (IFNULL(useremolumen_start_y, useremolumen_date_y) < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND useremolumen_status = '1' AND user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC LIMIT 1";	
	$user_emo = mysql_query($query_emo);
	$row_emo = mysql_fetch_assoc($user_emo);
	
	$count = 0;
	
	if($row_emo['useremolumen_elbhs']!=0 && $row_emo['useremolumen_elbhs']!=NULL)
		return $row_emo['useremolumen_elbhs'];
	else
		return 0; 
	} else {
		return 0;
	}
}

function getTotalEmolumenElBhsByUserID($id, $y)
{
	$total = 0;
	
	for($i=1; $i<=12; $i++)
	{
		if($i<10)
			$i = '0' . $i;
		$total += getEmolumenElBhsByUserID($id, 1, $i, $y);
	}
		
	return $total;
	
}

function getTotalEmolumenElBhsTetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenElBhsByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenElBhsKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenElBhsByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenElBhs($d, $m, $y)
{
	return (getTotalEmolumenElBhsTetap($d, $m, $y)+getTotalEmolumenElBhsKontrak($d, $m, $y));
}

function getEmolumenBSHByUserID($id, $d, $m, $y)
{
	if(getStatusTFByDateByStafID($id, $d, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($id, $m, $y) && checkStartDateByMonth($id, $m, $y)){
	$query_emo = "SELECT useremolumen_bsh FROM www.user_emolumen WHERE ((IFNULL(useremolumen_start_y, useremolumen_date_y) = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND IFNULL(useremolumen_start_m, useremolumen_date_m) <= '" . htmlspecialchars($m, ENT_QUOTES) . "') OR (IFNULL(useremolumen_start_y, useremolumen_date_y) < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND useremolumen_status = '1' AND user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC LIMIT 1";	
	$user_emo = mysql_query($query_emo);
	$row_emo = mysql_fetch_assoc($user_emo);
	
	$count = 0;
	
	if($row_emo['useremolumen_bsh']!=0 && $row_emo['useremolumen_bsh']!=NULL)
		return $row_emo['useremolumen_bsh'];
	else
		return 0; 
	} else {
		return 0;
	}
}

function getTotalEmolumenBSHByUserID($id, $y)
{
	$total = 0;
	
	for($i=1; $i<=12; $i++)
	{
		if($i<10)
			$i = '0' . $i;
		$total += getEmolumenBSHByUserID($id, 1, $i, $y);
	}
		
	return $total;
	
}

function getTotalEmolumenBSHTetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenBSHByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenBSHKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenBSHByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenBSH($d, $m, $y)
{
	return (getTotalEmolumenBSHTetap($d, $m, $y)+getTotalEmolumenBSHKontrak($d, $m, $y));
}

function getEmolumenPosBasikByUserID($id, $d, $m, $y)
{
	if(getStatusTFByDateByStafID($id, $d, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($id, $m, $y) && checkStartDateByMonth($id, $m, $y)){
	$query_emo = "SELECT useremolumen_posbasik FROM www.user_emolumen WHERE ((IFNULL(useremolumen_start_y, useremolumen_date_y) = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND IFNULL(useremolumen_start_m, useremolumen_date_m) <= '" . htmlspecialchars($m, ENT_QUOTES) . "') OR (IFNULL(useremolumen_start_y, useremolumen_date_y) < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND useremolumen_status = '1' AND user_stafid = '" . $id . "' ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC LIMIT 1";	
	$user_emo = mysql_query($query_emo);
	$row_emo = mysql_fetch_assoc($user_emo);
	
	$count = 0;
	
	if($row_emo['useremolumen_posbasik']!=0 && $row_emo['useremolumen_posbasik']!=NULL)
		return $row_emo['useremolumen_posbasik'];
	else
		return 0; 
	} else {
		return 0;
	}
}

function getTotalEmolumenPosBasikByUserID($id, $y)
{
	$total = 0;
	
	for($i=1; $i<=12; $i++)
	{
		if($i<10)
			$i = '0' . $i;
		$total += getEmolumenPosBasikByUserID($id, 1, $i, $y);
	}
		
	return $total;
	
}

function getTotalEmolumenPosBasikTetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenPosBasikByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenPosBasikKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenPosBasikByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenPosBasik($d, $m, $y)
{
	return (getTotalEmolumenPosBasikTetap($d, $m, $y)+getTotalEmolumenPosBasikKontrak($d, $m, $y));
}

function getEmolumenElPakarByUserID($id, $d, $m, $y)
{
	if(getStatusTFByDateByStafID($id, $d, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($id, $m, $y) && checkStartDateByMonth($id, $m, $y)){
	$query_emo = "SELECT useremolumen_elpakar FROM www.user_emolumen WHERE ((IFNULL(useremolumen_start_y, useremolumen_date_y) = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND IFNULL(useremolumen_start_m, useremolumen_date_m) <= '" . htmlspecialchars($m, ENT_QUOTES) . "') OR (IFNULL(useremolumen_start_y, useremolumen_date_y) < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND useremolumen_status = '1' AND user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC LIMIT 1";	
	$user_emo = mysql_query($query_emo);
	$row_emo = mysql_fetch_assoc($user_emo);
	
	$count = 0;
	
	if($row_emo['useremolumen_elpakar']!=0 && $row_emo['useremolumen_elpakar']!=NULL)
		return $row_emo['useremolumen_elpakar'];
	else
		return 0; 
	} else {
		return 0;
	}
}

function getTotalEmolumenElPakarByUserID($id, $y)
{
	$total = 0;
	
	for($i=1; $i<=12; $i++)
	{
		if($i<10)
			$i = '0' . $i;
		$total += getEmolumenElPakarByUserID($id, 1, $i, $y);
	}
		
	return $total;
	
}

function getTotalEmolumenElPakarTetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenElPakarByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenElPakarKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenElPakarByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenElPakar($d, $m, $y)
{
	return (getTotalEmolumenElPakarTetap($d, $m, $y)+getTotalEmolumenElPakarKontrak($d, $m, $y));
}

function getEmolumenElKtklByUserID($id, $d, $m, $y)
{
	if(getStatusTFByDateByStafID($id, $d, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($id, $m, $y) && checkStartDateByMonth($id, $m, $y)){
	$query_emo = "SELECT useremolumen_elktkl FROM www.user_emolumen WHERE ((IFNULL(useremolumen_start_y, useremolumen_date_y) = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND IFNULL(useremolumen_start_m, useremolumen_date_m) <= '" . htmlspecialchars($m, ENT_QUOTES) . "') OR (IFNULL(useremolumen_start_y, useremolumen_date_y) < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND useremolumen_status = '1' AND user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC LIMIT 1";	
	$user_emo = mysql_query($query_emo);
	$row_emo = mysql_fetch_assoc($user_emo);
	
	$count = 0;
	
	if($row_emo['useremolumen_elktkl']!=0 && $row_emo['useremolumen_elktkl']!=NULL)
		return $row_emo['useremolumen_elktkl'];
	else
		return 0; 
	} else {
		return 0;
	}
}

function getTotalEmolumenElKtklByUserID($id, $y)
{
	$total = 0;
	
	for($i=1; $i<=12; $i++)
	{
		if($i<10)
			$i = '0' . $i;
		$total += getEmolumenElKtklByUserID($id, 1, $i, $y);
	}
		
	return $total;
	
}

function getTotalEmolumenElKtklTetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenElKtklByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenElKtklKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenElKtklByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenElKtkl($d, $m, $y)
{
	return (getTotalEmolumenElKtklTetap($d, $m, $y) + getTotalEmolumenElKtklKontrak($d, $m, $y));
}

function getEmolumenOByUserID($id, $d, $m, $y)
{
	if(getStatusTFByDateByStafID($id, $d, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($id, $m, $y) && checkStartDateByMonth($id, $m, $y)){
	$query_emo = "SELECT useremolumen_o FROM www.user_emolumen WHERE ((IFNULL(useremolumen_start_y, useremolumen_date_y) = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND IFNULL(useremolumen_start_m, useremolumen_date_m) <= '" . htmlspecialchars($m, ENT_QUOTES) . "') OR (IFNULL(useremolumen_start_y, useremolumen_date_y) < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND useremolumen_status = '1' AND user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY useremolumen_date_y DESC, useremolumen_date_m DESC, useremolumen_date_d DESC, useremolumen_id DESC LIMIT 1";	
	$user_emo = mysql_query($query_emo);
	$row_emo = mysql_fetch_assoc($user_emo);
	
	$count = 0;
	
	if($row_emo['useremolumen_o']!=0 && $row_emo['useremolumen_o']!=NULL)
		return $row_emo['useremolumen_o'];
	else
		return 0; 
	} else {
		return 0;
	}
}

function getTotalEmolumenOByUserID($id, $y)
{
	$total = 0;
	
	for($i=1; $i<=12; $i++)
	{
		if($i<10)
			$i = '0' . $i;
		$total += getEmolumenOByUserID($id, 1, $i, $y);
	}
		
	return $total;
	
}

function getTotalEmolumenOTetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenOByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenOKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenOByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenO($d, $m, $y)
{
	return (getTotalEmolumenOTetap($d, $m, $y) + getTotalEmolumenOKontrak($d, $m, $y));
}

function getTotalEmolumenTetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumenKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getEmolumenByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmolumen($d, $m, $y)
{
	return (getTotalEmolumenTetap($d, $m, $y) + getTotalEmolumen($d, $m, $y));
}

function checkKWSPByStafID($id, $d, $m, $y)
{
	$query_ss = "SELECT userjob_kwsp_d, userjob_kwsp_m, userjob_kwsp_y FROM www.user_job WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND userjob_status = 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['userjob_kwsp_m'] != 0 && $row_ss['userjob_kwsp_y'] != 0)
	{
		if($m < $row_ss['userjob_kwsp_m'] && $y == $row_ss['userjob_kwsp_y'])
			return true;
		else if($y < $row_ss['userjob_kwsp_y'])
			return true;
		else
			return false;
	} else {
		return true;
	}
}

function getKWSPDateByStafID($id)
{
	$query_ss = "SELECT userjob_kwsp_d, userjob_kwsp_m, userjob_kwsp_y FROM www.user_job WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND userjob_status = 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['userjob_kwsp_d']!=0 && $row_ss['userjob_kwsp_m']!=0 && $row_ss['userjob_kwsp_y']!=0)
		return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['userjob_kwsp_m'], $row_ss['userjob_kwsp_d'], $row_ss['userjob_kwsp_y']));
	else
		return "";
}

function getKWSPStafPercByStafID($id, $d, $m, $y)
//function getKWSPStafPercByStafID($id, $d, $m, $y, $kwsp)
{
	if(checkKWSPByStafID($id, $d, $m, $y))
	{
		if(($m <'09' && $y <='2013') || ($m >'09' && $y<'2013'))
		{
			if(getAgeByUserID($id)>55 || checkPencenByDate($id, $m, $y))
				return 5.5;
			elseif(getAgeByUserID($id)<=55)
				return 11;
				
		} else {
			if(checkStafID('P2318')==TRUE)
			return 11;
			elseif(getAgeByUserID($id)>=61)
				return 5.5;
			elseif(getAgeByUserID($id)<61)
				return 11;
			
		};
		
	} else
		return 0;
}

function getKWSPEmpPercByStafID($id, $d, $m, $y)
{
	if(checkKWSPByStafID($id, $d, $m, $y))
	{
		if(($m <'09' && $y <='2013') || ($m >'09' && $y<'2013'))
		{
			if(getAgeByUserID($id)<=55)
				return 12;
			else if(getAgeByUserID($id)>55)
				return 6.5;
				
		} else {
			
			if(getTotalSalaryByUserID($id, $d, $m, $y)<=5000)
				return 13;
			else if(getTotalSalaryByUserID($id, $d, $m, $y)> 5000)
				return 12;
		}

	} else
	return 0;
}

function checkKelabMSNRM($id)
{
	$query_ss = "SELECT userjob_club FROM www.user_job WHERE userjob_status = 1 AND user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['userjob_club']==1)
		return true;
	else
		return false;
}

function getKelabMSNRM($id, $d, $m, $y)
{
	if(getStatusTFByDateByStafID($id, $d, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($id, $m, $y) && checkStartDateByMonth($id, $m, $y) && getBasicSalaryByUserID($id, $d, $m, $y) > 0){
	$query_ss = "SELECT club_onestaf FROM www.club WHERE (club_min <= '" . getBasicSalaryByUserID($id, $d, $m, $y) . "' AND club_max >= '" . getBasicSalaryByUserID($id, $d, $m, $y) . "') AND club_status = 1 LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total > 0 && checkKelabMSNRM($id))	
		$kmsn = $row_ss['club_onestaf'];
	else
		$kmsn = 0;
	} else {
		$kmsn = 0;
	};
	
	return $kmsn;
}

function getTotalKelabMSNRM($id, $y)
{
	$total = 0;
	for($i=1; $i<=12; $i++)
	{
		if($i<10)
			$i = '0' . $i;
		$total += getKelabMSNRM($id, 1, $i, $y);
	}
	
	return $total;
}

function getTotalKelabMSNTetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getKelabMSNRM($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalKelabMSNKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getKelabMSNRM($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getPotonganKwspByStafID($id)
{
	$sql = "SELECT userjob_kwsp_potong FROM user_job
	where user_stafid = '$id' ";
	$query = mysql_query($sql);
	$row = mysql_fetch_assoc($query);
	$potongankwsp= $row['userjob_kwsp_potong'];
	
	return $potongankwsp;
}

function getKWSPTypeByStafID($id, $m, $y)
{
	$data = getPotonganKwspByStafID($id);
	
	switch($data)
	{
		case 4:		$kwsp_type = 4; break;
		case 8: 	$kwsp_type = 3; break;
		case 5.5: 	$kwsp_type = 2; break;
		case 11: 	$kwsp_type = 1; break;
		default: 	$kwsp_type = 0; break;
	}

	return $kwsp_type;
/*
	if(($m <'09' && $y <='2013') || ($m >'09' && $y<'2013'))
	{
		if(getAgeByUserID($id)>55 || checkPencenByDate($id, $m, $y))
			return 2;
		elseif(getAgeByUserID($id)<=55)
			return 1;
			
	} else {
		if(checkStafID('P2318')==TRUE)
			return 1;
		elseif(getAgeByUserID($id)>=61)
			return 2;
		elseif(getAgeByUserID($id)<61)
			return 1;
	};
	//*/
	//if(getAgeByUserID($id)>55 || checkPencenByDate($id, $m, $y))
	//	return 2;
	//elseif(getAgeByUserID($id)<=55)
	//	return 1;
}

function getKWSPStafRM($id, $d, $m, $y, $kwsp=1, $perkeso=0)
{
	// kiraan KWSP Potongan Pekerja
	if(getStatusTFByDateByStafID($id, $d, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($id, $m, $y) && checkStartDateByMonth($id, $m, $y))
	{
		$query_ss = "SELECT kwsp_onestaf FROM www.kwsp WHERE (kwsp_min <= '" . getTotalSalaryByUserID($id, $d, $m, $y, $kwsp, $perkeso) . "' AND kwsp_max >= '" . getTotalSalaryByUserID($id, $d, $m, $y, $kwsp, $perkeso) . "') AND kwsp_status = 1 AND kwsp_type = '" . getKWSPTypeByStafID($id, $m, $y) . "'";	
		$user_ss = mysql_query($query_ss);
		$row_ss = mysql_fetch_assoc($user_ss);
		
		$total = mysql_num_rows($user_ss);
		
		if($total > 0 && checkKWSPByStafID($id, $d, $m, $y))	
			$kwsp = $row_ss['kwsp_onestaf'];
		else
			$kwsp = 0;
			
	} else {
		$kwsp = 0;
	}
	
	return $kwsp;
}

function getTotalKWSPStafRM($id, $y, $kwsp=1, $perkeso=0)
{
	$total = 0;
	for($i=1; $i<=12; $i++)
	{
		if($i<10)
			$i = '0' . $i;
		$total += getKWSPStafRM($id, 1, $i, $y, $kwsp, $perkeso);
	}
	
	return $total;
}

function getTotalKWSPStafTetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getKWSPStafRM($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalKWSPStafKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getKWSPStafRM($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalEmpRM($id, $d, $m, $y)
{
	return (getKWSPEmpRM($id, $d, $m, $y)+getPERKESOEmpRM($id, $d, $m, $y)+getPencenByStafID($id, $m, $y));
}

function getKWSPEmpRM($id, $d, $m, $y)
{
	// kiraan KWSP Potongan Majikan
	if(getStatusTFByDateByStafID($id, $d, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($id, $m, $y) && checkStartDateByMonth($id, $m, $y)){
	$query_ss = "SELECT kwsp_oneemp FROM www.kwsp WHERE (kwsp_min <= '" . getTotalSalaryByUserID($id, $d, $m, $y, 1, 0, 0) . "' AND kwsp_max >= '" . getTotalSalaryByUserID($id, $d, $m, $y, 1, 0, 0) . "') AND kwsp_status = 1 AND kwsp_type = '" . getKWSPTypeByStafID($id, $m, $y) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total > 0 && checkKWSPByStafID($id, $d, $m, $y))
		$kwsp = $row_ss['kwsp_oneemp'];
	else
		$kwsp = 0;
	} else {
		$kwsp = 0;
	}
	
	return $kwsp;
}

function getTotalKWSPEmpRM($id, $y)
{
	$total = 0;
	for($i=1; $i<=12; $i++)
	{
		if($i<10)
			$i = '0' . $i;
		$total += getKWSPEmpRM($id, 1, $i, $y);
	}
	
	return $total;
}

function getTotalKWSPEmpTetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getKWSPEmpRM($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalKWSPEmpKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getKWSPEmpRM($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function checkPERKESOByStafID($id, $d, $m, $y)
{
	$query_ss = "SELECT userjob_perkeso_d, userjob_perkeso_m, userjob_perkeso_y FROM www.user_job WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND userjob_status = 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['userjob_perkeso_m'] != 0 && $row_ss['userjob_perkeso_y'] != 0)
	{
		if($m < $row_ss['userjob_perkeso_m'] && $y == $row_ss['userjob_perkeso_y'])
			return true;
		else if($y < $row_ss['userjob_perkeso_y'])
			return true;
		else
			return false;
	} else {
		return true;
	}
}

function getPERKESODateByStafID($id)
{
	$query_ss = "SELECT userjob_perkeso_d, userjob_perkeso_m, userjob_perkeso_y FROM www.user_job WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND userjob_status = 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['userjob_perkeso_m']!=0 && $row_ss['userjob_perkeso_d']!=0 && $row_ss['userjob_perkeso_y']!=0)
		return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['userjob_perkeso_m'], $row_ss['userjob_perkeso_d'], $row_ss['userjob_perkeso_y']));
	else
		return "";
}

function getPERKESOStafRM($id, $d, $m, $y, $kwsp=0, $perkeso=1, $pencen=0)
{
	if(checkPERKESOByStafID($id, $d, $m, $y)  && !checkPencenByDate($id, $m, $y) && getStatusTFByDateByStafID($id, $d, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($id, $m, $y) && checkStartDateByMonth($id, $m, $y)) // jika dikira Gaji Pokok && getBasicSalaryByUserID($id, 1, $m, $y)<3000)
	{
		$query_ss = "SELECT perkeso_onestaf FROM www.perkeso WHERE ((perkeso_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND perkeso_date_m <= '" . htmlspecialchars($m, ENT_QUOTES) . "') OR (perkeso_date_y < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND (perkeso_min < '" . getTotalSalaryByUserID($id, $d, $m, $y, 0, 1, 0) . "' AND perkeso_max >= '" . getTotalSalaryByUserID($id, $d, $m, $y, 0, 1, 0) . "') AND perkeso_status = '1' ORDER BY perkeso_date_y DESC, perkeso_date_m DESC, perkeso_date_d DESC, perkeso_id DESC LIMIT 1";	
		$user_ss = mysql_query($query_ss);
		$row_ss = mysql_fetch_assoc($user_ss);
		
		$rm = $row_ss['perkeso_onestaf'];
	} else {
		$rm = 0;
	}
	
	return $rm;
}

function getTotalPERKESOStafRM($id, $y, $kwsp=0, $perkeso=1)
{
	$total = 0;
	for($i=1; $i<=12; $i++)
	{
		if($i<10)
			$i = '0' . $i;
		$total += getPERKESOStafRM($id, 1, $i, $y, $kwsp, $perkeso);
	}
	
	return $total;
}

function getTotalPERKESOStafTetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getPERKESOStafRM($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalPERKESOStafKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getPERKESOStafRM($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getPERKESOEmpRM($id, $d, $m, $y)
{
	if(checkPERKESOByStafID($id, $d, $m, $y) && !checkPencenByDate($id, $m, $y) && getStatusTFByDateByStafID($id, $d, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($id, $m, $y) && checkStartDateByMonth($id, $m, $y)) // Jika dikira Gaji Pokok && getBasicSalaryByUserID($id, 1, $m, $y)<3000)
	{
		$query_ss = "SELECT perkeso_oneemp FROM www.perkeso WHERE ((perkeso_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND perkeso_date_m <= '" . htmlspecialchars($m, ENT_QUOTES) . "') OR (perkeso_date_y < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND (perkeso_min < '" . getTotalSalaryByUserID($id, $d, $m, $y, 0, 1, 0) . "' AND perkeso_max >= '" . getTotalSalaryByUserID($id, $d, $m, $y, 0, 1, 0) . "') AND perkeso_status = '1' ORDER BY perkeso_date_y DESC, perkeso_date_m DESC, perkeso_date_d DESC, perkeso_id DESC LIMIT 1";	
		$user_ss = mysql_query($query_ss);
		$row_ss = mysql_fetch_assoc($user_ss);
		
		$rm = $row_ss['perkeso_oneemp'];
	} else {
		$rm = 0;
	}
	
	return $rm;
}

function getTotalPERKESOEmpRM($id, $y)
{
	$total = 0;
	for($i=1; $i<=12; $i++)
	{
		if($i<10)
			$i = '0' . $i;
		$total += getPERKESOEmpRM($id, 1, $i, $y);
	}
	
	return $total;
}

function getTotalPERKESOEmpTetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getPERKESOEmpRM($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalPERKESOEmpKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getPERKESOEmpRM($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function checkLHDNByStafID($id, $d, $m, $y)
{
	$query_ss = "SELECT userjob_lhdn_d, userjob_lhdn_m, userjob_lhdn_y FROM www.user_job WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND userjob_status = 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['userjob_lhdn_m'] != 0 && $row_ss['userjob_lhdn_y'] != 0)
	{
		if($m < $row_ss['userjob_lhdn_m'] && $y == $row_ss['userjob_lhdn_y'])
			return true;
		else if($y < $row_ss['userjob_lhdn_y'])
			return true;
		else
			return false;
	} else {
		return true;
	}
}

function getLHDNDateByStafID($id)
{
	$query_ss = "SELECT userjob_lhdn_d, userjob_lhdn_m, userjob_lhdn_y FROM www.user_job WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND userjob_status = 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['userjob_lhdn_m']!=0 && $row_ss['userjob_lhdn_d']!=0 && $row_ss['userjob_lhdn_y']!=0)
		return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['userjob_lhdn_m'], $row_ss['userjob_lhdn_d'], $row_ss['userjob_lhdn_y']));
	else
		return "";
}

function getPencenByStafID($userid, $m, $y)
{
	$pencen = 0;
	
	if(!checkKWSPByStafID($userid, '01', $m, $y) && getJobtypeIDByUserID($userid)=='1' && checkSalarySchDate($m, $y))
		$pencen = (getBasicSalaryByUserID($userid, '01', $m, $y)*(17.5/100));
	
	return $pencen;		
}

function getTotalPencenByStafID($userid, $y)
{
	$total = 0;
	for($i=1; $i<=12; $i++)
	{
		if($i<10)
			$i = '0' . $i;
		$total += getPencenByStafID($userid, $i, $y);
	}
	
	return $total;
}

function getTotalPencenTetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getPencenByStafID($row_ss['user_stafid'], $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalPencenKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getPencenByStafID($row_ss['user_stafid'], $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalSalaryByUserID($id, $d, $m, $y, $kwsp=0, $perkeso=0)
{
	return (getBasicSalaryByUserID($id, $d, $m, $y) + getEmolumenByUserID($id, $d, $m, $y) + getTotalTransactionSalaryByUserID($id, $m, $y, $kwsp, $perkeso));
}

function getTotalSalByUserID($id, $d, $m, $y, $kwsp=0, $perkeso=0)
{
	return (getBasicSalaryByUserID($id, $d, $m, $y) + getTotalTransactionSalaryByUserID($id, $m, $y, $kwsp, $perkeso));
}

function getTotalSalaryTetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getTotalSalaryByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalSalaryKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;

	
	do{
		$total += getTotalSalaryByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalSalary($d, $m, $y)
{
	return (getTotalSalaryKontrak($d, $m, $y)+getTotalSalaryTetap($d, $m, $y));
}

function getTotalSalaryPerYearByUserID($id, $y)
{
	$total = 0;
	for($i = 1; $i<=12; $i++)
	{
		if($i<10)
			$i = '0' . $i;
			
		$total += getTotalSalaryByUserID($id, '01', $i, $y);
	};
		
	return number_format($total,2);
}

function getTotalBasicSalaryPerYearByUserID($id, $y)
{
	$total = 0;
	for($i = 1; $i<=12; $i++)
	{
		if($i<10)
			$i = '0' . $i;
			
		$total += getBasicSalaryByUserID($id, 1, $i, $y);
	};
		
	return $total;
}

function getTotalSaraanByUserID($id, $y)
{
	return (getTotalBasicSalaryPerYearByUserID($id, $y) + getTotalEmolumenElKtklByUserID($id, $y) + getTotalEmolumenElPakarByUserID($id, $y) + getTotalTransactionYearByUserID($id, 41, $y) + getTotalTransactionYearByUserID($id, 60, $y));
}

function getTotalCutByUserID($id, $d, $m, $y, $kwsp=0, $perkeso=0)
{
	return (getKWSPStafRM($id, $d, $m, $y, 1, 0) + getPERKESOStafRM($id, $d, $m, $y, 0, 1) + getKelabMSNRM($id, $d, $m, $y) + getTotalTransactionCutByUserID($id, $m, $y));
}

function getTotalCutTetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getTotalCutByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalCutKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getTotalCutByUserID($row_ss['user_stafid'], $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalCut($d, $m, $y)
{
	return (getTotalCutTetap($d, $m, $y) + getTotalCutKontrak($d, $m, $y));
}

function getGajiBersihByUserID($id, $d, $m, $y)
{
	return (getTotalSalaryByUserID($id, $d, $m, $y) - getTotalCutByUserID($id, $d, $m, $y));
}

function getGajiBersihYearByUserID($id, $y)
{
	$total = 0;
	for($i=1; $i<=12; $i++)
	{
		if($i<10)
			$i = '0' . $i;
		$total += getGajiBersihByUserID($id, 1, $i, $y);
	}
	
	return $total;
}

function getTransactionTypeID($id)
{
	$query_ss = "SELECT transaction_type.transactiontype_id FROM www.transaction_type LEFT JOIN www.transaction ON transaction_type.transactiontype_id = transaction.transactiontype_id WHERE transaction.transaction_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['transactiontype_id'];
}

function getTransactionType($id)
{
	$query_ss = "SELECT transaction_type.transactiontype_name FROM www.transaction_type LEFT JOIN www.transaction ON transaction_type.transactiontype_id = transaction.transactiontype_id WHERE transaction.transaction_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['transactiontype_name'];
}

function getTransactionDateStart($userid, $id, $usersalaryid=0)
{
	$wsql = "";
	if($usersalaryid!=0)
		$wsql = " AND user_salary.usersalary_id = '" . htmlspecialchars($usersalaryid, ENT_QUOTES) . "'";
		
	$query_ss = "SELECT usersalary_date_d, usersalary_date_m, usersalary_date_y FROM www.user_salary WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND transaction_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND usersalary_status = 1 " . $wsql . " ORDER BY usersalary_date_y DESC, usersalary_date_m DESC, usersalary_date_d DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['usersalary_date_m']!=0 && $row_ss['usersalary_date_d'] != 0 && $row_ss['usersalary_date_y'] != 0)
		return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['usersalary_date_m'], $row_ss['usersalary_date_d'], $row_ss['usersalary_date_y']));
	else
		return 0;
}

function getTransactionDateEnd($userid, $id, $usersalaryid=0)
{
	$wsql = "";
	if($usersalaryid!=0)
		$wsql = " AND user_salary.usersalary_id = '" . htmlspecialchars($usersalaryid, ENT_QUOTES) . "'";
		
	$query_ss = "SELECT usersalary_end_d, usersalary_end_m, usersalary_end_y FROM www.user_salary WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND transaction_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND usersalary_status = 1 " . $wsql . " ORDER BY usersalary_date_y DESC, usersalary_date_m DESC, usersalary_date_d DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['usersalary_end_m']!=0 && $row_ss['usersalary_end_d'] != 0 && $row_ss['usersalary_end_y'] != 0)
		return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['usersalary_end_m'], $row_ss['usersalary_end_d'], $row_ss['usersalary_end_y']));
	else
		return "Berterusan";
}

function checkTransactionDateEnd($userid, $id)
{
	$query_ss = "SELECT usersalary_end_d, usersalary_end_m, usersalary_end_y FROM www.user_salary WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND transaction_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND usersalary_status = 1 ORDER BY usersalary_date_y DESC, usersalary_date_m DESC, usersalary_date_d DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['usersalary_end_m']!=0 && $row_ss['usersalary_end_d'] != 0 && $row_ss['usersalary_end_y'] != 0)
		return true;
	else
		return false;
}

function getSalaryRef($userid, $id)
{
	$query_ss = "SELECT usersalary_ref FROM www.user_salary WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND transaction_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND usersalary_status = 1 ORDER BY usersalary_date_y DESC, usersalary_date_m DESC, usersalary_date_d DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['usersalary_ref'];
}

function getTransactionIDByUserID($id)
{
	$query_ss = "SELECT transaction.transaction_id FROM www.transaction LEFT JOIN www.user_salary ON transaction.transaction_id= user_salary.transaction_id WHERE user_salary.user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND transaction_status=1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['transaction_id'];
}

function getTransactionName($id)
{
	$query_ss = "SELECT transaction_name FROM www.transaction WHERE transaction_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['transaction_name'];
}

function getTransactionCode($id)
{
	$query_ss = "SELECT transaction_code FROM www.transaction WHERE transaction_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['transaction_code'];
}

function checkTransactionByUseriD($userid, $transID, $d, $m, $y)
{
	$query_ss = "SELECT user_salary.*, transaction.transactiontype_id FROM www.user_salary LEFT JOIN transaction ON user_salary.transaction_id = transaction.transaction_id WHERE user_salary.user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND user_salary.usersalary_status = 1 AND user_salary.transaction_id = '" . htmlspecialchars($transID , ENT_QUOTES). "' AND ((user_salary.usersalary_date_m <= '" . htmlspecialchars($m, ENT_QUOTES) . "' AND user_salary.usersalary_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "')OR(user_salary.usersalary_date_y < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND (((user_salary.usersalary_end_m >= '" . htmlspecialchars($m, ENT_QUOTES) . "' AND user_salary.usersalary_end_y = '" . htmlspecialchars($y, ENT_QUOTES) . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))OR((user_salary.usersalary_end_y > '" . htmlspecialchars($y, ENT_QUOTES) . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))) ORDER BY user_salary.usersalary_date_y DESC, user_salary.usersalary_date_m DESC, user_salary.usersalary_date_d DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total = mysql_num_rows($user_ss);
	
	if($total>0)
		return true;
	else
		return false;
}

function getTransactionByUserID($userid, $transID, $d, $m, $y)
{
	if(getStatusTFByDateByStafID($userid, $d, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($userid, $m, $y) && checkStartDateByMonth($userid, $m, $y)){
	$query_ss = "SELECT user_salary.*, transaction.transactiontype_id FROM www.user_salary LEFT JOIN www.transaction ON user_salary.transaction_id = transaction.transaction_id WHERE user_salary.user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND user_salary.usersalary_status = 1 AND user_salary.transaction_id = '" . htmlspecialchars($transID, ENT_QUOTES) . "' AND ((user_salary.usersalary_date_m <= '" . htmlspecialchars($m, ENT_QUOTES) . "' AND user_salary.usersalary_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "')OR(user_salary.usersalary_date_y < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND (((user_salary.usersalary_end_m >= '" . htmlspecialchars($m, ENT_QUOTES) . "' AND user_salary.usersalary_end_y = '" . htmlspecialchars($y, ENT_QUOTES) . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))OR((user_salary.usersalary_end_y > '" . htmlspecialchars($y, ENT_QUOTES) . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))) ORDER BY user_salary.usersalary_date_y DESC, user_salary.usersalary_date_m DESC, user_salary.usersalary_date_d DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total>0)
		$tr = $row_ss['usersalary_value'];
	else
		$tr = 0;
	} else {
		$tr = 0;
	}
	
	return $tr;
}

function getTransactionPCBByUserID($userid, $transID, $d, $m, $y)
{
	
	if(getStatusTFByDateByStafID($userid, $d, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($userid, $m, $y) && checkStartDateByMonth($userid, $m, $y)){
	$query_ss = "SELECT user_salary.*, transaction.transactiontype_id FROM www.user_salary LEFT JOIN www.transaction ON user_salary.transaction_id = transaction.transaction_id WHERE user_salary.user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND user_salary.usersalary_status = 1 AND user_salary.transaction_id = '" . htmlspecialchars($transID, ENT_QUOTES) . "' AND ((user_salary.usersalary_date_m <= '" . htmlspecialchars($m, ENT_QUOTES) . "' AND user_salary.usersalary_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "')OR(user_salary.usersalary_date_y < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND (((user_salary.usersalary_end_m >= '" . htmlspecialchars($m, ENT_QUOTES) . "' AND user_salary.usersalary_end_y = '" . htmlspecialchars($y, ENT_QUOTES) . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))OR((user_salary.usersalary_end_y > '" . htmlspecialchars($y, ENT_QUOTES) . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))) ORDER BY user_salary.usersalary_date_y DESC, user_salary.usersalary_date_m DESC, user_salary.usersalary_date_d DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total>0)
		$tr = $row_ss['usersalary_value'];
	else
		$tr = 0;
	} else {
		$tr = 0;
	}
	
	return $tr;
}

function getTotalTransactionYearByUserID($id, $transID, $y)
{
	$total = 0;
	
	for($i=1; $i<=12; $i++)
	{
		if($i<10)
			$i = '0' . $i;
		$total += getTransactionByUserID($id, $transID, 1, $i, $y);
	}
	
	return $total;
}

function getTotalTransactionSalaryByUserID($id, $m, $y, $kwsp=0, $perkeso=0, $pencen=0)
{
	$wsql = "";
	
	if($kwsp == 1)
		$wsql .= " AND transaction.kwsp = 1";
	if($perkeso == 1)
		$wsql .= " AND transaction.perkeso = 1";
	if($pencen == 1)
		$wsql .= " AND transaction.pencen =1";
		
	if(getStatusTFByDateByStafID($id, 1, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($id, $m, $y) && checkStartDateByMonth($id, $m, $y))
	{
	$query_ss = "SELECT user_salary.*, transaction.transactiontype_id FROM www.user_salary LEFT JOIN transaction ON user_salary.transaction_id = transaction.transaction_id WHERE transactiontype_id = 1 " . $wsql . " AND user_salary.user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND ((user_salary.usersalary_date_m <= '" . htmlspecialchars($m, ENT_QUOTES) . "' AND user_salary.usersalary_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "') OR ( user_salary.usersalary_date_y < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND (((user_salary.usersalary_end_m >= '" . htmlspecialchars($m, ENT_QUOTES) . "' AND user_salary.usersalary_end_y = '" . htmlspecialchars($y, ENT_QUOTES) . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))OR((user_salary.usersalary_end_y > '" . htmlspecialchars($y, ENT_QUOTES) . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))) AND user_salary.usersalary_status = 1 ORDER BY user_stafid ASC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$count = 0;
	do {
		$count += $row_ss['usersalary_value'];
	} while($row_ss = mysql_fetch_assoc($user_ss));
	
	} else {
		$count = 0;
	}
	
	return $count;
}

function getTotalTransSalaryByUserID($id, $m, $y, $kwsp=0, $perkeso=0, $pencen=0)
{
	$wsql = "";
		
	if(getStatusTFByDateByStafID($id, 1, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($id, $m, $y) && checkStartDateByMonth($id, $m, $y))
	{
	$query_ss = "SELECT user_salary.*, transaction.transactiontype_id FROM www.user_salary LEFT JOIN transaction ON user_salary.transaction_id = transaction.transaction_id WHERE transactiontype_id = 1 " . $wsql . " AND user_salary.user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND ((user_salary.usersalary_date_m <= '" . htmlspecialchars($m, ENT_QUOTES) . "' AND user_salary.usersalary_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "') OR ( user_salary.usersalary_date_y < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND (((user_salary.usersalary_end_m >= '" . htmlspecialchars($m, ENT_QUOTES) . "' AND user_salary.usersalary_end_y = '" . htmlspecialchars($y, ENT_QUOTES) . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))OR((user_salary.usersalary_end_y > '" . htmlspecialchars($y, ENT_QUOTES) . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))) AND user_salary.usersalary_status = 1 ORDER BY user_stafid ASC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$count = 0;
	do {
		$count += $row_ss['usersalary_value'];
	} while($row_ss = mysql_fetch_assoc($user_ss));
	
	} else {
		$count = 0;
	}
	
	return $count;
}

function getTotalAllTransactionSalaryTetap($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getTotalTransactionSalaryByUserID($row_ss['user_stafid'], $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalAllTransactionSalaryKontrak($d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getTotalTransactionSalaryByUserID($row_ss['user_stafid'], $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalTransactionSalary($transID, $d, $m, $y)
{
	return (getTotalTransactionSalaryTetap($transID, $d, $m, $y)+getTotalTransactionSalaryKontrak($transID, $d, $m, $y));
}

function getTotalTransactionSalaryTetap($transID, $d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getTransactionByUserID($row_ss['user_stafid'], $transID, $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalTransactionSalaryKontrak($transID, $d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getTransactionByUserID($row_ss['user_stafid'], $transID, $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalTransactionCutByUserID($id, $m, $y)
{
	if(getStatusTFByDateByStafID($id, 1, $m, $y) && checkSalarySchDate($m, $y) && !checkSalaryBlockByUserID($id, $m, $y) && checkStartDateByMonth($id, $m, $y)){
	$query_ss = "SELECT user_salary.*, transaction.transactiontype_id FROM www.user_salary LEFT JOIN transaction ON user_salary.transaction_id = transaction.transaction_id WHERE transactiontype_id = 2 AND user_salary.user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND ((user_salary.usersalary_date_m <= '" . htmlspecialchars($m, ENT_QUOTES) . "' AND user_salary.usersalary_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "')OR(user_salary.usersalary_date_y < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND (((user_salary.usersalary_end_m >= '" . htmlspecialchars($m, ENT_QUOTES) . "' AND user_salary.usersalary_end_y = '" . htmlspecialchars($y, ENT_QUOTES) . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))OR((user_salary.usersalary_end_y > '" . htmlspecialchars($y, ENT_QUOTES) . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))) AND user_salary.usersalary_status = 1 ORDER BY user_stafid ASC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$count = 0;
	do {
		$count += $row_ss['usersalary_value'];
	} while($row_ss = mysql_fetch_assoc($user_ss));
	
	} else {
		$count = 0;
	}
	
	return $count;
}

function getTotalTransactionCut($transID, $d, $m, $y)
{
	return (getTotalTransactionCutTetap($transID, $d, $m, $y)+getTotalTransactionCutKontrak($transID, $d, $m, $y));
}

function getTotalTransactionCutTetap($transID, $d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '1'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getTransactionByUserID($row_ss['user_stafid'], $transID, $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

function getTotalTransactionCutKontrak($transID, $d, $m, $y)
{
	$sql_where = " login.login_status = '1' AND user_designation.jobtype_id = '2'";
	$query_ss = sqlAllStaf($sql_where);	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = 0;
	
	do{
		$total += getTransactionByUserID($row_ss['user_stafid'], $transID, $d, $m, $y);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $total;
}

//Salary Block

function getUserSalaryIDByUserID($userid, $transID, $d, $m, $y)
{
	$query_ss = "SELECT user_salary.* FROM www.user_salary WHERE user_salary.user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND user_salary.transaction_id = '" . $transID . "' AND ((user_salary.usersalary_date_m <= '" . htmlspecialchars($m, ENT_QUOTES) . "' AND user_salary.usersalary_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "')OR(user_salary.usersalary_date_m <= '" . htmlspecialchars($m, ENT_QUOTES) . "' AND user_salary.usersalary_date_y < '" . htmlspecialchars($y, ENT_QUOTES) . "')) AND (((user_salary.usersalary_end_m >= '" . htmlspecialchars($m, ENT_QUOTES) . "' AND user_salary.usersalary_end_y = '" . htmlspecialchars($y, ENT_QUOTES) . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))OR((user_salary.usersalary_end_y > '" . htmlspecialchars($y, ENT_QUOTES) . "') OR (user_salary.usersalary_end_m = 0 && user_salary.usersalary_end_y = 0))) AND user_salary.usersalary_status = 1 ORDER BY user_stafid ASC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['usersalary_id'];
}

function getSalaryBlockStartDateByID($id)
{
	$query_ss = "SELECT usb_start_m, usb_start_y FROM www.user_salaryblock WHERE usb_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND usb_status='1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['usb_start_m'] . " / " . $row_ss['usb_start_y'];
}

function getSalaryBlockEndDateByID($id)
{
	$query_ss = "SELECT usb_end_m, usb_end_y FROM www.user_salaryblock WHERE usb_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND usb_status='1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['usb_end_m'] . " / " . $row_ss['usb_end_y'];
}

function checkSalaryBlockByUserID($user, $m, $y)
{
	$query_ss = "SELECT user_salaryblock.usb_id FROM www.user_salaryblock LEFT JOIN www.user ON user.user_stafid = user_salaryblock.user_stafid WHERE user_salaryblock.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND user_salaryblock.usb_status = 1 AND ((user_salaryblock.usb_start_m <= '" . htmlspecialchars($m, ENT_QUOTES) . "' AND user_salaryblock.usb_start_y = '" . htmlspecialchars($y, ENT_QUOTES) . "') AND ((user_salaryblock.usb_end_m >= '" . htmlspecialchars($m, ENT_QUOTES) . "' AND user_salaryblock.usb_end_y = '" . htmlspecialchars($y, ENT_QUOTES) . "') OR (user_salaryblock.usb_end_m < '" . htmlspecialchars($m, ENT_QUOTES) . "' AND user_salaryblock.usb_end_y > '" . htmlspecialchars($y, ENT_QUOTES) . "'))) ORDER BY user.user_firstname ASC, user.user_lastname ASC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total > 0)
		return true;
	else
		return false;
}
?>
<?php
//kursus
function getQ()
{
	if(date('m')<='03'){ //Q1
		$q = '1';
	} else if(date('m')<='06'){ //Q2
		$q = '2';
	} else if(date('m')<='09'){ //Q3
		$q = '3';
	} else if(date('m')<='12'){ //Q4
		$q = '4';
	} else {
		$q = '1';
	};
	
	return $q;
}

function getDayByQ()
{
	if(date('m')<='03'){ //Q1
	
		$jk_d = 1; // 1 Hari
	} else if(date('m')<='06'){ //Q2
		$jk_d = 3; // 3 Hari
	} else if(date('m')<='09'){ //Q3
		$jk_d = 5; // 5 Hari
	} else if(date('m')<='12'){ //Q4
		$jk_d = 7; // 7 Hari
	} else {
		$jk_d = 1; // 1 Hari
	}
	
	return $jk_d;
}

function getHourByQ()
{
	if(date('m')<='03'){ //Q1
		$jk_h = 5; // 5 Jam
	} else if(date('m')<='06'){ //Q2
		$jk_h = 4; // 4 Jam
	} else if(date('m')<='09'){ //Q3
		$jk_h = 3; // 3 Jam
	} else if(date('m')<='12'){ //Q4
		$jk_h = 2; // 2 Jam
	} else {
		$jk_h = 5; // 5 Jam
	}
	
	return $jk_h;
}

function getTotalHourByQ()
{	
	return ((getDayByQ())*6 + getHourByQ()); // kiraan 1 Hari = 6 jam
}

function getHourByDayHour($day, $hour)
{
	return (($day*6)+$hour);
}

function getDayHourByHour($hour)
{
	$cd = intval($hour/6); // kiraan 1 Hari = 6 jam
	$ch = $hour%6;
	
	$view[0] = $cd; // Hari
	$view[1] = $ch; // Jam
	
	return $view;
}

function countCoursesDayPerMonth()
{
	return ((7*6)/12); // 7 hari jumlah kursus setahun, 6 jam untuk 1 hari, 12 bulan untuk setahun, $houryear = jumlah jam / bulan
}

function getCoursesDayByYear($userid, $y)
{
	if(getStartDayDate($userid, 3) < date('Y'))
		return 7; // jumlah hari kursus per tahun
	else
	{
		$m = getStartDayDate($userid, 2); // Bulan lapor diri
		$cd = round( ( (12-$m) * countCoursesDayPerMonth() ) / 6 );
		return $cd;
	};	
}

function getCoursesHRID()
{
	// senarai Staf ID yg menguruskan Modul HR > Kursus
	$query_ss = "SELECT user_stafid FROM www.user_sysacc WHERE menu_id = '5' AND submenu_id = '11' AND usersysacc_status='1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$list = array();
	do{
		$list[] = $row_ss['user_stafid'];
	} while($row_ss = mysql_fetch_assoc($user_ss));
		
	return $list;
}

function getCoursesID($user, $coursesid=0)
{
	$query_ss = "SELECT usercourses_id FROM www.user_courses WHERE user_courses.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND user_courses.courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "' AND usercourses_status = '1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['usercourses_id'];
}

function getCoursesName($coursesid)
{
	$query_ss = "SELECT courses_name FROM www.courses WHERE courses_status = '1' AND courses.courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['courses_name'];
}

function getCoursesLocation($coursesid)
{
	$query_ss = "SELECT courses_location FROM www.courses WHERE courses_status = '1' AND courses.courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['courses_location'];
}

function getCoursesTime($coursesid)
{
	$query_ss = "SELECT courses_time FROM www.courses WHERE courses_status = '1' AND courses.courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['courses_time'];
}

function getCoursesDuration($coursesid, $user=0)
{
	$query_ss = "SELECT courses_duration FROM www.courses WHERE courses_status = '1' AND courses.courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if(getUserAsByUserID($user, $coursesid)==1)
		$dur = 1;
	else
		$dur = $row_ss['courses_duration'];
		
	return $dur;
}

function getCoursesCategoryName($coursescatid)
{
	$query_ss = "SELECT coursescategory_name FROM www.courses_category WHERE coursescategory_status = '1' AND courses_category.coursescategory_id = '" . htmlspecialchars($coursescatid, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['coursescategory_name'];

}

function getOrganizedBy($orgid, $coursesid)
{
	$oby = "Tidak dinyatakan";
	
	if($orgid != '0')
	{
		$query_ss = "SELECT organizedby_id, organizedby_name FROM www.organized_by WHERE organizedby_id = '" . htmlspecialchars($orgid, ENT_QUOTES) . "'";	
		$user_ss = mysql_query($query_ss);
		$row_ss = mysql_fetch_assoc($user_ss);
		
		$oby = $row_ss['organizedby_name'];
	} else {
		$query_ss = "SELECT courses_lectureby FROM www.courses WHERE courses_status = '1' AND courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "'";	
		$user_ss = mysql_query($query_ss);
		$row_ss = mysql_fetch_assoc($user_ss);
		
		if($row_ss['courses_lectureby']!= '')
			$oby = $row_ss['courses_lectureby'];
		else
			$oby = "Tidak dinyatakan";
	};

	return $oby;
}

function getDurationType($id)
{
	$query_ss = "SELECT durationtype_name FROM www.duration_type WHERE durationtype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['durationtype_name'];
}

function getDurationTypeByCoursesID($coursesid, $user)
{
	$query_ss = "SELECT durationtype_id FROM www.courses WHERE courses_status = '1' AND courses.courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if(getUserAsByUserID($user, $coursesid)==1)
		$dur = 2;
	else
		$dur = $row_ss['durationtype_id'];
		
	return $dur;
}

function getCoursesDate($coursesid, $nt=1) //nt - line baru
{
	$query_ss = "SELECT courses_start_y, courses_start_m, courses_start_d, courses_end_d, courses_end_m, courses_end_y FROM www.courses WHERE courses_status = '1' AND courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$startdate = date('d/m/Y (D)', mktime(0, 0, 0, $row_ss['courses_start_m'], $row_ss['courses_start_d'], $row_ss['courses_start_y'])); 
	$enddate = date('d/m/Y (D)', mktime(0, 0, 0, $row_ss['courses_end_m'], $row_ss['courses_end_d'], $row_ss['courses_end_y']));	
	
	if($nt==1)
		$nl = "<br/>";
	else
		$nl = "";
		
	if($startdate != $enddate) 
		$date = $startdate . " - " . $nl . $enddate; 
	else 
		$date = $startdate;
		
	return $date;
}

function checkCoursesDir($user, $coursesid)
{
	$query_ss = "SELECT dir_id FROM www.courses WHERE courses_status = '1' AND courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if(getDirSubIDByUser($user)==$row_ss['dir_id'])
		return true;
	else
		return false;	
}

function checkCoursesGroup($user, $coursesid)
{
	$query_ss = "SELECT group_id FROM www.courses WHERE courses_status = '1' AND courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if(getGroupIDByUserID($user)== $row_ss['group_id'])
		return true;
	else
		return false;
}

function checkUserCoursesEntry($user,$coursesid) //menyemak user sama ada sudah menyertai atau tidak
{
	$query_ss = "SELECT user_stafid FROM www.user_courses WHERE user_courses.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND user_courses.courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "' AND usercourses_status = '1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total > 0)
		return true;
	else
		return false;
}

function totalUserCoursesEntry($coursesid)  // jumlah penyertaan
{
	$query_ss = "SELECT user_stafid FROM www.user_courses WHERE user_courses.courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "' AND usercourses_status = '1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	return $total;
}

function getUserCoursesEntryandTotal($coursesid)
{
	$query_ss = "SELECT courses_entry FROM www.courses WHERE courses.courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "' AND courses_status = '1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if(checkFullEntry($coursesid))
	{
		if($row_ss['courses_entry']!='0') 
			$total =  totalUserCoursesEntry($coursesid) . " / " . $row_ss['courses_entry']; 
		else 
			$total = "Terbuka";
	} else {
		if($row_ss['courses_entry']!='0') 
			$total = "<span class=\"txt_color2\">Penuh</span>";
		else 
			$total = "Terbuka";
	}
	
	return $total;
}

function getCoursesEntryorFull($id)
{
	$query_ss = "SELECT courses_entry FROM www.courses WHERE courses_status = '1' AND courses_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

		if($row_ss['courses_entry']!=0)
		{
			if(totalUserCoursesEntry($id) < $row_ss['courses_entry'])
				$view = $row_ss['courses_entry'] . " org";
			else
				$view = "<span class=\"txt_color2\">Penuh</span>";
		} else
		{
			$view = "Terbuka";
		}

	return $view;
}

function getCourseType($typeid)
{
	$query_ss = "SELECT coursestype_name FROM www.courses_type WHERE coursestype_id = '" . htmlspecialchars($typeid, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['coursestype_name'];
}

function getCoursesTypeID($coursesid)
{
	$query_ss = "SELECT coursestype_id FROM www.courses WHERE courses_status = '1' AND courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['coursestype_id'];
}

function getUserAsByUserID($userid, $coursesid)
{
	$query_ss = "SELECT user_courses.usercourses_as FROM www.user_courses WHERE user_courses.usercourses_status = '1' AND user_courses.user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND user_courses.courses_id='" . htmlspecialchars($coursesid, ENT_QUOTES) . "' ORDER BY user_courses.usercourses_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['usercourses_as'];
}

function checkUserInCoursesGroup($user,$coursesid,$groupid) // menyemak user berada dalam group yang di spesifikasikan utk kursus tersebut
{
	if($groupid==0 || checkCoursesGroup($user,$coursesid))
		return true;
	else 
		return false;
}

function checkUserInCoursesDir($user,$coursesid,$dirid) // menyemak user berada dalam kursus yang spesifik utk Bahagaian tertentu
{
	if($dirid==0 || checkCoursesDir($user,$coursesid))
		return true;
	else
		return false;
}

function checkFullEntry($coursesid) // menyemak kursus telah penuh atau TERBUKA
{
	$query_ss = "SELECT courses_entry FROM www.courses WHERE courses_status = '1' AND courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['courses_entry']==0 || (totalUserCoursesEntry($coursesid)<$row_ss['courses_entry']))
		return true;
	else
		return false;
}

function checkStartDate($coursesid)
{
	$query_ss = "SELECT courses_start_d, courses_start_m, courses_start_y FROM www.courses WHERE courses_status = '1' AND courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$enddate = false;
	
	if(date('Y')>=$row_ss['courses_start_y'])
		if(date('m')==$row_ss['courses_start_m'] && date('d')>=$row_ss['courses_start_d'])
			$enddate = true;
		else if(date('m')>$row_ss['courses_start_m'])
			$enddate = true;
				
	return $enddate;
}

function checkEndDate($coursesid)
{
	$query_ss = "SELECT courses_end_d, courses_end_m, courses_end_y FROM www.courses WHERE courses_status = '1' AND courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$enddate = false;
	
	if(date('Y')<=$row_ss['courses_end_y'])
	{
		if(date('m')==$row_ss['courses_end_m'] && date('d')<=$row_ss['courses_end_d'])
			$enddate = true;
		else if(date('m')<$row_ss['courses_end_m'])
			$enddate = true;
	}
				
	return $enddate;
}

function setDurationTypeToHour($id)
{
	$query_ss = "SELECT durationtype_calchour FROM www.duration_type WHERE durationtype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['durationtype_calchour'];
}

function getDurationToHour($dur, $durtype)
{
	return $dur * setDurationTypeToHour($durtype);
}

function viewCountDay($coursesid, $userid)
{
	if(checkReportNeed($coursesid, $userid)) //courses need report
	{
		if(checkReportSubmit($userid, $coursesid))
		{ 
			if(checkReportApproval($userid, $coursesid)!=0)
			{
				if(checkAttendence($userid, $coursesid) && !checkCoursesNeedAttendence($coursesid)) // semakkan kehadiran
				{
					$v = getCoursesDuration($coursesid, $userid) . " " . getDurationType(getDurationTypeByCoursesID($coursesid, $userid)); 
				} else if(!checkCoursesNeedAttendence($coursesid)) 
				{
					$v = getCoursesDuration($coursesid, $userid) . " " . getDurationType(getDurationTypeByCoursesID($coursesid, $userid)); 
				} else
					$v = "***";
			} else
				$v = "**";
		} else { 
			$v = "**"; 
		};
	} else if(getUserAsByUserID($userid, $coursesid)==1) { // pembentang
			$v = getCoursesDuration($coursesid, $userid) . " " . getDurationType(getDurationTypeByCoursesID($coursesid, $userid)); 
	} else { // courses tidak memerlukan report
		if(checkAttendence($userid, $coursesid) && checkCoursesNeedAttendence($coursesid)) // semakkan kehadiran
		{
			$v = getCoursesDuration($coursesid, $userid) . " " . getDurationType(getDurationTypeByCoursesID($coursesid, $userid)); 
		} else if(!checkCoursesNeedAttendence($coursesid)) 
		{
			$v = getCoursesDuration($coursesid, $userid) . " " . getDurationType(getDurationTypeByCoursesID($coursesid, $userid)); 
		} else {
			$v = "***";
		};
	}
		
	return $v;
}

function checkTotalCoursesByStafID($stafid, $year)
{
	$query_ss = "SELECT user_courses.*, courses.durationtype_id, courses_start_y, courses_time, courses_location, courses_status FROM user_courses LEFT JOIN courses ON courses.courses_id = user_courses.courses_id WHERE courses.courses_status = '1' AND user_courses.user_stafid = '" . $stafid . "' AND courses.courses_start_y = '" . $year . "' AND user_courses.usercourses_status = 1 ORDER BY courses_start_y DESC, courses_start_m DESC, courses_start_d DESC, courses_end_y DESC, courses_end_m DESC, courses_end_d DESC, courses.courses_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	return $total;
}

function countCoursesHour($stafid, $year)
{
	$hour = 0;
	$cd = 0;
	$ch = 0;
	$view = array();
	
	$query_ss = "SELECT user_courses.*, courses.courses_start_y FROM www.user_courses LEFT JOIN courses ON courses.courses_id = user_courses.courses_id WHERE user_courses.user_stafid = '" . htmlspecialchars($stafid, ENT_QUOTES) . "' AND courses.courses_start_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' AND usercourses_status = '1' AND courses.courses_status = '1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	do {
		if(checkReportNeed($row_ss['courses_id'], $row_ss['user_stafid'])){ // semakkan kursus yang memerlukan laporan
			if(checkReportSubmit($row_ss['user_stafid'], $row_ss['courses_id'])){ // semakkan sama ada laporan telah dihantar
				if(checkReportApproval($row_ss['user_stafid'], $row_ss['courses_id'])!=0) // semakkan laporan telah diluluskan
					if(checkAttendence($row_ss['user_stafid'], $row_ss['courses_id']) && checkCoursesNeedAttendence($row_ss['courses_id'])) // semakkan kehadiran
					{
						if(getUserAsByUserID($row_ss['user_stafid'], $row_ss['courses_id'])==1)
							$hour += (setDurationTypeToHour(2) * 1); // pembentang dapat 1 Hari
						else
							$hour += (setDurationTypeToHour(getDurationTypeByCoursesID($row_ss['courses_id'],$row_ss['user_stafid'])) * getCoursesDuration($row_ss['courses_id']));
					} else if(!checkCoursesNeedAttendence($row_ss['courses_id'])) {
						if(getUserAsByUserID($row_ss['user_stafid'], $row_ss['courses_id'])==1)
							$hour += (setDurationTypeToHour(2) * 1); // pembentang dapat 1 Hari
						else
							$hour += (setDurationTypeToHour(getDurationTypeByCoursesID($row_ss['courses_id'],$row_ss['user_stafid'])) * getCoursesDuration($row_ss['courses_id']));
					}
			}
		} else if(checkAttendence($row_ss['user_stafid'], $row_ss['courses_id']) && checkCoursesNeedAttendence($row_ss['courses_id'])){ // semak kehadiran
			if(getUserAsByUserID($row_ss['user_stafid'], $row_ss['courses_id'])==1)
				$hour += (setDurationTypeToHour(2) * 1); // pembentang dapat 1 Hari
			else
				$hour += (setDurationTypeToHour(getDurationTypeByCoursesID($row_ss['courses_id'],$row_ss['user_stafid'])) * getCoursesDuration($row_ss['courses_id']));
		} else if(!checkCoursesNeedAttendence($row_ss['courses_id'])) {
			if(getUserAsByUserID($row_ss['user_stafid'], $row_ss['courses_id'])==1)
				$hour += (setDurationTypeToHour(2) * 1); // pembentang dapat 1 Hari
			else
				$hour += (setDurationTypeToHour(getDurationTypeByCoursesID($row_ss['courses_id'],$row_ss['user_stafid'])) * getCoursesDuration($row_ss['courses_id']));
		}
	} while ($row_ss = mysql_fetch_assoc($user_ss));
	
	$cd = intval($hour/6); // kiraan 1 Hari = 6 jam
	$ch = $hour%6;
	
	$view[0] = $cd; // Hari
	$view[1] = $ch; // Jam
		
	return $view;
}


function countTotalCoursesHour($stafid, $year)
{
	$hour = 0;
	$cd = 0;
	$ch = 0;
	$view = array();
	
	$query_ss = "SELECT user_courses.*, courses.courses_start_y FROM www.user_courses LEFT JOIN courses ON courses.courses_id = user_courses.courses_id WHERE user_courses.user_stafid = '" . htmlspecialchars($stafid, ENT_QUOTES) . "' AND courses.courses_start_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' AND usercourses_status = '1' AND courses.courses_status = '1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	do {
					if(checkAttendence($row_ss['user_stafid'], $row_ss['courses_id']) && checkCoursesNeedAttendence($row_ss['courses_id'])) // semakkan kehadiran
					{
						if(getUserAsByUserID($row_ss['user_stafid'], $row_ss['courses_id'])==1)
							$hour += (setDurationTypeToHour(2) * 1); // pembentang dapat 1 Hari
						else
							$hour += (setDurationTypeToHour(getDurationTypeByCoursesID($row_ss['courses_id'],$row_ss['user_stafid'])) * getCoursesDuration($row_ss['courses_id']));
					} else if(!checkCoursesNeedAttendence($row_ss['courses_id'])) {
						if(getUserAsByUserID($row_ss['user_stafid'], $row_ss['courses_id'])==1)
							$hour += (setDurationTypeToHour(2) * 1); // pembentang dapat 1 Hari
						else
							$hour += (setDurationTypeToHour(getDurationTypeByCoursesID($row_ss['courses_id'],$row_ss['user_stafid'])) * getCoursesDuration($row_ss['courses_id']));
					}
			
		else if(checkAttendence($row_ss['user_stafid'], $row_ss['courses_id']) && checkCoursesNeedAttendence($row_ss['courses_id'])){ // semak kehadiran
			if(getUserAsByUserID($row_ss['user_stafid'], $row_ss['courses_id'])==1)
				$hour += (setDurationTypeToHour(2) * 1); // pembentang dapat 1 Hari
			else
				$hour += (setDurationTypeToHour(getDurationTypeByCoursesID($row_ss['courses_id'],$row_ss['user_stafid'])) * getCoursesDuration($row_ss['courses_id']));
		} else if(!checkCoursesNeedAttendence($row_ss['courses_id'])) {
			if(getUserAsByUserID($row_ss['user_stafid'], $row_ss['courses_id'])==1)
				$hour += (setDurationTypeToHour(2) * 1); // pembentang dapat 1 Hari
			else
				$hour += (setDurationTypeToHour(getDurationTypeByCoursesID($row_ss['courses_id'],$row_ss['user_stafid'])) * getCoursesDuration($row_ss['courses_id']));
		}
	} while ($row_ss = mysql_fetch_assoc($user_ss));
	
	$cd = intval($hour/6); // kiraan 1 Hari = 6 jam
	$ch = $hour%6;
	
	$view[0] = $cd; // Hari
	$view[1] = $ch; // Jam
		
	return $view;
}

function getCoursesTypeReport($id)
{
	$query_ss = "SELECT coursestype_report FROM www.courses_type WHERE coursestype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['coursestype_report'];
}

function checkReportNeed($coursesid, $user=0)
{
	if($user!=0)
	{
		$sqlr = " AND user_courses.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "'";
		$u = $user;
	}
	else
	{
		$sqlr = "";
		$u = '0';
	}
		
	$query_ss = "SELECT courses.courses_id, courses.courses_report, user_courses.usercourses_as FROM www.courses LEFT JOIN user_courses ON user_courses.courses_id = courses.courses_id WHERE courses.courses_status = '1' AND courses.courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "' " . $sqlr;	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if(getUserAsByUserID($u, $coursesid) == 1)
		return false;
	else if($row_ss['courses_report']=='1')
		return true;
	else
		return false;		
}

function checkReportSubmit($userid, $coursesid)
{
	$query_ss = "SELECT user_coursesreport.usercoursesreport_id FROM www.user_coursesreport LEFT JOIN user_courses ON user_courses.usercourses_id = user_coursesreport.usercourses_id WHERE user_courses.courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "' AND user_courses.user_stafid='" . htmlspecialchars($userid , ENT_QUOTES). "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if(getUserAsByUserID($userid, $coursesid)==1)
		return true;
	else if($total>0)
		return true;
	else
		return false;
}

function checkReportApproval($userid, $coursesid)
{
	$query_ss = "SELECT user_coursesreport.hr_approval, user_coursesreport.usercoursesreport_id, user_courses.usercourses_id, user_courses.user_stafid, user_courses.usercourses_as FROM www.user_coursesreport LEFT JOIN www.user_courses ON user_courses.usercourses_id = user_coursesreport.usercourses_id WHERE user_courses.courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "' AND user_courses.user_stafid='" . htmlspecialchars($userid, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if(getUserAsByUserID($userid, $coursesid)==1)
		$app = '1';
	else
		$app = $row_ss['hr_approval'];
		
	return $app;
}

function getCoursesReportUserID($coursesreportid)
{
	$query_ss = "SELECT usercoursesreport_by FROM www.user_coursesreport WHERE usercoursesreport_id = '" . htmlspecialchars($coursesreportid, ENT_QUOTES) . "' AND usercoursesreport_status='1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['usercoursesreport_by'];
}

function getUserCoursesReportIDByUserCoursesID($userid, $usercoursesid)
{
	$query_ss = "SELECT user_coursesreport.usercoursesreport_id FROM www.user_coursesreport WHERE usercourses_id = '" . htmlspecialchars($usercoursesid, ENT_QUOTES) . "' AND usercoursesreport_by='" . htmlspecialchars($userid, ENT_QUOTES) . "' AND usercoursesreport_status='1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['usercoursesreport_id'];
}

function getUserCoursesReportIDByCoursesID($userid, $coursesid)
{
	$query_ss = "SELECT user_coursesreport.usercoursesreport_id, user_courses.usercourses_id, user_courses.user_stafid FROM www.user_coursesreport LEFT JOIN user_courses ON user_courses.usercourses_id = user_coursesreport.usercourses_id WHERE user_courses.courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "' AND user_courses.user_stafid='" . htmlspecialchars($userid, ENT_QUOTES) . "' AND usercoursesreport_status='1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['usercoursesreport_id'];
}

function getCoursesIDbyReportID($reportid)
{
	$query_ss = "SELECT user_coursesreport.usercoursesreport_id, user_courses.usercourses_id, user_courses.courses_id FROM www.user_coursesreport LEFT JOIN user_courses ON user_courses.usercourses_id = user_coursesreport.usercourses_id WHERE user_coursesreport.usercoursesreport_id = '" . htmlspecialchars($reportid, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['courses_id'];
}

function getTotalReport($id)
{
	if(checkReportNeed($id, 0))
	{
		$query_ss = "SELECT user_coursesreport.usercoursesreport_id, user_courses.usercourses_id, user_courses.courses_id FROM www.user_coursesreport LEFT JOIN user_courses ON user_courses.usercourses_id = user_coursesreport.usercourses_id WHERE user_courses.courses_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
		$user_ss = mysql_query($query_ss);
		$row_ss = mysql_fetch_assoc($user_ss);
		
		$total = mysql_num_rows($user_ss);
	} else {
		$total = 0;	
	}
	
	return $total;
}

 //Kiraan jam yang masih tiada laporan
function countCoursesHourUnsubmitReport($stafid, $year)
{
	$hour = 0;
	$cd = 0;
	$ch = 0;
	$view = array();

	$query_ss = "SELECT user_courses.*, courses.courses_start_y FROM www.user_courses LEFT JOIN courses ON courses.courses_id = user_courses.courses_id WHERE user_courses.user_stafid = '" . htmlspecialchars($stafid, ENT_QUOTES) . "' AND courses.courses_start_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' AND usercourses_status = '1' AND courses.courses_status = '1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	do {
		if(checkReportNeed($row_ss['courses_id'], $row_ss['user_stafid'])){ // semakkan kursus yang memerlukan laporan
			if(!checkReportApproval($row_ss['user_stafid'], $row_ss['courses_id'])!=0){ // semakkan sama ada laporan telah dihantar
				if(checkAttendence($row_ss['user_stafid'], $row_ss['courses_id']) && checkCoursesNeedAttendence($row_ss['courses_id'])) // semakkan kehadiran
				{
					if(getUserAsByUserID($row_ss['user_stafid'], $row_ss['courses_id'])==1)
						$hour += (setDurationTypeToHour(2) * 1); // pembentang dapat 1 Hari
					else
						$hour += (setDurationTypeToHour(getDurationTypeByCoursesID($row_ss['courses_id'],$row_ss['user_stafid'])) * getCoursesDuration($row_ss['courses_id']));
				} else if(!checkCoursesNeedAttendence($row_ss['courses_id'])) 
				{
					if(getUserAsByUserID($row_ss['user_stafid'], $row_ss['courses_id'])==1)
						$hour += (setDurationTypeToHour(2) * 1); // pembentang dapat 1 Hari
					else
						$hour += (setDurationTypeToHour(getDurationTypeByCoursesID($row_ss['courses_id'],$row_ss['user_stafid'])) * getCoursesDuration($row_ss['courses_id']));
				}
			}
		}
	} while ($row_ss = mysql_fetch_assoc($user_ss));

	$cd = intval($hour/6); // kiraan 1 Hari = 6 jam
	$ch = $hour%6;

	$view[0] = $cd; // Hari
	$view[1] = $ch; // Jam

	return $view;
}

function checkCoursesNeedAttendence($id)
{
	$query_ss = "SELECT courses_att FROM www.courses WHERE courses_status = '1' AND courses_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['courses_att']==1)
		return true;
	else
		return false;
}

function checkAttendence($user, $id=0)
{
	if(checkCoursesNeedAttendence($id))
	{
		if($id!=0)
			$sqla = " AND user_courses.courses_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
		else
			$sqla = "";
			
		$query_ss = "SELECT user_courses.usercourses_approvalby, user_courses.usercourses_approvaldate FROM www.user_courses WHERE user_courses.usercourses_status = '1' AND user_courses.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' " . $sqla;	
		$user_ss = mysql_query($query_ss);
		$row_ss = mysql_fetch_assoc($user_ss);
		
		if(getUserAsByUserID($user, $id)==1)
			return true;
		else if($row_ss['usercourses_approvalby']!=NULL)
			return true;
		else
			return false;
	} else if(getUserAsByUserID($user, $id)==1) {
		return true;
	} else{
		return false;
	}
}

function getTotalAttendence($id)
{
	$query_ss = "SELECT user_courses.usercourses_approvalby, user_courses.user_stafid, user_courses.usercourses_id FROM www.user_courses WHERE user_courses.usercourses_status = '1' AND user_courses.courses_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
		
	$total = mysql_num_rows($user_ss);
	
	if(checkCoursesNeedAttendence($id)){
		
		$att = 0;
		$total = 0;
		
		do {
			if(getUserAsByUserID($row_ss['user_stafid'], $id)==1)
				$att += 1;
			else if($row_ss['usercourses_approvalby']!=NULL)
				$att += 1;
		} while($row_ss = mysql_fetch_assoc($user_ss));
		
		$totalAtt['0'] = $att;
		$totalAtt['1'] = mysql_num_rows($user_ss);
	} else {
		$totalAtt['0']= $total;
		$totalAtt['1']= $total;
	}
	return $totalAtt;
}

function iconAttendance($user, $id=0)
{
	if(getUserAsByUserID($user, $id)==1)
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" alt=\"Approval\" align=\"absbottom\" />";
	else if(checkAttendence($user, $id) && checkCoursesNeedAttendence($id)) 
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" alt=\"Approval\" align=\"absbottom\" />"; 
	else if(!checkCoursesNeedAttendence($id))
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" alt=\"Approval\" align=\"absbottom\" />";
	else
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_error.png\" alt=\"Pending\" align=\"absbottom\" />";
}

function getDirIDAttendanceByCoursesID($coursesid)
{
	$query_ss = "SELECT user_courses.user_stafid FROM www.user_courses WHERE user_courses.courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "' AND user_courses.usercourses_status = '1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$dir = array();
	
	do {
		$dir[] = getUserUnitIDByUserID($row_ss['user_stafid']);
	}while($row_ss = mysql_fetch_assoc($user_ss));
	
	return array_unique($dir);
}

function totalAttendanceByDirID($coursesid, $dirid)
{
	$query_ss = "SELECT user_courses.user_stafid FROM www.user_courses LEFT JOIN www.user_unit ON user_unit.user_stafid = user_courses.user_stafid WHERE user_unit.userunit_status = '1' AND user_unit.dir_id = '" . $dirid . "' AND user_courses.courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "' AND user_courses.usercourses_status = '1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	return $total;
}

function getStafIDByDirID($coursesid, $dirid)
{
	$query_ss = "SELECT user_courses.user_stafid FROM www.user_courses LEFT JOIN www.user ON user.user_stafid = user_courses.user_stafid LEFT JOIN www.user_unit ON user_unit.user_stafid = user_courses.user_stafid WHERE user_unit.userunit_status = '1' AND user_unit.dir_id = '" . $dirid . "' AND user_courses.courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "' AND user_courses.usercourses_status = '1' ORDER BY user.user_firstname ASC, user.user_lastname ASC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$stafid = array();
	
	do {
		$stafid[] = $row_ss['user_stafid'];
	} while($row_ss = mysql_fetch_assoc($user_ss));
	
	return $stafid;
}

//tak hadir perhimpunan
function getDirIDNotAttendByCoursesID($coursesid)
{
	$query_ss = "SELECT login.user_stafid FROM www.login LEFT JOIN user_courses ON user_courses.user_stafid = login.user_stafid WHERE NOT EXISTS (SELECT user_courses.user_stafid FROM user_courses WHERE login.user_stafid=user_courses.user_stafid AND user_courses.courses_id='" . htmlspecialchars($coursesid,ENT_QUOTES) . "') AND user_courses.usercourses_status = '1' AND login.login_status='1' GROUP BY login.user_stafid";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$dir = array();

	do {
		$dir[] = getUserUnitIDByUserID($row_ss['user_stafid']);
	}while($row_ss = mysql_fetch_assoc($user_ss));

	return array_unique($dir);
}

function totalNotAttendByDirID($coursesid, $dirid)
{
	$query_ss = "SELECT user.user_stafid FROM www.user LEFT JOIN www.login ON login.user_stafid = user.user_stafid LEFT JOIN www.user_unit ON user_unit.user_stafid = user.user_stafid LEFT JOIN www.user_courses ON user_courses.user_stafid = user.user_stafid WHERE NOT EXISTS (SELECT user_courses.user_stafid FROM user_courses WHERE user.user_stafid=user_courses.user_stafid AND user_courses.courses_id ='".htmlspecialchars($coursesid,ENT_QUOTES)."') AND user_unit.dir_id =  '".htmlspecialchars($dirid,ENT_QUOTES)."' AND login.login_status =  '1'
GROUP BY user.user_stafid";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total = mysql_num_rows($user_ss);
	
	return $total;
}

function getStafIDNotAttendByDirID($coursesid, $dirid)
{
	$query_ss = "SELECT user.user_stafid FROM www.user LEFT JOIN www.login ON login.user_stafid = user.user_stafid LEFT JOIN www.user_unit ON user_unit.user_stafid = user.user_stafid LEFT JOIN www.user_courses ON user_courses.user_stafid = user.user_stafid WHERE NOT EXISTS (SELECT user_courses.user_stafid FROM user_courses WHERE user.user_stafid=user_courses.user_stafid AND user_courses.courses_id ='".htmlspecialchars($coursesid,ENT_QUOTES)."') AND user_unit.dir_id =  '".htmlspecialchars($dirid,ENT_QUOTES)."' AND login.login_status =  '1' GROUP BY user.user_stafid ORDER BY user.user_firstname ASC, user.user_lastname ASC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$stafid = array();

	do {
		$stafid[] = $row_ss['user_stafid'];
	} while($row_ss = mysql_fetch_assoc($user_ss));

	return $stafid;
}

function getLeaveNameByStaffID($id,$d,$m,$y)
{
	  $query_ss = "SELECT leavecategory_name FROM www.leave_category LEFT JOIN user_leavedate ON leave_category.leavecategory_id=user_leavedate.leavecategory_id WHERE user_leavedate.user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND user_leavedate.userleavedate_date_d= '".htmlspecialchars($d,ENT_QUOTES). "' AND user_leavedate.userleavedate_date_m= '".htmlspecialchars($m,ENT_QUOTES). "' AND user_leavedate.userleavedate_date_y= '".htmlspecialchars($y,ENT_QUOTES). "'" ;	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss); 
	  $view = $row_ss['leavecategory_name'];

	  return $view;
}

function getStatusStaffByID($id,$d,$m,$y)
{

	if(!getLeaveNameByStaffID($id,$d,$m,$y))
	{
		$query_ss= "SELECT reason_name FROM www.reason LEFT JOIN leave_office ON leave_office.reason_id=reason.reason_id WHERE leave_office.user_stafid= '".htmlspecialchars($id,ENT_QUOTES)."' AND leave_office.leaveoffice_on_d='".htmlspecialchars($d, ENT_QUOTES)."' AND leave_office.leaveoffice_on_m= '".htmlspecialchars($m, ENT_QUOTES)."' AND leave_office.leaveoffice_on_y= '".htmlspecialchars($y, ENT_QUOTES)."'";
		$user_ss = mysql_query($query_ss);
		$row_ss = mysql_fetch_assoc($user_ss);
		
		$bs= $row_ss['reason_name'];
		
	} else {
		$bs = getLeaveNameByStaffID($id,$d,$m,$y);
	};
	
	return $bs;
}

function checkCoursesTypeID($coursesid) //jenis perhimpunan
{
	$query_ss = "SELECT coursestype_id FROM www.courses WHERE courses_status = '1' AND courses_id = '" . htmlspecialchars($coursesid, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($row_ss['coursestype_id']==1)
		return true;
	else
		return false;
}
?>
<?php
//Menu
function getMenuName($id=0)
{
	if($id != 0)
	{
		$query_ss = "SELECT menu.menu_name FROM www.menu WHERE menu.menu_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
		$user_ss = mysql_query($query_ss);
		$row_ss = mysql_fetch_assoc($user_ss);
	
		$menuname = $row_ss['menu_name'];
	} else {
		$menuname = "-";
	}
	
	return $menuname;
}

function getSubMenuName($id=0)
{
	if($id != 0)
	{
		$query_ss = "SELECT submenu.submenu_name FROM www.submenu WHERE submenu.submenu_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
		$user_ss = mysql_query($query_ss);
		$row_ss = mysql_fetch_assoc($user_ss);
	
		$menuname = $row_ss['submenu_name'];
	} else {
		$menuname = "-";
	}
	
	return $menuname;
}

function getDirIDByMenuID($menuid)
{
	if($menuid!=0)
	{
		$query_ss = "SELECT menu.dir_id FROM www.menu WHERE menu.menu_id = '" . htmlspecialchars($menuid, ENT_QUOTES) . "'";	
		$user_ss = mysql_query($query_ss);
		$row_ss = mysql_fetch_assoc($user_ss);
		
		$dirid = $row_ss['dir_id'];
		
	} else {
		$dirid = 0;
	};
	
	return $dirid;
}
?>
<?php
//leave
function getLeaveType($id)
{
	  $query_ss = "SELECT leavetype_name FROM www.leave_type WHERE leavetype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['leavetype_name'];
}

function getLeaveTypeByLeaveID($id)
{
	  $query_ss = "SELECT leavetype_id FROM www.user_leavedate WHERE userleavedate_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['leavetype_id'];
}

function getLeaveCategory($id)
{
	if($id!=0)
	{
	  $query_ss = "SELECT leavecategory_name FROM www.leave_category WHERE leavecategory_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss); 
	  $view = $row_ss['leavecategory_name'];
	} else
		$view = "Tidak dinyatakan ";
	  
	  return $view;
}

function getLeaveCategoryByLeaveID($id)
{
	  $query_ss = "SELECT leavecategory_id FROM www.user_leavedate WHERE userleavedate_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['leavecategory_id'];
}

function getTotalDayInLeaveCategory($lcid, $leavetypeid=0)
{
	if($leavetypeid!=0)
		$td = " AND leavetype_id = '" . htmlspecialchars($leavetypeid, ENT_QUOTES) . "'";
	else
		$td = "";
		
	  $query_ss = "SELECT leave_category.leavecategory_totalday FROM www.leave_category WHERE leave_category.leavecategory_id = '" . htmlspecialchars($lcid, ENT_QUOTES) . "'" . htmlspecialchars($td, ENT_QUOTES);	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	if($row_ss['leavecategory_totalday']== NULL)
	  	$countday = 0;
	else
		$countday = $row_ss['leavecategory_totalday'];
		
	  return $countday;
}

function getALID($user, $day, $month, $year, $totalday=0) // ID Cuti Rehat / Tahunan
{
	if($totalday!=0)
		$wsql = " AND userleave_annual = '" . htmlspecialchars($totalday, ENT_QUOTES) . "'"; 
		
	  $query_ss = "SELECT userleave_id FROM www.user_leave WHERE userleave_day = '" . htmlspecialchars($day, ENT_QUOTES) . "' AND userleave_month = '" . htmlspecialchars($month, ENT_QUOTES) . "' AND userleave_year = '" . htmlspecialchars($year, ENT_QUOTES) . "' " . $wsql . " ORDER BY userleave_year DESC, userleave_month DESC, userleave_day DESC, userleave_id DESC";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['userleave_id'];
}

function checkDatePast($year, $month, $day) // semakkan tarikh yang belum lepas
{
	if($year==date('Y') && $month>date('m'))
		return true;
	else if($year==date('Y') && $month==date('m') && $day>=date('d'))
		return true;
	else
		return false;
}

function getLeave($user, $year=0) //Jumlah cuti yang diperuntukkan kepada user dalam tahun tersebut
{
	$leave = 0;
	
	if($year==0)
		$year = date('Y');
		
	$query_lb1 = "SELECT userleave_id, userleave_day, userleave_month, userleave_year, userleave_annual, leavetype_id FROM www.user_leave WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userleave_year = '" . htmlspecialchars($year, ENT_QUOTES) . "' AND leavetype_id = '1' AND userleave_status = '1' ORDER BY userleave_id DESC";	
	$user_lb1 = mysql_query($query_lb1);
	$row_lb1 = mysql_fetch_assoc($user_lb1);
	
	do {
		if($row_lb1['leavetype_id']==3) // Cuti Ganti
		{
			if(checkDatePast(getLeaveEndDate($row_lb1['userleave_id'], $row_lb1['leavetype_id'], 3), getLeaveEndDate($row_lb1['userleave_id'], $row_lb1['leavetype_id'], 2), getLeaveEndDate($row_lb1['userleave_id'], $row_lb1['leavetype_id'], 1)))
			{ 
					$leave += $row_lb1['userleave_annual']; 
			}
		} else {
			$leave += $row_lb1['userleave_annual']; 
		}
	} while ($row_lb1 = mysql_fetch_assoc($user_lb1));
	
	return $leave;
}

function getTotalLeaveGanti($user, $year)
{
	//mendapatkan peruntukan cuti ganti bagi tahun tersebut;
	$query_lb1 = "SELECT userleave_annual FROM www.user_leave WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userleave_year = '" . htmlspecialchars($year, ENT_QUOTES) . "' AND leavetype_id ='3' AND userleave_status = '1' ORDER BY userleave_id DESC";	
	// echo $query_lb1;



	$user_lb1 = mysql_query($query_lb1);
	$row_lb1 = mysql_fetch_assoc($user_lb1);
	
	$total = 0;
	
	do {
		$total += $row_lb1['userleave_annual'];
	} while($row_lb1 = mysql_fetch_assoc($user_lb1));
	
	return $total;
}
function getTotalLeaveGantiUse($user, $year)
{
	//mendapatkan peruntukan cuti ganti bagi tahun tersebut;
	// $query_lb1 = "SELECT userleave_annual FROM www.user_leave WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userleave_year = '" . htmlspecialchars($year, ENT_QUOTES) . "' AND leavetype_id ='3' AND userleave_status = '1' ORDER BY userleave_id DESC";	


	$query_lb1 = "SELECT * FROM www.user_leavedate WHERE userleavedate_status = '1' AND user_stafid = '" . $user . "' AND leavetype_id = '3'  AND userleavedate_date_y = '" . $year . "' ORDER BY userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC";
	$user_lb1 = mysql_query($query_lb1);
	$total = mysql_num_rows($user_lb1);
	
	
	
	return $total;
}


function getTotalLeaveKhasPerubatan($user, $year)
{
	//mendapatkan peruntukan cuti khas perubatan Juru X-Ray bagi tahun tersebut;
	$query_lb1 = "SELECT userleave_annual FROM www.user_leave WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userleave_year = '" . htmlspecialchars($year, ENT_QUOTES) . "' AND leavetype_id ='9' AND userleave_status = '1' ORDER BY userleave_id DESC";	
	$user_lb1 = mysql_query($query_lb1);
	$row_lb1 = mysql_fetch_assoc($user_lb1);
	
	$total = 0;
	
	do {
		$total += $row_lb1['userleave_annual'];
	} while($row_lb1 = mysql_fetch_assoc($user_lb1));
	
	return $total;
}

function getTotalAllLeave($user, $year)
{
	$total = getLeave($user, $year)+getTotalLeaveKhasPerubatan($user, $year)+ getTotalLeaveGanti($user, $year);
	
	return $total;
}

function getStafIDByLeaveID($id) // mendapatkan staf id dari leave id
{
	  $query_ss = "SELECT user_stafid FROM www.user_leavedate WHERE userleavedate_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['user_stafid'];
}

function checkDayWeekend($day, $month, $year) // semakkan sama ada hari tersebut adalah hari minggu
{
	$ss = date("N", mktime(0, 0, 0, $month, $day, $year));
	
	if($ss <= 7) // Saturday = 6 and Sunday = 7
		$value = false; //send false jika hari bukan weekend
	else
		$value = true;
		
	return $value;
}

function checkDayWeekendByUser($user, $day, $month, $year) // semakkan sama ada hari tersebut adalah hari minggu
{
	$locID = getLocationByUserID($user);
	
	$ss = date("N", mktime(0, 0, 0, $month, $day, $year));
	
	if($ss <= 7) // Saturday = 6 and Sunday = 7
		$value = false; //send false jika hari bukan weekend
	else
		$value = true;
		
	return $value;
}

function checkDayLeave($user, $type=0, $day, $month, $year) 
{
	if($type != 0)
		$wsql = " AND leavetype_id = '" . $type . "'";
	else
		$wsql = "";
		
	$query_ss = "SELECT userleavedate_id FROM www.user_leavedate WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' " . $wsql . " AND userleavedate_date_d = '" . htmlspecialchars($day, ENT_QUOTES) . "' AND userleavedate_date_m = '" . htmlspecialchars($month, ENT_QUOTES) . "' AND userleavedate_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' AND userleavedate_app != '2' AND userleavedate_status = '1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total > 0)
		return true;
	else
		return false;
}

function getLeaveID($user, $type=0, $day, $month, $year)
{
	if($type != 0)
		$wsql = " AND leavetype_id = '" . $type . "'";
	else
		$wsql = "";
		
	  $query_ss = "SELECT userleavedate_id FROM www.user_leavedate WHERE user_leavedate.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' " . $wsql . " AND userleavedate_date_d = '" . htmlspecialchars($day, ENT_QUOTES) . "' AND userleavedate_date_m = '" . htmlspecialchars($month, ENT_QUOTES) . "' AND userleavedate_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' AND userleavedate_status = '1'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['userleavedate_id'];
}

function getLeaveTitle($user, $type=0, $day, $month, $year, $id=0)
{
	$wsql = "";
	
	if($id != 0)
		$wsql .= " AND userleavedate_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	
	if($type != 0)
		$wsql .= " AND leavetype_id = '" . htmlspecialchars($type, ENT_QUOTES) . "'";
		
	  $query_ss = "SELECT user_leavedate.userleavedate_id, userleavedate_name, userleavedate_note FROM www.user_leavedate WHERE user_leavedate.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' " . $wsql . " AND userleavedate_date_d = '" . htmlspecialchars($day, ENT_QUOTES) . "' AND userleavedate_date_m = '" . htmlspecialchars($month, ENT_QUOTES) . "' AND userleavedate_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' AND userleavedate_status = '1' ORDER BY userleavedate_id DESC";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  if($row_ss['userleavedate_name']==NULL)
	  	$view = "Dimasukkan oleh " . $GLOBALS['adname'] . " ";
	  else
		$view = $row_ss['userleavedate_name'];
		
	  return $view;
}

function getLeaveNote($user, $type=0, $day, $month, $year, $id=0)
{
	$wsql = "";
	
	if($id != 0)
		$wsql .= " AND userleavedate_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
		
	if($type != 0)
		$wsql .= " AND leavetype_id = '" . htmlspecialchars($type, ENT_QUOTES) . "'";
	else
		$wsql .= "";
		
	  $query_ss = "SELECT user_leavedate.userleavedate_id, userleavedate_name, userleavedate_note FROM www.user_leavedate WHERE user_leavedate.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' " . $wsql . " AND userleavedate_date_d = '" . htmlspecialchars($day, ENT_QUOTES) . "' AND userleavedate_date_m = '" . htmlspecialchars($month, ENT_QUOTES) . "' AND userleavedate_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' AND userleavedate_status = '1' ORDER BY userleavedate_id DESC";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	if($row_ss['userleavedate_note']!="" || $row_ss['userleavedate_note']!=NULL)
	  	return $row_ss['userleavedate_note'];
	else 
		return " ";
}

function getLeaveDate($id, $view=0)
{
	  $query_ss = "SELECT userleavedate_date_d, userleavedate_date_m, userleavedate_date_y FROM www.user_leavedate WHERE userleavedate_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  if($view == 1)
	  	return $row_ss['userleavedate_date_d'];
	  else if($view == 2)
	  	return $row_ss['userleavedate_date_m'];
	  else if($view == 3)
	  	return $row_ss['userleavedate_date_y'];
	  else
	  return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['userleavedate_date_m'], $row_ss['userleavedate_date_d'], $row_ss['userleavedate_date_y']));
}

function getLeaveNotice($id)
{
	  $query_ss = "SELECT user_leavedate.userleavedate_notice FROM www.user_leavedate WHERE user_leavedate.userleavedate_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND userleavedate_status = '1' ORDER BY userleavedate_id DESC";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['userleavedate_notice'];
}

function getLeaveEndDate($id, $leavetype=0, $view=0)
{
	  $query_ss = "SELECT userleave_day, userleave_month, userleave_year, leave_type.leavetype_id, leave_type.leavetype_expired FROM www.user_leave LEFT JOIN leave_type ON leave_type.leavetype_id = user_leave.leavetype_id WHERE userleave_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
		if($leavetype == $row_ss['leavetype_id']) // 3 - Cuti Ganti
			$expire = $row_ss['leavetype_expired'];
		else
			$expire = 0;
			
	  if(date("Y", mktime(0, 0, 0, ($row_ss['userleave_month']+$expire), $row_ss['userleave_day'], $row_ss['userleave_year']))<=date('Y'))
	  {
		  switch($view)
		  {
			  case 0:
				$viewd = date("d /m / Y (D)", mktime(0, 0, 0, ($row_ss['userleave_month']+$expire), $row_ss['userleave_day'], $row_ss['userleave_year']));
				break;
			  case 1:
				$viewd = date("d", mktime(0, 0, 0, ($row_ss['userleave_month']+$expire), $row_ss['userleave_day'], $row_ss['userleave_year']));
				break;
			case 2:
				$viewd = date("m", mktime(0, 0, 0, ($row_ss['userleave_month']+$expire), $row_ss['userleave_day'], $row_ss['userleave_year']));
				break;
			case 3:
				$viewd = date("Y", mktime(0, 0, 0, ($row_ss['userleave_month']+$expire), $row_ss['userleave_day'], $row_ss['userleave_year']));
				break;
			default:
				$viewd = date("d/m/Y", mktime(0, 0, 0, ($row_ss['userleave_month']+$expire), $row_ss['userleave_day'], $row_ss['userleave_year']));
		  };
		  
	  } else {
		  
		  switch($view)
		  {
			  case 0:
				$viewd = "31 / 12 / " . $row_ss['userleave_year'] . date(' (D)', mktime(0, 0, 0, 12, 31, $row_ss['userleave_year']));
				break;
			  case 1:
				$viewd = "31";
				break;
			case 2:
				$viewd = "12";
				break;
			case 3:
				$viewd = $row_ss['userleave_year'];
				break;
			default:
				$viewd = "31 / 12 / " . $row_ss['userleave_year'] . date(' (D)', mktime(0, 0, 0, 12, 31, $row_ss['userleave_year']));
		  };
		  
	  }
	  
	  return $viewd;
}

function checkLeaveAppByUserID($user, $id=0, $type=0, $day=0, $month=0, $year=0) // semakkan kelulusan cuti
{
	$wsql = "";
	if($id!=0)
	{
		$wsql .= " AND userleavedate_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	}
	
	if($type!=0)
	{
		$wsql .= " AND leavetype_id='" . htmlspecialchars($type, ENT_QUOTES) . "'";
	}
	
	if($day!=0)
	{
		$wsql .= " AND userleavedate_date_d = '" . htmlspecialchars($day, ENT_QUOTES) . "'";
	}
	
	if($month!=0)
	{
		$wsql .= " AND userleavedate_date_m = '" . htmlspecialchars($month, ENT_QUOTES) . "'";
	}
	
	if($year!=0)
	{
		$wsql .= " AND userleavedate_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "'";
	}
	
	  $query_ss = "SELECT userleavedate_app FROM www.user_leavedate WHERE userleavedate_status = '1' " . $wsql . " ORDER BY userleavedate_id DESC";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['userleavedate_app'];
}

function checkLeaveApp($id) // semakkan kelulusan cuti
{
	  $query_ss = "SELECT userleavedate_app FROM www.user_leavedate WHERE userleavedate_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  if($row_ss['userleavedate_app']==1) // 1 - diluluskan, 0 - masih dalam proses kelulusan / tangguh, 2- tidak diluluskan
	  	return true;
	  else
		return false;
}

function getLeaveAppBy($id) // semakkan kelulusan cuti oleh
{
	  $query_ss = "SELECT userleavedate_appby FROM www.user_leavedate WHERE userleavedate_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['userleavedate_appby'];
}

function getLeaveAppDate($id) // semakkan tarikh kelulusan cuti 
{
	  $query_ss = "SELECT userleavedate_appdate FROM www.user_leavedate WHERE userleavedate_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['userleavedate_appdate'];
}

function calAllLeave($user, $year=0)
{
		if($year==0)
			$year = date('Y');
			
	  $query_ss = "SELECT userleavedate_id FROM www.user_leavedate WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userleavedate_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' AND leavetype_id = '1' AND userleavedate_status = '1' AND userleavedate_app < '2'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	
	  $total = mysql_num_rows($user_ss);
	  
	  return $total;
}

function calGantiLeave($user, $year=0)
{
		if($year==0)
			$year = date('Y');
			
	  $query_ss = "SELECT userleavedate_id FROM www.user_leavedate WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userleavedate_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' AND leavetype_id = '3' AND userleavedate_status = '1' AND userleavedate_app < '2'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	
	  $total = mysql_num_rows($user_ss);
	  
	  return $total;
}

function countLeaveTypeByStafID($user, $leavetype=1, $month=0, $year=0)
{
	$wsql = "";
	
	if($year==0)
		$year = date('Y');
			
	if($month!=0)
		$wsql .= " AND userleavedate_date_m = '" . htmlspecialchars($month, ENT_QUOTES) . "'";
			
	$query_ss = "SELECT userleavedate_id FROM www.user_leavedate WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userleavedate_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' AND leavetype_id = '" . htmlspecialchars($leavetype, ENT_QUOTES) . "' " . $wsql . " AND userleavedate_status = '1' AND userleavedate_app < '2'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	  
	return $total;
}

function countLeaveCategoryByStafID($user, $leavecategory=1, $month=0, $year=0)
{
	$wsql = "";
	
	if($year==0)
		$year = date('Y');
			
	if($month!=0)
		$wsql .= " AND userleavedate_date_m = '" . htmlspecialchars($month, ENT_QUOTES) . "'";
			
	$query_ss = "SELECT userleavedate_id FROM www.user_leavedate WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userleavedate_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' AND leavecategory_id = '" . htmlspecialchars($leavecategory, ENT_QUOTES) . "' " . $wsql . " AND userleavedate_status = '1' AND userleavedate_app < '2'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	  
	return $total;
}

function getAllLeaveByDirID($dir, $d, $m, $y)
{
	if($dir!=0)
		$wsql = " AND user_unit.dir_id='" . $dir . "'";
	else
		$wsql = "";
		
	  $query_ss = "SELECT user_leavedate.* FROM www.user_leavedate LEFT JOIN (SELECT * FROM www.user_job2 WHERE user_job2.userjob2_status = '1' ORDER BY user_job2.userjob2_id DESC) AS user_job2 ON user_job2.user_stafid = user_leavedate.user_stafid LEFT JOIN www.user_unit ON user_unit.user_stafid = user_leavedate.user_stafid LEFT JOIN www.user_scheme ON user_scheme.user_stafid = user_leavedate.user_stafid WHERE userleavedate_status = '1' AND userleavedate_app != '2' AND userleavedate_date_d = '" . htmlspecialchars($d, ENT_QUOTES) . "' AND userleavedate_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "' AND userleavedate_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND user_unit.userunit_status = '1' " . $wsql . " GROUP BY user_leavedate.user_stafid ORDER BY user_job2.jobss_id DESC, user_scheme.userscheme_gred DESC, userleavedate_date_y DESC, userleavedate_date_m DESC, userleavedate_date_d DESC";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	
	  $total = mysql_num_rows($user_ss);
	  
	  return $total;
}

//status kehadiran kakitangan bawah bahagian cawangan/pusat/unit
function iconApplyByLeaveStatus($id)
{
	if(getHeadApprovalByLeaveOfficeID($id)==0)
	echo " ";
	if(getHeadApprovalByLeaveOfficeID($id)==1)
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" alt=\"Approval\" align=\"absbottom\" />";
	if(getHeadApprovalByLeaveOfficeID($id)==2)	
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_error.png\" alt=\"Pending\" border=\"0\" align=\"absbottom\" />";		
}

function countPLC2year($user, $year=0)
{
	if(getDesignationType($user)){
		if($year==0)
			$year = date('Y');
			
		$firstyear = $year-1;
		$secondyear = $year-2;
			
	  //$query_ss = "SELECT SUM(usplc_total) AS total FROM www.user_plc WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND (usplc_date_y = '" . htmlspecialchars($firstyear, ENT_QUOTES) . "' OR usplc_date_y = '" . htmlspecialchars($secondyear, ENT_QUOTES) . "')  AND usplc_status = '1' GROUP BY user_stafid";	
	  $query_ss = "SELECT SUM(usplc_total) AS total FROM www.user_plc WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND usplc_date_y = '" . htmlspecialchars($firstyear, ENT_QUOTES) . "' AND usplc_status = '1' GROUP BY user_stafid";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  $total = $row_ss['total']; 
	  
	} else
		$total = 0;
	  
	  return $total;
}

function countPLC($user, $year=0)
{
	$total = 0;
	
	if(getDesignationType($user)){
		if($year==0)
			$year = date('Y');
			
	  $query_ss = "SELECT SUM(usplc_total) AS total FROM www.user_plc WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND usplc_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "'  AND usplc_status = '1' GROUP BY user_stafid";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  $total = $row_ss['total']; 
	} else {
		$total = 0;
	}
	
	return $total;
}

function countGCRPLCLimit($user, $year=0)
{
	if(getDesignationType($user)){
		if($year==0)
			$year = date('Y');
			
		if(getLeave($user, $year)!=0)
			$limit = getLeave($user, $year) / 2;
		else
			$limit = 0;
			
		settype($limit, "integer");
		
		if($limit < countLeaveBalance($user, $year))
			return $limit;
		else
			return countLeaveBalance($user, $year);
	} else {
		return 0;
	}
}

function getGCRLimit()
{
	return 250;
}

function countGCRByYear($user, $year=0)
{
	if(getDesignationType($user)){
		if($year==0)
			$year = date('Y');
			
	  $query_ss = "SELECT SUM(uspgcr_total) AS total FROM www.user_gcr WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND uspgcr_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' AND uspgcr_status = '1' GROUP BY user_stafid";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  $total = $row_ss['total'];
	} else 
		$total = 0;
	  
	  return $total;
}

function getGCRPerYearByUserID($user, $y)
{
	if(getDesignationType($user)){
	  $query_ss = "SELECT SUM(uspgcr_total) AS total FROM www.user_gcr WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND uspgcr_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND uspgcr_status = '1' GROUP BY user_stafid";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  $total = $row_ss['total'];
	  settype($total, "integer");
	  
	} else
		$total = 0;
	
	return $total;
}

function countTotalGCR($user)
{
	if(getDesignationType($user)){
	  $query_ss = "SELECT SUM(uspgcr_total) AS total FROM www.user_gcr WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND uspgcr_status = '1' GROUP BY user_stafid";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  $total = $row_ss['total'];
	  settype($total, "integer");
	  
	} else
		$total = 0;
	
	return $total;
}

function checkGCRLimit($user)
{
	if(getDesignationType($user)){
		if(countTotalGCR($user)<getGCRLimit())
			return true;
		else
			return false;
	} else
		return false;
}

function getEL($user, $year=0, $gors=1) { // peruntukan cuti sakit bagi user
	
	if(getDesignationType($user) && $gors==1)
		return getELGov($user, $year); // Staf Tetap melalui Klinik Kerajaan
	else if(getDesignationType($user) && $gors==2)
		return getELSwasta($user, $year); // Staf Tetap melalui Klinik Swasta
	else
		return 14; // Staf Kontrak
}

function getELGov($user, $year=0){
	return 90; // Staf Tetap melalui Klinik Kerajaan
}

function getELSwasta($user, $year=0){
	return 15; // Staf Tetap melalui Klinik Swasta
}

function countEL($user, $year=0, $gors=1)
{
	$wsql = "";
	
	if($year==0)
		$year = date('Y');
	
	if(getDesignationType($user) && $gors==1)
		$wsql .= " AND clinictype_id = 1";
	else if(getDesignationType($user) && $gors==2)
		$wsql .= " AND clinictype_id = 2";
		  
	$query_ss = "SELECT SUM(userleavedate_day) AS countday FROM www.user_leavedate WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userleavedate_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' AND leavetype_id = '2' AND userleavedate_status = '1' " . $wsql . " GROUP BY user_stafid";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
		
	return $row_ss['countday'];
}

function getClinicTypeName($id)
{	
	  $query_ss = "SELECT clinictype_name FROM www.clinic_type WHERE clinictype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['clinictype_name'];
}

function countELBalance($user, $year=0, $gors=0)
{
	// GOS = merujuk pada staf tetap sama ada melalui Klinik Kerajaan atau Swasta
		if($year==0)
			$year = date('Y');
			
	return getEL($user, $year, $gors) - countEL($user, $year, $gors);	
}

function getLeaveWOR($user, $year=0) // cuti tanpa rekod
{
	return 30;
}

function getLeaveWORDay($id)
{			
	  $query_ss = "SELECT user_leavedate.leavetype_id, leave_category.leavecategory_totalday, user_leavedate.userleavedate_day FROM www.user_leavedate LEFT JOIN leave_category ON leave_category.leavecategory_id = user_leavedate.leavecategory_id WHERE user_leavedate.userleavedate_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND userleavedate_status = '1' GROUP BY user_leavedate.user_stafid";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  if($row_ss['leavecategory_totalday']==0)
	  {
	 	 $newdate = $row_ss['userleavedate_day'];
	  } else {
	 	 $newdate = '1';
	  }
	  return $newdate;
}

function countLeaveWOREndDate($id)
{			
	  $query_ss = "SELECT user_leavedate.leavetype_id, leave_category.leavecategory_totalday, user_leavedate.userleavedate_date_d, user_leavedate.userleavedate_date_m, user_leavedate.userleavedate_date_y, user_leavedate.userleavedate_day FROM www.user_leavedate LEFT JOIN leave_category ON leave_category.leavecategory_id = user_leavedate.leavecategory_id WHERE user_leavedate.userleavedate_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND userleavedate_status = '1' GROUP BY user_leavedate.user_stafid";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  if($row_ss['leavecategory_totalday']==0)
	  {
	 	 $newdate = date("d / m / Y (D)", mktime(0, 0, 0, $row_ss['userleavedate_date_m'], $row_ss['userleavedate_date_d']+($row_ss['userleavedate_day']-1), $row_ss['userleavedate_date_y']));
	  } else {
	 	 $newdate = date("d / m / Y (D)", mktime(0, 0, 0, $row_ss['userleavedate_date_m'], $row_ss['userleavedate_date_d'], $row_ss['userleavedate_date_y']));
	  }
	  return $newdate;
}

function getDayLeaveWORByID($id)
{	
	  $query_ss = "SELECT user_leavedate.userleavedate_day FROM www.user_leavedate LEFT JOIN www.leave_category ON leave_category.leavecategory_id = user_leavedate.leavecategory_id WHERE user_leavedate.userleavedate_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND user_leavedate.leavetype_id = '4'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['user_leavedate.userleavedate_day'];
}

function countLeaveWOR($user, $year=0)
{
	$totalday=0;
	
		if($year==0)
			$year = date('Y');
			
	  $query_ss = "SELECT user_leavedate.leavetype_id, leave_category.leavecategory_totalday, user_leavedate.userleavedate_day FROM www.user_leavedate LEFT JOIN www.leave_category ON leave_category.leavecategory_id = user_leavedate.leavecategory_id WHERE user_leavedate.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND user_leavedate.userleavedate_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' AND user_leavedate.leavetype_id = '4' AND user_leavedate.userleavedate_status = '1'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  do{
		  if($row_ss['leavecategory_totalday']!=0)
		  	$totalday += 1;
		  else
		  	$totalday  += $row_ss['userleavedate_day'];
	  } while($row_ss = mysql_fetch_assoc($user_ss));
	  
	return  $totalday;
}

function countLeaveWORBalance($user, $year=0)
{
		if($year==0)
			$year = date('Y');
		
	return getLeaveWOR($user, $year) - countLeaveWOR($user, $year);
}

function getDayLeaveWOSByID($id)
{	
	// Cuti tanpa gaji
	  $query_ss = "SELECT userleavedate_day FROM www.user_leavedate LEFT JOIN www.leave_category ON leave_category.leavecategory_id = user_leavedate.leavecategory_id WHERE user_leavedate.userleavedate_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND user_leavedate.leavetype_id = '6'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['userleavedate_day'];
}

function getLeaveWOS($user, $year=0)
{
		if($year==0)
			$year = date('Y');
			
	  $query_ss = "SELECT SUM(userleavedate_day) AS countday FROM www.user_leavedate WHERE leavetype_id = '6' AND userleavedate_status = '1' AND user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userleavedate_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' GROUP BY user_stafid";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['countday'];
}

function getLeaveHS($user, $year=0)
{
		if($year==0)
			$year = date('Y');
			
	  $query_ss = "SELECT SUM(userleavedate_day) AS countday FROM www.user_leavedate WHERE leavetype_id = '10' AND userleavedate_status = '1' AND user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userleavedate_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' GROUP BY user_stafid";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['countday'];
}

function getDayLeaveMTQByID($id)
{	
	// cuti melebihi kelayakkan
	  $query_ss = "SELECT leave_category.leavecategory_totalday  FROM www.user_leavedate LEFT JOIN www.leave_category ON leave_category.leavecategory_id = user_leavedate.leavecategory_id WHERE user_leavedate.userleavedate_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND user_leavedate.leavetype_id = '7'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['leavecategory_totalday'];




}

function getDayLeaveKhasByID($id)
{	
	// cuti melebihi kelayakkan
	  $query_ss = "SELECT leave_category.leavecategory_totalday  FROM www.user_leavedate LEFT JOIN www.leave_category ON leave_category.leavecategory_id = user_leavedate.leavecategory_id WHERE user_leavedate.userleavedate_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND user_leavedate.leavetype_id = '8'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['leavecategory_totalday'];




}

function getLeaveMTQ($user, $year=0)
{
		if($year==0)
			$year = date('Y');
			
	  $query_ss = "SELECT SUM(userleavedate_day) AS countday FROM www.user_leavedate WHERE leavetype_id = '7' AND userleavedate_status = '1' AND user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userleavedate_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' GROUP BY user_stafid";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['countday'];
}

function getLeaveKhas($user, $year=0)
{
		if($year==0)
			$year = date('Y');
			
	  $query_ss = "SELECT SUM(userleavedate_day) AS countday FROM www.user_leavedate WHERE leavetype_id = '8' OR leavetype_id = '15' AND userleavedate_status = '1' AND user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userleavedate_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' GROUP BY user_stafid";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['countday'];
}

function getLeaveKuarantin($user, $year=0)
{
		if($year==0)
			$year = date('Y');
			
	  $query_ss = "SELECT SUM(userleavedate_day) AS countday FROM www.user_leavedate WHERE leavetype_id = '11' AND userleavedate_status = '1' AND user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userleavedate_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' GROUP BY user_stafid";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['countday'];
}

function getLeaveBirth($user)
{
	return 300;
}

function getLeaveBirthDay($id)
{			
	  $query_ss = "SELECT leave_category.leavecategory_totalday FROM www.user_leavedate LEFT JOIN www.leave_category ON leave_category.leavecategory_id = user_leavedate.leavecategory_id WHERE user_leavedate.userleavedate_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND user_leavedate.leavetype_id = '5' AND user_leavedate.userleavedate_status = '1'";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['leavecategory_totalday'];
}

function countLeaveBirth($user)
{			
	  $query_ss = "SELECT SUM(leave_category.leavecategory_totalday) AS total FROM www.user_leavedate LEFT JOIN www.leave_category ON leave_category.leavecategory_id = user_leavedate.leavecategory_id WHERE user_leavedate.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND user_leavedate.leavetype_id = '5' AND user_leavedate.userleavedate_status = '1' GROUP BY user_stafid";	
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	  
	  return $row_ss['total'];
}

function countLeaveBirthBalance($user)
{
	return getLeaveBirth($user) - countLeaveBirth($user);
}

function countLeaveBalance($user, $year=0) // Baki cuti tahunan
{
	if($year==0)
		$year = date('Y');
			
	// Peruntukan Cuti rehat + Cuti Perubatan Khas (Juru X-Ray) + Cuti Bawa Kehadapan
	$userleave = getLeave($user, $year) + getTotalLeaveKhasPerubatan($user, $year) + countPLC2year($user, $year); 
	$allleave = calAllLeave($user, $year) + countGCRByYear($user, $year) + countPLC($user, $year); // Jumlah Cuti yg dipohon
	
	$leavebalance = $userleave - $allleave;
	
	return $leavebalance;
}

function countLeaveGantiBalance($user, $year=0) // Baki Ganti tahunan
{
	if($year==0)
		$year = date('Y');
			
	// Peruntukan Cuti Ganti
	$usergantileave = getTotalLeaveGanti($user, $year); 
	$allgantileave = calGantiLeave($user, $year); // Jumlah Cuti yg dipohon
	
	$leavegantibalance = $usergantileave - $allgantileave;
	
	return $leavegantibalance;
}





function checkHoliday($day, $month, $year, $user=0)
{
	$state = getStateIDByUserID($user);

	$query_ss = "SELECT holiday_id, holiday_state FROM www.holiday WHERE holiday_date_d = '" . htmlspecialchars($day, ENT_QUOTES) . "' AND holiday_date_m = '" . htmlspecialchars($month, ENT_QUOTES) . "' AND holiday_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' AND holiday_status = 1";
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
		
	if($row_ss['holiday_state']!=0 && $total!=0)
	{
		$liststate = preg_split("/[\s]*[,][\s]*/", $row_ss['holiday_state']);
		
		if(in_array($state, $liststate))
			return true;
		else
			return false;
	} else if($row_ss['holiday_state']==0 && $total!=0){
		return true;
	} else {
		return false;
	}
}

function checkHolidayByDate($day, $month, $year)
{
	$query_ss = "SELECT holiday_id FROM www.holiday WHERE holiday_date_d = '" . htmlspecialchars($day, ENT_QUOTES) . "' AND holiday_date_m = '" . htmlspecialchars($month, ENT_QUOTES) . "' AND holiday_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' AND holiday_status = '1'";
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total>0)
		return true;
	else
		return false;
}

function getHolidayState($holid)
{
	$query_ss = "SELECT holiday_id, holiday_state FROM www.holiday WHERE holiday_status = 1 AND holiday_id = '" . htmlspecialchars($holid, ENT_QUOTES) . "'";
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$state = "";
	
	if($row_ss['holiday_state']=='0')
	{
		$state = 'Semua Negeri';
	} else {
		$st = explode(',', $row_ss['holiday_state']);
		foreach($st AS $key => $value)
		{
			$state .= " &nbsp; &bull; &nbsp; " . getState($value);
		};
	};
	
	return $state;
}

function checkHolidayByState($holid, $state)
{

	$query_ss = "SELECT holiday_id, holiday_state FROM www.holiday WHERE holiday_status = 1 AND holiday_id = '" . htmlspecialchars($holid, ENT_QUOTES) . "'";
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
		
	if($row_ss['holiday_state']!=0 && $total!=0)
	{
		$liststate = preg_split("/[\s]*[,][\s]*/", $row_ss['holiday_state']);
		
		if(in_array($state, $liststate))
			return true;
		else
			return false;
	} else if($row_ss['holiday_state']==0 && $total!=0){
		return true;
	} else {
		return false;
	}
}

function getHolidayName($day, $month, $year)
{
	  $query_ss = "SELECT holiday_name FROM www.holiday WHERE holiday_date_d = '" . htmlspecialchars($day, ENT_QUOTES) . "' AND holiday_date_m = '" . htmlspecialchars($month, ENT_QUOTES) . "' AND holiday_date_y = '" . $year . "' AND holiday_status = 1";
	  $user_ss = mysql_query($query_ss);
	  $row_ss = mysql_fetch_assoc($user_ss);
	
		return $row_ss['holiday_name'];
}

function checkHolidayForAll($day, $month, $year)
{
	$query_ss = "SELECT holiday_state FROM www.holiday WHERE holiday_date_d = '" . htmlspecialchars($day, ENT_QUOTES) . "' AND holiday_date_m = '" . htmlspecialchars($month, ENT_QUOTES) . "' AND holiday_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' AND holiday_status = 1";
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	  
	if($total > 0 && $row_ss['holiday_state']==0)
	  	return true;
	else
		return false;
}

function checkLeaveNotice($user, $id=0, $type=1, $day=0, $month=0, $year=0)
{	
	$wsql = "";
	
	if($id!=0)
		$wsql .= " AND userleavedate_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	
	if($day!=0)
		$wsql .= " AND userleavedate_date_d = '" . htmlspecialchars($day, ENT_QUOTES) . "'";
	
	if($month!=0)
		$wsql .= " AND userleavedate_date_m = '" . htmlspecialchars($month, ENT_QUOTES) . "'";
	
	if($year!=0)
		$wsql .= " AND userleavedate_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "'";
		
	$query_ss = "SELECT userleavedate_notice FROM www.user_leavedate WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND leavetype_id = '" . htmlspecialchars($type, ENT_QUOTES) . "' AND userleavedate_status = '1' " . $wsql . " GROUP BY user_stafid";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($row_ss['userleavedate_notice']=='1')
		return true;
	else
		return false;
}

function checkNotice3Time($id)
{	
	$query_ss = "SELECT user_stafid FROM www.user_leavedate WHERE user_stafid='" . htmlspecialchars($id, ENT_QUOTES) . "' AND leavecategory_id = 9 AND userleavedate_date_y = '" . date('Y') . "' AND userleavedate_status= 1 AND userleavedate_notice = 1 AND leavetype_id = 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total>0 && ($total%3==0))
		return true;
	else
		return false;
}

function viewIconNotice($user, $id=0, $type=1, $day, $month, $year)
{
	if(checkLeaveNotice($user, $id, $type, $day, $month, $year))
	{
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_error.png\" alt=\"Lock\" border=\"0\" align=\"absbottom\" />";
	};
}

function viewIconLeave($user, $id=0, $type=1, $day, $month, $year)
{
	if(checkLeaveAppByUserID($user, $id, $type, $day, $month, $year)==0) 
	{
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/lock.png\" alt=\"Lock\" border=\"0\" align=\"absbottom\" />"; 
	} else if(checkLeaveAppByUserID($user, $id, $type, $day, $month, $year)==1) 
	{
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" alt=\"Approval\" border=\"0\" align=\"absbottom\" />"; 
	} else if(checkLeaveAppByUserID($user, $id, $type, $day, $month, $year)==2) {
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_error.png\" alt=\"Pending\" border=\"0\" align=\"absbottom\" />";
	};
}
?>
<?php
//email 
function getHeadIDByUserID($user) // mendapatkan Head ID melalui Staf ID
{	
	if(!checkJob2($user)) // staf tanpa jobs2, bukan ketua
	{
		$dirsub = getDirSubIDByUser($user);
		//if($dirsub == '60' || $dirsub =='90')
		//{
		//	return getPengarahBahagian($user);
		//}
		
		if(getKetuaUnitStafID($user)!=NULL)
		{
			return getKetuaUnitStafID($user);
		} else {
			if(getPengarahBahagian($user)!=NULL) {
				return getPengarahBahagian($user);
			} else {
				return getKPEStafID();
			};
		};
		
	} 
	else if((getJob2ID($user)=='1' || getJob2ID($user)=='8') && checkJob2($user)) // staf dgn jobs2 tapi ketua unit. 8 - Ketua Cawangan Satelit ISN. 1 - Ketua Cawangan
	{
		$dirsub = getDirSubIDByUser($user);
		
		if(getKetuaUnitByDirID($dirsub)!=NULL)
		{
			return getKetuaUnitByDirID($dirsub);
			
		} else if(getPengarahBahagian($user)==NULL)
		{
			return getKPEStafID();
			
		} else {
			return getPengarahBahagian($user);
		};
		
	} else if(getJob2ID($user)>=2 && getJob2ID($user)!=11 && getJob2ID($user)!=12 && checkJob2($user) ) // staf dgn jobs2 tapi pengarah bahagian
	{		
		return getPengarahBahagian($user);
		
	} else // staf dgn jobs2 tapi pengarah bahagian
	{		
		return getKPEStafID();
	};
}

function getKPEStafID()
{
		$query_ss2 = "SELECT user_job2.user_stafid, user_job2.jobss_id FROM www.user_job2 LEFT JOIN www.login ON login.user_stafid = user_job2.user_stafid WHERE login.login_status = '1' AND user_job2.userjob2_status = '1' AND user_job2.jobss_id = '2' ORDER BY user_job2.userjob2_id DESC, user_job2.userjob2_date_y DESC, user_job2.userjob2_date_m DESC, user_job2.userjob2_date_d DESC LIMIT 1";
		$user_ss2 = mysql_query($query_ss2);
		$row_ss2 = mysql_fetch_assoc($user_ss2);
		
		return $row_ss2['user_stafid'];
}

function getPengarahBahagian($user)
{
	$dirid = getDirIDByUser($user);
	
	$query_ss2 = "SELECT dir.* FROM dir WHERE dir.dir_id = '" . htmlspecialchars($dirid, ENT_QUOTES) . "' AND dir_status = '1' LIMIT 1";
	$user_ss2 = mysql_query($query_ss2);
	$row_ss2 = mysql_fetch_assoc($user_ss2);
	
	$userid = getUserIDByJob2ID($row_ss2['jobss_id']);
	
	if($userid == NULL)
		return getKPEStafID();
	else
		return $userid;
}

function getKetuaUnitStafID($user)
{
	$dirid = getDirIDByUser($user);
	
	$query_ss = "SELECT user_job2.user_stafid, user_job2.jobss_id FROM www.user_job2 LEFT JOIN www.login ON login.user_stafid = user_job2.user_stafid LEFT JOIN (SELECT * FROM www.user_unit WHERE userunit_status = '1') AS user_unit ON user_unit.user_stafid = user_job2.user_stafid WHERE login.login_status = '1' AND user_job2.userjob2_status = '1' AND user_unit.dir_id = '" . $dirid . "' AND user_job2.user_stafid != '" . htmlspecialchars($user, ENT_QUOTES) . "' ORDER BY user_job2.jobss_id DESC, user_job2.userjob2_date_y DESC, user_job2.userjob2_date_m DESC, user_job2.userjob2_date_d DESC, user_job2.userjob2_id DESC LIMIT 1";
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['user_stafid'];
}

function getKetuaUnitByDirID($dirid)
{
	
	$query_ss = "SELECT user_job2.user_stafid, user_job2.jobss_id FROM www.user_job2 LEFT JOIN www.login ON login.user_stafid = user_job2.user_stafid LEFT JOIN (SELECT * FROM www.user_unit WHERE userunit_status = '1') AS user_unit ON user_unit.user_stafid = user_job2.user_stafid WHERE login.login_status = '1' AND user_job2.userjob2_status = '1' AND user_unit.dir_id = '" . $dirid . "' ORDER BY user_job2.jobss_id DESC, user_job2.userjob2_date_y DESC, user_job2.userjob2_date_m DESC, user_job2.userjob2_date_d DESC, user_job2.userjob2_id DESC LIMIT 1";
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['user_stafid'];
}
?>
<?php
//note
function noteHR($code=0)
{
	$msg = "";
	
	if($code=='1')
	{
		$msg = "<span class=\"inputlabel2 padt fl\">&sup1; Sila berhubung dengan " . $GLOBALS['adname'] . " untuk kemaskini maklumat dibahagian ini.</span>";
	} else if($code=='2')
	{
		$msg = "<span class=\"inputlabel2 padt fl\">&sup1; Sila berhubung dengan " . $GLOBALS['adname'] . " untuk pindaan maklumat dibahagian ini.</span>";
	} else if($code=='3')
	{
		$msg = "<span class=\"inputlabel2 padt fl\">&sup2; Tiada pergerakkan Tanggan Gaji untuk tahun semasa (" . date('Y') . ")</span>";
	} else if($code=='4')
	{
		$msg = "<span class=\"inputlabel2 padt fl\">Subjek / Mata pelajaran yang disenaraikan adalah mengikut keperluan " . $GLOBALS['adname'] . ". Sila isi, jika berkaitan.</span>";
	}
	
	return $msg;
}

function noteFooter($code=0)
{
	$msg = "";
	
	if($code=='1')
	{
		$msg = "<span class=\"inputlabel2 padt fl\">* Maklumat perlu diisi.</span>";
	}
	
	return $msg;
}

function notePass($code=0)
{
	$msg = "";
	
	if($code=='1')
	{
		$msg = "<span class=\"inputlabel2 padt\">Kata Laluan anda mesti menggunakan kes yang betul. Cth: 'A' atau 'a' adalah dua perkara berbeza dalam Kata Laluan</span>";
	}
	
	return $msg;
}

function noteCoursesReport($code=1)
{
	$msg = "";
	
	if($code=='1')
	{
		$msg = "<span class=\"inputlabel2 padt fl\"><div>Rujukan :</div><div>* Kiraan 6 Jam kursus bersamaan 1 Hari</div><div>** Kiraan Jam Kursus hanya dibuat setelah laporan dihantar dan diluluskan. Ini hanya melibatkan kursus yang dua (2) hari atau lebih dalam kiraan Jam Kursus.</div><div>*** Kiraan Jam Kursus hanya dibuat setelah pengesahan kehadiran dibuat</div><div>&radic; memerlukan pengesahan kehadiran</div><div>&Phi; Pembentang kertas kerja perlu kemukakan maklumat berkaitan. Kiraan Jam Kursus adalah 1 Hari.</div></span>";
	}
	
	return $msg;
}

function noteError($code=0)
{
	$msg = "";
	
	if($code=='1')
	{
		$msg = "<div><img src=\"" . $GLOBALS['url_main'] . "icon/sign_error.png\" align=\"absmiddle\"> &nbsp; Anda tiada kebenaran untuk melihat maklumat ini. Sila berhubung dengan " . $GLOBALS['adname'] . " untuk maklumat lanjut</div>";
	}
	
	if($code=='0')
	{
		$msg = "<div><img src=\"" . $GLOBALS['url_main'] . "icon/sign_error.png\" align=\"absmiddle\"> &nbsp; Anda tiada kebenaran untuk melihat maklumat ini.</div>";
	}
	
	return $msg;
}

function noteEmail($code=0)
{
	$msg = "";
	
	if($code=='1' && !$GLOBALS['sendemailfunc'])
	{
		$msg = "<span class=\"inputlabel2 padt fl\"><div>Maklum balas melalui email tidak berfungsi buat masa ini, harap maklum.</div></span>";
	} else if($code=='2' && !$GLOBALS['sendemailfunc'])
	{
		$msg = "Maklum balas melalui email tidak berfungsi buat masa ini, harap maklum.";
	}
	
	return $msg;
}

function noteLeaveNotice($code=0)
{
	$msg = "";
	
	if($code=='1')
	{
		$msg = "<span class=\"inputlabel2 padt fl\"><div>&curren; Satu (1) notis akan dihantar kepada " . $GLOBALS['adname'] . " bagi 3 kali amaran terkumpul untuk tahunan semasa.</div></span>";
	}
	
	return $msg;
}

function noteMade($menu)
{
	return "<span class=\"inputlabel2 padt fl\">Modul ini diuruskan oleh " . getDirSubName(getDirIDByMenuID($menu)) . "</span>";
}
?>
<?php
//semakkan user sebelum delete
function getDelReport($id)
{
	$query_s = "SELECT user_stafid FROM user_report WHERE userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	return $row_s['user_stafid'];
}

function getDelEC($id)
{
	$query_s = "SELECT user_stafid FROM user_ec WHERE userec_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	return $row_s['user_stafid'];
}

function getDelDependents($id)
{
	$query_s = "SELECT user_stafid FROM user_dependents WHERE userdependents_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	return $row_s['user_stafid'];
}

function getDelExwork($id)
{
	$query_s = "SELECT user_stafid FROM user_exwork WHERE userexwork_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	return $row_s['user_stafid'];
}

function getDelEdu($id)
{
	$query_s = "SELECT user_stafid FROM user_edu WHERE useredu_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	return $row_s['user_stafid'];
}
?>
<?php
//editor
function getEditor($taid, $type=1)
{
	if($type = 1 || $type = NULL)
		echo "<script type=\"text/javascript\">CKEDITOR.replace('" . htmlspecialchars($taid, ENT_QUOTES) . "');
			</script>";
}

function shortText($string, $length=30)
{
	if($string!=NULL)
	{
		$st= substr(strip_tags($string), 0, $length);
		if (strlen(strip_tags($string)) > $length)
		$st .= "...";
	} else {
		$st = "";
	}
	
	return $st;
}

?>

<?php
//senarai Staf ICT yg ada akses mengikut menu dan menu2
function getUserIDSysAcc($menu, $menu2, $notinclude=0)
{
	$wsqlni = "";
	
	if($notinclude!='0')
		$wsqlni = " AND user_sysacc.user_stafid != '" . htmlspecialchars($notinclude, ENT_QUOTES) . "'";
		
	$query_entry = "SELECT user_sysacc.* FROM www.user_sysacc LEFT JOIN www.login ON login.user_stafid = user_sysacc.user_stafid LEFT JOIN www.user ON user.user_stafid = user_sysacc.user_stafid WHERE login.login_status = '1' AND user_sysacc.usersysacc_status='1' AND user_sysacc.menu_id = '" . $menu ."' AND user_sysacc.submenu_id = '" . htmlspecialchars($menu2, ENT_QUOTES) ."' " . $wsqlni . " ORDER BY user.user_firstname ASC, user.user_lastname ASC";
	$entry = mysql_query($query_entry);
	$row_entry = mysql_fetch_assoc($entry);
	
	$userid = array();
	
	do{
		$userid[] = $row_entry['user_stafid'];
	} while($row_entry = mysql_fetch_assoc($entry));
	
	return $userid; // array
}

// semak user sistem akses level
function checkUserSysAcc($userid, $menuid=0, $submenuid=0, $type)
{
	$wsql = "";
	
	if($menuid != 0)
		$wsql .= " AND menu_id = '" . htmlspecialchars($menuid, ENT_QUOTES) . "'";
	if($submenuid != 0)
		$wsql .= " AND submenu_id = '" . htmlspecialchars($submenuid, ENT_QUOTES) . "'";
		
	$wsql .= " AND login.login_status = 1";
		
	switch($type)
	{
		case 1: // view level
			$query_usa = "SELECT usersysacc_view FROM www.user_sysacc LEFT JOIN www.login ON login.user_stafid = user_sysacc.user_stafid WHERE usersysacc_status = 1 AND user_sysacc.user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' " . $wsql;
			$user_usa = mysql_query($query_usa);
			$row_usa = mysql_fetch_assoc($user_usa);
			
			$total = mysql_num_rows($user_usa);
		
			if($row_usa['usersysacc_view']==1 && $total > 0)
				$level = true;
			else
				$level = false;
			break;
			
		case 2: // add level
			$query_usa = "SELECT usersysacc_add FROM www.user_sysacc LEFT JOIN www.login ON login.user_stafid = user_sysacc.user_stafid WHERE usersysacc_status = 1 AND user_sysacc.user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' " . $wsql;
			$user_usa = mysql_query($query_usa);
			$row_usa = mysql_fetch_assoc($user_usa);
			
			$total = mysql_num_rows($user_usa);
		
			if($row_usa['usersysacc_add']==1 && $total > 0)
				$level = true;
			else
				$level = false;
			break;
			
		case 3: // edit level
			$query_usa = "SELECT usersysacc_edit FROM www.user_sysacc LEFT JOIN www.login ON login.user_stafid = user_sysacc.user_stafid WHERE usersysacc_status = 1 AND user_sysacc.user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' " . $wsql;
			$user_usa = mysql_query($query_usa);
			$row_usa = mysql_fetch_assoc($user_usa);
			
			$total = mysql_num_rows($user_usa);
		
			if($row_usa['usersysacc_edit']==1 && $total > 0)
				$level = true;
			else
				$level = false;
			break;
			
		case 4: // del level
			$query_usa = "SELECT usersysacc_del FROM www.user_sysacc LEFT JOIN www.login ON login.user_stafid = user_sysacc.user_stafid WHERE usersysacc_status = 1 AND user_sysacc.user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' " . $wsql;
			$user_usa = mysql_query($query_usa);
			$row_usa = mysql_fetch_assoc($user_usa);
			
			$total = mysql_num_rows($user_usa);
		
			if($row_usa['usersysacc_del']==1 && $total > 0)
				$level = true;
			else
				$level = false;
			break;
		default:
			$level = false;
	}
	
	return $level;
}

function checkUserLevelRegister($userid, $menuid=0, $submenuid=0)
{
	$wsql = "";
	
	if($menuid != 0)
		$wsql .= " AND menu_id = '" . htmlspecialchars($menuid, ENT_QUOTES) . "'";
	if($submenuid != 0)
		$wsql .= " AND submenu_id = '" . htmlspecialchars($submenuid, ENT_QUOTES) . "'";
		
	$query_usa = "SELECT usersysacc_del FROM www.user_sysacc WHERE usersysacc_status = '1' AND user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' " . $wsql;
	$user_usa = mysql_query($query_usa);
	$row_usa = mysql_fetch_assoc($user_usa);
	
	$total = mysql_num_rows($user_usa);
	
	if($total>0)
		return true;
	else
		return false;
}

function viewIconAcc($userid, $menuid=0, $submenuid=0, $type){
	if(checkUserSysAcc($userid, $menuid, $submenuid, $type))
		return "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" width=\"16\" height=\"16\" alt=\"Yes\" />";
	else
		return "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_error.png\" width=\"16\" height=\"16\" alt=\"Yes\" />";
}
?>
<?php
// sub menu utk permenant
function checkSubMenuPermenant($user, $id)
{
	$query_s = "SELECT submenu_permenant FROM www.submenu WHERE submenu_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	if($row_s['submenu_permenant']==1)
	{
		if(getDesignationType($user))
			return true;
		else
			return false;
	} else
		return true;
}
?>
<?php 
function sqlAllStaf($sql_where, $sql_orderby='0')
{
	if($sql_orderby!='0')
		$orderby = $sql_orderby;
	else
		$orderby = "user_job2.jobss_id DESC, user_scheme.userscheme_gred DESC, scheme.group_id ASC, user_firstname ASC, user_lastname ASC";
		
	$sqls = "SELECT user.*, user_job.userjob_tpg_m, scheme.group_id, user_job2.jobss_id, user_scheme.userscheme_gred, dir.dir_sub, dir.dir_sub, user_designation.userdesignation_date_d, user_designation.userdesignation_date_m, user_designation.userdesignation_date_y 
	FROM www.user 
	LEFT JOIN (SELECT * FROM www.login GROUP BY login.user_stafid ORDER BY login.login_id DESC) AS login ON login.user_stafid = user.user_stafid 
	LEFT JOIN (SELECT * FROM www.user_designation WHERE user_designation.userdesignation_status = '1' GROUP BY user_designation.user_stafid ORDER BY user_designation.userdesignation_date_y DESC, user_designation.userdesignation_date_m DESC, user_designation.userdesignation_date_d DESC, user_designation.userdesignation_id DESC) AS user_designation ON user_designation.user_stafid = user.user_stafid
	LEFT JOIN www.user_job ON user_job.user_stafid = user.user_stafid 
	LEFT JOIN (SELECT * FROM www.user_job2 WHERE user_job2.userjob2_status = '1' ORDER BY user_job2.userjob2_date_y DESC, user_job2.userjob2_date_m DESC, user_job2.userjob2_date_d DESC) AS user_job2 ON user_job2.user_stafid = user.user_stafid 
	LEFT JOIN (SELECT * FROM (SELECT * FROM www.user_scheme ORDER BY user_scheme.userscheme_gred DESC, userscheme_in_y DESC, userscheme_in_m DESC, userscheme_in_d DESC, userscheme_id DESC) AS user_scheme WHERE user_scheme.userscheme_status = '1' GROUP BY user_scheme.user_stafid ORDER BY user_scheme.userscheme_gred DESC, userscheme_in_y DESC, userscheme_in_m DESC, userscheme_in_d DESC, userscheme_id DESC) AS user_scheme ON user.user_stafid = user_scheme.user_stafid 
	LEFT JOIN www.scheme ON scheme.scheme_id = user_scheme.scheme_id 
	LEFT JOIN (SELECT * FROM www.user_unit WHERE userunit_status = '1' GROUP BY user_stafid ORDER BY userunit_in_y DESC, userunit_in_m DESC, userunit_in_d DESC, userunit_id DESC) AS user_unit ON user_unit.user_stafid = user.user_stafid 
LEFT JOIN (SELECT * FROM www.user_edu WHERE useredu_status = '1' GROUP BY user_stafid ORDER BY useredu_level DESC) AS user_edu ON user_edu.user_stafid = user.user_stafid 	LEFT JOIN www.dir ON dir.dir_id = user_unit.dir_id
	LEFT JOIN www.user_personal ON user_personal.user_stafid = user.user_stafid
	WHERE " . $sql_where . " 
	GROUP BY user.user_stafid 
	ORDER BY " . $orderby;	
	//AND login.login_status = 1 
	
	return $sqls;
}
?>
<?php 
function getPassBoxC($id, $urlsubmit, $urlback, $txt=NULL)
{ 
?>	
		<?php if(isset($_SESSION['user_stafid'])){
        echo "<div class=\"passbox_back hidden2\" id=\"" . $id . "\">";
        echo "<div class=\"passbox_form\">";
        	  echo "<form id=\"formpass\" class=\"back_white\" name=\"formpass\" method=\"post\" action=\"" . $urlsubmit . "\">";
        	    echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"form_table\">";
        	      echo "<tr>";
        	        echo "<td colspan=\"2\" class=\"title\">Pengesahan Kata Laluan</td>";
      	        echo "</tr>";
        	      echo "<tr>";
				  if($txt==NULL)
        	        echo "<td colspan=\"2\">Sila buat pengesahan Kata Laluan untuk tindakan selanjutnya.</td>";
				  else
				  	echo "<td colspan=\"2\">" . $txt . "</td>";
      	        echo "</tr>";
        	      echo "<tr>";
        	        echo "<td nowrap=\"nowrap\" class=\"back_white\">Kata Laluan</td>";
        	        echo "<td width=\"100%\" class=\"back_white\">";
       	            echo "<input type=\"password\" name=\"kl\" id=\"kl\" /></td>";
      	        echo "</tr>";
        	      echo "<tr>";
        	        echo "<td class=\"back_white\">";
       	            echo "<input name=\"MM_checkpass\" type=\"hidden\" id=\"MM_checkpass\" value=\"formpassc\" />";
       	            echo "<input name=\"url\" type=\"hidden\" id=\"url\" value=\"" . $urlback . "\" /></td>";
        	        echo "<td nowrap=\"nowrap\">";
                    echo "<input type=\"submit\" name=\"button\" id=\"button\" value=\"Semak\" class=\"submitbutton\" />";
       	            echo "<input type=\"button\" name=\"button2\" id=\"button2\" value=\"Batal\" class=\"cancelbutton\" onclick=\"toggleview2('formPasswordc'); return false;\" />";
                    echo "</td>";
      	        echo "</tr>";
      	      echo "</table>";
      	      echo "</form>";
        echo "</div>";
        echo "</div>";
        }; ?>
<?php }; ?>
<?php 
function getPassBoxF($id, $txt=NULL)
{ 
?>	
		<?php if(isset($_SESSION['user_stafid'])){
        echo "<div class=\"passbox_back hidden2\" id=\"" . $id . "\">";
        echo "<div class=\"passbox_form\">";
        	    echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"form_table\">";
        	      echo "<tr>";
        	        echo "<td colspan=\"2\" class=\"title\">Pengesahan Kata Laluan</td>";
      	        echo "</tr>";
        	      echo "<tr>";
				  if($txt==NULL)
        	        echo "<td colspan=\"2\">Sila buat pengesahan Kata Laluan untuk tindakan selanjutnya.</td>";
				  else
				  	echo "<td colspan=\"2\">" . $txt . "</td>";
      	        echo "</tr>";
        	      echo "<tr>";
        	        echo "<td nowrap=\"nowrap\" class=\"back_white\">Kata Laluan</td>";
        	        echo "<td width=\"100%\" class=\"back_white\">";
       	            echo "<input type=\"password\" name=\"kl\" id=\"kl\" /></td>";
      	        echo "</tr>";
        	      echo "<tr>";
        	        echo "<td class=\"back_white\">";
       	            echo "<input name=\"MM_checkpass\" type=\"hidden\" id=\"MM_checkpass\" value=\"formpassc\" />";
        	        echo "<td nowrap=\"nowrap\">";
                    echo "<input type=\"submit\" name=\"button\" id=\"button\" value=\"Semak\" class=\"submitbutton\" />";
       	            echo "<input type=\"button\" name=\"button2\" id=\"button2\" value=\"Batal\" class=\"cancelbutton\" onclick=\"toggleview2('formPasswordc'); return false;\" />";
                    echo "</td>";
      	        echo "</tr>";
      	      echo "</table>";
        echo "</div>";
        echo "</div>";
        }; ?>
<?php }; ?>
<?php
function color($perc)
{
	if($perc == 0)
		return "style=\"background-color: #FFFFFF; color:#CCC;\"";
	else if($perc < 10)
		return "style=\"background-color: #FFFFE6; color:#AAA;\"";
	else if($perc < 20)
		return "style=\"background-color: #FFF380; color:#666;\"";
	else if($perc < 30)
		return "style=\"background-color: #FDD017; color:#666;\"";
	else if($perc < 40)
		return "style=\"background-color: #FBB117; color:#FFF;\"";
	else if($perc < 50)
		return "style=\"background-color: #E56717; color:#FFF;\"";
	else if($perc < 60)
		return "style=\"background-color: #F75D59; color:#FFF;\"";
	else if($perc < 70)
		return "style=\"background-color: #E55451; color:#FFF;\"";
	else if($perc < 80)
		return "style=\"background-color: #FF0000; color:#FFF;\"";
	else if($perc < 90)
		return "style=\"background-color: #E41B17; color:#FFF;\"";
	else if($perc <= 100)
		return "style=\"background-color: #C11B17; color:#FFF;\"";
	else
		return "#FFFFFF";
};

function star($perc)
{
	if($perc == 0)
		return "<img src=\"" . $GLOBALS['url_main'] . "icon/star0.gif\" />";
	else if($perc <= 20)
		return "<img src=\"" . $GLOBALS['url_main'] . "icon/star1.gif\" />";
	else if($perc <= 40)
		return "<img src=\"" . $GLOBALS['url_main'] . "icon/star2.gif\" />";
	else if($perc <= 60)
		return "<img src=\"" . $GLOBALS['url_main'] . "icon/star3.gif\" />";
	else if($perc <= 80)
		return "<img src=\"" . $GLOBALS['url_main'] . "icon/star4.gif\" />";
	else if($perc <= 100)
		return "<img src=\"" . $GLOBALS['url_main'] . "icon/star5.gif\" />";
	else
		return "<img src=\"" . $GLOBALS['url_main'] . "icon/star0.gif\" />";	
}
?>
<?php
//datalist Staf
function datalistStaf($dlname, $dir=0)
{
	$sql_where = " login.login_status = '1' ";
	
	if($dir!=0)
		$sql_where .= " AND dir.dir_id = '" . htmlspecialchars($dir, ENT_QUOTES) . "'";
		
	$query_s = sqlAllStaf($sql_where);
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	$dl = "<datalist id='" . $dlname . "'>";
	
	do{
		$dl .= "<option value='" . $row_s['user_stafid'] . "'>" . getFullNameByStafID($row_s['user_stafid']) . "</option>";
	} while($row_s = mysql_fetch_assoc($user_s));
	
	$dl .= "</datalist>";
	
	return $dl;
}
?>
<?php
// System Audit
function sys_prorec($db, $table, $userid, $prorectype, $prorecnote)
{
	// prorec_type :
	// 1 - view
	// 2 - add
	// 3 - edit
	// 4 - delete
	$insertSQL = sprintf("INSERT INTO sysaudit.pro_rec (prorec_d, prorec_m, prorec_y, prorec_t, dbid, tableid, user_stafid, prorec_type, prorec_note) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString(date('d'), "text"),
                       GetSQLValueString(date('m'), "text"),
                       GetSQLValueString(date('Y'), "int"),
                       GetSQLValueString(date('h:i:s A'), "text"),
                       GetSQLValueString($db, "text"),
                       GetSQLValueString($table, "text"),
                       GetSQLValueString($userid, "text"),
                       GetSQLValueString($prorectype, "text"),
                       GetSQLValueString($prorecnote, "text"));

  mysql_select_db($GLOBALS['database_sysdb'], $GLOBALS['sysdb']);
  $Result1 = mysql_query($insertSQL, $GLOBALS['sysdb']) or die(mysql_error());
  
  return true;
}

function sys_prolog($userid, $sysid)
{
	$insertSQL = sprintf("INSERT INTO sysaudit.pro_log (prolog_d, prolog_m, prolog_y, prolog_t, sys_id, user_stafid) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString(date('d'), "text"),
                       GetSQLValueString(date('m'), "text"),
                       GetSQLValueString(date('Y'), "int"),
                       GetSQLValueString(date('h:i:s A'), "text"),
                       GetSQLValueString($sysid, "int"),
                       GetSQLValueString($userid, "text"));

  mysql_select_db($GLOBALS['database_sysdb'], $GLOBALS['sysdb']);
  $Result1 = mysql_query($insertSQL, $GLOBALS['sysdb']) or die(mysql_error());
  
  return true;
}

function getLastLogin($userid, $sysid=1)
{
	$query_s = "SELECT prolog_d, prolog_m, prolog_y, prolog_t FROM sysaudit.pro_log WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND sys_id='" . htmlspecialchars($sysid, ENT_QUOTES) . "' ORDER BY prolog_id DESC LIMIT 2";
	$user_s = mysql_query($query_s);
	$row_s = mysql_fetch_assoc($user_s);
	
	do {
		$view = date('d/m/Y (D)', mktime(0, 0, 0, $row_s['prolog_m'], $row_s['prolog_d'], $row_s['prolog_y'])) . " " . $row_s['prolog_t'];
	} while($row_s = mysql_fetch_assoc($user_s));
	
	return $view;
}
?>
<?php
//modul permohonan menginggalkan pejabat
function getleaveOfficeIDByDate($userid, $d, $m, $y)
{
	
	$query_leaveoffice = "SELECT leaveoffice_id FROM www.leave_office WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND leaveoffice_on_d = '" . $d . "' AND leaveoffice_on_m = '" . $m . "' AND leaveoffice_on_y = '" . $y . "' AND leaveoffice_status = 1";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
		
		$total = array();
	
	do {
		$total[]=$row_leaveoffice['leaveoffice_id'];
	} while($row_leaveoffice = mysql_fetch_assoc($leaveoffice));
	
	
	return $total;
	}
function checkDelLeaveOfficeByLeaveOfficeID($id)
{
	// Semakkan sekiranya harta dipadam dalam senarai harta
	$query_leaveoffice = "SELECT leaveoffice_status FROM www.leave_office WHERE leaveoffice_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);

	return $row_leaveoffice['leaveoffice_status'];
}

function getNewLeaveOfficeIDByDate($userid, $reason=0, $d, $m, $y)
{
	// Leave Office ID spesifik selepas Add New
	$wsql = "";
	
	if($reason!=0)
		$wsql .= " AND reason_id = '" . $reason . "'";
		
	$query_leaveoffice = "SELECT leaveoffice_id FROM www.leave_office WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND leaveoffice_on_d = '" . $d . "' AND leaveoffice_on_m='" . $m . "' AND leaveoffice_on_y='" . $y . "' AND leaveoffice_status = 1" . $wsql . " ORDER BY reason_id DESC LIMIT 1";	/*modify by nadia 20200706 - add leave status filter*/
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return $row_leaveoffice['leaveoffice_id'];
}

function getNewPergerakanIDByDate($userid,  $d, $m, $y)
{

	$query_leaveoffice = "SELECT pergerakan_id FROM www.pergerakan WHERE pergerakan_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND pergerakan_day = '" . $d . "' AND pergerakan_month='" . $m . "' AND pergerakan_year='" . $y . "' ";
	$leaveoffice = mysql_query($query_leaveoffice);
	$result = array();
	while ($row_leaveoffice = mysql_fetch_array($leaveoffice, MYSQL_ASSOC)) {
		$result[] = $row_leaveoffice['pergerakan_id'];
	}
	
	return $result;
}

function checkleaveOfficeIDByDate($userid, $d, $m, $y, $status=0)
{
	if($status == 0)
		$wsql = " AND app_status != '2'";
	else
		$wsql = "";
		
	$query_leaveoffice = "SELECT leaveoffice_id FROM www.leave_office WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND leaveoffice_on_d = '" . htmlspecialchars($d, ENT_QUOTES) . "' AND leaveoffice_on_m = '" . htmlspecialchars($m, ENT_QUOTES) . "' AND leaveoffice_on_y = '" . htmlspecialchars($y, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	$total = mysql_num_rows($leaveoffice);
	
	if($total>=2)
		return true;
	else
		return false;
}

function checkLeaveOfficeDateByLeaveOfficeID($id)
{	
	if(getReasonType(getReasonByLeaveOfficeID($id))=='1')
	{
		$dmy = getLeaveOfficeDateEndByLeaveOfficeID($id); 
		
		if($dmy[0]>=date('d') && $dmy[1]==date('m') && $dmy==date('Y'))
			$inday = true;
		elseif($dmy[1]>date('m') && $dmy==date('Y'))
			$inday = true;
		else
			$inday = false;
	} else
		$inday = false;
		
	return $inday;
}

function getUserIDByLeaveOfficeID($id)
{
	$query_leaveoffice = "SELECT user_stafid FROM www.leave_office WHERE leaveoffice_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return $row_leaveoffice['user_stafid'];
}

function getHeadApprovalByLeaveOfficeID($id)
{
	$query_leaveoffice = "SELECT app_status FROM www.leave_office WHERE leaveoffice_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return $row_leaveoffice['app_status'];
}

function getHeadApprovalDateByLeaveOfficeID($id)
{
	$query_leaveoffice = "SELECT app_date FROM www.leave_office WHERE leaveoffice_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return $row_leaveoffice['app_date'];
}

function getHeadApprovalByByLeaveOfficeID($id)
{
	// Staf ID yg meluluskan
	$query_leaveoffice = "SELECT app_by FROM www.leave_office WHERE leaveoffice_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return $row_leaveoffice['app_by'];
}

function getHeadApprovalNoteByLeaveOfficeID($id)
{
	$query_leaveoffice = "SELECT app_note FROM www.leave_office WHERE leaveoffice_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return $row_leaveoffice['app_note'];
}

function getWarningByLeaveOfficeID($id)
{
	$query_leaveoffice = "SELECT app_warning FROM www.leave_office WHERE leaveoffice_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return $row_leaveoffice['app_warning'];
}

function checkWarningByLeaveOfficeID($id)
{
	$query_leaveoffice = "SELECT app_warning FROM www.leave_office WHERE leaveoffice_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	$total = mysql_num_rows($leaveoffice);
	
	if($total>0 && $row_leaveoffice['app_warning']==1)
		return true;
	else
		return false;
}

function getFromDateByLeaveOfficeID($id)
{
	$query_leaveoffice = "SELECT leaveoffice_from_day, leaveoffice_from_month, leaveoffice_from_year FROM www.leave_office WHERE leaveoffice_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return date('d / m / Y (D)', mktime(0 , 0, 0, $row_leaveoffice['leaveoffice_from_month'], $row_leaveoffice['leaveoffice_from_day'], $row_leaveoffice['leaveoffice_from_year']));
}

function getTillDateByLeaveOfficeID($id)
{
	$query_leaveoffice = "SELECT leaveoffice_till_day, leaveoffice_till_month, leaveoffice_till_year FROM www.leave_office WHERE leaveoffice_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return date('d / m / Y (D)', mktime(0 , 0, 0, $row_leaveoffice['leaveoffice_till_month'], $row_leaveoffice['leaveoffice_till_day'], $row_leaveoffice['leaveoffice_till_year']));
}

function getDateLeaveByLeaveOfficeID($id)
{
	$query_leaveoffice = "SELECT leaveoffice_on_d, leaveoffice_on_m, leaveoffice_on_y FROM www.leave_office WHERE leaveoffice_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return date('d / m / Y (D)', mktime(0 , 0, 0, $row_leaveoffice['leaveoffice_on_m'], $row_leaveoffice['leaveoffice_on_d'], $row_leaveoffice['leaveoffice_on_y']));
}

function getTimeLeaveByLeaveOfficeID($id)
{
	$query_leaveoffice = "SELECT leaveoffice_on_d, leaveoffice_on_m, leaveoffice_on_y, leaveoffice_from_h, leaveoffice_from_m, leaveoffice_from_ap FROM www.leave_office WHERE leaveoffice_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return date('h : i A', mktime($row_leaveoffice['leaveoffice_from_h'] , $row_leaveoffice['leaveoffice_from_m'], 0, $row_leaveoffice['leaveoffice_on_m'], $row_leaveoffice['leaveoffice_on_d'], $row_leaveoffice['leaveoffice_on_y']));
}

function getTimeBackByLeaveOfficeID($id)
{
	$query_leaveoffice = "SELECT leaveoffice_on_d, leaveoffice_on_m, leaveoffice_on_y, leaveoffice_till_h, leaveoffice_till_m, leaveoffice_till_ap FROM www.leave_office WHERE leaveoffice_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return date('h : i A', mktime($row_leaveoffice['leaveoffice_till_h'] , $row_leaveoffice['leaveoffice_till_m'], 0, $row_leaveoffice['leaveoffice_on_m'], $row_leaveoffice['leaveoffice_on_d'], $row_leaveoffice['leaveoffice_on_y']));
}

function getReasonByLeaveOfficeID($id)
{
	$query_leaveoffice = "SELECT reason_id FROM www.leave_office WHERE leaveoffice_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return $row_leaveoffice['reason_id'];
}

function getLeaveOfficeDayByLeaveOfficeID($id)
{
	$query_leaveoffice = "SELECT leaveoffice_day FROM www.leave_office WHERE leaveoffice_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return $row_leaveoffice['leaveoffice_day'];
}

function getPergerakanDayByLeaveOfficeID($id)
{
	$query_leaveoffice = "SELECT pergerakan_day FROM www.pergerakan WHERE pergerakan_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return $row_leaveoffice['pergerakan_day'];
}

function getLeaveOfficeTotalDayByLeaveOfficeID($id)
{
	// jumlah hari berdasarkan tempoh
	$query_leaveoffice = "SELECT leaveoffice_day, leaveoffice_daytype, leaveoffice_on_d, leaveoffice_on_m, leaveoffice_on_y FROM www.leave_office WHERE leaveoffice_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	$day = 0;
	
	if($row_leaveoffice['leaveoffice_daytype']==3)
		$day = $row_leaveoffice['leaveoffice_day']*30; // kiraan hari dalam bulan
	elseif($row_leaveoffice['leaveoffice_daytype']==2)
		$day = $row_leaveoffice['leaveoffice_day']*7; // kiraan hari dalam minggu
	else
		$day = $row_leaveoffice['leaveoffice_day']; // jumlah hari
		
	return ($day-1);
}

function getLeaveOfficeDateEndByLeaveOfficeID($id)
{
	//tarikh akhir berdasarkan tempoh dalam array
	$query_leaveoffice = "SELECT leaveoffice_on_d, leaveoffice_on_m, leaveoffice_on_y FROM www.leave_office WHERE leaveoffice_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	$d= 0;
	$d = $row_leaveoffice['leaveoffice_on_d']+ getLeaveOfficeTotalDayByLeaveOfficeID($id);
	
	if($d >= '28' || $d<= '31')
{
	$dmy = explode("/", date('d/m/Y', mktime(0, 0, 0, $row_leaveoffice['leaveoffice_on_m']+1, $d, $row_leaveoffice['leaveoffice_on_y'])));
}
else 
$dmy = explode("/", date('d/m/Y', mktime(0, 0, 0, $row_leaveoffice['leaveoffice_on_m'], $d, $row_leaveoffice['leaveoffice_on_y'])));

	return $dmy;
}

function getLeaveOfficeDayTypeByLeaveOfficeID($id)
{
	$query_leaveoffice = "SELECT leaveoffice_daytype FROM www.leave_office WHERE leaveoffice_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return $row_leaveoffice['leaveoffice_daytype'];
}

function getDayType($id)
{
	switch($id)
	{
		case 1 :
			$view = "Hari";
			break;
		case 2 :
			$view = "Minggu";
			break;
		case 3 :
			$view = "Bulan";
			break;
	};
	
	return $view;
}

function getLeaveNoteByLeaveOfficeID($id)
{
	$query_leaveoffice = "SELECT leaveoffice_note FROM www.leave_office WHERE leaveoffice_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return $row_leaveoffice['leaveoffice_note'];
}

function getLeaveFrequencyByLeaveOfficeID($id, $m=0, $y=0)
{
	if($m==0)
		$m = date('m');
		
	if($y==0)
		$y = date('Y');
		
	$query_leaveoffice = "SELECT leaveoffice_id FROM www.leave_office WHERE leaveoffice_status = 1 AND user_stafid = '" . htmlspecialchars(getUserIDByLeaveOfficeID($id), ENT_QUOTES) . "' AND leaveoffice_on_m='" . $m . "' AND leaveoffice_on_y='" . $y . "' AND reason_id = '" . htmlspecialchars(getReasonByLeaveOfficeID($id), ENT_QUOTES) . "' ORDER BY leaveoffice_id ASC";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	$total = array();
	
	do {
		$total[]=$row_leaveoffice['leaveoffice_id'];
	} while($row_leaveoffice = mysql_fetch_assoc($leaveoffice));
	
	$key = array_search($id, $total);
	
	return ($key+1);
}

function getReasonNameByID($id)
{
	$query_leaveoffice = "SELECT reason_name FROM www.reason WHERE reason_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return $row_leaveoffice['reason_name'];
}

function iconApplyLeaveStatus($id)
{
	if(getHeadApprovalByLeaveOfficeID($id)==0)
	echo "<img src=\"" . $GLOBALS['url_main'] . "icon/lock.png\" alt=\"Pending\" align=\"absbottom\" />";
	if(getHeadApprovalByLeaveOfficeID($id)==1)
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" alt=\"Approval\" align=\"absbottom\" />";
	if(getHeadApprovalByLeaveOfficeID($id)==2)	
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_error.png\" alt=\"Pending\" border=\"0\" align=\"absbottom\" />";		
}

function checkWarningleaveOfficeByUserID($userid, $m=0, $y=0)
{
	//semakkan 3 kali amaran
	
	$wsql = "";
	
	if($m!=0)
		$wsql .= " AND leaveoffice_on_m = '" . $m . "'";
		
	if($y!=0)
		$wsql .= " AND leaveoffice_on_y = '" . $y . "'";
		
	$query_leaveoffice = "SELECT leaveoffice_id FROM www.leave_office WHERE leaveoffice_status = 1 AND app_warning = '1' AND user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' " . $wsql;
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	$total = mysql_num_rows($leaveoffice);
	
	if($total%3==0 && $total>0)
		return true;
	else
		return false;
}

function iconWarning($id)
{
	 if(checkWarningByLeaveOfficeID($id))
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_error.png\" alt=\"Warning\" align=\"absbottom\" />";
	else
		echo "";
}

function getReasonType($id)
{
	$query_leaveoffice = "SELECT reason_type FROM www.reason WHERE reason_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return $row_leaveoffice['reason_type'];
}

function getReasonStart($id)
{
	$query_leaveoffice = "SELECT reason_start_hour, reason_start_minit FROM www.reason WHERE reason_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	$hm = array();
	$hm[0] = $row_leaveoffice['reason_start_hour'];
	$hm[1] = $row_leaveoffice['reason_start_minit'];
	
	return $hm;
}

function getReasonEnd($id)
{
	$query_leaveoffice = "SELECT reason_end_hour, reason_end_minit FROM www.reason WHERE reason_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	$hm = array();
	$hm[0] = $row_leaveoffice['reason_end_hour'];
	$hm[1] = $row_leaveoffice['reason_end_minit'];
	
	return $hm;
}
?>
<?php
//Harta
function checkUserByPropertyID($user,$pid) 
{
	//menyemak user sama ada pengistiharan harta dia atau tidak
	$query_ss = "SELECT user_stafid FROM www.user_property WHERE user_property.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND user_property.userproperty_id = '" . htmlspecialchars($pid, ENT_QUOTES) . "' AND userproperty_status = '1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	$total = mysql_num_rows($user_ss);
	
	if($total > 0)
		return true;
	else
		return false;
}

function getSubmitDate($id, $view=0)
{		
	$query_ss = "SELECT userproperty_date_d, userproperty_date_m, userproperty_date_y FROM www.user_property WHERE userproperty_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY userproperty_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($view == 0)
		return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['userproperty_date_m'], $row_ss['userproperty_date_d'], $row_ss['userproperty_date_y']));
	else
		return date('d/m/Y', mktime(0, 0, 0, $row_ss['userproperty_date_m'], $row_ss['userproperty_date_d'], $row_ss['userproperty_date_y']));
}

function getPropertyTypeByPropertyID($pid)
{
	$query_type = "SELECT propertytype_name FROM www.property_type LEFT JOIN www.user_property ON property_type.propertytype_id= user_property.property_id WHERE userproperty_id='" . htmlspecialchars($pid, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);

	return $row_type['propertytype_name'];
}

function getPropertyDetailByID($id)
{		
	$query_ss = "SELECT userproperty_detail FROM www.user_property WHERE userproperty_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY userproperty_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['userproperty_detail'];
}

function getPropertyBy($id)
{		
	$query_ss = "SELECT userproperty_by FROM www.user_property WHERE userproperty_status = '1' AND userproperty_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY userproperty_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['userproperty_by'];
}

function getOwnerByPropertyID($pid)
{
	$query_type = "SELECT owner_name FROM www.owner LEFT JOIN www.user_property ON owner.owner_id= user_property.owner_id WHERE userproperty_id='" . htmlspecialchars($pid, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);

	return $row_type['owner_name'];
}

function getRegNoByPropertyID($pid)
{
	$query_type = "SELECT userproperty_regno FROM  www.user_property WHERE userproperty_id='" . htmlspecialchars($pid, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);

	return $row_type['userproperty_regno'];
}

function getAddressByPropertyID($id)
{
	$query_userid = "SELECT userproperty_address1, userproperty_address2, userproperty_address3 FROM www.user_property WHERE userproperty_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);

	$add = "";

	if($row_userid['userproperty_address1']!=NULL) 
		$add .= $row_userid['userproperty_address1'] . ", ";

	if($row_userid['userproperty_address2']!=NULL)
		$add .= $row_userid['userproperty_address2'] . ", ";

	if($row_userid['userproperty_address3']!=NULL) 
		$add .= $row_userid['userproperty_address3'];

	return strtoupper($add);
}

function getPoscodeByPropertyID($pid)
{
	$query_type = "SELECT userproperty_poscode FROM  www.user_property WHERE userproperty_id='" . htmlspecialchars($pid, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);
	
	return $row_type['userproperty_poscode'];
}

function getCityByPropertyID($pid)
{
	$query_type = "SELECT userproperty_city FROM  www.user_property WHERE userproperty_id='" . htmlspecialchars($pid, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);

	return $row_type['userproperty_city'];
}

function getStateIDByPropertyID($pid)
{
	$query_type = "SELECT state_id FROM www.user_property WHERE userproperty_id='" . htmlspecialchars($pid, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);

	return $row_type['state_id'];
}

function getOwnedDateByPropertyID($pid)
{
	$query_type = "SELECT userproperty_owned_date FROM  www.user_property WHERE userproperty_id='" . htmlspecialchars($pid, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);

	return $row_type['userproperty_owned_date'];
}

function getQuantityByPropertyID($pid)
{
	$query_type = "SELECT userproperty_quantity FROM  www.user_property WHERE userproperty_id='" . htmlspecialchars($pid, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);

	return $row_type['userproperty_quantity'];
}

function getAmountByPropertyID($pid)
{
	$query_type = "SELECT userproperty_amount FROM  www.user_property WHERE userproperty_id='" . htmlspecialchars($pid, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);

	return $row_type['userproperty_amount'];
}

function getSourceIDByPropertyID($pid)
{
	$query_type = "SELECT source_id FROM www.user_property WHERE userproperty_id='" . htmlspecialchars($pid, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);

	return $row_type['source_id'];
}

function getSourceNameByID($pid)
{
	$query_type = "SELECT source_name FROM www.source WHERE source_id='" . htmlspecialchars($pid, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);

	return $row_type['source_name'];
}

function getInstituteLoanByPropertyID($pid)
{
	$query_type = "SELECT userproperty_instituteloan FROM www.user_property WHERE userproperty_id='" . htmlspecialchars($pid, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);
	
	return $row_type['userproperty_instituteloan'];
}

function getPayDateByPropertyID($pid)
{
	$query_type = "SELECT userproperty_start_date, userproperty_end_date FROM www.user_property WHERE userproperty_id='" . htmlspecialchars($pid, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);

	return $row_type['userproperty_start_date']. " - " . $row_type['userproperty_end_date'];
}

function getDurationLoanByPropertyID($pid)
{
	$query_type = "SELECT userproperty_durationloan FROM www.user_property WHERE userproperty_id='" . htmlspecialchars($pid, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);

	return $row_type['userproperty_durationloan'];
}

function getTotalLoanByPropertyID($pid)
{
	$query_type = "SELECT userproperty_totalloan FROM www.user_property WHERE userproperty_id='" . htmlspecialchars($pid, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);
	
	return $row_type['userproperty_totalloan'];
}

function getMonthlyLoanByPropertyID($pid)
{
	$query_type = "SELECT userproperty_monthlyloan FROM www.user_property WHERE userproperty_id='" . htmlspecialchars($pid, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);

	return $row_type['userproperty_monthlyloan'];
}

function getNoteByPropertyID($pid)
{
	$query_type = "SELECT userproperty_note FROM www.user_property WHERE userproperty_id='" . htmlspecialchars($pid, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);
	
	return $row_type['userproperty_note'];
}

function getTotalAmountIndLoanByUser($user)
{
	$query_ss = "SELECT SUM(userproperty_totalloan) AS total FROM www.user_property LEFT JOIN www.owner ON owner.owner_id=www.user_property.owner_id WHERE  user_property.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND user_property.owner_id='1' AND source_id= '4' AND userproperty_status=1";
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total= $row_ss['total'];
	
	return $total;
}

function getTotalMonthlyAmountIndLoanByUser($user)
{
	$query_ss = "SELECT SUM(userproperty_monthlyloan) AS total FROM www.user_property LEFT JOIN www.owner ON owner.owner_id=www.user_property.owner_id WHERE user_property.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND user_property.owner_id='1' AND source_id='4' AND userproperty_status=1";
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total= $row_ss['total'];

	 return $total;
}

function getTotalAmountHusWifeLoanByUser($user)
{
	$query_ss = "SELECT SUM(userproperty_totalloan) AS total FROM www.user_property LEFT JOIN www.owner ON owner.owner_id=www.user_property.owner_id  WHERE user_property.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND source_id='4' AND (user_property.owner_id='2' OR user_property.owner_id='3') AND userproperty_status=1";
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total= $row_ss['total'];
	
	return $total;
}

function getTotalMonthlyAmountHusWifeLoanByUser($user)
{
	$query_ss = "SELECT SUM(userproperty_monthlyloan) AS total FROM www.user_property LEFT JOIN www.owner ON owner.owner_id=www.user_property.owner_id WHERE user_property.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND source_id='4' AND (user_property.owner_id='2' OR user_property.owner_id='3') AND userproperty_status=1";
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total= $row_ss['total'];

	 return $total;
}

function getStafIDByPropertyID($pid)
{
	$query_up = "SELECT user_property.user_stafid FROM www.user_property WHERE userproperty_id = '" . htmlspecialchars($pid, ENT_QUOTES) . "' AND userproperty_status = 1";
	$up = mysql_query($query_up);
	$row_up = mysql_fetch_assoc($up);

	return $row_up['user_stafid'];
}

function viewIconProperty($id)
{
	$query_userid = "SELECT user_stafid, userproperty_noproperty FROM www.user_property WHERE user_property.user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND userproperty_status = '1'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	if($row_userid['user_stafid']!=NULL && $row_userid['userproperty_noproperty']==0)
		return "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" width=\"16\" height=\"16\" alt=\"Yes\" />";
		
		elseif($row_userid['user_stafid']!=NULL && $row_userid['userproperty_noproperty']==1)
		return 'Tiada Harta';	
	else
		return "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_error.png\" width=\"16\" height=\"16\" alt=\"Yes\" />";	
}

function getNoPropertyByUserID($id)
{
	$query_type = "SELECT userproperty_noproperty FROM  www.user_property WHERE user_stafid='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);
	
	return $row_type['userproperty_noproperty'];
}


function checkDelPropertyByPropertyID($pid)
{
	// Semakkan sekiranya harta dipadam dalam senarai harta
	$query_property = "SELECT userproperty_status FROM www.user_property WHERE userproperty_id='" . htmlspecialchars($pid, ENT_QUOTES) . "'";
	$property = mysql_query($query_property);
	$row_property = mysql_fetch_assoc($property);

	return $row_property['userproperty_status'];
}

function getDisposalDateByPropertyID($pid)
{
	$query_type = "SELECT disposal_date FROM  www.disposal WHERE userproperty_id='" . htmlspecialchars($pid, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);
	
	return $row_type['disposal_date'];
}

function getDisposalWayByPropertyID($pid)
{
	$query_type = "SELECT disposalway_name FROM  www.disposal_way LEFT JOIN www.disposal ON disposal_way.disposalway_id= disposal.disposalway_id WHERE userproperty_id='" . htmlspecialchars($pid, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);
	
	return $row_type['disposalway_name'];
}

function getSellPriceByPropertyID($pid)
{
	$query_type = "SELECT disposal_sellprice FROM  www.disposal WHERE userproperty_id='" . htmlspecialchars($pid, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);

	return $row_type['disposal_sellprice'];
}

function getDisposalNoteByPropertyID($pid)
{
	$query_type = "SELECT disposal_note FROM  www.disposal WHERE userproperty_id='" . htmlspecialchars($pid, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);

	return $row_type['disposal_note'];
}

function checkLoanOrNotByPropertyID($pid)
{
	$query_userid = "SELECT source.source_id FROM www.source LEFT JOIN www.user_property ON source.source_id= user_property.source_id WHERE userproperty_id = '" . htmlspecialchars($pid, ENT_QUOTES) . "'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);

	if($row_userid['source_id']=='4')
		return true;
	else
		return false;
}

function getUserPropertyID($userid, $d, $m, $y)
{		
	$query_ss = "SELECT userproperty_id FROM www.user_property WHERE userproperty_status = '1' AND userproperty_by = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND userproperty_date_d = '" . htmlspecialchars($d, ENT_QUOTES) . "' AND userproperty_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "' AND userproperty_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "' ORDER BY userproperty_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['userproperty_id'];
}
//document
function getDocIDByStaffID($userid, $d, $m, $y)
{
	$query_ictitem = "SELECT doc_id FROM tadbir.document WHERE doc_by= '" .$userid."' AND doc_date_d = '" .$d. "' AND doc_date_m = '" .$m. "' AND doc_date_y = '" .$y. "' AND doc_status=1 ORDER BY doc_id DESC";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['doc_id'];
}

function getDateDocByDocID($id)
{
	$query_ictitem = "SELECT doc_date_d, doc_date_m, doc_date_y FROM tadbir.document WHERE doc_id='" . $id . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return date('d / m / Y (D)', mktime(0 , 0, 0, $row_ictitem['doc_date_m'], $row_ictitem['doc_date_d'], $row_ictitem['doc_date_y']));
}

function getRefNoByDocID($id)
{
	$query_ictitem = "SELECT doc_refno FROM tadbir.document WHERE doc_id='" . $id . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['doc_refno'];
}

function getDocTitleByDocID($id)
{
	$query_ictitem = "SELECT doc_title FROM tadbir.document WHERE doc_id='" . $id . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['doc_title'];
}

function getDocCategoryNameByDocCategoryID($id)
{
	$query_ictitem = "SELECT doccategory_name FROM tadbir.doc_category WHERE doccategory_id='" . $id . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['doccategory_name'];
}

function checkUserByDocID($user,$pid) 
{

	$query_ss = "SELECT user_stafid FROM tadbir.doc_status WHERE doc_status.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND doc_status.doc_id = '" . htmlspecialchars($pid, ENT_QUOTES) . "' AND docstatus_status = '1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	$total = mysql_num_rows($user_ss);
	
	if($total > 0)
		return true;
	else
		return false;
}

function getDocDateInByDocID($user, $id)
{
	$query_ictitem = "SELECT docstatus_date_in FROM tadbir.doc_status WHERE doc_id='" . $id . "' AND user_stafid = '". $user . "' AND docstatus_status = 1";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['docstatus_date_in'];
}

function getCategoryIDByDocID($id)
{
	$query_ictitem = "SELECT category_id FROM tadbir.document WHERE doc_id='" . $id . "' AND doc_status = 1";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['category_id'];
}

//thumbprint

function getTimeInByDate($userid, $d, $m, $y)
{
		
	$query_leaveoffice = "SELECT time_in FROM www.leave_office_soyal WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND date_d = '" . $d . "' AND date_m='" . $m . "' AND date_y='" . $y . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return $row_leaveoffice['time_in'];
}

function getTimeOutByDate($userid, $d, $m, $y)
{
		
	$query_leaveoffice = "SELECT time_out FROM www.leave_office_soyal WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND date_d = '" . $d . "' AND date_m='" . $m . "' AND date_y='" . $y . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return $row_leaveoffice['time_out'];
}

function getWPByUserID($userid, $m, $y)
{
		
	$query_leaveoffice = "SELECT shift FROM www.leave_office_soyal WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND date_m='" . $m . "' AND date_y='" . $y . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return $row_leaveoffice['shift'];
}

function getDateBySoyalID($id)
{
		
	$query_leaveoffice = "SELECT date_d, date_m, date_y FROM www.leave_office_soyal WHERE soyal_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return date('d / m / Y (D)', mktime(0, 0, 0, $row_leaveoffice['date_m'], $row_leaveoffice['date_d'], $row_leaveoffice['date_y']));
}

function getStaffBySoyalID($id)
{
		
	$query_leaveoffice = "SELECT user_stafid FROM www.leave_office_soyal WHERE soyal_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return $row_leaveoffice['user_stafid'];


	

	
}

function getLeaveNoteIDByDate($userid, $d, $m, $y)
{
		
	$query_leaveoffice = "SELECT leave_note.leave_hrnote FROM www.leave_note LEFT JOIN www.leave_office_soyal ON leave_office_soyal.soyal_id = leave_note.soyal_id WHERE leave_office_soyal.user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND date_d = '".$d . "' AND date_m='" . $m . "' AND date_y='" . $y . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return $row_leaveoffice['leave_hrnote'];
}

function getLeaveNoteHRByID($id)
{
		
	$query_leaveoffice = "SELECT leave_hrnote_name FROM www.leave_hrnote WHERE leave_hrnote_id='" . $id . "'";
	$leaveoffice = mysql_query($query_leaveoffice);
	$row_leaveoffice = mysql_fetch_assoc($leaveoffice);
	
	return $row_leaveoffice['leave_hrnote_name'];
}

?>
<?php

//pergerakan

// function test($pergerakanID)
// {
// 	echo "<br/>";
// 	echo "<tr>";
// 	echo "<td nowrap=\"nowrap\"class=\"back_white label\">Maklumat Pergerakan new</td>";
// 	echo "<td class=\"back_white\" width=\"100%\"><input name=\"lokasi_baru\" required=\"required\" type=\"text\" id=\"lokasi_baru".$pergerakanID."\" value=''\>";
// 	echo "</td>";
// 	echo "</tr>";
// 	return;
// }


function checkLeaveOfficeByDate($user, $day, $month, $year) 

{

	$query_ss = "SELECT * FROM www.leave_office WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND leaveoffice_status != 2 AND leaveoffice_on_d = '" . htmlspecialchars($day, ENT_QUOTES) . "' AND leaveoffice_on_m = '" . htmlspecialchars($month, ENT_QUOTES) . "' AND leaveoffice_on_y = '" . htmlspecialchars($year, ENT_QUOTES) . "'";	

	$user_ss = mysql_query($query_ss);

	$row_ss = mysql_fetch_assoc($user_ss);

	

	$total = mysql_num_rows($user_ss);

	

	if($total > 0)

		return true;

	else

		return false;

}

function checkPergerakan($user, $day, $month, $year) 

{

	$query_ss = "SELECT * FROM www.pergerakan WHERE pergerakan_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND pergerakan_day = '" . htmlspecialchars($day, ENT_QUOTES) . "' AND pergerakan_month = '" . htmlspecialchars($month, ENT_QUOTES) . "' AND pergerakan_year = '" . htmlspecialchars($year, ENT_QUOTES) . "' AND pergerakan_status = '1'";	

	$user_ss = mysql_query($query_ss);

	$row_ss = mysql_fetch_assoc($user_ss);

	

	$total = mysql_num_rows($user_ss);

	

	if($total > 0)

		return true;

	else

		return false;

}



function getPergerakanID($user, $day, $month, $year)

{

		

	$query_ss = "SELECT pergerakan_id FROM www.pergerakan WHERE pergerakan_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND pergerakan_day = '" . htmlspecialchars($day, ENT_QUOTES) . "' AND pergerakan_month = '" . htmlspecialchars($month, ENT_QUOTES) . "' AND pergerakan_year = '" . htmlspecialchars($year, ENT_QUOTES) . "'";	

	$user_ss = mysql_query($query_ss);

	// $row_ss = mysql_fetch_assoc($user_ss);

	for($x=0; $row_ss = mysql_fetch_array($user_ss); $x++)
	{		
		$result[] = $row_ss;
	}
	return $result;
	

	// return $row_ss['pergerakan_id'];

}

function getPergerakanLocationByID($user, $day, $month, $year)

{

	$query_ss = "SELECT pergerakan_location FROM www.pergerakan WHERE pergerakan_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND pergerakan_day = '" . htmlspecialchars($day, ENT_QUOTES) . "' AND pergerakan_month = '" . htmlspecialchars($month, ENT_QUOTES) . "' AND pergerakan_year = '" . htmlspecialchars($year, ENT_QUOTES) . "'";	

	$user_ss = mysql_query($query_ss);

	// $row_ss = mysql_fetch_row($user_ss);
	// $row_ss = mysql_fetch_assoc($user_ss); //untuk ['name_of_column']

	for($x=0; $row_ss = mysql_fetch_array($user_ss); $x++)
	{		
		$result[] = $row_ss;
	}
	return $result;

	// $arrData = array_values($row_ss);

	// return $row_ss;	
	// return $row_ss['pergerakan_location'];

}

function getPergerakanLocationByID1($user, $day, $month, $year)
{
	$query_ss = "SELECT pergerakan_location FROM www.pergerakan WHERE pergerakan_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND pergerakan_day = '" . htmlspecialchars($day, ENT_QUOTES) . "' AND pergerakan_month = '" . htmlspecialchars($month, ENT_QUOTES) . "' AND pergerakan_year = '" . htmlspecialchars($year, ENT_QUOTES) . "'";	

	$user_ss = mysql_query($query_ss);

	$row_ss = mysql_fetch_assoc($user_ss);

	

	return $row_ss['pergerakan_location'];
}


function getPergerakanStaffByID($user)

{

	  $query_ss = "SELECT pergerakan_location FROM www.pergerakan WHERE pergerakan_id = '" . htmlspecialchars($user, ENT_QUOTES)."'";	

	$user_ss = mysql_query($query_ss);

	$row_ss = mysql_fetch_assoc($user_ss);

	

	return $row_ss['pergerakan_location'];

}



function getSubDirByDirID($dir){

	$query_ss = "SELECT * FROM www.dir WHERE dir_sub = '".$dir."' AND dir_status = 1";

	$dir_ss = mysql_query($query_ss) or die(mysql_error());

	$row_ss = mysql_fetch_assoc($dir_ss);

	

	return $row_ss['dir_id'];

}



//Trace user level by user dir_id

function getRecursive($id){	

	$str = "";	

	if(getSubDirByDirID($id) != null){

		$str .= $id;

		$id = getSubDirByDirID($id);

		getRecursive($id);

		return $str;

	}else{		

	}

}

function getSoyalID($user, $day, $month, $year)

{

		

	$query_ss = "SELECT soyal_id FROM www.leave_office_soyal WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND date_d = '" . htmlspecialchars($day, ENT_QUOTES) . "' AND date_m = '" . htmlspecialchars($month, ENT_QUOTES) . "' AND date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "'";	

	$user_ss = mysql_query($query_ss);

	$row_ss = mysql_fetch_assoc($user_ss);

	

	return $row_ss['soyal_id'];

}

function getDependentsByType($user_stafid,$userdependents_relation){

	$query_ss = "SELECT * FROM www.user_dependents WHERE user_stafid = '".$user_stafid."' AND userdependents_relation = '".$userdependents_relation."'";

	$dir_ss = mysql_query($query_ss) or die(mysql_error());

	$alldependent = mysql_fetch_assoc($dir_ss);

	

	return $alldependent;

}

function adjustID($user_stafid)
{
	$string = str_split($user_stafid, 1)[0];  //P
	$int1 = str_split($user_stafid, 1)[1];  //1
	$int2 = str_split($user_stafid, 1)[2];  //1
	$int3 = str_split($user_stafid, 1)[3];  //0
	$int4 = str_split($user_stafid, 1)[4];  //9

	if(strlen($user_stafid) > 4)
	{
		if($int1 == 0 && $int2 == 0 && $int3 == 0)
		{
			$fullStr = $string . $int4;
		}

		else if($int1 == 0 && $int2 == 0 )
		{
			$fullStr = $string .$int3 . $int4;
		}

		else if($int1 == 0)
		{
			$fullStr = $string .$int2 .$int3 . $int4;
		}

		else {
			$fullStr = $user_stafid;
		}
	} 
	else
	{
		$fullStr = $user_stafid;
	}
	

	return $fullStr;
}

?>
