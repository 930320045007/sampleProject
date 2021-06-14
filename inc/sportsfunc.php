<?php
function getBorrowItemCategoryByID($id)
{
	$query_ictitem = "SELECT category_name FROM sports.category WHERE category_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['category_name'];
}

function getBorrowItemSubCategoryByID($id)
{
	$query_ictitem = "SELECT subcategory_name FROM sports.subcategory WHERE subcategory_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['subcategory_name'];
}

function getBorrowItemISNSiriByID($id)
{
	$query_ictitem = "SELECT item_isnsirihi, item_isnsiriyear, item_isnsiri FROM sports.item WHERE item_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return getSportsISNSiriHIByID($row_ictitem['item_isnsirihi']) . " / " . $row_ictitem['item_isnsiriyear'] . " / " . $row_ictitem['item_isnsiri'];
}

function getSportsISNSiriHIByID($id)
{
	if($id=='H')
		$view = "H";
	else
		$view = "I";
	
	return $view;
}

function getSportsItemBrandNameByID($id)
{
	$query_ictitem = "SELECT brand_name FROM sports.brand WHERE brand_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['brand_name'];
}

function getExpireBySportsItemID($id)
{
	//Tempoh Hayat
	$query_ictitem = "SELECT item_getdate_d, item_getdate_m, item_getdate_y FROM sports.item WHERE item_id = '" . $id . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	$year = date('Y') - $row_ictitem['item_getdate_y'];
	$hayat[0] = (int) $year;
	
	if($year != 0)
	{
		if(date('m') >= $row_ictitem['item_getdate_m'])
		{
			$hayat[1] = (int) (date('m') - $row_ictitem['item_getdate_m']);
		}else 
		$hayat[1] = (int) ($row_ictitem['item_getdate_m'] - date('m'));
	} else {
		$hayat[1] = (int) $row_ictitem['item_getdate_m'];
	}
	
	return $hayat;
}

function iconSportsBorrowByItemID($id)
{
	if(checkBorrowBySportsItemID($id))
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" alt=\"Approval\" align=\"absbottom\" />";
	else
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/lock.png\" alt=\"Lock\" border=\"0\" align=\"absbottom\" />";
}

function checkBorrowBySportsItemID($id)
{
	$query_ictitem = "SELECT item_borrow FROM sports.item WHERE item_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	if($row_ictitem['item_borrow']==1)
		return true;
	else
		return false;
}

function iconItemAvailableBySportsItemID($id)
{
	if(!checkItemAvailableBySportsItemID($id) && !checkBorrowBySportsItemID($id))
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" alt=\"Approval\" align=\"absbottom\" />";
	else if(checkBorrowBySportsItemID($id))
		echo "-";
	else
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick2.png\" alt=\"Approval\" align=\"absbottom\" />";
}

function checkItemAvailableBySportsItemID($id)
{
	$query_ictitem = "SELECT COUNT(itemborrow_id) AS count FROM  sports.item_borrow WHERE item_borrow.itemborrow_status = 1 AND item_borrow.item_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND item_borrow.userborrow_type = 1 AND item_borrow.ict_return = 0 GROUP BY item_borrow.itemborrow_id";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	if($row_ictitem['count']==0)
		return true;
	else
		return false;	
}

function getDurationByID($id)
{
	$query_ictitem = "SELECT durationtype_name FROM sports.duration_type WHERE durationtype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['durationtype_name'];
}

function getVendorNameByVendorID($id)
{
	$query_ictitem = "SELECT vendor_name FROM sports.vendor WHERE vendor_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['vendor_name'];
}

function getVendorAddByVendorID($id)
{
	$query_ictitem = "SELECT vendor_add FROM sports.vendor WHERE vendor_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['vendor_add'];
}

function getVendorNoTelByVendorID($id)
{
	$query_ictitem = "SELECT vendor_notel FROM sports.vendor WHERE vendor_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['vendor_notel'];
}

function getVendorNoFaxByVendorID($id)
{
	$query_ictitem = "SELECT vendor_nofax FROM sports.vendor WHERE vendor_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['vendor_nofax'];
}

