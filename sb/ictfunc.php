<?php
//Email akses
function countDeActEmail()
{
	$query_ictitem = "SELECT user.* FROM user LEFT JOIN (SELECT * FROM user_unit WHERE user_unit.userunit_status = '1' ORDER BY user_unit.userunit_id) AS user_unit ON user_unit.user_stafid = user.user_stafid WHERE NOT EXISTS (SELECT * FROM login WHERE user.user_stafid = login.user_stafid) AND user_unit.userunit_status = '1' GROUP BY user.user_stafid ORDER BY user.user_firstname ASC, user.user_lastname ASC";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	$total = mysql_num_rows($ictitem);
	
	return $total;
}

//item

function getItemIDByItemBorrowID($itemborrowid)
{
	//senarai item yg dipinjam dalam bentuk array merujuk pada UserBorrow_id
	$query_ictitem = "SELECT item_id FROM ict.item_borrow WHERE itemborrow_id='" . htmlspecialchars($itemborrowid, ENT_QUOTES) . "' AND itemborrow_status = '1'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['item_id'];
}

function getItemISNSiriByID($id)
{
	$query_ictitem = "SELECT item_isnsirihi, item_isnsiriyear, item_isnsiri FROM ict.item WHERE item_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return getISNSiriHIByID($row_ictitem['item_isnsirihi']) . " / " . $row_ictitem['item_isnsiriyear'] . " / " . $row_ictitem['item_isnsiri'];
}

function getISNSiriHIByID($id)
{
	if($id=='H')
		$view = "H";
	else
		$view = "I";
	
	return $view;
}

function checkBorrowByItemID($id)
{
	$query_ictitem = "SELECT item_borrow FROM ict.item WHERE item_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	if($row_ictitem['item_borrow']==1)
		return true;
	else
		return false;
}

function getItemCategoryByID($id)
{
	$query_ictitem = "SELECT category_name FROM ict.category WHERE category_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['category_name'];
}

function getItemCategoryBySubCatID($id)
{
	$query_ictitem = "SELECT category_name FROM ict.subcategory LEFT JOIN ict.category ON subcategory.category_id = category.category_id WHERE subcategory_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['category_name'];
}

function getItemSubCategoryByID($id)
{
	$query_ictitem = "SELECT subcategory_name FROM ict.subcategory WHERE subcategory_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['subcategory_name'];
}

function getItemSubCategoryByItemID($id)
{
	$query_ictitem = "SELECT subcategory_id FROM ict.item WHERE item_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['subcategory_id'];
}

function getItemBrandNameByID($id)
{
	$query_ictitem = "SELECT brand_name FROM ict.brand WHERE brand_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['brand_name'];
}

function getItemBrandNameByItemID($id)
{
	$query_ictitem = "SELECT brand_id FROM ict.item WHERE item_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return getItemBrandNameByID($row_ictitem['brand_id']);
}

function getModelByItemID($id)
{
	$query_ictitem = "SELECT item_model FROM ict.item WHERE item_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['item_model'];
}

function checkItemComponentByItemID($id)
{
	$query_ictitem = "SELECT item_id FROM ict.item_component WHERE item_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	$total = mysql_num_rows($ictitem);
	
	if($total > 0)
		return true;
	else
		return false;
}

function getVendorTypeNameByID($id)
{
	$query_ictitem = "SELECT vendortype_name FROM ict.vendor_type WHERE vendortype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['vendortype_name'];
}

function getVendorTypeIDByVendorID($id)
{
	$query_ictitem = "SELECT vendortype_id FROM ict.vendor WHERE vendor_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['vendortype_id'];
}

function getVendorNameByID($id)
{
	$query_ictitem = "SELECT vendor_name FROM ict.vendor WHERE vendor_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['vendor_name'];
}

function getVendorAddByID($id)
{
	$query_ictitem = "SELECT vendor_add FROM ict.vendor WHERE vendor_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['vendor_add'];
}

function getVendorNoTelByID($id)
{
	$query_ictitem = "SELECT vendor_notel FROM ict.vendor WHERE vendor_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['vendor_notel'];
}

function getVendorNoFaxByID($id)
{
	$query_ictitem = "SELECT vendor_nofax FROM ict.vendor WHERE vendor_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['vendor_nofax'];
}

function getVendorEmailByID($id)
{
	$query_ictitem = "SELECT vendor_email FROM ict.vendor WHERE vendor_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['vendor_email'];
}

function getVendorWebByID($id)
{
	$query_ictitem = "SELECT vendor_web FROM ict.vendor WHERE vendor_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['vendor_web'];
}

