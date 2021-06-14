<?php
//ekad
function viewKadByCardID($id)
{
	$query_userid = "SELECT card_img FROM ekad.card WHERE card_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	return $GLOBALS['url_main'] . "ekad/" . $row_userid['card_img'];
}

function viewKadNoteByCardID($id)
{
	$query_userid = "SELECT card_note FROM ekad.card WHERE card_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	return $row_userid['card_note'];
}

function getKadCatByCardID($id)
{
	$query_userid = "SELECT cat_id FROM ekad.card WHERE card_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	return $row_userid['cat_id'];
}

function getCatTextByCardID($id)
{
	$query_userid = "SELECT cat_text FROM ekad.cat WHERE cat_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$userid = mysql_query($query_userid);
	$row_userid = mysql_fetch_assoc($userid);
	
	return $row_userid['cat_text'];
}

function getCardDesign($cardid, $namapenerima, $ucapan, $stafid)
{
	if($stafid == '0')
	{
		$stafinfo = "Seluruh kakitangan";
		$dir = "Bahagian Khidmat Pengurusan";
	} else {
		$stafinfo = getFullNameByStafID(htmlspecialchars($stafid, ENT_QUOTES));
		$dir = getFulldirectoryByUserID(htmlspecialchars($stafid, ENT_QUOTES));
	}
	
	$dg = "<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"10\" cellspacing=\"0\" style=\" background-color: #EFEFEF;\">";
	$dg .= "<tr><td>";
	$dg .= "<table width=\"100\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" style=\"background-color: #FFFFFF; border:#999 1px solid;\">";
	$dg .= "<tr><td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"font-family:Tahoma, Geneva, sans-serif; font-size:13px; background-color: #FFFFFF;\">";
	$dg .= "<tr><td align=\"center\" valign=\"top\"><img src=\"" . viewKadByCardID($cardid) . "\" align=\"middle\" /></td>";
	$dg .= "</tr>";
	
	if(viewKadNoteByCardID($cardid)!=NULL)
	{
		$dg .= "<tr><td align=\"center\" valign=\"top\" style=\"background-color: #FFFFFF;\">
				<span style=\"font-family:Tahoma, Geneva, sans-serif; font-size: 9px; color:#BBB;\">" . viewKadNoteByCardID($cardid) . "</span></td>";
		$dg .= "</tr>";
	};
	
	$dg .= "<tr><td align=\"center\" valign=\"top\">";
	$dg .= "<br/><br/><table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"20\" cellspacing=\"0\" style=\"font-family:Tahoma, Geneva, sans-serif; font-size:13px;\">";
	$dg .= "<tr><td width=\"50%\" align=\"left\" valign=\"top\" style=\"border-right:solid #CCC 1px;\">Khas buat<br/><br/><span style=\" font-weight:bold;\">" . strtoupper($namapenerima) . "</span><br/><br/><span>" .  $ucapan . "</span></td><td width=\"50%\" align=\"left\" valign=\"top\" style=\"text-align:left;\">Ikhlas daripada <br/><br/><span style=\" font-weight:bold;\">" . $stafinfo . "</span><br/>" . $dir . "<br/><br/>Institut Sukan Negara Malaysia<br/>Kuala Lumpur</td></tr></table></td></tr>";
	
	if(getKadCatByCardID($cardid)!=0)
	{
		$dg .= "<tr><td align=\"center\" valign=\"top\" style=\"font-family:Tahoma, Geneva, sans-serif; font-size: 12px;\"><br/><br/><span>" . getCatTextByCardID(getKadCatByCardID($cardid)) . "</span><br/><br/></td></tr>";
	};
	
	$dg .= "<tr><td align=\"center\" valign=\"top\" style=\"font-family:Tahoma, Geneva, sans-serif; font-size: 11px; color: #666;\"><br/><br/><span>web : www.isn.gov.my &nbsp; &nbsp; &bull; &nbsp; &nbsp; twitter : @isnmas</span><br/></td></tr><tr><td align=\"center\" valign=\"top\" style=\"font-family:Tahoma, Geneva, sans-serif; font-size: 11px; color:#CCC; padding: 20px;\"><br/><br/><span>Email ini dihantar melalui " . $GLOBALS['systitle_full'] . ". Institut Sukan Negara Malaysia adalah tidak bertanggungjawab bagi apa-apa kehilangan atau kerugian yang disebabkan oleh penggunaan mana-mana maklumat yang diperolehi dari sistem ini.</span><br/><br/></td></tr></table></td></tr></table></td></tr></table>";
	
	return $dg;
}
?>