function getVendorEmailByVendorID($id)
{
	$query_ictitem = "SELECT vendor_email FROM sports.vendor WHERE vendor_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['vendor_email'];
}

function getVendorWebByVendorID($id)
{
	$query_ictitem = "SELECT vendor_web FROM sports.vendor WHERE vendor_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['vendor_web'];
}

function getVendorTypeNameByVendorID($id)
{
	$query_ictitem = "SELECT vendortype_name FROM sports.vendor_type WHERE vendortype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['vendortype_name'];
}

function getVendorIDByVendorID($id)
{
	$query_ictitem = "SELECT vendortype_id FROM sports.vendor WHERE vendor_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['vendortype_id'];
}

function checkSportsItemComponentByItemID($id)
{
	$query_ictitem = "SELECT item_id FROM sports.item_component WHERE item_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	$total = mysql_num_rows($ictitem);
	
	if($total > 0)
		return true;
	else
		return false;
}


function getSportsItemAddByID($id)
{
	$query_ictitem = "SELECT itemadd_name FROM sports.item_add WHERE itemadd_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['itemadd_name'];
}

function getDateByUserBorrowID($id)
{
	$query_ictitem = "SELECT userborrow_date_d, userborrow_date_m, userborrow_date_y FROM sports.user_borrow WHERE userborrow_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return date('d / m / Y (D)', mktime(0 , 0, 0, $row_ictitem['userborrow_date_m'], $row_ictitem['userborrow_date_d'], $row_ictitem['userborrow_date_y']));
}

function getTimeByUserBorrowID($id)
{
	$query_ictitem = "SELECT userborrow_time_h, userborrow_time_m, userborrow_time_ap FROM sports.user_borrow WHERE userborrow_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['userborrow_time_h'] . ":" . $row_ictitem['userborrow_time_m'] . " " . $row_ictitem['userborrow_time_ap'];
}

function iconSportsApproval($id)
{
	if(checkSportsApprovalByUserBorrowID($id)==1)
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" alt=\"Approval\" align=\"absbottom\" />";
	else if(checkSportsApprovalByUserBorrowID($id)==2)
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_error.png\" alt=\"Pending\" align=\"absbottom\" />";
	else
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/lock.png\" alt=\"Lock\" border=\"0\" align=\"absbottom\" />";
}

function checkSportsApprovalByUserBorrowID($id)
{
	$query_ictitem = "SELECT ict_status FROM sports.user_borrow WHERE userborrow_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['ict_status'];
}

function iconSportsReturn($id)
{
	if(checkSportsReturnByUserBorrowID($id)==1 && checkSportsApprovalByUserBorrowID($id)==1)
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" alt=\"Approval\" align=\"absbottom\" />";
	else if(checkSportsReturnByUserBorrowID($id)==0 && checkSportsApprovalByUserBorrowID($id)==1)
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_error.png\" alt=\"Pending\" align=\"absbottom\" />";
	else if(checkSportsApprovalByUserBorrowID($id)==0)
		echo "-";
	else if(checkSportsApprovalByUserBorrowID($id)==2)
		echo "-";
}

function checkSportsReturnByUserBorrowID($id)
{
	$query_ictitem = "SELECT ict_return FROM sports.user_borrow WHERE userborrow_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['ict_return'];
}

