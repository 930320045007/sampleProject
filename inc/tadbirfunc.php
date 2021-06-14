<?php
//book
function checkHallByDate($d, $m, $y, $hallid, $sesim, $sesino, $sesini)
{
	$wsql = "";
	if($d != 0)
		$wsql .= " AND hallbook_start_d='" . htmlspecialchars($d, ENT_QUOTES) . "'";
	if($m != 0)
		$wsql .= " AND hallbook_start_m='" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y != 0)
		$wsql .= " AND hallbook_start_y='" . htmlspecialchars($y, ENT_QUOTES) . "'";
	if($hallid != 0)
		$wsql .= " AND hall_id='" . htmlspecialchars($hallid, ENT_QUOTES) . "'";
	if($sesim != 0)
		$wsql .= " AND hallbook_morning='" . htmlspecialchars($sesim, ENT_QUOTES) . "'";
	if($sesino != 0)
		$wsql .= " AND hallbook_noon='" . htmlspecialchars($sesino, ENT_QUOTES) . "'";
	if($sesini != 0)
		$wsql .= " AND hallbook_night='" . htmlspecialchars($sesini, ENT_QUOTES) . "'";
		
	$query_ss = "SELECT hall_book.hallbook_id FROM tadbir.hall_book WHERE hallbook_status = '1' " . $wsql . " ORDER BY hallbook_id DESC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	  
	if($total > 0)
	  	return true;
	else
		return false;
}

function checkHallFullBook($d, $m, $y, $hallid)
{	
	$wsql = "";
	if($d != 0)
		$wsql .= " AND hallbook_start_d='" . htmlspecialchars($d, ENT_QUOTES) . "'";
	if($m != 0)
		$wsql .= " AND hallbook_start_m='" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y != 0)
		$wsql .= " AND hallbook_start_y='" . htmlspecialchars($y, ENT_QUOTES) . "'";
	if($hallid != 0)
		$wsql .= " AND hall_id='" . htmlspecialchars($hallid, ENT_QUOTES) . "'";
		
	$query_ss = "SELECT hall_book.hallbook_id FROM tadbir.hall_book WHERE hallbook_status = '1' " . $wsql . " GROUP BY hall_id ORDER BY hallbook_id DESC";
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total >=3 )
		return true;
	else
		return false;
}

function getBookName($d, $m, $y, $hallid, $sesim, $sesino, $sesini)
{
	$wsql = "";
	if($d != 0)
		$wsql .= " AND hallbook_start_d='" . htmlspecialchars($d, ENT_QUOTES) . "'";
	if($m != 0)
		$wsql .= " AND hallbook_start_m='" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y != 0)
		$wsql .= " AND hallbook_start_y='" . htmlspecialchars($y, ENT_QUOTES) . "'";
	if($hallid != 0)
		$wsql .= " AND hall_id='" . htmlspecialchars($hallid, ENT_QUOTES) . "'";
	if($sesim != 0)
		$wsql .= " AND hallbook_morning='" . htmlspecialchars($sesim, ENT_QUOTES) . "'";
	if($sesino != 0)
		$wsql .= " AND hallbook_noon='" . htmlspecialchars($sesino, ENT_QUOTES) . "'";
	if($sesini != 0)
		$wsql .= " AND hallbook_night='" . htmlspecialchars($sesini, ENT_QUOTES) . "'";
		
	$query_ss = "SELECT hall_book.hallbook_name FROM tadbir.hall_book WHERE hallbook_status = '1' " . $wsql . " ORDER BY hallbook_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['hallbook_name']==NULL)
		return "&nbsp;";
	else
		return $row_ss['hallbook_name'];
}

function getHallType($id)
{
	$query_ss = "SELECT hall_type.halltype_name FROM tadbir.hall_type WHERE halltype_status = '1' AND halltype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['halltype_name'];
}

function getHallName($id)
{
	$query_ss = "SELECT hall.hall_name, hall.halltype_id FROM tadbir.hall WHERE hall.hall_status = '1' AND hall.hall_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return getHallType($row_ss['halltype_id']) . " " . $row_ss['hall_name'];
}

function getBookingID($userid, $hallid, $d, $m, $y, $mo, $no, $ni)
{
	$wsql = "";
	
	if($userid!='0')
	{
		$wsql = " AND user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "'";
	};
	
	if($hallid!=0)
	{
		$wsql = " AND hall_id = '" . $hallid . "'";
	}
	
	$query_ss = "SELECT hallbook_id FROM tadbir.hall_book WHERE hallbook_status = '1' AND hallbook_start_d = '" . htmlspecialchars($d, ENT_QUOTES) . "' AND hallbook_start_m = '" . htmlspecialchars($m, ENT_QUOTES) . "' AND hallbook_start_y = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND hallbook_morning = '" . htmlspecialchars($mo, ENT_QUOTES) . "' AND hallbook_noon = '" . htmlspecialchars($no, ENT_QUOTES) . "' AND hallbook_night = '" . htmlspecialchars($ni, ENT_QUOTES) . "' " . $wsql . " LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['hallbook_id'];
}

function getBookingDate($id)
{
	$query_ss = "SELECT hallbook_start_d, hallbook_start_m, hallbook_start_y FROM tadbir.hall_book WHERE hallbook_status = '1' AND hallbook_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['hallbook_start_m'], $row_ss['hallbook_start_d'], $row_ss['hallbook_start_y']));
}

function getBookingDateMY($id)
{
	$query_ss = "SELECT hallbook_start_d, hallbook_start_m, hallbook_start_y FROM tadbir.hall_book WHERE hallbook_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return date('m/Y', mktime(0, 0, 0, $row_ss['hallbook_start_m'], $row_ss['hallbook_start_d'], $row_ss['hallbook_start_y']));
}

function getBookingSesi($id)
{
	$query_ss = "SELECT hallbook_morning, hallbook_noon, hallbook_night FROM tadbir.hall_book WHERE hallbook_status = '1' AND hallbook_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['hallbook_morning']==1)
		return "Pagi";
	else if($row_ss['hallbook_noon']==1)
		return "Petang";
	else if($row_ss['hallbook_night']==1)
		return "Malam";
}

function getBookingBy($id)
{
	$query_ss = "SELECT user_stafid FROM tadbir.hall_book WHERE hallbook_status = '1' AND hallbook_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['user_stafid'];
}

function getBookingName($id)
{
	$query_ss = "SELECT hallbook_name FROM tadbir.hall_book WHERE hallbook_status = '1' AND hallbook_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['hallbook_name'];
}

function getBookingDetail($id)
{
	$query_ss = "SELECT hallbook_detail FROM tadbir.hall_book WHERE hallbook_status = '1' AND hallbook_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['hallbook_detail'];
}

function getBookingHallID($id)
{
	$query_ss = "SELECT hall_id FROM tadbir.hall_book WHERE hallbook_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['hall_id'];
}
?>
<?php
//statistik
function getTotalBooking($hallid, $d, $m, $y)
{
	$wsql = "";
	if($hallid != 0)
		$wsql .=  " AND hall_id = '" . htmlspecialchars($hallid, ENT_QUOTES) . "'";
	if($d != 0)
		$wsql .= " AND hallbook_start_d = '" . htmlspecialchars($d, ENT_QUOTES) . "'";
	if($m != 0)
		$wsql .= " AND hallbook_start_m = '" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y != 0)
		$wsql .= " AND hallbook_start_y = '" . htmlspecialchars($y, ENT_QUOTES) . "'";
		
	$query_ss = "SELECT hallbook_id FROM tadbir.hall_book WHERE hallbook_status = '1' " . $wsql;	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	return $total;
}

function getTotalTiketApp($m=0, $y=0)
{
	//Jumlah tiket yg belum diuruskan
	$wsql = "";
	if($m!=0)
		$wsql .= " AND ticket_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "'";
	if($y!=0)
		$wsql .= " AND ticket_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "'";
		
	$query_t = "SELECT ticket_id FROM tadbir.ticket WHERE ticket_app = '0' AND ticket_status = 1 " . $wsql;
	$t = mysql_query($query_t); 
	$row_t = mysql_fetch_assoc($t);
	
	$total = mysql_num_rows($t);
	
	return $total;
}

function getTotalPenumpang($tid)
{
	$query_isnp = "SELECT * FROM tadbir.isnpassenger WHERE ip_status = 1 AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ip_id ASC";
	$isnp = mysql_query($query_isnp);
	$row_isnp = mysql_fetch_assoc($isnp);
	
	$totalRows_isnp = mysql_num_rows($isnp);
	
	$query_nisnp = "SELECT * FROM tadbir.nonisnpassenger WHERE nip_status = 1 AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY nip_id ASC";
	$nisnp = mysql_query($query_nisnp) ;
	$row_nisnp = mysql_fetch_assoc($nisnp);
	
	$totalRows_nisnp = mysql_num_rows($nisnp);
	
	return $totalRows_isnp + $totalRows_nisnp;
}
?>
<?php
//tiket
function getTiketID($userid, $d, $m, $y)
{		
	$query_ss = "SELECT ticket_id FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_by = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND ticket_date_d = '" . htmlspecialchars($d, ENT_QUOTES) . "' AND ticket_date_m = '" . htmlspecialchars($m, ENT_QUOTES) . "' AND ticket_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['ticket_id'];
}

