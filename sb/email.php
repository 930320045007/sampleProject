<?php include("Mail.php");

?>
<?php
function emailset()
{
	// $smtpinfo["host"] = "webmail.nsc.gov.my";
	$smtpinfo["host"] = "170.10.3.99";
	$smtpinfo["port"] = "587"; //587 - 465
	$smtpinfo["auth"] = true;
	$smtpinfo["username"] = "spsm@nsc.gov.my";
	$smtpinfo["password"] = "S1P2S3M4@1234x";
 	$smtp = @Mail::factory('smtp', $smtpinfo);
	
	return $smtp;
	
}

function addUser($to, $from, $subject, $type, $id)
{
	// Email kpd ICt dan ketua berkaitan pendaftaran staff baru dalam sistem SPSM
	//to = array senarai StafID penerima
	//subject = tajuk
	//type = jenis leave type, cth 1 - cuti tahunan
	//id = Staf ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT user.* FROM www.user WHERE user.user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) // 1 - Hantar email kpd ICT SysAcc
	{	
		
	//email kepada Head untuk maklum berkaitan pendaftaran Staf baru
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;


Untuk makluman, pendaftaran staf dalam <?php echo $GLOBALS['systitle_short'];?> seperti berikut :-


Nama : <?php echo getFullNameByStafID($row_ss['user_stafid']) . " (" . $row_ss['user_stafid'] . ")";?> 
Jawatan : <?php echo getJobtitle($row_ss['user_stafid']);?> (<?php echo getGred($row_ss['user_stafid']);?>)
Unit : <?php echo getFulldirectoryByUserID($row_ss['user_stafid']);?>


Pendaftar : <?php echo getFullNameByStafID($row_ss['user_by']) . " (" . $row_ss['user_by'] . ")";?> 
Tarikh : <?php echo $row_ss['user_date'];?>



Untuk maklumat lanjut berkaitan pendaftaran ini, sila hubungi <?php echo $GLOBALS['adname'];?> atau layari <?php echo $GLOBALS['systitle_short'];?> pada URL berikut <?php echo $GLOBALS['url_main'];?>


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageHead = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Pendaftaran Staf Baru";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
	if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
	{
		foreach($to as $key => $value)
		{
			$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
			
			if($type == 1 && getStatusTFByStafID($value))
			{ // email kpd ICT
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageHead, $format);
			}
		}
	}
}

function activateEmail($to, $from, $subject, $type, $id)
{
	// Email kpd Staf berkaitan pengaktifan akaun
	//to = array senarai Head ID penerima
	//subject = tajuk
	//type = jenis leave type, cth 1 - cuti tahunan
	//id = Staf ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT user.* FROM www.user WHERE user.user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) // 1 - Hantar email kpd Staf
	{	
	
	//email kepada Staf maklum pengaktifan akaun
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Untuk makluman, pengaktifan akaun telah dibuat dalam <?php echo $GLOBALS['systitle_short'];?> seperti berikut :-


Email Pengguna : <?php echo getEmailISNByUserID(htmlspecialchars($id, ENT_QUOTES));?>

Kata Laluan <?php echo $GLOBALS['systitle_short'];?> : <?php echo getDKey();?>


Sila daftar masuk untuk penukaran Kata Laluan baru dengan kadar segera. <?php echo $GLOBALS['systitle_full'];?> boleh diakses melalui URL berikut <?php echo $GLOBALS['url_main'];?>. 

Akaun email rasmi MSN boleh diakses pada URL berikut http://webmail.nsc.gov.my . Sila gunakan Kata Laluan Email sementara iaitu a1b2c3d4e5 . Perlu diingatkan bahawa kata laluan adalah sensitif, sila masukkan seperti mana yang dinyatakan dan menukar kepada kata laluan peribadi selepas mendaftar masuk.

Sekiranya terdapat kesilapan berkaitan maklumat kerjaya dalam <?php echo $GLOBALS['systitle_short'];?>, sila berhubung dengan <?php echo $GLOBALS['adname'];?>.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	
	//email kpd ketua Unit	
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Untuk makluman, pengaktifan akaun kepada kakitangan dibawah seliaan tuan/puan telah dibuat dalam <?php echo $GLOBALS['systitle_short'];?> seperti berikut :-


Nama : <?php echo getFullNameByStafID(htmlspecialchars($id, ENT_QUOTES)) . " (" . htmlspecialchars($id, ENT_QUOTES) . ")";?> 
Jawatan : <?php echo getJobtitleReal(htmlspecialchars($id, ENT_QUOTES));?> (<?php echo getGred(htmlspecialchars($id, ENT_QUOTES)); ?>)

Email rasmi MSN : <?php echo getEmailISNByUserID(htmlspecialchars($id, ENT_QUOTES));?>



Mohon tuan/puan untuk memaklumkan dan memberi panduan untuk mengaktifkan SPSM kakitangan tersebut bagi memudahkan pengurusan kerjaya dan pentadbiran kakitangan dibawah seliaan tuan/puan. <?php echo $GLOBALS['systitle_full'];?> boleh diakses melalui URL berikut <?php echo $GLOBALS['url_main'];?>.


Akaun email rasmi MSN boleh diakses pada URL berikut http://webmail.nsc.gov.my . Sila gunakan Kata Laluan Email sementara iaitu a1b2c3d4e5 . Perlu diingatkan bahawa kata laluan adalah sensitif, sila masukkan seperti mana yang dinyatakan dan menukar kepada kata laluan peribadi selepas mendaftar masuk.


Sekian, terima kasih.

Makluman ini dihantar kepada Ketua Bahagian/Cawangan/Pusat/Unit  melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageHead = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Pengaktifan akaun " . $GLOBALS['systitle_short'];
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
	if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
	{
		$headers = array ('From' => $from, 'To' => getEmailISNByUserID($id), 'Subject' => $subject);
		
		$mail = $smtp->send(getEmailISNByUserID(htmlspecialchars($id, ENT_QUOTES)), $headers, $message, $format); // kepada Staf ID
		$mail = $smtp->send(getEmailISNByUserID(htmlspecialchars($to, ENT_QUOTES)), $headers, $messageHead, $format); // kepada Head 
	}
}

function emailLeave($to, $from, $subject, $type, $id)
{
	//to = array senarai StafID penerima
	//subject = tajuk
	//type = jenis leave type, cth 1 - cuti tahunan
	//id = id permohonan cuti
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	if($type == 1) // 1 - Cuti Rehat / Tahunan
	{	
	
	//email kepada ketua unit
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Untuk makluman, permohonan <?php echo getLeaveType(htmlspecialchars($type, ENT_QUOTES)); ?> dalam <?php echo $GLOBALS['systitle_short'];?> untuk tindakan tuan/puan. Maklumat permohonan adalah seperti berikut :-


Nama : <?php echo getFullNameByStafID(getStafIDByLeaveID($id[0])) . " (" . getStafIDByLeaveID($id[0]) . ")";?> 

Perkara : <?php echo htmlspecialchars_decode(getLeaveTitle(getStafIDByLeaveID($id[0]), 0, getLeaveDate($id[0], 1), getLeaveDate($id[0], 2), getLeaveDate($id[0], 3)));?> 

<?php if(getLeaveNote(getStafIDByLeaveID($id[0]), 0, getLeaveDate($id[0], 1), getLeaveDate($id[0], 2), getLeaveDate($id[0], 3), $id[0])!=NULL){?>
Catatan : <?php echo htmlspecialchars_decode(getLeaveNote(getStafIDByLeaveID($id[0]), 0, getLeaveDate($id[0], 1), getLeaveDate($id[0], 2), getLeaveDate($id[0], 3), $id[0]));?>
<?php }; ?>


Pada tarikh berikut :
<?php $i=1; foreach($id AS $key => $value){?>
<?php echo $i . ". " . date("d/m/Y (D)", mktime(0, 0, 0, getLeaveDate($value, 2), getLeaveDate($value, 1), getLeaveDate($value, 3))); ?> 
<?php $i++;}; ?>

Sila layari <?php echo $GLOBALS['systitle_full'];?> untuk tindakan pengesahan / kelulusan permohonan cuti melalui URL berikut <?php echo $GLOBALS['url_main'];?>


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan
<?php
		//copy current buffer contents into $message variable and delete current output buffer
		$message = ob_get_clean();	
		
		// email kepada pemohon
		ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Untuk makluman, maklumat permohonan <?php echo getLeaveType(getLeaveTypeByLeaveID($id[0]));?> tuan/puan adalah seperti berikut :-


Nama : <?php echo getFullNameByStafID(getStafIDByLeaveID($id[0])) . " (" . getStafIDByLeaveID($id[0]) . ")";?> 

Perkara : <?php echo htmlspecialchars_decode(getLeaveTitle(getStafIDByLeaveID($id[0]), 0, getLeaveDate($id[0], 1), getLeaveDate($id[0], 2), getLeaveDate($id[0], 3), $id[0]));?> 

<?php if(getLeaveNote(getStafIDByLeaveID($id[0]), 0, getLeaveDate($id[0], 1), getLeaveDate($id[0], 2), getLeaveDate($id[0], 3), $id[0])!=NULL){?>
Catatan : <?php echo htmlspecialchars_decode(getLeaveNote(getStafIDByLeaveID($id[0]), 0, getLeaveDate($id[0], 1), getLeaveDate($id[0], 2), getLeaveDate($id[0], 3), $id[0]));?>
<?php }; ?>


Pada tarikh berikut :
<?php foreach($id AS $key => $value){?>
<?php echo $key+1 . ".  " . date("d / m / Y (D)", mktime(0, 0, 0, getLeaveDate($value, 2), getLeaveDate($value, 1), getLeaveDate($value, 3))); ?> 
<?php }; ?>

Untuk pindahan/perubahan/pembetulan pada maklumat cuti yang telah dipohon / diluluskan, sila berhubung dengan <?php echo $GLOBALS['adname'];?>. Untuk maklumat lanjut berkaitan status permohonan, sila semak melalui URL berikut <?php echo $GLOBALS['url_main'];?>


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message2 = ob_get_clean();
	
	} else if($type == 2) {

	//arahan email kelulusan cuti telah dibuat oleh ketua / cawangan sumber manusia
		
	// email kepada pemohon
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Untuk makluman, kelulusan permohonan <?php echo getLeaveType(getLeaveTypeByLeaveID(htmlspecialchars($id, ENT_QUOTES)));?> telah dibuat seperti berikut:-


<?php if(checkLeaveApp(htmlspecialchars($id, ENT_QUOTES))) {?>
Permohonan cuti bertarikh <?php echo getLeaveDate(htmlspecialchars($id, ENT_QUOTES)); ?> DILULUSKAN<?php if(checkLeaveNotice(getStafIDByLeaveID($id), htmlspecialchars($id, ENT_QUOTES))){?> dengan AMARAN<?php }; ?> oleh <?php echo getFullNameByStafID(getLeaveAppBy(htmlspecialchars($id, ENT_QUOTES)));?> pada <?php echo getLeaveAppDate(htmlspecialchars($id, ENT_QUOTES));?>
<?php } else { ?>
Permohonan cuti bertarikh <?php echo getLeaveDate(htmlspecialchars($id, ENT_QUOTES)); ?> TIDAK DILULUSKAN oleh <?php echo getFullNameByStafID(getLeaveAppBy(htmlspecialchars($id, ENT_QUOTES)));?> pada <?php echo getLeaveAppDate(htmlspecialchars($id, ENT_QUOTES));?>
<?php }; ?>


Untuk pindahan/perubahan/pembetulan pada maklumat cuti yang telah dipohon / diluluskan, sila berhubung terus dengan <?php echo $GLOBALS['adname'];?>. Layari URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut.


Sekian, terima kasih.

Makluman ini dihantar oleh Ketua Bahagian / Cawangan / Pusat / Unit / <?php echo $GLOBALS['adname'];?> melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	
	} else if($type == 3) {

	//arahan email oleh Cawangan Sumber Manusia (CSM) untuk penambahan cuti dalam sistenm
		
	// email kepada staf dari Cawangan Sumber Manusia
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Untuk makluman, kemaskini rekod <?php echo getLeaveType(getLeaveTypeByLeaveID(htmlspecialchars($id, ENT_QUOTES))); ?><?php if(getLeaveCategoryByLeaveID($id)!=0) echo " (" . getLeaveCategory(getLeaveCategoryByLeaveID(htmlspecialchars($id, ENT_QUOTES))) . ")";?> <?php if(getLeaveNotice($id)==1) echo "dengan AMARAN* ";?> bertarikh <?php echo getLeaveDate(htmlspecialchars($id, ENT_QUOTES)); ?> oleh <?php echo getFullNameByStafID(getLeaveAppBy(htmlspecialchars($id, ENT_QUOTES)));?> pada <?php echo getLeaveAppDate(htmlspecialchars($id, ENT_QUOTES));?>


Untuk pindaan atau pembetulan, sila berhubung terus dengan <?php echo $GLOBALS['adname'];?>. <?php echo $GLOBALS['systitle_short'];?> boleh diakses melalui URL berikut <?php echo $GLOBALS['url_main'];?>


Sekian, terima kasih.

Makluman ini dihantar oleh <?php echo $GLOBALS['adname'];?> melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.


<?php if($row_ss['userleavedate_notice']==1) echo "* Tindakan tatatertib akan dikenakan jika amaran terkumpul sebanyak tiga (3) kali.";?>
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageCSMUserID = ob_get_clean();	
	
	// email kepada Ketua Unit dari Cawangan Sumber Manusia
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Untuk makluman, kemaskini rekod <?php echo getLeaveType(getLeaveTypeByLeaveID(htmlspecialchars($id, ENT_QUOTES))); ?><?php if(getLeaveCategoryByLeaveID($id)!=0) echo " (" . getLeaveCategory(getLeaveCategoryByLeaveID(htmlspecialchars($id, ENT_QUOTES))) . ")";?> <?php if(getLeaveNotice($id)==1) echo "dengan AMARAN* ";?> kepada <?php echo getFullNameByStafID(getStafIDByLeaveID(htmlspecialchars($id, ENT_QUOTES))) . " (" . getStafIDByLeaveID(htmlspecialchars($id, ENT_QUOTES)) . ")";?> bertarikh <?php echo getLeaveDate(htmlspecialchars($id, ENT_QUOTES)); ?> oleh <?php echo getFullNameByStafID(getLeaveAppBy(htmlspecialchars($id, ENT_QUOTES)));?> pada <?php echo getLeaveAppDate($id);?>


Untuk pindaan atau pembetulan, sila berhubung terus dengan <?php echo $GLOBALS['adname'];?>. <?php echo $GLOBALS['systitle_short'];?> boleh diakses melalui URL berikut <?php echo $GLOBALS['url_main'];?>


Sekian, terima kasih.

Makluman ini dihantar oleh <?php echo $GLOBALS['adname'];?> melalui <?php echo $GLOBALS['systitle_full'];?> kepada Ketua Bahagian / Cawangan / Pusat / Unit sebagai rujukan


<?php if(getLeaveNotice($id)==1) echo "* Tindakan tatatertib akan dikenakan jika amaran terkumpul sebanyak tiga (3) kali.";?>
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageCSMHeadID = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Permohonan Cuti Rehat";
	else if($subject == 0 && $type == 2)
 		$subject = $GLOBALS['systitle_short'] . " : Kelulusan Permohonan " . getLeaveType(getLeaveTypeByLeaveID(htmlspecialchars($id, ENT_QUOTES)));
	else if($subject == 0 && $type == 3)
 		$subject = $GLOBALS['systitle_short'] . " : Pengurusan " . getLeaveType(getLeaveTypeByLeaveID(htmlspecialchars($id, ENT_QUOTES))) . " oleh " . $GLOBALS['adname'];
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
	if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
	{
		foreach($to as $key => $value)
		{
			$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
			
			if($key == 0 && $type == 1)
			{ // email kpd pemohon untuk makluman permohonan cuti baru
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message2, $format);
			}
			
			if($key == 1 && $type == 1 && getStatusTFByStafID($value))
			{ // email kpd ketua unit untuk permohonan cuti baru
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				//$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageHead, $format);
			}
			
			if($key == 0 && $type == 2)
			{ // email pemohon bagi kelulusan permohonan cuti yang telah dibuat oleh ketua
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
			}
			
			if($key == 0 && $type == 3)
			{ // email kpd pemohon untuk makluman penambahan cuti oleh Cawangan Sumber Manusia
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageCSMUserID, $format);
			}
			
			if($key == 1 && $type == 3)
			{ // email kpd ketua unit untuk penambahan cuti oleh Cawangan Sumber Manusia
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageCSMHeadID, $format);
			}
		}
	}
}
?>
<?php 
function emailNotice($to, $from, $subject, $type, $id)
{
	//to = array senarai StafID penerima
	//subject = tajuk
	//type = jenis leave type, cth 1 - cuti tahunan
	//id = Staf ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));
	
	$sendmail = checkNotice3Time(htmlspecialchars($id, ENT_QUOTES)); // semak Staf ID telah mendapat amaran sebanyak 3 kali

	if($type == 1 && $sendmail)
	{	
	
	//email kepada HR
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Tindakan dan perhatian tuan/puan diperlukan berkaitan Cuti Rehat / Tahunan yang diluluskan telah diberi AMARAN sebanyak tiga (3) kali oleh Ketua Bahagian/Cawangan/Pusat/Unit untuk kakitangan berikut :-


<?php echo getFullNameByStafID(htmlspecialchars($id, ENT_QUOTES)) . " (" . htmlspecialchars($id, ENT_QUOTES) . ")";?>

<?php echo getJobtitle(htmlspecialchars($id, ENT_QUOTES)); ?> (<?php echo getGred(htmlspecialchars($id, ENT_QUOTES));?>)
<?php echo getFulldirectoryByUserID(htmlspecialchars($id, ENT_QUOTES));?>


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	
	//email kepada Ketua
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Cuti Rehat / Tahunan yang diluluskan telah diberi AMARAN sebanyak tiga (3) kali oleh tuan/puan untuk kakitangan berikut :-


<?php echo getFullNameByStafID(htmlspecialchars($id, ENT_QUOTES)) . " (" . htmlspecialchars($id, ENT_QUOTES) . ")";?>

<?php echo getJobtitle(htmlspecialchars($id, ENT_QUOTES)); ?> (<?php echo getGred(htmlspecialchars($id, ENT_QUOTES));?>)
<?php echo getFulldirectoryByUserID(htmlspecialchars($id, ENT_QUOTES));?>


Makluman AMARAN ini juga telah dihantar ke <?php echo $GLOBALS['adname'];?> untuk tindakan dan perhatian selanjutnya.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageHead = ob_get_clean();
	
	//email kepada Ketua
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Perhatian tuan/puan diperlukan bagi Cuti Rehat / Tahunan yang diluluskan telah diberi AMARAN sebanyak tiga (3) kali. Makluman AMARAN ini juga telah dihantar ke <?php echo $GLOBALS['adname'];?> untuk tindakan dan perhatian selanjutnya.

Maklumat lanjut berkaitan AMARAN ini boleh dirujuk dalam <?php echo $GLOBALS['systitle_full'];?> melalui Modul Cuti > Laporan.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageStaf = ob_get_clean();
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : (AMARAN) Cuti Kakitangan";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
	}
	
	if($GLOBALS['sendemailfunc'] && $sendmail) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
	{
		foreach($to as $key => $value)
		{
			$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
			
			if($key == '0' && $type == 1 && getStatusTFByStafID($value))
			{ 
				// email kpd Staf berkaitan notice
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageStaf, $format);
			} elseif($key == '1' && $type == 1 && getStatusTFByStafID($value))
			{ 
				// email kpd ketua berkaitan notice
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageHead, $format);
			} elseif($key > '1' && $type == 1 && getStatusTFByStafID($value))
			{ 
				// email kpd HR berkaitan notice
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
			};
		}
	}
}
?>

