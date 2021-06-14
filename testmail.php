<?php include("Mail.php");?>
<?php

	$smtpinfo["host"] = "webmail.nsc.gov.my";
	$smtpinfo["port"] = "465";
	$smtpinfo["auth"] = true;
	$smtpinfo["username"] = "nurul.aiza@nsc.gov.my";
	$smtpinfo["password"] = "herinaghazali";
 	$smtp = @Mail::factory('smtp', $smtpinfo);

	$to = "mohdsyaiful@nsc.gov.my";  //norazurah@isn.gov.my

	$from = "SPSM <nurul.aiza@nsc.gov.my>";
	
	
	
	$message = "Selamat kembali IMAS!";

 	$subject = "SPSM : Selamat kembali";
	
	$headers = array ('From' => $from, 'To' => $to, 'Subject' => $subject);
	
	$mail = $smtp->send($to, $headers, $message);
	
//	if (PEAR::isError($mail)) {
//	   echo("<p>" . $mail->getMessage() . "</p>");
//	  } else {
//	   echo("<p>Message successfully sent!</p>");
//	  }

?>