function getTiketIDByTravelID($trid)
{		
	$query_ss = "SELECT ticket_id FROM tadbir.travel WHERE travel_status = '1' AND travel_id = '" . htmlspecialchars($trid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['ticket_id'];
}

function getTiketType($tid)
{		
	$query_ss = "SELECT tickettype_id FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['tickettype_id']==1)
		$tt = "Kapal Terbang";
	elseif($row_ss['tickettype_id']==2)
		$tt = "Bas";
	else
		$tt = "Lain-lain";
		
	return $tt;
}

function getTiketBy($tid)
{		
	$query_ss = "SELECT ticket_by FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['ticket_by'];
}

function getTiketDate($tid)
{		
	$query_ss = "SELECT ticket_date_d, ticket_date_m, ticket_date_y FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['ticket_date_m'], $row_ss['ticket_date_d'], $row_ss['ticket_date_y']));
}

function getTiketTitle($tid)
{		
	$query_ss = "SELECT ticket_title FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['ticket_title'];
}

function getTiketRef($tid)
{		
	$query_ss = "SELECT ticket_ref FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['ticket_ref'];
}

function getTiketBagasi($tid)
{		
	$query_ss = "SELECT ticket_bagasi FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['ticket_bagasi'];
}

function getTiketInsuran($tid)
{		
	$query_ss = "SELECT ticket_insuran FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['ticket_insuran'];
}

function getTiketVisa($tid)
{		
	$query_ss = "SELECT ticket_visa FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['ticket_visa'];
}

function checkTiketApp($tid)
{		
	$query_ss = "SELECT ticket_appupdateby, ticket_appby FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['ticket_appupdateby']!=NULL && $row_ss['ticket_appby']!=NULL)
		return true;
	else
		return false;
}

function getAppUpdateByTiketApp($tid)
{		
	// kemaskini oleh
	$query_ss = "SELECT ticket_appupdateby FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['ticket_appupdateby'];
}

function getAppUpdateDateTiketApp($tid)
{
	// Tarikh kemaskini
	$query_ss = "SELECT ticket_appupdatedate FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['ticket_appupdatedate'];
}

function checkTiketAppOrNot($tid)
{		
	$query_ss = "SELECT ticket_app, ticket_appby FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['ticket_app']==1)
		return true;
	else
		return false;
}

function iconTiketApp($tid)
{
	if(checkTiketApp($tid))
	{
		if(checkTiketAppOrNot($tid))
			$view = "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\"";
		else
			$view = "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_error.png\"";
	} else {
		$view = "<img src=\"" . $GLOBALS['url_main'] . "icon/lock.png\"";
	}
	
	return $view;
}

function getTiketAppBy($tid)
{		
	$query_ss = "SELECT ticket_appby FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['ticket_appby'];
}

function getTiketAppDate($tid)
{		
	$query_ss = "SELECT ticket_appdate_d, ticket_appdate_m, ticket_appdate_y FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['ticket_appdate_m'], $row_ss['ticket_appdate_d'], $row_ss['ticket_appdate_y']));
}

function getTiketAppNote($tid)
{		
	$query_ss = "SELECT ticket_appnote FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['ticket_appnote'];
}

function checkTiketInv($tid)
{		
	$query_ss = "SELECT agensi_id, ticket_invupdateby FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if($row_ss['agensi_id']!=NULL && $row_ss['ticket_invupdateby']!=NULL)
		return true;
	else
		return false;
}

function iconTiketInv($tid)
{
	if(checkTiketInv($tid) && checkTiketApp($tid) && checkTiketAppOrNot($tid))
	{
		$view = "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\"";
	} else if(!checkTiketAppOrNot($tid)) {
		$view = "";
	} else {
		$view = "<img src=\"" . $GLOBALS['url_main'] . "icon/lock.png\"";
	}
	
	return $view;
}

function getTiketInvUpdateByTiketApp($tid)
{		
	// kemaskini oleh
	$query_ss = "SELECT ticket_invupdateby FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['ticket_invupdateby'];
}

function getTiketInvUpdateDateTiketApp($tid)
{
	// Tarikh kemaskini
	$query_ss = "SELECT ticket_invupdatedate FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['ticket_invupdatedate'];
}

function getTiketInvDate($tid)
{		
	$query_ss = "SELECT ticket_invdate_d, ticket_invdate_m, ticket_invdate_y FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['ticket_invdate_m'], $row_ss['ticket_invdate_d'], $row_ss['ticket_invdate_y']));
}

function getTiketTypeName($ty)
{
	if($ty==1)
		$view = "Waran";
	else
		$view = "Invois";
		
	return $view;
}

function getTiketTypeWI($tid)
{		
	//jenis pembayaran Waran atau Invois
	$query_ss = "SELECT ticket_type FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['ticket_type'];
}

function getTiketTypeRef($tid)
{		
	$query_ss = "SELECT ticket_typeref FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['ticket_typeref'];
}

function getTiketInvRef($tid)
{		
	$query_ss = "SELECT ticket_invref FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['ticket_invref'];
}

function getTiketInvCost($tid)
{		
	$query_ss = "SELECT ticket_invcost FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['ticket_invcost'];
}

function getTiketInvNote($tid)
{		
	$query_ss = "SELECT ticket_invnote FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['ticket_invnote'];
}

function getAgensiIDByTiketID($tid)
{		
	$query_ss = "SELECT agensi_id FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['agensi_id'];
}
function getFlyTypeName($ty)
{
	if($ty==1)
		$view = "Malaysia Airlines";
	if($ty==2)
		$view = "AirAsia";
	if($ty==3)
		$view = "Lain-lain";
	else
		$view = "Tiada";
		
	return $view;
}

function getFlyTypeWI($tid)
{		
	//syarikat penerbangan
	$query_ss = "SELECT fly_type FROM tadbir.ticket WHERE ticket_status = '1' AND ticket_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY ticket_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['fly_type'];
}
?>
<?php 
//Agensi

function getAgensiName($tid)
{		
	$query_ss = "SELECT agensi_name FROM tadbir.agensi WHERE agensi_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY agensi_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['agensi_name'];
}

function getAgensiNoTel($tid)
{		
	$query_ss = "SELECT agensi_notel FROM tadbir.agensi WHERE agensi_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY agensi_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['agensi_notel'];
}

function getAgensiNoFax($tid)
{		
	$query_ss = "SELECT agensi_nofax FROM tadbir.agensi WHERE agensi_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY agensi_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['agensi_nofax'];
}

function getAgensiEmail($tid)
{		
	$query_ss = "SELECT agensi_email FROM tadbir.agensi WHERE agensi_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY agensi_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['agensi_email'];
}
?>
<?php
//claim report

function checkDateOT($id, $d, $m, $y)
{
	$query_claim = "SELECT claim_on_d, claim_on_m, claim_on_y, user_stafid FROM tadbir.claim WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND claim_on_d = '" . htmlspecialchars($d, ENT_QUOTES) . "' AND claim_on_m = '" . htmlspecialchars($m, ENT_QUOTES) . "' AND claim_on_y = '" . htmlspecialchars($y, ENT_QUOTES) . "' AND claim_status = 1";
	$claim = mysql_query($query_claim);
	$row_claim = mysql_fetch_assoc($claim);
	
	$total = mysql_num_rows($claim);
	
	if($total > 0)
		return true;
	else
		return false;
}

function getStafIDByClaimID($claimid)
{
	$query_claim = "SELECT claim.user_stafid FROM tadbir.claim WHERE claim_id = '" . htmlspecialchars($claimid, ENT_QUOTES) . "' AND claim_status = 1";
	$claim = mysql_query($query_claim);
	$row_claim = mysql_fetch_assoc($claim);
	
	return $row_claim['user_stafid'];
}

function getDateOnMonthByClaimID($claimid)
{
	$query_claim = "SELECT claim.claim_on_m FROM tadbir.claim WHERE claim_id = '" . htmlspecialchars($claimid, ENT_QUOTES) . "' AND claim_status = 1";
	$claim = mysql_query($query_claim);
	$row_claim = mysql_fetch_assoc($claim);
	
	return $row_claim['claim_on_m'];
}

function getDateOnYearByClaimID($claimid)
{
	$query_claim = "SELECT claim.claim_on_y FROM tadbir.claim WHERE claim_id = '" . htmlspecialchars($claimid, ENT_QUOTES) . "' AND claim_status = 1";
	$claim = mysql_query($query_claim);
	$row_claim = mysql_fetch_assoc($claim);
	
	return $row_claim['claim_on_y'];
}

function getSiang()
{
	return 1.125;
}

function getMalamSiangAhad()
{
	return 1.25;
}

function getMalamAhad()
{
	return 1.5;
}

function getAmSiang()
{
	return 1.75;
}

function getAmMalam()
{
	return 2.00;
}

function getRateMinit($minit)
{
	if($minit==15)
	{
		return 0.25;
		
	} elseif($minit==30)
	{
		return 0.5;
		
	} elseif($minit==45)
	{
		return 0.75;
		
	}else
	{
		return 0;

	}
}

function getRate1h($id, $d=0, $m=0, $y=0)
{

	$h = (getBasicSalaryByUserID($id, $d, $m, $y)*12)/2504;
	$rate= round($h, 2);

	 return $rate;
}

function getTypeRateByID($rateid, $id, $m, $y)
{
	$hour = 0;

	switch($rateid)
	{

		case 1 : // siang
			$hour = getTotalSiangByDateIn($id, $m, $y, 1);
			break;
			
		case 2 : // Malam siang ahad
			$hour = getTotalMalamSiangAhadByDateIn($id, $m, $y, 1);
			break;
			
		case 3 : // Malam Ahad
			$hour = getTotalMalamAhadByDateIn($id, $m, $y, 1);
			break;

		case 4 : // Am Siang
			$hour = getTotalAmSiangByDateIn($id, $m, $y, 1);
			break;

		case 5 : // Am Malam
			$hour = getTotalAmMalamByDateIn($id, $m, $y, 1);
			break;
	}
	
	return $hour;
}

function getTypeRateOnByID($rateid, $id, $d, $m, $y)
{
	$hour = 0;

	switch($rateid)
	{

		case 1 : // siang $d = claim_on_d; $m = claim_on_m; $y = claim_on_y;
			$hour = getTotalSiang($id, $d, $m, $y, 1);
			break;
			
		case 2 : // Malam siang ahad
			$hour = getTotalMalamSiangAhad($id, $d, $m, $y, 1);
			break;
			
		case 3 : // Malam Ahad
			$hour = getTotalMalamAhad($id, $d, $m, $y, 1);
			break;

		case 4 : // Am Siang
			$hour = getTotalAmSiang($id, $d, $m, $y, 1);
			break;

		case 5 : // Am Malam
			$hour = getTotalAmMalam($id, $d, $m, $y, 1);
			break;
	}
	
	return $hour;
}

function getTotalDeducHourByGred($id, $m, $y, $rate) 
{
	//jumlah jam setelah tolak 5 / 4 jam ikut gred
	$hour = 0;
	$hour = getTypeRateByID($rate, $id, $m, $y);
	 
	if(getGredByStafID($id)>=17)
	{
		$total = floor($hour/4);
		
	} elseif(getGredByStafID($id)<=16)
	{
		$total = floor($hour/5);
		
	}else {
		$total=0; 

	}

	return $total;
}

function getTotalDeducHourOnByGred($id, $m, $y, $don, $mon, $yon, $rate) 
{
	//jumlah jam setelah tolak 5 / 4 jam ikut gred
	//$d = claim_on_d
	//$m = claim_on_m
	//$y = claim_on_y
	
	if(getTypeRateByID($rate, $id, $m, $y)>0)
	{
	
	$wsql="";
	
	if($m!=0)
		$wsql.=" AND claim_date_m ='" . htmlspecialchars($m, ENT_QUOTES) . "'";
		
	if($y!=0)
		$wsql.=" AND claim_date_y ='" . htmlspecialchars($y, ENT_QUOTES) . "'";
		
	switch($rate)
	{
		case 1:
			$wsql .= " AND claim_siang_h != '0'";
			break;
		case 2:
			$wsql .= " AND claim_malamsiang_h != '0'";
			break;	
		case 3:
			$wsql .= " AND claim_malamahad_h != '0'";
			break;	
		case 4:
			$wsql .= " AND claim_amsiang_h != '0'";
			break;	
		case 5:
			$wsql .= " AND claim_ammalam_h != '0'";
			break;
	};

	$query_claim = "SELECT claim_on_d, claim_on_m, claim_on_y FROM tadbir.claim WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND claim_status= 1 " . $wsql . " GROUP BY claim_on_y, claim_on_m, claim_on_d ORDER BY claim_id ASC";
	$claim = mysql_query($query_claim);
	$row_claim = mysql_fetch_assoc($claim);
	
	$total = 0;
	
	do {
		
		$hour = 0;
		$hour = getTypeRateOnByID($rate, $id, $row_claim['claim_on_d'], $row_claim['claim_on_m'], $row_claim['claim_on_y']);
		 
		if($hour >=4 && getGredByStafID($id)>=17)
		{
			$total += floor($hour/4);
			
		} elseif($hour >=5 && getGredByStafID($id)<=16)
		{
			$total += floor($hour/5);
			
		};
		
	} while($row_claim = mysql_fetch_assoc($claim));
	
	} else {
		$total = 0;
	};

	return $total;
}

function getSiangHourAfterDeduc($id, $m, $y, $don, $mon, $yon)
{
	// mengira jumlah jam dan minit setelah ditolak kadar 1 jam setiap 5 jam / 4 jam;
	$total = array();
	$total[0] = (getTotalSiangByDateIn($id, $m, $y,1) - getTotalDeducHourOnByGred($id, $m, $y, $don, $mon, $yon, 1)); // bawa nilai jam
	$total[1] = getTotalSiangByDateIn($id, $m, $y,2); // bawa nilai minit

	return $total; // array
}

function getMalamSiangAhadHourAfterDeduc($id, $m, $y, $don, $mon, $yon)
{
	$total = array();
	$total[0] = (getTotalMalamSiangAhadByDateIn($id, $m, $y, 1) - getTotalDeducHourOnByGred($id, $m, $y,  $don, $mon, $yon, 2)); // bawa nilai jam
	$total[1] = getTotalMalamSiangAhadByDateIn($id, $m, $y, 2); // bawa nilai minit

	return $total; // array
}

function getMalamAhadHourAfterDeduc($id, $m, $y, $don, $mon, $yon)
{
	$total = array();
	$total[0] = (getTotalMalamAhadByDateIn($id, $m, $y,1)- getTotalDeducHourOnByGred($id, $m, $y,  $don, $mon, $yon, 3)); // bawa nilai jam
	$total[1] = getTotalMalamAhadByDateIn($id, $m, $y,2); // bawa nilai minit

	return $total; // array
}

function getAmSiangHourAfterDeduc($id, $m, $y, $don, $mon, $yon)
{
	$total = array();
	$total[0] = (getTotalAmSiangByDateIn($id, $m, $y,1)- getTotalDeducHourOnByGred($id, $m, $y,  $don, $mon, $yon, 4)); // bawa nilai jam
	$total[1] = getTotalAmSiangByDateIn($id, $m, $y,2); // bawa nilai minit
	
	return $total; // array
}

function getAmMalamHourAfterDeduc($id, $m, $y, $don, $mon, $yon)
{
	$total = array();
	$total[0] = (getTotalAmMalamByDateIn($id, $m, $y,1)- getTotalDeducHourOnByGred($id, $m, $y,  $don, $mon, $yon, 5)); // bawa nilai jam
	$total[1] = getTotalAmMalamByDateIn($id, $m, $y,2); // bawa nilai minit

	return $total; // array
}

function getAmountMalamSiangAhad($id, $m, $y, $don, $mon, $yon)
{
	$h=  getMalamSiangAhadHourAfterDeduc($id, $m, $y, $don, $mon, $yon);
	$total = getMalamSiangAhad()* ($h[0] + getRateMinit($h[1]))* getRate1h($id, 0, $m, $y); 
	
	return $total;
}

function getTotalSiang($id, $d, $m, $y, $view)
{
	$wsql="";
	
	if($d!=0)
		$wsql.=" AND claim_on_d ='" . htmlspecialchars($d, ENT_QUOTES) . "'";
	
	if($m!=0)
		$wsql.=" AND claim_on_m ='" . htmlspecialchars($m, ENT_QUOTES) . "'";
		
	if($y!=0)
		$wsql.=" AND claim_on_y ='" . htmlspecialchars($y, ENT_QUOTES) . "'";

	$query_claim = "SELECT claim_siang_h, claim_siang_m FROM tadbir.claim WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND claim_status= 1 ".$wsql." ORDER BY claim_id ASC";
	$claim = mysql_query($query_claim);
	$row_claim = mysql_fetch_assoc($claim);

	$tm = 0;
	$th = 0;

	do {
		
		$th = $row_claim['claim_siang_h'] + $th; // jam
		$tm = $row_claim['claim_siang_m'] + $tm; // minit
		
	}while($row_claim = mysql_fetch_assoc($claim));

	$hm= $th*60;
	$total=$tm + $hm; //jumlah dalam minit
	
	$mh=floor($total/60); //untuk dapatkan jam
	$mm=$total%60; //untuk dapatkan baki dalam minit

	if($view==1)
		return $mh;
	else if($view==2)
		return $mm;
	else
		return $total;
}

function getTotalSiangByDateIn($id, $m, $y,$view)//jumlah jam minit mengikut tarikh proses tuntutan
{
	$wsql="";

	if($m!=0)
		$wsql.=" AND claim_date_m ='".htmlspecialchars($m, ENT_QUOTES)."'";

	if($y!=0)
		$wsql.=" AND claim_date_y ='".htmlspecialchars($y, ENT_QUOTES)."'";

	$query_claim = "SELECT claim_siang_h, claim_siang_m FROM tadbir.claim WHERE user_stafid = '".htmlspecialchars($id, ENT_QUOTES)."' AND claim_status= 1 ".$wsql." ORDER BY claim_id ASC";
	$claim = mysql_query($query_claim);
	$row_claim = mysql_fetch_assoc($claim);

	$tm=0;
	$th=0;

	do {
		$tm+= $row_claim['claim_siang_m'];
		$th+= $row_claim['claim_siang_h'];
	}while($row_claim = mysql_fetch_assoc($claim));

	$hm= $th*60;
	$total=$tm + $hm; //jumlah dalam minit
	
	$mh=floor($total/60); //untuk dapatkan jam
	$mm=$total%60; //untuk dapatkan baki dalam minit

	if($view==1)
		return $mh;
	elseif($view==2)
		return $mm;
	else
		return $total;
}

function getTotalMalamSiangAhad($id, $d, $m, $y, $view)
{
	$wsql="";

	if($d!=0)
		$wsql.=" AND claim_on_d='".htmlspecialchars($d, ENT_QUOTES)."'";

	if($m!=0)
		$wsql.=" AND claim_on_m='".htmlspecialchars($m, ENT_QUOTES)."'";

	if($y!=0)
		$wsql.=" AND claim_on_y='".htmlspecialchars($y, ENT_QUOTES)."'";

	$query_claim = "SELECT claim_malamsiang_h, claim_malamsiang_m FROM tadbir.claim WHERE user_stafid = '".htmlspecialchars($id, ENT_QUOTES)."' AND claim_status= 1 ".$wsql." ORDER BY claim_id ASC";
	$claim = mysql_query($query_claim);
	$row_claim = mysql_fetch_assoc($claim);

	$tm=0;
	$th=0;

	do {
		$tm+= $row_claim['claim_malamsiang_m'];
		$th+= $row_claim['claim_malamsiang_h'];
	}while($row_claim = mysql_fetch_assoc($claim));

	$hm= $th*60;
	$total=$tm + $hm; //jumlah dalam minit
	
	$mh=floor($total/60);//untuk dapatkan jam
	$mm=$total%60;//untuk dapatkan baki dalam minit

	if($view==1)
		return $mh;
	elseif($view==2)
		return $mm;
	else
		return $total;
}

function getTotalMalamSiangAhadByDateIn($id, $m, $y,$view) 
{
	$wsql="";

	if($m!=0)
		$wsql.=" AND claim_date_m = '".htmlspecialchars($m, ENT_QUOTES)."'";

	if($y!=0)
		$wsql.=" AND claim_date_y = '".htmlspecialchars($y, ENT_QUOTES)."'";

	$query_claim = "SELECT claim_malamsiang_h, claim_malamsiang_m FROM tadbir.claim WHERE user_stafid = '".htmlspecialchars($id, ENT_QUOTES)."' AND claim_status= 1 ".$wsql." ORDER BY claim_id ASC";
	$claim = mysql_query($query_claim);
	$row_claim = mysql_fetch_assoc($claim);

	$tm=0;
	$th=0;

	do {
		$tm+= $row_claim['claim_malamsiang_m'];
		$th+= $row_claim['claim_malamsiang_h'];
	}while($row_claim = mysql_fetch_assoc($claim));

	$hm = $th*60;
	$total = $tm + $hm; //jumlah dalam minit
	
	$mh = floor($total/60);//untuk dapatkan jam
	$mm = $total%60;//untuk dapatkan baki dalam minit

	if($view==1)
		return $mh;
	else if($view==2)
		return $mm;
	else
		return $total;
}

function getTotalMalamAhad($id, $d, $m, $y,$view)
{

	$wsql="";
	
	if($d!=0)
		$wsql.=" AND claim_on_d ='" . htmlspecialchars($d, ENT_QUOTES) . "'";

	if($m!=0)
		$wsql.=" AND claim_on_m='".htmlspecialchars($m, ENT_QUOTES)."'";

	if($y!=0)
		$wsql.=" AND claim_on_y='".htmlspecialchars($y, ENT_QUOTES)."'";

	$query_claim = "SELECT claim_malamahad_h, claim_malamahad_m FROM tadbir.claim WHERE user_stafid = '".htmlspecialchars($id, ENT_QUOTES)."' AND claim_status= 1 ".$wsql." ORDER BY claim_id ASC";
	$claim = mysql_query($query_claim);
	$row_claim = mysql_fetch_assoc($claim);
	
	$tm=0;
	$th=0;

	do {
		$tm+= $row_claim['claim_malamahad_m'];
		$th+= $row_claim['claim_malamahad_h'];
	}while($row_claim = mysql_fetch_assoc($claim));

	$hm= $th*60;
	$total=$tm + $hm; //jumlah dalam minit
	$mh=floor($total/60);//untuk dapatkan jam
	$mm=$total%60;//untuk dapatkan baki dalam minit

	if($view==1)
		return $mh;
	else if($view==2)
		return $mm;
	else
		return $total;
}

function getTotalMalamAhadByDateIn($id, $m, $y,$view)
{

	$wsql="";

	if($m!=0)
		$wsql.=" AND claim_date_m='".htmlspecialchars($m, ENT_QUOTES)."'";
	if($y!=0)
		$wsql.=" AND claim_date_y='".htmlspecialchars($y, ENT_QUOTES)."'";

	$query_claim = "SELECT claim_malamahad_h, claim_malamahad_m FROM tadbir.claim WHERE user_stafid = '".htmlspecialchars($id, ENT_QUOTES)."' AND claim_status= 1 ".$wsql." ORDER BY claim_id ASC";
	$claim = mysql_query($query_claim);
	$row_claim = mysql_fetch_assoc($claim);
	
	$tm=0;
	$th=0;

	do {
		$tm+= $row_claim['claim_malamahad_m'];
		$th+= $row_claim['claim_malamahad_h'];
	}while($row_claim = mysql_fetch_assoc($claim));

	$hm= $th*60;
	$total=$tm + $hm; //jumlah dalam minit
	$mh=floor($total/60);//untuk dapatkan jam
	$mm=$total%60;//untuk dapatkan baki dalam minit

	if($view==1)
		return $mh;
	else if($view==2)
		return $mm;
	else
		return $total;
}

function getTotalAmSiang($id, $d, $m, $y, $view)
{

	$wsql="";
	
	if($d!='0')
		$wsql.=" AND claim_on_d = '" . htmlspecialchars($d, ENT_QUOTES) . "'";

	if($m!='0')
		$wsql.=" AND claim_on_m = '" . htmlspecialchars($m, ENT_QUOTES) . "'";

	if($y!='0')
		$wsql.=" AND claim_on_y = '" . htmlspecialchars($y, ENT_QUOTES) . "'";

	$query_claim = "SELECT claim_amsiang_h, claim_amsiang_m FROM tadbir.claim WHERE user_stafid = '".htmlspecialchars($id, ENT_QUOTES)."' AND claim_status= 1 ".$wsql." ORDER BY claim_id ASC";
	$claim = mysql_query($query_claim);
	$row_claim = mysql_fetch_assoc($claim);

	$tm=0;
	$th=0;

	do {
		$th = $row_claim['claim_amsiang_h'] + $th;
		$tm = $row_claim['claim_amsiang_m'] + $tm;
	}while($row_claim = mysql_fetch_assoc($claim));

	$hm = $th*60;
	$total = $tm + $hm; //jumlah dalam minit
	
	$mh = floor($total/60);//untuk dapatkan jam
	$mm = $total%60;//untuk dapatkan baki dalam minit

	if($view==1)
		return $mh;
	else if($view==2)
		return $mm;
	else
		return $total;
}

function getTotalAmSiangByDateIn($id, $m, $y,$view)
{
	$wsql="";

	if($m!=0)
		$wsql.=" AND claim_date_m='".htmlspecialchars($m, ENT_QUOTES)."'";
	
	if($y!=0)
		$wsql.=" AND claim_date_y='".htmlspecialchars($y, ENT_QUOTES)."'";

	$query_claim = "SELECT claim_amsiang_h, claim_amsiang_m FROM tadbir.claim WHERE user_stafid = '".htmlspecialchars($id, ENT_QUOTES)."' AND claim_status= 1 ".$wsql." ORDER BY claim_id ASC";
	$claim = mysql_query($query_claim);
	$row_claim = mysql_fetch_assoc($claim);

	$tm=0;
	$th=0;

	do {
		$tm+= $row_claim['claim_amsiang_m'];
		$th+= $row_claim['claim_amsiang_h'];
	}while($row_claim = mysql_fetch_assoc($claim));

	$hm= $th*60;
	$total=$tm + $hm; //jumlah dalam minit
	$mh=floor($total/60);//untuk dapatkan jam
	$mm=$total%60;//untuk dapatkan baki dalam minit

	if($view==1)
		return $mh;
	else if($view==2)
		return $mm;
	else
		return $total;
}

function getTotalAmMalam($id, $d, $m, $y, $view)
{

	$wsql="";
	
	if($d!=0)
		$wsql.=" AND claim_on_d ='" . htmlspecialchars($d, ENT_QUOTES) . "'";

	if($m!=0)
		$wsql.=" AND claim_on_m='".htmlspecialchars($m, ENT_QUOTES)."'";
	if($y!=0)
		$wsql.=" AND claim_on_y='".htmlspecialchars($y, ENT_QUOTES)."'";

	$query_claim = "SELECT claim_ammalam_h, claim_ammalam_m FROM tadbir.claim WHERE user_stafid = '".htmlspecialchars($id, ENT_QUOTES)."' AND claim_status= 1 ".$wsql." ORDER BY claim_id ASC";
	$claim = mysql_query($query_claim);
	$row_claim = mysql_fetch_assoc($claim);

	$tm=0;
	$th=0;

	do {
		$th+= $row_claim['claim_ammalam_h'];
		$tm+= $row_claim['claim_ammalam_m'];
	}while($row_claim = mysql_fetch_assoc($claim));

	$hm= $th*60;
	$total=$tm + $hm; //jumlah dalam minit
	$mh=floor($total/60);//untuk dapatkan jam
	$mm=$total%60;//untuk dapatkan baki dalam minit

	if($view==1)
		return $mh;
	else if($view==2)
		return $mm;
	else
		return $total;
}

function getTotalAmMalamByDateIn($id, $m, $y,$view)
{

	$wsql="";

	if($m!=0)
		$wsql.=" AND claim_date_m='".htmlspecialchars($m, ENT_QUOTES)."'";
	
	if($y!=0)
		$wsql.=" AND claim_date_y='".htmlspecialchars($y, ENT_QUOTES)."'";

	$query_claim = "SELECT claim_ammalam_h, claim_ammalam_m FROM tadbir.claim WHERE user_stafid = '".htmlspecialchars($id, ENT_QUOTES)."' AND claim_status= 1 ".$wsql." ORDER BY claim_id ASC";
	$claim = mysql_query($query_claim);
	$row_claim = mysql_fetch_assoc($claim);

	$tm=0;
	$th=0;

	do {
		$tm+= $row_claim['claim_ammalam_m'];
		$th+= $row_claim['claim_ammalam_h'];
	}while($row_claim = mysql_fetch_assoc($claim));

	$hm= $th*60;
	$total=$tm + $hm; //jumlah dalam minit
	$mh=floor($total/60);//untuk dapatkan jam
	$mm=$total%60;//untuk dapatkan baki dalam minit

	if($view==1)
		return $mh;
	else if($view==2)
		return $mm;
	else
		return $total;
}

//OT 05122012
function getTypeRateMonByID($rateid, $id, $mon, $yon)
{
	$hour = 0;
	
	switch($rateid)
	{
		case 1 : // siang $d = claim_on_d; $m = claim_on_m; $y = claim_on_y;
			$hour = getTotalSiangOn($id, $mon, $yon, 1);
			break;

		case 2 : // Malam siang ahad
			$hour = getTotalMalamSiangOn($id, $mon, $yon, 1);
			break;

		case 3 : // Malam Ahad
			$hour = getTotalMalamAhadOn($id, $mon, $yon, 1);
			break;

		case 4 : // Am Siang
			$hour = getTotalAmSiangOn($id, $mon, $yon, 1);
			break;

		case 5 : // Am Malam
			$hour = getTotalAmMalamOn($id,  $mon, $yon, 1);
			break;
	}

	return $hour;

}

function getTotalDeducHourMonByGred($id, $mon, $yon, $rate) 
{
	//jumlah jam setelah tolak 5 / 4 jam ikut gred
	//$d = claim_on_d
	//$m = claim_on_m
	//$y = claim_on_y

	if(getTypeRateMonByID($rate, $id, $mon, $yon)>0)
	{
		$wsql="";
		
		if($mon!=0)
			$wsql.=" AND claim_on_m ='" . htmlspecialchars($mon, ENT_QUOTES) . "'";
			
		if($yon!=0)
			$wsql.=" AND claim_on_y ='" . htmlspecialchars($yon, ENT_QUOTES) . "'";

		switch($rate)
		{
			case 1:
				$wsql .= " AND claim_siang_h != '0'";
				break;
	
			case 2:
				$wsql .= " AND claim_malamsiang_h != '0'";
				break;	
	
			case 3:
				$wsql .= " AND claim_malamahad_h != '0'";
				break;	
	
			case 4:
				$wsql .= " AND claim_amsiang_h != '0'";
				break;	
	
			case 5:
				$wsql .= " AND claim_ammalam_h != '0'";
				break;
		};
	
		$query_claim = "SELECT claim_on_d, claim_on_m, claim_on_y FROM tadbir.claim WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND claim_status= 1 " . $wsql . " GROUP BY claim_on_y, claim_on_m, claim_on_d ORDER BY claim_id ASC";
		$claim = mysql_query($query_claim);
		$row_claim = mysql_fetch_assoc($claim);
	
		$total = 0;
	
		do {
			
			$hour = 0;
			$hour = getTypeRateOnByID($rate, $id, $row_claim['claim_on_d'], $row_claim['claim_on_m'], $row_claim['claim_on_y']);
	
			if($hour >=4 && getGredByStafID($id)>=17)
			{
				$total += floor($hour/4);
				
			} elseif($hour >=5 && getGredByStafID($id)<=16)
			{
				$total += floor($hour/5);
				
			};
			
		} while($row_claim = mysql_fetch_assoc($claim));

	} else {
		
		$total = 0;
		
	};
	
	return $total;
}

function getSiangHourMonAfterDeduc($id,$mon, $yon)
{
	// mengira jumlah jam dan minit setelah ditolak kadar 1 jam setiap 5 jam / 4 jam;
	$total = array();
	$total[0] = (getTotalSiangOn($id, $mon, $yon, 1) - getTotalDeducHourMonByGred($id, $mon, $yon, 1)); // bawa nilai jam
	$total[1] = getTotalSiangOn($id, $mon, $yon, 2); // bawa nilai minit

	return $total; // array
}

function getMalamSiangHourMonAfterDeduc($id,$mon, $yon)
{

	// mengira jumlah jam dan minit setelah ditolak kadar 1 jam setiap 5 jam / 4 jam;
	$total = array();
	$total[0] = (getTotalMalamSiangOn($id, $mon, $yon, 1) - getTotalDeducHourMonByGred($id, $mon, $yon,2)); // bawa nilai jam
	$total[1] = getTotalMalamSiangOn($id, $mon, $yon, 2); // bawa nilai minit
	
	return $total; // array
}

function getMalamAhadHourMonAfterDeduc($id,$mon, $yon)
{

	// mengira jumlah jam dan minit setelah ditolak kadar 1 jam setiap 5 jam / 4 jam;

	$total = array();
	$total[0] = (getTotalMalamAhadOn($id, $mon, $yon, 1) - getTotalDeducHourMonByGred($id, $mon, $yon,3)); // bawa nilai jam
	$total[1] = getTotalMalamAhadOn($id, $mon, $yon, 2); // bawa nilai minit
	
	return $total; // array
}

function getAmSiangHourMonAfterDeduc($id,$mon, $yon)
{

	// mengira jumlah jam dan minit setelah ditolak kadar 1 jam setiap 5 jam / 4 jam;

	$total = array();
	$total[0] = (getTotalAmSiangOn($id, $mon, $yon, 1) - getTotalDeducHourMonByGred($id, $mon, $yon, 4)); // bawa nilai jam
	$total[1] = getTotalAmSiangOn($id, $mon, $yon, 2); // bawa nilai minit

	return $total; // array
}

function getAmMalamHourMonAfterDeduc($id,$mon, $yon)
{

	// mengira jumlah jam dan minit setelah ditolak kadar 1 jam setiap 5 jam / 4 jam;

	$total = array();
	$total[0] = (getTotalAmMalamOn($id, $mon, $yon, 1) - getTotalDeducHourMonByGred($id, $mon, $yon, 5)); // bawa nilai jam
	$total[1] = getTotalAmMalamOn($id, $mon, $yon, 2); // bawa nilai minit

	return $total; // array
}

function getAmountSiang($id, $m, $y, $mon, $yon)
{

	// mengira jumlah jam dan minit setelah ditolak kadar 1 jam setiap 5 jam / 4 jam;
	
	$h =  getSiangHourMonAfterDeduc($id,$mon, $yon);
	$total = getSiang() * ($h[0] + getRateMinit($h[1])) * getRate1h($id, 0, $m, $y); // bawa nilai jam
	
	$max= (getBasicSalaryByUserID($id, 1, $m, $y)/3);

	if(getGred($id)=='R3' || getGred($id)=='R6') 
	{ 
		return $total;
		
	} elseif($total<=$max) 
	{
		// nilai total tidak melebihi nilai max, kecuali kpd pemandu (R3 / R6)
		return $total;

	} else return $max;
	
}

function getAmountMalamSiang($id, $m, $y, $mon, $yon)
{

	// mengira jumlah jam dan minit setelah ditolak kadar 1 jam setiap 5 jam / 4 jam;

	$h =  getMalamSiangHourMonAfterDeduc($id,$mon, $yon);
	$total = getMalamSiangAhad() * ($h[0] + getRateMinit($h[1])) * getRate1h($id, 0, $m, $y); // bawa nilai jam
	
	$max= (getBasicSalaryByUserID($id, 1, $m, $y)/3);

	if(getGred($id)=='R3' || getGred($id)=='R6') 
	{ 
		return $total;
		
	} elseif($total<=$max) 
	{
		// nilai total tidak melebihi nilai max, kecuali kpd pemandu (R3 / R6)
		return $total;

	} else return $max;
	
}

function getAmountMalamAhad($id, $m, $y, $mon, $yon)
{

	// mengira jumlah jam dan minit setelah ditolak kadar 1 jam setiap 5 jam / 4 jam;

	$h =  getMalamAhadHourMonAfterDeduc($id,$mon, $yon);
	$total = getMalamAhad() * ($h[0] + getRateMinit($h[1])) * getRate1h($id, 0, $m, $y); // bawa nilai jam
	
	$max= (getBasicSalaryByUserID($id, 1, $m, $y)/3);

	if(getGred($id)=='R3' || getGred($id)=='R6') 
	{ 
		return $total;

	} elseif($total<=$max) 
	{
		// nilai total tidak melebihi nilai max, kecuali kpd pemandu (R3 / R6)
		return $total;

	} else return $max;
}

function getAmountAmSiang($id, $m, $y, $mon, $yon)
{

	// mengira jumlah jam dan minit setelah ditolak kadar 1 jam setiap 5 jam / 4 jam;

	$h =  getAmSiangHourMonAfterDeduc($id,$mon, $yon);
	$total = getAmSiang() * ($h[0] + getRateMinit($h[1])) * getRate1h($id, 0, $m, $y); // bawa nilai jam
	
	$max= (getBasicSalaryByUserID($id, 1, $m, $y)/3);

	if(getGred($id)=='R3' || getGred($id)=='R6') 
	{ 
		return $total;
		
	} elseif($total<=$max) 
	{
		// nilai total tidak melebihi nilai max, kecuali kpd pemandu (R3 / R6)
		return $total;

	} else return $max;
}

function getAmountAmMalam($id, $m, $y, $mon, $yon)
{
	// mengira jumlah jam dan minit setelah ditolak kadar 1 jam setiap 5 jam / 4 jam;

	$h =  getAmMalamHourMonAfterDeduc($id,$mon, $yon);
	$total = getAmMalam() * ($h[0] + getRateMinit($h[1])) * getRate1h($id, 0, $m, $y); // bawa nilai jam
	
	$max= (getBasicSalaryByUserID($id, 1, $m, $y)/3);

	if(getGred($id)=='R3' || getGred($id)=='R6') 
	{ 
		return $total;

	} elseif($total<=$max) 
	{

		// nilai total tidak melebihi nilai max, kecuali kpd pemandu (R3 / R6)
		return $total;

	} else return $max;
}

function getTotalSiangOn($id, $m, $y, $view)
{

	$wsql="";

	if($m!=0)
		$wsql.=" AND claim_on_m ='" . htmlspecialchars($m, ENT_QUOTES) . "'";

	if($y!=0)
		$wsql.=" AND claim_on_y ='" . htmlspecialchars($y, ENT_QUOTES) . "'";

	$query_claim = "SELECT claim_siang_h, claim_siang_m FROM tadbir.claim WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND claim_status= 1 ".$wsql." ORDER BY claim_id ASC";
	$claim = mysql_query($query_claim);
	$row_claim = mysql_fetch_assoc($claim);

	$tm = 0;
	$th = 0;

	do {
		
		$th = $row_claim['claim_siang_h'] + $th; // jam
		$tm = $row_claim['claim_siang_m'] + $tm; // minit
	}while($row_claim = mysql_fetch_assoc($claim));

	$hm= $th*60;
	$total=$tm + $hm; //jumlah dalam minit

	$mh=floor($total/60); //untuk dapatkan jam
	$mm=$total%60; //untuk dapatkan baki dalam minit

	if($view==1)
		return $mh;
	else if($view==2)
		return $mm;
	else
		return $total;
}

function getTotalMalamSiangOn($id, $m, $y, $view)
{
	$wsql="";
	
	if($m!=0)
		$wsql.=" AND claim_on_m ='" . htmlspecialchars($m, ENT_QUOTES) . "'";

	if($y!=0)
		$wsql.=" AND claim_on_y ='" . htmlspecialchars($y, ENT_QUOTES) . "'";

	$query_claim = "SELECT claim_malamsiang_h, claim_malamsiang_m FROM tadbir.claim WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND claim_status= 1 ".$wsql." ORDER BY claim_id ASC";
	$claim = mysql_query($query_claim);
	$row_claim = mysql_fetch_assoc($claim);

	$tm = 0;
	$th = 0;

	do {
		$th = $row_claim['claim_malamsiang_h'] + $th; // jam
		$tm = $row_claim['claim_malamsiang_m'] + $tm; // minit
	}while($row_claim = mysql_fetch_assoc($claim));

	$hm= $th*60;
	$total=$tm + $hm; //jumlah dalam minit

	$mh=floor($total/60); //untuk dapatkan jam
	$mm=$total%60; //untuk dapatkan baki dalam minit

	if($view==1)
		return $mh;
	else if($view==2)
		return $mm;
	else
		return $total;
}

function getTotalMalamAhadOn($id, $m, $y, $view)
{
	$wsql="";

	if($m!=0)
		$wsql.=" AND claim_on_m ='" . htmlspecialchars($m, ENT_QUOTES) . "'";

	if($y!=0)
		$wsql.=" AND claim_on_y ='" . htmlspecialchars($y, ENT_QUOTES) . "'";

	$query_claim = "SELECT claim_malamahad_h, claim_malamahad_m FROM tadbir.claim WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND claim_status= 1 ".$wsql." ORDER BY claim_id ASC";
	$claim = mysql_query($query_claim);
	$row_claim = mysql_fetch_assoc($claim);

	$tm = 0;
	$th = 0;
	
	do {

		$th = $row_claim['claim_malamahad_h'] + $th; // jam
		$tm = $row_claim['claim_malamahad_m'] + $tm; // minit
		
	}while($row_claim = mysql_fetch_assoc($claim));

	$hm= $th*60;
	$total=$tm + $hm; //jumlah dalam minit

	$mh=floor($total/60); //untuk dapatkan jam
	$mm=$total%60; //untuk dapatkan baki dalam minit

	if($view==1)
		return $mh;
	else if($view==2)
		return $mm;
	else
		return $total;
}

function getTotalAmSiangOn($id, $m, $y, $view)
{
	$wsql="";
	
	if($m!=0)
		$wsql.=" AND claim_on_m ='" . htmlspecialchars($m, ENT_QUOTES) . "'";

	if($y!=0)
		$wsql.=" AND claim_on_y ='" . htmlspecialchars($y, ENT_QUOTES) . "'";

	$query_claim = "SELECT claim_amsiang_h, claim_amsiang_m FROM tadbir.claim WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND claim_status= 1 ".$wsql." ORDER BY claim_id ASC";
	$claim = mysql_query($query_claim);
	$row_claim = mysql_fetch_assoc($claim);

	$tm = 0;
	$th = 0;

	do {

		$th = $row_claim['claim_amsiang_h'] + $th; // jam
		$tm = $row_claim['claim_amsiang_m'] + $tm; // minit

	}while($row_claim = mysql_fetch_assoc($claim));

	$hm= $th*60;
	$total=$tm + $hm; //jumlah dalam minit

	$mh=floor($total/60); //untuk dapatkan jam
	$mm=$total%60; //untuk dapatkan baki dalam minit

	if($view==1)
		return $mh;
	else if($view==2)
		return $mm;
	else
		return $total;
}

function getTotalAmMalamOn($id, $m, $y, $view)
{
	$wsql="";

	if($m!=0)
		$wsql.=" AND claim_on_m ='" . htmlspecialchars($m, ENT_QUOTES) . "'";

	if($y!=0)
		$wsql.=" AND claim_on_y ='" . htmlspecialchars($y, ENT_QUOTES) . "'";

	$query_claim = "SELECT claim_ammalam_h, claim_ammalam_m FROM tadbir.claim WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND claim_status= 1 ".$wsql." ORDER BY claim_id ASC";
	$claim = mysql_query($query_claim);
	$row_claim = mysql_fetch_assoc($claim);
	
	$tm = 0;
	$th = 0;

	do {

		$th = $row_claim['claim_ammalam_h'] + $th; // jam
		$tm = $row_claim['claim_ammalam_m'] + $tm; // minit

	}while($row_claim = mysql_fetch_assoc($claim));

	$hm= $th*60;
	$total=$tm + $hm; //jumlah dalam minit

	$mh=floor($total/60); //untuk dapatkan jam
	$mm=$total%60; //untuk dapatkan baki dalam minit

	if($view==1)
		return $mh;
	else if($view==2)
		return $mm;
	else
		return $total;
}

function getOverall($id, $m, $y, $mon=0, $yon=0)
{
	$total =  (round(getAmountSiang($id, $m, $y, $mon, $yon),2) +  round(getAmountMalamSiang($id, $m, $y, $mon, $yon),2) +  round(getAmountMalamAhad($id, $m, $y, $mon, $yon),2) + round(getAmountAmSiang($id, $m, $y, $mon, $yon),2) +  round(getAmountAmMalam($id, $m, $y, $mon, $yon),2));	
	
	return $total;	
}

function getTotalByUserDesignation($id, $m, $y, $mon=0, $yon=0, $jt)
{
	if($jt=='1' && getJobtypeIDByUserID($id)=='1') 
	{
		//Tetap
		return getOverall($id, $m, $y, $mon, $yon);

	} elseif($jt=='2' && getJobtypeIDByUserID($id)=='2')
	{
		//Kontrak
		return getOverall($id, $m, $y, $mon, $yon);

	} else return 0;
}

function getTotalClaimTetap($m, $y)
{
	$query_jobtype = "SELECT user_stafid, claim_on_m FROM tadbir.claim WHERE claim_date_m= '". htmlspecialchars($m, ENT_QUOTES)."' AND claim_date_y= '". htmlspecialchars($y, ENT_QUOTES)."' AND claim_status= 1 GROUP BY user_stafid,claim_on_y, claim_on_m ORDER BY claim_id ASC";
	$jobtype = mysql_query($query_jobtype);
	$row_jobtype = mysql_fetch_assoc($jobtype);

	$total = 0;

	do{

		$total += getTotalByUserDesignation($row_jobtype['user_stafid'], $m, $y, $row_jobtype['claim_on_m'], 0, 1);

	}while($row_jobtype = mysql_fetch_assoc($jobtype));

	return $total;
}

function getTotalClaimKontrak($m, $y)
{
	$query_jobtype ="SELECT user_stafid, claim_on_m FROM tadbir.claim WHERE claim_date_m= '". htmlspecialchars($m, ENT_QUOTES)."' AND claim_date_y= '". htmlspecialchars($y, ENT_QUOTES)."' AND claim_status= 1 GROUP BY user_stafid,claim_on_y, claim_on_m ORDER BY claim_id ASC";
	$jobtype = mysql_query($query_jobtype);
	$row_jobtype = mysql_fetch_assoc($jobtype);

	$total = 0;

	do{
		
		$total += getTotalByUserDesignation($row_jobtype['user_stafid'], $m, $y, $row_jobtype['claim_on_m'],0, 2);

	}while($row_jobtype = mysql_fetch_assoc($jobtype));

	return $total;
}

function getTotalStafOverall($m, $y)
{
	$query_claim = "SELECT user_stafid, claim_on_m, claim_date_m, claim_id FROM tadbir.claim WHERE claim_date_m = '". htmlspecialchars($m, ENT_QUOTES)."' AND claim_date_y = '". htmlspecialchars($y, ENT_QUOTES)."' AND claim_status = 1 GROUP BY claim_date_y, claim_date_m, user_stafid ORDER BY claim_id ASC";
	$claim = mysql_query($query_claim);
	$row_claim = mysql_fetch_assoc($claim);

	$total= mysql_num_rows($claim);

	return $total;	
}

function getTotalOverall( $m, $y)
{
	$query_claim = "SELECT user_stafid, claim_on_m, claim_on_y FROM tadbir.claim WHERE claim_date_m= '". htmlspecialchars($m, ENT_QUOTES)."' AND claim_date_y= '". htmlspecialchars($y, ENT_QUOTES)."' AND claim_status= 1 GROUP BY user_stafid,claim_on_y, claim_on_m ORDER BY claim_id ASC";
	$claim = mysql_query($query_claim);
	$row_claim = mysql_fetch_assoc($claim);

	$total=0;

	do{

		$total+=getOverall($row_claim['user_stafid'], $m, $y, $row_claim['claim_on_m'], $row_claim['claim_on_y']);

	}while($row_claim = mysql_fetch_assoc($claim));

	return $total;
}

function getTotalOverallByStafID($id, $m, $y)
{
	$query_claim = "SELECT claim_on_m, claim_on_y FROM tadbir.claim WHERE claim.user_stafid='".$id."' AND claim_date_m= '". htmlspecialchars($m, ENT_QUOTES)."' AND claim_date_y= '". htmlspecialchars($y, ENT_QUOTES)."' AND claim_status= 1 GROUP BY claim_on_y, claim_on_m ORDER BY claim_id ASC";
	$claim = mysql_query($query_claim);
	$row_claim = mysql_fetch_assoc($claim);
	
	$total=0;

	do{
		
		$total+=getOverall($id, $m, $y, $row_claim['claim_on_m'], $row_claim['claim_on_y']);

	}while($row_claim = mysql_fetch_assoc($claim));

	return $total;	
}
?>
<?php 
// Tempahan kenderaan
function getTransbookID($userid, $d, $m, $y)
{		
	$query_ss = "SELECT transbook_id FROM tadbir.transport_book WHERE transbook_status = '1' AND transbook_by = '" . htmlspecialchars($userid,ENT_QUOTES) . "' AND transbook_date_d = '" . htmlspecialchars($d,ENT_QUOTES) . "' AND transbook_date_m = '" . htmlspecialchars($m,ENT_QUOTES) . "' AND transbook_date_y = '" . htmlspecialchars($y,ENT_QUOTES) . "' ORDER BY transbook_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['transbook_id'];
}

function getBookDateByTransbookID($id)
{
	$query_transbook = "SELECT transbook_date_d, transbook_date_m, transbook_date_y FROM tadbir.transport_book WHERE transbook_id = '" . htmlspecialchars($id,ENT_QUOTES) . "'";
	$transbook = mysql_query($query_transbook);
	$row_transbook = mysql_fetch_assoc($transbook);

	return date('d / m / Y (D)', mktime(0, 0, 0, $row_transbook['transbook_date_m'], $row_transbook['transbook_date_d'], $row_transbook['transbook_date_y']));
}

function getUserIDByTransbookID($id)
{
	$query_transbook = "SELECT transbook_by FROM tadbir.transport_book WHERE transbook_id = '" . htmlspecialchars($id,ENT_QUOTES) . "'";
	$transbook = mysql_query($query_transbook);
	$row_transbook = mysql_fetch_assoc($transbook);

	return $row_transbook['transbook_by'];
}

function getTitleByTransbookID($id)
{
	$query_transbook = "SELECT transbook_title FROM tadbir.transport_book WHERE transbook_id = '" . htmlspecialchars($id,ENT_QUOTES) . "'";
	$transbook = mysql_query($query_transbook);
	$row_transbook = mysql_fetch_assoc($transbook);

	return $row_transbook['transbook_title'];
}

function getNoTransByTransbookID($id)
{
	$query_transbook = "SELECT transbook_notrans FROM tadbir.transport_book WHERE transbook_id = '" . htmlspecialchars($id,ENT_QUOTES) . "'";
	$transbook = mysql_query($query_transbook);
	$row_transbook = mysql_fetch_assoc($transbook);

	return $row_transbook['transbook_notrans'];
}

function getNoteByTransbookID($id)
{
	$query_transbook = "SELECT transbook_note FROM tadbir.transport_book WHERE transbook_id = '" . htmlspecialchars($id,ENT_QUOTES) . "'";
	$transbook = mysql_query($query_transbook);
	$row_transbook = mysql_fetch_assoc($transbook);

	return $row_transbook['transbook_note'];
}

function getTotalPassengerByTransbookID($id)
{
	$query_transbook = "SELECT passenger_id FROM tadbir.passenger WHERE passenger.transbook_id = '" . htmlspecialchars($id,ENT_QUOTES) . "' AND passenger.passenger_status = 1";
	$transbook = mysql_query($query_transbook);
	$row_transbook = mysql_fetch_assoc($transbook);
	
	$total = mysql_num_rows($transbook);

	return $total;
}

function checkAdminAppByID($id)
{
	$query_ss = "SELECT admin_status FROM tadbir.transport_book WHERE transbook_status=1 AND transbook_id='" . htmlspecialchars($id,ENT_QUOTES) . "'";
	$ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($ss);

	if($row_ss['admin_status']=='1')
		return true;
	else
		return false;
}

function getAdminAppByID($id)
{
	$query_ss = "SELECT admin_status FROM tadbir.transport_book WHERE transbook_id= '".htmlspecialchars($id,ENT_QUOTES)."'";
	$ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($ss);
	
	return $row_ss['admin_status'];
}

function getAdminByByID($id)
{
	$query_ss = "SELECT admin_by FROM tadbir.transport_book WHERE transbook_id= '".htmlspecialchars($id,ENT_QUOTES)."'";
	$ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($ss);
	
	return $row_ss['admin_by'];
}

function getAdminDateByID($id)
{
	$query_ss = "SELECT admin_date FROM tadbir.transport_book WHERE transbook_id= '".htmlspecialchars($id,ENT_QUOTES)."'";
	$ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($ss);
	
	return $row_ss['admin_date'];
}

function getAdminNoteByID($id)
{
	$query_ss = "SELECT admin_note FROM tadbir.transport_book WHERE transbook_id= '".htmlspecialchars($id,ENT_QUOTES)."'";
	$ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($ss);
	
	return $row_ss['admin_note'];
}

function iconBookTransportStatus($id)
{
	if(getAdminAppByID($id)==0)
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/lock.png\" alt=\"Pending\" align=\"absbottom\" />";
	else if(getAdminAppByID($id)==1)
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\" alt=\"Approval\" align=\"absbottom\" />";
	else if(getAdminAppByID($id)==2)	
		echo "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_error.png\" alt=\"Pending\" border=\"0\" align=\"absbottom\" />";
}

function getTransportNameByTransportID($id)
{
	$query_tr = "SELECT transport.transport_name FROM tadbir.transport LEFT JOIN tadbir.transdriver ON transport.transport_id = transdriver.transport_id= '".htmlspecialchars($id,ENT_QUOTES)."' WHERE transdriver_status = 1 GROUP BY transdriver.transport_id";
	$tr = mysql_query($query_tr);
	$row_tr = mysql_fetch_assoc($tr);
	
	return $row_tr['transport_name'];
}

function getDriverNameByID($id)
{
	$query_ss = "SELECT user_stafid FROM tadbir.driver WHERE driver_id = '" . htmlspecialchars($id,ENT_QUOTES) . "'";
	$ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($ss);

	return getFullNameByStafID($row_ss['user_stafid']);
}

function getStafIDByID($id)
{
	$query_ss = "SELECT user_stafid FROM tadbir.driver WHERE driver_id = '" . htmlspecialchars($id,ENT_QUOTES) . "'";
	$ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($ss);
	
	return $row_ss['user_stafid'];
}

function getTransportNameByID($id)
{
	$query_ss = "SELECT transport_name FROM tadbir.transport WHERE transport_id = '" . htmlspecialchars($id,ENT_QUOTES) . "'";
	$ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($ss);

	return $row_ss['transport_name'];
}

function getTransportPlatByID($id)
{
	$query_ss = "SELECT transport_plat FROM tadbir.transport WHERE transport_id = '" . htmlspecialchars($id,ENT_QUOTES) . "'";
	$ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($ss);
	
	return strtoupper($row_ss['transport_plat']);
}

function getTransportPlatByTransportID($id)
{
	$query_ss = "SELECT transport.transport_plat FROM tadbir.transport LEFT JOIN tadbir.transdriver ON transport.transport_id = transdriver.transport_id= '".htmlspecialchars($id,ENT_QUOTES)."' WHERE transdriver_status = 1 GROUP BY transdriver.transport_id";
	$ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($ss);

	return $row_ss['transport_plat'];
}

function checkUserIDByTransID($tid, $userid)
{
	//semak sama ada user telah didaftarkan dalam senarai penumpang
	$query_ss = "SELECT passenger_id FROM tadbir.passenger WHERE passenger_status = '1' AND passenger.user_stafid = '" . htmlspecialchars($userid, ENT_QUOTES) . "' AND transbook_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY passenger_id ASC";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	if($total>0)
		return true;
	else
		return false;
}

//rating

function checkTransbookEndByTransID($id)
{
	// semak sama ada tarikh tempahan sudah berlalu
	$query_tr = "SELECT transport_book.transbook_id, journey.journey_date_d, journey.journey_date_m, journey.journey_date_y FROM tadbir.transport_book LEFT JOIN (SELECT * FROM tadbir.journey WHERE journey_status = 1 AND journey.transbook_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND ((journey.journey_date_d < '" . date('d') . "' AND journey.journey_date_m = '" . date('m') . "' AND journey.journey_date_y = '" . date('Y') . "') OR (journey.journey_date_m < '" . date('m') . "' AND journey.journey_date_y = '" . date('Y') . "') OR (journey.journey_date_y < '" . date('Y') . "')) ORDER BY journey_date_y DESC, journey_date_m DESC, journey_date_d DESC) AS journey ON journey.transbook_id = transport_book.transbook_id WHERE journey.journey_id  IS NOT NULL AND NOT EXISTS (SELECT user_feedback.transbook_id FROM tadbir.user_feedback WHERE user_feedback.transbook_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' GROUP BY userfeedback_by, transbook_id) AND transport_book.transbook_id = '".htmlspecialchars($id, ENT_QUOTES)."' AND transport_book.transbook_status = '1' ORDER BY transport_book.transbook_id DESC";
	$tr = mysql_query($query_tr);
	$row_tr = mysql_fetch_assoc($tr);

	$total = mysql_num_rows($tr);

	if($total > 0)
		return true;
	else
		return false;
}

function checkDelTransbookByTransbookID($tid)
{
	// Semakkan sekiranya tempahan kenderaan dibatalkan 
	$query_tr = "SELECT transbook_status FROM tadbir.transport_book WHERE transbook_id='" . htmlspecialchars($tid, ENT_QUOTES) . "'";
	$tr = mysql_query($query_tr);
	$row_tr = mysql_fetch_assoc($tr);
	
	return $row_tr['transbook_status'];
}

function checkFeedback($id)
{
	$query_tr = "SELECT userfeedback_id FROM tadbir.user_feedback WHERE userfeedback_status = '1' AND transbook_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$tr = mysql_query($query_tr);
	$row_tr = mysql_fetch_assoc($tr);

	$total = mysql_num_rows($tr);

	if($total > 0)
		return true;
	else
		return false;
}

function checkAdminDelByTransdriverID($id)
{
	// Semakkan sekiranya nama pemandu dipadam dalam senarai booking
	$query_transdriver = "SELECT transdriver_status FROM tadbir.transdriver WHERE transdriver_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$transdriver = mysql_query($query_transdriver);
	$row_transdriver = mysql_fetch_assoc($transdriver);

	return $row_transdriver['transdriver_status'];
}

function getTransbookIDbyFeedbackID($reportid)
{
	$query_ss = "SELECT user_feedback.transbook_id FROM tadbir.user_feedback LEFT JOIN tadbir.transport_book ON transport_book.transbook_id = user_feedback.transbook_id WHERE user_feedback.userfeedback_id = '" . htmlspecialchars($reportid, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['transbook_id'];
}

function checkUserFeedbackByUserID($id)
{
	$query_tr = "SELECT transport_book.transbook_id, journey.journey_date_d, journey.journey_date_m, journey.journey_date_y FROM tadbir.transport_book LEFT JOIN (SELECT * FROM tadbir.journey WHERE journey_status = 1 ORDER BY journey_date_y ASC, journey_date_m ASC, journey_date_d ASC) AS journey ON journey.transbook_id = transport_book.transbook_id WHERE NOT EXISTS (SELECT user_feedback.transbook_id FROM tadbir.user_feedback WHERE user_feedback.transbook_id = transport_book.transbook_id GROUP BY userfeedback_by, transbook_id) AND ((journey.journey_date_d < '" . date('d') . "' AND journey.journey_date_m = '" . date('m') . "' AND journey.journey_date_y = '" . date('Y') . "') OR (journey.journey_date_m < '" . date('m') . "' AND journey.journey_date_y = '" . date('Y') . "') OR (journey.journey_date_y < '" . date('Y') . "')) AND transbook_by = '".htmlspecialchars($id, ENT_QUOTES)."' AND transport_book.admin_status = '1' AND transbook_status = '1' ORDER BY journey_date_y ASC, journey_date_m ASC, journey_date_d ASC";
	$tr = mysql_query($query_tr);
	$row_tr = mysql_fetch_assoc($tr);

	$total = mysql_num_rows($tr);

	if($total > 0)
		return true;
	else
		return false;
}

function getTransbookIDByJourneyID($tid)
{		
	$query_ss = "SELECT transbook_id FROM tadbir.journey WHERE journey_status = '1' AND journey_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY transbook_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['transbook_id'];
}

function getJourneyTimeByJourneyID($jid)
{		
	$query_ss = "SELECT journey_date_d, journey_date_m, journey_date_y, journey_time_h, journey_time_m FROM tadbir.journey WHERE journey_status = '1' AND journey_id = '" . htmlspecialchars($jid, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return date('h:i A', mktime($row_ss['journey_time_h'], $row_ss['journey_time_m'], 0, $row_ss['journey_date_m'], $row_ss['journey_date_d'], $row_ss['journey_date_y']));;
}

function checkJourney1HourByJourneyID($jid)
{		
	$query_ss = "SELECT journey_date_d, journey_date_m, journey_date_y, journey_time_h, journey_time_m FROM tadbir.journey WHERE journey_status = '1' AND journey_id = '" . htmlspecialchars($jid, ENT_QUOTES) . "' ORDER BY journey.journey_id LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	if(($row_ss['journey_date_y']==date('Y') && $row_ss['journey_date_m']==date('m') && $row_ss['journey_date_d']==date('d')) && ($row_ss['journey_time_h']>=date('G') && $row_ss['journey_time_h']<=date('G', mktime(date('G')+1, date('m'), 0, date('m'), date('d'), date('Y')))))
		return true;
	else
		return false;
}

function getFeedbackNameByID($id)
{
	$query_ss = "SELECT feedback_name FROM tadbir.feedback WHERE feedback_id = '" . htmlspecialchars($id,ENT_QUOTES) . "'";
	$ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($ss);
	
	return $row_ss['feedback_name'];
}

//statistik feedback

function percentTransAnswer($fid, $ans)
{
	if(countTransAnswer($fid, $ans)!=0 && countTransUserAnswer($fid)!=0)
		return round((countTransAnswer($fid, $ans)/countTransUserAnswer($fid))*100);
	else
		return 0;
};

function countTransAnswer($fid, $ans)
{
	$query_ss = "SELECT COUNT(userfeedback_id) AS count FROM tadbir.user_feedback WHERE feedback_id = '" . htmlspecialchars($fid,ENT_QUOTES) . "' AND userfeedback_answer = '" . $ans . "' GROUP BY userfeedback_answer";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	$total = mysql_num_rows($user_ss);

	if($row_ss['count']!=NULL)
		return $row_ss['count'];
	else
		return 0;
};

function countTransUserAnswer($fid)
{
	$query_ss = "SELECT user_feedback.userfeedback_id FROM tadbir.user_feedback WHERE feedback_id = '" . htmlspecialchars($fid,ENT_QUOTES) . "'";
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	$total = mysql_num_rows($user_ss);

	return $total;
};

function averageTransAnswer($fid)
{
	$total = 0;
	$anstotal = 0;
	
	for($i=1; $i<=5; $i++)
	{
		$anstotal += countTransAnswer($fid, $i)*$i;
		$total += countTransAnswer($fid, $i);
	};

	if($total>0)
		$ave = round(($anstotal / $total),2);
	else
		$ave = 0;

	return $ave;
};

// Statistik

function getTotalJourneyByDriverID($driverid=0, $d=0, $m=0, $y=0)
{
	$wsql = "";
	
	if($driverid!=0)
		$wsql .= " AND transdriver.driver_id = '" . htmlspecialchars($driverid,ENT_QUOTES) . "'";
	if($d!=0)
		$wsql .= " AND journey.journey_date_d = '" . htmlspecialchars($d,ENT_QUOTES) . "' ";
	if($m!=0)
		$wsql .= " AND journey.journey_date_m = '" . htmlspecialchars($m,ENT_QUOTES) . "' ";
	if($y!=0)
		$wsql .= " AND journey.journey_date_y = '" . htmlspecialchars($y,ENT_QUOTES) . "' ";
	
	$query_ss = "SELECT journey.journey_id FROM tadbir.journey LEFT JOIN tadbir.transport_book ON transport_book.transbook_id = journey.transbook_id LEFT JOIN tadbir.transdriver ON transdriver.transbook_id = journey.transbook_id WHERE EXISTS (SELECT * FROM tadbir.transdriver WHERE transdriver.transbook_id = journey.transbook_id) AND journey.journey_status = 1 " . $wsql . " ORDER BY journey.journey_date_y DESC, journey.journey_date_m DESC, journey.journey_date_d DESC, journey.journey_time_h DESC, journey.journey_time_m DESC, journey.journey_id DESC";
	$ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($ss);
	
	$total = mysql_num_rows($ss);
	
	return $total;
}

function getPercJourneyByDriverID($driverid, $d=0, $m=0, $y=0)
{
	if(getTotalJourneyByDriverID(0, $d, $m, $y)!=0)
		$perc = round((getTotalJourneyByDriverID($driverid, $d, $m, $y)/getTotalJourneyByDriverID(0, $d, $m, $y))*100);
	else
		$perc = 0;
	
	return $perc;
}

function getTotalTransbook($transportid, $d, $m, $y)
{
	$wsql = "";

	if($transportid != 0)
		$wsql .=  " AND transdriver.transport_id = '" . htmlspecialchars($transportid,ENT_QUOTES) . "'";
	else
		$wsql = "";

	$query_tr= "SELECT transdriver_id FROM tadbir.transdriver LEFT JOIN tadbir.transport_book ON transport_book.transbook_id = transdriver.transbook_id WHERE transport_book.transbook_date_d='" . htmlspecialchars($d,ENT_QUOTES) . "' AND transport_book.transbook_date_m='" . htmlspecialchars($m, ENT_QUOTES) . "' AND transport_book.transbook_date_y='" . htmlspecialchars($y,ENT_QUOTES) . "' " . $wsql . " AND transdriver.transdriver_status='1'";
	$tr= mysql_query($query_tr);
	$row_tr = mysql_fetch_assoc($tr);

	$total = mysql_num_rows($tr);

	return $total;
}

function countTotalTransbookNeedApproval($d, $m, $y)
{
	$wsql = "";

	if($d!=0)
		$wsql .= " AND transbook_date_d = '" . htmlspecialchars($d,ENT_QUOTES) . "'";

	if($m!=0)

		$wsql .= " AND transbook_date_m = '" . htmlspecialchars($m,ENT_QUOTES) . "'";

	if($y!=0)
		$wsql .= " AND transbook_date_y = '" . htmlspecialchars($y,ENT_QUOTES) . "'";

	$query_transbook = "SELECT transbook_id FROM tadbir.transport_book WHERE admin_status = 0 AND transbook_status = 1 " . $wsql . " ORDER BY transbook_date_y DESC, transbook_date_m DESC, transbook_date_d DESC, transbook_id DESC";
	$transbook = mysql_query($query_transbook);
	$row_ictitem = mysql_fetch_assoc($transbook);

	$total = mysql_num_rows($transbook);
	
	return $total;
}

function getTotalTransportTypeByMonth($trid, $d=0, $m, $y)
{
	$wsql = "";
	
	if($trid != 0)
		$wsql .= " AND transport_book.transport_id = '" . htmlspecialchars($trid,ENT_QUOTES) . "'";
	if($d!=0)
		$wsql .= " AND transport_book.transbook_date_d = '" . htmlspecialchars($d,ENT_QUOTES) . "'";

	$query_tr = "SELECT transport_book.transbook_id FROM tadbir.transport_book WHERE transport_book.transbook_date_m='" . htmlspecialchars($m,ENT_QUOTES) . "' AND transport_book.transbook_date_y='" . htmlspecialchars($y,ENT_QUOTES) . "' " . $wsql . " AND transport_book.transbook_status='1'";
	$tr = mysql_query($query_tr);
	$row_tr = mysql_fetch_assoc($tr);
	
	$total = mysql_num_rows($tr);

	return $total;
}

function getPercStarRatingByDriverID($userid, $m, $y)
{
	$total = getTotalStarRatingByDriverID($userid, $m, $y);

	if($total!=0)
		$perc = ((getTotalStarRatingByDriverID($userid, $m, $y)/$total)*100);
	else
		$perc = 0;
		
	return $perc;
}

function getTotalStarRatingByDriverID($userid, $m, $y)
{
	$wsql = "";

	if($m!= 0)
		$wsql .= " AND transport_book.transbook_date_m = '" . htmlspecialchars($m,ENT_QUOTES) . "'";
	if($y!=0)
	
		$wsql .= " AND transport_book.transbook_date_y = '" . htmlspecialchars($y, ENT_QUOTES) . "'";

	$query_tr = "SELECT COUNT(user_report.userreport_star) AS totalstar FROM ict.user_report LEFT JOIN ict.user_reportfeedback ON user_reportfeedback.userreport_id = user_report.userreport_id WHERE user_reportfeedback.urf_status = 1 AND user_reportfeedback.feedbacktype_id = '0' AND user_reportfeedback.urf_by = '" . htmlspecialchars($userid,ENT_QUOTES) . "' AND user_report.userreport_status='1' " . $wsql . " GROUP BY user_reportfeedback.urf_by";
	$ictitem = mysql_query($query_ictitem);
	$row_ictitem = mysql_fetch_assoc($ictitem);

	return ($row_ictitem['totalstar']*5);
}
?>
<?php 
//penyelenggaraan kenderaan
function getTypeNameByID($id)
{
	$query_type = "SELECT transporttype_id, transporttype_name FROM tadbir.transport_type WHERE transporttype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);

	return ($row_type['transporttype_name']);
}

function getTransportNameByTypeID($id)
{
	$query_type = "SELECT transporttype_id, transport_name FROM tadbir.transport WHERE transporttype_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);
	
	return strtoupper($row_type['transport_name']);
}

function getMaintenanceIDByUserID($user, $day, $month, $year)
{
	$query_maintenance = "SELECT maintenance_id FROM tadbir.maintenance WHERE maintenance_by = '" . $user . "' AND maintenance_d = '" . $day . "' AND maintenance_m = '" . $month . "' AND maintenance_y = '" . $year . "' ORDER BY maintenance_y DESC, maintenance_m DESC, maintenance_d DESC, maintenance_id DESC";
	$maintenance = mysql_query($query_maintenance);
	$row_maintenance = mysql_fetch_assoc($maintenance);

	return $row_maintenance['maintenance_id'];
}

function getMaintenanceIDByMainTypeID($mtid)
{		
	$query_ss = "SELECT maintenance_id FROM tadbir.maintenance_normalize WHERE mainnormalize_status = '1' AND maintenancetype_id = '" . htmlspecialchars($mtid, ENT_QUOTES) . "' ORDER BY maintenance_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['maintenance_id'];
}

function getMaintenanceBy($mid)
{		
	$query_ss = "SELECT maintenance_by FROM tadbir.maintenance WHERE maintenance_status = '1' AND maintenance_id = '" . htmlspecialchars($mid, ENT_QUOTES) . "' ORDER BY maintenance_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['maintenance_by'];
}

function getOdometerByID($mid)
{		
	$query_ss = "SELECT maintenance_odometer FROM tadbir.maintenance WHERE maintenance_status = '1' AND maintenance_id = '" . htmlspecialchars($mid, ENT_QUOTES) . "' ORDER BY maintenance_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['maintenance_odometer'];
}

function getMaintenanceNoteByID($mid)
{		
	$query_ss = "SELECT maintenance_note FROM tadbir.maintenance WHERE maintenance_status = '1' AND maintenance_id = '" . htmlspecialchars($mid, ENT_QUOTES) . "' ORDER BY maintenance_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['maintenance_note'];
}

function getTransportNameByMaintenanceID($mid)
{		
	$query_ss = "SELECT transport.transport_name FROM tadbir.transport LEFT JOIN tadbir.maintenance ON transport.transport_id= maintenance.transport_id WHERE maintenance_status = '1' AND maintenance_id = '" . htmlspecialchars($mid, ENT_QUOTES) . "' ORDER BY maintenance_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['transport_name'];
}

function getTypeNameByMaintenanceID($id)
{
	$query_type = "SELECT transporttype_name FROM tadbir.transport_type LEFT JOIN tadbir.transport ON transport_type.transporttype_id=transport.transporttype_id LEFT JOIN tadbir.maintenance ON transport.transport_id=maintenance.transport_id WHERE maintenance_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);

	return ($row_type['transporttype_name']);
}

function getTransportPlatByMaintenanceID($mid)
{		
	$query_ss = "SELECT transport.transport_plat FROM tadbir.transport LEFT JOIN tadbir.maintenance ON transport.transport_id= maintenance.transport_id WHERE maintenance_status = '1' AND maintenance_id = '" . htmlspecialchars($mid, ENT_QUOTES) . "' ORDER BY maintenance_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return $row_ss['transport_plat'];
}

//icon kelulusan Admin
function iconAdminApp($mid)
{
	if(checkAdminApp($mid))
	{
		if(checkAdminApprOrNot($mid))
			$view = "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\"";
		else
			$view = "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_error.png\"";
	} else {
		$view = "<img src=\"" . $GLOBALS['url_main'] . "icon/lock.png\"";
	}

	return $view;
}

function checkAdminApp($mid)
{		
	$query_ss = "SELECT maintenance_adminby FROM tadbir.maintenance WHERE maintenance_status = '1' AND maintenance_id = '" . htmlspecialchars($mid, ENT_QUOTES) . "' ORDER BY maintenance_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($row_ss['maintenance_adminby']!=NULL)
		return true;
	else
		return false;
}

function checkAdminApprOrNot($mid)
{		
	$query_ss = "SELECT maintenance_adminstatus FROM tadbir.maintenance WHERE maintenance_status = '1' AND maintenance_id = '" . htmlspecialchars($mid, ENT_QUOTES) . "' ORDER BY maintenance_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($row_ss['maintenance_adminstatus']==1)
		return true;
	else
		return false;
}

function getAdminAppBy($mid)
{		
	$query_ss = "SELECT maintenance_adminby FROM tadbir.maintenance WHERE maintenance_status = '1' AND maintenance_id = '" . htmlspecialchars($mid, ENT_QUOTES) . "' ORDER BY maintenance_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['maintenance_adminby'];
}

function getAdminAppDateByID($mid)
{		
	$query_ss = "SELECT maintenance_admindate FROM tadbir.maintenance WHERE maintenance_status = '1' AND maintenance_id = '" . htmlspecialchars($mid, ENT_QUOTES) . "' ORDER BY maintenance_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['maintenance_admindate'];
}

function getAdminAppNoteByID($mid)
{		
	$query_ss = "SELECT maintenance_adminnote FROM tadbir.maintenance WHERE maintenance_status = '1' AND maintenance_id = '" . htmlspecialchars($mid, ENT_QUOTES) . "' ORDER BY maintenance_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['maintenance_adminnote'];
}

//Ketua Meluluskan
function checkMaintenanceValid($mid)
{		
	$query_ss = "SELECT  maintenance_validby FROM tadbir.maintenance WHERE maintenance_status = '1' AND maintenance_id = '" . htmlspecialchars($mid, ENT_QUOTES) . "' ORDER BY maintenance_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($row_ss['maintenance_validby']!=NULL)
		return true;
	else
		return false;
}

function checkValidOrNot($mid)
{		
	$query_ss = "SELECT maintenance_validstatus FROM tadbir.maintenance WHERE maintenance_status = '1' AND maintenance_id = '" . htmlspecialchars($mid, ENT_QUOTES) . "' ORDER BY maintenance_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($row_ss['maintenance_validstatus']==1)
		return true;
	else
		return false;
}

function iconMaintenanceValid($mid)
{
	if(checkMaintenanceValid($mid))
	{
		if(checkValidOrNot($mid))
			$view = "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\"";
		else
			$view = "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_error.png\"";
	} else {
		$view = "<img src=\"" . $GLOBALS['url_main'] . "icon/lock.png\"";
	}

	return $view;
}

function getValidBy($mid)
{		
	$query_ss = "SELECT maintenance_validby FROM tadbir.maintenance WHERE maintenance_status = '1' AND maintenance_id = '" . htmlspecialchars($mid, ENT_QUOTES) . "' ORDER BY maintenance_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['maintenance_validby'];
}

function getValidDateByID($mid)
{		
	$query_ss = "SELECT maintenance_validdate FROM tadbir.maintenance WHERE maintenance_status = '1' AND maintenance_id = '" . htmlspecialchars($mid, ENT_QUOTES) . "' ORDER BY maintenance_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['maintenance_validdate'];
}

function getValidNoteByID($mid)
{		
	$query_ss = "SELECT maintenance_validnote FROM tadbir.maintenance WHERE maintenance_status = '1' AND maintenance_id = '" . htmlspecialchars($mid, ENT_QUOTES) . "' ORDER BY maintenance_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['maintenance_validnote'];
}

function getRoadTaxDateByTransportID($tid)
{		
	$query_ss = "SELECT roadtax_date_d, roadtax_date_m, roadtax_date_y FROM tadbir.roadtax LEFT JOIN tadbir.transport ON roadtax.transport_id=transport.transport_id  WHERE roadtax_status = '1' AND transport.transport_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	return date('d / m / Y', mktime(0, 0, 0, $row_ss['roadtax_date_m'], $row_ss['roadtax_date_d'], $row_ss['roadtax_date_y']));
}

function checkRoadtaxByTransportID($tid)
{	
	$query_ss = "SELECT roadtax_id FROM tadbir.roadtax WHERE transport_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' AND roadtax_status = '1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	$total = mysql_num_rows($user_ss);

	if($total > 0)
		return true;
	else
		return false;
}

//Check sama ada tarikh roadtax sudah ada atau tiada
function checkRoadtaxkDateByTransportID($tid)
{
	$query_roadtax = "SELECT transport_id FROM tadbir.roadtax WHERE transport_id = '" . $tid . "'";
	$roadtax = mysql_query($query_roadtax);
	$row_roadtax = mysql_fetch_assoc($roadtax);
	$total = mysql_num_rows($roadtax);

	if($total > 0)
		return true;
	else
		return false;
}

function getMaintenanceDateByID($mid)
{		
	$query_ss = "SELECT maintenance_d, maintenance_m, maintenance_y FROM tadbir.maintenance WHERE maintenance_status = '1' AND maintenance_id = '" . htmlspecialchars($mid, ENT_QUOTES) . "' ORDER BY maintenance_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['maintenance_m'], $row_ss['maintenance_d'], $row_ss['maintenance_y']));
}

//Admin Update Data
function checkMaintenanceApp($id)
{		
	$query_ss = "SELECT  maintenance_appby FROM tadbir.maintenance WHERE maintenance_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY maintenance_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($row_ss['maintenance_appby']!=NULL)
		return true;
	else
		return false;
}

function iconMaintenanceApp($mid)
{
	if(checkMaintenanceApp($mid))
		$view = "<img src=\"" . $GLOBALS['url_main'] . "icon/sign_tick.png\"";
	else
		$view = "<img src=\"" . $GLOBALS['url_main'] . "icon/lock.png\"";

	return $view;
}

function getMainTypeNameByMaintenanceID($id)
{
	$query_type = "SELECT maintenancetype_name FROM tadbir.maintenance_type LEFT JOIN tadbir.maintenance_normalize ON maintenance_type.maintenancetype_id=maintenance_normalize.maintenancetype_id WHERE maintenance_normalize.maintenance_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$type = mysql_query($query_type);
	$row_type = mysql_fetch_assoc($type);

	return ($row_type['maintenancetype_name']);
}

function getMaintenanceDateByTransportID($tid)
{		
	$query_ss = "SELECT maintenance_d, maintenance_m, maintenance_y FROM tadbir.maintenance LEFT JOIN tadbir.transport ON maintenance.transport_id=transport.transport_id  WHERE maintenance_status = '1' AND transport.transport_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return date('d / m / Y', mktime(0, 0, 0, $row_ss['maintenance_m'], $row_ss['maintenance_d'], $row_ss['maintenance_y']));
}

function getDescNameByID($id)
{
	$query_desc = "SELECT desc_name FROM tadbir.description WHERE desc_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$desc = mysql_query($query_desc);
	$row_desc = mysql_fetch_assoc($desc);

	return ($row_desc['desc_name']);
}

function getTadbirCategoryNameByID($id)
{
	$query_cat = "SELECT category_name FROM tadbir.category WHERE category_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$cat = mysql_query($query_cat);
	$row_cat = mysql_fetch_assoc($cat);

	return ($row_cat['category_name']);
}

function getTransportIDByMaintenanceID($mid)
{
	$query_tr = "SELECT transport_id FROM tadbir.maintenance WHERE maintenance_id = '" . htmlspecialchars($mid, ENT_QUOTES) . "'";
	$tr = mysql_query($query_tr);
	$row_tr = mysql_fetch_assoc($tr);
	
	return ($row_tr['transport_id']);
}

//Transport Agency
function getTransagencyNameByID($tid)
{		
	$query_ss = "SELECT transagency_name FROM tadbir.transport_agency WHERE transagency_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY transagency_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['transagency_name'];
}

function getTransagencyNoTelByID($tid)
{		
	$query_ss = "SELECT transagency_notel FROM tadbir.transport_agency WHERE transagency_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY transagency_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['transagency_notel'];
}

function getTransagencyNoFaxByID($tid)
{		
	$query_ss = "SELECT transagency_nofax FROM tadbir.transport_agency WHERE transagency_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY transagency_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['transagency_nofax'];
}

function getTransagencyEmailByID($tid)
{		
	$query_ss = "SELECT transagency_email FROM tadbir.transport_agency WHERE transagency_id = '" . htmlspecialchars($tid, ENT_QUOTES) . "' ORDER BY transagency_id DESC LIMIT 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	return $row_ss['transagency_email'];
}

function getAmountByID($mid)
{
	$query_ss = "SELECT SUM(descinv_amount) AS total FROM tadbir.desc_invoice WHERE maintenance_id = '" . htmlspecialchars($mid, ENT_QUOTES) . "' ORDER BY maintenance_id";
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total= $row_ss['total'];
	
	return $total;
}
?>