<?php 
function emailAL($to, $from=0, $subject=0, $type=0, $id=0)
{
	//to = array senarai StafID penerima
	//subject = tajuk
	//type = jenis leave type, cth 1 - cuti tahunan
	//id = id permohonan cuti
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT * FROM www.user_leave WHERE userleave_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) // 1 - Cuti Ganti
	{	
	
	//email kepada ketua unit
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Untuk makluman, penambahan <?php echo getLeaveType($row_ss['leavetype_id']);?> sebanyak <?php echo $row_ss['userleave_annual'] . " hari";?> kepada <?php echo getFullNameByStafID($row_ss['user_stafid']) . " (" . $row_ss['user_stafid'] . ")";?> <?php if($row_ss['leavetype_id']=='3'){//3 - Cuti ganti ?> bermula <?php echo date("d/m/Y (D)", mktime(0, 0, 0, $row_ss['userleave_month'], $row_ss['userleave_day'], $row_ss['userleave_year'])); ?> dalam tempoh 3 bulan <?php };?>oleh <?php echo getFullNameByStafID($row_ss['userleave_by']);?> pada <?php echo$row_ss['userleave_date'];?>


Untuk pindaan atau pembetulan, sila berhubung terus dengan <?php echo $GLOBALS['adname'];?>. <?php echo $GLOBALS['systitle_short'];?> boleh diakses melalui URL berikut <?php echo $GLOBALS['url_main'];?>


Sekian, terima kasih.

Makluman ini dihantar oleh <?php echo $GLOBALS['adname'];?> melalui <?php echo $GLOBALS['systitle_full'];?> kepada Ketua Bahagian / Cawangan / Pusat / Unit sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Penambahan Cuti Ganti";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
	if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
	{
		foreach($to as $key => $value)
		{
			$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
			
			if($key == 0 && $type == 1 && getStatusTFByStafID($value))
			{ // email kpd pemohon untuk makluman permohonan cuti baru
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
			}
			
			if($key == 1 && $type == 1 && getStatusTFByStafID($value))
			{ // email kpd pemohon untuk makluman permohonan cuti baru
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
			}
		}
	}
}


?>

<?php 
function emailALERApproval($to, $from=0, $subject=0, $type=0, $id=0)
{
	// Send Error Report kpd HR / ICT berkaitan permohonan cuti tanpa nama kelulusan.
	//to = array senarai HR / ICT ID penerima
	//subject = tajuk
	//type = jenis leave type, cth 1 - cuti tahunan
	//id = id permohonan cuti
	
	if($from==0)
	{
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	} else {
		$from = getEmailISNByUserID(htmlspecialchars($from, ENT_QUOTES));
	}
	
	$random_hash = md5(date('r', time()));
	
	if($id!=0)
	{
		$query_ss = "SELECT * FROM www.user_leavedate WHERE userleavedate_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";	
		$user_ss = mysql_query($query_ss);
		$row_ss = mysql_fetch_assoc($user_ss);
	}
	
	if($type == 1) // 1 - Error tiada nama kelulusan
	{	
	
	//email kepada HR / ICT
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Untuk makluman, permohonan cuti berikut tidak didaftarkan dengan maklumat Pegawai Penilai. Mohon semakkan dan kemaskini berkaitan laporan ini.


Maklumat permohonan adalah seperti berikut :-

Tarikh : <?php echo date('d/m/Y (D) h:i:s A');?>

Tiket No.: <?php echo $row_ss['userleavedate_id'];?>

Nama : <?php echo getFullNameByStafID($row_ss['user_stafid']) . " (" . $row_ss['user_stafid'] . ")";?> <?php if(getExtNoByUserID($row_ss['user_stafid'])!=NULL) echo " Ext : " . getExtNoByUserID($row_ss['user_stafid']);?>

Unit : <?php echo getFulldirectoryByUserID($row_ss['user_stafid']);?>

Tarikh Cuti : <?php echo date('d/m/Y', mktime(0, 0,0, $row_ss['userleavedate_date_m'], $row_ss['userleavedate_date_d'], $row_ss['userleavedate_date_y']));?>


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> kepada <?php echo $GLOBALS['adname'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	
	}else if($type == 2) // 1 - Error Pegawai Penilai tidak betul
	{	
	
	//email kepada HR / ICT
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Untuk makluman, terdapat ralat pada maklumat Pegawai Penilai bagi cuti kakitangan berikut. Mohon semakkan dan kemaskini berkaitan aduan ini.


Maklumat permohonan adalah seperti berikut :-

Tarikh : <?php echo date('d/m/Y (D) h:i:s A');?>

Nama : <?php echo getFullNameByStafID($_SESSION['user_stafid']) . " (" . $_SESSION['user_stafid'] . ")";?> <?php if(getExtNoByUserID($_SESSION['user_stafid'])!=NULL) echo " Ext : " . getExtNoByUserID($_SESSION['user_stafid']);?>

Unit : <?php echo getFulldirectoryByUserID($_SESSION['user_stafid']);?>

Pegawai Penilai Semasa : <?php echo getFullNameByStafID(getHeadIDByUserID($_SESSION['user_stafid'])) . " (" . getHeadIDByUserID($_SESSION['user_stafid']) . ")";?>


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> kepada <?php echo $GLOBALS['adname'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message2 = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : (ER) Tiada maklumat Pegawai Penilai pada permohonan cuti";
	else if($subject == 0 && $type == 2)
 		$subject = $GLOBALS['systitle_short'] . " : (ER) Ralat pada maklumat Pegawai Penilai";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
	if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
	{
		foreach($to as $key => $value)
		{
			$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
			
			if($type == 1 && getStatusTFByStafID($value))
			{ // email kpd pemohon untuk makluman permohonan cuti baru
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
			} else if($type == 2 && getStatusTFByStafID($value))
			{ // email kpd pemohon untuk makluman permohonan cuti baru
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message2, $format);
			}
		}
	}
}
?>
<?php 
function emailCourses($to, $from=0, $subject=0, $type=0, $id=0)
{
	//to = array senarai StafID penerima
	//subject = tajuk
	//type = jenis leave type, cth 1 - cuti tahunan
	//id = id permohonan cuti
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . '<spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT * FROM www.user_courses WHERE usercourses_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) // 1 - Penambahan Kehadiran oleh HR
	{	
	
	//email kepada Staf ID
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Untuk makluman, tuan/puan telah didaftarkan dalam <?php echo getCourseType(getCoursesTypeID($row_ss['courses_id']));?> "<?php echo htmlspecialchars_decode(getCoursesName($row_ss['courses_id']));?>" oleh <?php echo getFullNameByStafID($row_ss['usercourses_by']);?> pada <?php echo$row_ss['usercourses_date'];?>.<?php if(checkReportNeed($row_ss['courses_id'])){?> <?php echo getCourseType(getCoursesTypeID($row_ss['courses_id']));?> ini memerlukan peserta untuk menghantar laporan kepada Ketua Bahagian / Cawangan / Pusat / Unit dan <?php echo $GLOBALS['adname'];?> setelah selesai menghadirinya.<?php }; ?>


Untuk pindaan atau pembetulan, sila berhubung terus dengan <?php echo $GLOBALS['adname'];?>. Maklumat lanjut berkaitan <?php echo getCourseType(getCoursesTypeID($row_ss['courses_id']));?>, sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?>


Sekian, terima kasih.

Makluman ini dihantar oleh <?php echo $GLOBALS['adname'];?> melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	
	//email kepada Head ID
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Untuk makluman, pendaftaran kehadiran <?php echo getCourseType(getCoursesTypeID($row_ss['courses_id']));?> "<?php echo htmlspecialchars_decode(getCoursesName($row_ss['courses_id']));?>" kepada <?php echo getFullNameByStafID($row_ss['user_stafid']) . " (" . $row_ss['user_stafid'] . ")";?> oleh <?php echo getFullNameByStafID($row_ss['usercourses_by']);?> pada <?php echo$row_ss['usercourses_date'];?>.<?php if(checkCoursesNeedAttendence($row_ss['courses_id'])) echo " " . getCourseType(getCoursesTypeID($row_ss['courses_id'])) . "ini memerlukan pengesahan kehadiran sebagai syarat pengiraan Jam Kursus.";?><?php if(checkReportNeed($row_ss['courses_id'])){?> <?php echo getCourseType(getCoursesTypeID($row_ss['courses_id']));?> ini memerlukan peserta untuk menghantar laporan kepada Ketua Bahagian / Cawangan / Pusat / Unit dan <?php echo $GLOBALS['adname'];?> setelah selesai menghadirinya.<?php }; ?>


Untuk pindaan atau pembetulan, sila berhubung terus dengan <?php echo $GLOBALS['adname'];?>. Maklumat lanjut berkaitan <?php echo getCourseType(getCoursesTypeID($row_ss['courses_id']));?>, sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?>


Sekian, terima kasih.

Makluman ini dihantar oleh <?php echo $GLOBALS['adname'];?> melalui <?php echo $GLOBALS['systitle_full'];?> kepada Ketua Bahagian / Cawangan / Pusat / Unit sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageHead = ob_get_clean();
	} else if($type == 2) // 2 - Apply Kursus
	{	
	
	//email kepada Staf ID
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Untuk makluman, tuan/puan telah mendaftar untuk menghadiri "<?php echo htmlspecialchars_decode(getCoursesName($row_ss['courses_id']));?>" pada <?php echo getCoursesDate($row_ss['courses_id']);?>.<?php if(checkCoursesNeedAttendence($row_ss['courses_id'])) echo " " . getCourseType(getCoursesTypeID($row_ss['courses_id'])) . " ini memerlukan pengesahan kehadiran sebagai syarat pengiraan Jam Kursus.";?> Sila hadirkan diri pada tarikh yang telah dinyatakan.<?php if(checkReportNeed($row_ss['courses_id'])){?> <?php echo getCourseType(getCoursesTypeID($row_ss['courses_id']));?> ini memerlukan peserta untuk menghantar laporan kepada Ketua Bahagian / Cawangan / Pusat / Unit dan <?php echo $GLOBALS['adname'];?> setelah selesai menghadirinya.<?php }; ?>


Untuk pindaan atau pembetulan kehadiran, sila berhubung terus dengan <?php echo $GLOBALS['adname'];?>. Maklumat lanjut berkaitan <?php echo getCourseType(getCoursesTypeID($row_ss['courses_id']));?>, sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?>


<?php echo $GLOBALS['adname']; ?> berhak untuk mengubah maklumat <?php echo getCourseType(getCoursesTypeID($row_ss['courses_id']));?> yang telah dinyatakan atau membatalkan kehadiran kursus tanpa sebarang notis atau makluman.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	
	//email kepada Head ID
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Untuk makluman, pendaftaran untuk menghadiri "<?php echo htmlspecialchars_decode(getCoursesName($row_ss['courses_id']));?>" bertarikh <?php echo getCoursesDate($row_ss['courses_id']);?> oleh <?php echo getFullNameByStafID($row_ss['user_stafid']) . " (" . $row_ss['user_stafid'] . ")";?> pada <?php echo$row_ss['usercourses_date'];?>.<?php if(checkCoursesNeedAttendence($row_ss['courses_id'])) echo " " . getCourseType(getCoursesTypeID($row_ss['courses_id'])) . " ini memerlukan pengesahan kehadiran sebagai syarat pengiraan Jam Kursus.";?><?php if(checkReportNeed($row_ss['courses_id'])){?> <?php echo getCourseType(getCoursesTypeID($row_ss['courses_id']));?> ini memerlukan peserta untuk menghantar laporan kepada Ketua Bahagian / Cawangan / Pusat / Unit dan <?php echo $GLOBALS['adname'];?> setelah selesai menghadirinya.<?php }; ?>


Untuk pindaan atau pembetulan, sila berhubung terus dengan <?php echo $GLOBALS['adname'];?>. Maklumat lanjut berkaitan <?php echo getCourseType(getCoursesTypeID($row_ss['courses_id']));?>, sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?>


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> kepada Ketua Bahagian / Cawangan / Pusat / Unit sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageHead = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Pendaftaran Kehadiran Kursus";
	
	if($subject == 0 && $type == 2)
 		$subject = $GLOBALS['systitle_short'] . " : Pendaftaran Kehadiran Kursus";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
	if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
	{
		foreach($to as $key => $value)
		{
			$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
			
			if($key == 0 && $type == 1 && getStatusTFByStafID($value))
			{ // email kpd Staf untuk pengesahan pendaftaran kursus oleh CSM
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
			}
			
			if($key == 1 && $type == 1 && getStatusTFByStafID($value))
			{ // email kpd Staf untuk pengesahan pendaftaran kursus oleh CSM
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageHead, $format);
			}
			
			if($key == 0 && $type == 2 && getStatusTFByStafID($value))
			{ // email kpd Staf ID untuk makluman pendaftaran kursus baru
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
			}
			
			if($key == 1 && $type == 2 && getStatusTFByStafID($value))
			{ // email kpd Head untuk makluman pendaftaran kursus baru
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageHead, $format);
			}
		}
	}
}
?>
<?php 
function emailCoursesReport($to, $from=0, $subject=0, $type=0, $id=0)
{
	//to = array senarai StafID penerima
	//subject = tajuk
	//type = jenis leave type, cth 1 - cuti tahunan
	//id = id permohonan cuti
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT user_coursesreport.*, user_courses.* FROM www.user_coursesreport LEFT JOIN www.user_courses ON user_courses.usercourses_id = user_coursesreport.usercourses_id WHERE usercoursesreport_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);

	if($type == 1 && $total > 0) // 1 - Hantar laporan kepada HR
	{	
	
	//email kepada HR ID untuk maklum berkaitan penghantaran report
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;


Untuk makluman, laporan <?php echo getCourseType(getCoursesTypeID($row_ss['courses_id']));?> telah hantar seperti berikut :-

Tajuk	: <?php echo htmlspecialchars_decode(getCoursesName($row_ss['courses_id']));?>

Tarikh	: <?php echo getCoursesDate($row_ss['courses_id'], 0);?> 

Dihantar oleh	: 
<?php echo getFullNameByStafID($row_ss['usercoursesreport_by']) . " (" . $row_ss['usercoursesreport_by'] . ")";?> 
<?php echo getFulldirectoryByUserID($row_ss['usercoursesreport_by']);?>


Tarikh hantar : <?php echo $row_ss['usercoursesreport_date'];?>


Mohon pengesahan dan tindakan selanjutnya berkaitan laporan tersebut. Maklumat lanjut berkaitan laporan kursus, sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?>


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	} else if($type == 2 && $total > 0) // 2 - HR sahkan laporan
	{	
	
	//email kepada HR ID untuk maklum berkaitan penghantaran report
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;


Untuk makluman, laporan kursus yang dihantar telah disemak seperti berikut :-


Tajuk kursus : <?php echo htmlspecialchars_decode(getCoursesName($row_ss['courses_id']));?>


Keputusan :

<?php if($row_ss['hr_approval']==1) echo "Telah diluluskan (Jam Kursus dikira)"; else { echo "Perlu penambahbaikkan sebelum dilulus untuk kiraan Jam Kursus"; ?>


Catatan :
<?php if($row_ss['hr_comment']!=NULL) echo  $row_ss['hr_comment']; ?>
<?php echo " Sila kemaskini laporan tersebut dengan kadar segera";?>
<?php };?>


Laporan kursus ini disemak oleh <?php echo getFullNameByStafID($row_ss['hr_by']) . " (" . $row_ss['hr_by'] . ")";?> <?php echo getFulldirectoryByUserID($row_ss['hr_by']);?> pada <?php echo $row_ss['hr_date'];?>.


Maklumat lanjut berkaitan laporan kursus, sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?>


Sekian, terima kasih.

Makluman ini dihantar oleh <?php echo $GLOBALS['adname'];?> melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	} else if($type == 3 && $total > 0) // 3 - Edit
	{	
	
	//email kepada HR ID untuk maklum berkaitan penghantaran report
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;


Untuk makluman, laporan  <?php echo getCourseType(getCoursesTypeID($row_ss['courses_id']));?> telah dikemaskini seperti berikut :-

Tajuk		: <?php echo htmlspecialchars_decode(getCoursesName($row_ss['courses_id']));?>

Tarikh 		: <?php echo getCoursesDate($row_ss['courses_id'], 0);?>


Dikemaskini oleh :
<?php echo getFullNameByStafID($row_ss['usercoursesreport_by']) . " (" . $row_ss['usercoursesreport_by'] . ")";?>

<?php echo getFulldirectoryByUserID($row_ss['usercoursesreport_by']);?>


Tarikh kemaskini : <?php echo $row_ss['usercoursesreport_date'];?>


Mohon pengesahan dan tindakan selanjutnya berkaitan laporan tersebut. Maklumat lanjut berkaitan laporan kursus, sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?>


Sekian, terima kasih.

Makluman ini dihantar oleh <?php echo $GLOBALS['adname'];?> melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageEdit = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Laporan Kursus";
	
	if($subject == 0 && $type == 2)
 		$subject = $GLOBALS['systitle_short'] . " : Pengesahan Laporan Kursus";
	
	if($subject == 0 && $type == 3)
 		$subject = $GLOBALS['systitle_short'] . " : Kemaskini Laporan Kursus";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
	if($GLOBALS['sendemailfunc'] && $total > 0) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
	{
		foreach($to as $key => $value)
		{
			$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
			
			if($type == 1 && getStatusTFByStafID($value))
			{ // email kpd HR yg menguruskan kursus berkiatn laporan baru
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
			}
			
			if($type == 2 && getStatusTFByStafID($value))
			{ // email kpd Staf untuk pengesahan laporan oleh HR
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
			}
			
			if($type == 3 && getStatusTFByStafID($value))
			{ // email kpd HR untuk kemaskini laporan
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageEdit, $format);
			}
		}
	}
}
?>
<?php 
function emailCoursesAttendance($to, $from=0, $subject=0, $type=0, $id=0)
{
	//to = array senarai StafID penerima
	//subject = tajuk
	//type = 1- hantar nota
	//id = id kursus
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT user_courses.* FROM www.user_courses WHERE usercourses_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) // 1 - Hantar nota kepada kakitangan berdaftar
	{	
	
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Untuk makluman, pengesahan kehadiran '<?php echo htmlspecialchars_decode(getCoursesName($row_ss['courses_id']));?>' kepada <?php echo getFullNameByStafID($row_ss['user_stafid']);?> pada <?php echo date('d/m/Y h:i:s A');?> melalui <?php echo $GLOBALS['systitle_full'];?>. Maklumat lanjut, sila hubungi <?php echo $GLOBALS['adname'];?> atau layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?>


Sekian, terima kasih.

Makluman ini dihantar sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	};
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Pengesahan Kehadiran " . getCoursesName($row_ss['courses_id']);
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
	if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
	{
		foreach($to as $key => $value)
		{
			$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
			
			if($type == 1 && getStatusTFByStafID($value))
			{ // email kpd kakitangan berdaftar untuk kursus
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
			}
		}
	}
}
?>
<?php 
function emailCourses7Day($to, $from, $subject, $type, $id)
{
	//to = array senarai StafID penerima
	//subject = tajuk
	//type = 1- Email kpd kakitangan yg masih belum lengkap 7 Hari
	//id = Staf ID
	
	$q = getQ(); // Q1, Q2, Q3, Q4
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));
	
	$courseshour = countCoursesHour(htmlspecialchars($id, ENT_QUOTES), date('Y'));
	
	if(getHourByDayHour($courseshour['0'], $courseshour['1']) < getTotalHourByQ())
	{
		if($type == 1) // 1 - Hantar nota kepada kakitangan
		{	
		
		ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Semakkan kepada rekod Jam Kursus Terkumpul tuan/puan sehingga penggal <?php echo $q;?> adalah sebanyak <?php echo $courseshour['0'] . " Hari "; echo $courseshour['1'] . " Jam";?>.

Dicadangkan untuk tuan/puan melengkapkan Jam Kursus Terkumpul bagi penggal <?php  echo $q;?> adalah sebanyak <?php echo getDayByQ() . " Hari ";?> <?php echo getHourByQ() . " Jam ";?>. Sila abaikan email ini jika Jam Kursus Terkumpul tuan/puan sudah memenuhi keperluan.


Maklumat lanjut, sila hubungi <?php echo $GLOBALS['adname'];?> atau layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?>


Sekian, terima kasih.

Makluman ini dihantar sebagai rujukan.
<?php
		//copy current buffer contents into $message variable and delete current output buffer
		$message = ob_get_clean();
		};
		
		$smtp = emailset();
		
		if($subject == 0 && $type == 1)
			$subject = $GLOBALS['systitle_short'] . " : Jam Kursus Terkumpul bagi penggal  " . $q;
		
		$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
		
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			$headers = array ('From' => $from, 'To' => getEmailISNByUserID($to), 'Subject' => $subject);
				
			if($type == 1 && getStatusTFByStafID($to))
			{ // email kpd kakitangan 
				$mail = $smtp->send(getEmailISNByUserID($to), $headers, $message, $format);
			};
		};
	};
};
?>
<?php 
function emailCoursesNote($to, $from=0, $subject=0, $type=0, $id=0, $msg=0, $by=0)
{
	//to = array senarai StafID penerima
	//subject = tajuk
	//type = 1- hantar nota
	//id = id kursus
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT user_courses.* FROM www.user_courses WHERE courses_id='" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) // 1 - Hantar nota kepada kakitangan berdaftar
	{	
	
	ob_start(); //Turn on output buffering	
?>
<?php echo htmlspecialchars_decode($msg);?>


---------------

Makluman ini dihantar oleh <?php echo getFullNameByStafID($by);?> pada <?php echo date('d/m/Y h:i:s A');?> berkaitan '<?php echo htmlspecialchars_decode(getCoursesName($row_ss['courses_id']));?>' melalui <?php echo $GLOBALS['systitle_full'];?>. Maklumat lanjut, sila hubungi <?php echo $GLOBALS['adname'];?> atau layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?>
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	};
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Pesanan untuk " . getCoursesName($row_ss['courses_id']);
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
	if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
	{
		foreach($to as $key => $value)
		{
			$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
			
			if($type == 1 && getStatusTFByStafID($value))
			{ // email kpd kakitangan berdaftar untuk kursus
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
			}
		}
	}
}
?>
<?php 
function emailFailKatalaluan($to, $from=0, $subject=0, $type=0, $id=0)
{
	// Email lupa kata laluan
	//to = array senarai StafID penerima
	//subject = tajuk
	//type = jenis leave type, cth 1 - cuti tahunan
	//id = id permohonan cuti
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT login_username, login_password FROM www.login WHERE user_stafid = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND login_status='1'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) // 1 - Hantar laporan kepada HR
	{	
	
	//email kepada user untuk maklum berkaitan semakkan kata laluan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Berikut merupakan kata laluan yang dipohon untuk semakkan melalui <?php echo $GLOBALS['systitle_full'];?>.

Kata Laluan : <?php echo getPassKey($row_ss['login_password'],0);?>


PERINGATAN! 
Modul Semakkan Kata Laluan hanya boleh digunakan kembali selepas 2 minggu dari tarikh semakkan ini.


Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?>


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Semakkan Kata Laluan";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-" . $random_hash . "\"";
	
	if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
	{
		foreach($to as $key => $value)
		{
			$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
			
			if($type == 1 && getStatusTFByStafID($value))
			{ // email kpd HR yg menguruskan kursus
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
			}
		}
	}
}
?>
<?php 
function emailKelulusanPinjamanICT($to, $from=0, $subject=0, $type=0, $id=0)
{
	// Email keputusan pinjaman peralatan ICT
	//to = array senarai StafID penerima
	//subject = tajuk
	//type = jenis, cth 1 - kelulusan
	//id = user_borrow ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT user_borrow.* FROM ict.user_borrow WHERE userborrow_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) // 1 - Hantar laporan kepada HR
	{	
	
	//email kepada user untuk maklum berkaitan semakkan kata laluan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Berikut merupakan status permohonan pinjaman peralatan :-

Permohonan <?php if($row_ss['ict_status']==1) echo "DILULUSKAN dengan syarat dan peraturan yang ditetapkan."; else echo "TIDAK DILULUSKAN atas sebab tertentu."; ?> 

<?php if($row_ss['ict_note']!=NULL) echo "CATATAN :";?>

<?php if($row_ss['ict_note']!=NULL) echo $row_ss['ict_note'];?>


Berikut maklumat pinjaman peralatan :-

Tujuan : <?php echo htmlspecialchars_decode($row_ss['userborrow_title']);?>

Lokasi : <?php echo htmlspecialchars_decode($row_ss['userborrow_location']);?>

Tarikh : <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['userborrow_date_m'], $row_ss['userborrow_date_d'], $row_ss['userborrow_date_y']));?>