function getExpireByItemID($id)
{
	//Tempoh Hayat
	$query_ictitem = "SELECT item_getdate_d, item_getdate_m, item_getdate_y FROM ict.item WHERE item_id = '" . $id . "'";
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

function getDurationTypeByID($id)
{
	$query_ictitem = "SELECT durationtype_name FROM ict.duration_type WHERE durationtype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['durationtype_name'];
}

function getItemAddByID($id)
{
	$query_ictitem = "SELECT itemadd_name FROM ict.item_add WHERE itemadd_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['itemadd_name'];
}

function getItemOSByID($id)
{
	$query_ictitem = "SELECT itemos_name FROM ict.item_os WHERE itemos_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['itemos_name'];
}

function getItemRAMByID($id)
{
	$query_ictitem = "SELECT itemram_name FROM ict.item_ram WHERE itemram_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['itemram_name'];
}
?>
<?php
// Pinjaman
function countTotalBorrowNeedApproval($d, $m, $y)
{
	$wsql = "";
	
	if($d!=0)
		$wsql .= " AND userborrow_date_d = '" . htmlspecialchars($d, ENT_QUOTES) . "'";
	if($m!=0)
		$wsql .= " AND userborrow_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y!=0)
		$wsql .= " AND userborrow_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "'";
	
	$query_ictitem = "SELECT userborrow_id FROM ict.user_borrow WHERE ict_status = 0 AND userborrow_status = 1 " . $wsql . " ORDER BY userborrow_date_y DESC, userborrow_date_m DESC, userborrow_date_d DESC, userborrow_id DESC";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	$total = mysql_num_rows($ictitem);
	
	return $total;
}

function countTotalBorrow($d, $m, $y)
{
	$wsql = "";
	
	if($d!=0)
		$wsql .= " AND userborrow_date_d = '" . htmlspecialchars($d, ENT_QUOTES) . "'";
	if($m!=0)
		$wsql .= " AND userborrow_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y!=0)
		$wsql .= " AND userborrow_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "'";
	
	$query_ictitem = "SELECT userborrow_id FROM ict.user_borrow WHERE userborrow_status = 1 " . $wsql . " ORDER BY userborrow_date_y DESC, userborrow_date_m DESC, userborrow_date_d DESC, userborrow_id DESC";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	$total = mysql_num_rows($ictitem);
	
	return $total;
}

function getUserBorrowIDByUserID($user, $day, $month, $year)
{
	$query_ictitem = "SELECT userborrow_id FROM ict.user_borrow WHERE user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userborrow_date_d = '" . htmlspecialchars($day, ENT_QUOTES) . "' AND userborrow_date_m = '" . htmlspecialchars($month, ENT_QUOTES) . "' AND userborrow_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' ORDER BY userborrow_date_y DESC, userborrow_date_m DESC, userborrow_date_d DESC, userborrow_id DESC";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['userborrow_id'];
}

function getTotalUserBorrowByDate($user, $day, $month, $year)
{
	$query_ictitem = "SELECT userborrow_id FROM ict.user_borrow WHERE user_borrow.userborrow_status = '1' AND user_borrow.ict_status = '0' AND user_borrow.user_stafid = '" . htmlspecialchars($user, ENT_QUOTES) . "' AND userborrow_date_d = '" . htmlspecialchars($day, ENT_QUOTES) . "' AND userborrow_date_m = '" . htmlspecialchars($month, ENT_QUOTES) . "' AND userborrow_date_y = '" . htmlspecialchars($year, ENT_QUOTES) . "' ORDER BY userborrow_date_y DESC, userborrow_date_m DESC, userborrow_date_d DESC, userborrow_id DESC";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	$total = mysql_num_rows($ictitem);
	
	return $total;
}

function getUserIDByUserBorrowID($id)
{
	$query_ictitem = "SELECT user_stafid FROM ict.user_borrow WHERE userborrow_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['user_stafid'];
}

function getTotalItemCanBorrow($subcatid, $dmy='0')
{
	if($dmy != '0')
	{
		$dmy = explode('/', htmlspecialchars($dmy, ENT_QUOTES));
		$wsql = " AND user_borrow.userborrow_date_d = '" . $dmy[0] . "' AND user_borrow.userborrow_date_m = '" . $dmy[1] . "' AND user_borrow.userborrow_date_y = '" . $dmy[2] . "'";
	} else {
		$wsql = "";
	};
		
	$query_ictitem = "SELECT item.item_id FROM ict.item WHERE item_borrow = '1' AND subcategory_id = '" . htmlspecialchars($subcatid, ENT_QUOTES) . "' AND item_status = '1' AND NOT EXISTS (SELECT * FROM ict.item_borrow LEFT JOIN ict.user_borrow ON user_borrow.userborrow_id = item_borrow.userborrow_id WHERE item_borrow.item_id = item.item_id AND itemborrow_status = '1' AND item_borrow.ict_return='0' AND user_borrow.ict_status != 2 " . $wsql  . " )";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	$total = mysql_num_rows($ictitem);
	
	return $total;
}

function getBorrowTitleByUserBorrowID($id)
{
	$query_ictitem = "SELECT userborrow_title FROM ict.user_borrow WHERE userborrow_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['userborrow_title'];
}

function getBorrowLocationByUserBorrowID($id)
{
	$query_ictitem = "SELECT userborrow_location FROM ict.user_borrow WHERE userborrow_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['userborrow_location'];
}

function getDateBorrowByUserBorrowID($id)
{
	$query_ictitem = "SELECT userborrow_date_d, userborrow_date_m, userborrow_date_y FROM ict.user_borrow WHERE userborrow_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return date('d / m / Y (D)', mktime(0 , 0, 0, $row_ictitem['userborrow_date_m'], $row_ictitem['userborrow_date_d'], $row_ictitem['userborrow_date_y']));
}

function getLateReturnByUserBorrowID($id)
{	
	$query_ictitem = "SELECT * FROM ict.user_borrow WHERE userborrow_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND userborrow_status = '1' AND ict_status = '1' AND ict_return='0' GROUP BY user_stafid ORDER BY userborrow_date_y DESC, userborrow_date_m DESC, userborrow_date_d DESC, userborrow_id DESC";
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

function getSubCategoryItemBorrowByUserBorrowID($id)
{
	//senarai item yg dipinjam dalam bentuk array merujuk pada UserBorrow_id
	$query_ictitem = "SELECT subcategory_id FROM ict.item_borrow WHERE userborrow_id='" . htmlspecialchars($id, ENT_QUOTES) . "' AND itemborrow_status = '1'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	$item = array();
	
	do {
		$item[] = $row_ictitem['subcategory_id'];
	} while($row_ictitem = mysql_fetch_assoc($ictitem));
	
	return $item;
}

function getItemBorrowByUserBorrowID($id)
{
	//senarai item yg dipinjam dalam bentuk array merujuk pada UserBorrow_id
	$query_ictitem = "SELECT item_id FROM ict.item_borrow WHERE userborrow_id='" . htmlspecialchars($id, ENT_QUOTES) . "' AND itemborrow_status = '1'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	$item = array();
	
	do {
		$item[] = $row_ictitem['item_id'];
	} while($row_ictitem = mysql_fetch_assoc($ictitem));
	
	return $item;
}

function getTimeBorrowByUserBorrowID($id)
{
	$query_ictitem = "SELECT userborrow_time_h, userborrow_time_m, userborrow_time_ap FROM ict.user_borrow WHERE userborrow_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['userborrow_time_h'] . ":" . $row_ictitem['userborrow_time_m'] . " " . $row_ictitem['userborrow_time_ap'];
}

function checkTimeBorrowNotPast($day, $month, $year)
{
	$query_ictitem = "SELECT userborrow_time_h, userborrow_time_m, userborrow_time_ap FROM ict.user_borrow WHERE userborrow_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['userborrow_time_h'] . ":" . $row_ictitem['userborrow_time_m'] . " " . $row_ictitem['userborrow_time_ap'];
}

function getDurationByUserBorrowID($id)
{
	$query_ictitem = "SELECT userborrow_duration, durationtype_id FROM ict.user_borrow WHERE userborrow_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['userborrow_duration'] . " " . getDurationTypeByID($row_ictitem['durationtype_id']);
}

function checkICTApprovalByUserBorrowID($id)
{
	$query_ictitem = "SELECT ict_status FROM ict.user_borrow WHERE userborrow_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['ict_status'];
}

function iconICTBorrowByItemID($id)
{
	if(checkBorrowByItemID($id))
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" alt=\"Approval\" align=\"absbottom\" />";
	else
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/lock.png\" alt=\"Lock\" border=\"0\" align=\"absbottom\" />";
}

function checkICTReturnByUserBorrowID($id)
{
	$query_ictitem = "SELECT ict_return FROM ict.user_borrow WHERE userborrow_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['ict_return'];
}

function iconICTApproval($id)
{
	if(checkICTApprovalByUserBorrowID($id)==1)
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" alt=\"Approval\" align=\"absbottom\" />";
	else if(checkICTApprovalByUserBorrowID($id)==2)
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_error.png\" alt=\"Pending\" align=\"absbottom\" />";
	else
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/lock.png\" alt=\"Lock\" border=\"0\" align=\"absbottom\" />";
}

function iconICTReturn($id)
{
	if(checkICTReturnByUserBorrowID($id)==1 && checkICTApprovalByUserBorrowID($id)==1)
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" alt=\"Approval\" align=\"absbottom\" />";
	else if(checkICTReturnByUserBorrowID($id)==0 && checkICTApprovalByUserBorrowID($id)==1)
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_error.png\" alt=\"Pending\" align=\"absbottom\" />";
	else if(checkICTApprovalByUserBorrowID($id)==0)
		echo "-";
	else if(checkICTApprovalByUserBorrowID($id)==2)
		echo "-";
}

function checkUserBorrowReturnDateByUserID($userid)
{
	$day2 = date('d', mktime(0, 0, 0, date('m'), date('d')-2, date('y')));
	$month2 = date('m', mktime(0, 0, 0, date('m'), date('d')-2, date('y')));
	$year2 = date('Y', mktime(0, 0, 0, date('m'), date('d')-2, date('y')));
	
	$query_ictitem = "SELECT COUNT(userborrow_id) AS count FROM ict.user_borrow WHERE userborrow_status = '1' AND user_stafid='" . htmlspecialchars($userid, ENT_QUOTES) . "' AND ict_status = '1' AND ict_return='0' AND userborrow_date_d <= '" . htmlspecialchars($day2, ENT_QUOTES) . "' AND userborrow_date_m <= '" . htmlspecialchars($month2, ENT_QUOTES) . "' AND userborrow_date_y <= '" . htmlspecialchars($year2, ENT_QUOTES) . "' GROUP BY user_stafid ORDER BY userborrow_date_y DESC, userborrow_date_m DESC, userborrow_date_d DESC, userborrow_id DESC";
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
?>
<?php
//pinjaman 2
function checkItemAvailableByItemID($id)
{
	$query_ictitem = "SELECT COUNT(itemborrow_id) AS count FROM ict.item_borrow WHERE item_borrow.itemborrow_status = 1 AND item_borrow.item_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND item_borrow.userborrow_type = 1 AND item_borrow.ict_return = 0 GROUP BY item_borrow.itemborrow_id";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	if($row_ictitem['count']==0)
		return true;
	else
		return false;	
}

function iconItemAvailableByItemID($id)
{
	if(!checkItemAvailableByItemID($id) && !checkBorrowByItemID($id))
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" alt=\"Approval\" align=\"absbottom\" />";
	else if(checkBorrowByItemID($id))
		echo "-";
	else
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick2.png\" alt=\"Approval\" align=\"absbottom\" />";
}
?>
<?php
//Aduan
function countReportNeedApproval($d, $m, $y)
{
	$wsql = "";
	if($d!=0)
		$wsql .= " AND userreport_date_d = '" . htmlspecialchars($d, ENT_QUOTES) . "'";
	if($m!=0)
		$wsql .= " AND userreport_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y!=0)
		$wsql .= " AND userreport_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "'";
		
	$query_ictitem = "SELECT user_report.* FROM ict.user_report WHERE user_report.userreport_result = 0 AND user_report.userreport_status = 1 AND NOT EXISTS (SELECT user_reportfeedback.* FROM ict.user_reportfeedback WHERE user_reportfeedback.feedbacktype_id = 0 AND user_reportfeedback.userreport_id = user_report.userreport_id GROUP BY user_reportfeedback.userreport_id) " . $wsql;
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	$total = mysql_num_rows($ictitem);
	
	return $total;
}

function countTotalReport($d, $m, $y)
{
	$wsql = "";
	if($d!=0)
		$wsql .= " AND userreport_date_d = '" . htmlspecialchars($d, ENT_QUOTES) . "'";
	if($m!=0)
		$wsql .= " AND userreport_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y!=0)
		$wsql .= " AND userreport_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "'";
		
	$query_ictitem = "SELECT user_report.* FROM ict.user_report WHERE user_report.userreport_result = 0 AND user_report.userreport_status = 1 " . $wsql;
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	$total = mysql_num_rows($ictitem);
	
	return $total;
}

function getReportTypeByID($id)
{
	if($id!=0)
	{
		$query_ictitem = "SELECT reporttype_name FROM ict.report_type WHERE reporttype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
		$ictitem = mysql_query($query_ictitem);
		$row_ictitem = mysql_fetch_assoc($ictitem);
		
		$view = $row_ictitem['reporttype_name'];
	} else {
		$view = "Lain - lain";
	}
	return $view;
}

function getReportSubTypeByID($id)
{
	if($id!=0)
	{
		$query_ictitem = "SELECT reportsubtype_name FROM ict.report_subtype WHERE reportsubtype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
		$ictitem = mysql_query($query_ictitem);
		$row_ictitem = mysql_fetch_assoc($ictitem);
		
		$view = $row_ictitem['reportsubtype_name'];
	} else {
		$view = "Lain - lain";
	}
	
	return $view;
}

function getUserReportByReportID($id)
{
	$query_ictitem = "SELECT user_stafid FROM ict.user_report WHERE userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['user_stafid'];
}

function getReportSymptomByID($id)
{
	$query_ictitem = "SELECT reportsymptom_question FROM ict.report_symptom WHERE reportsymptom_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return htmlspecialchars_decode($row_ictitem['reportsymptom_question']);
}

function getReportTypeBySymptomID($id)
{
	$query_ictitem = "SELECT reporttype_id FROM ict.report_symptom WHERE reportsymptom_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['reporttype_id'];
}

function getReportSubTypeBySymptomID($id)
{
	$query_ictitem = "SELECT reportsubtype_id FROM ict.report_symptom WHERE reportsymptom_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['reportsubtype_id'];
}

function getUserReportIDByUserID($userid, $symptomid, $d, $m, $y)
{
	$query_ictitem = "SELECT userreport_id FROM ict.user_report WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND reportsymptom_id = '" . htmlspecialchars($symptomid, ENT_QUOTES) . "' AND userreport_date_d = '" . htmlspecialchars($d, ENT_QUOTES) . "' AND userreport_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "' AND userreport_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "' GROUP BY user_stafid";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['userreport_id'];
}

function getReportDateByID($id)
{
	$query_ictitem = "SELECT userreport_date_d, userreport_date_m, userreport_date_y FROM ict.user_report WHERE userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return date('d / m / Y (D)', mktime(0, 0, 0, $row_ictitem['userreport_date_m'], $row_ictitem['userreport_date_d'], $row_ictitem['userreport_date_y']));
}

function getReportDateDMYByID($id, $dmy)
{
	$query_ictitem = "SELECT userreport_date_d, userreport_date_m, userreport_date_y FROM ict.user_report WHERE userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	if($dmy==1)
		return date('d', mktime(0, 0, 0, $row_ictitem['userreport_date_m'], $row_ictitem['userreport_date_d'], $row_ictitem['userreport_date_y']));
	elseif($dmy==2)
		return date('m', mktime(0, 0, 0, $row_ictitem['userreport_date_m'], $row_ictitem['userreport_date_d'], $row_ictitem['userreport_date_y']));
	elseif($dmy==3)
		return date('Y', mktime(0, 0, 0, $row_ictitem['userreport_date_m'], $row_ictitem['userreport_date_d'], $row_ictitem['userreport_date_y']));
}

function checkReportTodayByUserID($userid, $symptom)
{
	$query_ictitem = "SELECT COUNT(userreport_id) AS count FROM ict.user_report WHERE user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND reportsymptom_id = '" . htmlspecialchars($symptom, ENT_QUOTES) . "' AND userreport_date_d = '" . date('d') . "' AND userreport_date_m = '" . date('m') . "' AND userreport_date_y = '" . date('Y') . "' AND userreport_status = 1 GROUP BY user_stafid";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	if($row_ictitem['count']>0)
		return true;
	else
		return false;
}

function checkTotalReportPerDayByUserID($userid)
{
	$query_ictitem = "SELECT COUNT(userreport_id) AS count FROM ict.user_report WHERE userreport_status = '1' AND user_stafid='" . htmlspecialchars($userid, ENT_QUOTES) . "' AND userreport_date_d = '" . date('d') . "' AND userreport_date_m = '" . date('m') . "' AND userreport_date_y = '" . date('Y') . "' GROUP BY user_stafid";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	if($row_ictitem['count']<5) //3kali aduan per day
	{
		return true;
	} else {
		return false;
	}
}

function getFeedbackDayLong($urid)
{
	$query_ictitem = "SELECT urf_date_d, urf_date_m, urf_date_y, urf_date_h FROM ict.user_reportfeedback WHERE userreport_id = '" . htmlspecialchars($urid, ENT_QUOTES) . "' ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC LIMIT 1";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	$total = mysql_num_rows($ictitem);
	
	if($total > 0)
		$day = round(abs(mktime(0, 0, 0, $row_ictitem['urf_date_m'], $row_ictitem['urf_date_d'], $row_ictitem['urf_date_y']) - mktime(0, 0, 0, date('m'), date('d'), date('Y'))) / 86400 );
	else
		$day = round(abs(mktime(0, 0, 0, getReportDateDMYByID($urid, 2), getReportDateDMYByID($urid, 1), getReportDateDMYByID($urid, 3)) - mktime(0, 0, 0, date('m'), date('d'), date('Y'))) / 86400 );
		
	return $day;
}

function checkFeedbackApprovalByUserID($userid)
{
	$query_ictitem = "SELECT user_report.userreport_id FROM ict.user_report LEFT JOIN ict.user_reportfeedback ON user_reportfeedback.userreport_id = user_report.userreport_id WHERE user_reportfeedback.feedbacktype_id = '0' AND user_report.userreport_star = '0' AND user_report.userreport_status = '1' AND user_report.user_stafid='" . htmlspecialchars($userid, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	$total = mysql_num_rows($ictitem);
	
	return $total;
}

function getFeedbackTypeByID($id)
{
	$query_ictitem = "SELECT feedbacktype_id, feedbacktype_name FROM ict.feedback_type WHERE feedbacktype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	if($row_ictitem['feedbacktype_id']==0)
		$view = "Tamat";
	else
		$view = $row_ictitem['feedbacktype_name'];
		
	return $view;
}

function getFeedbackDateByUserReportID($urid, $urfid)
{
	$query_ictitem = "SELECT urf_date_d, urf_date_m, urf_date_y, urf_date_h FROM ict.user_reportfeedback WHERE urf_id = '" . htmlspecialchars($urfid, ENT_QUOTES) . "' AND userreport_id = '" . $urid . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return date('d / m / Y (D)', mktime(0, 0, 0, $row_ictitem['urf_date_m'], $row_ictitem['urf_date_d'], $row_ictitem['urf_date_y'])) . " " . $row_ictitem['urf_date_h'];
}

function checkFeedbackInWeek($urid)
{
	$day = getFeedbackDayLong($urid);
			
	if($day%7==0)
		return true;
	else
		return false;
}

function checkFeedbackEndByUserReportID($id)
{
	$query_ictitem = "SELECT urf_id FROM ict.user_reportfeedback WHERE urf_status = 1 AND userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND feedbacktype_id = '0'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	$total = mysql_num_rows($ictitem);
	
	if($total>0)
		return true;
	else
		return false;
}

function getTotalFeedbackByUserReportID($id)
{
	$query_ictitem = "SELECT urf_stafid FROM ict.user_reportfeedback WHERE urf_status = 1 AND userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC LIMIT 1";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	$total = mysql_num_rows($ictitem);

	return $total;
}

function getLastFeedbackUserIDByUserReportID($id)
{
	$query_ictitem = "SELECT urf_by FROM ict.user_reportfeedback WHERE urf_status = 1 AND userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC LIMIT 1";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);

	return $row_ictitem['urf_by'];
}

function getLastFeedbackNoteByUserReportID($id)
{
	$query_ictitem = "SELECT urf_note FROM ict.user_reportfeedback WHERE urf_status = 1 AND userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC LIMIT 1";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);

	return $row_ictitem['urf_note'];
}

function getLastFeedbackToUserIDByUserReportID($id)
{
	$query_ictitem = "SELECT urf_stafid FROM ict.user_reportfeedback WHERE urf_status = 1 AND userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC LIMIT 1";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);

	return $row_ictitem['urf_stafid'];
}

function getLastFeedbackDateByUserReportID($id)
{
	$query_ictitem = "SELECT urf_date_d, urf_date_m, urf_date_y FROM ict.user_reportfeedback WHERE urf_status = 1 AND userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC LIMIT 1";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	$total = mysql_num_rows($ictitem);

	return date('d / m / Y (D)', mktime(0, 0, 0, $row_ictitem['urf_date_m'], $row_ictitem['urf_date_d'], $row_ictitem['urf_date_y']));
}

function getFeedbackActionNoteByUserReportID($id)
{
	$query_ictitem = "SELECT urf_note FROM ict.user_reportfeedback WHERE urf_status = 1 AND userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC LIMIT 1";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);

	return $row_ictitem['urf_note'];
}