function getLateByUserBorrowID($id)
{	
	$query_ictitem = "SELECT * FROM sports.user_borrow WHERE userborrow_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND userborrow_status = '1' AND ict_status = '1' AND ict_return='0' GROUP BY user_stafid ORDER BY userborrow_date_y DESC, userborrow_date_m DESC, userborrow_date_d DESC, userborrow_id DESC";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	if($row_ictitem['durationtype_id']==2)
		$day = $row_ictitem['userborrow_duration'];
	else if($row_ictitem['durationtype_id']==3)
		$day = $row_ictitem['userborrow_duration'] * 7;
	else if($row_ictitem['durationtype_id']==4)
		$day = $row_ictitem['userborrow_duration'] * 30;
	else if($row_ictitem['durationtype_id']==5)
		$day = $row_ictitem['userborrow_duration'] * 360;
	else
		$day = 1;
					
	$dend = date('d', mktime(0, 0, 0, $row_ictitem['userborrow_date_m'], $row_ictitem['userborrow_date_d']+$day, $row_ictitem['userborrow_date_y']));
	$mend = date('m', mktime(0, 0, 0, $row_ictitem['userborrow_date_m'], $row_ictitem['userborrow_date_d']+$day, $row_ictitem['userborrow_date_y']));
	$yend = date('Y', mktime(0, 0, 0, $row_ictitem['userborrow_date_m'], $row_ictitem['userborrow_date_d']+$day, $row_ictitem['userborrow_date_y']));
	
	$cday = ((mktime(0, 0, 0, date('m'), date('d'), date('Y')) - mktime(0, 0, 0, $mend, $dend, $yend))/86400);
	
	if($cday>0)
		return $cday;
	else
		return 0;
}

function getTotalItemBorrow($subcatid, $dmy='0')
{
	if($dmy != '0')
	{
		$dmy = explode('/', htmlspecialchars($dmy, ENT_QUOTES));
		$wsql = " AND user_borrow.userborrow_date_d = '" . $dmy[0] . "' AND user_borrow.userborrow_date_m = '" . $dmy[1] . "' AND user_borrow.userborrow_date_y = '" . $dmy[2] . "'";
	} else {
		$wsql = "";
	};
		
	$query_ictitem = "SELECT item.item_id FROM sports.item WHERE item_borrow = '1' AND subcategory_id = '" . htmlspecialchars($subcatid, ENT_QUOTES) . "' AND item_status = '1' AND NOT EXISTS (SELECT * FROM  sports.item_borrow LEFT JOIN sports.user_borrow ON user_borrow.userborrow_id = item_borrow.userborrow_id WHERE item_borrow.item_id = item.item_id AND itemborrow_status = '1' AND item_borrow.ict_return='0' AND user_borrow.ict_status != 2 " . $wsql  . " )";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	$total = mysql_num_rows($ictitem);
	
	return $total;
}

function getCategoryBySubCatID($id)
{
	$query_ictitem = "SELECT category_name FROM sports.subcategory LEFT JOIN sports.category ON subcategory.category_id = category.category_id WHERE subcategory_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['category_name'];
}

function countAmountBorrow($d, $m, $y)
{
	$wsql = "";
	
	if($d!=0)
		$wsql .= " AND userborrow_date_d = '" . htmlspecialchars($d, ENT_QUOTES) . "'";
	if($m!=0)
		$wsql .= " AND userborrow_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y!=0)
		$wsql .= " AND userborrow_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "'";
	
	$query_ictitem = "SELECT userborrow_id FROM sports.user_borrow WHERE userborrow_status = 1 " . $wsql . " ORDER BY userborrow_date_y DESC, userborrow_date_m DESC, userborrow_date_d DESC, userborrow_id DESC";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	$total = mysql_num_rows($ictitem);
	
	return $total;
}

function countAmountBorrowNeedApproval($d, $m, $y)
{
	$wsql = "";
	
	if($d!=0)
		$wsql .= " AND userborrow_date_d = '" . htmlspecialchars($d, ENT_QUOTES) . "'";
	if($m!=0)
		$wsql .= " AND userborrow_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y!=0)
		$wsql .= " AND userborrow_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "'";
	
	$query_ictitem = "SELECT userborrow_id FROM sports.user_borrow WHERE ict_status = 0 AND userborrow_status = 1 " . $wsql . " ORDER BY userborrow_date_y DESC, userborrow_date_m DESC, userborrow_date_d DESC, userborrow_id DESC";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	$total = mysql_num_rows($ictitem);
	
	return $total;
}

function getModelBySportsItemID($id)
{
	$query_ictitem = "SELECT item_model FROM sports.item WHERE item_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['item_model'];
}