Masa : <?php echo getTimeBorrowByUserBorrowID($row_ss['userborrow_id']);?>


Caw. Teknologi Maklumat berhak membatal atau menukar maklumat pinjaman tanpa sebarang notis atau makluman. Pemohon bertanggungjawab sepenuhnya terhadap item dan kuantiti yang dipinjam sentiasa dalam keadaan baik dan berfungsi sepertimana keadaan sewaktu penerimaan.


Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut berkaitan permohonan pinjaman peralatan.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Status pinjaman peralatan";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				}
			}
		}
}
?>
<?php 
function emailPinjamanBaruICT($to, $from, $subject, $type, $id)
{
	// Email  pinjaman peralatan ICT
	//to = array senarai StafID penerima dan ICT
	//subject = tajuk
	//type = jenis, cth 1 - Makluman Pinjaman baru
	//id = user_borrow ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT user_borrow.* FROM ict.user_borrow WHERE userborrow_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) // 1 - Hantar laporan kepada HR
	{	
	
	//email kepada user untuk maklum berkaitan pemohonan pinjaman
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Berikut maklumat permohonan pinjaman peralatan <?php echo getDirSubName(getDirIDByMenuID('8'));?> yang telah dipohon :-


Tujuan : <?php echo htmlspecialchars_decode(getBorrowTitleByUserBorrowID(htmlspecialchars($id, ENT_QUOTES)));?>

Lokasi : <?php echo htmlspecialchars_decode(getBorrowLocationByUserBorrowID(htmlspecialchars($id, ENT_QUOTES)));?>

Tarikh : <?php echo getDateBorrowByUserBorrowID(htmlspecialchars($id, ENT_QUOTES));?>

Tempoh : <?php echo getDurationByUserBorrowID($row_ss['userborrow_id']);?>

Masa   : <?php echo getTimeBorrowByUserBorrowID($row_ss['userborrow_id']);?>


Item yang dipinjam :

<?php 
$item = getSubCategoryItemBorrowByUserBorrowID($row_ss['userborrow_id']);

foreach($item AS $key => $value)
{
echo $key+1 . ". " . getItemSubCategoryByID($value) . "; 
";
}
?>


Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut berkaitan permohonan dan status pinjaman peralatan <?php echo getDirSubName(getDirIDByMenuID(8));?>. 


Untuk pindaan, pembatalan atau penukaran maklumat pinjaman, sila berhubung terus dengan <?php echo getDirSubName(getDirIDByMenuID(8));?>. Pindaan, pembatalan atau penukaran maklumat pinjaman hanya boleh dibuat sebelum <?php echo getDirSubName(getDirIDByMenuID(8));?> membuat pengesahan pinjaman sahaja.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	
	//email kepada ICT untuk maklum berkaitan permohonana pinjaman baru
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Berikut maklumat permohonan baru pinjaman peralatan <?php echo getDirSubName(getDirIDByMenuID(8));?> untuk tindakan selanjutnya :-


Tujuan : <?php echo htmlspecialchars_decode(getBorrowTitleByUserBorrowID(htmlspecialchars($id, ENT_QUOTES)));?>

Lokasi : <?php echo htmlspecialchars_decode(getBorrowLocationByUserBorrowID(htmlspecialchars($id, ENT_QUOTES)));?>

Tarikh : <?php echo getDateBorrowByUserBorrowID(htmlspecialchars($id, ENT_QUOTES));?>

Tempoh : <?php echo getDurationByUserBorrowID($row_ss['userborrow_id']);?>

Masa   : <?php echo getTimeBorrowByUserBorrowID($row_ss['userborrow_id']);?>


Oleh   : <?php echo getFullNameByStafID(getUserIDByUserBorrowID(htmlspecialchars($id, ENT_QUOTES))) . " (" . getUserIDByUserBorrowID(htmlspecialchars($id, ENT_QUOTES)) . "), Ext : " . getExtNoByUserID(getUserIDByUserBorrowID(htmlspecialchars($id, ENT_QUOTES)));?>

Unit   : <?php echo getFulldirectoryByUserID(getUserIDByUserBorrowID(htmlspecialchars($id, ENT_QUOTES)));?>


----------------------------


Item yang dipinjam :

<?php 
$item2 = getSubCategoryItemBorrowByUserBorrowID(htmlspecialchars($id, ENT_QUOTES));

foreach($item2 AS $key => $value)
{
echo $key+1 . ". " . getItemSubCategoryByID($value) . " 
";
}
?>


----------------------------


Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut berkaitan permohonan pinjaman peralatan Unit ICT.


Sekian, terima kasih.

Makluman ini dihantar kepada <?php echo getDirSubName(getDirIDByMenuID(8));?> melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageICT = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Permohonan pinjaman peralatan " . getDirSubName(getDirIDByMenuID(8));
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($key == 0 && $type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf dan ICT
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				} else if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf dan ICT
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageICT, $format);
				}
			}
		}
}
?>
<?php 
function cronemailICReturnLate($to, $from, $subject, $type, $id)
{
	// Email  pinjaman peralatan ICT
	//to = array senarai StafID penerima dan ICT
	//subject = tajuk
	//type = jenis, cth 1 - Makluman Pinjaman baru
	//id = user_borrow ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT item_borrow.* FROM ict.item_borrow WHERE userborrow_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND itemborrow_status = 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) // 1 - Hantar laporan kepada HR
	{	
	
	//email kepada user untuk maklum berkaitan pemohonan pinjaman
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Mohon tuan/puan untuk membuat penyerahan kembali item daripada permohonan pinjaman peralatan <?php echo getDirSubName(getDirIDByMenuID(8));?> seperti berikut :-


Tujuan : <?php echo getBorrowTitleByUserBorrowID(htmlspecialchars($id, ENT_QUOTES));?>

Tarikh Pinjaman : <?php echo getDateBorrowByUserBorrowID(htmlspecialchars($id, ENT_QUOTES));?>

Tempoh : <?php echo getDurationByUserBorrowID(htmlspecialchars($id, ENT_QUOTES));?>


Oleh :
<?php echo getFullNameByStafID(getUserIDByUserBorrowID(htmlspecialchars($id, ENT_QUOTES))) . " (" . getUserIDByUserBorrowID(htmlspecialchars($id, ENT_QUOTES)) . ")";?>

<?php echo getFulldirectoryByUserID(getUserIDByUserBorrowID(htmlspecialchars($id, ENT_QUOTES)));?>


----------------------------------

Senarai item yang dipinjam :
<?php 
$i=1; do {
?>
<?php 
echo $i . ". Item : " . getItemCategoryBySubCatID($row_ss['subcategory_id']) . ",   No Siri : " . getItemISNSiriByID($row_ss['item_id']) . ",   Model : " . getItemBrandNameByItemID($row_ss['item_id']) . " " . getModelByItemID($row_ss['item_id']);
echo "
";
 ?>
<?php $i++; } while($row_ss = mysql_fetch_assoc($user_ss));?>

----------------------------------


Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut berkaitan pinjaman item. Sekiranya item telah dipulangkan kepada <?php echo getDirSubName(getDirIDByMenuID(8));?>, sila maklumkan kepada Pegawai Pemegang Aset <?php echo getDirSubName(getDirIDByMenuID(8));?> untuk semakkan dan kemaskini maklumat pinjaman.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	
	//email kepada ICT untuk maklum berkaitan pemohonan pinjaman
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Sila buat semakkan dan hubungi kakitangan tersebut untuk proses penyerahan kembali item daripada permohonan pinjaman peralatan <?php echo getDirSubName(getDirIDByMenuID(8));?> seperti berikut :-


Tujuan : <?php echo getBorrowTitleByUserBorrowID(htmlspecialchars($id, ENT_QUOTES));?>

Tarikh Pinjaman : <?php echo getDateBorrowByUserBorrowID(htmlspecialchars($id, ENT_QUOTES));?>

Tempoh : <?php echo getDurationByUserBorrowID(htmlspecialchars($id, ENT_QUOTES));?>


Oleh :
<?php echo getFullNameByStafID(getUserIDByUserBorrowID(htmlspecialchars($id, ENT_QUOTES))) . " (" . getUserIDByUserBorrowID(htmlspecialchars($id, ENT_QUOTES)) . ")";?>

<?php echo getFulldirectoryByUserID(getUserIDByUserBorrowID(htmlspecialchars($id, ENT_QUOTES)));?>


----------------------------------

Senarai item yang dipinjam :
<?php 
$item = getItemBorrowByUserBorrowID(htmlspecialchars($id, ENT_QUOTES));

foreach($item AS $key => $value)
{
	echo $key+1 . ". " . getItemISNSiriByID($value) . " - " . getItemSubCategoryByID(getItemSubCategoryByItemID($value)) . " " . getItemBrandNameByItemID($value) . " " . getModelByItemID($value) . ", ";
	echo " ";
}
?>


----------------------------------


Layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut berkaitan pinjaman item.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageICT = ob_get_clean();
	}
	
	$smtp = emailset();
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
	
				if($key == 0 && $type == 1)
					$subject = $GLOBALS['systitle_short'] . " : Pinjaman Peralatan yang belum dipulangkan";
				else
					$subject = $GLOBALS['systitle_short'] . " : (TINDAKAN) Tiada penyerahan item untuk pinjaman peralatan";
				
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($key == 0 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				} else if($key > 0 && getStatusTFByStafID($value))
				{ // email kpd  ICT
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageICT, $format);
				}
			}
		}
}
?>
<?php 
function emailAduanBaruICT($to, $from, $subject, $type, $id)
{
	// Email aduan
	//to = array senarai StafID penerima dan ICT
	//subject = tajuk
	//type = jenis, cth 1 - Makluman Aduan
	//id = user_report ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT user_report.* FROM ict.user_report WHERE userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) 
	{	
	
	//email kepada user untuk maklum berkaitan aduan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Berikut maklumat aduan yang telah dibuat :-

Kategori : <?php echo getReportTypeByID(getReportTypeBySymptomID($row_ss['reportsymptom_id']));?> > <?php echo getReportSubTypeByID(getReportSubTypeBySymptomID($row_ss['reportsymptom_id']));?>

Isu : <?php echo getReportSymptomByID($row_ss['reportsymptom_id']);?>

Tarikh : <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['userreport_date_m'], $row_ss['userreport_date_d'], $row_ss['userreport_date_y']));?>

Masa : <?php echo $row_ss['userreport_time'];?>


Setiap pemohon hanya dibenarkan untuk membuat 5 kali aduan dalam tempoh tarikh tersebut dan setiap isu yang dihantar hanya boleh dibuat sekali dalam tempoh tarikh tersebut. 

Sehubungan itu, pemohon diminta untuk memilih isu yang betul berkaitan permasalahan atau aduan yang ingin dibuat. <?php echo getDirSubName(getDirIDByMenuID(8));?> berhak untuk membatalkan atau menukar maklumat aduan tanpa sebarang notis atau makluman. Setiap aduan yang dibuat akan dinilai untuk tujuan penambahbaik perkhidmatan. 

Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut berkaitan status aduan. Sekiranya tiada sebarang maklum balas berkaitan aduan dalam  <?php echo $GLOBALS['systitle_short'];?>, sila hubungi <?php echo getDirSubName(getDirIDByMenuID(8));?> (Teknikal) di talian ext 9951 dan sila nyatakan Nama dan Tarikh aduan ketika berhubung untuk memudahkan proses semakkan.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	
	//email kepada ICT untuk maklum berkaitan permohonana pinjaman baru
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Berikut maklumat aduan baru untuk tindakan selanjutnya :-

Kategori : <?php echo getReportTypeByID(getReportTypeBySymptomID($row_ss['reportsymptom_id']));?> > <?php echo getReportSubTypeByID(getReportSubTypeBySymptomID($row_ss['reportsymptom_id']));?>

Isu      : <?php echo getReportSymptomByID($row_ss['reportsymptom_id']);?>


Tarikh   : <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['userreport_date_m'], $row_ss['userreport_date_d'], $row_ss['userreport_date_y']));?>

Masa     : <?php echo $row_ss['userreport_time'];?>


Oleh     : <?php echo getFullNameByStafID($row_ss['user_stafid']) . " (" . $row_ss['user_stafid'] . "), Ext : " . getExtNoByUserID($row_ss['user_stafid']);?>

Unit     : <?php echo getFulldirectoryByUserID($row_ss['user_stafid']);?>


Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut berkaitan aduan.


Sekian, terima kasih.

Makluman ini dihantar kepada <?php echo getDirSubName(getDirIDByMenuID(8));?> melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageICT = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Aduan kepada " . getDirSubName(getDirIDByMenuID(8));
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($key == 0 && $type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf dan ICT
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				} else if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf dan ICT
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageICT, $format);
				}
			}
		}
}
?>
<?php
function emailFeedbackICTAction($to, $from, $subject, $type, $id)
{
	// Email maklum balas untuk tindakan StafID
	//to = array senarai StafID penerima dan ICT
	//subject = tajuk
	//type = jenis, cth 1 - Makluman Aduan
	//id = user_report ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT user_report.* FROM ict.user_report WHERE userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) 
	{	
	
	//email kepada user untuk maklum berkaitan aduan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Tindakan/perhatian daripada tuan/puan bagi perkara berikut diperlukan :-

Oleh : <?php echo getFullNameByStafID(getFeedbackActionUserIDByUserReportID($row_ss['userreport_id']));?>

Catatan :

<?php echo htmlspecialchars_decode(getFeedbackActionNoteByUserReportID($row_ss['userreport_id']));?>


------------


Merujuk pada aduan berikut :-


Kategori : <?php echo getReportTypeByID(getReportTypeBySymptomID($row_ss['reportsymptom_id']));?> > <?php echo getReportSubTypeByID(getReportSubTypeBySymptomID($row_ss['reportsymptom_id']));?>

Isu : <?php echo getReportSymptomByID($row_ss['reportsymptom_id']);?>


Tarikh : <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['userreport_date_m'], $row_ss['userreport_date_d'], $row_ss['userreport_date_y']));?>

Masa : <?php echo $row_ss['userreport_time'];?>


Oleh : <?php echo getFullNameByStafID($row_ss['user_stafid']) . " (" . $row_ss['user_stafid'] . "), Ext : " . getExtNoByUserID($row_ss['user_stafid']);?>

Unit : <?php echo getFulldirectoryByUserID($row_ss['user_stafid']);?>



Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : (Tindakan) Maklum balas aduan " . getDirSubName(getDirIDByMenuID(8));
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				}
			}
		}
}
?>
<?php
function emailFeedbackICT($to, $from, $subject, $type, $id)
{
	// Email aduan
	//to = array senarai StafID penerima dan ICT
	//subject = tajuk
	//type = jenis, cth 1 - Makluman Aduan
	//id = user_report ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT user_report.* FROM ict.user_report WHERE userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) 
	{	
	
	//email kepada user untuk maklum berkaitan aduan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Merujuk kepada aduan seperti berikut yang telah diselesaikan oleh <?php echo getDirSubName(getDirIDByMenuID(8));?> :-

Kategori 	: <?php echo getReportTypeByID(getReportTypeBySymptomID($row_ss['reportsymptom_id']));?> > <?php echo getReportSubTypeByID(getReportSubTypeBySymptomID($row_ss['reportsymptom_id']));?>

Isu			: <?php echo getReportSymptomByID($row_ss['reportsymptom_id']);?>


Tarikh 		: <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['userreport_date_m'], $row_ss['userreport_date_d'], $row_ss['userreport_date_y']));?>

Masa 		: <?php echo $row_ss['userreport_time'];?>


--------------------------

Catatan 	:
<?php echo htmlspecialchars_decode(getLastFeedbackNoteByUserReportID(htmlspecialchars($id, ENT_QUOTES)));?>


Oleh <?php echo getFullNameByStafID(getLastFeedbackUserIDByUserReportID(htmlspecialchars($id, ENT_QUOTES))) . " (" . getLastFeedbackUserIDByUserReportID(htmlspecialchars($id, ENT_QUOTES)) . ")";?> pada <?php echo getLastFeedbackDateByUserReportID(htmlspecialchars($id, ENT_QUOTES));?>


--------------------------


Mohon tuan/puan untuk membuat pengesahan aduan yang telah diselesaikan bagi tujuan penambahbaikkan perkhidmatan <?php echo getDirSubName(getDirIDByMenuID(8));?>.


Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk pengesahan berkaitan status aduan. Tuan/Puan tidak dibenarkan untuk membuat aduan baru sekiranya aduan sedia ada ini tidak dibuat pengesahan terlebih dahulu.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	
	//email kepada ICT untuk maklum berkaitan permohonana pinjaman baru
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Berikut maklum balas aduan yang telah tamat :-