function getFeedbackActionUserIDByUserReportID($id)
{
	$query_ictitem = "SELECT urf_by FROM ict.user_reportfeedback WHERE urf_status = 1 AND userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY urf_date_y DESC, urf_date_m DESC, urf_date_d DESC, urf_id DESC LIMIT 1";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);

	return $row_ictitem['urf_by'];
}

function getFeedbackEndDateByUserReportID($id, $view)
{
	$query_ictitem = "SELECT urf_date_d, urf_date_m, urf_date_y FROM ict.user_reportfeedback WHERE urf_status = 1 AND userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND feedbacktype_id = '0'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	$total = mysql_num_rows($ictitem);
	
	if($view==1)
		return $row_ictitem['urf_date_d'];
	else if($view==2)
		return $row_ictitem['urf_date_m'];
	else if($view==3)
		return $row_ictitem['urf_date_y'];
}

function getFeedbackEndWithPembekalanByUserReportFeedbackID($id)
{
	$query_ictitem = "SELECT urf_pembekalan FROM ict.user_reportfeedback WHERE urf_status = 1 AND urf_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND feedbacktype_id = '0'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	if($row_ictitem['urf_pembekalan']!=NULL)
		return $row_ictitem['urf_pembekalan'];
	else
		return 0;
}