function noteSports($id)
{
	if($id=='1')
		$msg = "<span class=\"inputlabel2 padt fl\">* Maklumat diperlukan</span>";
		
	return $msg;
}
//modul pinjaman
function checkUserSportsBorrowReturnDateByUserID($userid)
{
	$day2 = date('d', mktime(0, 0, 0, date('m'), date('d')-2, date('y')));
	$month2 = date('m', mktime(0, 0, 0, date('m'), date('d')-2, date('y')));
	$year2 = date('Y', mktime(0, 0, 0, date('m'), date('d')-2, date('y')));
	
	$query_ictitem = "SELECT COUNT(userborrow_id) AS count FROM sports.user_borrow WHERE userborrow_status = '1' AND user_stafid='" . htmlspecialchars($userid, ENT_QUOTES) . "' AND ict_status = '1' AND ict_return='0' AND userborrow_date_d <= '" . htmlspecialchars($day2, ENT_QUOTES) . "' AND userborrow_date_m <= '" . htmlspecialchars($month2, ENT_QUOTES) . "' AND userborrow_date_y <= '" . htmlspecialchars($year2, ENT_QUOTES) . "' GROUP BY user_stafid ORDER BY userborrow_date_y DESC, userborrow_date_m DESC, userborrow_date_d DESC, userborrow_id DESC";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	if($row_ictitem['count']>0)
	{
		$permis = true;
	} else {
		$permis = false;
	}
	
	return $permis;
}

function getTotalUserSportsBorrowByDate($user, $day, $month, $year)
{
	$query_ictitem = "SELECT userborrow_id FROM sports.user_borrow WHERE user_borrow.userborrow_status = '1' AND user_borrow.ict_status = '0' AND user_borrow.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userborrow_date_d = '" . htmlspecialchars($day, ENT_QUOTES) . "' AND userborrow_date_m = '" . htmlspecialchars($month, ENT_QUOTES) . "' AND userborrow_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' ORDER BY userborrow_date_y DESC, userborrow_date_m DESC, userborrow_date_d DESC, userborrow_id DESC";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	$total = mysql_num_rows($ictitem);
	
	return $total;
}

function getUserSportsBorrowIDByUserID($user, $day, $month, $year)
{
	$query_ictitem = "SELECT userborrow_id FROM sports.user_borrow WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userborrow_date_d = '" . htmlspecialchars($day, ENT_QUOTES) . "' AND userborrow_date_m = '" . htmlspecialchars($month, ENT_QUOTES) . "' AND userborrow_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' ORDER BY userborrow_date_y DESC, userborrow_date_m DESC, userborrow_date_d DESC, userborrow_id DESC";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['userborrow_id'];
}

function getDurationByUserSportsBorrowID($id)
{
	$query_ictitem = "SELECT userborrow_duration, durationtype_id FROM sports.user_borrow WHERE userborrow_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['userborrow_duration'] . " " . getDurationByID($row_ictitem['durationtype_id']);
}

function getSportsItemBrandNameByItemID($id)
{
	$query_ictitem = "SELECT brand_id FROM sports.item WHERE item_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return getSportsItemBrandNameByID($row_ictitem['brand_id']);
}

function getUserSportsIDByUserBorrowID($id)
{
	$query_ictitem = "SELECT user_stafid FROM sports.user_borrow WHERE userborrow_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['user_stafid'];
}

function getBorrowTitleByUserSportsBorrowID($id)
{
	$query_ictitem = "SELECT userborrow_title FROM sports.user_borrow WHERE userborrow_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['userborrow_title'];
}

function getBorrowLocationByUserSportsBorrowID($id)
{
	$query_ictitem = "SELECT userborrow_location FROM sports.user_borrow WHERE userborrow_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['userborrow_location'];
}

function getSubCategoryItemByUserBorrowID($id)
{
	//senarai item yg dipinjam dalam bentuk array merujuk pada UserBorrow_id
	$query_ictitem = "SELECT subcategory_id FROM sports.item_borrow WHERE userborrow_id='" . htmlspecialchars($id, ENT_QUOTES) . "' AND itemborrow_status = '1'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	$item = array();
	
	do {
		$item[] = $row_ictitem['subcategory_id'];
	} while($row_ictitem = mysql_fetch_assoc($ictitem));
	
	return $item;
}
?>