Kategori 	: <?php echo getReportTypeByID(getReportTypeBySymptomID($row_ss['reportsymptom_id']));?> > <?php echo getReportSubTypeByID(getReportSubTypeBySymptomID($row_ss['reportsymptom_id']));?>

Isu			: <?php echo getReportSymptomByID($row_ss['reportsymptom_id']);?>


Tarikh 		: <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['userreport_date_m'], $row_ss['userreport_date_d'], $row_ss['userreport_date_y']));?>

Masa 		: <?php echo $row_ss['userreport_time'];?>


Oleh 		: <?php echo getFullNameByStafID($row_ss['user_stafid']) . " (" . $row_ss['user_stafid'] . "), Ext : " . getExtNoByUserID($row_ss['user_stafid']);?>

Unit 		: <?php echo getFulldirectoryByUserID($row_ss['user_stafid']);?>


--------------------------

Catatan :
<?php echo htmlspecialchars_decode(getLastFeedbackNoteByUserReportID(htmlspecialchars($id, ENT_QUOTES)));?>



Oleh <?php echo getFullNameByStafID(getLastFeedbackUserIDByUserReportID(htmlspecialchars($id, ENT_QUOTES))) . " (" . getLastFeedbackUserIDByUserReportID(htmlspecialchars($id, ENT_QUOTES)) . ")";?> pada <?php echo getLastFeedbackDateByUserReportID(htmlspecialchars($id, ENT_QUOTES));?>


--------------------------


Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut berkaitan maklum balas aduan.


Sekian, terima kasih.

Makluman ini dihantar kepada <?php echo getDirSubName(getDirIDByMenuID(8));?> melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageICT = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : (Tamat) Maklum balas aduan " . getDirSubName(getDirIDByMenuID(8));
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($key == 0 && $type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				} else if($key != 0 && $type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf dan ICT
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageICT, $format);
				}
			}
		}
}
?>
<?php
function emailPermohonanPeralatanICT($to, $from, $subject, $type, $id)
{
	// Email memaklumkan kepada ketua unit berkaitan keputusan permohonan peralatan ICT
	//to = array senarai StafID penerima dan ICT
	//subject = tajuk
	//type = jenis
	//id = userapply_id
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));


	if($type == 1) 
	{	
	
	//email kepada user untuk maklum berkaitan aduan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;


Permohonan peralatan / perisian <?php echo getDirSubName(getDirIDByMenuID(8));?> seperti berikut :-


Tarikh 	: <?php echo getApplyDateByApplyID(htmlspecialchars($id, ENT_QUOTES));?>

Catatan : 

<?php echo htmlspecialchars_decode(getApplyNoteByID(htmlspecialchars($id, ENT_QUOTES)));?>


Senarai kakitangan:-

<?php 
	$query_ss = "SELECT user_applyitem.* FROM ict.user_applyitem WHERE userapply_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

$i=1; do { ?>
<?php echo $i;?> - 
Nama 	: <?php echo getFullNameByStafID($row_ss['user_stafid']);?> (<?php echo $row_ss['user_stafid'];?>); 
Jenis 	: <?php echo getReqTypeNameByReqID($row_ss['reqtype_id']);?>;
Item 	: <?php echo getItemCategoryBySubCatID($row_ss['subcategory_id']) . " " . getItemSubCategoryByID($row_ss['subcategory_id']);?> 

--------------------------

<?php $i++; } while($row_ss = mysql_fetch_assoc($user_ss)); ?>


<?php echo getDirSubName(getDirIDByMenuID(8));?> akan membuat pertimbangan berkaitan permohonan ini mengikut keperluan / kepentingan, implikasi kewangan, status peralatan sedia ada, atau budi bicara.


<?php echo getDirSubName(getDirIDByMenuID(8));?> berhak untuk menukar atau membatalkan mana-mana permohonan atau keputusan yang telah dibuat tanpa sebarang notis atau makluman. Status permohonan boleh disemak melalui Modul ICT > Rekod > Rekod Permohonan.


Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	
	//email kepada user untuk maklum berkaitan aduan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;


Permohonan baru peralatan / perisian <?php echo getDirSubName(getDirIDByMenuID(8));?> seperti berikut :-


Tarikh 	: <?php echo getApplyDateByApplyID(htmlspecialchars($id, ENT_QUOTES));?>


Catatan : 
<?php echo htmlspecialchars_decode(getApplyNoteByID(htmlspecialchars($id, ENT_QUOTES)));?>


Senarai kakitangan:-

<?php 
	$query_ss2 = "SELECT user_applyitem.* FROM ict.user_applyitem WHERE userapply_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss2 = mysql_query($query_ss2);
	$row_ss2 = mysql_fetch_assoc($user_ss2);

$i=1; do { ?>
<?php echo $i;?> - 
Nama 	: <?php echo getFullNameByStafID($row_ss2['user_stafid']);?> (<?php echo $row_ss2['user_stafid'];?>); 
Jenis 	: <?php echo getReqTypeNameByReqID($row_ss2['reqtype_id']);?>;
Item 	: <?php echo getItemCategoryBySubCatID($row_ss2['subcategory_id']) . " " . getItemSubCategoryByID($row_ss2['subcategory_id']);?> 

--------------------------

<?php $i++; } while($row_ss2 = mysql_fetch_assoc($user_ss2)); ?>


Jumlah Pemohon : <?php echo countTotalStafByApplyID(htmlspecialchars($id, ENT_QUOTES));?>


Oleh :
<?php echo getFullNameByStafID(getStafIDByApplyID(htmlspecialchars($id, ENT_QUOTES))); ?> (<?php echo getStafIDByApplyID(htmlspecialchars($id, ENT_QUOTES)); ?>)
<?php echo getFulldirectoryByUserID(getStafIDByApplyID(htmlspecialchars($id, ENT_QUOTES)));?>
<?php echo "Ext : " . getExtNoByUserID(getStafIDByApplyID(htmlspecialchars($id, ENT_QUOTES)));?>



Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageICT = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Permohonan peralatan / perisian baru";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($key == 0 && $type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				} else {// email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageICT, $format);
				}
			}
		}
}
?>
<?php
function emailKelulusanPermohonanICT($to, $from, $subject, $type, $id)
{
	// Email memaklumkan kepada ketua unit berkaitan keputusan permohonan peralatan ICT
	//to = array senarai StafID penerima dan ICT
	//subject = tajuk
	//type = jenis
	//id = userapply_id
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT user_applyitem.* FROM ict.user_applyitem WHERE userapply_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) 
	{	
	
	//email kepada user untuk maklum berkaitan aduan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;


Berikut adalah keputusan permohonan peralatan / perisian <?php echo getDirSubName(getDirIDByMenuID(8));?> yang dipohon oleh tuan/puan merujuk kepada permohonan peralatan/perisian  seperti berikut :-


Tarikh 	: <?php echo getApplyDateByApplyID(htmlspecialchars($id, ENT_QUOTES));?>

Catatan : 

<?php echo htmlspecialchars_decode(getApplyNoteByID(htmlspecialchars($id, ENT_QUOTES)));?>


Senarai kakitangan / status permohonan :-

<?php $i=1; do { ?>
<?php echo $i;?> - Keputusan : <?php echo getStatusNameByID($row_ss['applystatus_id']);?>; Catatan : <?php echo htmlspecialchars_decode($row_ss['ict_note']);?>

Nama 	: <?php echo getFullNameByStafID($row_ss['user_stafid']);?> (<?php echo $row_ss['user_stafid'];?>); 
Jenis 	: <?php echo getReqTypeNameByReqID($row_ss['reqtype_id']);?>;
Item 	: <?php echo getItemCategoryBySubCatID($row_ss['subcategory_id']) . " " . getItemSubCategoryByID($row_ss['subcategory_id']);?> 

--------------------------

<?php $i++; } while($row_ss = mysql_fetch_assoc($user_ss)); ?>

<?php echo getDirSubName(getDirIDByMenuID(8));?> berhak untuk menukar atau membatalkan mana-mana permohonan atau keputusan yang telah dibuat tanpa sebarang notis atau makluman. Maklumat lanjut berkaitan status permohonan boleh disemakkan melalui Modul ICT > Rekod > Rekod Permohonan.


Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Keputusan permohonan peralatan / perisian";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				}
			}
		}
}
?>
<?php 
function emailTransaksiAdd($to, $from, $subject, $type, $id)
{
	// Email penambahan transaksi
	//to = array senarai StafID penerima
	//subject = tajuk
	//type = jenis, cth 1 - kelulusan
	//id = user_borrow ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT user_salary.* FROM www.user_salary WHERE usersalary_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) // 1 - Hantar laporan kepada HR
	{	
	
	//email kepada user untuk maklum berkaitan semakkan kata laluan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Penambahan transaksi dalam Penyata Gaji adalah seperti berikut :-


Tarikh Mula 	: <?php echo getTransactionDateStart($row_ss['user_stafid'], $row_ss['transaction_id'], htmlspecialchars($id, ENT_QUOTES));?>

Jenis Transaksi : <?php echo getTransactionType($row_ss['transaction_id']);?> <?php echo getTransactionName($row_ss['transaction_id']);?>

Jumlah 			: RM <?php echo $row_ss['usersalary_value'];?>


Untuk maklumat lanjut berkaitan penambahan transaksi ini, sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?>.

<?php echo $GLOBALS['adname'];?> berhak untuk membuat pindaan Penyata Gaji mengikut keperluan tanpa sebarang notis atau makluman.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Penambahan Transaksi dalam Penyata Gaji";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				}
			}
		}
}
?>
<?php 
function emailCoursesByDate($to, $from, $subject, $type, $id)
{
	// Email Courses Alert By Cron Jobs
	//to = array senarai StafID penerima
	//subject = tajuk
	//type = jenis, cth 1 - kelulusan
	//id = user_borrow ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	if($type == 1) // 1 - Hantar laporan kepada HR
	{	
	
	//email kepada user untuk maklum berkaitan semakkan kata laluan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Untuk makluman, kursus yang telah didaftarkan untuk hari ini adalah seperti berikut:-


Tajuk 	: <?php echo getCoursesName(htmlspecialchars($id, ENT_QUOTES));?>

Masa 	: <?php echo getCoursesTime(htmlspecialchars($id, ENT_QUOTES));?>

<?php if(getCoursesLocation(htmlspecialchars($id, ENT_QUOTES))!=NULL){?>
Tempat 	: <?php echo getCoursesLocation(htmlspecialchars($id, ENT_QUOTES));?>
<?php }; ?>


<?php if(checkCoursesNeedAttendence(htmlspecialchars($id, ENT_QUOTES))) echo "Kursus ini memerlukan peserta untuk membuat pengesahan kehadiran sebagai syarat  kiraan Jam Kursus."; if(checkReportNeed(htmlspecialchars($id, ENT_QUOTES))) echo "Kursus ini memerlukan peserta untuk menghantar laporan setelah selesai menghadirinya.";?>


Untuk maklumat lanjut, sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?>.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Kursus Hari Ini";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				}
			}
		}
}
?>
<?php 
function emailCoursesReportLate($to, $from, $subject, $type, $id)
{
	// Email Courses Alert By Cron Jobs
	//to = array senarai StafID penerima
	//subject = tajuk
	//type = jenis, cth 1 - kelulusan
	//id = user_borrow ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	if($type == 1) // 1 - Hantar laporan kepada HR
	{	
	
	//email kepada user untuk maklum berkaitan semakkan kata laluan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Kursus ini memerlukan peserta untuk menghantar laporan setelah selesai menghadirinya, seperti berikut:-


Tajuk 	: <?php echo getCoursesName(htmlspecialchars($id, ENT_QUOTES));?>

Tarikh 	: <?php echo getCoursesDate(htmlspecialchars($id, ENT_QUOTES), 0);?>

Masa 	: <?php echo getCoursesTime(htmlspecialchars($id, ENT_QUOTES));?>


Laporan kursus boleh dihantar melalui <?php echo $GLOBALS['systitle_full'];?> dalam Modul Kursus > Laporan (Sila klik pada pautan 'Hantar' pada tajuk kursus tersebut). Pengiraan Jam Kursus hanya akan dibuat setelah laporan yang dihantar telah diluluskan oleh <?php echo $GLOBALS['adname'];?>. Sila abaikan email ini sekiranya laporan telah dihantar.

Untuk maklumat lanjut, sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?>.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Laporan kursus";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				}
			}
		}
}
?>
<?php 
function cronemailICTReportFeedbackByDate($to2, $from, $subject, $type, $id)
{
	//Email Aduan yang belum diselesaikan kepada ICT dalam tempoh seminggu
	//to = array senarai StafID penerima
	//subject = tajuk
	//type = jenis, cth 1 - kelulusan
	//id = user_borrow ID
	
	$to = array();
	$to = getUserIDSysAcc(6, 28); //senarai stafid yg ada akses modul
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT user_report.* FROM ict.user_report WHERE userreport_status = 1 AND userreport_result = 0 AND NOT EXISTS (SELECT * FROM ict.user_reportfeedback WHERE urf_status = 1 AND feedbacktype_id = 0 AND user_reportfeedback.userreport_id = user_report.userreport_id)";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	$i = 0;

	if($type == 1 && $total>0) // 1 - Hantar email kpd ICt berkaitan Aduan yg belum diselesaikan
	{	
	
	//email kepada user untuk maklum berkaitan semakkan kata laluan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Aduan berikut masih tidak diselesaikan / ditamatkan :-
<?php 
do {
	if(checkFeedbackInWeek($row_ss['userreport_id'])) 
	{
		$i++;
?>

Kategori 	: <?php echo getReportTypeByID(getReportTypeBySymptomID($row_ss['reportsymptom_id']));?> <?php echo getReportSubTypeByID(getReportSubTypeBySymptomID($row_ss['reportsymptom_id']));?>

Isu 		: <?php echo getReportSymptomByID($row_ss['reportsymptom_id']);?>


Tarikh 		: <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['userreport_date_m'], $row_ss['userreport_date_d'], $row_ss['userreport_date_y']));?>

Masa 		: <?php echo $row_ss['userreport_time'];?>


<?php echo getFullNameByStafID($row_ss['user_stafid']) . " (" . $row_ss['user_stafid'] . "), Ext : " . getExtNoByUserID($row_ss['user_stafid']);?>, 
<?php echo getFulldirectoryByUserID($row_ss['user_stafid']);?>


--------
<?php
	} 
} while($row_ss = mysql_fetch_assoc($user_ss));
?>

Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut berkaitan maklum balas aduan.


Sekian, terima kasih.

Makluman ini dihantar kepada <?php echo getDirSubName(getDirIDByMenuID(8));?> melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Aduan yang belum ditamatkan";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
	
		if(($GLOBALS['sendemailfunc']) && $i > 0 && $total > 0) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				}
			}
		}
}
?>
<?php 
function cronemailICTReportFeedbackApprovalByDate($to, $from, $subject, $type, $id)
{
	//Email Aduan yang belum diselesaikan kepada ICt dalam tempoh seminggu
	//to = array senarai StafID penerima
	//subject = tajuk
	//type = jenis, cth 1 - kelulusan
	//id = user_borrow ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT user_report.* FROM ict.user_report WHERE userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND userreport_status = 1";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) // 1 - Hantar email kpd ICt berkaitan Aduan yg belum diselesaikan
	{	
	
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;


Tuan/puan diminta untuk membuat pengesahan / penilaian pada aduan dalam SPSM melalui 'Modul ICT > Rekod > Rekod Aduan' untuk penambahbaikkan perkhidmatan <?php echo getDirSubName(getDirIDByMenuID(8));?>.


Aduan tuan/puan telah diselesaikan / ditamatkan seperti berikut :-


Kategori 	: <?php echo getReportTypeByID(getReportTypeBySymptomID($row_ss['reportsymptom_id']));?> <?php echo getReportSubTypeByID(getReportSubTypeBySymptomID($row_ss['reportsymptom_id']));?>

Isu 		: <?php echo getReportSymptomByID($row_ss['reportsymptom_id']);?>


Tarikh 		: <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['userreport_date_m'], $row_ss['userreport_date_d'], $row_ss['userreport_date_y']));?>