function checkFeedbackApprovalByUserReportID($id)
{
	$query_ictitem = "SELECT userreport_id FROM ict.user_report WHERE userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND userreport_star > '0'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	$total = mysql_num_rows($ictitem);
	
	if($total>0 && checkFeedbackEndByUserReportID($id))
		return true;
	else
		return false;
}

function iconFeedbackStatusByUserReportID($id)
{
	if(checkFeedbackEndByUserReportID($id))
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" alt=\"Approval\" align=\"absbottom\" />";
	elseif(getTotalFeedbackByUserReportID($id)==0)
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_error.png\" alt=\"Pending\" align=\"absbottom\" />";
	else
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/lock.png\" alt=\"Pending\" align=\"absbottom\" />";
}

function iconFeedbackApprovalByUserReportID($id)
{
	if(checkFeedbackApprovalByUserReportID($id))
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" alt=\"Approval\" align=\"absbottom\" />";
	else
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/lock.png\" alt=\"Pending\" align=\"absbottom\" />";
}
?>
<?php 
function getTotalReportTypeByMonth($rtid, $m, $y)
{
	if($rtid != 0)
		$wsql = " AND report_symptom.reporttype_id = '" . htmlspecialchars($rtid, ENT_QUOTES) . "'";
	else
		$wsql = "";
		
	$query_ictitem = "SELECT userreport_id FROM ict.user_report LEFT JOIN ict.report_symptom ON report_symptom.reportsymptom_id = user_report.reportsymptom_id WHERE user_report.userreport_date_m='" . htmlspecialchars($m, ENT_QUOTES) . "' AND user_report.userreport_date_y='" . htmlspecialchars($y, ENT_QUOTES) . "' " . $wsql . " AND user_report.userreport_status='1' AND userreport_result='0'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	$total = mysql_num_rows($ictitem);
	
	return $total;
}

