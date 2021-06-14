<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ekad.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ekadfunc.php');?>
<?php include('../sb/email.php');?>
<?php 
	
	$insertGoTo = $url_main . "ekad/index.php?cat=" . getKadCatByCardID($_POST['kad']) . "&kad=" . htmlspecialchars($_POST['kad'], ENT_QUOTES);
	
	if(isset($_POST['np']) && isset($_POST['ep']))
	{
		if(!empty($_POST['ep']) && count($_POST['ep'])<=5)
		{
			$groupmail = array("all@isn.gov.my", "all2@isn.gov.my", "allstaff@isn.gov.my", "spw@isn.gov.my", "allsat@isn.gov.my", "headbhgn@isn.gov.my", "director@isn.gov.my", "headcaw@isn.gov.my", "ppisn@isn.gov.my", "pegtetap@isn.gov.my");
			
			foreach($_POST['ep'] AS $ep_key => $ep_value)
			{
				$message = getCardDesign($_POST['kad'], $_POST['np'][$ep_key], $_POST['ucapan'], $row_user['user_stafid']);	
				
				if(!in_array($_POST['ep'][$ep_key], $groupmail))
				{
					if($GLOBALS['sendemailfunc'] && filter_var($_POST['ep'][$ep_key], FILTER_VALIDATE_EMAIL)) 
					{
						// semak sama ada func email dibenarkan berfungsi atau tidak file:hrmsdb.php
						//server SMTP tak mengizinkan host lain untuk menjadi from header. pakai isn header.
						
						$headers["From"] = '"' . getFullNameByStafID($row_user['user_stafid']) . '" <' . getEmailISNByUserID($row_user['user_stafid']) . '>'; 
						$headers["To"] = htmlspecialchars($_POST['ep'][$ep_key], ENT_QUOTES);
						$headers["MIME-Version"] = "1.0";
						$headers["Content-Type"] = "text/html; charset=ISO-8859-1";
						$headers["Subject"] = "ISN eKad khas untuk anda"; 
						
						if(getStatusTFByStafID($row_user['user_stafid']))
						{
							$smtp = emailset();
							$mail = $smtp->send(htmlspecialchars($_POST['ep'][$ep_key], ENT_QUOTES), $headers, $message);
							
							if (PEAR::isError($mail))
							{
								$insertGoTo .= "&ekad=2";
							} else {
								$insertGoTo .= "&ekad=1";
							};
							
						} else {
							$insertGoTo .= "&ekad=2";
						};
						
					} else {
						$insertGoTo .= "&msg=error";
					};
					
				} else {
					$insertGoTo .= "&ekad=2";
				};
				
			}; // end foreach
		
		} else {
			$insertGoTo .= "&ekad=3";
		};
	
	} else {
		$insertGoTo .= "&msg=error";
	};
	
	header(sprintf("Location: %s", $insertGoTo));

?>