Masa 		: <?php echo $row_ss['userreport_time'];?>


Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut berkaitan maklum balas aduan.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Pengesahan Aduan";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			$headers = array ('From' => $from, 'To' => getEmailISNByUserID($to), 'Subject' => $subject);
				
			if($type == 1 && getStatusTFByStafID($to))
			{ // email kpd staf
				$mail = $smtp->send(getEmailISNByUserID($to), $headers, $message, $format);
			}
		}
}
?>
<?php 
function emailSalaryError($to, $from, $subject, $type, $id)
{	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT salary_error.* FROM www.salary_error WHERE salaryerror_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) // 1 - Hantar laporan kepada HR
	{	
	
	//email kepada user untuk maklum berkaitan semakkan kata laluan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Pindaan dan semakkan penyata gaji bagi kakitangan seperti berikut:-


<?php echo getFullNameByStafID($row_ss['user_stafid']) . " (" . $row_ss['user_stafid'] . "), Ext : " . getExtNoByUserID($row_ss['user_stafid']);?>

<?php echo getFulldirectoryByUserID($row_ss['user_stafid']);?>


Penyata Bulan 	: <?php echo date('F Y', mktime(0, 0, 0, $row_ss['salaryerror_month'], 1, $row_ss['salaryerror_year']));?>


Untuk maklumat lanjut, sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?>.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Pindaan Penyata Gaji Bulanan";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				}
			}
		}
}
?>
<?php 
function emailHallBook($to, $from, $subject, $type, $id)
{
	// Email Courses Alert By Cron Jobs
	//to = array senarai StafID penerima
	//subject = tajuk
	//type = jenis, cth 1 - kelulusan
	//id = user_borrow ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));
	
	if($type == 1) 
	{	
	
	//email kepada user untuk maklum berkaitan semakkan kata laluan
	ob_start(); //Turn on output buffering	
?>
Salam Sejahtera;

Tempahan dewan / bilik seperti berikut:-

Lokasi 	: <?php echo getHallName(getBookingHallID($id[0]));?>

Tarikh 	: 
<?php 
foreach($id AS $key => $value)
{ $i = $key + 1;
?> <?php echo $i . ". " . getBookingDate($value);?>, Sesi : <?php echo getBookingSesi($value);?>

<?php }; ?>

Tujuan 	: <?php if(getBookingName($id[0])!=NULL) echo htmlspecialchars_decode(getBookingName($id[0])); else echo "Tidak dinyatakan";?>


Catatan : <?php if(getBookingDetail($id[0])!=NULL) echo htmlspecialchars_decode(getBookingDetail($id[0])); else echo "Tidak dinyatakan";?>


Oleh 	: <?php echo getFullNameByStafID($to[0]) . " (" . $to[0] . "), Ext : " . getExtNoByUserID($to[0]);?>
<?php echo getFulldirectoryByUserID($to[0]);?>


Pentadbir Bilik/Dewan berhak untuk mengubah atau membatalkan maklumat tempahan dengan notis atau makluman. Untuk maklumat lanjut, sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?>.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Tempahan Dewan / Bilik";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				}
			}
		}
}
?>
<?php 
function emailAduanBaruHarta($to, $from, $subject, $type, $id)
{
	// Email aduan
	//to = array senarai StafID penerima dan ICT
	//subject = tajuk
	//type = jenis, cth 1 - Makluman Aduan
	//id = user_report ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT user_report.* FROM harta.user_report WHERE userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) 
	{	
	
	//email kepada user untuk maklum berkaitan aduan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Berikut maklumat aduan yang telah dibuat :-


No. Tiket 	: <?php echo getReportTicketByID(htmlspecialchars($id, ENT_QUOTES)); ?>

Perkara 	: <?php echo getCategoryNameByRCID(getReportCaseByURID(htmlspecialchars($id, ENT_QUOTES))); ?> > <?php echo getSubCategoryNameByRCID(getReportCaseByURID(htmlspecialchars($id, ENT_QUOTES))); ?> > <?php echo getRCTitleByID(getReportCaseByURID(htmlspecialchars($id, ENT_QUOTES)));?>

Lokasi 		: <?php echo htmlspecialchars_decode(getReportLocationByID(htmlspecialchars($id, ENT_QUOTES)));?>

Tarikh 		: <?php echo getReportDate(htmlspecialchars($id, ENT_QUOTES));?>


Oleh 		: <?php echo getFullNameByStafID(getReportByByID(htmlspecialchars($id, ENT_QUOTES))) . " (" . getReportByByID(htmlspecialchars($id, ENT_QUOTES)) . ")";?>, Ext : <?php echo getExtNoByUserID(getReportByByID(htmlspecialchars($id, ENT_QUOTES)));?>

Unit 		: <?php echo getFulldirectoryByUserID(getReportByByID(htmlspecialchars($id, ENT_QUOTES)));?>


Setiap pemohon hanya dibenarkan untuk membuat 5 kali aduan dalam tempoh tarikh tersebut. Setiap aduan yang dibuat akan dinilai untuk tujuan penambahbaik perkhidmatan. 

<?php echo getDirSubName(getDirIDByMenuID(11));?> berhak untuk membatal atau menukar maklumat aduan tanpa sebarang notis atau makluman.

Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut berkaitan status aduan. Sila berhubungan dengan <?php echo getDirSubName(getDirIDByMenuID(11));?> dengan menyertakan No. Tiket aduan sekiranya tiada sebarang tindakan diambil dalam tempoh 24 jam daripada tarikh aduan dibuat.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	
	//email kepada ICT untuk maklum berkaitan permohonana pinjaman baru
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Berikut maklumat aduan baru untuk tindakan selanjutnya :-


No. Tiket 	: <?php echo getReportTicketByID(htmlspecialchars($id, ENT_QUOTES)); ?>

Perkara 	: <?php echo getCategoryNameByRCID(getReportCaseByURID(htmlspecialchars($id, ENT_QUOTES))); ?> > <?php echo getSubCategoryNameByRCID(getReportCaseByURID(htmlspecialchars($id, ENT_QUOTES))); ?> > <?php echo getRCTitleByID(getReportCaseByURID(htmlspecialchars($id, ENT_QUOTES)));?>

Lokasi 		: <?php echo htmlspecialchars_decode(getReportLocationByID(htmlspecialchars($id, ENT_QUOTES)));?>

Tarikh 		: <?php echo getReportDate(htmlspecialchars($id, ENT_QUOTES));?>


Oleh 		: <?php echo getFullNameByStafID(getReportByByID(htmlspecialchars($id, ENT_QUOTES))) . " (" . getReportByByID(htmlspecialchars($id, ENT_QUOTES)) . ")";?>, Ext : <?php echo getExtNoByUserID(getReportByByID(htmlspecialchars($id, ENT_QUOTES)));?>

Unit 		: <?php echo getFulldirectoryByUserID(getReportByByID(htmlspecialchars($id, ENT_QUOTES)));?>


Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut berkaitan aduan.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageICT = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Aduan kerosakkan harta / kemudahan kepada " . getDirSubName(getDirIDByMenuID(11));
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($key == 0 && $type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf dan ICT
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				} else if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf dan ICT
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageICT, $format);
				}
			}
		}
}
?>
<?php
function emailFeedbackHartaAction($to, $from, $subject, $type, $id)
{
	// Email aduan
	//to = array senarai StafID penerima dan ICT
	//subject = tajuk
	//type = jenis, cth 1 - Makluman Aduan
	//id = user_report ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	if($type == 1) 
	{	
	
	//email kepada user untuk maklum berkaitan aduan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Tindakan/perhatian daripada tuan/puan bagi aduan berikut diperlukan :-


No. Tiket 	: <?php echo getReportTicketByID(htmlspecialchars($id, ENT_QUOTES)); ?>

Perkara 	: <?php echo getCategoryNameByRCID(getReportCaseByURID(htmlspecialchars($id, ENT_QUOTES))); ?> > <?php echo getSubCategoryNameByRCID(getReportCaseByURID(htmlspecialchars($id, ENT_QUOTES))); ?> > <?php echo getRCTitleByID(getReportCaseByURID(htmlspecialchars($id, ENT_QUOTES)));?>

Lokasi 		: <?php echo htmlspecialchars_decode(getReportLocationByID(htmlspecialchars($id, ENT_QUOTES)));?>

Tarikh 		: <?php echo getReportDate(htmlspecialchars($id, ENT_QUOTES));?>


Oleh 		: <?php echo getFullNameByStafID(getReportByByID(htmlspecialchars($id, ENT_QUOTES))) . " (" . getReportByByID(htmlspecialchars($id, ENT_QUOTES)) . ")";?>, Ext : <?php echo getExtNoByUserID(getReportByByID(htmlspecialchars($id, ENT_QUOTES)));?>

Unit 		: <?php echo getFulldirectoryByUserID(getReportByByID(htmlspecialchars($id, ENT_QUOTES)));?>


Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : (Tindakan) Maklum balas aduan kepada " . getDirSubName(getDirIDByMenuID(11));
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				}
			}
		}
}
?>
<?php
function emailFeedbackHarta($to, $from, $subject, $type, $id)
{
	// Email aduan
	//to = array senarai StafID penerima dan ICT
	//subject = tajuk
	//type = jenis, cth 1 - Makluman Aduan
	//id = user_report ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT user_report.* FROM harta.user_report WHERE userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) 
	{	
	
	//email kepada user untuk maklum berkaitan aduan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;


Mohon tuan/puan untuk membuat pengesahan aduan yang telah diselesaikan bagi tujuan penambahbaikkan perkhidmatan <?php echo getDirSubName(getDirIDByMenuID(11));?>. Tuan/Puan tidak dibenarkan untuk membuat aduan baru sekiranya aduan sedia ada ini tidak dibuat pengesahan terlebih dahulu. 


Merujuk kepada aduan berikut :-


No. Tiket 	: <?php echo getReportTicketByID(htmlspecialchars($id, ENT_QUOTES)); ?>

Tarikh 		: <?php echo getReportDate(htmlspecialchars($id, ENT_QUOTES));?>


Perkara 	: <?php echo getCategoryNameByRCID(getReportCaseByURID(htmlspecialchars($id, ENT_QUOTES))); ?> > <?php echo getSubCategoryNameByRCID(getReportCaseByURID(htmlspecialchars($id, ENT_QUOTES))); ?> > <?php echo getRCTitleByID(getReportCaseByURID(htmlspecialchars($id, ENT_QUOTES)));?>

Lokasi 		: <?php echo htmlspecialchars_decode(getReportLocationByID(htmlspecialchars($id, ENT_QUOTES)));?>


--------------------------


Catatan 	:
<?php echo htmlspecialchars_decode(getFeedbackLastNote(htmlspecialchars($id, ENT_QUOTES)));?>


Oleh <?php echo getFullNameByStafID(getFeedbackLastStafID(htmlspecialchars($id, ENT_QUOTES))) . " (" . getFeedbackLastStafID(htmlspecialchars($id, ENT_QUOTES)) . ")";?> pada <?php echo getFeedbackLastDate(htmlspecialchars($id, ENT_QUOTES));?>


--------------------------



Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk pengesahan berkaitan status aduan.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	
	//email kepada ICT untuk maklum berkaitan permohonana pinjaman baru
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Berikut maklum balas aduan yang telah tamat :-


No. Tiket 	: <?php echo getReportTicketByID(htmlspecialchars($id, ENT_QUOTES)); ?>

Tarikh 		: <?php echo getReportDate(htmlspecialchars($id, ENT_QUOTES));?>


Perkara 	: <?php echo getCategoryNameByRCID(getReportCaseByURID(htmlspecialchars($id, ENT_QUOTES))); ?> > <?php echo getSubCategoryNameByRCID(getReportCaseByURID(htmlspecialchars($id, ENT_QUOTES))); ?> > <?php echo getRCTitleByID(getReportCaseByURID(htmlspecialchars($id, ENT_QUOTES)));?>

Lokasi 		: <?php echo htmlspecialchars_decode(getReportLocationByID(htmlspecialchars($id, ENT_QUOTES)));?>


Oleh 		: <?php echo getFullNameByStafID(getReportByByID(htmlspecialchars($id, ENT_QUOTES))) . " (" . getReportByByID(htmlspecialchars($id, ENT_QUOTES)) . ")";?>, Ext : <?php echo getExtNoByUserID(getReportByByID(htmlspecialchars($id, ENT_QUOTES)));?>

Unit 		: <?php echo getFulldirectoryByUserID(getReportByByID(htmlspecialchars($id, ENT_QUOTES)));?>


--------------------------

Catatan 	:
<?php echo htmlspecialchars_decode(getFeedbackLastNote(htmlspecialchars($id, ENT_QUOTES)));?>


Oleh <?php echo getFullNameByStafID(getFeedbackLastStafID(htmlspecialchars($id, ENT_QUOTES))) . " (" . getFeedbackLastStafID(htmlspecialchars($id, ENT_QUOTES)) . ")";?> pada <?php echo getFeedbackLastDate(htmlspecialchars($id, ENT_QUOTES));?>


--------------------------


Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut berkaitan maklum balas aduan.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageICT = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : (Tamat) Maklum balas aduan kerosakkan harta / kemudahan";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($key == 0 && $type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				} else if($key != 0 && $type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf dan ICT
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageICT, $format);
				}
			}
		}
}
?>
<?php
function emailFeedbackLate24Harta($to, $from, $subject, $type, $id)
{
	// Email aduan harta yang lambat diselesaikan dalam tempoh 24 jam
	//to = array senarai StafID penerima dan ICT
	//subject = tajuk
	//type = jenis, cth 1 - Makluman Aduan
	//id = user_report ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	if($type == 1) 
	{
		
	$to = getUserIDSysAcc(12, 45);	// array
	
	$d3 = date('d', mktime(0, 0, 0, date('m'), date('d')-1, date('Y')));
	$m3 = date('m', mktime(0, 0, 0, date('m'), date('d')-1, date('Y')));
	$y3 = date('Y', mktime(0, 0, 0, date('m'), date('d')-1, date('Y')));

	$query_ss = "SELECT user_report.userreport_id FROM harta.user_report WHERE userreport_date_d = '" . $d3 . "' AND userreport_date_m = '" . $m3 . "' AND userreport_date_y = '" . $y3 . "' AND userreport_status = 1 AND NOT EXISTS(SELECT * FROM harta.user_reportfeedback WHERE user_reportfeedback.userreport_id = user_report.userreport_id)";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	
	$total = mysql_num_rows($user_ss);
	
	//email kepada StafID Modull Harta untuk maklum berkaitan aduan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Tiada sebarang tindakan terhadap aduan dalam tempoh 24 jam (merujuk pada tarikh aduan) berikut :-

<?php
do{
?>
No. Tiket 	: <?php echo getReportTicketByID($row_ss['userreport_id']); ?>

Perkara 	: <?php echo getCategoryNameByRCID(getReportCaseByURID($row_ss['userreport_id'])); ?> > <?php echo getSubCategoryNameByRCID(getReportCaseByURID($row_ss['userreport_id'])); ?> > <?php echo getRCTitleByID(getReportCaseByURID($row_ss['userreport_id']));?>

Lokasi 		: <?php echo htmlspecialchars_decode(getReportLocationByID($row_ss['userreport_id']));?>

Tarikh 		: <?php echo getReportDate($row_ss['userreport_id']);?>


<?php echo getFullNameByStafID(getReportByByID($row_ss['userreport_id'])) . " (" . getReportByByID($row_ss['userreport_id']) . ")";?>, Ext : <?php echo getExtNoByUserID(getReportByByID($row_ss['userreport_id']));?>

<?php echo getFulldirectoryByUserID(getReportByByID($row_ss['userreport_id']));?>


--------

<?php } while($row_ss = mysql_fetch_assoc($user_ss)); ?>
Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : (Tindakan) Tiada tindakan pada aduan";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc'] && $total > 0) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				}
			}
		}
	mysql_free_result($user_ss);
}
?>
<?php
function emailFeedbackLateHarta($to, $from, $subject, $type, $id)
{
	// Email aduan harta yang lambat diselesaikan dalam tempoh 3 hari
	//to = array senarai StafID penerima dan ICT
	//subject = tajuk
	//type = jenis, cth 1 - Makluman Aduan
	//id = user_report ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	if($type == 1) 
	{
		
	$to = getUserIDSysAcc(12, 45);	

	$query_ss = "SELECT * FROM harta.user_report WHERE userreport_status = 1 AND NOT EXISTS(SELECT * FROM harta.user_reportfeedback WHERE user_reportfeedback.userreport_id = user_report.userreport_id AND (feedbacktype_id = 0 OR feedbacktype_id = 3) ORDER BY user_reportfeedback.urf_id DESC LIMIT 1)";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);
	$total = mysql_num_rows($user_ss);
	
	//echo $d3 . "/" . $m3 . "/" . $y3; 
	
	//email kepada StafID Modull Harta untuk maklum berkaitan aduan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Tindakan/perhatian daripada tuan/puan bagi aduan berikut diperlukan :

<?php
$i=0;
do{
	if(countFeedbackLastDate($row_ss['userreport_id'])!=0 && (countFeedbackLastDate($row_ss['userreport_id'])%3) == 0)
	{ $i++;
		?>
No. Tiket 	: <?php echo getReportTicketByID($row_ss['userreport_id']); ?>

Tarikh 		: <?php echo getReportDate($row_ss['userreport_id']);?>


Perkara 	: <?php echo getCategoryNameByRCID(getReportCaseByURID($row_ss['userreport_id'])); ?> > <?php echo getSubCategoryNameByRCID(getReportCaseByURID($row_ss['userreport_id'])); ?> > <?php echo getRCTitleByID(getReportCaseByURID($row_ss['userreport_id']));?>

Lokasi 		: <?php echo htmlspecialchars_decode(getReportLocationByID($row_ss['userreport_id']));?>


<?php echo getFullNameByStafID(getReportByByID($row_ss['userreport_id'])) . " (" . getReportByByID($row_ss['userreport_id']) . ")";?>, Ext : <?php echo getExtNoByUserID(getReportByByID($row_ss['userreport_id']));?>

<?php echo getFulldirectoryByUserID(getReportByByID($row_ss['userreport_id']));?>


--------

<?php }; } while($row_ss = mysql_fetch_assoc($user_ss)); ?>
Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut.


Sekian, terima kasih.

Makluman ini dihantar kepada <?php echo getDirSubName(getDirIDByMenuID(11));?> melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	mysql_free_result($user_ss);
	
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : (Tindakan) Aduan yang belum tamat";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc'] && $i > 0 && $total > 0) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				}
			}
		}
}
?>
<?php
//SKT
function emailSKTFeedback($to, $from, $subject, $type, $id)
{
	// Email aduan
	//to = array senarai StafID penerima dan ICT
	//subject = tajuk
	//type = jenis, cth 1 - Makluman Aduan
	//id = user_report ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	if($type == 1) 
	{	
	
	//email kepada user untuk maklum berkaitan aduan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Tindakan/perhatian daripada tuan/puan bagi aduan berikut diperlukan :

No. Tiket 	: <?php echo getReportTicketByID(htmlspecialchars($id, ENT_QUOTES)); ?>

Tarikh 		: <?php echo getReportDate(htmlspecialchars($id, ENT_QUOTES));?>


Perkara 	: <?php echo getCategoryNameByRCID(getReportCaseByURID(htmlspecialchars($id, ENT_QUOTES))); ?> > <?php echo getSubCategoryNameByRCID(getReportCaseByURID(htmlspecialchars($id, ENT_QUOTES))); ?> > <?php echo getRCTitleByID(getReportCaseByURID(htmlspecialchars($id, ENT_QUOTES)));?>

Lokasi 		: <?php echo htmlspecialchars_decode(getReportLocationByID(htmlspecialchars($id, ENT_QUOTES)));?>


Oleh 		: <?php echo getFullNameByStafID(getReportByByID(htmlspecialchars($id, ENT_QUOTES))) . " (" . getReportByByID(htmlspecialchars($id, ENT_QUOTES)) . ")";?>, Ext : <?php echo getExtNoByUserID(getReportByByID(htmlspecialchars($id, ENT_QUOTES)));?>

Unit 		: <?php echo getFulldirectoryByUserID(getReportByByID(htmlspecialchars($id, ENT_QUOTES)));?>


Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : (Tindakan) Maklum balas aduan kerosakkan harta / kemudahan";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				}
			}
		}
}
?>
<?php
// Admin > Tiket
function emailNewTicket($to, $from, $subject, $type, $id)
{
	// Email permohonan baru kepada Admin
	// to = array senarai StafID penerima
	// subject = tajuk
	// type = jenis
	// id = tiket ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_tr = "SELECT * FROM tadbir.travel WHERE ticket_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND travel_status = 1 ORDER BY travel_id ASC";	
	$user_tr = mysql_query($query_tr);
	$row_tr = mysql_fetch_assoc($user_tr);
	$total_tr = mysql_num_rows($user_tr);

	$query_isnp = "SELECT * FROM tadbir.isnpassenger WHERE ip_status = 1 AND ticket_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY ip_id ASC";	
	$user_isnp = mysql_query($query_isnp);
	$row_isnp = mysql_fetch_assoc($user_isnp);
	$total_isnp = mysql_num_rows($user_isnp);

	$query_nisnp = "SELECT * FROM tadbir.nonisnpassenger WHERE nip_status = 1 AND ticket_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY nip_id ASC";	
	$user_nisnp = mysql_query($query_nisnp);
	$row_nisnp = mysql_fetch_assoc($user_nisnp);
	$total_nisnp = mysql_num_rows($user_nisnp);

	if($type == 1) 
	{	
	
	//email kepada admin / user untuk maklum berkaitan tempahan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Berikut merupakan permohonan tiket yang telah dihantar :


Jenis Tiket 			: <?php echo getTiketType(htmlspecialchars($id, ENT_QUOTES));?>

Tujuan / Program 		: <?php echo htmlspecialchars_decode(getTiketTitle(htmlspecialchars($id, ENT_QUOTES)));?>

No. Rujukan Kelulusan 	: <?php echo getTiketRef(htmlspecialchars($id, ENT_QUOTES));?>


Maklumat Perjalanan 	:

<?php 
if($total_tr>0)
{
	$i=1; do { ?>
<?php echo $i; ?> - <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_tr['travel_date_m'], $row_tr['travel_date_d'], $row_tr['travel_date_y']));?>, <?php echo $row_tr['travel_time']; ?>, <?php echo $row_tr['travel_from']; ?> -> <?php echo $row_tr['travel_to']; ?>

<?php 
$i++; 
}while($row_tr = mysql_fetch_assoc($user_tr));
} else echo "Tiada rekod dijumpai";?>


Jumlah Penumpang 		: <?php echo getTotalPenumpang(htmlspecialchars($id, ENT_QUOTES));?> orang


Senarai Penumpang 		:

A) Kakitangan ISN
<?php 
if($total_isnp>0)
{ 
	$j=1; do{ ?>
<?php echo $j;?> - <?php echo getFullNameByStafID($row_isnp['user_stafid']) . " (" . $row_isnp['user_stafid'] . ")";?>, <?php echo getFulldirectoryByUserID($row_isnp['user_stafid']);?>

<?php 
$j++; 
}while($row_isnp = mysql_fetch_assoc($user_isnp));
} else echo "Tiada rekod dijumpai";?>


B) Bukan Kakitangan ISN
<?php 
if($total_nisnp>0)
{ 
	$k=1; do{ ?>
<?php echo $k;?> - <?php echo $row_nisnp['nip_name']; ?>, No. KP : <?php if($row_nisnp['nip_noic']!=NULL) echo $row_nisnp['nip_noic']; else echo "Tidak dinyatakan"; ?>, No. Passport : <?php if($row_nisnp['nip_passport']!=NULL) echo $row_nisnp['nip_passport']; else echo "Tidak dinyatakan"; ?>

<?php 
$k++; 
}while($row_nisnp = mysql_fetch_assoc($user_nisnp));
} else echo "Tiada rekod dijumpai";?>


Tambahan Bagasi 		: <?php echo getTiketBagasi(htmlspecialchars($id, ENT_QUOTES));?> kg
Insuran Perjalanan 		: <?php if(getTiketInsuran(htmlspecialchars($id, ENT_QUOTES))==1) echo "Ya"; else echo "Tidak";?>

Visa Perjalanan 		: <?php if(getTiketVisa(htmlspecialchars($id, ENT_QUOTES))==1) echo "Ya"; else echo "Tidak";?>