function getStarRatingByUserID($userid, $m, $y)
{
	$wsql = "";
	if($m!= 0)
		$wsql .= " AND user_report.userreport_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y!=0)
		$wsql .= " AND user_report.userreport_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "'";
		
	$query_ictitem = "SELECT SUM(user_report.userreport_star) AS totalstar FROM ict.user_report LEFT JOIN ict.user_reportfeedback ON user_reportfeedback.userreport_id = user_report.userreport_id WHERE user_reportfeedback.urf_status = 1 AND user_reportfeedback.feedbacktype_id = '0' AND user_report.userreport_star > 0 AND user_reportfeedback.urf_by = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND user_report.userreport_status='1' " . $wsql . " GROUP BY user_reportfeedback.urf_by";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	if($row_ictitem['totalstar']!=NULL)
		return $row_ictitem['totalstar'];
	else
		return 0;
}

function getTotalReportByUserID($userid, $m, $y)
{
	$wsql = "";
	if($userid != '0')
		$wsql .= " AND user_reportfeedback.urf_by = '" . htmlspecialchars($userid, ENT_QUOTES) . "'";
	if($m != '0')
		$wsql .= " AND user_report.userreport_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y !='0')
		$wsql .= " AND user_report.userreport_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "'";
		
	$query_ictitem = "SELECT COUNT(user_report.userreport_star) AS totalstar FROM ict.user_report LEFT JOIN ict.user_reportfeedback ON user_reportfeedback.userreport_id = user_report.userreport_id WHERE user_reportfeedback.urf_status = 1 AND user_reportfeedback.feedbacktype_id = '0' AND user_report.userreport_status='1' " . $wsql . " GROUP BY user_reportfeedback.urf_by";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	if($row_ictitem['totalstar']!=NULL)
		return $row_ictitem['totalstar'];
	else
		return 0;
}