Oleh 					: <?php echo getFullNameByStafID(getTiketBy(htmlspecialchars($id, ENT_QUOTES))) . " (" . getTiketBy(htmlspecialchars($id, ENT_QUOTES)) . ")";?>, Ext : <?php echo getExtNoByUserID(getTiketBy($id));?>

Unit 					: <?php echo getFulldirectoryByUserID(getTiketBy(htmlspecialchars($id, ENT_QUOTES)));?>



<?php echo getDirSubName(getDirIDByMenuID(9));?> berhak untuk menukar atau membatal mana-mana maklumat dan permohonan mengikut keperluan tanpa sebarang notis atau makluman, dan tertakluk pada terma dan syarat. Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	  
	mysql_free_result($user_tr);
	mysql_free_result($user_isnp);
	mysql_free_result($user_nisnp);
	
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Tempahan Tiket " . getTiketType(htmlspecialchars($id, ENT_QUOTES));
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				}
			}
		}
}
?>
<?php
// Admin > Tiket > Kelulusan
function emailAppTicket($to, $from, $subject, $type, $id)
{
	// Email kelulusan permohonan kepada user
	// to = array senarai StafID penerima
	// subject = tajuk
	// type = jenis
	// id = tiket ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	if($type == 1) 
	{	
	
	//email kepada admin / user untuk maklum berkaitan tempahan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Berikut merupakan keputusan kelulusan permohonan tiket :-

Permohonan untuk penempahan tiket <?php echo getTiketType(htmlspecialchars($id, ENT_QUOTES));?> <?php if(checkTiketAppOrNot(htmlspecialchars($id, ENT_QUOTES))) echo "DILULUSKAN"; else echo "TIDAK DILULUSKAN";?> oleh <?php if(getTiketAppBy(htmlspecialchars($id, ENT_QUOTES))==1) echo getJob2Name('2'); else echo getJob2Name('9')?> pada <?php echo getTiketAppDate(htmlspecialchars($id, ENT_QUOTES));?>.
<?php if(getTiketAppNote(htmlspecialchars($id, ENT_QUOTES))!=NULL){?>

Catatan :
<?php echo htmlspecialchars_decode(getTiketAppNote(htmlspecialchars($id, ENT_QUOTES)));?>

<?php }; ?>

-----------------------------

Keputusan kelulusan ini adalah merujuk pada maklumat tempahan berikut :-

Tarikh Permohonan 		: <?php echo getTiketDate(htmlspecialchars($id, ENT_QUOTES));?>

Jenis Tiket 			: <?php echo getTiketType(htmlspecialchars($id, ENT_QUOTES));?>

Tujuan / Program 		: <?php echo htmlspecialchars_decode(getTiketTitle(htmlspecialchars($id, ENT_QUOTES)));?>

No. Rujukan Kelulusan 	: <?php echo getTiketRef(htmlspecialchars($id, ENT_QUOTES));?>

Jumlah Penumpang 		: <?php echo getTotalPenumpang(htmlspecialchars($id, ENT_QUOTES));?> orang

Oleh 					: <?php echo getFullNameByStafID(getTiketBy(htmlspecialchars($id, ENT_QUOTES))) . " (" . getTiketBy(htmlspecialchars($id, ENT_QUOTES)) . ")";?>, Ext : <?php echo getExtNoByUserID(getTiketBy(htmlspecialchars($id, ENT_QUOTES)));?>

Unit 					: <?php echo getFulldirectoryByUserID(getTiketBy(htmlspecialchars($id, ENT_QUOTES)));?>



Maklumat berkaitan dengan tiket akan dikemaskini apabila pihak agensi telah membuat pengesahan dengan Cawangan Pentadbiran.


Maklumat kelulusan ini dikemaskini oleh <?php echo getFullNameByStafID(getAppUpdateByTiketApp(htmlspecialchars($id, ENT_QUOTES))) . " (" . getAppUpdateByTiketApp(htmlspecialchars($id, ENT_QUOTES)) . ")";?> pada <?php echo getAppUpdateDateTiketApp(htmlspecialchars($id, ENT_QUOTES));?>. 


<?php echo getDirSubName(getDirIDByMenuID('9'));?> berhak untuk menukar atau membatal mana-mana maklumat dan permohonan mengikut keperluan tanpa sebarang notis atau makluman, dan tertakluk pada terma dan syarat. Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Kelulusan Tempahan Tiket " . getTiketType(htmlspecialchars($id, ENT_QUOTES));
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				}
			}
		}
}
?>
<?php
// Admin > Tiket > Kelulusan
function emailInvTicket($to, $from, $subject, $type, $id)
{
	// Email maklumat tiket kepada user
	// to = array senarai StafID penerima
	// subject = tajuk
	// type = jenis
	// id = tiket ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	if($type == 1) 
	{	
	
	//email kepada admin / user untuk maklum berkaitan tempahan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Berikut merupakan tiket yang telah dibuat mengikut permohonan :-


No. Rujukan Tiket 	: <?php echo getTiketInvRef(htmlspecialchars($id, ENT_QUOTES));?>


Maklumat Agensi		:

<?php echo getAgensiName(getAgensiIDByTiketID(htmlspecialchars($id, ENT_QUOTES)));?>

<?php if(getAgensiNoTel(getAgensiIDByTiketID(htmlspecialchars($id, ENT_QUOTES)))!=NULL) echo "Tel : " . getAgensiNoTel(getAgensiIDByTiketID(htmlspecialchars($id, ENT_QUOTES)));?>

<?php if(getAgensiNoFax(getAgensiIDByTiketID(htmlspecialchars($id, ENT_QUOTES)))!=NULL) echo "Fax : " . getAgensiNoFax(getAgensiIDByTiketID(htmlspecialchars($id, ENT_QUOTES)));?>

<?php if(getAgensiEmail(getAgensiIDByTiketID(htmlspecialchars($id, ENT_QUOTES)))!=NULL) echo "Email : " . getAgensiEmail(getAgensiIDByTiketID(htmlspecialchars($id, ENT_QUOTES)));?>



Catatan 			:
<?php echo getTiketInvNote(htmlspecialchars($id, ENT_QUOTES));?>


----------------------------

Tiket ini adalah merujuk pada maklumat tempahan berikut :-

Tarikh Permohonan 		: <?php echo getTiketDate(htmlspecialchars($id, ENT_QUOTES));?>

Jenis Tiket				: <?php echo getTiketType(htmlspecialchars($id, ENT_QUOTES));?>

Tujuan / Program 		: <?php echo htmlspecialchars_decode(getTiketTitle(htmlspecialchars($id, ENT_QUOTES)));?>

No. Rujukan Kelulusan	: <?php echo getTiketRef(htmlspecialchars($id, ENT_QUOTES));?>

Jumlah Penumpang		: <?php echo getTotalPenumpang(htmlspecialchars($id, ENT_QUOTES));?> orang


Oleh 					: <?php echo getFullNameByStafID(getTiketBy(htmlspecialchars($id, ENT_QUOTES))) . " (" . getTiketBy(htmlspecialchars($id, ENT_QUOTES)) . ")";?>, Ext : <?php echo getExtNoByUserID(getTiketBy(htmlspecialchars($id, ENT_QUOTES)));?>

Unit 					: <?php echo getFulldirectoryByUserID(getTiketBy(htmlspecialchars($id, ENT_QUOTES)));?>



Maklumat tiket ini dikemaskini oleh <?php echo getFullNameByStafID(getTiketInvUpdateByTiketApp(htmlspecialchars($id, ENT_QUOTES))) . " (" . getTiketInvUpdateByTiketApp(htmlspecialchars($id, ENT_QUOTES)) . ")";?> pada <?php echo getTiketInvUpdateDateTiketApp(htmlspecialchars($id, ENT_QUOTES));?>. 


<?php echo getDirSubName(getDirIDByMenuID('9'));?> berhak untuk menukar atau membatal mana-mana maklumat dan permohonan mengikut keperluan tanpa sebarang notis atau makluman, dan tertakluk pada terma dan syarat. Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Maklumat Tiket " . getTiketType($id);
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				}
			}
		}
}
?>
<?php
// Am 5 Bab G
function emailNewLeaveOffice($to, $from, $subject, $type, $id)
{
	// Email maklumat kelulusan permohonan kepada user
	// to = array senarai StafID penerima
	// subject = tajuk
	// type = jenis
	// id = Leave Office ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	if($type == 1) 
	{	
	
		//email kepada admin / user untuk kelulusan permohonanob_start(); 
		ob_start(); //Turn on output buffering	
?>
Salam sejahtera;


Berikut adalah permohonan kebenaran meninggalkan pejabat dalam waktu pejabat (AM 5 BAB G) :-


Nama 	: <?php echo getFullNameByStafID(getUserIDByLeaveOfficeID($id)) . " (" . getUserIDByLeaveOfficeID($id) . ")";?>.


Tarikh 	: <?php echo getDateLeaveByLeaveOfficeID($id);?>

Tempoh 	: <?php if(getReasonType(getReasonByLeaveOfficeID($id))=='0') echo getTimeLeaveByLeaveOfficeID($id) . " hingga " . getTimeBackByLeaveOfficeID($id); elseif(getReasonType(getReasonByLeaveOfficeID($id))=='1') echo getLeaveOfficeDayByLeaveOfficeID($id) . " " . getDayType(getLeaveOfficeDayTypeByLeaveOfficeID($id));?>


Sebab 	: <?php echo getReasonNameByID(getReasonByLeaveOfficeID($id));?>

Catatan : <?php echo htmlspecialchars_decode(getLeaveNoteByLeaveOfficeID($id));?>



Sila layari URL berikut <?php echo $GLOBALS['url_main'];?> untuk semakkan kelulusan dan maklumat lanjut.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;


Berikut adalah permohonan baru kebenaran meninggalkan pejabat dalam waktu pejabat (AM 5 BAB G) untuk kelulusan :-


Nama 	: <?php echo getFullNameByStafID(getUserIDByLeaveOfficeID($id)) . " (" . getUserIDByLeaveOfficeID($id) . ")";?>.


Tarikh 	: <?php echo getDateLeaveByLeaveOfficeID($id);?>

Tempoh 	: <?php if(getReasonType(getReasonByLeaveOfficeID($id))=='0') echo getTimeLeaveByLeaveOfficeID($id) . " hingga " . getTimeBackByLeaveOfficeID($id); elseif(getReasonType(getReasonByLeaveOfficeID($id))=='1') echo getLeaveOfficeDayByLeaveOfficeID($id) . " " . getDayType(getLeaveOfficeDayTypeByLeaveOfficeID($id));?>


Sebab 	: <?php echo getReasonNameByID(getReasonByLeaveOfficeID($id));?>


Catatan : <?php echo htmlspecialchars_decode(getLeaveNoteByLeaveOfficeID($id));?>



Untuk meluluskan permohonan ini, sila klik pada Modul Bahagian/Cawangan/Pusat/Unit > Kehadiran dengan melayari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?>.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageHead = ob_get_clean();
	
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Permohonan Kebenaran Meninggalkan Pejabat Dalam Waktu Pejabat (AM 5 BAB G)";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($key == 0 && $type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				} elseif($key == 1 && $type == 1 && getStatusTFByStafID($value))
				{ // email kpd Head
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageHead, $format);
				}
			}
		}
}
?>
<?php
// Am 5 Bab G
function emailApprovalLeaveOffice($to, $from, $subject, $type, $id)
{
	// Email maklumat kelulusan permohonan kepada user
	// to = array senarai StafID penerima
	// subject = tajuk
	// type = jenis
	// id = Leave Office ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	if($type == 1) 
	{	
	
	//email kepada admin / user untuk kelulusan permohonan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;


Kelulusan permohonan kebenaran meninggalkan pejabat dalam waktu pejabat (AM 5 BAB G) adalah <b> <?php if(getHeadApprovalByLeaveOfficeID($id)=='1') echo "DILULUSKAN"; else echo "TIDAK DILULUSKAN";?> </b> <?php if(checkWarningByLeaveOfficeID($id)) echo " dengan AMARAN ";?> oleh <?php echo getFullNameByStafID(getHeadApprovalByByLeaveOfficeID($id)) . " (" . getHeadApprovalByByLeaveOfficeID($id) . ")";?> pada <?php echo getHeadApprovalDateByLeaveOfficeID($id);?>.

Catatan 	: <?php echo getHeadApprovalNoteByLeaveOfficeID($id);?>

----------------------------

Kelulusan ini adalah berdasarkan permohonan berikut :-

Sebab 		: <?php echo getReasonNameByID(getReasonByLeaveOfficeID($id));?>

Tarikh 		: <?php echo getDateLeaveByLeaveOfficeID($id);?>

Tempoh 		: <?php if(getReasonType(getReasonByLeaveOfficeID($id))=='0') echo getTimeLeaveByLeaveOfficeID($id) . " hingga " . getTimeBackByLeaveOfficeID($id); elseif(getReasonType(getReasonByLeaveOfficeID($id))=='1') echo getLeaveOfficeDayByLeaveOfficeID($id) . " " . getDayType(getLeaveOfficeDayTypeByLeaveOfficeID($id));?>

Catatan : <?php echo htmlspecialchars_decode(getLeaveNoteByLeaveOfficeID($id));?>


Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Kelulusan Permohonan Kebenaran Meninggalkan Pejabat Dalam Waktu Pejabat (AM 5 BAB G)";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				}
			}
		}
}
?>
<?php
// Am 5 Bab G
function emailNoticeLeaveOffice($to, $from, $subject, $type, $id)
{
	// Email Amaran 3 kali kepada user
	// to = array senarai StafID penerima
	// subject = tajuk
	// type = jenis
	// id = Leave Office ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	if($type == 1) 
	{	
	
	//email kepada admin / user untuk kelulusan permohonan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Tindakan dan perhatian tuan/puan diperlukan berkaitan Kebenaran Meninggalkan Pejabat Dalam Waktu Pejabat (AM 5 BAB G) telah diberi AMARAN sebanyak tiga (3) kali oleh Ketua Bahagian/Cawangan/Pusat/Unit untuk kakitangan berikut :-

<?php echo getFullNameByStafID(getUserIDByLeaveOfficeID(htmlspecialchars($id, ENT_QUOTES))) . " (" . getUserIDByLeaveOfficeID(htmlspecialchars($id, ENT_QUOTES)) . ")";?>

<?php echo getJobtitle(getUserIDByLeaveOfficeID(htmlspecialchars($id, ENT_QUOTES))); ?> (<?php echo getGred(getUserIDByLeaveOfficeID(htmlspecialchars($id, ENT_QUOTES)));?>)
<?php echo getFulldirectoryByUserID(getUserIDByLeaveOfficeID(htmlspecialchars($id, ENT_QUOTES)));?>


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageHR = ob_get_clean();
	
	//email kepada admin / user untuk kelulusan permohonan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Kakitangan dibawah selian tuan/puan berikut telah diberi AMARAN sebanyak tiga (3) kali bagi Kebenaran Meninggalkan Pejabat Dalam Waktu Pejabat (AM 5 BAB G) bagi tahun <?php date('Y');?> :-

<?php echo getFullNameByStafID(getUserIDByLeaveOfficeID(htmlspecialchars($id, ENT_QUOTES))) . " (" . getUserIDByLeaveOfficeID(htmlspecialchars($id, ENT_QUOTES)) . ")";?>

<?php echo getJobtitle(getUserIDByLeaveOfficeID(htmlspecialchars($id, ENT_QUOTES))); ?> (<?php echo getGred(getUserIDByLeaveOfficeID(htmlspecialchars($id, ENT_QUOTES)));?>)
<?php echo getFulldirectoryByUserID(getUserIDByLeaveOfficeID(htmlspecialchars($id, ENT_QUOTES)));?>


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageHead = ob_get_clean();
	
	//email kepada admin / user untuk kelulusan permohonan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Perhatian tuan/puan diperlukan bagi Kebenaran Meninggalkan Pejabat Dalam Waktu Pejabat (AM 5 BAB G) telah diberi AMARAN sebanyak tiga (3) kali. Makluman AMARAN ini juga telah dihantar ke <?php echo $GLOBALS['adname'];?> untuk tindakan dan perhatian selanjutnya.

Maklumat lanjut berkaitan AMARAN ini boleh dirujuk dalam <?php echo $GLOBALS['systitle_full'];?> melalui Modul Cuti > Rekod Kehadiran.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : (AMARAN) Kebenaran Meninggalkan Pejabat Dalam Waktu Pejabat (AM 5 BAB G)";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($key == 0 && $type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				}elseif($key == 1 && $type == 1 && getStatusTFByStafID($value))
				{ // email kpd Head
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageHead, $format);
				}elseif($key == 2 && $type == 1 && getStatusTFByStafID($value))
				{ // email kpd HR
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageHR, $format);
				}
			}
		}
}
?>
<?php
// Tempahan Kenderaan
function emailPermohonanKenderaan($to, $from, $subject, $type, $id)
{
	// Email kepada user
	// to = array senarai StafID penerima
	// subject = tajuk
	// type = jenis
	// id = Leave Office ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	if($type == 1) 
	{	
	
	//email kepada admin / user untuk kelulusan permohonan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Berikut merupakan tempahan kenderaan yang telah dibuat :-


Tujuan						: <?php echo htmlspecialchars_decode(getTitleByTransbookID($id));?>

Bil Kenderaan (cadangan)	: <?php echo getNoTransByTransbookID($id);?>


Catatan :
<?php echo htmlspecialchars_decode(getNoteByTransbookID($id));?>



Maklumat Perjalanan
_______________________________________

<?php
$query_ss = sprintf("SELECT * FROM tadbir.journey WHERE journey_status=1 AND transbook_id = %s ORDER BY journey_id ASC", GetSQLValueString($id, "int"));
$user_ss = mysql_query($query_ss);
$row_ss = mysql_fetch_assoc($user_ss);
$total_ss = mysql_num_rows($user_ss);
?>
<?php if($total_ss>0){?>
<?php $i=1; do { ?><?php echo $i;?>. <?php echo date('d / m / Y (D) h:i A', mktime($row_ss['journey_time_h'], $row_ss['journey_time_m'], 0, $row_ss['journey_date_m'], $row_ss['journey_date_d'], $row_ss['journey_date_y']));?>,  Dari : <?php echo htmlspecialchars_decode($row_ss['journey_from']); ?> -> Ke : <?php echo htmlspecialchars_decode($row_ss['journey_to']); ?>

<?php echo "";?>
<?php $i++; } while($row_ss = mysql_fetch_assoc($user_ss)); ?>
<?php } else { ?>
Tidak dinyatakan
<?php }; ?>
<?php mysql_free_result($user_ss);?>



Maklumat Penumpang
_______________________________________

<?php
$query_pss = sprintf("SELECT * FROM passenger WHERE passenger_status=1 AND transbook_id = %s ORDER BY passenger_id ASC", GetSQLValueString($id, "int"));
$user_pss = mysql_query($query_pss);
$row_pss = mysql_fetch_assoc($user_pss);
$total_pss = mysql_num_rows($user_pss);
?>
<?php if($total_pss>0){?>
<?php $i=1; do { ?>
<?php echo $i . ". " . getFullNameByStafID($row_pss['user_stafid']) . " (" . $row_pss['user_stafid'] . ")";?>, <?php echo getFulldirectoryByUserID($row_pss['user_stafid']);?>

<?php $i++; } while($row_pss = mysql_fetch_assoc($user_pss));?>
<?php } else { ?>
Tidak dinyatakan
<?php }; ?>
<?php mysql_free_result($user_pss); ?>

Jumlah penumpang 	: <?php echo $total_pss;?> orang



Maklumat lanjut berkaitan status tempahan kenderaan ini boleh dirujuk pada <?php echo $GLOBALS['systitle_full'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?>.

Sebarang perubahan atau pembatalan berkaitan tempahan kenderaan, sila berhubung terus dengan <?php echo getDirSubName(getDirIDByMenuID(9));?>.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	
	//email kepada admin / user untuk kelulusan permohonan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Berikut merupakan tempahan kenderaan yang telah dibuat :-


Tujuan						: <?php echo htmlspecialchars_decode(getTitleByTransbookID($id));?>

Bil Kenderaan (cadangan)	: <?php echo getNoTransByTransbookID($id);?>


Catatan :
<?php echo htmlspecialchars_decode(getNoteByTransbookID($id));?>



Maklumat Perjalanan
_______________________________________

<?php
$query_ss2 = sprintf("SELECT * FROM tadbir.journey WHERE journey_status=1 AND transbook_id = %s ORDER BY journey_id ASC", GetSQLValueString($id, "int"));
$user_ss2 = mysql_query($query_ss2);
$row_ss2 = mysql_fetch_assoc($user_ss2);
$total_ss2 = mysql_num_rows($user_ss2);
?>
<?php if($total_ss2>0){?>
<?php $i=1; do { ?>
<?php echo $i;?>. <?php echo date('d / m / Y (D) h:i A', mktime($row_ss2['journey_time_h'], $row_ss2['journey_time_m'], 0, $row_ss2['journey_date_m'], $row_ss2['journey_date_d'], $row_ss2['journey_date_y']));?>,  Dari : <?php echo htmlspecialchars_decode($row_ss2['journey_from']); ?> -> Ke : <?php echo htmlspecialchars_decode($row_ss2['journey_to']); ?>

<?php echo "";?>
<?php $i++; } while($row_ss2 = mysql_fetch_assoc($user_ss2)); ?>
<?php } else { ?>
Tidak dinyatakan
<?php }; ?>
<?php mysql_free_result($user_ss2);?>



Maklumat Penumpang
_______________________________________

<?php
$query_pss2 = sprintf("SELECT * FROM passenger WHERE passenger_status=1 AND transbook_id = %s ORDER BY passenger_id ASC", GetSQLValueString($id, "int"));
$user_pss2 = mysql_query($query_pss2);
$row_pss2 = mysql_fetch_assoc($user_pss2);
$total_pss2 = mysql_num_rows($user_pss2);
?>
<?php if($total_pss2>0){?>
<?php $i=1; do { ?>
<?php echo $i . ". " . getFullNameByStafID($row_pss2['user_stafid']) . " (" . $row_pss2['user_stafid'] . ")";?>, <?php echo getFulldirectoryByUserID($row_pss2['user_stafid']);?>

<?php $i++; } while($row_pss2 = mysql_fetch_assoc($user_pss2));?>
<?php } else { ?>
Tidak dinyatakan
<?php }; ?>
<?php mysql_free_result($user_pss2); ?>


Jumlah penumpang 	: <?php echo $total_pss2;?> orang



Maklumat lanjut berkaitan tempahan kenderaan ini, layari <?php echo $GLOBALS['url_main'];?>.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageTrans = ob_get_clean();
}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Tempahan Kenderaan";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($key == 0 && $type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				}elseif($key != 0 && $type == 1 && getStatusTFByStafID($value))
				{ // email kpd Head
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageTrans, $format);
				};
			};
		};
}
?>
<?php
// Kelulusan Tempahan Kenderaan
function emailKelulusanPermohonanKenderaan($to, $from, $subject, $type, $id)
{
	// Email kepada user
	// to = array senarai StafID penerima
	// subject = tajuk
	// type = jenis
	// id = Leave Office ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	if($type == 1) 
	{	
	
	//email kepada admin / user untuk kelulusan permohonan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Permohonan tempahan kenderaan <?php if(checkAdminAppByID($id)) echo "DILULUSKAN mengikut syarat dan peraturan yang ditetapkan."; else echo "TIDAK DILULUSKAN.";?> Kelulusan ini dibuat oleh <?php echo getFullNameByStafID(getAdminByByID($id)) . " (" . getAdminByByID($id) . ")";?> pada <?php echo getAdminDateByID($id);?>.

<?php if(getAdminNoteByID($id)!=NULL){?>
Catatan :

<?php echo htmlspecialchars_decode(getAdminNoteByID($id));?>
<?php }; ?>


---------------------------

Berikut tempahan kenderaan yang berkaitan :-

Tujuan						: <?php echo htmlspecialchars_decode(getTitleByTransbookID($id));?>

Bil Kenderaan (cadangan)	: <?php echo getNoTransByTransbookID($id);?>

Tarikh tempahan				: <?php echo getBookDateByTransbookID($id);?>


Catatan :
<?php echo htmlspecialchars_decode(getNoteByTransbookID($id));?>

---------------------------


Maklumat lanjut berkaitan kelulusan tempahan kenderaan, maklumat pemandu dan kenderaan yang terlibat boleh merujuk pada <?php echo $GLOBALS['systitle_full'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?>. <?php echo getDirSubName(getDirIDByMenuID(9));?> berhak untuk menukar atau membatalkan permohonan tanpa sebarang notis atau makluman.

Sebarang perubahan atau pembatalan berkaitan tempahan kenderaan, sila berhubung terus dengan <?php echo getDirSubName(getDirIDByMenuID(9));?>.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Kelulusan Tempahan Kenderaan";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				};
			};
		};
}
?>
<?php
// Email kepada pemandu Kenderaan
function emailPemanduKenderaan($to, $from, $subject, $type, $id)
{
	// Email kepada pemandu kenderaan
	// to = array senarai StafID penerima
	// subject = tajuk
	// type = jenis
	// id = Leave Office ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	if($type == 1) 
	{	
	
	//email kepada admin / user untuk kelulusan permohonan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Perkhidmatan tuan/puan diperlukan bagi tempahan kenderaan berikut :-


Tujuan	   : <?php echo htmlspecialchars_decode(getTitleByTransbookID($id));?>


<?php if(getNoteByTransbookID($id)!=NULL){?>
Catatan    :
<?php echo htmlspecialchars_decode(getNoteByTransbookID($id));?>
<?php }; ?>



Maklumat Perjalanan
_______________________________________

<?php
$query_ss = sprintf("SELECT * FROM tadbir.journey WHERE journey_status=1 AND transbook_id = %s ORDER BY journey_id ASC", GetSQLValueString($id, "int"));
$user_ss = mysql_query($query_ss);
$row_ss = mysql_fetch_assoc($user_ss);
$total_ss = mysql_num_rows($user_ss);
?>
<?php if($total_ss>0){?>
<?php $i=1; do { ?><?php echo $i;?>. <?php echo date('d / m / Y (D) h:i A', mktime($row_ss['journey_time_h'], $row_ss['journey_time_m'], 0, $row_ss['journey_date_m'], $row_ss['journey_date_d'], $row_ss['journey_date_y']));?>,  Dari : <?php echo htmlspecialchars_decode($row_ss['journey_from']); ?> -> Ke : <?php echo htmlspecialchars_decode($row_ss['journey_to']); ?>

<?php echo "";?>
<?php $i++; } while($row_ss = mysql_fetch_assoc($user_ss)); ?>
<?php } else { ?>
Tidak dinyatakan
<?php }; ?>
<?php mysql_free_result($user_ss);?>



Maklumat Penumpang
_______________________________________

<?php
$query_pss = sprintf("SELECT * FROM passenger WHERE passenger_status=1 AND transbook_id = %s ORDER BY passenger_id ASC", GetSQLValueString($id, "int"));
$user_pss = mysql_query($query_pss);
$row_pss = mysql_fetch_assoc($user_pss);
$total_pss = mysql_num_rows($user_pss);
?>
<?php if($total_pss>0){?>
<?php $i=1; do { ?>
<?php echo $i . ". " . getFullNameByStafID($row_pss['user_stafid']) . " (" . $row_pss['user_stafid'] . ")";?>, <?php echo getFulldirectoryByUserID($row_pss['user_stafid']);?>

<?php $i++; } while($row_pss = mysql_fetch_assoc($user_pss));?>
<?php } else { ?>
Tidak dinyatakan
<?php }; ?>
<?php mysql_free_result($user_pss); ?>


Jumlah penumpang 	: <?php echo $total_pss;?> orang


Maklumat lanjut berkaitan tempahan dan jenis kenderaan boleh merujuk pada <?php echo $GLOBALS['systitle_full'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?>. 



Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Pemandu Kenderaan";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				};
			};
		};
}
?>
<?php 
//Penambahan pengistiharan Harta
function emailPropertyAdd($to, $from, $subject, $type, $id)
{
	// Email penambahan harta
	//to = array senarai StafID penerima
	//subject = tajuk
	//type = jenis, cth 1 - kelulusan
	//id = user_borrow ID

	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';

	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT user_property.* FROM www.user_property WHERE userproperty_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) // 1 - Hantar laporan kepada HR
	{	
		//email kepada user untuk maklum berkaitan semakkan kata laluan
		ob_start(); //Turn on output buffering	
?>
Salam sejahtera;


Penambahan harta dalam Pengistiharan Harta adalah seperti berikut :-


Jenis Harta      : <?php echo getPropertyTypeByPropertyID($row_ss['userproperty_id']); ?><br />&nbsp; &bull; &nbsp; <?php echo getPropertyDetailByID($row_ss['userproperty_id']);?>

Pemilik 		 : <?php echo getOwnerByPropertyID($row_ss['userproperty_id']);?>

Tarikh Pemilikan : <?php echo getOwnedDateByPropertyID($row_ss['userproperty_id']); ?>

Nilai Perolehan  : RM <?php if(getAmountByPropertyID($row_ss['userproperty_id'])!='') echo number_format(getAmountByPropertyID($row_ss['userproperty_id']),2); else echo "-"; ?>


Untuk maklumat lanjut berkaitan penambahan harta ini, sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?>.

<?php echo $GLOBALS['adname'];?> berhak untuk membuat pindaan Pengistiharan Harta mengikut keperluan tanpa sebarang notis atau makluman.


Sekian, terima kasih.


Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageStaf = ob_get_clean();

	//email kepada HR untuk maklum berkaitan permohonana pinjaman baru
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;


Berikut maklumat penambahan harta baru untuk maklumat :-


Jenis Harta      : <?php echo getPropertyTypeByPropertyID($row_ss['userproperty_id']); ?><br />&nbsp; &bull; &nbsp; <?php echo getPropertyDetailByID($row_ss['userproperty_id']);?>

Pemilik 		 : <?php echo getOwnerByPropertyID($row_ss['userproperty_id']);?>

Tarikh Pemilikan : <?php echo getOwnedDateByPropertyID($row_ss['userproperty_id']); ?>

Nilai Perolehan  : RM <?php if(getAmountByPropertyID($row_ss['userproperty_id'])!='') echo number_format(getAmountByPropertyID($row_ss['userproperty_id']),2); else echo "-"; ?>


---------------------------------


Tarikh   : <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['userproperty_date_m'], $row_ss['userproperty_date_d'], $row_ss['userproperty_date_y']));?>

Oleh     : <?php echo getFullNameByStafID($row_ss['user_stafid']) . " (" . $row_ss['user_stafid'] . "), Ext : " . getExtNoByUserID($row_ss['user_stafid']);?>

Cawangan     : <?php echo getFulldirectoryByUserID($row_ss['user_stafid']);?>


Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut berkaitan aduan.


Sekian, terima kasih.

Makluman ini dihantar kepada <?php echo getDirSubName(getDirIDByMenuID(5));?> melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	
	}

	$smtp = emailset();

	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Penambahan Harta dalam Pengistiharan Harta";

	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";

	if($GLOBALS['sendemailfunc'] && $sendmail) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
	{
		foreach($to as $key => $value)
		{
			$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);

			if($key == '0' && $type == 1 && getStatusTFByStafID($value))
			{ 
				// email kpd Staf berkaitan notice
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageStaf, $format);

			} elseif($key == '1' && $type == 1 && getStatusTFByStafID($value)){ 

				// email kpd HR berkaitan notice
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);

			};
		};
	};
};
?>
<?php 
//Kemaskini pengistiharan Harta
function emailPropertyEdit($to, $from, $subject, $type, $id)
{
	// Email kemaskini harta
	//to = array senarai StafID penerima
	//subject = tajuk
	//type = jenis, cth 1 - kelulusan
	//id = user_borrow ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';

	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT user_property.* FROM www.user_property WHERE userproperty_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) // 1 - Hantar laporan kepada HR
	{
		//email kepada user untuk maklum berkaitan semakkan kata laluan
		
		ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Berikut adalah maklumat harta yang telah dibuat pengemaskinian :-


Jenis Harta      : <?php echo getPropertyTypeByPropertyID($row_ss['userproperty_id']); ?><br />&nbsp; &bull; &nbsp; <?php echo getPropertyDetailByID($row_ss['userproperty_id']);?>

Pemilik 		 : <?php echo getOwnerByPropertyID($row_ss['userproperty_id']);?>

Tarikh Pemilikan : <?php echo getOwnedDateByPropertyID($row_ss['userproperty_id']); ?>

Nilai Perolehan  : RM <?php if(getAmountByPropertyID($row_ss['userproperty_id'])!='') echo number_format(getAmountByPropertyID($row_ss['userproperty_id']),2); else echo "-"; ?>


Untuk maklumat lanjut berkaitan pengemaskinian harta ini, sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?>.

<?php echo $GLOBALS['adname'];?> berhak untuk membuat pindaan Pengistiharan Harta mengikut keperluan tanpa sebarang notis atau makluman.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageStaf = ob_get_clean();

	//email kepada HR untuk maklum berkaitan permohonana pinjaman baru
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;


Berikut maklumat pengemaskinian harta untuk makluman :-


Jenis Harta      : <?php echo getPropertyTypeByPropertyID($row_ss['userproperty_id']); ?><br />&nbsp; &bull; &nbsp; <?php echo getPropertyDetailByID($row_ss['userproperty_id']);?>

Pemilik 		 : <?php echo getOwnerByPropertyID($row_ss['userproperty_id']);?>

Tarikh Pemilikan : <?php echo getOwnedDateByPropertyID($row_ss['userproperty_id']); ?>

Nilai Perolehan  : RM <?php if(getAmountByPropertyID($row_ss['userproperty_id'])!='') echo number_format(getAmountByPropertyID($row_ss['userproperty_id']),2); else echo "-"; ?>


---------------------------------

Tarikh   : <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['userproperty_date_m'], $row_ss['userproperty_date_d'], $row_ss['userproperty_date_y']));?>

Oleh     : <?php echo getFullNameByStafID($row_ss['user_stafid']) . " (" . $row_ss['user_stafid'] . "), Ext : " . getExtNoByUserID($row_ss['user_stafid']);?>

Cawangan     : <?php echo getFulldirectoryByUserID($row_ss['user_stafid']);?>


Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut berkaitan aduan.


Sekian, terima kasih.

Makluman ini dihantar kepada <?php echo getDirSubName(getDirIDByMenuID(5));?> melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.

<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	}

	$smtp = emailset();

	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Kemaskini Harta dalam Pengistiharan Harta";

	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";

	if($GLOBALS['sendemailfunc'] && $sendmail) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
	{
		foreach($to as $key => $value)
		{
			$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
			
			if($key == '0' && $type == 1 && getStatusTFByStafID($value))
			{ 
				// email kpd Staf berkaitan notice
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageStaf, $format);

			} elseif($key == '1' && $type == 1 && getStatusTFByStafID($value)){ 

				// email kpd HR berkaitan notic
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
			};
		};
	};
};
?>
<?php 
//Pelupusan Harta
function emailPropertyDel($to, $from, $subject, $type, $id)
{
	// Email pelupusan harta
	//to = array senarai StafID penerima
	//subject = tajuk
	//type = jenis, cth 1 - kelulusan
	//id = user_borrow ID

	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
		
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT user_property.* FROM www.user_property WHERE userproperty_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) // 1 - Hantar laporan kepada HR
	{
		//email kepada user untuk maklum berkaitan semakkan kata laluan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Berikut adalah maklumat harta yang telah dibuat pengemaskinian :-


Jenis Harta      : <?php echo getPropertyTypeByPropertyID($row_ss['userproperty_id']); ?><br />&nbsp; &bull; &nbsp; <?php echo getPropertyDetailByID($row_ss['userproperty_id']);?>

Pemilik 		 : <?php echo getOwnerByPropertyID($row_ss['userproperty_id']);?>

Tarikh Pemilikan : <?php echo getOwnedDateByPropertyID($row_ss['userproperty_id']); ?>

Tarikh Pelupusan : <?php echo getDisposalDateByPropertyID($row_ss['userproperty_id']); ?>

Cara Pelupusan	 : <?php echo getDisposalWayByPropertyID($row_ss['userproperty_id']); ?>


Untuk maklumat lanjut berkaitan pelupusan harta ini, sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?>.

<?php echo $GLOBALS['adname'];?> berhak untuk membuat pindaan Pengistiharan Harta mengikut keperluan tanpa sebarang notis atau makluman.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageStaf = ob_get_clean();

	//email kepada HR untuk maklum berkaitan permohonana pinjaman baru
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Berikut maklumat pelupusan harta untuk makluman :-


Jenis Harta      : <?php echo getPropertyTypeByPropertyID($row_ss['userproperty_id']); ?><br />&nbsp; &bull; &nbsp; <?php echo getPropertyDetailByID($row_ss['userproperty_id']);?>

Pemilik 		 : <?php echo getOwnerByPropertyID($row_ss['userproperty_id']);?>

Tarikh Pemilikan : <?php echo getOwnedDateByPropertyID($row_ss['userproperty_id']); ?>

Tarikh Pelupusan : <?php echo getDisposalDateByPropertyID($row_ss['userproperty_id']); ?>


Cara Pelupusan	 : <?php echo getDisposalWayByPropertyID($row_ss['userproperty_id']); ?>

---------------------------------

Tarikh   : <?php echo getDisposalDateByPropertyID($row_ss['userproperty_id']); ?>

Oleh     : <?php echo getFullNameByStafID($row_ss['user_stafid']) . " (" . $row_ss['user_stafid'] . "), Ext : " . getExtNoByUserID($row_ss['user_stafid']);?>

Cawangan     : <?php echo getFulldirectoryByUserID($row_ss['user_stafid']);?>


Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut berkaitan aduan.


Sekian, terima kasih.

Makluman ini dihantar kepada <?php echo getDirSubName(getDirIDByMenuID(5));?> melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	}

	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Pelupusan Harta";

	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";

	if($GLOBALS['sendemailfunc'] && $sendmail) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
	{
		foreach($to as $key => $value)
		{
			$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);

			if($key == '0' && $type == 1 && getStatusTFByStafID($value))
			{ 
				// email kpd Staf berkaitan notice
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageStaf, $format);
				
			} elseif($key == '1' && $type == 1 && getStatusTFByStafID($value)){ 

				// email kpd HR berkaitan notice
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);

			};
		};
	};
};
?>
<?php
// Finance > JKB
function emailNewJKB($to, $from, $subject, $type, $id)
{
	// Email permohonan baru kepada Finance
	// to = array senarai StafID penerima
	// subject = tajuk
	// type = jenis
	// id = JKB ID

	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
		
	$random_hash = md5(date('r', time()));
	
	$query_jkb = "SELECT * FROM finance.jkb WHERE jkb_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' AND jkb_status = 1 ORDER BY jkb_id ASC";	
	$user_jkb = mysql_query($query_jkb);
	$row_jkb = mysql_fetch_assoc($user_jkb);
	$total_jkb = mysql_num_rows($user_jkb);

	$query_apply = "SELECT * FROM finance.apply WHERE apply_status = 1 AND jkb_id = '" . htmlspecialchars($id, ENT_QUOTES) . "' ORDER BY apply_id ASC";	
	$user_apply = mysql_query($query_apply);
	$row_apply = mysql_fetch_assoc($user_apply);
	$total_apply = mysql_num_rows($user_apply);

	if($type == 1) 
	{	
	//email kepada admin / user untuk maklum berkaitan permohonan JKB
	ob_start(); //Turn on output buffering	
?>

Salam sejahtera;

Berikut merupakan permohonan yang telah dihantar :

Kategori Permohonan 	: <?php echo getCategory(htmlspecialchars($id, ENT_QUOTES));?>
Cawangan				: <?php echo getFullDirectory(getDirIDByJkbID(htmlspecialchars($id, ENT_QUOTES))); ?>
No. Rujukan				: <?php echo getJkbRefByID(htmlspecialchars($id, ENT_QUOTES)); ?>
Aktiviti 				: <?php echo htmlspecialchars_decode(getJkbActivityByID(htmlspecialchars($id, ENT_QUOTES)));?>
Perihal 				: <?php echo getJkbDetailByID(htmlspecialchars($id, ENT_QUOTES));?>

--------------------------

Maklumat Permohonan 	:

<?php $i=1; do { ?>
<?php echo $i;?>
Deskripsi/Perbelanjaan Dipohon 	: <?php echo getApplyDescriptionByID(htmlspecialchars($id,ENT_QUOTES));?>
Kuantiti				: <?php echo getApplyQuantityByID(htmlspecialchars($id,ENT_QUOTES));?>
Pengiraan				: <?php echo getApplyCalculationByID(htmlspecialchars($id,ENT_QUOTES));?>
Jumlah (RM)				: <?php echo getApplyAmountByID(htmlspecialchars($id,ENT_QUOTES));?>

--------------------------
<?php $i++; } while($row_apply = mysql_fetch_assoc($user_apply)); ?>

Jumlah Keseluruhan Dipohon	(RM)	: <?php echo number_format(getActualTotalAmountByJkbID($id),2); ?>
Oleh 					: <?php echo getFullNameByStafID($row_jkb['user_stafid']);?>
<?php echo getDirSubName(getDirIDByMenuID(16));?> berhak untuk menukar atau membatal mana-mana maklumat dan permohonan mengikut keperluan tanpa sebarang notis atau makluman, dan tertakluk pada terma dan syarat. Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut.

Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	mysql_free_result($user_jkb);
	mysql_free_result($user_apply);
	};
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Permohonan JKB " . getCategory(htmlspecialchars($id, ENT_QUOTES));
		
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";

	if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
	{
		foreach($to AS $key => $value)
		{
			$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
			
			if($type == 1 && getStatusTFByStafID($value))
			{ // email kpd staf
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
			};
		};
	};
};
?>
<?php
// Admin > JKB > Kelulusan
function emailAppJKB($to, $from, $subject, $type, $id)
{
	// Email kelulusan permohonan kepada user
	// to = array senarai StafID penerima
	// subject = tajuk
	// type = jenis
	// id = jkb ID

	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';

	$random_hash = md5(date('r', time()));
	
	if($type == 1) 
	{	

	//email kepada admin / user untuk maklum berkaitan tempahan
	ob_start(); //Turn on output buffering	
?>

Salam sejahtera;

Berikut merupakan keputusan kelulusan permohonan JKB :-

Permohonan untuk Bantuan Pelaksanaan Program / Aktiviti ISN <?php echo getCategory(htmlspecialchars($id, ENT_QUOTES));?> disahkan oleh <?php if(getClassificationByID(htmlspecialchars($id, ENT_QUOTES)==0)) echo getJob2Name('2'); if(getClassificationByID(htmlspecialchars($id, ENT_QUOTES)==1)) echo "AHLI MESYUARAT"; if(getClassificationByID(htmlspecialchars($id, ENT_QUOTES)==2)) echo  getJob2Name('9');?> pada <?php echo getJKBAppDate(htmlspecialchars($id, ENT_QUOTES));?>.

<?php if(getJKBAppNote(htmlspecialchars($id, ENT_QUOTES))!=NULL){?>
Catatan :
<?php echo htmlspecialchars_decode(getJKBAppNote(htmlspecialchars($id, ENT_QUOTES)));?>
<?php }; ?>

-----------------------------

Keputusan kelulusan ini adalah merujuk pada maklumat permohonan berikut :-

Tarikh Permohonan 		: <?php echo getJKBDate(htmlspecialchars($id, ENT_QUOTES));?>
Kategori Permohonan 	: <?php echo getCategory(htmlspecialchars($id, ENT_QUOTES));?>
Cawangan				: <?php echo getFullDirectory(getDirIDByJkbID(htmlspecialchars($id, ENT_QUOTES))); ?>
No. Rujukan				: <?php echo getJkbRefByID(htmlspecialchars($id, ENT_QUOTES)); ?>
Aktiviti 				: <?php echo htmlspecialchars_decode(getJkbActivityByID(htmlspecialchars($id, ENT_QUOTES)));?>
Perihal 				: <?php echo getJkbDetailByID(htmlspecialchars($id, ENT_QUOTES));?>
Oleh 					: <?php echo getFulldirectory(getDirIDByUser($row_user['user_stafid']));?>

Maklumat kelulusan ini dikemaskini oleh <?php echo getFullNameByStafID(getAppUpdateByJKBApp(htmlspecialchars($id, ENT_QUOTES))) . " (" . getAppUpdateByJKBApp(htmlspecialchars($id, ENT_QUOTES)) . ")";?> pada <?php echo getAppUpdateDateJKBApp(htmlspecialchars($id, ENT_QUOTES));?>. 

<?php echo getDirSubName(getDirIDByMenuID('16'));?> berhak untuk menukar atau membatal mana-mana maklumat dan permohonan mengikut keperluan tanpa sebarang notis atau makluman, dan tertakluk pada terma dan syarat. Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut.

Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	}

	$smtp = emailset();

	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Kelulusan Permohonan JKB " . getCategory(htmlspecialchars($id, ENT_QUOTES));

	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
	if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
	{
		foreach($to AS $key => $value)
		{
			$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
			
			if($type == 1 && getStatusTFByStafID($value))
			{ // email kpd staf
				$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
			};
		};
	};
};
?>
<?php 