function getTotalStarRatingByUserID($userid, $m, $y)
{
	$wsql = "";
	if($m!= 0)
		$wsql .= " AND user_report.userreport_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y!=0)
		$wsql .= " AND user_report.userreport_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "'";
		
	$query_ictitem = "SELECT COUNT(user_report.userreport_star) AS totalstar FROM ict.user_report LEFT JOIN ict.user_reportfeedback ON user_reportfeedback.userreport_id = user_report.userreport_id WHERE user_reportfeedback.urf_status = 1 AND user_reportfeedback.feedbacktype_id = '0' AND user_reportfeedback.urf_by = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND user_report.userreport_status='1' " . $wsql . " GROUP BY user_reportfeedback.urf_by";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return ($row_ictitem['totalstar']*5);
}

function getPercStarRatingByUserID($userid, $m, $y)
{
	$total = getTotalStarRatingByUserID($userid, $m, $y);
	
	if($total!=0)
		$perc = ((getStarRatingByUserID($userid, $m, $y)/$total)*100);
	else
		$perc = 0;
		
	return $perc;
}

function getTotalReportFeedbackBy1DayByUserID($userid, $m, $y, $daytype)
{
	$wsql = "";
	
	if($userid != '0')
		$wsql .= " AND user_reportfeedback.urf_by = '" . htmlspecialchars($userid, ENT_QUOTES) . "'";
	if($m != '0')
		$wsql .= " AND user_report.userreport_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y != '0')
		$wsql .= " AND user_report.userreport_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "'";
		
	$query_ictitem = "SELECT userreport_date_d, userreport_date_m, userreport_date_y, urf_date_d, urf_date_m, urf_date_y FROM ict.user_report LEFT JOIN ict.user_reportfeedback ON user_reportfeedback.userreport_id = user_report.userreport_id WHERE user_reportfeedback.urf_status = 1 AND user_reportfeedback.feedbacktype_id = '0'  AND user_report.userreport_status='1' " . $wsql;
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	$totalall = mysql_num_rows($ictitem);
	
	$total = 0;
	
	if($totalall>0)
	{
		do {
		$day = round(abs(mktime(0, 0, 0, $row_ictitem['urf_date_m'], $row_ictitem['urf_date_d'], $row_ictitem['urf_date_y']) - mktime(0, 0, 0, $row_ictitem['userreport_date_m'], $row_ictitem['userreport_date_d'], $row_ictitem['userreport_date_y'])) / 86400);
		
		if($daytype=='1' && $day==0)
			$total+=1;
		else if($daytype=='3' && ($day>0 && $day<=2))
			$total+=1;
		else if($daytype=='7' && ($day>2 && $day<=6))
			$total+=1;
		else if($daytype=='8' && $day>=7)
			$total+=1;
		} while($row_ictitem = mysql_fetch_assoc($ictitem));
	};
	
	return $total;
}
?>
<?php
//status kelulusan permohonan
function iconApplyStatus($id)
{
	if(checkApplyStatusByID($id)==1)
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" alt=\"Approval\" align=\"absbottom\" />";
	else 
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/lock.png\" alt=\"Pending\" align=\"absbottom\" />";
}

function checkApplyStatusByID($id)
{
	$query_ictitem = "SELECT ict_status FROM ict.user_apply WHERE userapply_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['ict_status'];
}

function getUserIDByItemID($id)
{
	$query_ictitem = "SELECT user_stafid FROM ict.user_applyitem WHERE uai_id='" . htmlspecialchars($id, ENT_QUOTES) . "' AND uai_status=1";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['user_stafid'];
}
	
function getApplyIDByItemID($id)
{
	$query_ictitem = "SELECT userapply_id FROM ict.user_applyitem WHERE uai_id='" . htmlspecialchars($id, ENT_QUOTES) . "' AND uai_status=1";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['userapply_id'];
}

function getApplyIDByStaffID($userid, $d, $m, $y)
{
	$query_ictitem = "SELECT userapply_id FROM ict.user_apply WHERE userapply_by = '" . htmlspecialchars($userid, ENT_QUOTES) ."' AND userapply_date_d = '" .htmlspecialchars($d, ENT_QUOTES). "' AND userapply_date_m = '" .htmlspecialchars($m, ENT_QUOTES). "' AND userapply_date_y = '" .htmlspecialchars($y, ENT_QUOTES). "' AND userapply_status=1 ORDER BY userapply_id DESC";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['userapply_id'];
}
	
function getApplyNoteByID($id)
{
	$query_ictitem = "SELECT userapply_note FROM ict.user_apply WHERE userapply_id='" . htmlspecialchars($id, ENT_QUOTES) . "' AND userapply_status=1";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['userapply_note'];
}

function getApplyDateByApplyID($id)
{
	$query_ictitem = "SELECT userapply_date_d , userapply_date_m, userapply_date_y FROM ict.user_apply WHERE userapply_id = '".htmlspecialchars($id, ENT_QUOTES)."' AND userapply_status=1";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return date('d / m / Y (D)', mktime(0,0,0, $row_ictitem['userapply_date_m'],$row_ictitem['userapply_date_d'], $row_ictitem['userapply_date_y']));
}
	
function getStafIDByApplyID($id)
{
	$query_ictitem = "SELECT userapply_by FROM ict.user_apply WHERE userapply_id='" . htmlspecialchars($id, ENT_QUOTES) . "' AND userapply_status=1";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['userapply_by'];
}
	
function getStatusByID($id)
{
	$query_ictitem = "SELECT applystatus_id FROM ict.user_applyitem WHERE uai_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	if($row_ictitem['applystatus_id']!=0)
		return $row_ictitem['applystatus_id'];
	else
		return 0;
}

function getStatusNameByID($id)
{
	if($id!=0)
	{
		$query_ictitem = "SELECT applystatus_name FROM ict.apply_status WHERE applystatus_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
		$ictitem = mysql_query($query_ictitem);
		$row_ictitem = mysql_fetch_assoc($ictitem);
	
		$view = $row_ictitem['applystatus_name'];
	} else {
		$view = "Dalam Proses";
	}
	
	return $view;
}
	
function getICTNoteByID($id)
{
	$query_ictitem = "SELECT ict_note FROM ict.user_applyitem WHERE uai_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['ict_note'];
}

function getReqTypeNameByReqID($id)
{
	$query_ictitem = "SELECT reqtype_name FROM ict.req_type WHERE reqtype_id = '" .htmlspecialchars($id, ENT_QUOTES)."' AND reqtype_status= 1";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	return $row_ictitem['reqtype_name'];
}	
	
function countTotalStafByApplyID($id)
{
	$query_ictitem = "SELECT uai_id FROM ict.user_applyitem WHERE uai_status = 1 AND userapply_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	$total = mysql_num_rows($ictitem);
	
	return $total;
}	
	
function countTotalApplyNeedApproval($d=0, $m=0, $y=0)
{
	$wsql = "";
	
	if($d!=0)
		$wsql .= " AND user_apply.userapply_date_d = '" . htmlspecialchars($d, ENT_QUOTES) . "'";
	if($m!=0)
		$wsql .= " AND user_apply.userapply_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y!=0)
		$wsql .= " AND user_apply.userapply_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "'";
	
	$query_ictitem = "SELECT userapply_id FROM ict.user_apply WHERE user_apply.ict_status = 0 AND user_apply.userapply_status = 1 " . $wsql . " ORDER BY user_apply.userapply_date_y DESC, user_apply.userapply_date_m DESC, user_apply.userapply_date_d DESC, user_apply.userapply_id DESC";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	$total = mysql_num_rows($ictitem);
	
	return $total;
}	
	