//PINJAMAN SAINS SUKAN
function emailKelulusanPinjamanSainsSukan($to, $from=0, $subject=0, $type=0, $id=0)
{
	// Email keputusan pinjaman peralatan ICT
	//to = array senarai StafID penerima
	//subject = tajuk
	//type = jenis, cth 1 - kelulusan
	//id = user_borrow ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT user_borrow.* FROM sports.user_borrow WHERE userborrow_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) // 1 - Hantar laporan kepada HR
	{	
	
	//email kepada user untuk maklum berkaitan semakkan kata laluan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Berikut merupakan status permohonan pinjaman peralatan :-


Permohonan <?php if($row_ss['ict_status']==1) echo "DILULUSKAN dengan syarat dan peraturan yang ditetapkan."; else echo "TIDAK DILULUSKAN atas sebab tertentu."; ?> 

<?php if($row_ss['ict_note']!=NULL) echo "CATATAN :";?>

<?php if($row_ss['ict_note']!=NULL) echo $row_ss['ict_note'];?>


Berikut maklumat pinjaman peralatan :-

Tujuan : <?php echo htmlspecialchars_decode($row_ss['userborrow_title']);?>

Lokasi : <?php echo htmlspecialchars_decode($row_ss['userborrow_location']);?>

Tarikh : <?php echo date('d / m / Y (D)', mktime(0, 0, 0, $row_ss['userborrow_date_m'], $row_ss['userborrow_date_d'], $row_ss['userborrow_date_y']));?>

Masa : <?php echo getTimeByUserBorrowID($row_ss['userborrow_id']);?>


<?php echo getDirSubName(getDirIDByMenuID(20));?> berhak membatal atau menukar maklumat pinjaman tanpa sebarang notis atau makluman. Pemohon bertanggungjawab sepenuhnya terhadap item dan kuantiti yang dipinjam sentiasa dalam keadaan baik dan berfungsi sepertimana keadaan sewaktu penerimaan.


Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut berkaitan permohonan pinjaman peralatan.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Status pinjaman peralatan";
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				}
			}
		}
}
?>
<?php 
function emailPinjamanBaruSportsSains($to, $from, $subject, $type, $id)
{
	// Email  pinjaman peralatan ICT
	//to = array senarai StafID penerima dan ICT
	//subject = tajuk
	//type = jenis, cth 1 - Makluman Pinjaman baru
	//id = user_borrow ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT user_borrow.* FROM sports.user_borrow WHERE userborrow_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) // 1 - Hantar laporan kepada HR
	{	
	
	//email kepada user untuk maklum berkaitan pemohonan pinjaman
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Berikut maklumat permohonan pinjaman peralatan <?php echo getDirSubName(getDirIDByMenuID('20'));?> yang telah dipohon :-


Tujuan : <?php echo htmlspecialchars_decode(getBorrowTitleByUserSportsBorrowID(htmlspecialchars($id, ENT_QUOTES)));?>

Lokasi : <?php echo htmlspecialchars_decode(getBorrowLocationByUserSportsBorrowID(htmlspecialchars($id, ENT_QUOTES)));?>

Tarikh : <?php echo getDateByUserBorrowID(htmlspecialchars($id, ENT_QUOTES));?>

Tempoh : <?php echo getDurationByUserSportsBorrowID($row_ss['userborrow_id']);?>

Masa   : <?php echo getTimeByUserBorrowID($row_ss['userborrow_id']);?>


Item yang dipinjam :

<?php 
$item = getSubCategoryItemByUserBorrowID($row_ss['userborrow_id']);

foreach($item AS $key => $value)
{
echo $key+1 . ". " . getBorrowItemSubCategoryByID($value) . "; 
";
}
?>


Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut berkaitan permohonan dan status pinjaman peralatan <?php echo getDirSubName(getDirIDByMenuID(20));?>. 


Untuk pindaan, pembatalan atau penukaran maklumat pinjaman, sila berhubung terus dengan <?php echo getDirSubName(getDirIDByMenuID(20));?>. Pindaan, pembatalan atau penukaran maklumat pinjaman hanya boleh dibuat sebelum <?php echo getDirSubName(getDirIDByMenuID(20));?> membuat pengesahan pinjaman sahaja.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	
	//email kepada ICT untuk maklum berkaitan permohonana pinjaman baru
	//ob_start(); //Turn on output buffering	

	//copy current buffer contents into $message variable and delete current output buffer
	//$messageICT = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Permohonan Pinjaman Peralatan " . getDirSubName(getDirIDByMenuID(20));
	
	    $format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($key == 0 && $type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf dan ICT
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				} 
				//else if($type == 1 && getStatusTFByStafID($value))
				//{ // email kpd staf dan ICT
					//$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageICT, $format);
				//}
			}
		}
}
?>


<?php 
function emailAduanBaruMBJ($to, $from, $subject, $type, $id)
{
	// Email aduan
	//to = array senarai StafID penerima dan ICT
	//subject = tajuk
	//type = jenis, cth 1 - Makluman Aduan
	//id = user_report ID
	/*$to = "shazleen@isn.gov.my";*/
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT user_report.* FROM mbj.user_report WHERE userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) 
	{	
	
	//email kepada user untuk maklum berkaitan aduan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Berikut maklumat aduan yang telah dibuat :-

Kategori : <?php echo htmlspecialchars_decode(getCategoryNameByID($row_ss['category_id']));?>

Aduan    : <?php echo htmlspecialchars_decode(getReportNoteByID($row_ss['userreport_id']));?>

Masa     : <?php echo $row_ss['userreport_time'];?>

Tarikh   : <?php echo getReportDateByID($row_ss['userreport_id']); ?>

Oleh     : <?php echo getFullNameByStafID(getReportByByID(htmlspecialchars($id, ENT_QUOTES))) . " (" . getReportByByID(htmlspecialchars($id, ENT_QUOTES)) . ")";?>, Ext : <?php echo getExtNoByUserID(getReportByByID(htmlspecialchars($id, ENT_QUOTES)));?>

Unit 	 : <?php echo getFulldirectoryByUserID(getReportByByID(htmlspecialchars($id, ENT_QUOTES)));?>


Setiap pemohon hanya dibenarkan untuk membuat 5 kali aduan dalam tempoh tarikh tersebut dan setiap isu yang dihantar hanya boleh dibuat sekali dalam tempoh tarikh tersebut. 

Sehubungan itu, pemohon diminta untuk memilih isu yang betul berkaitan permasalahan atau aduan yang ingin dibuat. <?php echo getDirSubName(getDirIDByMenuID(22));?> berhak untuk membatalkan atau menukar maklumat aduan tanpa sebarang notis atau makluman. Setiap aduan yang dibuat akan dinilai untuk tujuan penambahbaik perkhidmatan. 

Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut berkaitan status aduan. Sekiranya tiada sebarang maklum balas berkaitan aduan dalam  <?php echo $GLOBALS['systitle_short'];?>, sila hubungi <?php echo getDirSubName(getDirIDByMenuID(22));?> (Jawatankuasa MBJ) di talian ext 4871 dan sila nyatakan Nama dan Tarikh aduan ketika berhubung untuk memudahkan proses semakkan.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	
	//email kepada ICT untuk maklum berkaitan permohonana pinjaman baru
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Berikut maklumat aduan baru untuk tindakan selanjutnya :-

Kategori : <?php echo htmlspecialchars_decode(getCategoryNameByID($row_ss['category_id']));?>

Aduan    : <?php echo htmlspecialchars_decode(getReportNoteByID($row_ss['userreport_id']));?>

Tarikh   : <?php echo getReportDateByID(htmlspecialchars($id, ENT_QUOTES));?>

Oleh 	 : <?php echo getFullNameByStafID(getReportByByID(htmlspecialchars($id, ENT_QUOTES))) . " (" . getReportByByID(htmlspecialchars($id, ENT_QUOTES)) . ")";?>, Ext : <?php echo getExtNoByUserID(getReportByByID(htmlspecialchars($id, ENT_QUOTES)));?>

Unit    : <?php echo getFulldirectoryByUserID(getReportByByID(htmlspecialchars($id, ENT_QUOTES)));?>



Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut berkaitan aduan.


Sekian, terima kasih.

Makluman ini dihantar kepada <?php echo getDirSubName(getDirIDByMenuID(22));?> melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageICT = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Aduan MBJ " . getDirSubName(getDirIDByMenuID(22));
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($key == 0 && $type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf dan ICT
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				} else if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf dan ICT
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $messageICT, $format);
				}
			}
		}
}
?>

<?php
function emailFeedbackMBJAction($to, $from, $subject, $type, $id)
{
	// Email maklum balas untuk tindakan StafID
	//to = array senarai StafID penerima dan ICT
	//subject = tajuk
	//type = jenis, cth 1 - Makluman Aduan
	//id = user_report ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT user_report.* FROM mbj.user_report WHERE userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) 
	{	
	
	//email kepada user untuk maklum berkaitan aduan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Tindakan/perhatian daripada tuan/puan bagi perkara berikut diperlukan :-

Oleh  : <?php echo getFullNameByStafID(getFeedbackActionUserIDByUserReportID($row_ss['userreport_id']));?>

Catatan :

<?php echo htmlspecialchars_decode(getFeedbackActionNoteByUserReportID($row_ss['userreport_id']));?>


------------


Merujuk pada aduan berikut :-


Kategori : <?php echo getCategoryNameByID($row_userreport['userreport_id']); ?>

Aduan : <?php echo getReportNoteByID($row_userreport['userreport_id']);?>


Tarikh : <?php echo getReportDateByID($row_userreport['userreport_id'],1);?> 

Masa : <?php echo $row_ss['userreport_time'];?>


Oleh : <?php echo getFullNameByStafID($row_ss['user_stafid']) . " (" . $row_ss['user_stafid'] . "), Ext : " . getExtNoByUserID($row_ss['user_stafid']);?>

Unit : <?php echo getFulldirectoryByUserID($row_ss['user_stafid']);?>



Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : (Tindakan) Maklum balas aduan " . getDirSubName(getDirIDByMenuID(22));
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				}
			}
		}
}
?>


<?php
function emailFeedbackMBJ($to, $from, $subject, $type, $id)
{
	// Email aduan
	//to = array senarai StafID penerima dan ICT
	//subject = tajuk
	//type = jenis, cth 1 - Makluman Aduan
	//id = user_report ID
	
	if($from==0)
		$from = $GLOBALS['systitle_short'] . ' <spsm@nsc.gov.my>';
	
	$random_hash = md5(date('r', time()));

	$query_ss = "SELECT user_report.* FROM mbj.user_report WHERE userreport_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";	
	$user_ss = mysql_query($query_ss);
	$row_ss = mysql_fetch_assoc($user_ss);

	if($type == 1) 
	{	
	
	//email kepada user untuk maklum berkaitan aduan
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Merujuk kepada aduan, maklum balas aduan MBJ yang telah dibuat:-

Kategori : <?php echo htmlspecialchars_decode(getCategoryNameByID($row_ss['category_id']));?>

Aduan    : <?php echo htmlspecialchars_decode(getReportNoteByID($row_ss['userreport_id']));?>

Masa     : <?php echo $row_ss['userreport_time'];?>

Tarikh   : <?php echo getReportDateByID($row_ss['userreport_id']); ?>

Oleh     : <?php echo getFullNameByStafID(getReportByByID(htmlspecialchars($id, ENT_QUOTES))) . " (" . getReportByByID(htmlspecialchars($id, ENT_QUOTES)) . ")";?>, Ext : <?php echo getExtNoByUserID(getReportByByID(htmlspecialchars($id, ENT_QUOTES)));?>

Unit 	 : <?php echo getFulldirectoryByUserID(getReportByByID(htmlspecialchars($id, ENT_QUOTES)));?>


--------------------------
MAKLUMBALAS DARI PIHAK MBJ

Catatan  :<?php echo htmlspecialchars_decode(getLastFeedbackNoteByUserReportID(htmlspecialchars($id, ENT_QUOTES)));?>


Oleh <?php echo getFullNameByStafID(getLastFeedbackUserIDByUserReportID(htmlspecialchars($id, ENT_QUOTES))) . " (" . getLastFeedbackUserIDByUserReportID(htmlspecialchars($id, ENT_QUOTES)) . ")";?> pada <?php echo getLastFeedbackDateByUserReportID(htmlspecialchars($id, ENT_QUOTES));?>


--------------------------


Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk pengesahan berkaitan status aduan. Tuan/Puan tidak dibenarkan untuk membuat aduan baru sekiranya aduan sedia ada ini tidak dibuat pengesahan terlebih dahulu.


Sekian, terima kasih.

Makluman ini dihantar melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	
	//email kepada ICT untuk maklum berkaitan permohonana pinjaman baru
	ob_start(); //Turn on output buffering	
?>
Salam sejahtera;

Berikut maklum balas aduan MBJ yang telah dibuat :-

Kategori : <?php echo htmlspecialchars_decode(getCategoryNameByID($row_ss['category_id']));?>

Aduan    : <?php echo htmlspecialchars_decode(getReportNoteByID($row_ss['userreport_id']));?>

Masa     : <?php echo $row_ss['userreport_time'];?>

Tarikh   : <?php echo getReportDateByID($row_ss['userreport_id']); ?>

Oleh     : <?php echo getFullNameByStafID(getReportByByID(htmlspecialchars($id, ENT_QUOTES))) . " (" . getReportByByID(htmlspecialchars($id, ENT_QUOTES)) . ")";?>, Ext : <?php echo getExtNoByUserID(getReportByByID(htmlspecialchars($id, ENT_QUOTES)));?>

Unit 	 : <?php echo getFulldirectoryByUserID(getReportByByID(htmlspecialchars($id, ENT_QUOTES)));?>


--------------------------
MAKLUMBALAS DARI PIHAK MBJ

Catatan   :<?php echo htmlspecialchars_decode(getLastFeedbackNoteByUserReportID(htmlspecialchars($id, ENT_QUOTES)));?>


Oleh  <?php echo getFullNameByStafID(getLastFeedbackUserIDByUserReportID(htmlspecialchars($id, ENT_QUOTES))) . " (" . getLastFeedbackUserIDByUserReportID(htmlspecialchars($id, ENT_QUOTES)) . ")";?> pada <?php echo getLastFeedbackDateByUserReportID(htmlspecialchars($id, ENT_QUOTES));?>


--------------------------


Sila layari <?php echo $GLOBALS['systitle_short'];?> melalui URL berikut <?php echo $GLOBALS['url_main'];?> untuk maklumat lanjut berkaitan maklum balas aduan.


Sekian, terima kasih.

Makluman ini dihantar kepada <?php echo getDirSubName(getDirIDByMenuID(22));?> melalui <?php echo $GLOBALS['systitle_full'];?> sebagai rujukan.
<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$messageICT = ob_get_clean();
	}
	
	$smtp = emailset();
	
	if($subject == 0 && $type == 1)
 		$subject = $GLOBALS['systitle_short'] . " : Maklum balas aduan MBJ " . getDirSubName(getDirIDByMenuID(22));
	
	$format = "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
	
		if($GLOBALS['sendemailfunc']) // semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php

		{
			foreach($to AS $key => $value)
			{
				$headers = array ('From' => $from, 'To' => getEmailISNByUserID($value), 'Subject' => $subject);
				
				if($key == 0 && $type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				} else if($key != 0 && $type == 1 && getStatusTFByStafID($value))
				{ // email kpd staf dan ICT
					$mail = $smtp->send(getEmailISNByUserID($value), $headers, $message, $format);
				}
			}
		}
}
?>