function countTotalApply($d=0, $m=0, $y=0)
{
	$wsql = "";
	
	if($d!=0)
		$wsql .= " AND user_apply.userapply_date_d = '" . htmlspecialchars($d, ENT_QUOTES) . "'";
	if($m!=0)
		$wsql .= " AND user_apply.userapply_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y!=0)
		$wsql .= " AND user_apply.userapply_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "'";
	
	$query_ictitem = "SELECT userapply_id FROM ict.user_apply WHERE user_apply.userapply_status = 1 " . $wsql . " ORDER BY user_apply.userapply_date_y DESC, user_apply.userapply_date_m DESC, user_apply.userapply_date_d DESC, user_apply.userapply_id DESC";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);
	
	$total = mysql_num_rows($ictitem);
	
	return $total;
}
?>
<?php
// note
function noteICT($id)
{
	if($id=='1')
		$msg = "<span class=\"inputlabel2 padt fl\">* Maklumat diperlukan</span>";
		
	return $msg;
}
?>
<?php
//green IT
function countTotalAksesByDate($d, $m, $y)
{
	$wsql = "";
	
	if($d!=0)
		$wsql .= " AND prolog_d = '" . htmlspecialchars($d, ENT_QUOTES) . "'";
	if($m!=0)
		$wsql .= " AND prolog_m = '" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y!=0)
		$wsql .= " AND prolog_y = '" . htmlspecialchars($y, ENT_QUOTES) . "'";
		
	$query_sys = "SELECT prolog_d, prolog_m, prolog_y, COUNT(prolog_id) AS total FROM sysaudit.pro_log WHERE sys_id = '1' " . $wsql . " GROUP BY prolog_y, prolog_m, prolog_d, user_stafid";
	$sys = mysql_query($query_sys);
	$row_sys = mysql_fetch_assoc($sys);
	
	$total = mysql_num_rows($sys);
	
	return $total;
};

function percAksesByDate($d, $m, $y)
{
	if(totalStaff($d, $m, $y)!=0)
	{
		$total = (date('t')*totalStaff($d, $m, $y));
		$perc = round((countTotalAksesByDate($d, $m, $y) / $total)*100);
		
	} else
		$perc = 0;
		
	return $perc;
};
?>
<?php
//Perkhidmatan ICT
function getServiceTypeByID($id)
{
	$query_type = "SELECT servicetype_id, servicetype_name FROM ict.service_type WHERE servicetype_id = '" . htmlspecialchars($id,ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);

	return $row_type['servicetype_name'];
}

function getServiceDateByID($sid)
{		
	$query_ss = "SELECT service_date_d, service_date_m, service_date_y FROM ict.service WHERE service_status = '1' AND service_id = '" . htmlspecialchars($sid, ENT_QUOTES) . "' ORDER BY service_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['service_date_m'], $row_ss['service_date_d'], $row_ss['service_date_y']));
}

function getServiceByByID($sid)
{		
	$query_ss = "SELECT service_by FROM ict.service WHERE service_status = '1' AND service_id = '" . htmlspecialchars($sid, ENT_QUOTES) . "' ORDER BY service_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['service_by'];
}

function getServiceTitleByID($sid)
{		
	$query_ss = "SELECT service_title FROM ict.service WHERE service_status = '1' AND service_id = '" . htmlspecialchars($sid, ENT_QUOTES) . "' ORDER BY service_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['service_title'];
}

function getServiceTypeNameByID($stid)
{		
	$query_ss = "SELECT servicetype_name FROM ict.service_type WHERE servicetype_status = '1' AND servicetype_id = '" . htmlspecialchars($stid, ENT_QUOTES) . "' ORDER BY servicetype_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['servicetype_name'];
}

function getServiceStartDateByID($sid)
{		
	$query_ss = "SELECT service_start_date_d, service_start_date_m, service_start_date_y FROM ict.service WHERE service_status = '1' AND service_id = '" . htmlspecialchars($sid, ENT_QUOTES) . "' ORDER BY service_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return date('d / m / Y', mktime(0, 0, 0, $row_ss['service_start_date_m'], $row_ss['service_start_date_d'], $row_ss['service_start_date_y']));
}

 function getServiceEndDateByID($sid)
{		
	$query_ss = "SELECT service_end_date_d, service_end_date_m, service_end_date_y FROM ict.service WHERE service_status = '1' AND service_id = '" . htmlspecialchars($sid, ENT_QUOTES) . "' ORDER BY service_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return date('d / m / Y', mktime(0, 0, 0, $row_ss['service_end_date_m'], $row_ss['service_end_date_d'], $row_ss['service_end_date_y']));
}

function getCountDownByServiceID($sid)
{
	//count down sebelum tamat tempoh
	$query_ss = "SELECT service_end_date_d, service_end_date_m, service_end_date_y FROM ict.service WHERE service_id = '" . $sid . "' AND service_status = '1' ORDER BY service_end_date_y DESC, service_end_date_m DESC, service_end_date_d DESC, service_id DESC";
	$ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($ss);
	
	$date1=  date('Y-m-d ', mktime(0,0,0,$row_ss['service_end_date_m'], $row_ss['service_end_date_d'], $row_ss['service_end_date_y']));
	
	$date2=  date('Y-m-d', mktime(0,0,0, date('m'),date('d'), date('Y')));
	if($row_ss['service_end_date_y']>= date('Y') && $row_ss['service_end_date_m']>= date('m'))
	{
	$diff = abs(strtotime($date1) - strtotime($date2));
	
	$years = floor($diff / (365*60*60*24));
	
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	
	if($years != 0 || $months != 0 || $days != 0)
		$view = $years . "T ". $months . "B ". $days . "H ";
	else
		$view = "TAMAT";
	
	} else 
	$view = "TAMAT";
	
	return $view;
}

function checkEndDateService($serviceid)
{
	$query_ss = "SELECT service_end_date_d, service_end_date_m, service_end_date_y FROM ict.service WHERE service_status = '1' AND service_id = '" . htmlspecialchars($serviceid, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$enddate = false;
	
	if(date('Y')<=$row_ss['service_end_date_y'])
	{
		if(date('m')==$row_ss['service_end_date_m'] && date('d')<=$row_ss['service_end_date_d'])
			$enddate = true;
		else if(date('m')<$row_ss['service_end_date_m'])
			$enddate = true;
	}
				
	return $enddate;
}
?>